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
 * @filename:	home.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the model for home module
 * 				and contains all the business logic for home module.
 *
 *
 */
class UserRegistration {

		public function get_users() {
		global $db,$request;

		$query = "SELECT * FROM user";
	
			$result = $db['master']->getResults($query);
		
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
		}


	public function insert_user($name,$email,$dob,$age,$gender,$course,$address)
	{
		global $db , $result;
		$query="INSERT INTO user 
		(`name`,
		`email`,
		`dob`,
		`age`,
		`gender`,
		`course`,
		`address`) 
		VALUES('".$name."',
		'".$email."',
		'".$dob."',
		'".$age."',
		'".$gender."',
		'".$course."',
		'".$address."') ";
		$result=$db['master']->query($query);
		if($result)
		{
			return "inserted";
		}
		else{
			return "not_inserted";
		}
		
	}


	public function edit_user($name,$email,$dob,$age,$gender,$course,$address,$id)
		{
			global $db,$result;
			
			$query="UPDATE user
			SET 
			`name`='".$name."',
			`email`='".$email."',
			`dob`='".$dob."',
			`age`='".$age."',
			`gender`='".$gender."',
			`course`='".$course."',
			`address`='".$address."'
			WHERE `id`='".$id."'";
			
			$result=$db['master']->query($query);

		
			if($result)
			{
				return "updated";
			}
			else{
				return "not_updated";
			}
		} 



		public function delete_user($id)
		{
			global $db,$result;
			
			$query="Delete from  user WHERE `id`='".$id."'";
			
			$result=$db['master']->query($query);

		
			if($result)
			{
				return "deleted";
			}
			else{
				return "not deleted";
			}
		} 



	public function get_user($id = '') {
		global $db,$request;

		$query = "SELECT * FROM user";
		if($id != '') {
			$query .= " WHERE id = '" . $id . "'";
			$result = $db['master']->getOneRow($query);
		
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
		}

	
}
}
?>










































