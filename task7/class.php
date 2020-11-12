<?php
include 'connect.php';

class report{
    private $type;

    public function __construct($type){
       
        $this->type=$type;
    }

    public function sql(){

        switch($this->type){
        
        case "Hour wise report":{

            $sql = "SELECT  HOUR(Date) AS hour,COUNT(DATE) as totalcount, SUM(sucess) as Success,SUM(failed) AS Failed,SUM(pending) AS pending       
            FROM     review
            WHERE    Date BETWEEN
                           DATE_FORMAT(NOW() - INTERVAL 23 HOUR, '%Y-%m-%d %H:00:00')
                       AND NOW()
            GROUP BY hour
            ORDER BY hour";
        
        
          return $sql;
        break;
        }
        
        case "Date wise report":{

            $sql = "SELECT  Date(Date)as dates,COUNT(DATE) as totalcount,SUM(sucess) as Success,SUM(failed) AS Failed,SUM(pending) AS pending
             from review where date BETWEEN
            DATE_FORMAT(NOW() - INTERVAL 10 DAY, '%Y-%m-%d %H:00:00')
        AND  DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00')
    GROUP BY dates ORDER BY dates DESC";
        
                
          return $sql;
        break;
        }

        case "Month wise report":{

            $sql = "SELECT  Month(Date) AS month,COUNT(DATE) as totalcount,SUM(sucess) as Success,SUM(failed) AS Failed,SUM(pending) AS pending       
            FROM     review
            WHERE    DATE_FORMAT(Date, '%Y-%m-%d %H:00:00') BETWEEN
                           DATE_FORMAT(NOW() - INTERVAL 3 MONTH, '%Y-%m-%d %H:00:00')
                           AND  DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00')
            GROUP BY month
            ORDER BY month";
                 
          return $sql;
        break;
        }
        
        
        }

    }
}

?>