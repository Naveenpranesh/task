<?php

include 'connect.php';
include 'class.php';


$report1='Hour wise report';
$report2='Date wise report';
$report3='Month wise report';

$sql1 = new report($report1);



$sql3 = new report($report3);

function h_report($sqls,$head){
	include "connect.php";

    $sql = json_decode($sqls);

    $result_one_th = array();
    $result_one_dates = array();

    $result_two_sucess = array();
    $result_two_failed = array();
    $result_two_lb = array();
    $result_two_total = array();


   
    $result_three_sucess = array();
    $result_three_failed= array();
    $result_three_lb = array();
    $result_three_total = array();

    $result_four_revenue = array();



    $html = '<table class="table table-bordered table-responsive">';
    $html .= ' <col>
    <col>
    <colgroup span="3"></colgroup>
    <thead>
    <tr>'.$head.'</tr>';
    $html .='<tr>
            <th rowspan="2" scope="col">Date</th>
            <th rowspan="2" scope="col">totalhit</th>
            <th colspan="4" scope="colgroup">changeshistory</th>
            <th colspan="4" scope="colgroup">Subscribtions</th>
            <th rowspan="2" scope="colgroup">Revenue</th>
        </tr>

        <tr>

            <th>Success</th>
            <th>Failed</th>
            <th>LB</th>
            <th>Total</th>

            <th>Success</th>
            <th>Failed</th>
            <th>LB</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    ';
     
   
	$resultset=mysqli_query($conn,$sql->th);
	$r_count=mysqli_num_rows($resultset);
		if($r_count>0)
		{	
			while($row=mysqli_fetch_assoc($resultset)) 
			{
                $field0=$row["dates"];
                $field1=$row["th"];
                
                array_push($result_one_th, $field1);
                array_push($result_one_dates, $field0);

      
            }
        } 
        

        $resultset2=mysqli_query($conn,$sql->sub);
	$r_count2=mysqli_num_rows($resultset2);
		if($r_count2>0)
		{	
			while($row2=mysqli_fetch_assoc($resultset2)) 
			{
                $field2=$row2["Success"];
                $field3=$row2["failed"];
                $field4=$row2["lb"];
                $field5=$row2["total"];
                

                array_push($result_two_sucess, $field2);
                array_push($result_two_failed, $field3);
                array_push($result_two_lb, $field4);
                array_push($result_two_total,$field5,);
              
               

            }
        } 
     
        $resultset3=mysqli_query($conn,$sql->cg);
        $r_count3=mysqli_num_rows($resultset3);
            if($r_count3>0)
            {	
                while($row3=mysqli_fetch_assoc($resultset3)) 
                {
                    $field6=$row3["Success"];
                    $field7=$row3["failed"];
                    $field8=$row3["lb"];
                    $field9=$row3["total"];
 
                array_push($result_three_sucess, $field6);
                array_push($result_three_failed, $field7);
                array_push($result_three_lb, $field8);
                array_push($result_three_total,$field9);
                
    
                }
            } 


            $resultset4=mysqli_query($conn,$sql->rev);
            $r_count4=mysqli_num_rows($resultset4);
                if($r_count4>0)
                {	
                    while($row4=mysqli_fetch_assoc($resultset4)) 
                    {
                        $field10=$row4["revenue"];
                        
     
                    array_push($result_four_revenue, $field10);
                   
                    
        
                    }
                } 

    foreach ($result_one_dates as $id=>$key){
        $cg_total=0;
        $cg_total=$result_two_sucess[$id]+$result_two_failed[$id]+$result_two_lb[$id];

        $sub_total=0;
        $sub_total=$result_three_sucess[$id]+$result_three_failed[$id]+$result_three_lb[$id];

        $th_total+=$result_one_th[$id];
        $two_suc_total+=$result_two_sucess[$id];
        $two_fail_total+=$result_two_failed[$id];
        $two_lb_total+=$result_two_lb[$id];
        $two_total+=$cg_total;

        $three_suc_total+=$result_three_sucess[$id];
        $three_fail_total+=$result_three_failed[$id];
        $three_lb_total+=$result_three_lb[$id];
        $three_total+=$sub_total;
        $rev+=$result_four_revenue[$id];

                $html .= "<td>".$result_one_dates[$id].'</td>';
                $html .= "<td>".$result_one_th[$id].'</td>';
           
              
                $html .= "<td>".$result_two_sucess[$id].'</td>';
                $html .= "<td>".$result_two_failed[$id].'</td>';
                $html .= "<td>".$result_two_lb[$id].'</td>';
                $html .= "<td>".$result_two_total[$id].'</td>';
              
                $html .= "<td>".$result_three_sucess[$id].'</td>';
                $html .= "<td>".$result_three_failed[$id].'</td>';
                $html .= "<td>".$result_three_lb[$id].'</td>';
                $html .= "<td>".$result_three_total[$id].'</td>';

                $html .= "<td>".$result_four_revenue[$id].'</td>';

           $html .= "</tr>";  
        

      
    }

    $html .= '</tbody>';
    $html.='<tfoot>
    <tr>
      <td>Total</td>
      <td>'.$th_total.'</td>
      <td>'.$two_suc_total.'</td>
      <td>'.$two_fail_total.'</td>
      <td>'.$two_lb_total.'</td>
      <td>'.$two_total.'</td>
      
      <td>'.$three_suc_total.'</td>
      <td>'.$three_fail_total.'</td>
      <td>'.$three_lb_total.'</td>
      <td>'.$three_total.'</td>
      <td>'.$rev.'</td>
    </tr>
  </tfoot>';


return $html;
	}


    function m_d_report($sqls,$head){
        include "connect.php";
    
        $sql = json_decode($sqls);
    
        $result_one_th = array();
        $result_one_dates = array();
    
        $result_two_sucess = array();
        $result_two_failed = array();
        $result_two_lb = array();
        $result_two_total = array();
    
    
       
        $result_three_sucess = array();
        $result_three_failed= array();
        $result_three_lb = array();
        $result_three_total = array();
    
        $result_four_revenue = array();
    
    
    
        $html = '<table class="table table-bordered table-responsive ">';
        $html .= ' <col>
        <col>
        <colgroup span="3"></colgroup>
        <thead>
        <tr>'.$head.'</tr>';
        $html .='<tr>
                <th rowspan="2" scope="col">Date</th>
                <th rowspan="2" scope="col">totalhit</th>
                <th colspan="4" scope="colgroup">changeshistory</th>
                <th colspan="4" scope="colgroup">Subscribtions</th>
                <th rowspan="2" scope="colgroup">Revenue</th>
            </tr>
    
            <tr>
    
                <th>Success</th>
                <th>Failed</th>
                <th>LB</th>
                <th>Total</th>
    
                <th>Success</th>
                <th>Failed</th>
                <th>LB</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        ';
         
       
        $resultset=mysqli_query($conn,$sql->th);
        $r_count=mysqli_num_rows($resultset);
            if($r_count>0)
            {	
                while($row=mysqli_fetch_assoc($resultset)) 
                {
                    $field0=$row["dates"];
                    $field1=$row["total_hits"];

                    $field2=$row["cg_suc"];
                    $field3=$row["cg_fail"];
                    $field4=$row["cg_pend"];

                    // $field5=$row["cg_total"];

                    $field6=$row["sub_retry_suc"];
                    $field7=$row["sub_retry_fail"];
                    $field8=$row["sub_retry_lb"];

                    // $field9=$row["sub_total"];

                    $field10=$row["sub_revenue"];
                   
                    array_push($result_one_th, $field1);
                    array_push($result_one_dates, $field0);

                    array_push($result_two_sucess, $field2);
                    array_push($result_two_failed, $field3);

                    array_push($result_two_lb, $field4);
                    // array_push($result_two_total, $field5);

                    array_push($result_three_sucess, $field6);
                    array_push($result_three_failed, $field7);

                    array_push($result_three_lb, $field8);
                    // array_push($result_three_total, $field9);

                    array_push($result_four_revenue, $field10);
    
          
                }
            } 
       
        foreach ($result_one_dates as $id=>$key){
            
            $cg_total=0;
            $cg_total=$result_two_sucess[$id]+$result_two_failed[$id]+$result_two_lb[$id];

            $sub_total=0;
            $sub_total=$result_three_sucess[$id]+$result_three_failed[$id]+$result_three_lb[$id];

            $th_total+=$result_one_th[$id];
            $two_suc_total+=$result_two_sucess[$id];
            $two_fail_total+=$result_two_failed[$id];
            $two_lb_total+=$result_two_lb[$id];
            $two_total+=$cg_total;

            $three_suc_total+=$result_three_sucess[$id];
            $three_fail_total+=$result_three_failed[$id];
            $three_lb_total+=$result_three_lb[$id];
            $three_total+=$sub_total;

            $rev+=$result_four_revenue[$id];
    
                    $html .= "<td>".$result_one_dates[$id].'</td>';
                    $html .= "<td>".$result_one_th[$id].'</td>';
               
                  
                    $html .= "<td>".$result_two_sucess[$id].'</td>';
                    $html .= "<td>".$result_two_failed[$id].'</td>';
                    $html .= "<td>".$result_two_lb[$id].'</td>';
                    $html .= "<td>".$cg_total.'</td>';
                  
                    $html .= "<td>".$result_three_sucess[$id].'</td>';
                    $html .= "<td>".$result_three_failed[$id].'</td>';
                    $html .= "<td>".$result_three_lb[$id].'</td>';


                    $html .= "<td>".$sub_total.'</td>';

                    $html .= "<td>".$result_four_revenue[$id].'</td>';
                   
                 
    
                  
    
               $html .= "</tr>";  
            
    
          
        }
    
    $html .= '</tbody>';
    $html.='<tfoot>
    <tr>
      <td>Total</td>
      <td>'.$th_total.'</td>
      <td>'.$two_suc_total.'</td>
      <td>'.$two_fail_total.'</td>
      <td>'.$two_lb_total.'</td>
      <td>'.$two_total.'</td>
      
      <td>'.$three_suc_total.'</td>
      <td>'.$three_fail_total.'</td>
      <td>'.$three_lb_total.'</td>
      <td>'.$three_total.'</td>
      <td>'.$rev.'</td>
    </tr>
  </tfoot>
  <br>
  <br>';



    $html .='</table>';
    
    return $html;
        }

        
?>

<!DOCTYPE HTML>
<html>

<body>

    <head>
        <title>Report</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
    </head>

    <div>
        <div>

            <?php   $result1 =   h_report($sql1->sql(),'HOUR WISE REPORT:'); echo $result1; ?>
        </div>
        <div>
            <?php   $sql2 = new report($report2);  $result2 =   m_d_report($sql2->sql(),'DATE WISE REPORT:'); echo $result2; ?>
        </div>
        <div>
           
            <?php  $result3 =   m_d_report($sql3->sql(),'MONTH WISE REPORT:'); echo $result3; ?>
        </div>

    </div>

</body>

</html>