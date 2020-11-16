<?php
define("DB_CONNECTIONS","master,sub");
ini_set('display_errors', 1); 
include_once("../framework/initialise/framework.init.php");
include_once("../framework/initialise/helper.php");
console(LOG_LEVEL_TRACE, "Cell Hourly Report Initiated");
global $library,$request,$db,$curl,$libxml,$log,$viewclass,$mail;
date_default_timezone_set('Africa/Johannesburg');
//echo date("Y-m-d H:i:s");exit;
$fromdate= date("Y-m-d 00:00:00",strtotime("now"));
$todate= date("Y-m-d 23:59:59",strtotime("now"));
$cur_hour = date("H",strtotime("now"));
if($cur_hour!='0')
$sub_pre_hr = $cur_hour - 1 ;
else
$sub_pre_hr =0;
$sub_pre_base_date=date("Y-m-d ".$sub_pre_hr.":59:59",strtotime("now"));
$isbase=isset($request['send_mail'])?'yes':'no';
$today=date('Y-m-d');
//$today='2019-02-06';  
$to=date('Y-m-d',strtotime('-1 day'));
$from=date('Y-m-d', strtotime('-11 days'));
$from10=date('Y-m-d', strtotime('-10 days'));
if($today==date('Y-m-01'))
{
$bt=strtotime(date('Y-m-01',strtotime($today)),time());
$curr_mon=date('Y-m',strtotime('-1 month',$bt));
$prev_mon=date('Y-m',strtotime('-2 month',$bt));
$two_month=date('Y-m',strtotime('-3 month',$bt));
}
else{
$bt=strtotime(date('Y-m-01',strtotime($today)),time());
$curr_mon=date('Y-m',strtotime('-0 month',$bt));
$prev_mon=date('Y-m',strtotime('-1 month',$bt));
$two_month=date('Y-m',strtotime('-2 month',$bt));
}

$prev_date=date('Y-m-d',strtotime('-1 day'));
$check_prev="SELECT count(*) as cnt FROM cellc_flat_copy1 WHERE DATE='".$prev_date."' ";
$res_prev1=$db['master']->getOneRow($check_prev);
if(!isset($request['send_mail']))
	shell_exec("curl -s 'http://13.234.185.60/wap-cellc/HourlyReport/lpstatus_insert.php'");
if($res_prev1['cnt'] == '0')
{
	shell_exec('php cellc_insert_new_copy.php');
	shell_exec('curl -s "http://13.234.185.60/cellc_mis/cellc_service_wise_for_a_day.php?day=1"');
	shell_exec('php ../../cellc_mis/malware_block_day.php');
	shell_exec('php ../../cellc_mis/cellc_agency_wise.php');
	echo 'in';
} 	
$year1 = date("Y",strtotime("now"));
$month1 = date("m",strtotime("now"));
$date1 = date("d",strtotime("now"));
$cur_hour1 = date("H",strtotime("now"));
shell_exec('php ../../cellc_mis/cellc_agency_wise_hourly.php');
shell_exec('php ../../cellc_mis/malware_block_hourly.php');
$file_path_url = "http://13.234.185.60/cellc_mis/cellc_agency_wise_hourly/".$year1."/".$month1."/".$date1."/CELLC_" . $year1 . "_" . $month1 . "_" . $date1 . "_agency_wise_hour_".$cur_hour1.".csv";
$block_link = "http://13.234.185.60/cellc_mis/blocked/hourly/".$year1."/".$month1."/".$date1."/CELLC_" . $year1 . "_" . $month1 . "_" . $date1 . "_blockedcount_hour_".$cur_hour1.".csv";
$varMessage= 'Agency wise counts <a href="'.$file_path_url.'">
 Click here for details</a><br>';
 $varMessage.= 'Malware Blocked counts <a href="'.$block_link.'">
 Click here for details</a><br>';
$cellc_err_arr=array("201"=>"Service Already Exists - <br> Status is Active or Preactivated","202"=>"Insufficient Funds", "203"=>"Subscriber Blacklisted","204"=>"Duplicate Request - Pending<br> subscriber Opt In","206"=>"Charge Error – Permanent","208"=>"Request Error – Permanent","209"=>"Renotify success","210"=>"Renotify exceeded - maximum <br>allowed renotifications exceeded", "211"=>"Renotify Rejected Possible reasons: Subscription <br>does not exist or is not in pending state.", "212"=>"Rejected by Filter –<br> prohibited word" , "213"=>"Maximum allowed <br>charges exceeded","214"=>"Incorrect charge interval", "215"=>"Incorrect Charge Code","216"=>"Invalid MSISDN/<br>Subscriber hotlined/suspended/churned","217"=> "Invalid Content Type","218"=>"Incorrect ServiceName /<br> ContentProvider length","220"=>"Service in Clearing<br> Period - 24 hours","221"=>"Subscription not found","223"=>"Billing Error","224" =>"No service id specified","225"=>"Rejected, Subscriber rejected <br>the subscription, in 24h clearing period","226"=>"Cancelled, Subscription  has <br> been cancelled, in 24h clearing period","227"=>"Churned, Subscriber churned, <br> in 24h clearing period","228"=>"Inactive Subscriber<br>: Returned by CRM","230"=>"Invalid Subscriber: <br> Returned by CRM ");
//echo "<pre>";print_r($cellc_err_arr);echo "</pre>";exit(); 
//echo "<pre>";print_r($db);echo "</pre>";exit();

//
//echo '<pre>';print_r($db);echo '</pre>';exit; 




