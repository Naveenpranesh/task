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
class HomeModel {
	public function get_university($id = '', $state_id = '') {
		global $db,$request;
		$query = "SELECT * FROM mtsoc_universities";
		if(!empty($id))
			$query .= " WHERE id = '$id'";
		if(!empty($state_id))
			$query .= " WHERE state_id = '$state_id'";
		$position	= strpos($query, 'WHERE');
		if ($position !== false) {
			$query = substr($query, 0, $position + 1) . str_replace('WHERE', 'AND', substr($query, $position + 1));
		}
		$query .= " ORDER BY name";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

	public function get_college($id = '', $univ_id = '') {
		global $db,$request;
		$query = "SELECT * FROM mtsoc_colleges";
		if(!empty($id))
			$query .= " WHERE id = '$id'";
		if(!empty($univ_id))
			$query .= " WHERE university_id = '$univ_id'";
		$position	= strpos($query, 'WHERE');
		if ($position !== false) {
			$query = substr($query, 0, $position + 1) . str_replace('WHERE', 'AND', substr($query, $position + 1));
		}
		$query .= " ORDER BY name";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

	public function get_branch($id = '', $college_id = '', $group = false) {
		global $db,$request;
		$query = "SELECT * FROM mtsoc_branch";
		if(!empty($id))
			$query .= " WHERE branch_id = '$id'";
		if(!empty($college_id))
			$query .= " WHERE college_id = '$college_id'";
		$position	= strpos($query, 'WHERE');
		if ($position !== false) {
			$query = substr($query, 0, $position + 1) . str_replace('WHERE', 'AND', substr($query, $position + 1));
		}
		if(!empty($group) && $group != false)
			$query .= " GROUP BY branch_name";
		$query .= " ORDER BY branch_name";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

	public function get_subject($id = '', $univ_id = '', $sem_id = '', $branch_id = '') {
		global $db,$request;
		$query = "SELECT * FROM mtsoc_subjects";
		if(!empty($id))
			$query .= " WHERE subject_id = '$id'";
		if(!empty($univ_id))
			$query .= " WHERE university_id = '$univ_id'";
		if(!empty($sem_id))
			$query .= " WHERE semester_id = '$sem_id'";
		if(!empty($branch_id))
			$query .= " WHERE branch_id = '$branch_id'";
		$position	= strpos($query, 'WHERE');
		if ($position !== false) {
			$query = substr($query, 0, $position + 1) . str_replace('WHERE', 'AND', substr($query, $position + 1));
		}
		$query .= " GROUP BY subject_name ORDER BY subject_name";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

	public function get_branch_ids($branch) {
		global $db,$request;
		$query = "SELECT branch_id FROM mtsoc_branch";
		if(!empty($branch))
			$query .= " WHERE branch_name = '$branch'";
		$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return $result;
		else
			return false;
	}

	public function get_subject_sme($branch_ids) {
		global $db,$request;
		$branch_id	= '';
		foreach($branch_ids as $branch) {
			$branch_id	.= $branch['branch_id'].',';
		}
		$query = "SELECT * FROM mtsoc_subjects WHERE branch_id IN (".rtrim($branch_id, ',').") GROUP BY subject_name";
		$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

	public function get_sme($id	= '', $branch_id = '') {
		global $db,$request;
		$query = "SELECT * FROM mtsoc_auth_users WHERE type = 'SME'";
		if(!empty($id))
			$query .= " WHERE id = '$id'";
		if(!empty($branch_id))
			$query .= " WHERE branch_id = '$branch_id'";
		$position	= strpos($query, 'WHERE');
		if ($position !== false) {
			$query = substr($query, 0, $position + 1) . str_replace('WHERE', 'AND', substr($query, $position + 1));
		}
		$query .= " ORDER BY first_name";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

	public function get_topic($id = '', $subject_id = '') {
		global $db,$request;
		$query = "SELECT * FROM mtsoc_topic";
		if(!empty($id))
			$query .= " WHERE topic_id = '$id'";
		if(!empty($subject_id))
			$query .= " WHERE subject_id = '$subject_id'";
		$position	= strpos($query, 'WHERE');
		if ($position !== false) {
			$query = substr($query, 0, $position + 1) . str_replace('WHERE', 'AND', substr($query, $position + 1));
		}
		$query .= " ORDER BY topic_name";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}

	public function get_chatroom($id = '') {
		global $db,$request;
		$query = "SELECT * FROM cometchat_chatrooms";
		if(!empty($id))
			$query .= " WHERE id = '$id'";
		$query .= " ORDER BY id ASC";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return $result;
		else
			return false;
	}

	public function get_users($id = '', $university = '', $college = '', $branch = '', $semester = '') {
		global $db,$request;
		$query = "SELECT * FROM mtsoc_users";
		if(!empty($id))
			$query .= " WHERE id = '$id'";
		if(!empty($university))
			$query .= " WHERE university_id = '$university'";
		if(!empty($college))
			$query .= " WHERE college_id = '$college'";
		if(!empty($branch))
			$query .= " WHERE branch_id = '$branch'";
		if(!empty($semester))
			$query .= " WHERE semester_id = '$semester'";
		$position	= strpos($query, 'WHERE');
		if ($position !== false) {
			$query = substr($query, 0, $position + 1) . str_replace('WHERE', 'AND', substr($query, $position + 1));
		}
		$query .= " ORDER BY first_name";
		if(!empty($id))
			$result = $db['master']->getOneRow($query);
		else
			$result = $db['master']->getResults($query);
		if ($result && count($result) > 0)
			return (object)$result;
		else
			return false;
	}
}
?>
