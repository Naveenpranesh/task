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
 * @filename:	registration.service.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the controller for Registration Report Module
 * 
 *
 */

class RegistrationController{
	function RegistrationController() {
	
		if(!mtutor_is_loggedin()) {
			header('location: '.APPLICATION_URL);
		}
	
		global $request, $tsResponse, $library;
		//Collecting the action parameter from request.
		$action = strtolower ( trim ( $request ['action'] ) );
		switch ($action) {
			case "initiate" :
				include(ROOT_DIR.'gateway/header.php');
				$report_name	= 'Registration Report';
				$form_fields	= array (
					'field_1'	=> array(
						'name'		=> 'start_date',
						'type'		=> 'date_range',
						'key'		=> 'date_range',
						'label'		=> 'Start Date',
						'id'		=> 'date_range',
						'class'		=> 'single_date start'
					),
					'field_2'	=> array(
						'name'		=> 'end_date',
						'type'		=> 'date_range',
						'key'		=> 'date_range',
						'label'		=> 'End Date',
						'id'		=> 'date_range',
						'class'		=> 'single_date end'
					),
					'field_3'	=> array(
						'name'		=> 'access',
						'type'		=> 'select',
						'key'		=> 'access',
						'label'		=> 'Access',
						'multiple'	=> false,
						'has_ajax'	=> false,
						'id'		=> 'access'
					),
					'field_4'	=> array(
						'name'			=> 'university',
						'type'			=> 'select',
						'key'			=> 'university',
						'label'			=> 'University',
						'multiple'		=> false,
						'has_ajax'		=> true,
						'ajax_target'	=> array('college'),
						'id'			=> 'university'
					),
					'field_5'	=> array(
						'name'		=> 'college',
						'type'		=> 'select',
						'key'		=> 'college',
						'label'		=> 'College',
						'parent'	=> 'university',
						'multiple'	=> true,
						'has_ajax'	=> false,
						'id'		=> 'college'
					),
					'field_6'	=> array(
						'name'		=> 'gender',
						'type'		=> 'select',
						'key'		=> 'gender',
						'label'		=> 'Gender',
						'multiple'	=> false,
						'has_ajax'	=> false,
						'id'		=> 'gender'
					)
				);
				$application	= 'Registration';
				$form	= mtutorForm($form_fields);
				include(ROOT_DIR.'gateway/search_panel.php');
				include(ROOT_DIR.'gateway/footer.php');
				break;
			case "form_submit" :
				if((strtotime($request['start_date']) >= strtotime($request['end_date']))) {
					die('<div style="color: red;">Start Date should be less than End Date.</div>');
				}
				$beanObj 		    = new Registration( $request );
				$regModelObj 	    = new RegistrationModel ();
				$homeModelObj 		= new HomeModel();
				$getRegResponse 	= $regModelObj->getRegStudent($beanObj);
				$title  	 	= 'Registration Report';
				$yaxislabel  	= 'Count';
				$university  	= $beanObj->getUniversity();				
				$college  		= $beanObj->getCollege();  
				$gender  		= $beanObj->getGender();
				$access  		= $beanObj->getAccess();
				if($beanObj->getStart_date()!=''){
					$date_from	= $beanObj->getStart_date();
				}else{
					$date_from	= '';
				}
				if($beanObj->getEnd_date()!=''){
					$date_to	= $beanObj->getEnd_date();
				}else{
					$date_to	= '';
				}
				if( ($date_from == '') &&( $date_to == '') ){
					$date_from	= date( 'Y-m-d' , strtotime( '-90 days' ) );
					$date_to	= date( 'Y-m-d' );
				} else{
					$date_from	= date( 'Y-m-d' ,strtotime($date_from));
					$date_to	= date( 'Y-m-d' ,strtotime($date_to));
				}
				$dates      	= mtutor_datelist($date_from, $date_to);
				$table_title   	= 'Registration Report';
				$filter_type   	= 'default';
				$color			= array( '#36C6D3','#8000ff', '#ff0080', '#80ff00',  '#A329AD' );
				$filter_args   = ' data-date_from' . ($date_from ? '=' . $date_from : '');
				$filter_args  .= ' data-date_to' . ($date_to ?'=' . $date_to : "");
				$filter_args  .= ' data-university' . ($university ? '=' . $university : '');
				$filter_args  .= ' data-college' . ($college ? '=' . implode(',', $college) : '');
				$filter_args  .= ' data-gender' . ($gender ?'=' . $gender : "");
				$filter_args  .= ' data-access' . ($access ?'=' . $access : "");
				$filter_args  .= ' data-action=' . APPLICATION_URL.'gateway/action?application=registration&action=filter_data';
				$filter_args  .= ' id=chart-filter ';
				$filter_args  .= ' data-reportname= "Registration Report"';
				$downloadLink = array(
					'csv_download_link' => 'Registration_Report_'.$date_from.'_to_'.$date_to.'.csv',
					'pdf_download_link' => 'Registration_Report_'.$date_from.'_to_'.$date_to.'.pdf' ,
					'reportname'		=> 'Registration Report',
					'fromdate'			=> $date_from,
					'todate'			=> $date_to
				);
				$args			= array(
					'university' => $university,
					'college'    => $college,
					'gender'     => $gender,
					'access'     => $access,
					'date_from'  => $date_from,
					'date_to'    => $date_to
				);
				if( empty($university) && empty($college)){
					$data['results']['All University']   = $regModelObj->getRegistration_chart($args);
					$xaxislabel  = 'All Universities';
				}elseif ( !empty($university) && empty($college) ){
					$data['results']['All College']   = $regModelObj->getRegistration_chart($args);
					$xaxislabel  = 'All Colleges';
				} else {
					foreach($college as $col) {
						$college_list		= $homeModelObj->get_college($col);
						$args['college']	= $col;
						$data['results'][$college_list->name] = $regModelObj->getRegistration_chart($args);
					}
					$args['college'] = implode(',', $college);
				}
				$user_data['users']	= $regModelObj->get_registration_report( $args );
				$bar_chart	= TRUE;
				$line_chart	= TRUE;
				$chart_contents = mtutor_filter_form ( $filter_args, $downloadLink );
				$chart_contents .= mtutor_chart();
				$chart_contents .= str_replace('1', '', include ROOT_DIR . 'gateway/chart.php');
				$chart_contents .= mtutor_tabular_data($user_data);
				echo $chart_contents;
				break;
			case "filter_data" :
				$homeModelObj	= new HomeModel();
				$filter_type	= isset( $request['filter_val'] ) ? $request['filter_val'] : 'default';
				$start_date		= isset( $request['date_from'] ) ? $request['date_from'] : '';
				$end_date		= isset( $request['date_to'] ) ? $request['date_to'] : '';
				$university		= isset( $request['university'] ) ? $request['university'] : '';
				$college		= isset( $request['college'] ) ? $request['college'] : '';
				$gender			= isset( $request['gender'] ) ? $request['gender'] : '';
				$access			= isset( $request['access'] ) ? $request['access'] : '';
				$lastxday		= isset( $request['lastxday'] ) ? $request['lastxday'] : '';
				$title			= 'Registration Report';
				$yaxislabel		= 'Count';
				$university		= $university;
				$college		= $college;
				$gender			= $gender;
				$access			= $access;
				$date_from		= $start_date;
				$date_to		= $end_date;
				$filter_type	= $filter_type;
				$report_name	= 'Registration_report';
				$color			= array( '#36C6D3','#8000ff', '#ff0080', '#80ff00',  '#A329AD' );
				$args			= array(
					'university' => $university,
					'college'    => ($college && !empty($college) ) ? explode(",", $college) : '',
					'gender'     => $gender,
					'access'     => $access,
					'date_from'  => $date_from,
					'date_to'    => $date_to,
					'report_name'=> $report_name
				);
				$beanObj		= new Registration( $request );
				$regModelObj	= new RegistrationModel ();
				if( ($filter_type === 'days') || ( $filter_type === 'default' ) ) {
					if( $filter_type === 'days' ){
						$start_date	= date('Y-m-d', strtotime('-' . $lastxday . ' days'));
						$end_date	= date('Y-m-d');
						$dates		= mtutor_datelist( $start_date, $end_date ,'days' );
					}else{
						$dates	= mtutor_datelist( $start_date, $end_date );
					}
					$args['date_from']	= $start_date;
					$args['date_to'] 	= $end_date;
					if( empty($university) ) {
						$data['results']['All University']	= $regModelObj->getRegistration_chart( $args, 'default' );
					} else if( !empty($university) && empty($college) ) {
						$uni_list 		       				= $homeModelObj->get_university( $university );
						$data['results'][$uni_list->name]	= $regModelObj->getRegistration_chart( $args, 'default' );
					} else {
						$college_list	= explode(",", $college);
						foreach( $college_list as $col ) {
							$col_list 		    	 			= $homeModelObj->get_college( $col );
							$args['college']					= $col;
							$data['results'][$col_list->name]  	= $regModelObj->getRegistration_chart( $args, 'default' );
						}
					}
				}else if( $filter_type === 'week' ) {
					if( empty($university) ) {
						$data['results']['All University']	= $regModelObj->getRegistration_chart( $args, 'weekly' );
					} else if( !empty($university) && empty($college) ) {
						$uni_list			        	 	= $homeModelObj->get_university( $university );
						$data['results'][$uni_list->name]	= $regModelObj->getRegistration_chart( $args, 'weekly' );
					} else {
						$college_list	= explode( ",", $college );
						foreach($college_list as $col){
							$col_list				 			= $homeModelObj->get_college( $col );
							$args['college']   		 			= $col;
							$data['results'][$col_list->name]	= $regModelObj->getRegistration_chart( $args, 'weekly' );
						}
					}
					$dates	= mtutor_datelist( $start_date, $end_date, 'week' );
				} else if( $filter_type === 'month' ) {
					if( empty($university) ) {
						$data['results']['All University']= $regModelObj->getRegistration_chart( $args, 'monthly' );
					} else if( !empty($university) &&  empty($request['college']) ) {
						$uni_list	= $homeModelObj->get_university( $university );
						$data['results'][$uni_list->name]		= $regModelObj->getRegistration_chart( $args, 'monthly' );
					} else {
						$college_list	= explode( ",",$college );
						foreach( $college_list as $col ){
							$col_list			 	 			= $homeModelObj->get_college( $col );
							$args['college']  		 			= $col;
							$data['results'][$col_list->name]	= $regModelObj->getRegistration_chart( $args, 'monthly' );
						}
					}
					$dates	= mtutor_datelist( $start_date, $end_date, 'month' );
				}
				$bar_chart	= TRUE;
				$line_chart	= TRUE;
				include ROOT_DIR . 'gateway/chart.php';
				break;
			default :
				break;
		}
	}
}
?>