$cellc_tot_hits=$db['master']->getResults("SELECT COUNT(*) as  tot_hits,
HOUR(CONVERT_TZ(transtime,'+05:30','+02:00')) as hits_hour,packageid ,COUNT(DISTINCT msisdn) AS uniq_hits,COUNT(CASE WHEN `user_status` = 'DND' THEN 1 ELSE NULL END) AS DND,COUNT(CASE WHEN  `user_status` = 'ALREADY ACTIVE' THEN 1 ELSE NULL END) AS AAC  
FROM hit_analysis 
WHERE  CONVERT_TZ(transtime,'+05:30','+02:00') >='".$fromdate."' AND CONVERT_TZ(transtime,'+05:30','+02:00') <='".$todate."'
GROUP BY hits_hour ");      //echo'<pre>'; print_r($cellc_tot_hits); echo'</pre>'; exit;

$cellc_agency_success_hold=$db['master']->getResults("SELECT COUNT(*) as agency_holds,HOUR(CONVERT_TZ(dateandtime,'+05:30','+02:00')) as agency_hour, response 
FROM agent_hit_analysis 
WHERE CONVERT_TZ(dateandtime,'+05:30','+02:00') >='".$fromdate."' AND CONVERT_TZ(dateandtime,'+05:30','+02:00') <='".$todate."' 
 GROUP BY agency_hour, response");
//echo'<pre>'; print_r($cellc_agency_success_hold); echo'</pre>'; exit;
if( $isbase=='no' )
{
	$sub_retry_star_base=$db['sub']->query("INSERT INTO sub_retry_basecount 
											SELECT '',COUNT(*),'".date('Y-m-d')."','".date('H')."' FROM subscription WHERE status_id='4' AND circle_id='4' 
											AND CONVERT_TZ(sub_date,'+05:30','+02:00') <= '".date('Y-m-d H:i:s')."'");
}

											
$sub_retry_current_base=$db['sub']->getResults(" SELECT COUNT(*) as cr_base FROM subscription WHERE status_id='4' AND circle_id='4' 
											    AND CONVERT_TZ(sub_date,'+05:30','+02:00') <= '".date('Y-m-d H:i:s')."' ");
$sub_retry_base=$db['sub']->getResults(" SELECT * FROM sub_retry_basecount WHERE `date`='".date('Y-m-d')."' ");
//echo'<pre>'; print_r($sub_retry_base); echo'</pre>'; exit;
$sub_retry_details=$db['sub']->getResults("SELECT HOUR(CONVERT_TZ(added_on,'+5:30','+2:00')) AS hour_num,COUNT(*) as sub_retry,
SUM(CASE WHEN (error_code = '0' AND (trans_type LIKE '%SubscriptionRetry%' )) THEN 1 ELSE 0 END) AS retry_suc,
SUM(CASE WHEN (error_code = '202' AND (trans_type LIKE '%SubscriptionRetry%' )) THEN 1 ELSE 0 END) AS retry_lb,
SUM(CASE WHEN (error_code != '202' AND error_code != '0' AND (trans_type LIKE '%SubscriptionRetry%' )) THEN 1 ELSE 0 END) AS retry_fail
													  FROM charging_history 
													  WHERE CONVERT_TZ(added_on,'+5:30','+2:00')>='".$fromdate."' AND 
													  CONVERT_TZ(added_on,'+5:30','+2:00')<='".$todate."' AND (trans_type LIKE 'SubscriptionRetry%') 
													  GROUP BY hour_num");


$cg_resp=$db['master']->getResults("	
											SELECT
											HOUR(CONVERT_TZ(transtime,'+05:30','+02:00')) AS `hour_num`,
											COUNT(*) AS cg_cnt,
											SUM(CASE WHEN response = 'success' OR
											response = 'insufficient-balance' THEN 1 ELSE 0 END )AS cg_suc,
											SUM(CASE WHEN response = 'pending' THEN 1 ELSE 0 END )AS cg_pend,
											SUM(CASE WHEN response = 'duplicate' THEN 1 ELSE 0 END )AS cg_dupl,
											SUM(CASE WHEN response = 'failed' THEN 1 ELSE 0 END )AS cg_fail
											FROM subscription_detail
											WHERE packageid IN ('645','646','652','680','681','682','683','684','685','687','688','689','690') 
											AND  CONVERT_TZ(transtime,'+05:30','+02:00') >='".$fromdate."' 
											AND CONVERT_TZ(transtime,'+05:30','+02:00') <='".$todate."'
											AND transactionid LIKE '%SUB%'
											GROUP BY `hour_num`");

$async_resp=$db['sub']->getResults("	
											SELECT HOUR(CONVERT_TZ(response_time,'+05:30','+02:00')) AS `hour_num`,addsub_result,COUNT(*) as asynct 
											FROM subscription_removed 
											WHERE CONVERT_TZ(response_time,'+05:30','+02:00') >='".$fromdate."' 
											AND CONVERT_TZ(response_time,'+05:30','+02:00') <='".$todate."'
											GROUP BY addsub_result,hour_num ");
$cellc_cg_url=$db['sub']->getResults("SELECT COUNT(*) as cg_cnt, 
HOUR(CONVERT_TZ(sub_date,'+05:30','+02:00')) as cg_hour, service_details_id 
FROM subscription 
WHERE CONVERT_TZ(sub_date,'+05:30','+02:00') >='".$fromdate."' AND CONVERT_TZ(sub_date,'+05:30','+02:00') <='".$todate."' 
GROUP BY cg_hour,service_details_id ");
//echo'<pre>'; print_r($cellc_cg_url); echo'</pre>'; exit;


$cellc_subs_succ=$db['sub']->getResults("SELECT COUNT(*), HOUR(added_on) FROM charging_history WHERE DATE(sub_date) = '".$today."' AND error_code = '0' GROUP BY HOUR(added_on)");     




/* $cellc_counts=$db ['sub']->getResults("SELECT HOUR(CONVERT_TZ(ch.added_on,'+05:30','+02:00')) AS hour_val,
SUM(CASE WHEN (ch.error_code = '0' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription%' OR ch.trans_type='Free Trail')) THEN 1 ELSE 0 END) AS sub_success,
SUM(CASE WHEN (ch.error_code = '202' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription%' OR ch.trans_type='Free Trail')) THEN 1 ELSE 0 END) AS sub_low_bal,
SUM(CASE WHEN (ch.error_code = '202' AND (ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%')) THEN 1 ELSE 0 END) AS ren_low_bal,
SUM(CASE WHEN (ch.error_code = '0' AND (ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%')) THEN 1 ELSE 0 END) AS ren_success,
SUM(CASE WHEN(ch.error_code != '0' AND ch.error_code != '202' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription%' OR ch.trans_type='Free Trail'))THEN 1 ELSE 0 END) AS sub_failure,SUM(CASE WHEN(ch.error_code != '0' AND ch.error_code != '202' AND (ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%'))THEN 1 ELSE 0 END) AS ren_failure, SUM(CASE WHEN (ch.error_code = '0' AND ( ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%')) THEN  1 * (sd.charges/100) ELSE 0 END)  AS ren_rev,SUM(CASE WHEN (ch.error_code = '0' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription%' OR ch.trans_type='Free Trail')) THEN  1 * (sd.charges/100) ELSE 0 END)  AS sub_rev FROM charging_history ch LEFT JOIN service_details sd ON ch.service_details_id=sd.service_details_id 
WHERE CONVERT_TZ(ch.added_on,'+05:30','+02:00') >='".$fromdate."' AND CONVERT_TZ(ch.added_on,'+05:30','+02:00') <='".$todate."' 
GROUP BY hour_val"); */     
$cellc_counts=$db ['sub']->getResults("SELECT HOUR(CONVERT_TZ(ch.added_on,'+05:30','+02:00')) AS hour_val,
SUM(CASE WHEN (ch.error_code = '0' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription' OR ch.trans_type='Free Trail')) THEN 1 ELSE 0 END) AS sub_success,
SUM(CASE WHEN (ch.error_code = '202' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription' OR ch.trans_type='Free Trail')) THEN 1 ELSE 0 END) AS sub_low_bal,
SUM(CASE WHEN (ch.error_code = '202' AND (ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%')) THEN 1 ELSE 0 END) AS ren_low_bal,
SUM(CASE WHEN (ch.error_code = '0' AND (ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%')) THEN 1 ELSE 0 END) AS ren_success,
SUM(CASE WHEN(ch.error_code != '0' AND ch.error_code != '202' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription' OR ch.trans_type='Free Trail'))THEN 1 ELSE 0 END) AS sub_failure,SUM(CASE WHEN(ch.error_code != '0' AND ch.error_code != '202' AND (ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%'))THEN 1 ELSE 0 END) AS ren_failure, SUM(CASE WHEN (ch.error_code = '0' AND ( ch.trans_type!='' AND ch.trans_type NOT LIKE 'Subscription%')) THEN  1 * (sd.charges/100) ELSE 0 END)  AS ren_rev,SUM(CASE WHEN (ch.error_code = '0' AND (ch.trans_type='' OR ch.trans_type LIKE 'Subscription%' OR ch.trans_type='Free Trail')) THEN  1 * (sd.charges/100) ELSE 0 END)  AS sub_rev FROM charging_history ch LEFT JOIN service_details sd ON ch.service_details_id=sd.service_details_id 
WHERE CONVERT_TZ(ch.added_on,'+05:30','+02:00') >='".$fromdate."' AND CONVERT_TZ(ch.added_on,'+05:30','+02:00') <='".$todate."' 
GROUP BY hour_val");
    
$cur_time=date("H:i",strtotime("now"));

		$insert_base=$db ['sub']->query("INSERT INTO basecount(`date`,base_count) SELECT DATE(CONVERT_TZ(NOW(),'+05:30','+02:00')),COUNT(1) AS `base_count` FROM subscription WHERE status_id IN(1,4) AND circle_id !='4' AND DATE(CONVERT_TZ(exp_date,'+05:30','+02:00'))<='".$today."' ");
		console(LOG_LEVEL_TRACE, "basecount from::".$insert_base['base_count']);
	
$cellc_base=$db ['sub']->getResults("SELECT * FROM basecount where date='".$today."' ");
//echo'<pre>'; print_r($cellc_base); echo'</pre>'; exit;
console(LOG_LEVEL_TRACE, "basecount flat table::".var_export($cellc_base, true));
$start_base=isset($cellc_base[0]['base_count'])?$cellc_base[0]['base_count']:"0";

$cellc_deact_cust_one=$db ['sub']->getResults("SELECT HOUR(CONVERT_TZ(sh.unsub_date,'+05:30','+02:00')) AS `hour1`,COUNT(1) as cust_ones FROM subscription_history sh WHERE sh.deact_mode_id!='0' AND DATE(CONVERT_TZ(sh.unsub_date,'+05:30','+02:00'))='".$today."' GROUP BY `hour1`");//echo'<pre>'; print_r($cellc_deact_cust_one); echo'</pre>'; exit

$cellc_deact_cust_two=$db ['sub']->getResults("SELECT HOUR(CONVERT_TZ(ch.added_on,'+05:30','+02:00')) AS `hour2`,COUNT(1) as cust_second FROM charging_history ch WHERE ch.error_code='221' AND DATE(CONVERT_TZ(ch.added_on,'+05:30','+02:00'))='".$today."' GROUP BY `hour2`"); //echo'<pre>'; print_r($cellc_deact_cust_two); echo'</pre>'; exit;

$cellc_deact_sameday_one=$db ['sub']->getResults("SELECT HOUR(CONVERT_TZ(sh.unsub_date,'+05:30','+02:00')) AS `hour1`,COUNT(1) as deact_ones FROM subscription_history sh WHERE sh.deact_mode_id!='0' AND DATE(sh.unsub_date)='".$today."' AND DATE(CONVERT_TZ(sh.unsub_date,'+05:30','+02:00'))=DATE(CONVERT_TZ(sh.sub_date,'+05:30','+02:00')) GROUP BY HOUR(sh.unsub_date)");

$cellc_deact_sameday_two=$db ['sub']->getResults("SELECT HOUR(CONVERT_TZ(ch.added_on,'+05:30','+02:00')) AS `hour2`,COUNT(1) as deact_second FROM charging_history ch WHERE ch.error_code='221' AND DATE(ch.added_on)='".$today."' AND DATE(CONVERT_TZ(ch.added_on,'+05:30','+02:00'))=DATE(CONVERT_TZ(ch.sub_date,'+05:30','+02:00')) GROUP BY `hour2`");

$cellc_hourlyavg=$db['sub']->getResults("SELECT bill_hour, ROUND(SUM(amount)) as rev_avg FROM hourly_bill WHERE bill_date >= (CURDATE() - INTERVAL 60 DAY) GROUP BY bill_hour");

foreach($cellc_hourlyavg as $val)
{
	$dt1[$val['bill_hour']]['rev_avg'] = round(($val['rev_avg']/60),2);
}

$varMessage = $varMessage.'<h3>CELLC Hourly Report - '. $fromdate.' To '. date("Y-m-d H:i:s",strtotime("now")).'</h3>
					<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">
						<span style="color: red;">IST</span> - Indian Standard Time,
						<span style="color: red;">SAST</span> - South Africa Standard Time,
						<span style="color: red;">TH</span> - Total hits,
						<span style="color: red;">NCS</span> - Not Clicked Subscription button on LP,
						<span style="color: red;">RTCG</span> - Redirect To CG,
						<span style="color: red;">CG RESP</span> - Response from CG,
						<span style="color: red;">Succ</span> - Success,
						<span style="color: red;">Fail</span> - Failed,
						<span style="color: red;">Dup</span> - Duplicate,	
						<span style="color: red;">Pend</span> - Pending,	
						<span style="color: red;">ACT</span> - Active,
						<span style="color: red;">RJC</span> - Rejected,
						<span style="color: red;">CNC</span> - Canceled,
						<span style="color: red;">EXP</span> - Expired,
						<span style="color: red;">CHR</span> - Churned,
						<span style="color: red;">AS</span> -Agency Success ,
						<span style="color: red;">AH</span> -Agency Hold ,
						<span style="color: red;">Sub Retry</span> -Subscription Retry ,
						<span style="color: red;">SRB</span> -Subscription Retry Base,
						<span style="color: red;">SRC</span> -Subscription Retry Count,
						<span style="color: red;">Succ</span> -Success ,
						<span style="color: red;">LB</span> -Low Balance ,
						<span style="color: red;">Fail</span> -Failure ,
						<span style="color: red;">Tot</span> -Total ,
						<span style="color: red;">Sub</span> - Subscription,
						<span style="color: red;">Ren</span> - Renewal,
						<span style="color: red;">Ren Count</span> - Renewal Count,
						<span style="color: red;">Ren Count</span> - Renewal Count,
						<span style="color: red;">Cust</span> -Customer ,
						<span style="color: red;">SD</span> -Same Day ,
						<span style="color: red;">Sub Rev</span> - Subscription Revenue,
						<span style="color: red;">Ren Rev</span> - Renewal Revenue,
						<span style="color: red;">Tot Rev</span> - Total Revenue,
						<span style="color: red;">AVG Rev</span> - last  60 days average Revenue
					</i>
	<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="45" ;>CELLC Hourly Report - '. $fromdate.' To '. date("Y-m-d H:i:s",strtotime("now")).'</th>
	   </tr>
	   <tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="3";>SAST </br>Hour</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="3";>IST </br>Hour</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="3";>TH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="3";>NCS</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="3";>RTCG</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="5";>CG RESP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="6";>ASYNC RESP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="3";>AS</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="3";>AH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="5";>Sub Retry</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="4";>Sub Count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="4";>Ren count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="7";>Availibilty</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="3";>Deactivation</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="3";>Sub <br>Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="3";>Ren<br> Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="3";>Tot<br> Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="3";>AVG<br> Rev</th>
		</tr>
		<tr>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Succ</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>fail</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Dup</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Pend</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Tot</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>ACT</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>RJC</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>CNC</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>EXP</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>CHR</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Tot</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>SRB</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>SRC</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Succ</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>LB</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Fail</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Succ</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>LB</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Fail</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Tot</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Succ</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>LB</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Fail</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Tot</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" colspan="3";>Base</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" rowspan="2";>Tot</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" rowspan="2";>Succ</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" rowspan="2";>LB</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" rowspan="2";>Fail</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" rowspan="2";>Cust</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" rowspan="2";>SD</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" rowspan="2";>Tot</th>
	 </tr>
	<tr> 
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center">Ren</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center">Sub</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center">Tot</th>
		
	</tr>';
	
	  $ren_avail=$sub_avail=$total_avail=0;
		foreach($cellc_tot_hits as $val){
			$dt[$val['hits_hour']]['tot_hits']=$val['tot_hits'];
			$dt[$val['hits_hour']]['uniq_hits']=$val['uniq_hits'];
			$dt[$val['hits_hour']]['DND']=$val['DND'];
			$dt[$val['hits_hour']]['AAC']=$val['AAC'];
		}
		foreach($cellc_agency_success_hold as $val){
			$dt[$val['agency_hour']][$val['response']]['agency_holds']=$val['agency_holds'];	
		}
		foreach($sub_retry_base as $val){
			$dt[$val['hour']]['sub_base']=$val['base_count'];	
		}
		/* foreach($sub_retry_current_base as $val){
			$dt[$cur_hour]['sub_base']=$val['cr_base'];	
		} */
		foreach($sub_retry_details as $val){
			$dt[$val['hour_num']]['sub_retry']=$val['sub_retry'];	
			$dt[$val['hour_num']]['retry_suc']=$val['retry_suc'];	
			$dt[$val['hour_num']]['retry_lb']=$val['retry_lb'];	
			$dt[$val['hour_num']]['retry_fail']=$val['retry_fail'];	
		}
		foreach($cg_resp as $val){
			$dt[$val['hour_num']]['cg_cnt']=$val['cg_cnt'];	
		}
	
		foreach($cg_resp as $val){
			$dt[$val['hour_num']]['cg_cnt1']=$val['cg_cnt1'];	 
			$dt[$val['hour_num']]['cg_suc']=$val['cg_suc'];
			$dt[$val['hour_num']]['cg_pend']=$val['cg_pend'];
			$dt[$val['hour_num']]['cg_dupl']=$val['cg_dupl'];
			$dt[$val['hour_num']]['cg_fail']=$val['cg_fail'];
		}
		foreach($async_resp as $val){
			if($val['addsub_result']=='active')
				$dt[$val['hour_num']]['active']=$val['asynct'];
			if($val['addsub_result']=='cancelled')
				$dt[$val['hour_num']]['cancelled']=$val['asynct'];
			if($val['addsub_result']=='rejected')
				$dt[$val['hour_num']]['rejected']=$val['asynct'];
			if($val['addsub_result']=='expired')
				$dt[$val['hour_num']]['expired']=$val['asynct'];
			if($val['addsub_result']=='churned')
				$dt[$val['hour_num']]['churned']=$val['asynct'];
		}
		foreach($cellc_deact_cust_one as $val){
			$dt[$val['hour1']]['cust_ones']=$val['cust_ones'];
		}
		foreach($cellc_deact_cust_two as $val){
			$dt[$val['hour2']]['cust_second']=$val['cust_second'];
		}
		foreach($cellc_deact_sameday_one as $val){
			$dt[$val['hour1']]['deact_ones']=$val['deact_ones'];
		}
		foreach($cellc_deact_sameday_two as $val){
			$dt[$val['hour2']]['deact_second']=$val['deact_second'];
		}
		
		
		//print_r($dt);exit;
	
		foreach($cellc_counts as $val){
			$dt1[$val['hour_val']]['sub_success']=$val['sub_success'];
			$dt1[$val['hour_val']]['sub_low_bal']=$val['sub_low_bal'];
			$dt1[$val['hour_val']]['ren_low_bal']=$val['ren_low_bal'];
			$dt1[$val['hour_val']]['ren_success']=$val['ren_success'];
			$dt1[$val['hour_val']]['sub_failure']=$val['sub_failure'];
			$dt1[$val['hour_val']]['ren_failure']=$val['ren_failure'];
			$dt1[$val['hour_val']]['sub_rev']=$val['sub_rev'];
			$dt1[$val['hour_val']]['ren_rev']=$val['ren_rev'];
		}
		
		for($i=0;$i<=$cur_hour;$i++){
			if($i>=0 && $i<=9)
				$si="0$i";
			else
				$si=$i;
				if($i==0){
						$tot_hits_val=isset($dt[$i]["tot_hits"])?$dt[$i]["tot_hits"]:"0";
						
						$uni_hits=isset($dt[$i]["uniq_hits"])?$dt[$i]["uniq_hits"]:"0";
						$aac=isset($dt[$i]["AAC"])?$dt[$i]["AAC"]:"0";
						$dnd=isset($dt[$i]["DND"])?$dt[$i]["DND"]:"0";
						
						$agency_succ_count=isset($dt[$i]["Success"]["agency_holds"])?$dt[$i]["Success"]["agency_holds"]:"0";
						$agency_hold_count=isset($dt[$i]["HOLD"]["agency_holds"])?$dt[$i]["HOLD"]["agency_holds"]:"0";
						$subs_retry_basect=isset($dt[$si]["sub_base"])?$dt[$si]["sub_base"]:"0";
						$subs_retry_ct=isset($dt[$i]["sub_retry"])?$dt[$i]["sub_retry"]:"0";
						$subs_retry_suc=isset($dt[$i]["retry_suc"])?$dt[$i]["retry_suc"]:"0";
						$subs_retry_lb=isset($dt[$i]["retry_lb"])?$dt[$i]["retry_lb"]:"0";
						$subs_retry_fail=isset($dt[$i]["retry_fail"])?$dt[$i]["retry_fail"]:"0";
						$redirect_cg_cnt=isset($dt[$i]["cg_cnt"])?$dt[$i]["cg_cnt"]:"0";
						
						$cg_suc=isset($dt[$i]["cg_suc"])?$dt[$i]["cg_suc"]:"0";
						$cg_fail=isset($dt[$i]["cg_fail"])?$dt[$i]["cg_fail"]:"0";
						$cg_nr=isset($dt[$i]["cg_pend"])?$dt[$i]["cg_pend"]:"0";
						$cg_dupl=isset($dt[$i]["cg_dupl"])?$dt[$i]["cg_dupl"]:"0";
						$tot_sync_cnt=$cg_suc+$cg_fail+$cg_nr+$cg_dupl;
						
						$aync_act=isset($dt[$i]["active"])?$dt[$i]["active"]:"0";
						$aync_cnc=isset($dt[$i]["cancelled"])?$dt[$i]["cancelled"]:"0";
						$aync_rjc=isset($dt[$i]["rejected"])?$dt[$i]["rejected"]:"0";
						$aync_exp=isset($dt[$i]["expired"])?$dt[$i]["expired"]:"0";
						$aync_chr=isset($dt[$i]["churned"])?$dt[$i]["churned"]:"0";
						$tot_hr_asyn=$aync_act+$aync_cnc+$aync_rjc+$aync_exp+$aync_chr;
						
						$ncs=$tot_hits_val-($aac+$dnd+$redirect_cg_cnt);
						if($ncs < 0)
							$ncs=0;
						
						$tot_subs_val=isset($dt1[$i]["sub_success"])?$dt1[$i]["sub_success"]:"0";
						$sub_low_bals=isset($dt1[$i]["sub_low_bal"])?$dt1[$i]["sub_low_bal"]:"0";
						$sub_fail=isset($dt1[$i]["sub_failure"])?$dt1[$i]["sub_failure"]:"0";
						$sub_total=$tot_subs_val+$sub_low_bals+$sub_fail;
						$tot_ren_val=isset($dt1[$i]["ren_success"])?$dt1[$i]["ren_success"]:"0";
						$tot_success=$tot_subs_val+$tot_ren_val;
						$ren_low_bals=isset($dt1[$i]["ren_low_bal"])?$dt1[$i]["ren_low_bal"]:"0";
						$tot_low_bal=$sub_low_bals+$ren_low_bals;
						$ren_fail=isset($dt1[$i]["ren_failure"])?$dt1[$i]["ren_failure"]:"0";
						$ren_total=$tot_ren_val+$ren_low_bals+$ren_fail;
						$tot_fail_cnt=$sub_fail+$ren_fail;
						$deact_cust_one=isset($dt[$i]["cust_ones"])?$dt[$i]["cust_ones"]:"0";
						$deact_cust_two=isset($dt[$i]["cust_second"])?$dt[$i]["cust_second"]:"0";
						$deact_customer=$deact_cust_one+$deact_cust_two;
						$deact_sameday_one=isset($dt[$i]["deact_ones"])?$dt[$i]["deact_ones"]:"0";
						$deact_sameday_two=isset($dt[$i]["deact_second"])?$dt[$i]["deact_second"]:"0";
						$deact_same_day=$deact_sameday_one+	$deact_sameday_two;
						$deact_totals=$deact_customer+$deact_same_day;						
						$totals=$tot_success+$tot_low_bal+$tot_fail_cnt; 
						$tot_sub_rev_val=isset($dt1[$i]["sub_rev"])?$dt1[$i]["sub_rev"]:"0";
						$tot_ren_rev_val=isset($dt1[$i]["ren_rev"])?$dt1[$i]["ren_rev"]:"0";
						$tot_total_rev_val=$tot_sub_rev_val+$tot_ren_rev_val;
					
						$ren_avail=$start_base;
						$sub_avail=$sub_low_bals+$sub_fail;
						$total_avail=$ren_avail+$sub_avail;
						$avg_revenue=isset($dt1[$i]["rev_avg"])?$dt1[$i]["rev_avg"]:"0";
					}else{
						$tot_hits_val=isset($dt[$i]["tot_hits"])?$dt[$i]["tot_hits"]:"0";
						$uni_hits=isset($dt[$i]["uniq_hits"])?$dt[$i]["uniq_hits"]:"0";
						$aac=isset($dt[$i]["AAC"])?$dt[$i]["AAC"]:"0";
						$dnd=isset($dt[$i]["DND"])?$dt[$i]["DND"]:"0";
						$agency_succ_count=isset($dt[$i]["Success"]["agency_holds"])?$dt[$i]["Success"]["agency_holds"]:"0";
						$agency_hold_count=isset($dt[$i]["HOLD"]["agency_holds"])?$dt[$i]["HOLD"]["agency_holds"]:"0";
						$subs_retry_basect=isset($dt[$si]["sub_base"])?$dt[$si]["sub_base"]:"0";
						$subs_retry_ct=isset($dt[$i]["sub_retry"])?$dt[$i]["sub_retry"]:"0";
						$subs_retry_suc=isset($dt[$i]["retry_suc"])?$dt[$i]["retry_suc"]:"0";
						$subs_retry_lb=isset($dt[$i]["retry_lb"])?$dt[$i]["retry_lb"]:"0";
						$subs_retry_fail=isset($dt[$i]["retry_fail"])?$dt[$i]["retry_fail"]:"0";
						$redirect_cg_cnt=isset($dt[$i]["cg_cnt"])?$dt[$i]["cg_cnt"]:"0";
						$cg_suc=isset($dt[$i]["cg_suc"])?$dt[$i]["cg_suc"]:"0";
						$cg_fail=isset($dt[$i]["cg_fail"])?$dt[$i]["cg_fail"]:"0";
						$cg_nr=isset($dt[$i]["cg_pend"])?$dt[$i]["cg_pend"]:"0";
						$cg_dupl=isset($dt[$i]["cg_dupl"])?$dt[$i]["cg_dupl"]:"0";
						$tot_sync_cnt=$cg_suc+$cg_fail+$cg_nr+$cg_dupl;
						
						$aync_act=isset($dt[$i]["active"])?$dt[$i]["active"]:"0";
						$aync_cnc=isset($dt[$i]["cancelled"])?$dt[$i]["cancelled"]:"0";
						$aync_rjc=isset($dt[$i]["rejected"])?$dt[$i]["rejected"]:"0";
						$aync_exp=isset($dt[$i]["expired"])?$dt[$i]["expired"]:"0";
						$aync_chr=isset($dt[$i]["churned"])?$dt[$i]["churned"]:"0";
						$tot_hr_asyn=$aync_act+$aync_cnc+$aync_rjc+$aync_exp+$aync_chr;
						
						$ncs=$tot_hits_val-($aac+$dnd+$redirect_cg_cnt);
						if($ncs < 0)
							$ncs=0;
						$tot_subs_val=isset($dt1[$i]["sub_success"])?$dt1[$i]["sub_success"]:"0";
						$sub_low_bals=isset($dt1[$i]["sub_low_bal"])?$dt1[$i]["sub_low_bal"]:"0";
						$sub_fail=isset($dt1[$i]["sub_failure"])?$dt1[$i]["sub_failure"]:"0";
						$sub_total=$tot_subs_val+$sub_low_bals+$sub_fail;
						$tot_ren_val=isset($dt1[$i]["ren_success"])?$dt1[$i]["ren_success"]:"0";
						$tot_success=$tot_subs_val+$tot_ren_val;
						$ren_low_bals=isset($dt1[$i]["ren_low_bal"])?$dt1[$i]["ren_low_bal"]:"0";
						$tot_low_bal=$sub_low_bals+$ren_low_bals;
						$ren_fail=isset($dt1[$i]["ren_failure"])?$dt1[$i]["ren_failure"]:"0";
						$ren_total=$tot_ren_val+$ren_low_bals+$ren_fail;
						$tot_fail_cnt=$sub_fail+$ren_fail;
						$deact_cust_one=isset($dt[$i]["cust_ones"])?$dt[$i]["cust_ones"]:"0";
						$deact_cust_two=isset($dt[$i]["cust_second"])?$dt[$i]["cust_second"]:"0";
						$deact_customer=$deact_cust_one+$deact_cust_two;
						$deact_sameday_one=isset($dt[$i]["deact_ones"])?$dt[$i]["deact_ones"]:"0";
						$deact_sameday_two=isset($dt[$i]["deact_second"])?$dt[$i]["deact_second"]:"0";
						$deact_same_day=$deact_sameday_one+	$deact_sameday_two;
						$deact_totals=$deact_customer+$deact_same_day;						
						$totals=$tot_success+$tot_low_bal+$tot_fail_cnt; 
						$tot_sub_rev_val=isset($dt1[$i]["sub_rev"])?$dt1[$i]["sub_rev"]:"0";
						$tot_ren_rev_val=isset($dt1[$i]["ren_rev"])?$dt1[$i]["ren_rev"]:"0";
						$tot_total_rev_val=$tot_sub_rev_val+$tot_ren_rev_val;
						$tot_subs_val_prev=isset($dt1[$i-1]["sub_success"])?$dt1[$i-1]["sub_success"]:"0";
						$tot_ren_val_prev=isset($dt1[$i-1]["ren_success"])?$dt1[$i-1]["ren_success"]:"0";
						$tot_success_prev=$tot_subs_val_prev+$tot_ren_val_prev;
						
						$ren_avail=$total_avail-$tot_success_prev;
						$sub_avail=$sub_low_bals+$sub_fail;
						$total_avail=$ren_avail+$sub_avail;
						$avg_revenue=isset($dt1[$i]["rev_avg"])?$dt1[$i]["rev_avg"]:"0";
					}
					
		
			$gmttimeval = date("H:i", strtotime($today." ".$i.":00:00 +210 minutes"));
	$varMessage.='<tr>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$i.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$gmttimeval.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_total_hits[]=$tot_hits_val.'</td>';
	
	/* $varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_uniq[]=$uni_hits.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">'.$tot_aac[]=$aac.'<p align="center"></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">'.$tot_dnd[]=$dnd.'<p align="center"></td>';
	 */
	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">'.$tot_ncs[]=$ncs.'<p align="center"></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_url[]=$redirect_cg_cnt.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_suc[]=$cg_suc.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_fail[]=$cg_fail.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_dupl[]=$cg_dupl.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_nr[]=$cg_nr.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_syn_cg[]=$tot_sync_cnt.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_aact[]=$aync_act.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_arjc[]=$aync_rjc.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_acnc[]=$aync_cnc.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_aexp[]=$aync_exp.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_achr[]=$aync_chr.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_asyn_resp[]=$tot_hr_asyn.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agency_success[]=$agency_succ_count.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agency_hold[]=$agency_hold_count.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_retry_basect[]=$subs_retry_basect.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_retry_ct[]=$subs_retry_ct.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_retry_suc[]=$subs_retry_suc.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_retry_lb[]=$subs_retry_lb.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_retry_fail[]=$subs_retry_fail.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_cnts[]=$tot_subs_val.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_lowbal[]=$sub_low_bals.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_fail[]=$sub_fail.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_total[]=$sub_total.'</td>
	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_cnts[]=$tot_ren_val.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_lowbal[]=$ren_low_bals.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_fail[]=$ren_fail.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_total[]=$ren_total.'</td>
	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_avails[]=$ren_avail.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_avails[]=$sub_avail.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_avails_total[]=$total_avail.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_total[]=$totals.'</td>
	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cnts_total[]=$tot_success.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_lowbal_total[]=$tot_low_bal.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_fail_total[]=$tot_fail_cnt.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deact_cust[]=$deact_customer.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deact_sameday[]=$deact_same_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deact_totals[]=$deact_totals.'</td>
	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_revs[]=$tot_sub_rev_val.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_revs[]=$tot_ren_rev_val.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_total_revenue_cnts[]=$tot_total_rev_val.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$total_avg[]=$avg_revenue.'</td>
	</tr>';
				
	}   
	
	
	 $varMessage.='<tr><td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;" colspan="2"><p align="center"><strong>Total</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_total_hits).'</strong></td>';
	/* $varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_uniq).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_aac).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_dnd).'</strong></td>'; */
	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ncs).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_url).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_suc).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_fail).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_dupl).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_nr).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_syn_cg).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_aact).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_arjc).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_acnc).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_aexp).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_achr).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_asyn_resp).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agency_success).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agency_hold).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong></strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_retry_ct).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_retry_suc).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_retry_lb).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_retry_fail).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong></strong>'.array_sum($tot_sub_cnts).'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sub_lowbal).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sub_fail).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sub_total).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_cnts).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_lowbal).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_fail).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_total).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong></strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong></strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong></strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_total).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cnts_total).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_lowbal_total).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_fail_total).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deact_cust).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deact_sameday).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deact_totals).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sub_revs).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_revs).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_total_revenue_cnts).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($total_avg).'</strong></td>
	</tr>';
 
	$varMessage = $varMessage.'</table>';
