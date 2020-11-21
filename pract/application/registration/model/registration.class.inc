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
 * @filename:	registration.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the model for registration report
 * 				and contains all the business logic for registration report.
 *
 *
 */
class RegistrationModel {

	private $_insertValidataionRules;

	public function getRegStudent ($beanObj) {
		global $db, $request, $log;
		return json_encode(array('date_from' => $beanObj->getEnd_date()));
	}

	public function getRegistration_chart( $args, $type = 'default' ){
		global $db, $request, $log;
		$university_id	= isset( $args['university'] ) ? $args['university'] : '';
		$college_id		= isset( $args['college'] ) ? $args['college'] : '';
		$gender			= isset( $args['gender'] ) ? $args['gender'] : '';
		$access			= isset( $args['access'] ) ? $args['access'] : '';
		$start_date		= isset( $args['date_from'] ) ? $args['date_from'] : '';
		$end_date		= isset( $args['date_to'] ) ? $args['date_to'] : '';
		$selectQuery = "select DATE(registered_date) AS date, COUNT(*) AS cnt  ";
		$where = " WHERE DATE(registered_date) BETWEEN '$start_date' AND '$end_date' ";
		if( $type === 'default' ) {
			$group_by =  " GROUP BY DATE( registered_date) ";
		}
		if( $type === 'weekly' ){
			$selectQuery = "SELECT WEEK( registered_date ) AS week, YEAR( registered_date ) AS year,COUNT(*) AS cnt, DATE_ADD( registered_date, INTERVAL( 1-DAYOFWEEK( registered_date ) ) DAY ) AS week_start, DATE_ADD( registered_date, INTERVAL( 7-DAYOFWEEK( registered_date ) ) DAY ) AS week_end ";
			$group_by    = " GROUP BY YEAR( registered_date ), WEEK( registered_date ) ";
		}
		if( $type === 'monthly' ){
			$selectQuery = "SELECT YEAR( registered_date ) AS year, MONTH( registered_date ) AS month,COUNT(*) AS cnt ";
			$group_by    = " GROUP BY MONTH( registered_date ) ";
		}
		if( $gender !== 'all' && $gender !== ''){
			$where .= " AND gender = '$gender' ";
		}
		if( $university_id !== ''){
			$where .=  " AND university_id IN ($university_id) ";
		}
		if( $college_id !== 'all' && $college_id !== ''){
			$where .= " AND college_id IN ($college_id) ";
		}
		if( $access != '' && $access != 'All' ){
			$where .= " AND access = '".$access."' ";
		}
		$SELECT_QUERY	= "$selectQuery from mtsoc_users $where $group_by";
		$results		= $db ['master']->getResults( $SELECT_QUERY );
		return $results;
	}

	public function get_registration_report($args) {
		global $db, $request, $log;
		$university_id	= isset( $args['university'] ) ? $args['university'] : '';
		$college_id		= isset( $args['college'] ) ? $args['college'] : '';
		$gender			= isset( $args['gender'] ) ? $args['gender'] : '';
		$access			= isset( $args['access'] ) ? $args['access'] : '';
		$start_date		= isset( $args['date_from'] ) ? $args['date_from'] : '';
		$end_date		= isset( $args['date_to'] ) ? $args['date_to'] : '';
		$selectQuery = "select  concat(first_name, ' ', last_name) as Name ,mu.gender as gender, mu.mobile_no as mobile_no, mu.email,mut.name as university,mc.name as college, DATE_FORMAT(mu.registered_date,'%b %d %Y %h:%i %p') as registered_date,mu.access";
		$where = " WHERE DATE(registered_date) BETWEEN '$start_date' AND '$end_date' ";
		if( $gender !== 'all' && !empty($gender) ){
			$where .= " AND mu.gender = '$gender' ";
		}
		if( !empty($university_id)){
			$where .=  " AND mu.university_id IN('$university_id') ";
		}
		if( !empty($college_id) ){
			$where .= " AND mu.college_id IN($college_id) ";
		}
		if( $access != '' && $access != 'All' ){
			$where .= " AND mu.access = '".$access."' ";
		}
		$SELECT_QUERY = "$selectQuery from  mtsoc_users mu left join mtsoc_universities mut on mu.university_id = mut.id left join mtsoc_colleges mc on mc.id = mu.college_id $where ";
		$results		= $db ['master']->getResults( $SELECT_QUERY );
		return $results;
	}
}
?>