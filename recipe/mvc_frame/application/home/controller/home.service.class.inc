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
 * @filename:	home.service.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the controller for members Module
 * 				which select the action or state for model depends
 * 				upon the user input given to the controller.
 * 
 *
 */

class HomeController{
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
	function HomeController() {
	
		if(!mtutor_is_loggedin()) {
			header('location: '.APPLICATION_URL);
		}
	
		global $request, $tsResponse, $library;
		//Collecting the action parameter from request.
		$action = strtolower ( trim ( $request ['action'] ) );
		switch ($action) {
			case "initiate" :
				include(ROOT_DIR.'gateway/header.php');
				include(ROOT_DIR.'gateway/dashboard.php');
				include(ROOT_DIR.'gateway/footer.php');
				break;
			case "get_college" :
				$homeModel	= new HomeModel();
				$univ_id	= $request['university_id'];
				$result		= $homeModel->get_college('', $univ_id);
				if($result)
					echo json_encode(array('return_val'=> 'college', 'result' => $result));
				else
					echo json_encode(array('return_val'=> 'college', 'status'=> false));
				break;
			case "get_subject" :
				$homeModel	= new HomeModel();
				$univ_id	= (isset($request['university_id']) && !empty($request['university_id'])) ? $request['university_id'] : '';
				$sem_id		= (isset($request['semester_id']) && !empty($request['semester_id'])) ? $request['semester_id'] : '';
				$branch_id	= (isset($request['branch_id']) && !empty($request['branch_id'])) ? $request['branch_id'] : '';
				$result		= $homeModel->get_subject('', $univ_id, $sem_id, $branch_id);
				if($result) {
					$result = (array)$result;
					$return = array_map(function($res) {
						return array(
							'id'	=> $res['subject_id'],
							'name'	=> $res['subject_name']
						); 
					}, $result);
					echo json_encode(array('return_val' => 'subject', 'result' => $return));
				} else {
					echo json_encode(array('return_val'=> 'subject', 'status'=> false));
				}
				break;
			case "get_branch" :
				$homeModel	= new HomeModel();
				$college_id	= $request['college_id'];
				$result		= $homeModel->get_branch();
				if($result) {
					$result = (array)$result;
					$return = array_map(function($res) {
						return array(
							'id'	=> $res['branch_id'],
							'name'	=> $res['branch_name']
						); 
					}, $result);
					echo json_encode(array('return_val'=> 'branch', 'result' => $return));
				} else {
					echo json_encode(array('return_val'=> 'branch', 'status'=> false));
				}
				break;
			case "get_topic" :
				$homeModel	= new HomeModel();
				$subject_id	= $request['subject_id'];
				$result		= $homeModel->get_topic('', $subject_id);
				if($result) {
					$result = (array)$result;
					$return = array_map(function($res) {
						return array(
							'id'	=> $res['topic_id'],
							'name'	=> $res['topic_name']
						); 
					}, $result);
					echo json_encode(array('return_val'=> 'topic', 'result' => $return));
				} else {
					echo json_encode(array('return_val'=> 'topic', 'status'=> false));
				}
				break;
			case "get_subject_sme" :
				$homeModel	= new HomeModel();
				$branch		= $request['branch'];
				$subjects	= $homeModel->get_subject('', '', '', $branch);
				if($subjects) {
					$subjects	= (array)$subjects;
					$return		= array_map(function($res) {
						return array(
							'id'	=> $res['subject_id'],
							'name'	=> $res['subject_name']
						); 
					}, $subjects);
					echo json_encode(array('return_val'=> 'subject', 'result' => $return));
				} else {
					echo json_encode(array('return_val'=> 'subject', 'status'=> false));
				}
				break;
			case "get_sme" :
				$homeModel	= new HomeModel();
				$branch_id	= $request['branch_id'];
				$smes	= $homeModel->get_sme('', $branch_id);
				if($smes) {
					$smes		= (array)$smes;
					$return		= array_map(function($res) {
						return array(
							'id'	=> $res['id'],
							'name'	=> $res['first_name'] . ' ' . $res['last_name']
						); 
					}, $smes);
					echo json_encode(array('return_val'=> 'sme', 'result' => $return));
				} else {
					echo json_encode(array('return_val'=> 'sme', 'status'=> false));
				}
				break;
			case "get_student_id" :
				$homeModel		= new HomeModel();
				$univ_id		= $request['university_id'];
				$college_id		= $request['college_id'];
				$branch_id		= $request['branch_id'];
				$semester_id	= $request['semester_id'];
				$students		= $homeModel->get_users('', $univ_id, $college_id, $branch_id, $semester_id);
				if($students) {
					$students		= (array)$students;
					$return		= array_map(function($res) {
						return array(
								'id'	=> $res['id'],
								'name'	=> $res['first_name'] . ' ' . $res['last_name']
						);
					}, $students);
					echo json_encode(array('return_val'=> 'student_id', 'result' => $return));
				} else {
					echo json_encode(array('return_val'=> 'student_id', 'status'=> false));
				}
				break;
			default : 
				break;
		}
	}
}
?>