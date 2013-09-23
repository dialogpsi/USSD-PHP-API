<?php

require_once 'core.php';
class UssdSender extends Core{
    	private $applicationId,
			$password,
			$charging_amount='',
			$encoding='',
			$version='',
			$deliveryStatusRequest='',
			$binaryHeader='',
			$sourceAddress='',
			$serverURL;

    public function __construct($server,$applicationId,$password){
        $this->serverURL = $server; 
        $this->applicationId = $applicationId; 
        $this->password = $password; 
    }

    public function ussd( $sessionId, $message, $destinationAddress, $ussdOperation='mo-cont'){
						 
        if (is_array($destinationAddress)) { 
            return $this->ussdMany($message,$sessionId, $ussdOperation, $destinationAddress);
				
        } else if (is_string($destinationAddress) && trim($destinationAddress) != "") {
            return $this->ussdMany($message,$sessionId, $ussdOperation, $destinationAddress);
        } else {
            throw new Exception("address should a string or a array of strings");
        }
    }

    private function ussdMany($message,$sessionId, $ussdOperation, $destinationAddress)
	{

        $arrayField = array("applicationId" => $this->applicationId,
            "password" => $this->password,
            "message" => $message,
            "destinationAddress" => $destinationAddress,
            "sessionId" => $sessionId,
            "ussdOperation" => $ussdOperation,
            "encoding" => "440"
			);

        $jsonObjectFields = json_encode($arrayField);
        return $this->sendRequest($jsonObjectFields,$this->serverURL);
    }

    private function handleResponse($resp){
        if ($resp == "") {
            throw new UssdException
            ("Server URL is invalid", '500');
        } else {
            echo $resp;
        }
    }

}



class UssdException extends Exception{ // Ussd Exception Handler

    var $code;
    var $response;
    var $statusMessage;

    public function __construct($message, $code, $response = null){
        parent::__construct($message);
        $this->statusMessage = $message;
        $this->code = $code;
        $this->response = $response;
    }

    public function getStatusCode(){
        return $this->code;
    }

    public function getStatusMessage(){
        return $this->statusMessage;
    }

    public function getRawResponse(){
        return $this->response;
    }

}

?>