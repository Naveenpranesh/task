<?php
error_reporting(0);
include 'connect.php';

class report{
    private $type;

    public function __construct($type){
       
        $this->type=$type;
    }

    public function sql(){

        switch($this->type){
        
        case "Hour wise report":{

            $csql->th = "SELECT  HOUR(transtime) AS dates,COUNT(transtime) as th    
            FROM     hit_analysis
            WHERE    transtime BETWEEN
                           DATE_FORMAT(NOW() - INTERVAL 96 HOUR, '%Y-%m-%d %H:00:00')
                       AND NOW()
            GROUP BY dates
            ORDER BY dates";

        $csql->sub="SELECT HOUR(charging_history.sub_date) AS dates,COUNT(case error_code when '0' then 1 else null end ) as Success,COUNT(case error_code when '221' then 1 else null end ) as failed ,COUNT(case error_code when '202' then 1 else null end ) as lb,(COUNT(case error_code when '0' then 1 else null end ) + COUNT(case error_code when '221' then 1 else null end )+ COUNT(case error_code when '202' then 1 else null end )) as total from charging_history  

        INNER JOIN  subscription on charging_history.subscription_id= subscription.subscription_id
        
        WHERE    charging_history.sub_date BETWEEN DATE_FORMAT(NOW() - INTERVAL 96 HOUR, '%Y-%m-%d %H:00:00')
                               AND NOW()
                    GROUP BY dates
                    ORDER BY dates";
        

            $csql->rev="SELECT HOUR(sub_date) AS dates,SUM(case error_code when '0' then price else 0 end) as revenue FROM charging_history  WHERE sub_date BETWEEN DATE_FORMAT(NOW() - INTERVAL 96 HOUR, '%Y-%m-%d %H:00:00')
                        AND NOW()
                        GROUP BY dates
                        ORDER BY dates";


                    $csql->cg="SELECT HOUR(charging_history.sub_date) AS dates,COUNT(case error_code when '0' then 1 else null end ) as Success,COUNT(case error_code when '221' then 1 else null end ) as failed ,COUNT(case error_code when '202' then 1 else null end ) as lb ,(COUNT(case error_code when '0' then 1 else null end ) + COUNT(case error_code when '221' then 1 else null end )+ COUNT(case error_code when '202' then 1 else null end )) as total from charging_history  

                    WHERE    charging_history.sub_date BETWEEN DATE_FORMAT(NOW() - INTERVAL 96 HOUR, '%Y-%m-%d %H:00:00')
                                           AND NOW()
                                GROUP BY dates
                                ORDER BY dates";

        $sql = json_encode($csql);
          return $sql;
        break;
        }
        
        case "Date wise report":{

            $csql->th = "SELECT  DAY(date) AS dates,total_hits,cg_suc,cg_fail,cg_pend,sub_retry_suc,sub_retry_fail,sub_retry_lb,sub_revenue   
            FROM     cellc_flat_copy1
            WHERE    date BETWEEN
                           DATE_FORMAT(NOW() - INTERVAL 60 DAY, '%Y-%m-%d %H:00:00')
                       AND NOW()
                       GROUP BY dates
            ORDER BY dates";

        

        $sql = json_encode($csql);
          return $sql;
        break;
        }
        
        case "Month wise report":{

            $csql->th = "SELECT  MONTH(date) AS dates,total_hits,cg_suc,cg_fail,cg_pend,sub_retry_suc,sub_retry_fail,sub_retry_lb,sub_revenue   
            FROM     cellc_flat_copy1
            WHERE    date BETWEEN
                           DATE_FORMAT(NOW() - INTERVAL 3 MONTH, '%Y-%m-%d %H:00:00')
                       AND NOW()
                       GROUP BY dates
            ORDER BY dates";

    
        $sql = json_encode($csql);
          return $sql;
        break;
        }
        
        
        }

    }
}

?>