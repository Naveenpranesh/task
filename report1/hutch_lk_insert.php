<?php
ini_set('display_errors', 1); 
define("DB_CONNECTIONS","master,sub");
include_once("../framework/initialise/framework.init.php");
include_once("../framework/initialise/helper.php");
global $library,$request,$db,$curl,$libxml,$log,$viewclass,$mail;
date_default_timezone_set('Asia/Kolkata');
$today= date('Y-m-d',strtotime('-1 day'));
$today_tb= date('Ymd',strtotime('-1 day'));
$date_check=date('d',strtotime($today));
if(date('d')=='01')
	$table='charging_history_'.$today_tb;
else
	$table='charging_history';
/* echo $date_check;
echo $table;
exit; */
/* $today= date('Y-m-d',strtotime('-2 day'));
$today_tb= date('Ymd',strtotime('-2 day'));
$table='charging_history_'.$today_tb;
 */
$he_details=$db['master']->getResults("	SELECT date(transtime) AS hour_num,COUNT(*) AS tot_hits,SUM(CASE WHEN msisdn ='empty' THEN 1 ELSE 0 END) AS wifi,
										SUM(CASE WHEN (msisdn !='empty' AND msisdn !='')  THEN 1 ELSE 0 END) AS `data`
										FROM he_details WHERE DATE(transtime)='".$today."' GROUP BY  hour_num");
foreach($he_details as $val)
{
			$dt[$val['hour_num']]['tot_hits']=$val['tot_hits'];
			$dt[$val['hour_num']]['wifi']=$val['wifi'];
			$dt[$val['hour_num']]['data']=$val['data'];
}	

$tot_hits_data=$db['master']->getResults("	SELECT DATE(transtime) AS hour_num, COUNT(*) AS tot_hits,COUNT( DISTINCT msisdn ) AS unique_hits ,
										SUM(CASE WHEN user_status = 'ALREADY ACTIVE' THEN 1 ELSE 0 END )AS aac,
										SUM(CASE WHEN user_status = 'DND' THEN 1 ELSE 0 END )AS dnd
										FROM hit_analysis WHERE DATE(transtime)='".$today."' GROUP BY hour_num ");
foreach($tot_hits_data as $val)
{
			$dt[$val['hour_num']]['tot_hits_ha']=$val['tot_hits'];
			$dt[$val['hour_num']]['uniq_hits']=$val['unique_hits'];
			$dt[$val['hour_num']]['DND']=$val['dnd'];
			$dt[$val['hour_num']]['AAC']=$val['aac'];
}
$rtcg_data=$db['sub']->getResults("		SELECT DATE(transtime) AS hour_num, COUNT(*) AS rt_cg,
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
$subs_data=$db['sub']->getResults("		SELECT DATE(added_on) AS hour_num,COUNT(*) AS tot_subtry,
										SUM(CASE WHEN (error_code = 'E020') THEN 1 ELSE 0 END )AS sub_suc,
										SUM(CASE WHEN (error_code = 'E035' OR error_code = 'LB02') THEN 1 ELSE 0 END )AS sub_lb,
										SUM(CASE WHEN (error_code != 'E020' AND error_code != 'E035' AND error_code != 'LB02') THEN 1 ELSE 0 END )AS sub_fail
										FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type ='subscription' GROUP BY hour_num ");
foreach($subs_data as $val)
{
			$dt[$val['hour_num']]['tot_subtry']=$val['tot_subtry'];
			$dt[$val['hour_num']]['sub_suc']=$val['sub_suc'];
			$dt[$val['hour_num']]['sub_lb']=$val['sub_lb'];
			$dt[$val['hour_num']]['sub_fail']=$val['sub_fail'];
}

$get_sub_base=$db['sub']->getOneRow("SELECT base_count FROM sub_base_count WHERE `date`='".$today."' ");	
$sub_start_base=$get_sub_base['base_count'];
	
$subsretry_data=$db['sub']->getResults("SELECT DATE(added_on) AS hour_num,COUNT(*) AS tot_subretry,
										SUM(CASE WHEN (error_code = 'E041') THEN 1 ELSE 0 END )AS subretry_suc,
										SUM(CASE WHEN (error_code = 'E035' OR error_code ='LB03' ) THEN 1 ELSE 0 END )AS subretry_lb,
										SUM(CASE WHEN (error_code != 'E035' AND error_code !='LB03') THEN 1 ELSE 0 END )AS subretry_fail
										FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type ='subscription_retry' GROUP BY hour_num ");
foreach($subsretry_data as $val)
{			
			$dt[$val['hour_num']]['subretry_tot']=$val['tot_subretry'];
			$dt[$val['hour_num']]['subretry_suc']=$val['subretry_suc'];
			$dt[$val['hour_num']]['subretry_lb']=$val['subretry_lb'];
			$dt[$val['hour_num']]['subretry_fail']=$val['subretry_fail'];
}
$ren_data=$db['sub']->getResults("		SELECT DATE(added_on) AS hour_num, COUNT(*) AS tot_ren,
										SUM(CASE WHEN error_code = 'E012' THEN 1 ELSE 0 END )AS ren_suc,
										SUM(CASE WHEN error_code = 'LB01' THEN 1 ELSE 0 END )AS ren_lb,
										SUM(CASE WHEN (error_code != 'LB01' AND error_code != 'E012') THEN 1 ELSE 0 END )AS ren_fail
										FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type='renewal' GROUP BY hour_num ");
$ren_data_uniql=$db['sub']->getResults("SELECT DATE(added_on) AS hour_num, COUNT( DISTINCT CONCAT(mobile_num,'~',service_details_id)) AS renu_l
										FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type='renewal' AND error_code='LB01' AND subscription_id NOT IN 
										( SELECT subscription_id FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type='renewal' AND error_code='E012')
										GROUP BY hour_num ");
$ren_data_uniqf=$db['sub']->getResults("		SELECT DATE(added_on) AS hour_num, COUNT( DISTINCT CONCAT(mobile_num,'~',service_details_id)) AS renu_f
										FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type='renewal' AND error_code!='LB01' and error_code!='E012' AND subscription_id NOT IN 
										( SELECT subscription_id FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type='renewal' AND error_code IN ('E012','LB01'))
										GROUP BY hour_num ");
foreach($ren_data as $val)
{
			$dt[$val['hour_num']]['ren_suc']=$val['ren_suc'];
			$dt[$val['hour_num']]['ren_fail']=$val['ren_fail'];
			$dt[$val['hour_num']]['ren_lb']=$val['ren_lb'];
}
foreach($ren_data_uniql as $val)
{
	$dt[$val['hour_num']]['ren_fail_ul']=$val['renu_l'];
}
foreach($ren_data_uniqf as $val)
{
	$dt[$val['hour_num']]['ren_fail_uf']=$val['renu_f'];
}
$ren_rev_data=$db['sub']->getResults("	SELECT DATE(added_on) AS hour_num ,SUM(rprice) AS ren_rev
										FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type ='renewal' AND error_code='E012' GROUP BY hour_num ");
foreach($ren_rev_data as $val)
{
			$dt[$val['hour_num']]['ren_rev']=$val['ren_rev'];
}
$sub_rev_data=$db['sub']->getResults("	SELECT DATE(added_on) AS hour_num ,SUM(rprice) AS sub_rev
										FROM ".$table." WHERE DATE(added_on)='".$today."' AND trans_type LIKE 'subscription%' AND error_code IN ('E020','E041') GROUP BY hour_num ");
foreach($sub_rev_data as $val)
{
			$dt[$val['hour_num']]['sub_rev']=$val['sub_rev'];
}											
	
$ag_det=$db['master']->getResults("		SELECT COUNT(*) as agency_holds,DATE(dateandtime) as agency_hour, response 
										FROM agent_hit_analysis 
										WHERE DATE(dateandtime)='".$today."'
										GROUP BY agency_hour, response");		
foreach($ag_det as $val)
{
			$dt[$val['agency_hour']]['response']=$val['agency_holds'];
}					
$smd_deact=$db ['sub']->getResults(" 	SELECT DATE(sh.unsub_date) AS `hour_num`,COUNT(1) as smd FROM subscription_history sh 
										WHERE sh.deact_mode_id!='0' AND DATE(sh.unsub_date)='".$today."' AND DATE(sh.unsub_date)=DATE(sh.sub_date) 
										GROUP BY DATE(sh.unsub_date)");
foreach($smd_deact as $val)
{
			$dt[$val['hour_num']]['smd']=$val['smd'];
}	
$tot_deact=$db ['sub']->getResults("	SELECT DATE(sh.unsub_date) AS `hour_num`,COUNT(1) as tdd FROM subscription_history sh 
										WHERE sh.deact_mode_id!='0' AND DATE(sh.unsub_date)='".$today."'
										GROUP BY DATE(sh.unsub_date)");
foreach($tot_deact as $val)
{
			$dt[$val['hour_num']]['tdd']=$val['tdd'];
}
$get_str_base=$db['sub']->getOneRow("SELECT base_count FROM base_count WHERE `date`='".$today."'");
$start_base=$get_str_base['base_count'];

$i=$today;

	$tot_hits_val=isset($dt[$i]["tot_hits"])?$dt[$i]["tot_hits"]:"0";
	$tot_wifi_val=isset($dt[$i]["wifi"])?$dt[$i]["wifi"]:"0";
	$tot_data_val=isset($dt[$i]["data"])?$dt[$i]["data"]:"0";
	$tot_hits_ha_val=isset($dt[$i]["tot_hits_ha"])?$dt[$i]["tot_hits_ha"]:"0";
	$uni_hits=isset($dt[$i]["uniq_hits"])?$dt[$i]["uniq_hits"]:"0";
	$aac=isset($dt[$i]["AAC"])?$dt[$i]["AAC"]:"0";
	$dnd=isset($dt[$i]["DND"])?$dt[$i]["DND"]:"0";
	$rtcgc=isset($dt[$i]['rt_cg'])?$dt[$i]['rt_cg']:'0';
	$rtcgc_s=isset($dt[$i]['cg_succ'])?$dt[$i]['cg_succ']:'0';
	$rtcgc_f=isset($dt[$i]['cg_fail'])?$dt[$i]['cg_fail']:'0';
	$rtcgc_p=isset($dt[$i]['cg_pend'])?$dt[$i]['cg_pend']:'0';
	
	$subsretry_t=isset($dt[$i]['subretry_tot'])?$dt[$i]['subretry_tot']:'0';
	$subsretry_s=isset($dt[$i]['subretry_suc'])?$dt[$i]['subretry_suc']:'0';
	$subsretry_l=isset($dt[$i]['subretry_lb'])?$dt[$i]['subretry_lb']:'0';
	$subsretry_f=isset($dt[$i]['subretry_fail'])?$dt[$i]['subretry_fail']:'0';
	
	$subs_s=isset($dt[$i]['sub_suc'])?$dt[$i]['sub_suc']:'0';
	$subs_l=isset($dt[$i]['sub_lb'])?$dt[$i]['sub_lb']:'0';
	$subs_f=isset($dt[$i]['sub_fail'])?$dt[$i]['sub_fail']:'0';
	$subs_tot=$subs_s+$subs_l+$subs_f;
	
	$ags=isset($dt[$i]['Success'])?$dt[$i]['Success']:'0';
	$agh=isset($dt[$i]['HOLD'])?$dt[$i]['HOLD']:'0';
	
	$rens_s=isset($dt[$i]['ren_suc'])?$dt[$i]['ren_suc']:'0';
	$rens_l=isset($dt[$i]['ren_fail_ul'])?$dt[$i]['ren_fail_ul']:'0';
	$rens_f=isset($dt[$i]['ren_fail_uf'])?$dt[$i]['ren_fail_uf']:'0';
	
	/* $rens_ul=isset($dt[$i]['ren_fail_ul'])?$dt[$i]['ren_fail_ul']:'0';
	$rens_f=isset($dt[$i]['ren_oth'])?$dt[$i]['ren_oth']:'0';
	$rens_uf=isset($dt[$i]['ren_fail_uf'])?$dt[$i]['ren_fail_uf']:'0'; */
	$rens_tot=$rens_s+$rens_l+$rens_f;
	
	$rens_lr=$start_base-$rens_s;
	
	$smd=isset($dt[$i]['smd'])?$dt[$i]['smd']:'0';
	$tdd=isset($dt[$i]['tdd'])?$dt[$i]['tdd']:'0';
	
	$subs_rev=isset($dt[$i]['sub_rev'])?$dt[$i]['sub_rev']:'0';
	$rens_rev=isset($dt[$i]['ren_rev'])?$dt[$i]['ren_rev']:'0';
	$tots_rev=$subs_rev+$rens_rev;
	
	
	echo $ins_qry="INSERT INTO `hourly_flat`
            (
             `date`,
             `tot_hit`,
             `uniq_hit`,
             `aac`,
             `dnd`,
             `rtcg`,
             `cgs`,
             `cgf`,
             `cgp`,
             `sub_suc`,
             `sub_low`,
             `sub_fail`,
             `ren_suc`,
             `ren_low`,
             `ren_fail`,
             `sm_deact`,
             `cs_deact`,
             `sub_rev`,
             `ren_rev`,
			 `ags`,
			 `agh`,
			 `wifi`,
			 `data`,
			 `hit_ha`,
			 `srb`,
			 `src`,
			 `subretry_suc`,
			 `subretry_low`,
			 `subretry_fail`)
		VALUES (
			'$i',
			'$tot_hits_val',
			'$uni_hits',
			'$aac',
			'$dnd',
			'$rtcgc',
			'$rtcgc_s',
			'$rtcgc_f',
			'$rtcgc_p',
			'$subs_s',
			'$subs_l',
			'$subs_f',
			'$rens_s',
			'$rens_l',
			'$rens_f',
			'$smd',
			'$tdd',
			'$subs_rev',
			'$rens_rev',
			'$ags',
			'$agh',
			'$tot_wifi_val',
			'$tot_data_val',
			'$tot_hits_ha_val',
			'$sub_start_base',
			'$subsretry_t',
			'$subsretry_s',
			'$subsretry_l',
			'$subsretry_f');";
$ins_cmd=$db['master']->query($ins_qry);
?>