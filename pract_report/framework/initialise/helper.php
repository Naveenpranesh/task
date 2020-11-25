<?php
	include(ROOT_DIR.'application/home/model/home.class.inc'); 
	include(ROOT_DIR.'application/admin/model/admin.class.inc'); 

	function mtutor_current_application () {
		global $request;
		if(isset($request['application']) && !empty($request['application']))
			return $request['application'];
		else
			return false;
	}
	
	function mtutor_current_user() {
		$admin_model = new AdminModel();
		if(isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
			return $admin_model->get_user($_SESSION['userid']);
		} else {
			return false;
		}
	}
	
	function mtutor_is_loggedin() {
		if( isset($_SESSION['userid']) && !empty($_SESSION['userid']) ) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_chatroom($chatroom_id = '') {
		global $db;
		$where = "";
		if ( !empty($chatroom_id) ) {
			$where .= "WHERE id = $chatroom_id";
		}
		$query  = "SELECT * FROM cometchat_chatrooms $where";
		$chatrooms = $db['master']->getResults($query);
		return $chatrooms;
	}
	
	function mtutorForm($form_fields = array()) {
		if(!empty(array_filter($form_fields))) {
			$home_model = new HomeModel();
			$form_html = '';
			$counter		= 0;
			$last_element	= count($form_fields);
			foreach($form_fields as $field) {
				if($field['key'] == 'date_range') {
					if($field['optional'])
						$form_html .= '<div class="col-md-4">';
					else
						$form_html .= '<div class="col-md-3">';
					$form_html .= '<div class="form-group">
										<label for="' . $field['id'] . '">' . $field['label'] . '</label>
					';
					$form_html .= '<input name="' . $field['name'] . '" value="" id="' . $field['id'] . '" class="form-control mt-field-daterange pull-right control-datepicker ' . $field['class'] . '" type="text"/>';
				} else{
					if($field['optional'])
						$form_html .= '<div class="col-md-4">';
					else
						$form_html .= '<div class="col-md-6">';
					$form_html .= '<div class="form-group">
										<label for="' . $field['id'] . '">' . $field['label'] . '</label>
					';
					if($field['key'] == 'university') {
						$target	= implode(',', $field['ajax_target']);
						$form_html .= '<select class="form-control" name="' . $field['name'] . '" id="'.$field['id'].'" data-target="' . $target . '">
								<option value="">All</option>';
						$university	= $home_model->get_university();
						foreach($university as $univ) {
							$form_html .= '<option value="' . $univ['id'] . '">' . $univ['name'] . '</option>';
						}
						$form_html	.= '</select>';
					} elseif($field['key'] == 'college') {
						if($field['multiple'] == true) {
							$multiple		= 'select2';
							$multiple_array	= '[]';
							$multiple_key	= 'multiple';
						} else {
							$multiple		= '';
							$multiple_array	='';
							$multiple_key	= '';
							if($field['has_ajax'] == true) {
								$target	= implode(',', $field['ajax_target']);
								$ajax_target	= 'data-target="' . $target . '"';
							} else {
								$ajax_target = '';
							}
						}
						$form_html .= '<select class="form-control '.$multiple.'" '.$multiple_key.' name="' . $field['name'] . $multiple_array.'" id="' . $field['id'] . '" style="height: 34px;" ' . $ajax_target . '><option value="0">Select University</option></select><div class="college_all_div"></div>';
					} elseif($field['key'] == 'branch') {
						if($field['has_ajax'] == true) {
							$target	= implode(',', $field['ajax_target']);
							$ajax_target	= 'data-target="' . $target . '"';
						} else {
							$ajax_target = '';
						}
						$form_html	.= '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="form-control" ' . $ajax_target . '>
							<option value="">No Record Found</option>
						</select>';
					} elseif($field['key'] == 'subject') {
						if($field['has_ajax'] == true) {
							$target	= implode(',', $field['ajax_target']);
							$ajax_target	= 'data-target="' . $target . '"';
						} else {
							$ajax_target = '';
						}
						$form_html	.= '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="form-control" ' . $ajax_target . '>
							<option value="">No Record Found</option>
						</select>';
					} elseif($field['key'] == 'topic') {
						$form_html	.= '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="form-control">
							<option value="">No Record Found</option>
						</select>';
					} elseif($field['key'] == 'gender') {
						$form_html	.= '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="form-control"> 
							<option value="all">All</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Others">Others</option>
						</select>';
					} elseif($field['key'] == 'access') {
						$form_html	.= '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="form-control"> 
							<option value="All">All</option>
							<option value="Web">Web</option>
							<option value="App">App</option>
						</select>';
					} elseif($field['key'] == 'custom') {
						if($field['type'] == 'select') {
							if($field['has_ajax'] == true) {
								$data_target	= ' data-target="' . $target . '"';
							} else {
								$data_target	= '';
							}
							$form_html	.= '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="form-control" ' . $data_target . '>';
							foreach($field['options'] as $key => $value) {
								$form_html	.= '<option value="'.$key.'">'.$value.'</option>';
							}
							$form_html	.= '</select>';
						} elseif($field['type'] == 'number') {
							$form_html	.= '<input name="' . $field['name'] . '" value="" class="form-control mt-field-rank" min="1" id="' . $field['id'] . '" type="number">';
						} elseif($field['type'] == 'checkbox') {
							$form_html	.= '<input name="' . $field['name'] . '" value="1" type="checkbox" id="' . $field['id'] . '">';
						}
					} elseif($field['key'] == 'branch_sme') {
						$target	= implode(',', $field['ajax_target']);
						$ajax_target	= 'data-target="' . $target . '"';
						$form_html .= '<select class="form-control" name="' . $field['name'] . '" id="'.$field['id'].'" ' . $ajax_target . '>
								<option value="">Please Select</option>';
						$branches	= $home_model->get_branch();
						foreach($branches as $branch) {
							$form_html .= '<option value="' . $branch['branch_id'] . '">' . $branch['branch_name'] . '</option>';
						}
						$form_html	.= '</select>';
					} elseif($field['key'] == 'sme') {
						$form_html .= '<select class="form-control" name="' . $field['name'] . '" id="'.$field['id'].'">
								<option value="">Please Select</option>';
						$sme_s	= $home_model->get_sme();
						foreach($sme_s as $sme) {
							$form_html .= '<option value="' . $sme['id'] . '">' . $sme['first_name'] . ' ' . $sme['last_name'] . '</option>';
						}
						$form_html	.= '</select>';
					} elseif($field['key'] == 'chatroom') {
						$form_html .= '<select class="form-control" name="' . $field['name'] . '" id="'.$field['id'].'">
								<option value="">Please Select</option>';
						$chatrooms	= $home_model->get_chatroom();
						foreach($chatrooms as $chatroom) {
							$form_html .= '<option value="' . $chatroom['id'] . '">' . $chatroom['name'] . '</option>';
						}
						$form_html	.= '</select>';
					} elseif($field['key'] == 'radio') {
						if (is_array($field['bulk']) && count($field['bulk']) > 0 ) {
							$isCheked = 1;
							foreach ( $field['bulk'] as $value) {
								$form_html .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '" value="' . $value . '">&nbsp;&nbsp;' . ucfirst($value) . '&nbsp;&nbsp;';
							}
							
						} else {
							$form_html .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '" value="' . $field['value'] . '">' . ucfirst($value);
						}
						
					} elseif($field['key'] == 'users') {
						$form_html .= '<select class="form-control" name="' . $field['name'] . '" id="'.$field['id'].'">
								<option value="">Please Select</option>';
						$users	= $home_model->get_users();
						foreach($users as $user) {
							$form_html .= '<option value="' . $user['id'] . '">'.$user['first_name'].' '.$user['last_name'].'</option>';
						}
						$form_html	.= '</select>';
					}
				}
				$form_html .= '</div></div>';
				$counter++;
				if($counter == 3) {
					$form_html .= '</div>';
					if($counter != $last_element) {
						$form_html .= '<div class="row">';
					}
				}
				if($counter >= 4){
					if(($counter-1) % 2 === 0) {
						$form_html .= '</div>';
						if($counter != $last_element) {
							$form_html .= '<div class="row">';
						}
					} else {
						if($counter == $last_element) {
							$form_html .= '</div>';
						}
					}
				}
			}
			return $form_html;
		} else {
			return false;
		}
	}

	//Datelist
	function mtutor_datelist( $start_date = '', $end_date = '', $type = '' ) {
		try {
			$start_date   = DateTime::createFromFormat('Y-m-d', $start_date);
			$end_date     = DateTime::createFromFormat('Y-m-d', $end_date);
			$dateObject   = new DatePeriod( $start_date, new DateInterval('P1D'), $end_date );
			$dateList = array();
			if( $type === 'month' ) {
				while ( $start_date <= $end_date ) {
					$dateList[] = $start_date->format( 'm-Y' );
					$start_date->modify( 'first day of next month' );
				}
			} else if( $type === 'week' ) {
				$end_date 	= date('Y-m-d', strtotime($end_date->format('Y-m-d') . ' +1 day'));
				$end_date  	= DateTime::createFromFormat('Y-m-d', $end_date);
				$dateObject = new DatePeriod( $start_date, new DateInterval('P1D'), $end_date );
				$weekNumber	= 1;
				$weeks		= array();
				foreach ( $dateObject as $date ) {
					$weeks[$weekNumber][] = $date->format( 'Y-m-d' );
					if ( $date->format('w') == 6 ) {
						$weekNumber++;
					}
				}
				$week_list_maped = array_map( function($total_week){
					if( count( $total_week ) == 1 ) {
						return date("Y-m-d", strtotime( $total_week[0] )). ' TO ' . $total_week[0];
					} else {
						return date("Y-m-d", strtotime( array_shift( $total_week ) )) . ' TO ' . date("Y-m-d", strtotime( array_pop( $total_week ) ));
					}
				}, $weeks );
				foreach( $week_list_maped as $dates ){
					$dates_seperate	= explode( ' TO ', $dates );
					$start_date		= date("Y-m-d", strtotime( $dates_seperate['0'] ));
					$end_date		= date("Y-m-d", strtotime( $dates_seperate['1'] ));
					$dateList[] 	= date("d-m", strtotime( $start_date ))." To ".date("d-m-Y", strtotime( $end_date ));
				}
			} else {		 
				foreach( $dateObject as $dates ) {
					$date =  $dates->format( 'Y-m-d' );
					array_push( $dateList, $date );
				}
			}
			return $dateList;
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
	}

	function mtutor_datelistWeekly( $start_date = '', $end_date = '', $type = '' ) {
		$tem_end	= $end_date;
		$timestamp	= strtotime($end_date);
		$end_date	=  date('Y-m-d', strtotime("next Saturday ", $timestamp));
		$tem_start	= $start_date;
		$timestamp2 = strtotime($start_date);
		$start_date_day = date("D", $timestamp2);
		if($start_date_day != 'Sun'){
			$start_date =  date('Y-m-d', strtotime("last Sunday ", $timestamp2));
		}
		$weekno		=  date('W', $timestamp2);
		try {
			$start_date   = DateTime::createFromFormat('Y-m-d', $start_date);
			$end_date     = DateTime::createFromFormat('Y-m-d', $end_date);
			$dateObject   = new DatePeriod( $start_date, new DateInterval('P1D'), $end_date );
			$dateList = array();
			if( $type === 'month' ) {
				while ( $start_date <= $end_date ) {
					$dateList[] = $start_date->format( 'm-Y' );
					$start_date->modify( 'first day of next month' );
				}
			} else if( $type === 'week' ) {
				$end_date 	= date('Y-m-d', strtotime($end_date->format('Y-m-d') . ' +1 day'));
				$end_date  	= DateTime::createFromFormat('Y-m-d', $end_date);
				$dateObject = new DatePeriod( $start_date, new DateInterval('P1D'), $end_date );
				$weekNumber	= 1;
				$weeks		= array();
				foreach ( $dateObject as $date ) {
					$weeks[$weekNumber][] = $date->format( 'Y-m-d' );
					if ( $date->format('w') == 6 ) {
						$weekNumber++;
					}
				}
				$week_list_maped = array_map( function($total_week){
					if( count( $total_week ) == 1 ) {
						return date("Y-m-d", strtotime( $total_week[0] )). ' TO ' . $total_week[0];
					} else {
						return date("Y-m-d", strtotime( array_shift( $total_week ) )) . ' TO ' . date("Y-m-d", strtotime( array_pop( $total_week ) ));
					}
				}, $weeks );
				$memory	= 0;
				$tot_len	= count($week_list_maped);
				foreach( $week_list_maped as $dates ){
					$dates_seperate	= explode( ' TO ', $dates );
					$start_date		= date("Y-m-d", strtotime( $dates_seperate['0'] ));
					$end_date		= date("Y-m-d", strtotime( $dates_seperate['1'] ));
					if($start_date == '2017-01-01') {
						$updated	= '01';
					} else {
						$updated	= date('W', strtotime($start_date)) + 1;
					}
					$dateListweek[]	= date("d-m-Y", strtotime( $start_date ))." To ".date("d-m-Y", strtotime( $end_date ))." To ".$updated." To ".date('Y', strtotime($start_date));
					if($memory	== 0){
						$dateList[] 	= date("d-m", strtotime( $tem_start ))." To ".date("d-m-Y", strtotime( $end_date ));
					} else if($memory+1 == 14) {
						$dateList[] 	= date("d-m", strtotime( $start_date ))." To ".date("d-m-Y", strtotime( $tem_end ));
					}else {
						$dateList[] 	= date("d-m", strtotime( $start_date ))." To ".date("d-m-Y", strtotime( $end_date ));
					}
					$memory++;
					$c++;
				}
			} else {
				foreach( $dateObject as $dates ) {
					$date =  $dates->format( 'Y-m-d' );
					array_push( $dateList, $date );
				}
			}
			return array('default'	=> $dateList, 'custom'	=> $dateListweek);
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
	}

	/** 
	* Generate Chart Filter Form.
	*/
	function mtutor_filter_form ( $args = '', $downloadLink = '' ,$filter_type = '') {
		if (!empty($downloadLink)) {
			$csv_download_link = $downloadLink['csv_download_link'];
			$pdf_download_link = $downloadLink['pdf_download_link'];
		} else {
			$csv_download_link = 'csvOutput.csv';
			$pdf_download_link = 'pdfOutput.pdf';
		}
		if(!empty($filter_type)){
			$filter_type = $filter_type;
		}else{
			$filter_type = '';
		}
		$html = '<div class="box box-default"><div class="box-header with-border" id="boxheader">';
		$html .= 	'<div class="pull-left" >';
		$html .= 	   '<h3 class="box-title" id="changefilterheading" data-title="'.$downloadLink['reportname'].' From '.date('d-m-Y',strtotime($downloadLink['fromdate'])).' to '.date('d-m-Y',strtotime($downloadLink['todate'])).'">'.$filter_type .' '.$downloadLink['reportname'].' From '.date('d-m-Y',strtotime($downloadLink['fromdate'])).' to '.date('d-m-Y',strtotime($downloadLink['todate'])).'</h3>';
		$html .= 	'</div>';
		$html .= 	'<div class="buttons pull-right">';
		$html .= 	   '<a id="report-download-csv" class="btn btn-primary" data-name="'.$csv_download_link.'">Download Data to CSV</a>&nbsp;';
		$html .= 	   '<a id="report-download-pdf" class="btn btn-primary" data-name="'.$pdf_download_link.'">Download Chart to PDF</a>';
		$html .= 	'</div>';
		$html .= '</div>';
		$html .= '<div class="box-body">';
		$html .= 	'<div id="filter-btn">';
		$html .= 	   '<div class="row">';
		$html .=		'<form method="POST" ' . $args . '>';
		$html .=			'<div class="form-group">';
		$html .=				'<div class="col-md-3" style="margin-left:20px">';
		$html .=					'<div class="input-group">';
		$html .=						'<span class="input-group-addon" id="sizing-addon1">Last</span>';
		$html .=						'<input type="number" class="form-control" value="" id="lastxdays">';
		$html .=						'<span class="input-group-btn">';
		$html .=							'<a class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="days" data-value="">Days</a>';
		$html .=						'</span>';
		$html .=					'</div>';
		$html .=				'</div>';
		$html .=				'<div class="col-md-2">';
		$html .=					'<a style="display: block;" href="javascript:void(0)" class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="week" data-value="week">Weekly</a>';
		$html .=				'</div>';
		$html .=				'<div class="col-md-2">';
		$html .=					'<a style="display: block;" href="javascript:void(0)" class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="month" data-value="month">Monthly</a>';
		$html .=				'</div>';
		$html .=				'<div class="col-md-2">';
		$html .=					'<a style="display: block;" href="javascript:void(0)" class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="default" data-value="default">Default</a>';
		$html .=				'</div>';
		$html .=			'</div>';
		$html .= 		'</form>';
		$html .=	    '</div>';
		$html .=	'</div>';
		$html .='</div>';
		return $html;
	}

	/**
	* Charts container element
	*/
	function mtutor_chart() {
		$content = '<div id="report">';
		$content .= 	'<div class="row" id="tobe_empty">';
		$content .= 		'<div class="col-md-12">';
		$content .= 			'<div id="column-chart" class="report_chart"></div>';
		$content .= 		'</div>';
		$content .= 	'</div>';
		$content .= 	'<div class="row" id="tobe_empty">';
		$content .= 		'<div class="col-md-12">';
		$content .= 			'<div id="line-chart" class="report_chart"></div>';
		$content .= 		'</div>';
		$content .= 	'</div>';
		$content .= '</div>';
		return $content;
	}

	//data for table
	function mtutor_tabular_data( $table_content = '', $th = '' ) {
		$table_header 	= array();
		foreach($table_content['users'] as $key => $value) {
			foreach($value as $k => $v){
				$table_header['Sr.'] 	= 'Sr.';
				$table_header[$k] 		= ucwords(str_replace('_', ' ', $k));
			}
		}
		$sr_no = 0;
		$tabular_data 	= 	'<div class="container-fluid">';
		$tabular_data 	.= 		'<div class="row">';
		$tabular_data 	.= 			'<div class="col-md-12">';
		$tabular_data 	.= 				'<div class="box">';
		$tabular_data 	.= 					'<div class="box-body table-responsive no-padding">';
		$tabular_data 	.= 						'<table class="table table-hover" id="report-table">';
		$tabular_data 	.= 							'<thead>';
		$tabular_data 	.= 								'<tr>';
															if ( !empty($th) ) {
																foreach ($th as $k => $v) {
		$tabular_data 	.= 											'<td><strong>' . $v .'</strong></td>';
																}
															} else {
																if(!empty($table_header)) {
																	foreach ($table_header as $k => $v) {
		$tabular_data 	.= 												'<td><strong>' . $v . '</strong></td>';
																	}
																}
															}
		$tabular_data 	.= 								'</tr>';
		$tabular_data 	.= 							'</thead>';
		$tabular_data 	.= 							'<tbody>';
														foreach($table_content['users'] as $key => $value) {
		$tabular_data 	.= 								'<tr>';
		$tabular_data 	.= 									'<td>' . ++$sr_no . '</td>';
															foreach($value as $k => $v){
		$tabular_data 	.= 									'<td>' . $v . '</td>';
															}
														}
		$tabular_data 	.= 							'</tbody>';
		$tabular_data 	.= 						'</table>';
		$tabular_data 	.= 					'</div>';
		$tabular_data 	.= 				'</div>';
		$tabular_data 	.= 			'</div>';
		$tabular_data 	.= 		'</div>';
		$tabular_data 	.= 	'</div>';
		return $tabular_data;
	}

	//summary report table
	function mtutor_tabulars_data( $table_content, $table_header ) {
		$sr_no = 0;
		$tabular_data 	= 	'<div class="box">
									<div class="box-body table-responsive no-padding">
												<table class="table table-hover" id="report-table">
													<thead>
														<tr>';
															foreach ($table_header as $k => $v) {
		$tabular_data 	.= 									'<td><strong>' . $v .'</strong></td>';
															}
		$tabular_data 	.= 								'</tr>';
		$tabular_data 	.= 							'</thead>';
		$tabular_data 	.= 							'<tbody>';
														foreach($table_content as $key => $value) {
		if($table_content[$key]['average_time'][0]['AVERAGE_USAGE'] != '00:00:00' ) {
			list($hrs,$min,$sec) = explode( ":", $table_content[$key]['average_time'][0]['AVERAGE_USAGE']);
			$hrs_display = "";
			$min_display = "";
			$sec_display = "";
			if($hrs != "00") {
				$hrs_display = $hrs." hrs";
			}
			if($min != "00") {
				$min_display = $min." mins";
			}
			$avg_time = $hrs_display." ".$min_display;
		} else {
			$avg_time = '--';
		}
		$not_login	= ($table_content[$key]['user_count_till_date'][0]['REGISTRATION_COUNT_till_that_date']) - ($table_content[$key]['login_count'][0]['COUNT_OF_USERS_LOGGED_IN_FOR_GIVEN_DATE']);
		$tabular_data 	.= 								'<tr>';
		$tabular_data 	.= 									'<td>' . ++$sr_no . '</td>';
		$tabular_data 	.= 									'<td>'.$key.'</td><td>' . $table_content[$key]['total_users'][0]['TOTAL_NUMBER_OF_REGISTERED_USERS_as_on_that_date'] . '</td><td>' . $table_content[$key]['user_count_till_date'][0]['REGISTRATION_COUNT_till_that_date'] . '</td><td>' . $table_content[$key]['login_count'][0]['COUNT_OF_USERS_LOGGED_IN_FOR_GIVEN_DATE'] . '</td>';
		$tabular_data 	.= 									'<td>' . $not_login . '</td><td>' . $avg_time . '</td>';
		$tabular_data 	.= 								'</tr>';
														}
		$tabular_data 	.= 							'</tbody>';
		$tabular_data 	.= 						'</table>';
		$tabular_data 	.= 					'</div>';
		$tabular_data 	.= 				'</div>';
		return $tabular_data;
	}

	//table for sme_performance report
	function mtutor_sme_performance_data( $table_header,$table_content,$heading ) {
		$sr = 0;
		$content = '<div class="row">
							<div class="col-md-12">
								<div class="box">
									<div class="box-header with-border mtutor-table-header">
										<h3 class="box-title">'.$heading.'</h3>
									</div>
									<div class="box-body table-responsive no-padding" id="here_table">
										<table class="table table-hover" id="report-table1">
											<thead>
											<tr>';
												for($i=0;$i<count($table_header);$i++){
													$content .= '<td><strong>'.$table_header[$i].'</strong></td>';
												}
		$content .=							'</tr>
											</thead>
											<tbody id="user">';
													foreach($table_content as $value){
													if(($value['Total_no_of_question_assigned']=='0')&&($value['Total_no_of_answered_questions']=='0')&&($value['Total_no_of_rejected_answer']=='0'))
													{
		$content .=										'<tr><td colspan="7" style="text-align:center;">No Records Found</td></tr>';
													}else{
		$content .=									'<tr>';
		$content .=										'<td>' . ++$sr . '</td>
														<td>'.$value['Total_no_of_question_assigned'].'</td>
														<td><a href="javascript:void(0);" id="Total_answered_questions" sme="'.$value['sme'].'"  start_date="'.$value['start_date'].'" end_date="'.$value['end_date'].'" data-toggle="collapse" data-target="#demo">'.$value['Total_no_of_answered_questions'].'</a></td>
														<td><a href="javascript:void(0);" id="Total_rejected_answer" sme="'.$value['sme'].'"  start_date="'.$value['start_date'].'" end_date="'.$value['end_date'].'" data-toggle="collapse" data-target="#demo">'.$value['Total_no_of_rejected_answer'].'</a></td>
														<td>'.$value['average'].'</td>
														<td><a href="javascript:void(0);" id="max_time_spent" sme="'.$value['sme'].'"  start_date="'.$value['start_date'].'" end_date="'.$value['end_date'].'" data-toggle="collapse" data-target="#demo">'.$value['max_difference'].'</a></td>
														<td><a href="javascript:void(0);" id="min_time_spent" sme="'.$value['sme'].'"  start_date="'.$value['start_date'].'" end_date="'.$value['end_date'].'" data-toggle="collapse" data-target="#demo">'.$value['min_difference'].'</a></td>';
		$content .=									'</tr>';
														}
													}
		$content .=							'</tbody>';
		$content .=						'</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
		return $content;
	}

	function mtut_filter_forms( $args ){
		$args['id'] = 'chart-filter';
		$html = '<div class="box box-default"><div class="box-header with-border" id="boxheader">
						<div class="pull-left">
							<h3 class="box-title" id="changefilterheading" data-title="'.$args['data-reponame'].' From '.date('d-m-Y',strtotime($args['data-date_from'])).' To '.date('d-m-Y',strtotime($args['data-date_to'])).'">'.$args['data-reponame'].' From '.date('d-m-Y',strtotime($args['data-date_from'])).' To '.date('d-m-Y',strtotime($args['data-date_to'])).'</h3>
						</div>
						<div class="buttons pull-right">
							<a id="report-download-csv" class="btn btn-primary" data-name="'.$args['data-reportname'].'.csv">Download Data to CSV</a>
							<a id="report-download-pdf" class="btn btn-primary" data-name="'.$args['data-reportname'].'.pdf">Download Chart to PDF</a>
						</div>
					</div>';
		$html .=	'<div class="box-body">
						<div id="filter-btn">
						<div class="row">';
		$html .= 		'<form action="#" data-date_from="'.$args['data-date_from'].'" data-date_to="'.$args['data-date_to'].'" data-university="'.$args['data-university'].'" data-college="'.$args['data-college'].'" data-gender="'.$args['data-gender'].'" data-access="'.$args['data-access'].'" data-action="'.$args['data-action'].'" data-reportname="'.$args['data-reportname'].'" id="chart-filter" method="post" accept-charset="utf-8">';
		$html .= 			'<div class="form-group">
								<div class="col-md-3">
									<div class="input-group">
										<span class="input-group-addon" id="sizing-addon1">Last</span>
										<input type="number" class="form-control" value="" id="lastxdays">
										<span class="input-group-btn">
											<a class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="days" data-value="">Days</a>
										</span>
									</div>
								</div>';
		$html .=				'<div class="col-md-2">
									<a style="display: block;" href="javascript:void(0)" class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="week" data-value="week">Weekly</a>
								</div>
								<div class="col-md-2">
									<a style="display: block;" href="javascript:void(0)" class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="month" data-value="month">Monthly</a>
								</div>';
		$html .=				'<div class="col-md-2">';
		$html .=					'<a style="display: block;" href="javascript:void(0)" class="btn btn-info filter-links text-muted" id="filter-chart" name="chart_filter" data-type="default" data-value="default">Default</a>';
		$html .=				'</div>
							</div>';
		$html .= 	'</form>';
		$html .=		'</div>';
		$html .=		'</div>';
		echo $html;
	}
?>