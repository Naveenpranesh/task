<?php
ini_set('display_errors', 1); 
define("DB_CONNECTIONS","master,sub");
include_once("../framework/initialise/framework.init.php");
include_once("../framework/initialise/helper.php");
global $library,$request,$db,$curl,$libxml,$log,$viewclass,$mail;
date_default_timezone_set('Asia/Kolkata');
$fromdate=date('Y-m-d 00:00:00');
$todate= date("Y-m-d 23:59:59");
$today= date("Y-m-d");
$cr_hour= date("H");
$to=date('Y-m-d',strtotime('-1 day'));
$from=date('Y-m-d', strtotime('-10 days'));
if($today==date('Y-m-01'))
{
$bt=strtotime(date('Y-m-01',strtotime($today)),time());
$curr_mon = date('Y-m',strtotime('-1 month',$bt));
$prev_mon = date('Y-m',strtotime('-2 month',$bt));
$two_month  =date('Y-m',strtotime('-3 month',$bt));
}
else
{
$bt=strtotime(date('Y-m-01',strtotime($today)),time());
$curr_mon=date('Y-m',strtotime('-0 month',$bt));
$prev_mon=date('Y-m',strtotime('-1 month',$bt));
$two_month=date('Y-m',strtotime('-2 month',$bt));
}
//data extraction from DB
$check_flat=$db['master']->getOneRow(" SELECT date FROM hourly_flat WHERE `date`='".$to."' ");
if($check_flat['date']!=$to)
{
	shell_exec("curl -s 'http://3.128.193.202/wap-hutch-lanka/hourly_report/hutch_lk_insert.php'");
}
$he_details=$db['master']->getResults("	SELECT HOUR(transtime) AS hour_num,COUNT(*) AS tot_hits,SUM(CASE WHEN msisdn ='empty' THEN 1 ELSE 0 END) AS wifi,
										SUM(CASE WHEN (msisdn !='empty' AND msisdn !='')  THEN 1 ELSE 0 END) AS `data`
										FROM he_details WHERE DATE(transtime)='".$today."' GROUP BY  hour_num");
foreach($he_details as $val)
{
			$dt[$val['hour_num']]['tot_hits']=$val['tot_hits'];
			$dt[$val['hour_num']]['wifi']=$val['wifi'];
			$dt[$val['hour_num']]['data']=$val['data'];
}									

$tot_hits_data=$db['master']->getResults("	SELECT HOUR(transtime) AS hour_num, COUNT(*) AS tot_hits,COUNT( DISTINCT msisdn ) AS unique_hits ,
										SUM(CASE WHEN user_status = 'ALREADY ACTIVE' THEN 1 ELSE 0 END )AS aac,
										SUM(CASE WHEN user_status = 'DND' THEN 1 ELSE 0 END )AS dnd
										FROM hit_analysis WHERE DATE(transtime)='".$today."' GROUP BY hour_num ");
foreach($tot_hits_data as $val)
{
			//$dt[$val['hour_num']]['tot_hits']=$val['tot_hits'];
			$dt[$val['hour_num']]['uniq_hits']=$val['unique_hits'];
			$dt[$val['hour_num']]['DND']=$val['dnd'];
			$dt[$val['hour_num']]['AAC']=$val['aac'];
}
/* $rtcg_data=$db['master']->getResults("		SELECT HOUR(transtime) AS hour_num, COUNT(*) AS rt_cg,
										SUM(CASE WHEN response = 'success' THEN 1 ELSE 0 END )AS cg_succ,
										SUM(CASE WHEN response = 'failed' THEN 1 ELSE 0 END )AS cg_fail,
										SUM(CASE WHEN response = 'pending' THEN 1 ELSE 0 END )AS cg_pend
										FROM subscription_detail WHERE DATE(transtime)='".$today."' GROUP BY hour_num ");
foreach($rtcg_data as $val)
{
			$dt[$val['hour_num']]['rt_cg']=$val['rt_cg'];
			$dt[$val['hour_num']]['cg_succ']=$val['cg_succ'];
			$dt[$val['hour_num']]['cg_fail']=$val['cg_fail'];
			$dt[$val['hour_num']]['cg_pend']=$val['cg_pend'];
} */

$rtcg_data=$db['sub']->getResults(" 	SELECT HOUR(transtime) AS hour_num, COUNT(*) AS rt_cg,
										SUM(CASE WHEN (`status` = 'success' OR `status` = 'lowbalance') THEN 1 ELSE 0 END )AS cg_succ,
										SUM(CASE WHEN `status` = 'failed' THEN 1 ELSE 0 END )AS cg_fail,
										SUM(CASE WHEN `status` = 'pending' THEN 1 ELSE 0 END )AS cg_pend
										FROM cg_redirect WHERE DATE(transtime)='".$today."' GROUP BY hour_num ");
foreach($rtcg_data as $val)
{
			$dt[$val['hour_num']]['rt_cg']=$val['rt_cg'];
			$dt[$val['hour_num']]['cg_succ']=$val['cg_succ'];
			$dt[$val['hour_num']]['cg_fail']=$val['cg_fail'];
			$dt[$val['hour_num']]['cg_pend']=$val['cg_pend'];
}
										
$subs_data=$db['sub']->getResults("		SELECT HOUR(added_on) AS hour_num,COUNT(*) AS tot_subtry,
										SUM(CASE WHEN (error_code = 'E020' OR error_code = 'E041') THEN 1 ELSE 0 END )AS sub_suc,
										SUM(CASE WHEN (error_code = 'E035' OR error_code ='LB02' OR error_code ='LB03' ) THEN 1 ELSE 0 END )AS sub_lb,
										SUM(CASE WHEN (error_code != 'E020' AND error_code != 'E035' AND error_code !='LB02' AND error_code !='LB03') THEN 1 ELSE 0 END )AS sub_fail
										FROM charging_history WHERE DATE(added_on)='".$today."' AND trans_type ='subscription' GROUP BY hour_num ");
foreach($subs_data as $val)
{
			$dt[$val['hour_num']]['tot_subtry']=$val['tot_subtry'];
			$dt[$val['hour_num']]['sub_suc']=$val['sub_suc'];
			$dt[$val['hour_num']]['sub_lb']=$val['sub_lb'];
			$dt[$val['hour_num']]['sub_fail']=$val['sub_fail'];
}
$ren_data=$db['sub']->getResults("		SELECT HOUR(added_on) AS hour_num, COUNT(*) AS tot_ren,
										SUM(CASE WHEN error_code = 'E012' THEN 1 ELSE 0 END )AS ren_suc,
										SUM(CASE WHEN error_code = 'LB01' THEN 1 ELSE 0 END )AS ren_lb,
										SUM(CASE WHEN (error_code != 'LB01' AND error_code != 'E012') THEN 1 ELSE 0 END )AS ren_fail
										FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type='renewal' GROUP BY hour_num ");
/* $ren_data_uniql=$db['sub']->getResults("		SELECT HOUR(added_on) AS hour_num, COUNT( DISTINCT CONCAT(mobile_num,'~',service_details_id)) AS renu_l
										FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type='renewal' AND error_code='E013'  
										GROUP BY hour_num ");
$ren_data_uniqf=$db['sub']->getResults("		SELECT HOUR(added_on) AS hour_num, COUNT( DISTINCT CONCAT(mobile_num,'~',service_details_id)) AS renu_f
										FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type='renewal' AND error_code!='E013' and error_code!='E012' GROUP BY hour_num"); */
foreach($ren_data as $val)
{
			$dt[$val['hour_num']]['ren_suc']=$val['ren_suc'];
			$dt[$val['hour_num']]['ren_fail']=$val['ren_fail'];
			$dt[$val['hour_num']]['ren_lb']=$val['ren_lb'];
}
/* foreach($ren_data_uniql as $val)
{
	$dt[$val['hour_num']]['ren_fail_ul']=$val['renu_l'];
}
foreach($ren_data_uniqf as $val)
{
	$dt[$val['hour_num']]['ren_fail_uf']=$val['renu_f'];
} */
$ren_rev_data=$db['sub']->getResults("	SELECT HOUR(added_on) AS hour_num ,SUM(rprice) AS ren_rev
										FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type ='renewal' AND error_code='E012' GROUP BY hour_num ");
foreach($ren_rev_data as $val)
{
			$dt[$val['hour_num']]['ren_rev']=$val['ren_rev'];
}
$sub_rev_data=$db['sub']->getResults("	SELECT HOUR(added_on) AS hour_num ,SUM(rprice) AS sub_rev
										FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type LIKE 'subscription%' AND (error_code='E020' OR error_code='E041') GROUP BY hour_num ");
foreach($sub_rev_data as $val)
{
			$dt[$val['hour_num']]['sub_rev']=$val['sub_rev'];
}											
$in_base=$db['sub']->query("         	INSERT INTO base_count(`date`,base_count) SELECT DATE(NOW()),COUNT(*)
										FROM subscription AS s LEFT JOIN service_details AS sd ON sd.service_details_id=s.service_details_id 
										WHERE s.status_id IN (SELECT status_details_id FROM status_details WHERE status_name='CHARGE' OR status_name='ACTIVE') AND  
										DATE(NOW()) <= DATE_ADD(exp_date,INTERVAL sd.grace_period DAY) AND  
										DATE(exp_date) <= DATE(NOW()) AND is_renewal='1' AND DATE(sub_date) != DATE(NOW()) AND circle_id!='4'");
$get_str_base=$db['sub']->getOneRow("SELECT base_count FROM base_count WHERE `date`=DATE(NOW())");	
$start_base=$get_str_base['base_count'];

$in_sub_base=$db['sub']->query("        INSERT INTO sub_base_count(`date`,base_count) SELECT DATE(NOW()),COUNT(*)
										FROM subscription AS s LEFT JOIN service_details AS sd ON sd.service_details_id=s.service_details_id 
										WHERE s.status_id IN (SELECT status_details_id FROM status_details WHERE status_name='CHARGE') AND  DATE(NOW()) <= DATE_ADD(exp_date,INTERVAL sd.grace_period DAY) AND   circle_id='4' AND
										DATE(exp_date) <= DATE(NOW()) AND is_renewal='1' AND DATE(sub_date) != DATE(NOW()) 	");
$get_sub_base=$db['sub']->getOneRow("SELECT base_count FROM sub_base_count WHERE `date`=DATE(NOW())");	
$sub_start_base=$get_sub_base['base_count'];
	
$subsretry_data=$db['sub']->getResults("		SELECT HOUR(added_on) AS hour_num,COUNT(*) AS tot_subretry,
										SUM(CASE WHEN (error_code = 'E041') THEN 1 ELSE 0 END )AS subretry_suc,
										SUM(CASE WHEN (error_code = 'E035' OR error_code ='LB03' ) THEN 1 ELSE 0 END )AS subretry_lb,
										SUM(CASE WHEN (error_code != 'E035' AND error_code !='LB03') THEN 1 ELSE 0 END )AS subretry_fail
										FROM charging_history WHERE DATE(added_on)='".$today."' AND trans_type ='subscription_retry' GROUP BY hour_num ");
foreach($subsretry_data as $val)
{
			$dt[$val['hour_num']]['tot_subretry']=$val['tot_subretry'];
			$dt[$val['hour_num']]['subretry_lb']=$val['subretry_suc'];
			$dt[$val['hour_num']]['subretry_lb']=$val['subretry_lb'];
			$dt[$val['hour_num']]['subretry_fail']=$val['subretry_fail'];
}
$ag_det=$db['master']->getResults("		SELECT COUNT(*) as agency_holds,HOUR(dateandtime) as agency_hour, response 
										FROM agent_hit_analysis 
										WHERE DATE(dateandtime)='".$today."'
										GROUP BY agency_hour, response");		
foreach($ag_det as $val)
{
			$dt[$val['agency_hour']]['response']=$val['agency_holds'];
}					
$smd_deact=$db ['sub']->getResults(" 	SELECT HOUR(sh.unsub_date) AS `hour_num`,COUNT(1) as smd FROM subscription_history sh 
										WHERE sh.deact_mode_id!='0' AND DATE(sh.unsub_date)='".$today."' AND DATE(sh.unsub_date)=DATE(sh.sub_date) 
										GROUP BY HOUR(sh.unsub_date)");
foreach($smd_deact as $val)
{
			$dt[$val['hour_num']]['smd']=$val['smd'];
}	
$tot_deact=$db ['sub']->getResults("	SELECT HOUR(sh.unsub_date) AS `hour_num`,COUNT(1) as tdd FROM subscription_history sh 
										WHERE sh.deact_mode_id!='0' AND DATE(sh.unsub_date)='".$today."'
										GROUP BY HOUR(sh.unsub_date)");
foreach($tot_deact as $val)
{
			$dt[$val['hour_num']]['tdd']=$val['tdd'];
}
//echo "<pre>";print_r($dt);echo "</pre>";exit(); 

$varMessage = $varMessage.'<h3><b>Hutch Lanka Hourly Report<b></h3>
					<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">
						<span style="color: red;">IST</span> - Indian Standard Time,
						<span style="color: red;">TH</span> - Total hits,
						<span style="color: red;">HE</span> - Header Enrichment Details,
						<span style="color: red;">NDC</span> - Network Data Count,
						<span style="color: red;">WDC</span> - Wifi Data Count,
						<span style="color: red;">UH</span> - Unique hits,
						<span style="color: red;">RTCG</span> - Redirect To CG,
						<span style="color: red;">AS</span> -Agency Success,
						<span style="color: red;">AH</span> -Agency Hold,
						<span style="color: red;">SRB</span> -Subscription Retry Base Count,
						<span style="color: red;">SRC</span> -Subscription Retry Processed Count,
						<span style="color: red;">Succ</span> -Success,
						<span style="color: red;">LB</span> -Low Balance,
						<span style="color: red;">Fail</span> -Failure,
						<span style="color: red;">NR</span> - No Response,
						<span style="color: red;">Tot</span> -Total,
						<span style="color: red;">Sub</span> - Subscription,
						<span style="color: red;">Ren</span> - Renewal,
						<span style="color: red;">Ren Count</span> - Renewal Count,
						<span style="color: red;">Ren Count</span> - Renewal Count,
						<span style="color: red;">Cust</span> -Customer,
						<span style="color: red;">SD</span> -Same Day,
						<span style="color: red;">Sub Rev</span> - Subscription Revenue,
						<span style="color: red;">Ren Rev</span> - Renewal Revenue,
						<span style="color: red;">Tot Rev</span> - Total Revenue
					</i>
	<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="39" ;>Hutch Lanka Hourly Report - '. $fromdate.' To '. date("Y-m-d H:i:s",strtotime("now")).'</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="3";>IST </br>Hour</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="3";>TH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" colspan="3";>HE</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="3";>UH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="3";>AAC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="3";>DND</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="3";>RTCG</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" colspan="3";>CG RESP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="5";>Sub Retry</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="4";>Subscription</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="3";>AS</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="3";>AH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="4";>Ren count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="7";>Availibilty</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="2";>Deactivation</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="3";>Sub <br>Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="3";>Ren<br> Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="3";>Tot<br> Rev</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>NDC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>WDC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>NR</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>SRB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>SRC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" colspan="3";>Base</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>SD</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" rowspan="2";>Tot</th>
		</tr>
		<tr> 
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center">Ren</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center">Sub</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center">Tot</th>
		</tr>';
$ren_avail=$sub_avail=$total_avail=0;
for($i=0;$i<=$cr_hour;$i++)
{
	$tot_hits_val=isset($dt[$i]["tot_hits"])?$dt[$i]["tot_hits"]:"0";
	$tot_wifi_val=isset($dt[$i]["wifi"])?$dt[$i]["wifi"]:"0";
	$tot_data_val=isset($dt[$i]["data"])?$dt[$i]["data"]:"0";
	$tot_he_val=$tot_wifi_val+$tot_data_val;
	$uni_hits=isset($dt[$i]["uniq_hits"])?$dt[$i]["uniq_hits"]:"0";
	$aac=isset($dt[$i]["AAC"])?$dt[$i]["AAC"]:"0";
	$dnd=isset($dt[$i]["DND"])?$dt[$i]["DND"]:"0";
	$rtcgc=isset($dt[$i]['rt_cg'])?$dt[$i]['rt_cg']:'0';
	$rtcgc_s=isset($dt[$i]['cg_succ'])?$dt[$i]['cg_succ']:'0';
	$rtcgc_f=isset($dt[$i]['cg_fail'])?$dt[$i]['cg_fail']:'0';
	$rtcgc_p=isset($dt[$i]['cg_pend'])?$dt[$i]['cg_pend']:'0';
	
	$subsretry_t=isset($dt[$i]['tot_subretry'])?$dt[$i]['tot_subretry']:'0';
	$subsretry_s=isset($dt[$i]['subretry_suc'])?$dt[$i]['subretry_suc']:'0';
	$subsretry_l=isset($dt[$i]['subretry_lb'])?$dt[$i]['subretry_lb']:'0';
	$subsretry_f=isset($dt[$i]['subretry_fail'])?$dt[$i]['subretry_fail']:'0';
	
	$tot_subsretry_val_prev=isset($dt[$i-1]["subretry_suc"])?$dt[$i-1]["subretry_suc"]:"0";
	
	$subs_s=isset($dt[$i]['sub_suc'])?$dt[$i]['sub_suc']:'0';
	$subs_l=isset($dt[$i]['sub_lb'])?$dt[$i]['sub_lb']:'0';
	$subs_f=isset($dt[$i]['sub_fail'])?$dt[$i]['sub_fail']:'0';
	$subs_tot=$subs_s+$subs_l+$subs_f;
	
	$ags=isset($dt[$i]['Success'])?$dt[$i]['Success']:'0';
	$agh=isset($dt[$i]['HOLD'])?$dt[$i]['HOLD']:'0';
	
	$rens_s=isset($dt[$i]['ren_suc'])?$dt[$i]['ren_suc']:'0';
	$rens_l=isset($dt[$i]['ren_lb'])?$dt[$i]['ren_lb']:'0';
	$rens_f=isset($dt[$i]['ren_fail'])?$dt[$i]['ren_fail']:'0';
	
	$tot_subs_val_prev=isset($dt[$i-1]["sub_suc"])?$dt[$i-1]["sub_suc"]:"0";
	$tot_ren_val_prev=isset($dt[$i-1]["ren_suc"])?$dt[$i-1]["ren_suc"]:"0";
	$tot_success_prev=$tot_subs_val_prev+$tot_ren_val_prev;
	
	if($i==0)
	{
		$sub_base=$sub_start_base;
		$ren_avail=$start_base;
		$sub_avail=$subs_l+$subs_f;
		$total_avail=$ren_avail+$sub_avail;
	}
	else
	{
		$sub_base=$sub_base-$tot_subsretry_val_prev;
		$ren_avail=$total_avail-$tot_success_prev;
		$sub_avail=$subs_l+$subs_f;
		$total_avail=$ren_avail+$sub_avail;
	}
	$rens_tot=$rens_s+$rens_l+$rens_f;
	$smd=isset($dt[$i]['smd'])?$dt[$i]['smd']:'0';
	$tdd=isset($dt[$i]['tdd'])?$dt[$i]['tdd']:'0';
	
	$subs_rev=isset($dt[$i]['sub_rev'])?$dt[$i]['sub_rev']:'0';
	$rens_rev=isset($dt[$i]['ren_rev'])?$dt[$i]['ren_rev']:'0';
	$tots_rev=$subs_rev+$rens_rev;

$varMessage.='<tr>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$i.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_hits_day[]=$tot_hits_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_data_day[]=$tot_data_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_wifi_day[]=$tot_wifi_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_he_day[]=$tot_he_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_uni_day[]=$uni_hits.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_aac_day[]=$aac.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_dnd_day[]=$dnd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_day[]=$rtcgc.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_s_day[]=$rtcgc_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_f_day[]=$rtcgc_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_p_day[]=$rtcgc_p.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$sub_base.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$subsretry_t.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_s_day[]=$subsretry_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_l_day[]=$subsretry_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_f_day[]=$subsretry_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_s_day[]=$subs_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_l_day[]=$subs_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_f_day[]=$subs_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_tot_day[]=$subs_tot.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ags_tot_day[]=$ags.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agh_tot_day[]=$agh.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_s_day[]=$rens_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_l_day[]=$rens_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_f_day[]=$rens_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_tot_day[]=$rens_tot.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$ren_avail.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$sub_avail.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$total_avail.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$rens_tot.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$rens_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$rens_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$rens_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_smd_day[]=$smd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_tdd_day[]=$tdd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsr_day[]=$subs_rev.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rensr_day[]=$rens_rev.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_revs_day[]=$tots_rev.'</p></td>
		<tr>';
}
$varMessage.='<tr>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;"><p align="center"><strong>Total</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_hits_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_data_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_wifi_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_he_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_uni_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_aac_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_dnd_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_s_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_f_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_p_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_s_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_l_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_f_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_s_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_l_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_f_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_tot_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ags_tot_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agh_tot_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_s_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_l_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_f_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_tot_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong></strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_smd_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_tdd_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsr_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rensr_day).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_revs_day).'</strong></td>
			</tr></table>';
			
			
	$varMessage = $varMessage.'<h3><b>Hutch Lanka Last 10 Days Report<b></h3>
	<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="32" ;>Hutch Lanka Last 10 Days Report - '. $from.' To '.$to.'</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>Date</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>TH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" colspan="3";>HE</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>UH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>AAC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>DND</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>RTCG</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" colspan="3";>CG RESP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="5";>Sub Retry</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="4";>Subscription</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>AS</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>AH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="4";>Ren count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="2";>Deactivation</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>Sub <br>Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>Ren<br> Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>Tot<br> Rev</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >NDC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >WDC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >NR</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >SRB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >SRC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >SD</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
		</tr>';
		
$last10_data=$db['master']->getResults(" SELECT * FROM hourly_flat WHERE `date`>=('".date('Y-m-d')."' - INTERVAL 11 DAY) GROUP BY `date` ");
foreach($last10_data as $val)
{
	$dt[$val['date']]["tot_hits"]=$val['tot_hit'];
	$dt[$val['date']]["wifi"]=$val['wifi'];
	$dt[$val['date']]["data"]=$val['data'];
	$dt[$val['date']]["uniq_hits"]=$val['uniq_hit'];
	$dt[$val['date']]["AAC"]=$val['aac'];
	$dt[$val['date']]["DND"]=$val['dnd'];
	$dt[$val['date']]["rt_cg"]=$val['rtcg'];
	$dt[$val['date']]["cg_succ"]=$val['cgs'];
	$dt[$val['date']]["cg_fail"]=$val['cgf'];
	$dt[$val['date']]["cg_pend"]=$val['cgp'];
	$dt[$val['date']]["srb"]=$val['srb'];
	$dt[$val['date']]["src"]=$val['src'];
	$dt[$val['date']]["subretry_suc"]=$val['subretry_suc'];
	$dt[$val['date']]["subretry_low"]=$val['subretry_low'];
	$dt[$val['date']]["subretry_fail"]=$val['subretry_fail'];
	$dt[$val['date']]["sub_suc"]=$val['sub_suc'];
	$dt[$val['date']]["sub_lb"]=$val['sub_low'];
	$dt[$val['date']]["sub_fail"]=$val['sub_fail'];
	$dt[$val['date']]["Success"]=$val['ags'];
	$dt[$val['date']]["HOLD"]=$val['agh'];
	$dt[$val['date']]["ren_suc"]=$val['ren_suc'];
	$dt[$val['date']]["ren_fail"]=$val['ren_low'];
	$dt[$val['date']]["ren_oth"]=$val['ren_fail'];
	$dt[$val['date']]["smd"]=$val['sm_deact'];
	$dt[$val['date']]["tdd"]=$val['cs_deact'];
	$dt[$val['date']]["sub_rev"]=$val['sub_rev'];
	$dt[$val['date']]["ren_rev"]=$val['ren_rev'];
}
$date_range=array();
array_push($date_range,$to);
for($j=1;$j<=8;$j++){
array_push($date_range,date('Y-m-d', strtotime("-".$j." day",strtotime ($to))));
}
array_push($date_range,$from);
foreach($date_range as $i)
{
	$ten_tot_hits_val=isset($dt[$i]["tot_hits"])?$dt[$i]["tot_hits"]:"0";
	$ten_tot_data_val=isset($dt[$i]["data"])?$dt[$i]["data"]:"0";
	$ten_tot_wifi_val=isset($dt[$i]["wifi"])?$dt[$i]["wifi"]:"0";
	$ten_tot_he_val=$ten_tot_data_val+$ten_tot_wifi_val;
	$ten_uni_hits=isset($dt[$i]["uniq_hits"])?$dt[$i]["uniq_hits"]:"0";
	$ten_aac=isset($dt[$i]["AAC"])?$dt[$i]["AAC"]:"0";
	$ten_dnd=isset($dt[$i]["DND"])?$dt[$i]["DND"]:"0";
	$ten_rtcgc=isset($dt[$i]['rt_cg'])?$dt[$i]['rt_cg']:'0';
	$ten_rtcgc_s=isset($dt[$i]['cg_succ'])?$dt[$i]['cg_succ']:'0';
	$ten_rtcgc_f=isset($dt[$i]['cg_fail'])?$dt[$i]['cg_fail']:'0';
	$ten_rtcgc_p=isset($dt[$i]['cg_pend'])?$dt[$i]['cg_pend']:'0';
	
	
	$ten_subs_srb=isset($dt[$i]['srb'])?$dt[$i]['srb']:'0';
	$ten_subs_src=isset($dt[$i]['src'])?$dt[$i]['src']:'0';
	$ten_subsretry_s=isset($dt[$i]['subretry_suc'])?$dt[$i]['subretry_suc']:'0';
	$ten_subsretry_l=isset($dt[$i]['subretry_low'])?$dt[$i]['subretry_low']:'0';
	$ten_subsretry_f=isset($dt[$i]['subretry_fail'])?$dt[$i]['subretry_fail']:'0';

	$ten_subs_s=isset($dt[$i]['sub_suc'])?$dt[$i]['sub_suc']:'0';
	$ten_subs_l=isset($dt[$i]['sub_lb'])?$dt[$i]['sub_lb']:'0';
	$ten_subs_f=isset($dt[$i]['sub_fail'])?$dt[$i]['sub_fail']:'0';
	$ten_subs_tot=$subs_s+$subs_l+$subs_f;

	$ten_ags=isset($dt[$i]['Success'])?$dt[$i]['Success']:'0';
	$ten_agh=isset($dt[$i]['HOLD'])?$dt[$i]['HOLD']:'0';

	$ten_rens_s=isset($dt[$i]['ren_suc'])?$dt[$i]['ren_suc']:'0';
	$ten_rens_l=isset($dt[$i]['ren_fail'])?$dt[$i]['ren_fail']:'0';
	$ten_rens_f=isset($dt[$i]['ren_oth'])?$dt[$i]['ren_oth']:'0';
	$ten_rens_tot=$ten_rens_s+$ten_rens_l+$ten_rens_f;

	$ten_smd=isset($dt[$i]['smd'])?$dt[$i]['smd']:'0';
	$ten_tdd=isset($dt[$i]['tdd'])?$dt[$i]['tdd']:'0';

	$ten_subs_rev=isset($dt[$i]['sub_rev'])?$dt[$i]['sub_rev']:'0';
	$ten_rens_rev=isset($dt[$i]['ren_rev'])?$dt[$i]['ren_rev']:'0';
	$ten_tots_rev=$ten_subs_rev+$ten_rens_rev;

$varMessage.='<tr>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$i.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_hits_ten[]=$ten_tot_hits_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_data_ten[]=$ten_tot_data_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_wifi_ten[]=$ten_tot_wifi_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_he_ten[]=$ten_tot_he_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_uni_ten[]=$ten_uni_hits.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_aac_ten[]=$ten_aac.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_dnd_ten[]=$ten_dnd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_ten[]=$ten_rtcgc.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_s_ten[]=$ten_rtcgc_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_f_ten[]=$ten_rtcgc_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_p_ten[]=$ten_rtcgc_p.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_srb_ten[]=$ten_subs_srb.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_src_ten[]=$ten_subs_src.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_s_ten[]=$ten_subsretry_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_l_ten[]=$ten_subsretry_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_f_ten[]=$ten_subsretry_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_s_ten[]=$ten_subs_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_l_ten[]=$ten_subs_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_f_ten[]=$ten_subs_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_tot_ten[]=$ten_subs_tot.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ags_tot_ten[]=$ten_ags.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agh_tot_ten[]=$ten_agh.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_s_ten[]=$ten_rens_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_l_ten[]=$ten_rens_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_f_ten[]=$ten_rens_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_tot_ten[]=$ten_rens_tot.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_smd_ten[]=$ten_smd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_tdd_ten[]=$ten_tdd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsr_ten[]=$ten_subs_rev.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rensr_ten[]=$ten_rens_rev.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_revs_ten[]=$ten_tots_rev.'</p></td>
		<tr>';
}
$varMessage.='<tr>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;"><p align="center"><strong>Total</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_hits_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_data_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_wifi_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_he_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_uni_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_aac_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_dnd_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_s_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_f_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_p_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_srb_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_src_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_s_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_l_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_f_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_s_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_l_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_f_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_tot_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ags_tot_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agh_tot_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_s_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_l_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_f_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_tot_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_smd_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_tdd_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsr_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rensr_ten).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_revs_ten).'</strong></td>
			</tr></table>';		
	
	
	$last_three_mon=$db['master']->getResults("SELECT DATE_FORMAT(`date`,'%Y-%m') AS mon_val,SUM(`tot_hit`) AS tot_hit,SUM(`uniq_hit`) AS uniq_hit,SUM(`aac`) AS aac,SUM(`dnd`) AS dnd,SUM(`rtcg`) AS rtcg,SUM(`cgs`) AS cgs,SUM(`cgf`) AS cgf,SUM(`cgp`) AS cgp,SUM(`sub_suc`) AS sub_suc,SUM(`sub_low`) AS sub_low,SUM(`sub_fail`) AS sub_fail,SUM(`ren_suc`) AS ren_suc,SUM(`ren_low`) AS ren_low,SUM(`ren_fail`) AS ren_fail,SUM(`sm_deact`) AS sm_deact,SUM(`cs_deact`) AS cs_deact,SUM(`sub_rev`) AS sub_rev,SUM(`ren_rev`) AS ren_rev,SUM(`ags`) AS ags,SUM(`agh`) AS agh,SUM(`data`) AS data,SUM(`wifi`) AS wifi,SUM(`srb`) AS srb,SUM(`src`) AS src,SUM(`subretry_suc`) AS subretry_suc,SUM(`subretry_low`) AS subretry_low,SUM(`subretry_fail`) AS subretry_fail FROM `hourly_flat` WHERE `date`>=('".date('Y-m-d')."' - INTERVAL 3 MONTH) GROUP BY MONTH(`date`)");
	foreach($last_three_mon as $val)
	{
		$dt[$val['mon_val']]["tot_hits"]=$val['tot_hit'];
		$dt[$val['mon_val']]["data"]=$val['data'];
		$dt[$val['mon_val']]["wifi"]=$val['wifi'];
		$dt[$val['mon_val']]["tot_hits"]=$val['tot_hit'];
		$dt[$val['mon_val']]["uniq_hits"]=$val['uniq_hit'];
		$dt[$val['mon_val']]["AAC"]=$val['aac'];
		$dt[$val['mon_val']]["DND"]=$val['dnd'];
		$dt[$val['mon_val']]["rt_cg"]=$val['rtcg'];
		$dt[$val['mon_val']]["cg_succ"]=$val['cgs'];
		$dt[$val['mon_val']]["cg_fail"]=$val['cgf'];
		$dt[$val['mon_val']]["cg_pend"]=$val['cgp'];
		$dt[$val['mon_val']]["srb"]=$val['srb'];
		$dt[$val['mon_val']]["src"]=$val['src'];
		$dt[$val['mon_val']]["subretry_suc"]=$val['subretry_suc'];
		$dt[$val['mon_val']]["subretry_low"]=$val['subretry_low'];
		$dt[$val['mon_val']]["subretry_fail"]=$val['subretry_fail'];
		$dt[$val['mon_val']]["sub_suc"]=$val['sub_suc'];
		$dt[$val['mon_val']]["sub_lb"]=$val['sub_low'];
		$dt[$val['mon_val']]["sub_fail"]=$val['sub_fail'];
		$dt[$val['mon_val']]["Success"]=$val['ags'];
		$dt[$val['mon_val']]["HOLD"]=$val['agh'];
		$dt[$val['mon_val']]["ren_suc"]=$val['ren_suc'];
		$dt[$val['mon_val']]["ren_fail"]=$val['ren_low'];
		$dt[$val['mon_val']]["ren_oth"]=$val['ren_fail'];
		$dt[$val['mon_val']]["smd"]=$val['sm_deact'];
		$dt[$val['mon_val']]["tdd"]=$val['cs_deact'];
		$dt[$val['mon_val']]["sub_rev"]=$val['sub_rev'];
		$dt[$val['mon_val']]["ren_rev"]=$val['ren_rev'];
	}
	
$varMessage = $varMessage.'<h3><b>Hutch Lanka Last Three Months Report <b></h3>
	<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="32" ;>Hutch Lanka Last Three Months Report - '.date("F", strtotime($two_month)).' to '.date("F", strtotime($curr_mon)).'</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>Month</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>TH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" colspan="3";>HE</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>UH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>AAC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>DND</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" rowspan="2";>RTCG</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color:#000; text-align: center" colspan="3";>CG RESP</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="5";>Sub Retry</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="4";>Subscription</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>AS</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>AH</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="4";>Ren count</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan="2";>Deactivation</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>Sub <br>Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>Ren<br> Rev</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" rowspan="2";>Tot<br> Rev</th>
		</tr>
		<tr>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >NDC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >WDC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >NR</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >SRB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >SRC</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Succ</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >LB</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Fail</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >SD</th>
			<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #99e6ff; color: #000; text-align: center" >Tot</th>
		</tr>';
		
		
$mon_range=array();
array_push($mon_range,$curr_mon,$prev_mon,$two_month);
foreach($mon_range as $i)
{
	$month_val = date("F", strtotime($i));
	$three_tot_hits_val=isset($dt[$i]["tot_hits"])?$dt[$i]["tot_hits"]:"0";
	$three_tot_data_val=isset($dt[$i]["data"])?$dt[$i]["data"]:"0";
	$three_tot_wifi_val=isset($dt[$i]["wifi"])?$dt[$i]["wifi"]:"0";
	$three_tot_he_val=$three_tot_data_val+$three_tot_wifi_val;
	$three_uni_hits=isset($dt[$i]["uniq_hits"])?$dt[$i]["uniq_hits"]:"0";
	$three_aac=isset($dt[$i]["AAC"])?$dt[$i]["AAC"]:"0";
	$three_dnd=isset($dt[$i]["DND"])?$dt[$i]["DND"]:"0";
	$three_rtcgc=isset($dt[$i]['rt_cg'])?$dt[$i]['rt_cg']:'0';
	$three_rtcgc_s=isset($dt[$i]['cg_succ'])?$dt[$i]['cg_succ']:'0';
	$three_rtcgc_f=isset($dt[$i]['cg_fail'])?$dt[$i]['cg_fail']:'0';
	$three_rtcgc_p=isset($dt[$i]['cg_pend'])?$dt[$i]['cg_pend']:'0';
	
	$three_subs_srb=isset($dt[$i]['srb'])?$dt[$i]['srb']:'0';
	$three_subs_src=isset($dt[$i]['src'])?$dt[$i]['src']:'0';
	$three_subsretry_s=isset($dt[$i]['subretry_suc'])?$dt[$i]['subretry_suc']:'0';
	$three_subsretry_l=isset($dt[$i]['subretry_low'])?$dt[$i]['subretry_low']:'0';
	$three_subsretry_f=isset($dt[$i]['subretry_fail'])?$dt[$i]['subretry_fail']:'0';
	
	$three_subs_s=isset($dt[$i]['sub_suc'])?$dt[$i]['sub_suc']:'0';
	$three_subs_l=isset($dt[$i]['sub_lb'])?$dt[$i]['sub_lb']:'0';
	$three_subs_f=isset($dt[$i]['sub_fail'])?$dt[$i]['sub_fail']:'0';
	$three_subs_tot=$subs_s+$subs_l+$subs_f;

	$three_ags=isset($dt[$i]['Success'])?$dt[$i]['Success']:'0';
	$three_agh=isset($dt[$i]['HOLD'])?$dt[$i]['HOLD']:'0';

	$three_rens_s=isset($dt[$i]['ren_suc'])?$dt[$i]['ren_suc']:'0';
	$three_rens_l=isset($dt[$i]['ren_fail'])?$dt[$i]['ren_fail']:'0';
	$three_rens_f=isset($dt[$i]['ren_oth'])?$dt[$i]['ren_oth']:'0';
	$three_rens_tot=$three_rens_s+$three_rens_l+$three_rens_f;

	$three_smd=isset($dt[$i]['smd'])?$dt[$i]['smd']:'0';
	$three_tdd=isset($dt[$i]['tdd'])?$dt[$i]['tdd']:'0';

	$three_subs_rev1=isset($dt[$i]['sub_rev'])?$dt[$i]['sub_rev']:'0';
	$three_rens_rev1=isset($dt[$i]['ren_rev'])?$dt[$i]['ren_rev']:'0';
	$three_subs_rev=round($three_subs_rev1,2);
	$three_rens_rev=round($three_rens_rev1,2);
	$three_tots_rev=$three_subs_rev+$three_rens_rev;
	
	$varMessage.='<tr>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$month_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_hits_three[]=$three_tot_hits_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_data_three[]=$three_tot_data_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_wifi_three[]=$three_tot_wifi_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_he_three[]=$three_tot_he_val.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_uni_three[]=$three_uni_hits.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_aac_three[]=$three_aac.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_dnd_three[]=$three_dnd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_three[]=$three_rtcgc.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_s_three[]=$three_rtcgc_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_f_three[]=$three_rtcgc_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rtcgc_p_three[]=$three_rtcgc_p.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_srb_three[]=$three_subs_srb.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_src_three[]=$three_subs_src.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_s_three[]=$three_subsretry_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_l_three[]=$three_subsretry_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsretry_f_three[]=$three_subsretry_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_s_three[]=$three_subs_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_l_three[]=$three_subs_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_f_three[]=$three_subs_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subs_tot_three[]=$three_subs_tot.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_ags_tot_three[]=$three_ags.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_agh_tot_three[]=$three_agh.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_s_three[]=$three_rens_s.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_l_three[]=$three_rens_l.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_f_three[]=$three_rens_f.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rens_tot_three[]=$three_rens_tot.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_smd_three[]=$three_smd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_tdd_three[]=$three_tdd.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_subsr_three[]=$three_subs_rev.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rensr_three[]=$three_rens_rev.'</p></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_revs_three[]=$three_tots_rev.'</p></td>
		<tr>';
}
$varMessage.='<tr>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;"><p align="center"><strong>Total</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_hits_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_data_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_wifi_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_he_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_uni_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_aac_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_dnd_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_s_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_f_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rtcgc_p_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_srb_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_src_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_s_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_l_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsretry_f_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_s_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_l_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_f_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subs_tot_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_ags_tot_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_agh_tot_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_s_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_l_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_f_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rens_tot_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_smd_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_tdd_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_subsr_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rensr_three).'</strong></td>
			<td style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_revs_three).'</strong></td>
			</tr></table>';		
			
	$error_des=array("E001" => "Invalid request","E002" => "Data not properly populated","E003" => "Vendor not found","E004" => "Data not properly populated","E005" => "Request timeout","E006" => "Authentication error","E007" => "Database insertion failed","E008" => "Subscription type not properly provided","E010" => "Iframe URL successfully generated","E011" => "Iframe URL not generated","E012" => "Renewal transaction success","E013" => "Renewal transaction failed","E014" => "Credit balance Unsuccessful","E015" => "Content confirmation failed","E016" => "User canacled transaction","E017" => "Confirmation request data population error","E018" => "Cannot extract data after confirmation","E019" => "Invallid confirmation request","E020" => "Content successfully confirmed","E021" => "Cannot extract data after cancle page","E022" => "Request time limit exceed","E023" => "Cannot extract data after request timeout","E034" => "Request too old","E035" => "Insufficient balance","E036" => "Vendor not activated. Please contact administrator","E037" => "Transaction amount not met the minimum value","E038" => "Transaction amount exceed the maximum value","E039" => "Transaction amount exceed the daily transaction limit","E040" => "Subscriber balance not found","E041" => "Other transaction success","E042" => "Other transaction Fail","E043" => "OTP verification fail","LB01"=>"Insufficient Funds","LB02"=>"Low balance while subscription","LB03"=>"Subscription Retrial Low balance","E028"=>"Not a valid mobile number");
	
	$GetError=$db['sub']->getResults("SELECT error_code,COUNT(*) as ec FROM charging_history WHERE DATE(added_on)='".date('Y-m-d')."' GROUP BY error_code");
	
	$varMessage.='<h3><b>Error Code Count (Cumulative) : '.date('Y-m-d').' <b></h3>
	<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">';
	foreach($GetError as $val)
	{
		if(!empty($val['error_code']))
						$varMessage.='<span style="color: red;">'.$val['error_code'].'</span> - '.$error_des[$val['error_code']].','; 
	}
	$cp=count($GetError)+1;
	$varMessage.='</i>
	<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr><th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan='.$cp.' >Error codes</th></tr><tr>';
	foreach($GetError as $val)
	{
		if(!empty($val['error_code']))
		$varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" >'.$val['error_code'].'</th>';
		else
		$varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" >Empty</th>';
	}
	$varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" >Total</th></tr><tr>';
	foreach($GetError as $val)
	{
		$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$ect[]=$val['ec'].'</p></td>';
	}
	$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">'.array_sum($ect).'</td></tr></table>';


	$Getprice=$db['sub']->getResults("SELECT rprice,COUNT(*) as ecc FROM charging_history WHERE DATE(added_on)='".date('Y-m-d')."' AND error_code='E012' GROUP BY rprice");
$cpr=count($Getprice)+2;
$varMessage.='<h3><b>Price Point Wise Count : '.date('Y-m-d').' <b></h3>
	<table border="1" cellspacing="0" cellpadding="0" >	  
		<tr><th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" colspan='.$cpr.'>Price Point Report : '.date('Y-m-d').'</th></tr><tr>
		<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">Price</p></td>';
	foreach($Getprice as $val)
	{
		$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$val['rprice'].'</p></td>';
	}
	$varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" >Total</th></tr><tr>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">Count</p></td>';
	foreach($Getprice as $val)
	{
		$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_c[]=$val['ecc'].'</p></td>';
	}
	$varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" >'.array_sum($tot_c).'</th></tr><tr>
	<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">Revenue<p></td>';
	foreach($Getprice as $val)
	{
		$revp=$val['ecc']*$val['rprice'];
		$varMessage.='<td style="font-family:sans-serif;font-size: 12px;padding: 3px;"><p align="center">'.$tot_rev[]=$revp.'</p></td>';
	}
	$varMessage.='<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #8080ff; color: #000; text-align: center" >'.array_sum($tot_rev).'</th></tr></tr></table>';

$msg_content=$varMessage;
/* $to='sakthivel.c@m-tutor.com';
$ccto='kesarivarman.p@m-tutor.com'; */
$to='adalarasu.a@m-tutor.com'; 
$ccto='pk@symbioticinfo.com,pk@m-tutor.com,sundar@symbioticinfo.com,shankar@m-tutor.com,kesarivarman.p@m-tutor.com,senthilkumar.a@m-tutor.com,kalaiarasu.b@m-tutor.com,aishwarya.prasad@m-tutor.com,l1support@symbioticinfo.com,gangadhar.ml@symbioticinfo.com,aniket.sahamate@symbioticinfo.com,hrlyreports@m-tutor.com';
 
$subject = 'Hutch Lanka AWS';
echo $msg_content;


if(!isset($request['send_mail']))
	sendemail($to, $msg_content, $file, $subject, $ccto);
/* function sendemail($email, $msg_content, $attachment = '', $subject, $ccto = '') {
    require_once("mail/mail.class.inc");
    $mail = new Mailer();
    $mail->CharSet = "UTF-8";
    $mail->IsSMTP(); // set mailer to use SMTP
//$mail->Host = "192.168.100.7"; // specify main and backup server
    $mail->Host = "mail.symbioticinfo.com"; // specify main and backup server
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->Port = "587";
    $mail->Username = "alerts"; // SMTP username
    $mail->Password = 'G$d26B@e$4fXz@M9$A'; // SMTP password
    $mail->From = 'alerts@symbioticinfo.com';
    $mail->FromName = 'Hutch Lanka';
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
 */
?>