<?php
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

//10days report


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
		echo $varMessage;
	

?>