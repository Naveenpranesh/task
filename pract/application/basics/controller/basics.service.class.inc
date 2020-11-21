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
 * @filename:	basics.service.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the controller for members Module
 * 				which select the action or state for model depends
 * 				upon the user input given to the controller.
 * 
 *
 */

class BasicsController{
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
	function BasicsController() {
	
	
		global $request, $tsResponse, $library;
		//Collecting the action parameter from request.
		$action = strtolower ( trim ( $request ['action'] ) );
		switch ($action) {
			case "initiate" :
				
				include(ROOT_DIR.'gateway/task/basics.php');
				
				break;

			case "get_results" :
				$basicsModel	= new BasicsModel();

				$string	= $request['string'];
				$needtoreplace	= $request['needtoreplace'];
				$replace_word	= $request['replace_word'];
				$string_position	= $request['string_position'];
								
				$result	= $basicsModel->get_results($string,$needtoreplace,$replace_word,$string_position);
				
				if($result){
					
					echo json_encode(array( 'result' => $result));		
				}
				else{
					
					echo json_encode(array('status'=> false));
				
				}
				break;
			
			default : 
				break;
		}
	}
}
?>