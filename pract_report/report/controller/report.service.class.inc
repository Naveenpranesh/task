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
class ReportController{
	
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
	function ReportController(){
		
		global  $tsResponse ,$library,$request,$db,$curl,$libxml,$log,$viewclass;

		$action = strtolower ( trim ( $request ['action'] ) );
		switch ($action) {
		
				
			case "fetch_data":
				 $fromdate=date('Y-m-d 00:00:00');
						$todate= date("Y-m-d 23:59:59");
						$today= date("Y-m-d");
						$cr_hour= date("H");
						$to=date('Y-m-d',strtotime('-1 day'));
						$from=date('Y-m-d', strtotime('-10 days'));

						if($today==date('Y-m-01'))
						{
						$bt=strtotime(date('Y-m-01',strtotime($today)),time());
						$curr_mon=date('Y-m',strtotime('-1 month',$bt));
						$prev_mon=date('Y-m',strtotime('-2 month',$bt));
						$two_month=date('Y-m',strtotime('-3 month',$bt));
						}
						else
						{
						$bt=strtotime(date('Y-m-01',strtotime($today)),time());
						$curr_mon=date('Y-m',strtotime('-0 month',$bt));
						$prev_mon=date('Y-m',strtotime('-1 month',$bt));
						$two_month=date('Y-m',strtotime('-2 month',$bt));
						}


						$reportModel = new ReportModel();

						$result = $reportModel->find_report();
						$dt=$result[0];
						$start_base=$result[1];
						$sub_start_base=$result[2];
						
						$GetError= $reportModel->find_report_GetError();
						$Getprice= $reportModel->find_report_get_sub_base();
					
						$last10_data= $reportModel->find_report_10days();
						$last_three_mon = $reportModel->find_report_month();

						include(ROOT_DIR.'gateway/report.php');
						
					
				break;

		
		
		}
	}
	
}
?>