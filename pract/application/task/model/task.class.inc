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
  

class TaskModel {

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
	public function TaskModel() {
		$this->_insertValidataionRules = array (
			'username'	=> array (
				'type'		=> 'string',
				'required'	=> true,
				'striptags'	=> true,
				'length'	=> 255
			)
		);
	}

	public function validateUser() {
		global $db,$request;

		$query = "SELECT * FROM test WHERE userName='".$request['username']."' AND password='".MD5($request['password'])."'";
		$result = $db['master']->getOneRow($query);
		if ($result && count($result) > 0)
			return $result;
		else
			return false;
	}
	public function addUserActivity($id = '') {
		global $db,$request;
		$current_date_time = date('Y-m-d H:i:s');
		$query    = "insert into mt_activity (user_id,user_in) values ('".$id."','".$current_date_time."')";
		return $db['master']->query($query);
	}
	public function get_user($user_id = '', $type = '') {
		global $db,$request;

		$query = "SELECT * FROM test";
		if($user_id != '') {
			$query .= " WHERE id = '" . $user_id . "'";
			$result = $db['master']->getOneRow($query);
		} else if($type != '') {
			$query .= " WHERE type = '" . $type . "'";
			if($type == 'moderator')
				$result = $db['master']->getOneRow($query);
			else
				$result = $db['master']->getResults($query);
		} else {
			$result = $db['master']->getResults($query);
		}
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

}
?>