//echo $varMessage;exit;

$cellc_dynamic_lb=$db['master']->getResults("SELECT HOUR(CONVERT_TZ(transtime,'+05:30','+02:00')) AS hour_num ,packageid,pageid,COUNT(*) as lpc  FROM hit_analysis WHERE DATE(CONVERT_TZ(transtime,'+05:30','+02:00'))='".$today."' GROUP BY packageid,pageid,hour_num");
//print_r($cellc_dynamic_lb);
foreach($cellc_dynamic_lb as $val)
{
	if($val['packageid']=='645' || $val['packageid']=='682' || $val['packageid']=='683')
	{
		$dt[$val['hour_num']]['game']=$val['pageid'];
		$dt[$val['hour_num']]['gamec']=$val['lpc'];
	}
	if($val['packageid']=='646' || $val['packageid']=='680' || $val['packageid']=='681')
	{
		$dt[$val['hour_num']]['glam']=$val['pageid'];
		$dt[$val['hour_num']]['glamc']=$val['lpc'];
	}
}




$varMessage = $varMessage.'<h3>CELLC DynamicLP Hourly Report - '. $fromdate.' To '. date("Y-m-d H:i:s",strtotime("now")).'</h3>
					<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">
						<span style="color: red;">LPID</span> - Landing Pageid </i>
						
						<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="6" ;>CELLC DynamicLP Hourly Report - '. $fromdate.' To '. date("Y-m-d H:i:s",strtotime("now")).'</th>
	   </tr>
	   <tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="2";>SAST </br>Hour</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="2";>IST </br>Hour</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="1" colspan="2";>GameZone</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="1" colspan="2";>Glamour</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="1" ;>LPID</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="1" ;>Count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="1" ;>LPID</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="1" ;>Count</th>
			
		</tr>
						';
		for($i=0;$i<=$cur_hour;$i++)
		{
			$gamelp=isset($dt[$i]["game"])?$dt[$i]["game"]:"0";
			$gamelpc=isset($dt[$i]["game"])?$dt[$i]["gamec"]:"0";
			$glamlp=isset($dt[$i]["glam"])?$dt[$i]["glam"]:"0";
			$glamlpc=isset($dt[$i]["glamc"])?$dt[$i]["glamc"]:"0";
			
			$gmttimeval = date("H:i", strtotime($today." ".$i.":00:00 +210 minutes"));
			$varMessage.='<tr>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$i.'</td>	
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$gmttimeval.'</td>	
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$gamelp.'</td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$gamelpc.'</td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$glamlp.'</td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$glamlpc.'</td></tr>';
		}
			$varMessage.='</table>';
						//echo $varMessage;
		$dynamicpack="SELECT packageid FROM lpstatus WHERE date='".date('Y-m-d')."' GROUP BY packageid";
