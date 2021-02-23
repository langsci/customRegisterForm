{**
 * templates/customUserRegistrationForm.tpl
 *
 * Copyright (c) 2020 Language Science Press
 * Developed by Ronald Steffen
 * Distributed under the MIT license. For full terms see the file docs/License.
 *
 * Custom fieldset for user registration form.
 *
 * @brief Display the basic registration form fields
 *
 * @uses $locale string Locale key to use in the affiliate field
 * @uses $givenName string First name input entry if available
 * @uses $familyName string Last name input entry if available
 * @uses $countries array List of country options
 * @uses $country string The selected country if available
 * @uses $email string Email input entry if available
 * @uses $username string Username input entry if available
 *}

<link rel="stylesheet" href="{$baseUrl}/plugins/generic/customRegisterForm/css/registerForm.css" type="text/css" />

<fieldset class="custom">
	<legend>
		{translate key="plugins.generic.registerPage.label.register"}
	</legend>
	<div class="fields">
		<div id="register_form_row">
			<div class="inline">
				<label>
					<input type="text" name="inputAcademicTitle" id="inputAcademicTitle" value="{$inputAcademicTitle|escape}" maxlength="255">
					<span class="label">
						{translate key="plugins.generic.registerPage.label.academicTitle"}<sup>1</sup>
						<span class="pkp_screen_reader">
							{translate key="common.required"}
						</span>
					</span>		
				</label>
			</div>
			<div class="inline">
				<label>
					<input type="text" name="givenName" id="givenName" value="{$givenName|escape}" maxlength="255" required aria-required="true">
					<span class="label">
						{translate key="user.givenName"}
						<span class="required" aria-hidden="true">*</span>
						<span class="pkp_screen_reader">
							{translate key="common.required"}
						</span>
					</span>
				</label>
			</div>
			<div class="inline">
				<label>
					<input type="text" name="familyName" id="familyName" value="{$familyName|escape}" maxlength="255">
					<span class="label">
						{translate key="user.familyName"}
					</span>
				</label>
			</div>
		</div>
		<div id="register_form_row">
			<div class="inline">
				<label>
					<input type="text" name="username" id="username" value="{$username|escape}" maxlength="32" required="" aria-required="true">
					<span class="label">
						Username<sup>2</sup>
						<span class="required" aria-hidden="true">*</span>
						<span class="pkp_screen_reader">
							Required
						</span>
					</span>
				</label>
			</div>
			<div class="inline">
				<label>
				<input type="password" name="password" id="password" password="true" maxlength="32" required="" aria-required="true">
					<span class="label">
						Password
						<span class="required" aria-hidden="true">*</span>
						<span class="pkp_screen_reader">
							Required
						</span>
					</span>
				</label>
			</div>
			<div class="inline">
				<label>
				<input type="password" name="password2" id="password2" password="true" maxlength="32" required="" aria-required="true">
					<span class="label">
						Repeat password
						<span class="required" aria-hidden="true">*</span>
						<span class="pkp_screen_reader">
							Required
						</span>
					</span>	
				</label>
			</div>
		</div>
		<div id="register_form_row">
			<div class="inline">
				<label>
					<input type="text" name="affiliation" id="affiliation" value="{$affiliation|escape}" required="" aria-required="true">
					<span class="label">
						Affiliation
						<span class="required" aria-hidden="true">*</span>
						<span class="pkp_screen_reader">
							Required
						</span>
					</span>
				</label>
			</div>
			<div class="inline">
				<label>
					<input type="email" name="email" id="email" value="{$email|escape}" maxlength="90" required="" aria-required="true">
					<span class="label">
						Email
						<span class="required" aria-hidden="true">*</span>
						<span class="pkp_screen_reader">
							Required
						</span>
					</span>
				</label>
			</div>
			<div class="inline">
				<label>
				<input type="text" name="url" id="url" value="{$url|escape}" maxlength="255">
					<span class="label">
						{translate key="plugins.generic.registerPage.label.url"}
						<span class="pkp_screen_reader">
							{translate key="common.required"}
						</span>
					</span>		
				</label>
			</div>
			<div class="footnotes">
				<div class="footnote"><span class="required">*</span>  Denotes req field.</div>
				<div class="footnote">1  Please use your degree, e.g. <span class="italic">Dr</span>, rather than your job title, e.g <span class="italic">lecturer</span>.</div>
				<div class="footnote">2 The username must contain only lowercase letters, numbers, and hyphens/underscores.</div>
			</div>
		</div>
	</div>
	
</fieldset>
<fieldset class="custom">
	<legend>
		{translate key="plugins.generic.registerPage.label.supporter"}
	</legend>
	<div class="fields">
		<div id="supporter_and_subscriber">
			<ul class="checkbox_and_radiobutton">
				<li>
					<input id="Supporter" name="Supporter" type="checkbox">
					<label>Public supporter (my name will be listed on the public <a href="../supporters">supporter page</a>).</label>
				</li>
				<li>
					<input id="Author" name="Author" type="checkbox">
					<label>Author (<a href="../forAuthors">more information</a>)</label>
				</li>
				<li>
					<input id="VolumeEditor" name="VolumeEditor" type="checkbox">
					<label>Volume Editor (<a href="../forAuthors">more information</a>)</label>
				</li>
				<li>
					<input id="Proofreader" name="Proofreader" type="checkbox">
					<label>Proofreader and subscribe to the LangSci proofreader mailing list.</label>
				</li>
			</ul>
		</div>
	</div>
</fieldset>	
<fieldset class="custom">
	<legend>
		{translate key="plugins.generic.registerPage.label.subscriber"}
	</legend>
	<div class="fields">
		<div id="supporter_and_subscriber">
			<ul class="checkbox_and_radiobutton">
				<li>
					<input id="NewsletterSubscriber" name="NewsletterSubscriber" type="checkbox">
					<label>LangSci newsletter</label>
				</li>
			</ul>
		</div>
	</div>
</fieldset>
<fieldset class="custom">
	<legend>
		{translate key="plugins.generic.registerPage.label.captcha.heading"}
	</legend>
	<div class="fields">
		<div id="captchSection">
			<label>
				<p>{translate key="plugins.generic.registerPage.label.captcha.info"}</p>
				<input type="text" name="inputCaptcha" id="inputCaptcha" maxlength="40" required="" aria-required="true" value={$inputCaptcha|escape}>
				<input type="text" name="questionSelected" id="questionSelected" maxlength="40" value={$questionSelected} hidden=true>
				<span>
					<label class="sub_label">{$captchaQuestion}<span class="req">*</span></label>
				</span>
			</label>
		</div>
	</div>
</fieldset>
