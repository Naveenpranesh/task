<div class="content-wrapper">
    <section class="content-header">
        <h1>TrueMove Revenue Report</h1>
    </section>
    <section class="content">
        <div class="box box-default">
            <div class="box-body">
                <?php
				$last=date('Y-m-d',strtotime('-1 day'));   
				$to=date('Y-m-d',strtotime('-2 day')); 
				$curr_mon=date('Y-m');
				$prev_mon=date('Y-m',strtotime('-1 month'));
				$two_month=date('Y-m',strtotime('-2 month'));
				$to_date=date('Y-m-d',strtotime('-2 day')); 
				$from_date=date('Y-m-d', strtotime('-11 days'));  
				$report_msg='<h2><strong>Last Day Report</strong></h2>
				
				<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">
						<span style="color: red;">New Sub</span> - New Subscription,
						<span style="color: red;">Unsub</span> - Unsubscription ,  
						<span style="color: red;">Active Sub</span> - Active Subscription ,
						<span style="color: red;">Total Tans</span> - Total Transfer ,
						<span style="color: red;">MT Success</span> -Mtutor Success ,
						<span style="color: red;">Sym</span> -Symbiotic ,
						<span style="color: red;">Part</span> -Partner 
				</i>
				
				<table border="1" cellspacing="0" cellpadding="0" >
				
				<tr>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="10" >TrueMove Last Day Report - '.$last.'</th>
				</tr>
				<tr>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center;" rowspan="2">Date</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="5" >Subscription Details </th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="4" >Revenue Details </th>
				</tr>
				
				
				
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >New Sub</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Un Sub</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Active Sub</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Total Trans</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >MT Success</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center;">TrueMove<br>Revenue</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Sym and<br>part Revenue</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >part<br>Revenue</th>
				<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Sym<br> Revenue</th></tr>';
				
				$date=isset($day_report['date'])?$day_report['date']:$last;
				$newsub=isset($day_report['new_sub'])?$day_report['new_sub']:'0';
				$unsub=isset($day_report['un_sub'])?$day_report['un_sub']:'0';
				$activesub=isset($day_report['active_sub'])?$day_report['active_sub']:'0';
				$totaltrans=isset($day_report['total_trans'])?$day_report['total_trans']:'0';
				$mtsuccess=isset($day_report['mt_success'])?$day_report['mt_success']:'0';
					$true=round(($mtsuccess*3),2);
					$sym_part=round(($true*0.5),2);
					$sym=round(($sym_part*0.75),2);
					$part=round(($sym_part*0.25),2);
					
					/* $true=ceil(($mtsuccess*3));
					$sym_part=ceil(($true*0.5));
					$sym=ceil(($sym_part*0.75));
					$part=ceil(($sym_part*0.25)); */
				$report_msg.='<tr><td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$date.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$newsub.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$unsub.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$activesub.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$totaltrans.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$mtsuccess.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$true.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$sym_part.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$part.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
								<p align="center">'.$sym.'</p></td>
							</tr></table>';
				/* $report_msg.='<tr>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>Total</p></strong></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$newsub.'</p></strong></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$unsub.'</p></strong></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$activesub.'</strong></p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$totaltrans.'</strong></p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$mtsuccess.'</strong></p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$true.'</strong></p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$sym_part.'</strong></p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$part.'</strong></p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.$sym.'</strong></p></td>
							</tr></table>'; */
			
				   
				$report_msg.='<h2><strong>Last 10 Days Report</strong></h2> 
									<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">
										<span style="color: red;">New Sub</span> - New Subscription,
										<span style="color: red;">Unsub</span> - Unsubscription ,  
										<span style="color: red;">Active Sub</span> - Active Subscription ,
										<span style="color: red;">Total Tans</span> - Total Transfer ,
										<span style="color: red;">MT Success</span> -Mtutor Success ,
										<span style="color: red;">Sym</span> -Symbiotic ,
										<span style="color: red;">Part</span> -Partner 
								</i>
							<table border="1" cellspacing="0" cellpadding="0" >
							
							<tr>
								<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="10" >TrueMove Last 10 Days Report - From '.$from_date.' To '.$to_date.'</th>
							</tr>
							  <tr>
							  <th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center;" rowspan="2">Date</th>
								<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="5" >Subscription Details </th>
								<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="4" >Revenue Details </th>
								</tr>
							<tr>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >New Sub</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Un Sub</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Active Sub</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Total Trans</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >MT Success</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center;">TrueMove<br>Revenue</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Sym and<br>part Revenue</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >part<br>Revenue</th>
							<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Sym<br> Revenue</th></tr>';
				$date_range=array();
				array_push($date_range,$to);
				for($j=1;$j<=9;$j++)
				{
					array_push($date_range,date('Y-m-d', strtotime("-".$j." day",strtotime ($to))));
				}
				foreach($last10_days_report as $val)
				{
					$day_dt[$val['date']]['new_sub']=$val['new_sub'];		
					$day_dt[$val['date']]['un_sub']=$val['un_sub'];		
					$day_dt[$val['date']]['active_sub']=$val['active_sub'];		
					$day_dt[$val['date']]['total_trans']=$val['total_trans'];		
					$day_dt[$val['date']]['mt_success']=$val['mt_success'];		
				}
				foreach($date_range as $days_report)
				{
					$newsub=isset($day_dt[$days_report]['new_sub'])?$day_dt[$days_report]['new_sub']:'0';
					$unsub=isset($day_dt[$days_report]['un_sub'])?$day_dt[$days_report]['un_sub']:'0';
					$activesub=isset($day_dt[$days_report]['active_sub'])?$day_dt[$days_report]['active_sub']:'0';
					$totaltrans=isset($day_dt[$days_report]['total_trans'])?$day_dt[$days_report]['total_trans']:'0';
					$mtsuccess=isset($day_dt[$days_report]['mt_success'])?$day_dt[$days_report]['mt_success']:'0';
					$true=round(($mtsuccess*3),2);
					$sym_part=round(($true*0.5),2);
					$sym=round(($sym_part*0.75),2);
					$part=round(($sym_part*0.25),2);
								
				$report_msg.='<tr>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$days_report.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_newsub[]=$newsub.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_unsub[]=$unsub.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_actsub[]=$activesub.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_trans[]=$totaltrans.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_mt[]=$mtsuccess.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_rev[]=$true.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_sp[]=$sym_part.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_p[]=$part.'</p></td>
								<td style="font-family:sans-serif;font-size: 12px;padding: 3px;">
									<p align="center">'.$tot_s[]=$sym.'</p></td>
							</tr>';
					}
				$report_msg.='<tr>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>Total</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_newsub).'</p></strong></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_unsub).'</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_actsub).'</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_trans).'</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_mt).'</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rev).'</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sp).'</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_p).'</strong></p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_s).'</strong></p></td>
					</tr></table>';
				
				
				
			$from_month=date( "F" , strtotime($two_month));
			$to_month=date( "F" , strtotime($curr_mon));
				
				$report_msg.='<h2><strong>Last 3 Months Report</strong></h2>
				
				<i style="font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size: 13px;">
						<span style="color: red;">New Sub</span> - New Subscription,
						<span style="color: red;">Unsub</span> - Unsubscription ,  
						<span style="color: red;">Active Sub</span> - Active Subscription ,
						<span style="color: red;">Total Tans</span> - Total Transfer ,
						<span style="color: red;">MT Success</span> -Mtutor Success ,
						<span style="color: red;">Sym</span> -Symbiotic ,
						<span style="color: red;">Part</span> -Partner 
				</i>
					<table border="1" cellspacing="0" cellpadding="0" >
					
					<tr>
								<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="10" >TrueMove Last 3 Months Report - From '.$from_month.' To '.$to_month.'</th>
					</tr>
					<tr>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center;" rowspan="2">Month</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="5" >Subscription Details </th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color: #88b5fc; color: #000; text-align: center" colspan="4" >Revenue Details </th>
					</tr>
					<tr>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >New Sub</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Un Sub</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Active Sub</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Total Trans</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >MT Success</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center;">TrueMove<br>Revenue</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Sym and<br>part Revenue</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >part<br>Revenue</th>
					<th style="font-family:sans-serif;font-size: 12px;padding: 5px;border: 1px solid #000; background-color:  #88b5fc; color:#000; text-align: center" >Sym<br> Revenue</th></tr>';
				/* print_r($last3_months_report);
				echo $to_monthss;
				echo $from_monthss; */
				$mon_range=array();
				array_push($mon_range,$curr_mon,$prev_mon,$two_month);
				foreach($last3_months_report as $val)
				{
					$day_dt1[$val['mon_val']]['new_sub']=$val['new_sub'];		
					$day_dt1[$val['mon_val']]['un_sub']=$val['un_sub'];		
					$day_dt1[$val['mon_val']]['active_sub']=$val['active_sub'];		
					$day_dt1[$val['mon_val']]['total_trans']=$val['total_trans'];		
					$day_dt1[$val['mon_val']]['mt_success']=$val['mt_success'];		
				}
						
				foreach($mon_range as $months_report)
				{
							
					$newsub=isset($day_dt1[$months_report]['new_sub'])?$day_dt1[$months_report]['new_sub']:'0';
					$unsub=isset($day_dt1[$months_report]['un_sub'])?$day_dt1[$months_report]['un_sub']:'0';
					$activesub=isset($day_dt1[$months_report]['active_sub'])?$day_dt1[$months_report]['active_sub']:'0';
					$totaltrans=isset($day_dt1[$months_report]['total_trans'])?$day_dt1[$months_report]['total_trans']:'0';
					$mtsuccess=isset($day_dt1[$months_report]['mt_success'])?$day_dt1[$months_report]['mt_success']:'0';
					$true=round(($mtsuccess*3),2);
					$sym_part=round(($true*0.5),2);
					$sym=round(($sym_part*0.75),2);
					$part=round(($sym_part*0.25),2);
						
				$month_val = date( "F" , strtotime($months_report));
				$report_msg.='<tr><td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$month_val.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_newsub1[]=$newsub.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_unsub1[]=$unsub.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_actsub1[]=$activesub.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_trans1[]=$totaltrans.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_mt1[]=$mtsuccess.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_rev1[]=$true.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_sp1[]=$sym_part.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_p1[]=$part.'</p></td>
							<td style="font-family:sans-serif;font-size: 12px;padding: 5px;">
								<p align="center">'.$tot_s1[]=$sym.'</p></td>
							</tr>';
				}
				
				$report_msg.='<tr>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>Total</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_newsub1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_unsub1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_actsub1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_trans1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_mt1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_rev1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_sp1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_p1).'</strong></p></td>
					<td style="font-family:sans-serif;font-size: 12px;padding: 3px;border: 1px solid #000; background-color:  #88b5fc; color: #000; text-align: center;><p align="center"><strong>'.array_sum($tot_s1).'</strong></p></td>
					</tr></table>';
					
					
				echo $report_msg;
				 ?>
                <br>
                <!--<center>
	<div class="row form-group">
		<div class=" col-md-1 ">
			<a id="send_mail" class="btn btn-success btn-md"  style="margin-left: 10px;" href="<?php echo APPLICATION_URL . 'gateway/action?application=truemove&action=send_email'; ?>">Send Email</a> 
		</div>
	</div></center>-->
    </section>
</div>