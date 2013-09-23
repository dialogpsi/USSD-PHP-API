<?php

ini_set('error_log', 'ussd-app-error.log');

require 'libs/MoUssdReceiver.php';
require 'libs/MtUssdSender.php';
require 'class/operationsClass.php';
require 'log.php';
require 'db.php';


$production=false;

	if($production==false){
		$ussdserverurl ='http://localhost:7000/ussd/send';
	}
	else{
		$ussdserverurl= 'https://api.dialog.lk/ussd/send';
	}


$receiver 	= new UssdReceiver();
$sender 	= new UssdSender($ussdserverurl,'APP_000001','password');
$operations = new Operations();

$receiverSessionId = $receiver->getSessionId();
$content 			= 	$receiver->getMessage(); // get the message content
$address 			= 	$receiver->getAddress(); // get the sender's address
$requestId 			= 	$receiver->getRequestID(); // get the request ID
$applicationId 		= 	$receiver->getApplicationId(); // get application ID
$encoding 			=	$receiver->getEncoding(); // get the encoding value
$version 			= 	$receiver->getVersion(); // get the version
$sessionId 			= 	$receiver->getSessionId(); // get the session ID;
$ussdOperation 		= 	$receiver->getUssdOperation(); // get the ussd operation


$responseMsg = array(
    "main" =>  
    "T-Shirts
1. Small
2. Medium
3. Large

99. Exit"
);


if ($ussdOperation  == "mo-init") { 
   
	try {
		
		$sessionArrary=array( "sessionid"=>$sessionId,"tel"=>$address,"menu"=>"main","pg"=>"","others"=>"");

  		$operations->setSessions($sessionArrary);

		$sender->ussd($sessionId, $responseMsg["main"],$address );

	} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again',$address );
	}
	
}else {

	$flag=0;

  	$sessiondetails=  $operations->getSession($sessionId);
  	$cuch_menu=$sessiondetails['menu'];
  	$operations->session_id=$sessiondetails['sessionsid'];

		switch($cuch_menu ){
		
			case "main": 	// Following is the main menu
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="small";
							$operations->saveSesssion();
							$sender->ussd($sessionId,'Enter Your ID',$address );
							break;
						case "2":
							$operations->session_menu="medium";
							$operations->saveSesssion();
							$sender->ussd($sessionId,'Enter Your ID',$address );
							break;
						case "3":
							$operations->session_menu="large";
							$operations->saveSesssion();
							$sender->ussd($sessionId,'Enter Your ID',$address );
							break;
						default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
			case "small":
				$operations->session_menu="medium";
				$operations->session_others=$receiver->getMessage();
				$operations->saveSesssion();
				$sender->ussd($sessionId,'You Purchased a small T-Shirt Your ID '.$receiver->getMessage(),$address ,'mt-fin');
				break;
			case "medium":
				$sender->ussd($sessionId,'You Purchased a medium T-Shirt Your ID '.$receiver->getMessage(),$address ,'mt-fin');
				break;
			case "large":
				$sender->ussd($sessionId,'You Purchased a large T-Shirt Your ID '.$receiver->getMessage(),$address ,'mt-fin');
				break;
			default:
				$operations->session_menu="main";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Incorrect option',$address );
				break;
		}
	
}