$packs=$db['sub']->getResults($dynamicpack);

$dynamicagency="SELECT agency FROM lpstatus WHERE date='".date('Y-m-d')."' GROUP BY agency";
$agent=$db['sub']->getResults($dynamicagency);
//$rc=0;
foreach($packs as $val)
{
	$resr=$db['sub']->getResults("SELECT agency FROM lpstatus WHERE date='".date('Y-m-d')."' and packageid='".$val['packageid']."' GROUP BY agency");
	$rc1[]=count($resr);
	$packwiseagency_arr[]=$resr;
	$packwiseagency_arr1[$val['packageid']]=$resr;
	$sp[$val['packageid']]['span']=count($resr);
}
$rc=array_sum($rc1);
$varMessage = $varMessage.'<h3>CELLC LP Status Hourly Report - '. $fromdate.' To '. date("Y-m-d H:i:s",strtotime("now")).'</h3>
					<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">
						<span style="color: red;">" - "</span> -No Hits Received ,
						<span style="color: red;">ON</span> - Landing page On ,
						<span style="color: red;">OFF</span> - Landing page Off 
						<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="'.(3+$rc).'" ;>CELLC LP Status Hourly Report - '. $fromdate.' To '. date("Y-m-d H:i:s",strtotime("now")).'</th>
	   </tr>
	   <tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="2";>SAST </br>Hour</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="2";>IST </br>Hour</th>';
          foreach($packs as $val)
		  {
			  $varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" colspan="'.$sp[$val['packageid']]['span'].'";>'.$val['packageid'].'</th>';
		  }
		  $varMessage.='</tr><tr>';
		  foreach($packwiseagency_arr as $val)
		  {	
			foreach($val as $val1)
			{	
				$varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="1";>'.$val1['agency'].'</th>';
			}
		  }
		  $varMessage.='</tr>';
		  
		  
		  $flatdata=$db['sub']->getResults("SELECT * FROM lpstatus WHERE date='".date('Y-m-d')."'");
		  foreach($flatdata as $val)
		  {
			  $lpst[$val['hour']][$val['packageid']][$val['agency']]=$val['lpstatus'];
		  }
		  $lh=date('H');
		  //$lh=(int)$lh1;
		  //print_r($dt1);
		  for($i=0;$i<=$lh;$i++)
		  {
			  $gmttimeval = date("H:i", strtotime($today." ".$i.":00:00 +210 minutes"));
				$varMessage.='<tr>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$i.'</td>	
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$gmttimeval.'</td>	';
			  foreach($packs  as $val)
			  {
				  foreach($packwiseagency_arr1[$val['packageid']] as $val1)
				  {
					  $status_str=isset($lpst[$i][$val['packageid']][$val1['agency']]) ? $lpst[$i][$val['packageid']][$val1['agency']] : '-' ;
					  $varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$status_str.'</td>';
				  }
			  }
			  
			$varMessage.='</tr>'; 
		  }

