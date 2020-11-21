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
 * @filename:	member.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the model for test module
 * 				and contains all the business logic for test module.
 *
 *
 */


class Mbasicsmodel {

	private $_insertValidataionRules;
	/**
	 * Description:
	 * constructor for test class will intialize the validition rules for insert operation.
	 *
	 * Parameters:
	 * null		: null
	 * Return Value:
	 * null		: null
	 */
	

public function get_users() {
		global $db,$request;

		$query = "SELECT * FROM test";
	
			$result = $db['master']->getResults($query);
		
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
		}


	public function insert_user($name,$email,$password)
	{
		global $db , $result;
		$query="INSERT INTO test 
		(`userName`,
		`email`,
		`password`) 
		VALUES('".$name."',
		'".$email."',
		'".$password."') ";

		$result=$db['master']->query($query);
		if($result)
		{
			return "inserted";
		}
		else{
			return "not_inserted";
		}
		
	}


	public function edit_user($name,$email,$opassword,$npassword)
		{
			global $db,$result;
			
			$query="UPDATE test
			SET 
			`userName`='".$name."',
			`email`='".$email."',
			`password`='".$npassword."'
			WHERE `email`='".$email."' AND  `password`='".$opassword."'";
			
			$result=$db['master']->query($query);

			if($result)
			{
				return "updated";
			}
			else{
				return "not_updated";
			}
		} 

		public function delete_user($email)
		{
			global $db,$result;
			
			$query="Delete from  test WHERE `email`='".$email."'";
			
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

		$query = "SELECT * FROM test";
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
