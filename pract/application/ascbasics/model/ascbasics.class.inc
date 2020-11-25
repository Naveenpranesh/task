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


class AscbasicsModel {

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



		public function get_results($arr,$insert,$_delete,$num_delete,$search) {
		global $db,$request,$result;
		
		$result = new \stdClass();

		$c_array = $arr;

		
	 	$created_array = $c_array;

		$result ->created_array = $created_array;	

		$ini_count=count($created_array);
		$result ->ini_count=$ini_count;

		$inserted_array = $c_array;

		array_push($inserted_array,$insert);
		

		$result ->inserted_array = $inserted_array;
		
		
		
		array_pop($created_array);
        
		$deleted_array = $created_array;

		$result ->deleted_array=$deleted_array;
		
		$num_deleted_array = array_splice($created_array, 0 , count($created_array) - $num_delete);
		$result ->num_deleted_array =$num_deleted_array;
		
		$search = array_search($search, $c_array);
		$result ->search =$search;
		
		$asorted=sort($created_array);
		$result ->asorted =$asorted;

		$dsorted=rsort($created_array);
		$result ->dsorted =$dsorted;

		$copy_array = $c_array;

		$result ->copy_array=$copy_array;

		$merged_array = array_merge($copy_array, $c_array);

		$mer_count=count($merged_array);


		$created_array['first'] = 'hi';
		$created_array['second'] = 'hello';
		$created_array['third'] = 'how are you?';
		$created_array['fourth'] = 'I am Naveen';
		$created_array['fifth'] = 'bi';
	
	$result ->ele_insert = $created_array;

		$first_four=array_splice($c_array, 0, 4);
		$result ->first_four = $first_four;

	
		$unique=array_unique($c_array);
		$result ->unique=$unique;

		
		$result ->merged_array=$merged_array;
		
		$result ->mer_count=$mer_count;
		
		return (object)$result;
	
	}




}
?>
