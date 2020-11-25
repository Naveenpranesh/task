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


class ReportModel {

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


	
		public function find_report()
		{
			global $db , $result,$dt;

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


			$rtcg_data=$db['slave']->getResults(" 	SELECT HOUR(transtime) AS hour_num, COUNT(*) AS rt_cg,
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
													
			$subs_data=$db['slave']->getResults("		SELECT HOUR(added_on) AS hour_num,COUNT(*) AS tot_subtry,
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
			$ren_data=$db['slave']->getResults("		SELECT HOUR(added_on) AS hour_num, COUNT(*) AS tot_ren,
													SUM(CASE WHEN error_code = 'E012' THEN 1 ELSE 0 END )AS ren_suc,
													SUM(CASE WHEN error_code = 'LB01' THEN 1 ELSE 0 END )AS ren_lb,
													SUM(CASE WHEN (error_code != 'LB01' AND error_code != 'E012') THEN 1 ELSE 0 END )AS ren_fail
													FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type='renewal' GROUP BY hour_num ");

			foreach($ren_data as $val)
			{
						$dt[$val['hour_num']]['ren_suc']=$val['ren_suc'];
						$dt[$val['hour_num']]['ren_fail']=$val['ren_fail'];
						$dt[$val['hour_num']]['ren_lb']=$val['ren_lb'];
			}

			$ren_rev_data=$db['slave']->getResults("	SELECT HOUR(added_on) AS hour_num ,SUM(rprice) AS ren_rev
													FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type ='renewal' AND error_code='E012' GROUP BY hour_num ");
			foreach($ren_rev_data as $val)
			{
						$dt[$val['hour_num']]['ren_rev']=$val['ren_rev'];
			}
			$sub_rev_data=$db['slave']->getResults("	SELECT HOUR(added_on) AS hour_num ,SUM(rprice) AS sub_rev
													FROM charging_history WHERE DATE(added_on)=DATE(NOW()) AND trans_type LIKE 'subscription%' AND (error_code='E020' OR error_code='E041') GROUP BY hour_num ");
			foreach($sub_rev_data as $val)
			{
						$dt[$val['hour_num']]['sub_rev']=$val['sub_rev'];
			}											
		
			$subsretry_data=$db['slave']->getResults("		SELECT HOUR(added_on) AS hour_num,COUNT(*) AS tot_subretry,
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
			$smd_deact=$db ['slave']->getResults(" 	SELECT HOUR(sh.unsub_date) AS `hour_num`,COUNT(1) as smd FROM subscription_history sh 
													WHERE sh.deact_mode_id!='0' AND DATE(sh.unsub_date)='".$today."' AND DATE(sh.unsub_date)=DATE(sh.sub_date) 
													GROUP BY HOUR(sh.unsub_date)");
			foreach($smd_deact as $val)
			{
						$dt[$val['hour_num']]['smd']=$val['smd'];
			}	
			$tot_deact=$db ['slave']->getResults("	SELECT HOUR(sh.unsub_date) AS `hour_num`,COUNT(1) as tdd FROM subscription_history sh 
													WHERE sh.deact_mode_id!='0' AND DATE(sh.unsub_date)='".$today."'
													GROUP BY HOUR(sh.unsub_date)");
			foreach($tot_deact as $val)
			{
						$dt[$val['hour_num']]['tdd']=$val['tdd'];
			}
			$get_str_base=$db['slave']->getOneRow("SELECT base_count FROM base_count WHERE `date`=DATE(NOW())");	
			$start_base=$get_str_base['base_count'];
			
			$get_sub_base=$db['slave']->getOneRow("SELECT base_count FROM sub_base_count WHERE `date`=DATE(NOW())");	
			$sub_start_base=$get_sub_base['base_count'];
			
			if(!empty($dt))
				return array($dt,$start_base,$sub_start_base);
			else
				return false;
		}		
				
				public function find_report_month(){

						global $db , $result,$last_three_mon;
						date_default_timezone_set('Asia/Kolkata');
						$last_three_mon=$db['master']->getResults("SELECT DATE_FORMAT(`date`,'%Y-%m') AS mon_val,SUM(`tot_hit`) AS tot_hit,SUM(`uniq_hit`) AS uniq_hit,SUM(`aac`) AS aac,SUM(`dnd`) AS dnd,SUM(`rtcg`) AS rtcg,SUM(`cgs`) AS cgs,SUM(`cgf`) AS cgf,SUM(`cgp`) AS cgp,SUM(`sub_suc`) AS sub_suc,SUM(`sub_low`) AS sub_low,SUM(`sub_fail`) AS sub_fail,SUM(`ren_suc`) AS ren_suc,SUM(`ren_low`) AS ren_low,SUM(`ren_fail`) AS ren_fail,SUM(`sm_deact`) AS sm_deact,SUM(`cs_deact`) AS cs_deact,SUM(`sub_rev`) AS sub_rev,SUM(`ren_rev`) AS ren_rev,SUM(`ags`) AS ags,SUM(`agh`) AS agh,SUM(`data`) AS data,SUM(`wifi`) AS wifi,SUM(`srb`) AS srb,SUM(`src`) AS src,SUM(`subretry_suc`) AS subretry_suc,SUM(`subretry_low`) AS subretry_low,SUM(`subretry_fail`) AS subretry_fail FROM `hourly_flat` WHERE `date`>=('".date('Y-m-d')."' - INTERVAL 3 MONTH) GROUP BY MONTH(`date`)");
				
						return $last_three_mon;
				
				}

					public function find_report_10days(){

						global $db , $result,$last_three_mon;
						date_default_timezone_set('Asia/Kolkata');
						$last_10_days=$db['master']->getResults(" SELECT * FROM hourly_flat WHERE `date`>=('".date('Y-m-d')."' - INTERVAL 11 DAY) GROUP BY `date` ");
				
						return $last_10_days;
				
				}


				public function find_report_GetError(){
					global $db , $GetError;
						$GetError=$db['slave']->getResults("SELECT error_code,COUNT(*) as ec FROM charging_history WHERE DATE(added_on)='".date('Y-m-d')."' GROUP BY error_code");
						return $GetError;
				}

				public function find_report_get_sub_base(){
					global $db,$Getprice;
						$Getprice=$db['slave']->getResults("SELECT rprice,COUNT(*) as ecc FROM charging_history WHERE DATE(added_on)='".date('Y-m-d')."' AND error_code='E012' GROUP BY rprice");
						return $Getprice;
				}
	}
?>