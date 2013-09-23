<?php

class Operations
{
	
	public $session_id='';
	public $session_menu='';
	public $session_pg=0;
	public $session_tel='';
	public $session_others='';

	public function setSessions($sessions){

		$sql_sessions="INSERT INTO `sessions` (`sessionsid`, `tel`, `menu`, `pg`, `created_at`,`others`) VALUES 
			('".$sessions['sessionid']."', '".$sessions['tel']."', '".$sessions['menu']."', '".$sessions['pg']."', 'CURRENT_TIMESTAMP','".$sessions['others']."')";

		$quy_sessions=mysql_query($sql_sessions);
	}

	public function getSession($sessionid){	

		$sql_session="SELECT *  FROM  `sessions` WHERE  sessionsid='". $sessionid."'";
		$quy_sessions=mysql_query($sql_session);
		$fet_sessions=mysql_fetch_array($quy_sessions);
		$this->session_others=$fet_sessions['others'];
		return $fet_sessions;	
	}


	public function saveSesssion()
	{
		$sql_session="UPDATE  `sessions` SET 
									`menu` =  '".$this->session_menu."',
									`pg` =  '".$this->session_pg."',
									`others` =  '".$this->session_others."'
									WHERE `sessionsid` =  '".$this->session_id."'";
		$quy_sessions=mysql_query($sql_session);
	}



}

?>