$varMessage.='</table>'; 


//$fromdate ='2018-11-07 00:00:00';
//$todate='2018-11-07 23:59:59';

	/*last 10 days*/ 
	$cellc_ten_days=$db['master']->getResults("SELECT * FROM cellc_flat_copy1 WHERE `date`>='".$from10."' GROUP BY `date` ");
	//echo '<pre>';print_r($cellc_ten_days);echo '</pre>';exit;
	$varMessage = $varMessage.'<h3>CELLC - Last 10 Days</h3>
					
	<table border="1" cellspacing="0" cellpadding="0" >
	<tr><th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="36" ;>CELLC - Last 10 Days</th></tr><tr>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="2";>Date</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>TH</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>NCS</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>RTCG</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="5";>CG RESP</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="6";>ASYNC RESP</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>AS</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>AH</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="5";>Sub Retry</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="4";>Sub Count</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="4";>Ren count</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="3";>Deactivation</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Sub <br>Rev</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Ren<br> Rev</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Tot<br> Rev</th>
	</tr><tr>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Succ</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">fail</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Dup</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Pend</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Tot</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">ACT</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">RJC</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">CNC</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">EXP</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">CHR</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Tot</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">SRB</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">SRC</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Succ</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">LB</th>
		<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Fail</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Succ</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >LB</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Fail</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Tot</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Succ</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >LB</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Fail</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Tot</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" >Cust</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" >SD</th>
	<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" >Tot</th></tr>';
			

	 //echo'<pre>'; print_r($cellc_ten_days);echo '</pre>';exit;
	 foreach($cellc_ten_days as $val){
			$dts[$val['date']]['total_hits']=$val['total_hits'];
			$dts[$val['date']]['uniq_hits']=$val['uniq_hits'];
			$dts[$val['date']]['aac']=$val['aac'];
			$dts[$val['date']]['dnd']=$val['dnd'];
		 
			$dts[$val['date']]['sub_low_balance']=$val['sub_low_balance'];
			$dts[$val['date']]['sub_failure_count']=$val['sub_failure_count'];
		   
		    $dts[$val['date']]['redirect_cg']=$val['redirect_cg'];
			
			$dts[$val['date']]['cg_suc']=$val['cg_suc'];
			$dts[$val['date']]['cg_fail']=$val['cg_fail'];
			$dts[$val['date']]['cg_pend']=$val['cg_pend'];
			$dts[$val['date']]['cg_dup']=$val['cg_dup'];
			$dts[$val['date']]["asyn_act"]=$val['asyn_act'];
			$dts[$val['date']]["asyn_cnc"]=$val['asyn_cnc'];
			$dts[$val['date']]["asyn_rjc"]=$val['asyn_rjc'];
			$dts[$val['date']]["asyn_exp"]=$val['asyn_exp'];
			$dts[$val['date']]["asyn_chr"]=$val['asyn_chr'];
			
			$dts[$val['date']]['ag_succ']=$val['ag_succ'];
			$dts[$val['date']]['ag_hold']=$val['ag_hold'];
			$dts[$val['date']]['sub_base']=$val['sub_base'];
			$dts[$val['date']]['sub_retry']=$val['sub_retry'];
			$dts[$val['date']]['sub_retry_suc']=$val['sub_retry_suc'];
			$dts[$val['date']]['sub_retry_lb']=$val['sub_retry_lb'];
			$dts[$val['date']]['sub_retry_fail']=$val['sub_retry_fail'];
			$dts[$val['date']]['sub_count']=$val['sub_count']; 
			$dts[$val['date']]['ren_count']=$val['ren_count'];
		  
			$dts[$val['date']]['sub_revenue']=$val['sub_revenue'];
			$dts[$val['date']]['ren_revenue']=$val['ren_revenue'];
			$dts[$val['date']]['ren_low_balance']=$val['ren_low_balance'];
			$dts[$val['date']]['ren_failure_count']=$val['ren_failure_count'];
			$dts[$val['date']]['deact_customer']=$val['deact_customer'];
			$dts[$val['date']]['deact_sameday']=$val['deact_sameday'];
	}
	
$date_range=array();
//array_push($date_range,$today);
array_push($date_range,$to);
	for($j=1;$j<=9;$j++){
		//array_push($date_range,date('Y-m-d', strtotime("-".$j." day",strtotime ($today))));
		array_push($date_range,date('Y-m-d', strtotime("-".$j." day",strtotime ($to))));
}
//array_push($date_range,$from);

