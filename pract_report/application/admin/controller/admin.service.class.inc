<?php
/*
 * @company: 	Symbiotic Infotech Pvt. Ltd.
 * @copyright: 	© Symbiotic Infotech Pvt. Ltd. 2011
 *				All rights reserved.Any redistribution or reproduction of part
 * 				or all of the contents in any form is prohibited. You may not,
 * 				except with express written permission, distribute or
 * 				commercially exploit or personally use the content.
 * 				Nor may you transmit it or store it in any other media or
 * 				other form of electronic or physical retrieval system.
 *
 * @filename:	admin.service.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the controller for members Module
 * 				which select the action or state for model depends
 * 				upon the user input given to the controller.
 * 
 *
 */

session_start();
class AdminController{
	/**
	 * Description:
	 * This is controller for user Module,it will decide the action  to be given to 
	 * the model class depends upon the action parameter given to the
	 * controller.
	 * 
	 * Parameters:
	 *	null		: null
	 * Return Value: 
	 *	null		: null
	*/
	function AdminController(){
		global $request, $tsResponse, $library;
		//Collecting the action parameter from request.
		
		$action = strtolower ( trim ( $request ['action'] ) );
		switch ($action) {
			case "initiate" :
				if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
					header('location: '.APPLICATION_URL.'gateway/action?application=home&action=initiate');
				} else {
					header('location: '.APPLICATION_URL);
				}
				break;
			case "login_form" :
				if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
					header('location: '.APPLICATION_URL.'gateway/action?application=home&action=initiate');
				} else {
					include(ROOT_DIR.'gateway/login.php');
				}
				break;
			case "login" :
				if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
					header('location: '.APPLICATION_URL.'gateway/action?application=admin&action=initiate');
				} else {
					$adminModelObj = new AdminModel();
					$admin			= $adminModelObj->validateUser();
					if ($admin != false) {
						$_SESSION['userid']		= $admin['id'];
						$_SESSION['usertype']	= $admin['type'];
						$_SESSION['username']	= $admin['first_name'].' '.$admin['last_name'];
						$record					= $adminModelObj->addUserActivity($admin['id']);
						header('location: '.APPLICATION_URL.'gateway/action?application=admin&action=initiate');
					} else {
						header('location: '.APPLICATION_URL.'gateway/action?application=admin&action=login_form&display=error');
					}
				}
				break;
			case "logout" :
				session_destroy();
				header('location: '.APPLICATION_URL);
				break;
		}
	}
	
}
?>