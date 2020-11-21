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
 * @filename:	Delte.service.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the controller for members Module
 * 				which select the action or state for model depends
 * 				upon the user input given to the controller.
 * 
 *
 */

session_start();
class MbasicsController{
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
	
	function MbasicsController(){
		global $request, $tsResponse, $library;
		//Collecting the action parameter from request.
		
		$action = strtolower ( trim ( $request ['action'] ) );
		switch ($action) {

			case "initiate" :
			
				include(ROOT_DIR.'gateway/task/mbasics.php'); 				
				
				break;

			
			case "insert" :
				$userModel	= new Mbasicsmodel();
				if(!empty($request['name'])&&!empty($request['email'])&&!empty($request['password'])){
					$name	= $request['name'];
					$email	= $request['email'];
					$password	= md5($request['password']);
				}
					
					$result	= $userModel->insert_user($name,$email,$password);
				
					if($result)
						echo 'inserted';
					else
						echo 'Not Inserted';
					break;


			case "get_all_id" :
				$userModel	= new Mbasicsmodel();		
				$result	= $userModel->get_users();
				if($result){
					echo json_encode(array('result' => $result));		
				}
				else{
					echo json_encode(array('status'=> false));
				}
				break;


			case "edit_user":
				$userModel	= new Mbasicsmodel();
				if(!empty($request['name'])&&!empty($request['email'])&&!empty($request['o_password'])&&!empty($request['n_password'])){
					$id=$request['id'];
					$name	= $request['name'];
					$email	= $request['email'];
					$opassword	= md5($request['o_password']);
					$npassword	= md5($request['n_password']);
				}
				
				$result	= $userModel->edit_user($name,$email,$opassword,$npassword);
				if($result)
					echo 'updated';
				else
					echo 'Not updated';
				break;


			case "delete_user":
					$userModel	= new Mbasicsmodel();
					if(!empty($request['email'])){
					$email	= $request['email'];
					}
					$result	= $userModel->delete_user($email);
					if($result){
					echo 'deleted';
					}
					else{
					echo 'Not deleted';
					}
				break;


			case "get_id" :
				$userModel	= new Mbasicsmodel();
				$id	= $request['id'];
				
				$result	= $userModel->get_user($id);
				if($result){
					echo json_encode(array( 'result' => $result));		
				}
				else{
					echo json_encode(array('return_val'=> 'id', 'status'=> false));
				}
				break;
				
			

			default : 
				break;
		}
	}
	
}
?>