
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
 * @filename:	user.service.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the controller for members Module
 * 				which select the action or state for model depends
 * 				upon the user input given to the controller.
 * 
 *
*/

class UserController{
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
	function UserController() {
	
		if(!mtutor_is_loggedin()) {
			header('location: '.APPLICATION_URL);
		}
	
		global $request, $tsResponse, $library;
		//Collecting the action parameter from request.
		$action = strtolower ( trim ( $request ['action'] ) );
		
		switch ($action) {

			case "initiate" :
				include(ROOT_DIR.'gateway/task/header.php');
				include(ROOT_DIR.'gateway/task/user.php'); 				
				include(ROOT_DIR.'gateway/task/footer.php');
				break;

			
			case "insert" :
					$userModel	= new UserRegistration();
				if(!empty($request['name'])&&!empty($request['email'])&&!empty($request['dob'])&&!empty($request['age'])&&
				!empty($request['gender'])&&!empty($request['course'])){
					$name	= $request['name'];
					$email	= $request['email'];
					$dob	= $request['dob'];
					$age	= $request['age'];
					$gender	= $request['gender'];
					$course	= $request['course'];
					$address	= $request['address'];

				}
					
					$result		= $userModel->insert_user($name,$email,$dob,$age,$gender,$course,$address);
					if($result)
						echo 'inserted';
					else
						echo 'Not Inserted';
					break;


			case "get_all_id" :
				$userModel	= new UserRegistration();		
				$result	= $userModel->get_users();
				if($result){
					echo json_encode(array('result' => $result));		
				}
				else{
					echo json_encode(array('status'=> false));
				}
				break;


			case "edit_user":
				$userModel	= new UserRegistration();
					$id	= $request['id'];
					$name	= $request['name'];
					$email	= $request['email'];
					$dob	= $request['dob'];
					$age	= $request['age'];
					$gender	= $request['gender'];
					$course	= $request['course'];
					$address	= $request['address'];
				
				$result	= $userModel->edit_user($name,$email,$dob,$age,$gender,$course,$address,$id);
				if($result)
					echo 'updated';
				else
					echo 'Not updated';
				break;


			case "delete_user":
					$userModel	= new UserRegistration();
					$id	= $request['id'];
					
				
					$result	= $userModel->delete_user($id);
					if($result){
					echo 'deleted';
					}
					else{
					echo 'Not deleted';
					}
					break;


			case "get_id" :
				$userModel	= new UserRegistration();
				$id	= $request['id'];
				
				$result	= $userModel->get_user($id);
				if($result){
					echo json_encode(array( 'result' => $result));		
				}
				else{
					echo json_encode(array('return_val'=> 'id', 'status'=> false));
				}
				break;
				
			case "logout" :
				session_destroy();
				header('location: '.APPLICATION_URL);
				break;

			default : 
				break;
		}
	}
}
?>