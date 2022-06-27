<?php

/**
 * @file plugins/generic/customRegisterForm/customRegisterFormPlugin.inc.php
 *
 *
 * Copyright (c) 2020 Language Science Press
 * Developed by Ronald Steffen
 * Distributed under the MIT license. For full terms see the file docs/License.
 *
 * @ingroup plugins_generic_customRegisterForm
 * @brief Plugin to customize content of the register form
 * @class customRegisterFormPlugin
 */

class customRegisterFormPlugin extends GenericPlugin {
    
    private $_registrationForm;
    private $_questionSelected;
    private $_captchaValid;

    private $_captchaQuestions = array("What is the color of an orange book?",
                                        "Which word is spelled exactly like the word <i>bank</i>?",
                                        "What is the concatenation of <i>conca</i> and <i>tenation</i>?",
                                        "What is the next word in this sentence?<br <i>A rose is a rose is a...</i>",
                                        "What is Marie Curie's last name?");

    private $_captchaSolutions = array("orange",
                                        "bank",
                                        "concatenation",
                                        "rose",
                                        "Curie");
    
    /**
     * @copydoc Plugin::register()
     */
    function register($category, $path, $mainContextId = null) {
        $success = parent::register($category, $path, $mainContextId);
        if ($success && $this->getEnabled($mainContextId)) {
            HookRegistry::register('registrationform::Constructor', array($this, 'callbackRegistrationFormConstruct'));
            HookRegistry::register('registrationform::readuservars', array($this, 'callbackRegistrationFormReadUserVars'));
            HookRegistry::register('registrationform::execute', array($this, 'callbackRegistrationFormExecute'));
            HookRegistry::register('registrationform::display', array($this, 'callbackRegistrationFormDisplay'));
            
            // Add new fields to user DAO
            HookRegistry::register('userdao::getAdditionalFieldNames', array($this, 'addFieldName'));
        }
        return $success;
    }

    function callbackRegistrationFormConstruct($hookName, $args) {
        if ($hookName == 'registrationform::Constructor') {          
            $this->_registrationForm = &$args[0];
            $form = $this->_registrationForm;
            $this->_registrationForm->_template = $this->getTemplateResource('customUserRegistrationForm.tpl');

            $captchaSolutions = $this->_captchaSolutions;
            $this->_registrationForm->addCheck(new FormValidatorCustom($form, 'captchaQuestion', 'required', 'plugins.generic.registerPage.captchaNotVaslid',
             function() use ($form, $captchaSolutions) {
                 if ($captchaSolutions[$form->getData('questionSelected')] == $form->getData('inputCaptcha')) {
                    $this->_captchaValid = true;
                 } else {
                    $this->_captchaValid = false;
                    $this->_questionSelected = $form->getData('questionSelected');
                 }
                return $this->_captchaValid;
            }, array(), false));
            // This validation required the user to type in "http://", we don't want this and add it in execute ourselves
            //$this->_registrationForm->addCheck(new FormValidatorUrl($form, 'url', 'optional', 'validator.url'));
		
        }
        return false;
    }
    
    function callbackRegistrationFormDisplay($hookName, $args) {
        if ($hookName == 'registrationform::display') {
            $request = Application::get()->getRequest();
            $templateMgr = TemplateManager::getManager($request);
            
            if (!isset($this->_captchaValid)) {
                $this->_questionSelected = rand(0,count($this->_captchaQuestions)-1);
            }
            $templateMgr->assign(array(
                'captchaQuestion' => $this->_captchaQuestions[$this->_questionSelected],
                'questionSelected' => $this->_questionSelected
            ));
        }
        return false;
    }

    function callbackRegistrationFormReadUserVars($hookName, $args) {
        if ($hookName == 'registrationform::readuservars') {
            // make field country optional
            foreach ($this->_registrationForm->_checks as $value) {
                if ($value->_field == 'country') {
                    $value->_type = 'optional';
                }
            }
            $args[1] = array_merge($args[1],['inputAcademicTitle','url','inputCaptcha','questionSelected','Supporter','Author','VolumeEditor','Proofreader','NewsletterSubscriber']);
        }
        return false;
    }
    
    function callbackRegistrationFormExecute($hookName, $args) {
        if ($hookName == 'registrationform::execute') {       
            $user = $this->_registrationForm->user;           
            $fields = ['inputAcademicTitle','url'];
            foreach ($fields as $field) {
                if ($field == 'url') {
                    $url = $this->_registrationForm->getData($field);
		    if (!empty($url)) {
                       // add protocol if not present 
                       if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                          $url = "http://" . $url;
                       }
                       $user->setData($field,$url);
		    }
                } else {
                    $user->setData($field, $this->_registrationForm->getData($field));
                }
            }
        }
        return false;
    }
    
    function addFieldName($hookName, $params) {
        if ($hookName == 'userdao::getAdditionalFieldNames') {    

            // We add the user to the selected groups here and not in the execute method because the 
            // RegistrationForm::execute hook is called before the user ID is created
            // This should only be done in case we are called by RegistrationForm, i.e. $this->_registrationForm was set in the constructor
            if (isset($this->_registrationForm)) {
                $userId = $params[0]->getInsertId();
                $locale = AppLocale::getLocale();

                $groups = ['Supporter','Author','VolumeEditor','Proofreader','NewsletterSubscriber'];

                $this->import('customRegisterFormDAO');
                $customRegisterFormDAO = new customRegisterFormDAO();

                foreach ($groups as $group) {
                    if ($this->_registrationForm->getData($group) == "on") {
                        // TODO @RS this is a bad workaround, groups should be handled by ID instead
                        if ($group == 'VolumeEditor') {
                            $group = 'Volume editor';
                        } elseif ($group == 'NewsletterSubscriber') {
                            $group = 'Newsletter subscriber';
                        }
                        $roles = $customRegisterFormDAO->getUserGroupIdByName($group, $locale);
                        if (isset($roles)) {
                            $userGroupDao = DAORegistry::getDAO('UserGroupDAO');
                            $userGroupDao->assignUserToGroup($userId, $roles);
                        }
                    }
                }
            }

            //add the additional user profile fields
            $params[1] = array_merge($params[1],['inputAcademicTitle','inputUrl']);
        }
        return false;
    }
    
    function getDisplayName() {
        return __('plugins.generic.customRegisterForm.displayName');
    }
    
    function getDescription() {
        return __('plugins.generic.customRegisterForm.description');
    }
}


