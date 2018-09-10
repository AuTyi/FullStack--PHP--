<?php
class Users {
	public $users = array();

	function addUser($user){
		array_push($this->users,$user);
		return true;
	}

	function removeUser($number){
		if($number >= 0 && $number < sizeof($this->users)){
			unset($this->users[$number]);
			return true;
		}
		return false;
	}

	function printUsers(){
		for($n = 0;$n < sizeof($this->users); $n++){
			print $this->users[$n];
		}
	}
}
?>