foreach($date_range as $val){
		$tot_hits_ten_day=isset($dts[$val]["total_hits"])?$dts[$val]["total_hits"]:"0";
		$uni_hits_ten_day=isset($dts[$val]["uniq_hits"])?$dts[$val]["uniq_hits"]:"0";
		$aac_ten_day=isset($dts[$val]["aac"])?$dts[$val]["aac"]:"0";
		$dnd_ten_day=isset($dts[$val]["dnd"])?$dts[$val]["dnd"]:"0";
		$agency_succ_count_ten_day=isset($dts[$val]["ag_succ"])?$dts[$val]["ag_succ"]:"0";
		$agency_hold_count_ten_day=isset($dts[$val]["ag_hold"])?$dts[$val]["ag_hold"]:"0";
		$ten_sub_retry_base=isset($dts[$val]["sub_base"])?$dts[$val]["sub_base"]:"0";
		$ten_sub_retry=isset($dts[$val]["sub_retry"])?$dts[$val]["sub_retry"]:"0";
		$ten_sub_retry_suc=isset($dts[$val]["sub_retry_suc"])?$dts[$val]["sub_retry_suc"]:"0";
		$ten_sub_retry_lb=isset($dts[$val]["sub_retry_lb"])?$dts[$val]["sub_retry_lb"]:"0";
		$ten_sub_retry_fail=isset($dts[$val]["sub_retry_fail"])?$dts[$val]["sub_retry_fail"]:"0";
		$redirect_cg_cnt_ten_day=isset($dts[$val]["redirect_cg"])?$dts[$val]["redirect_cg"]:"0";
		
		$cgsuc_ten=isset($dts[$val]["cg_suc"])?$dts[$val]["cg_suc"]:"0";
		$cgfail_ten=isset($dts[$val]["cg_fail"])?$dts[$val]["cg_fail"]:"0";
		$cgdup_ten=isset($dts[$val]["cg_dup"])?$dts[$val]["cg_dup"]:"0";
		$cgpend_ten=isset($dts[$val]["cg_pend"])?$dts[$val]["cg_pend"]:"0";
		$tot_sync_cnt10=$cgsuc_ten+$cgfail_ten+$cgdup_ten+$cgpend_ten;
		
		$aync_act10=isset($dts[$val]["asyn_act"])?$dts[$val]["asyn_act"]:"0";
		$aync_cnc10=isset($dts[$val]["asyn_cnc"])?$dts[$val]["asyn_cnc"]:"0";
		$aync_rjc10=isset($dts[$val]["asyn_rjc"])?$dts[$val]["asyn_rjc"]:"0";
		$aync_exp10=isset($dts[$val]["asyn_exp"])?$dts[$val]["asyn_exp"]:"0";
		$aync_chr10=isset($dts[$val]["asyn_chr"])?$dts[$val]["asyn_chr"]:"0";
		$tot_hr_asyn10=$aync_act10+$aync_cnc10+$aync_rjc10+$aync_exp10+$aync_chr10;
		
		$ncs_ten=$tot_hits_ten_day-($aac_ten_day+$dnd_ten_day+$redirect_cg_cnt_ten_day);
		if($ncs_ten < 0)
			$ncs_ten=0;
		$sub_cnts_ten_day=isset($dts[$val]["sub_count"])?$dts[$val]["sub_count"]:"0";
		$low_bal_cnts_ten_day=isset($dts[$val]["sub_low_balance"])?$dts[$val]["sub_low_balance"]:"0";
		$fail_cnts_ten_day=isset($dts[$val]["sub_failure_count"])?$dts[$val]["sub_failure_count"]:"0";
		$total_subs_count=$sub_cnts_ten_day+$low_bal_cnts_ten_day+$fail_cnts_ten_day;
		$ren_cnts_ten_day=isset($dts[$val]["ren_count"])?$dts[$val]["ren_count"]:"0";
		$ren_low_bal_cnts_ten_day=isset($dts[$val]["ren_low_balance"])?$dts[$val]["ren_low_balance"]:"0";
		$ren_fail_cnts_ten_day=isset($dts[$val]["ren_failure_count"])?$dts[$val]["ren_failure_count"]:"0";
		$total_rens_count=$ren_cnts_ten_day+$ren_low_bal_cnts_ten_day+$ren_fail_cnts_ten_day;
		$sub_revs_val_ten_days=isset($dts[$val]["sub_revenue"])?$dts[$val]["sub_revenue"]:"0";
		$ren_revs_val_ten_days=isset($dts[$val]["ren_revenue"])?$dts[$val]["ren_revenue"]:"0";
		$total_revenue_cnts_ten_days=$sub_revs_val_ten_days+$ren_revs_val_ten_days;
		$deact_cust_ten_days=isset($dts[$val]["deact_customer"])?$dts[$val]["deact_customer"]:"0";
		$deact_sameday_ten_days=isset($dts[$val]["deact_sameday"])?$dts[$val]["deact_sameday"]:"0";
		$total_deacts_ten_days=$deact_cust_ten_days+$deact_sameday_ten_days;
		
		
		 
$varMessage.='<tr>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.date('d-m-Y',strtotime($val)).'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_total_hits_ten_day[]=$tot_hits_ten_day.'</td>';
	/* $varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_uni_ten[]=$uni_hits_ten_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_aac_ten[]=$aac_ten_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_dnd_ten[]=$dnd_ten_day.'</td>'; */
	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ncs_ten[]=$ncs_ten.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_redirect_cg_ten_day[]=$redirect_cg_cnt_ten_day.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgs_ten[]=$cgsuc_ten.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgf_ten[]=$cgfail_ten.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgd_ten[]=$cgdup_ten.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgr_ten[]=$cgpend_ten.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_syn_cg10[]=$tot_sync_cnt10.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_aact10[]=$aync_act10.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_arjc10[]=$aync_rjc10.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_acnc10[]=$aync_cnc10.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_aexp10[]=$aync_exp10.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_achr10[]=$aync_chr10.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_asyn_resp10[]=$tot_hr_asyn10.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agency_succ_ten_day[]=$agency_succ_count_ten_day.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agency_hold_ten_day[]=$agency_hold_count_ten_day.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ten_sub_retry_base[]=$ten_sub_retry_base.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ten_sub_retry[]=$ten_sub_retry.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ten_sub_retry_suc[]=$ten_sub_retry_suc.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ten_sub_retry_lb[]=$ten_sub_retry_lb.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ten_sub_retry_fail[]=$ten_sub_retry_fail.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_cnts_ten_days[]=$sub_cnts_ten_day.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_low_bals_ten_days[]=$low_bal_cnts_ten_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_fail_cnts_ten_days[]=$fail_cnts_ten_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_count[]=$total_subs_count.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_cnts_ten_days[]=$ren_cnts_ten_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_low_cnts_ten_days[]=$ren_low_bal_cnts_ten_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_fail_val_ten_days[]=$ren_fail_cnts_ten_day.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens[]=$total_rens_count.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deact_custs[]=$deact_cust_ten_days.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deact_sameday[]=$deact_sameday_ten_days.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deacts[]=$total_deacts_ten_days.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_revs_ten_days[]=$sub_revs_val_ten_days.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_revs_ten_days[]=$ren_revs_val_ten_days.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$total_rev_sum_ten_day[]=$total_revenue_cnts_ten_days.'</td></tr>';
	   
}
	$varMessage.='<tr>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>Total</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_total_hits_ten_day).'</strong></td>';
/* 	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_uni_ten).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_aac_ten).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_dnd_ten).'</strong></td>'; */
	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ncs_ten).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_redirect_cg_ten_day).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgs_ten).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgf_ten).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgd_ten).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgr_ten).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_syn_cg10).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_aact10).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_arjc10).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_acnc10).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_aexp10).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_achr10).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_asyn_resp10).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agency_succ_ten_day).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agency_hold_ten_day).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ten_sub_retry_base).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ten_sub_retry).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ten_sub_retry_suc).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ten_sub_retry_lb).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ten_sub_retry_fail).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sub_cnts_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_low_bals_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_fail_cnts_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_count).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_cnts_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_low_cnts_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_fail_val_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deact_custs).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deact_sameday).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deacts).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sub_revs_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_revs_ten_days).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($total_rev_sum_ten_day).'</strong></td></tr>';
 $varMessage = $varMessage.'</table>'; 
 //echo $varMessage;exit();  
	
	/*last 3 months*/
	$cellc_three_mons=$db['master']->getResults("SELECT DATE_FORMAT(`date`,'%Y-%m') as mon_val,SUM(total_hits) AS `total_hits`,SUM(sub_count) AS `sub_count`,SUM(ren_count) AS `ren_count`,SUM(sub_low_balance) AS `sub_low_balance`,SUM(sub_failure_count) AS `sub_failure_count`,SUM(sub_revenue) AS `sub_revenue`,SUM(ren_revenue) AS `ren_revenue`,SUM(redirect_cg) AS `redirect_cg`,SUM(ag_succ) AS `ag_succ`,SUM(ag_hold) AS `ag_hold` ,SUM(ren_low_balance) AS `ren_low_balance`,SUM(ren_failure_count) AS `ren_failure_count`,SUM(deact_customer) AS `deact_customer`,SUM(deact_sameday) AS `deact_sameday`,SUM(uniq_hits) AS `uniq_hits`,SUM(aac) AS `aac`,SUM(dnd) AS `dnd`,SUM(cg_suc) AS `cg_suc`,SUM(cg_fail) AS `cg_fail`,SUM(cg_pend) AS `cg_pend`,sum(`cg_dup`) as cg_dup,sum(`asyn_act`)as asyn_act,sum(`asyn_rjc`)as asyn_rjc,sum(`asyn_cnc`)as asyn_cnc,sum(`asyn_exp`)as asyn_exp,sum(`asyn_chr`)as asyn_chr,sum(`sub_retry`)as sub_retry,sum(`sub_base`) as sub_base,sum(`sub_retry_suc`) as sub_retry_suc,sum(`sub_retry_lb`) as sub_retry_lb,sum(`sub_retry_fail`) as sub_retry_fail  FROM cellc_flat_copy1 WHERE `date`>=('".date('Y-m-d')."' - INTERVAL 3 MONTH) GROUP BY MONTH(`date`) ");
	//echo '<pre>';print_r($cellc_three_mons);echo '</pre>';exit;
 
