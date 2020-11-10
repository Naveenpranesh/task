<?php

class simpleCal{
    private $num1;
    private $num2;
    private $type;

    public function __construct($num1,$num2,$type){
        $this->num1=$num1;
        $this->num2=$num2;
        $this->type=$type;
    }
  
  public function calculation(){

        switch($this->type){
            case "+":
                 $result= $this->num1 + $this->num2;
                 break;
            
            case "-":
                 $result= $this->num1 - $this->num2;
            break;
            
            case "x":
                 $result= $this->num1 * $this->num2;
            break;
            
            case "/":
                 $result= $this->num1 / $this->num2;
                    break;

            case "%":
               
                $result=  ($this->num1 / 100) *  $this->num2;
                break;
                
            default:
               
					$result= "error";
                    break;
                
        }
         return $result;
    } 
  
}

?>