<?php

/**
 * @file plugins/generic/customRegisterForm/customRegisterFormDAO.inc.php
 *
 * Copyright (c) 2020 Language Science Press
 * Developed by Ronald Steffen
 * Distributed under the MIT license. For full terms see the file docs/License.
 *
 * @class customRegisterFormDAO
 *
 * Class for customRegisterForm database access.
 */

class customRegisterFormDAO extends DAO {

    function __construct() {
		parent::__construct();
	}

	function getUserGroupIdByName($user_group_name, $locale) {
		$result = $this->retrieve(
			"SELECT user_group_id FROM user_group_settings WHERE
				locale='".$locale."' AND
				setting_name = 'name' AND
				setting_value = '" . $user_group_name . "'"
		);

		if ($result->RecordCount() == 0) {
			$result->Close();
			return null;
		} else {
			$row = $result->getRowAssoc(false);
			$result->Close();
			return $this->convertFromDB($row['user_group_id'],null);
		}	
	}
}

?>