$varMessage = $varMessage.'<h3>CELLC - Last 3 Months</h3>
					 
		<table border="1" cellspacing="0" cellpadding="0" >
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="36" ;>CELLC - Last 3 Months</th>
	   </tr>	
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color:#000; text-align: center" rowspan="2";>Date</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>TH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>NCS</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>RTCG</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="5";>CG RESP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="6";>ASYNC RESP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>AS</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  rowspan="2";>AH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center"  colspan="5";>Sub Retry</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="4";>Sub Count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="4";>Ren count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="3";>Deactivation</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Sub <br>Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Ren<br> Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" rowspan="2";>Tot<br> Rev</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Dup</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Pend</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">ACT</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">RJC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">CNC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">EXP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">CHR</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">SRB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">SRC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center">Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" >Cust</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" >SD</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #B0E0E6; color: #000; text-align: center" >Tot</th>
	 </tr>';
		  foreach($cellc_three_mons as $val){
			$dts[$val['mon_val']]['total_hits']=$val['total_hits'];
			$dts[$val['mon_val']]['uniq_hits']=$val['uniq_hits'];
			$dts[$val['mon_val']]['aac']=$val['aac'];
			$dts[$val['mon_val']]['dnd']=$val['dnd'];
		
			$dts[$val['mon_val']]['sub_low_balance']=$val['sub_low_balance'];
			$dts[$val['mon_val']]['sub_failure_count']=$val['sub_failure_count'];
		   
		    $dts[$val['mon_val']]['redirect_cg']=$val['redirect_cg'];
			
			
			$dts[$val['mon_val']]['cg_suc']=$val['cg_suc'];
			$dts[$val['mon_val']]['cg_fail']=$val['cg_fail'];
			$dts[$val['mon_val']]['cg_pend']=$val['cg_pend'];
			$dts[$val['mon_val']]['cg_dup']=$val['cg_dup'];
			
			$dts[$val['mon_val']]["asyn_act"]=$val['asyn_act'];
			$dts[$val['mon_val']]["asyn_cnc"]=$val['asyn_cnc'];
			$dts[$val['mon_val']]["asyn_rjc"]=$val['asyn_rjc'];
			$dts[$val['mon_val']]["asyn_exp"]=$val['asyn_exp'];
			$dts[$val['mon_val']]["asyn_chr"]=$val['asyn_chr'];
			
			$dts[$val['mon_val']]['ag_succ']=$val['ag_succ'];
			$dts[$val['mon_val']]['ag_hold']=$val['ag_hold'];
			
			$dts[$val['mon_val']]['sub_base']=$val['sub_base'];
			$dts[$val['mon_val']]['sub_retry']=$val['sub_retry'];
			$dts[$val['mon_val']]['sub_retry_suc']=$val['sub_retry_suc'];
			$dts[$val['mon_val']]['sub_retry_lb']=$val['sub_retry_lb'];
			$dts[$val['mon_val']]['sub_retry_fail']=$val['sub_retry_fail'];
			
			$dts[$val['mon_val']]['sub_count']=$val['sub_count']; 
			$dts[$val['mon_val']]['ren_count']=$val['ren_count'];
		  
			$dts[$val['mon_val']]['sub_revenue']=$val['sub_revenue'];
			$dts[$val['mon_val']]['ren_revenue']=$val['ren_revenue'];
			$dts[$val['mon_val']]['ren_low_balance']=$val['ren_low_balance'];
			$dts[$val['mon_val']]['ren_failure_count']=$val['ren_failure_count'];
			$dts[$val['mon_val']]['deact_customer']=$val['deact_customer'];
			$dts[$val['mon_val']]['deact_sameday']=$val['deact_sameday'];
			
		   
		 }
	$mon_range=array();
	//array_push($mon_range,$curr_mon,$prev_mon);
array_push($mon_range,$curr_mon,$prev_mon,$two_month);  
//print_r($mon_range);echo "<br>";
foreach($mon_range as $vals){
		$month_val = date("m", strtotime($vals));
		$tot_hits_three_mons=isset($dts[$vals]["total_hits"])?$dts[$vals]["total_hits"]:"0";
		$uniq_three_mons=isset($dts[$vals]["uniq_hits"])?$dts[$vals]["uniq_hits"]:"0";
		$aac_three_mons=isset($dts[$vals]["aac"])?$dts[$vals]["aac"]:"0";
		$dnd_three_mons=isset($dts[$vals]["dnd"])?$dts[$vals]["dnd"]:"0";
		$agency_succ_count_three_mons=isset($dts[$vals]["ag_succ"])?$dts[$vals]["ag_succ"]:"0";
		$agency_hold_count_three_mons=isset($dts[$vals]["ag_hold"])?$dts[$vals]["ag_hold"]:"0";
		
		$three_sub_retry_base=isset($dts[$vals]["sub_base"])?$dts[$vals]["sub_base"]:"0";
		$three_sub_retry=isset($dts[$vals]["sub_retry"])?$dts[$vals]["sub_retry"]:"0";
		$three_sub_retry_suc=isset($dts[$vals]["sub_retry_suc"])?$dts[$vals]["sub_retry_suc"]:"0";
		$three_sub_retry_lb=isset($dts[$vals]["sub_retry_lb"])?$dts[$vals]["sub_retry_lb"]:"0";
		$three_sub_retry_fail=isset($dts[$vals]["sub_retry_fail"])?$dts[$vals]["sub_retry_fail"]:"0";
		
		$redirect_cg_cnt_three_mons=isset($dts[$vals]["redirect_cg"])?$dts[$vals]["redirect_cg"]:"0";
		$ncs_threem=$tot_hits_three_mons-($aac_three_mons+$dnd_three_mons+$redirect_cg_cnt_three_mons);
		if($ncs_threem < 0)
			$ncs_threem=0;
		
		$cgsuc_three=isset($dts[$vals]["cg_suc"])?$dts[$vals]["cg_suc"]:"0";
		$cgfail_three=isset($dts[$vals]["cg_fail"])?$dts[$vals]["cg_fail"]:"0";
		$cgdup_three=isset($dts[$vals]["cg_dup"])?$dts[$vals]["cg_dup"]:"0";
		$cgnr_three=isset($dts[$vals]["cg_pend"])?$dts[$vals]["cg_pend"]:"0";
		$tot_sync_cntm=$cgsuc_three+$cgfail_three+$cgdup_three+$cgnr_three;
		
		$aync_actm=isset($dts[$vals]["asyn_act"])?$dts[$vals]["asyn_act"]:"0";
		$aync_cncm=isset($dts[$vals]["asyn_cnc"])?$dts[$vals]["asyn_cnc"]:"0";
		$aync_rjcm=isset($dts[$vals]["asyn_rjc"])?$dts[$vals]["asyn_rjc"]:"0";
		$aync_expm=isset($dts[$vals]["asyn_exp"])?$dts[$vals]["asyn_exp"]:"0";
		$aync_chrm=isset($dts[$vals]["asyn_chr"])?$dts[$vals]["asyn_chr"]:"0";
		$tot_hr_asynm=$aync_actm+$aync_cncm+$aync_rjcm+$aync_expm+$aync_chrm;
		
		$sub_cnts_three_mons=isset($dts[$vals]["sub_count"])?$dts[$vals]["sub_count"]:"0";
		$low_bal_cnts_three_mons=isset($dts[$vals]["sub_low_balance"])?$dts[$vals]["sub_low_balance"]:"0";
		$fail_cnts_three_mons=isset($dts[$vals]["sub_failure_count"])?$dts[$vals]["sub_failure_count"]:"0";
		$total_subs_count_three_mons=$sub_cnts_three_mons+$low_bal_cnts_three_mons+$fail_cnts_three_mons;
		$ren_cnts_three_mons=isset($dts[$vals]["ren_count"])?$dts[$vals]["ren_count"]:"0";
		$ren_low_bal_cnts_three_mons=isset($dts[$vals]["ren_low_balance"])?$dts[$vals]["ren_low_balance"]:"0";
		$ren_fail_cnts_three_mons=isset($dts[$vals]["ren_failure_count"])?$dts[$vals]["ren_failure_count"]:"0";
		$total_rens_count_three_mons=$ren_cnts_three_mons+$ren_low_bal_cnts_three_mons+$ren_fail_cnts_three_mons;
		$sub_revs_val_three_mons=isset($dts[$vals]["sub_revenue"])?$dts[$vals]["sub_revenue"]:"0";
		$ren_revs_val_three_mons=isset($dts[$vals]["ren_revenue"])?$dts[$vals]["ren_revenue"]:"0";
		$total_revenue_cnts_three_mons=$sub_revs_val_three_mons+$ren_revs_val_three_mons;
		$deact_cust_three_mons=isset($dts[$vals]["deact_customer"])?$dts[$vals]["deact_customer"]:"0";
		$deact_sameday_three_mons=isset($dts[$vals]["deact_sameday"])?$dts[$vals]["deact_sameday"]:"0";
		$total_deacts_three_mons=$deact_cust_three_mons+$deact_sameday_three_mons;
		
	$name_of_month=date("F", strtotime($vals));	
	$varMessage.='<tr>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.date("F", strtotime($vals)).'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_total_hits_three_mons[]=$tot_hits_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ncs_threem[]=$ncs_threem.'</td>';
	/* $varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_uni_three[]=$uniq_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_aac_three[]=$aac_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_dnd_three[]=$dnd_three_mons.'</td>'; */
	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_redirect_cg_three_mons[]=$redirect_cg_cnt_three_mons.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgs_three[]=$cgsuc_three.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgf_three[]=$cgfail_three.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgd_three[]=$cgdup_three.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cgr_three[]=$cgnr_three.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_syn_cgm[]=$tot_sync_cntm.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_aactm[]=$aync_actm.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_arjcm[]=$aync_rjcm.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_acncm[]=$aync_cncm.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_aexpm[]=$aync_expm.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_achrm[]=$aync_chrm.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_cg_asyn_respm[]=$tot_hr_asynm.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agency_succ_three_mons[]=$agency_succ_count_three_mons.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agency_hold_three_mons[]=$agency_hold_count_three_mons.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_three_sub_retry_base[]=$three_sub_retry_base.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_three_sub_retry[]=$three_sub_retry.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_three_sub_retry_suc[]=$three_sub_retry_suc.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_three_sub_retry_lb[]=$three_sub_retry_lb.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_three_sub_retry_fail[]=$three_sub_retry_fail.'</td>							
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_cnts_three_mons[]=$sub_cnts_three_mons.'</td>	
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_low_bals_three_mons[]=$low_bal_cnts_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_fail_cnts_three_mons[]=$fail_cnts_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_count_three_mons[]=$total_subs_count_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_cnts_three_mons[]=$ren_cnts_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_low_cnts_three_mons[]=$ren_low_bal_cnts_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_fail_val_three_mons[]=$ren_fail_cnts_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_three_mons[]=$total_rens_count_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deact_custs_three_mons[]=$deact_cust_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deact_sameday_three_mons[]=$deact_sameday_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_deacts_three_mons[]=$total_deacts_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_sub_revs_three_mons[]=$sub_revs_val_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ren_revs_three_mons[]=$ren_revs_val_three_mons.'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$total_rev_sum_three_mons[]=$total_revenue_cnts_three_mons.'</td></tr>'; 
}
	$varMessage.='<tr><td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>Total</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_total_hits_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ncs_threem).'</strong></td>';
	/* $varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_uni_three).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_aac_three).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_dnd_three).'</strong></td>'; */
	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_redirect_cg_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgs_three).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgf_three).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgd_three).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cgr_three).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_syn_cgm).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_aactm).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_arjcm).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_acncm).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_aexpm).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_achrm).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_cg_asyn_respm).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agency_succ_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agency_hold_three_mons).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_three_sub_retry_base).'</strong></td> 
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_three_sub_retry).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_three_sub_retry_suc).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_three_sub_retry_lb).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_three_sub_retry_fail).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong></strong>'.array_sum($tot_sub_cnts_three_mons).'</td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_low_bals_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_fail_cnts_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_count_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_cnts_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_low_cnts_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_fail_val_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deact_custs_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deact_sameday_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_deacts_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sub_revs_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ren_revs_three_mons).'</strong></td>
	<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>'.array_sum($total_rev_sum_three_mons).'</strong></td></tr>';

 
	$varMessage = $varMessage.'</table>';
		//echo $varMessage;
		
		
		//error_code//
		$cellc_err_codes=$db ['sub']->getResults("SELECT CASE WHEN (`trans_type` LIKE 'Sub%' OR `trans_type` = '' OR trans_type='Free Trail') THEN 'Subscription' ELSE 'Renewal' END AS `type`,COUNT(DISTINCT CONCAT(mobile_num,service_details_id)) AS err_cnts, error_code FROM charging_history WHERE DATE(CONVERT_TZ(added_on,'+05:30','+02:00')) = '".$today."' AND error_code != '0' GROUP BY error_code ORDER BY error_code");
	$count_cellc=count($cellc_err_codes);//echo $count_cellc;exit;
	//echo '<pre>';print_r($cellc_err_codes);echo '</pre>';exit;
	$codes_cellc=0;
	$cnts_cellc=0;
	$head_sub=0;
	if(!empty($cellc_err_codes)){
		$spantxt = "";
	foreach($cellc_err_codes as $val){
		$head_sub = $cellc_err_arr[$val['error_code']];
					$spantxt .= '<span style="color: red;">'.$val['error_code'].'</span> - '.$head_sub.', ';		
	}
		$varMessage = $varMessage.'<h3>CELLC Error Code (Cumulative) For :-'.$today. ' </h3>
		<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">'.$spantxt.'</i>
		<table border="1" cellspacing="0" cellpadding="0">
		<tr>';$varMessage .= '<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center" colspan="'.(2*$count_cellc).'">CELLC error codes - '. $today.' </th></tr><tr><td style="font-family:sans-serif;font-size: 12px;padding: 5px;background-color: #f8c471;border: 1px solid #000;  color: #000; text-align: center;><p align="center"><strong>Type</td>';	
					foreach($cellc_err_codes as $val){
					foreach($cellc_err_arr as $key=>$value){
						if($val['error_code'] == ''){
							$codes_cellc="Empty";
							break;
						} elseif($val['error_code' ] == $key){
							$codes_cellc = $key;
							break;
						}
					
					}
					$varMessage .= '<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center">'.$codes_cellc.'</td>';
							
				}
				$varMessage .='<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471; color: #000; text-align: center;><p align="center"><strong>Total</td>';
				
				$varMessage .='</tr> <tr><td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;  color: black; text-align: center;><p align="center"><strong>Sub</td>';
				foreach($cellc_err_codes as $val){
				$cnts_cellc_sub_err=0;
					if($val['type']=='Subscription'){
					$cnts_cellc_sub_err=$val['err_cnts'];
					}
					$varMessage .= '<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;  color: black; text-align: center;><p align="center">'.$total_sub_err_cnts[]=$cnts_cellc_sub_err.'</td>';
									
				}
				$varMessage .= '<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;background-color: #f8c471;  color: black; text-align: center;><p align="center">'.array_sum($total_sub_err_cnts).'</td>';
				
				$varMessage .='</tr> <tr><td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;  color: black; text-align: center;><p align="center"><strong>Ren</td>';
				foreach($cellc_err_codes as $val){
				$cnts_cellc_ren_err=0;
					if($val['type']=='Renewal'){
					$cnts_cellc_ren_err=$val['err_cnts'];
					}
					$varMessage .= '<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;  color: black; text-align: center;><p align="center">'.$total_ren_err_cnts[]=$cnts_cellc_ren_err.'</td>';
									
				}
				$varMessage .= '<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;background-color: #f8c471;color: black; text-align: center;><p align="center">'.array_sum($total_ren_err_cnts).'</td>';
				
	$varMessage = $varMessage.'</tr> </table>';
	}else{
			$varMessage = $varMessage.'<h3>CELLC Error Code (Cumulative) for :-'.$today. ' </h3>';
			$errs_cellc="No Error codes for :-'".$today."' ";
		}
		
		//price_point//
		$cellc_pricepnt=$db ['sub']->getResults("SELECT sd.service_name AS `price_name`,sd.charges AS price_point,((sd.charges/100)) AS prices,COUNT(1) AS price_cnts FROM service_details sd,charging_history ch WHERE sd.service_details_id = ch.service_details_id AND  DATE(CONVERT_TZ(added_on,'+05:30','+02:00')) = '".$today."' AND ch.error_code='0' GROUP BY sd.charges");
		$count_cellc_pricepnt=count($cellc_pricepnt);//echo $count_yeah_pricepnt;exit;
	//echo '<pre>';print_r($count_cellc_pricepnt);echo '</pre>';exit;
	$price_cellc=0;
	$price_cnts_cellc=0;
	if(!empty($cellc_pricepnt)){
		$varMessage = $varMessage.'<h3>CELLC Price Point (Cumulative) For :-'.$today. ' </h3>
		<table border="1" cellspacing="0" cellpadding="0">
		<tr>';
		//$varMessage .= '<th style="background-color:#000 ;"colspan="'.$count_yeah_pricepnt.'"></th>';
		$varMessage .='</tr>
		<tr><th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471;color:##000;  text-align: center" colspan="'.$count_cellc_pricepnt.'">PricePoint</th>';
		
		foreach($cellc_pricepnt as $val){
				$price_cellc = $val['prices'].' RAND';
				$varMessage .= '<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #f8c471;color:##000; text-align: center;colspan="'.$count_cellc_pricepnt.'"><p align="center">'.$price_cellc.'</td>';
				}
	$varMessage .='</tr> <tr><th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;  text-align: center" colspan="'.$count_cellc_pricepnt.'">Total</th>';
				foreach($cellc_pricepnt as $val){
					$price_cnts_cellc=$val['price_cnts'];
					$varMessage .= '<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000;  color: black; text-align: center;><p align="center"><strong>'.$price_cnts_cellc.'</td>';				
				}
	$varMessage = $varMessage.'</tr> </table>';
	}else{
			$varMessage = $varMessage.'<h3>CELLC Price Point (Cumulative) for :-'.$today. ' </h3>';
			$prices_cellc="No Price Point for :-'".$today."' ";
		}
		  
	
