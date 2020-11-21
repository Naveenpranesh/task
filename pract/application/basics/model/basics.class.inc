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
 * @filedesc:   This file contains the model for user module
 * 				and contains all the business logic for user module.
 *
 *
 */


class BasicsModel {

	private $_insertValidataionRules;

	/**
	 * Description:
	 * constructor for user class will intialize the validition rules for insert operation.
	 *
	 * Parameters:
	 * null		: null
	 * Return Value:
	 * null		: null
	 */

	public function BasicsModel() {
		$this->_insertValidataionRules = array (
			'username'	=> array (
				'type'		=> 'string',
				'required'	=> true,
				'striptags'	=> true,
				'length'	=> 255
			)
		);
	}


	public function get_results($input,$needtoreplace,$replace_word,$string_position) {
		global $db,$request,$result;

	
		$len = strlen($input);
		$shuffled = str_shuffle($input);
		$wordcount = str_word_count($input);
		$replaced = str_replace($needtoreplace, $replace_word, $input);
		$position = strrpos($replaced, $string_position);
		$lower = strtolower($input);
		$upper = strtoupper($input);

		$first_letter = $input[0];
		$last_letter = $input[$len - 1];

		$reversed = strrev($input);

		$f_upper = ucwords($input);

		$f_lower = strtolower($input[0]) . substr($input, 1, $len - 1);
		$md5 = md5($input);
		$whitespaceremoved = trim($input);
		$stringcompare = strcmp($input, $input);

		$result = new \stdClass();
		$result ->length = $len;		
		$result ->shuffled = $shuffled;
		$result ->wordcount=$wordcount;
		$result ->replaced =$replaced;
		$result ->position =$position;
		$result ->lower =$lower;
		$result ->upper=$upper;
		$result ->first_letter=$first_letter;
		$result ->last_letter=$last_letter;
		$result ->reversed=$reversed;
		$result ->f_upper = $f_upper;
		$result ->f_lower = $f_lower;
		$result ->whitespaceremoved=$whitespaceremoved;
		$result ->stringcompare=$stringcompare;
		$result ->md5=$md5;
		
		return (object)$result;
	
		

	
}

public function basics_user($id,$dob,$name,$email,$address,$age,$gender,$course)
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

public function get_All($id  = '') {
			global $db,$request;

		$query = "SELECT * FROM user";
		
			$query .= " WHERE id = '" . $id . "'";
			$result = $db['master']->getOneRow($query);
		
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	

}
}
?>
