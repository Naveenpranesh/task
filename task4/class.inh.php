<?php

class simpleCal{
    public $num1;
    public $num2;
    public $type;

    public function __construct($num1,$num2,$type){
        $this->num1=$num1;
        $this->num2=$num2;
        $this->type=$type;
    }
  
    public function add(){
      return  $result= $this->num1 + $this->num2;
    }
    public function sub(){
        return $result= $this->num1 - $this->num2;
    }
    public function mult(){
      return  $result= $this->num1 * $this->num2;
    }
    public function div(){
        return  $result= $this->num1 / $this->num2;
    }
 

}
class simpleCal2 extends simpleCal{
    public function percentage(){
      return  $result=  ($this->num1 / 100) *  $this->num2;
    }
}
?>