/* $lpath="reporting_task/gateway/product_reports/".date('Y', strtotime('now')).'/'.date('m', strtotime('now')).'/'.date('d', strtotime('now')).'/CELLC/';

    $year = date("Y", strtotime('now'));
    $month = date("m", strtotime('now'));
    $date = date("d", strtotime('now'));
	 $destination1 = $lpath."cellc_product_reports_".$year."_".$month."_".$date.".zip"; */


 
$to='adalarasu.a@m-tutor.com'; 
$ccto='pk@symbioticinfo.com,pk@m-tutor.com,sundar@symbioticinfo.com,shankar@m-tutor.com,kesarivarman.p@m-tutor.com,senthilkumar.a@m-tutor.com,kalaiarasu.b@m-tutor.com,srikanth.murugavel@m-tutor.com,aishwarya.prasad@m-tutor.com,l1support@symbioticinfo.com,gangadhar.ml@symbioticinfo.com,aniket.sahamate@symbioticinfo.com,sakthivel.c@m-tutor.com,hrlyreports@m-tutor.com,donovan@stos.co.za';
 
$msg_content = $varMessage.$errs_cellc.$prices_cellc.'<br>'; 
$msg_content.= "CELLC Product Hourly,Last 10 Days and Last 3 Months Reports<br>";
$msg_content.= '<a href="http://socialdev.m-tutor.com/'.$destination1.'">
 Click here for product details</a><br>';


/* $to='sakthivel.c@m-tutor.com';
$ccto='kesarivarman.p@m-tutor.com'; */

$subject = 'CELLC TIMEZONE REPORT';
echo $msg_content;
shell_exec('php ../../cellc_mis/cellc_service_wise.php');


$fromdate = date("Y-m-d",strtotime("now"));
$year = date("Y",strtotime("now"));
$month = date("m",strtotime("now"));
$date = date("d",strtotime("now"));
$cur_hour = date("H",strtotime("now"));

$file= "/var/www/html/cellc_mis/cellc/".$year."/".$month."/".$date."/CELLC_" . $year . "_" . $month . "_" . $date . "_service_wise_hour_".$cur_hour.".csv";


if(!isset($request['send_mail']))
	sendemail($to, $msg_content, $file, $subject, $ccto);
function sendemail($email, $msg_content, $attachment = '', $subject, $ccto = '') {
    require_once(ROOT_DIR . "framework/library/mail/mail.class.inc");
    $mail = new Mailer();
    $mail->CharSet = "UTF-8";
    $mail->IsSMTP(); // set mailer to use SMTP
//$mail->Host = "192.168.100.7"; // specify main and backup server
    $mail->Host = "mail.symbioticinfo.com"; // specify main and backup server
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->Port = "587";
    $mail->Username = "alerts"; // SMTP username
    $mail->Password = "A1RT786"; // SMTP password
    $mail->From = 'alerts@symbioticinfo.com';
    $mail->FromName = 'CELLC';
    $mail->IsHTML(true);
    $to = $email;
    $body = $msg_content;
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->addAttachment($attachment);
    $mail->AddAddress($to);
    $arrCC = explode(",", $ccto);
    foreach ($arrCC as $cc) {
        $mail->AddCC($cc);
    }
    if ($mail->Send()) {
		//echo "Mail successfully sent to $to"; 
        console(LOG_LEVEL_TRACE, "Mail successfully sent to $to");
    } else {
		//echo "Mail sending FAILED to";
		//echo "<pre>";print_r($mail);echo "</pre>";
        console(LOG_LEVEL_TRACE, "Mail sending FAILED to " . $to . "::" . var_export($mail, true));
    }
    unset($mail);
}
?>