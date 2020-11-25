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


class TruemoveModel {

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
	
		public function find_report($report_date)
		{
			global $db , $result;
			$rep_date=date('Y-m-d',strtotime($report_date));
			$query="SELECT * FROM report_table WHERE date='".$rep_date."'";
			$result = $db['master']->getResults($query);
			return $result; 
		}
		public function exist($data_d,$newsub,$unsub,$actsub,$tottrans,$mtsucc)
		{
			global $db ;
			$rep_date1=date('Y-m-d',strtotime($data_d));
			$query_check="SELECT * FROM report_table WHERE `date`='".$rep_date1."'";
			$result1 = $db['master']->getOneRow($query_check);
			if(!empty($result1) && count($result1)>= 1)
			{
				$query_update="UPDATE report_table SET 
				
				`new_sub`='".$newsub."',
				`un_sub`='".$unsub."',
				`active_sub`='".$actsub."',
				`total_trans`='".$tottrans."',
				`mt_success`='".$mtsucc."'
				
				WHERE `id`='".$result1['id']."' ";
				$resup=$db['master']->query($query_update);
				if($resup)
				{
					return "updated";
				}
				else{
					return "not_updated";
				}
				
			}
			else
			{
				return "insert_now";
			}
		}
		public function insert_report($date,$newsub,$unsub,$actsub,$tottrans,$mtsucc)
		{
			$reb_date=date('Y-m-d',strtotime($date));
			global $db , $result;
			$query="INSERT INTO report_table 
			(`date`,
			`new_sub`,
			`un_sub`,
			`active_sub`,
			`total_trans`,
			`mt_success`,
			`id`) 
			VALUES('".$reb_date."',
			'".$newsub."',
			'".$unsub."',
			'".$actsub."',
			'".$tottrans."',
			'".$mtsucc."','') ";
			$resin=$db['master']->query($query);
			if($resin)
			{
				return "inserted";
			}
			else{
				return "not_inserted";
			}
			
		}
		/* public function update_report($id,$date,$newsub,$unsub,$actsub,$tottrans,$mtsucc)
		{
			$rep_date1=date('Y-m-d',strtotime($date));
			$query="UPDATE report_table
			SET `date`='".$rep_date1."',
			`new_sub`='".$newsub."',
			`un_sub`='".$unsub."',
			`active_sub`='".$actsub."',
			`total_trans`='".$tottrans."',
			`mt_success`='".$mtsucc."'
			WHERE `id`='".$id."'";
			$resup=$db['master']->query($query);
			if($resup)
			{
				return "updated";
			}
			else{
				return "not_updated";
			}
		} */
		public function get_day_report()
		{
			global $db ;
			$today=date("Y-m-d",strtotime('-1 day'));
			$get_one="SELECT * FROM report_table WHERE `date`='".$today."' ORDER BY `date` DESC "; 
			$oneday_rep=$db['master']->getOneRow($get_one);
			return $oneday_rep;
		}
		public function get_days_report()
		{
			global $db ;
			$to=date("Y-m-d",strtotime('-2 day'));
			$from=date("Y-m-d",strtotime('-11 day'));
			$get_days="SELECT * FROM report_table WHERE DATE <='".$to."' AND DATE >='".$from."' ORDER BY `date` DESC  ";
			$days_report = $db['master']->getResults($get_days);
			return $days_report;
		}
		public function get_months_report()
		{
			global $db ;
			$to_month=date("Y-m");
			$from_month=date("Y-m-01",strtotime('-2 months'));
			
			$get_months="SELECT DATE_FORMAT(`date`,'%Y-%m') AS mon_val,
							SUM(new_sub) AS `new_sub`,
							SUM(un_sub) AS `un_sub`,
							SUM(active_sub) AS `active_sub`,
							SUM(total_trans) AS `total_trans`,
							SUM(mt_success) AS `mt_success`
							FROM report_table
							WHERE `date`>='".$from_month."' GROUP BY MONTH(`date`) ORDER BY `date` DESC ";
			$months_report = $db['master']->getResults($get_months);
			return $months_report; 
		}
		public function get_lastmonth()
		{
			global $db ;
			$year=date("Y-m");
			$to=$year.'-01';
			//$tos=strtotime($to);
			$fromr= date('Y-m', strtotime("-1 month",strtotime ($to)));
			$from=$fromr.'-01';
			$tos1=date('Y-m', strtotime("+1 month",strtotime ($fromr)));
			$tos2=$tos1.'-01';
			$get_month="SELECT `date`,
						mt_success*0.75 AS `revenue`
						FROM report_table
						WHERE `date`<'".$tos2."' AND `date`>='".$from."'  ";
			$month_report = $db['master']->getResults($get_month);
			return $month_report; 
			
		}
		public function sendemail($email, $msg_content, $attachment='',$subject,$ccto)
			{
					require_once(ROOT_DIR."/framework/library/mail/mail.init.php");
					$mail = new Mailer();
					$mail->CharSet = "UTF-8"; 
					$mail->IsSMTP();                     // set mailer to use SMTP
					//$mail->Host = "192.168.100.7";  // specify main and backup server
					$mail->Host = "mail.symbioticinfo.com";  // specify main and backup server
					$mail->SMTPSecure = "ssl";
					$mail->SMTPAuth = true;     // turn on SMTP authentication
					$mail->Port = "587";
					$mail->Username = "alerts";  // SMTP username
					$mail->Password = 'G$d26B@e$4fXz@M9$A'; // SMTP password
					$mail->From = 'alerts@symbioticinfo.com';
					$mail->FromName = 'TrueMove';
					$mail->IsHTML(true); 
					$to = $email;
					$body = $msg_content;                
					$mail->Subject = $subject;                                          
					$mail->Body    = $body;
					$mail->AddAddress($to);             
					$arrCC = explode(",",$ccto);
					foreach($arrCC as $cc)
					{
						$mail->AddCC($cc);
					}
					if($mail->Send())
					{
						//return TRUE;
						 console(LOG_LEVEL_INFO, "Mail successfully sent to $to");
					}
					else
					{
						//return FALSE;
						le(LOG_LEVEL_INFO, "Mail sending FAILED to " . $to . "::" . var_export($mail, true));
					}
					unset($mail);
			}
	}
?>
