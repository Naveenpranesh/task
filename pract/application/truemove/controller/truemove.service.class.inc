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
 * @filename:	admin.service.class.inc
 * @filetype:	PHP
 * @filedesc:   This file contains the controller for members Module
 * 				which select the action or state for model depends
 * 				upon the user input given to the controller.
 * 
 *
 */

session_start();
class TruemoveController{
	
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
	function TruemoveController(){
		
		global $request, $tsResponse, $library;
		$truemod=new TruemoveModel(); 
		//Collecting the action parameter from request.
		if(!isset($request['login_bypass']) && !mtutor_is_loggedin()) {
			header('location: '.APPLICATION_URL);
		}
		$action = strtolower ( trim ( $request ['action'] ) );
		switch ($action) {
			case "initiate" :
				include(ROOT_DIR.'gateway/header.php');
				include(ROOT_DIR.'gateway/truemove/truemove_entry_form.php');
				include(ROOT_DIR.'gateway/footer.php');
				break;
			case "fetch_data":
				$db_data=$truemod->find_report($request['date']);
				echo json_encode($db_data);
			break;
			case "insert":
				if(isset($request['date']))
				{
					$type=$truemod->exist($request['date'],$request['newsub'],$request['unsub'],$request['actsub'],$request['tottrans'],$request['mtsucc']);
					 if($type=='insert_now')
					{
							$ins_res=$truemod->insert_report($request['date'],$request['newsub'],$request['unsub'],$request['actsub'],$request['tottrans'],$request['mtsucc']);
							echo $ins_res;
					}
				}
			break;
			case "get_report":
			
				$day_report=$truemod->get_day_report();
				$last10_days_report=$truemod->get_days_report();
				$last3_months_report=$truemod->get_months_report();
				$last_month_report=$truemod->get_lastmonth();
				//echo print_r($last3_months_report);
				if(!isset($request['login_bypass']))
					include(ROOT_DIR.'gateway/header.php');
				include(ROOT_DIR.'gateway/truemove/truemove_report_page.php');
				if(!isset($request['login_bypass']))
					include(ROOT_DIR.'gateway/footer.php');
				$torep=date("Y-m-d",strtotime('-1 day'));
				$ccto = 'jai@m-tutor.com,pk@symbioticinfo.com,sundar@symbioticinfo.com,aniket.sahamate@symbioticinfo.com,kesarivarman.p@m-tutor.com,balaji.g@symbioticinfo.com,l1support@symbioticinfo.com,gangadhar.ml@symbioticinfo.com';
				$to =  'adalarasu.a@m-tutor.com';
				$subject  = 'TrueMove Revenue Report upto '.$torep;
				$varMessage=$report_msg;
				if(isset($request['login_bypass']) && !empty($day_report) && isset($day_report['date']))
					$truemod->sendemail($to,$varMessage,'',$subject,$ccto);
			break;
		case "send_email":
				$day_report=$truemod->get_day_report();
				$last10_days_report=$truemod->get_days_report();
				$last3_months_report=$truemod->get_months_report();
				$last_month_report=$truemod->get_lastmonth();
				include(ROOT_DIR.'gateway/header.php');
				include(ROOT_DIR.'gateway/truemove/truemove_report_page.php');
				include(ROOT_DIR.'gateway/footer.php');
				$ccto = 'jai@m-tutor.com,pk@symbioticinfo.com,sundar@symbioticinfo.com,aniket.sahamate@symbioticinfo.com,kesarivarman.p@m-tutor.com,balaji.g@symbioticinfo.com,l1support@symbioticinfo.com,gangadhar.ml@symbioticinfo.com';
				$to =  'adalarasu.a@m-tutor.com';
				$subject  = 'TrueMove Revenue Report upto '.$torep;
				$varMessage=$report_msg;
				$truemod->sendemail($to,$varMessage,'',$subject,$ccto);
				break;
					
		
		}
	}
	
}
?>