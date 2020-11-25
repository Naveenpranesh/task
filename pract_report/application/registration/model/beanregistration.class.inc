<?php
/** auto generated code by BeanGenerator **/
class Registration {

	private $_start_date;
	private $_end_date;
	private $_university;
	private $_college;
	private $_gender;
	private $_access;

	/** setter function for All columns **/
	public function __construct($value) {
		if(isset($value['university'])) {
			$this->_university = $value['university'];
		}
		if(isset($value['gender'])) {
			$this->_gender = $value['gender'];
		}
		if(isset($value['college'])) {
			$this->_college = $value['college'];
		}
		if(isset($value['access'])) {
			$this->_access = $value['access'];
		}
		if(isset($value['start_date']))
			$this->_start_date = $value['start_date'];
			
		if(isset($value['end_date']))
			$this->_end_date = $value['end_date'];
	}
	/** getter function for start date **/
	public function getStart_date() {
		return $this->_start_date;
	}

	/** getter function for end date **/
	public function getEnd_date() {
		return $this->_end_date;
	}

	/** getter function for university **/
	public function getUniversity() {
		return $this->_university;
	}

	/** getter function for college **/
	public function getCollege() {
		return $this->_college;
	}

	/** getter function for gender **/
	public function getGender() {
		return $this->_gender;
	}

	/** getter function for status **/
	public function getAccess() {
		return $this->_access;
	}
}
?>