<?php
/**
 *   (C) Copyright 1997-2013 hSenid International (pvt) Limited.
 *   All Rights Reserved.
 *
 *   These materials are unpublished, proprietary, confidential source code of
 *   hSenid International (pvt) Limited and constitute a TRADE SECRET of hSenid
 *   International (pvt) Limited.
 *
 *   hSenid International (pvt) Limited retains all title to and intellectual
 *   property rights in these materials.
 */

class UssdReceiver{

    private $sourceAddress; 
    private $message;
    private $requestId;
    private $applicationId;
    private $encoding;
    private $version;
    private $sessionId;
    private $ussdOperation;
    private $vlrAddress;
	private $thejson;
	
    public function __construct(){
        $array = json_decode(file_get_contents('php://input'), true);
        $this->thejson = json_decode(file_get_contents('php://input'), true);
        $this->sourceAddress = $array['sourceAddress'];
        $this->message = $array['message'];
        $this->requestId = $array['requestId'];
        $this->applicationId = $array['applicationId'];
        $this->encoding = $array['encoding'];
        $this->version = $array['version'];
        $this->sessionId = $array['sessionId'];
        $this->ussdOperation = $array['ussdOperation'];

        if (!((isset($this->sourceAddress) && isset($this->message)))) {
            throw new Exception("Some of the required parameters are not provided");
        } else {
            $responses = array("statusCode" => "S1000", "statusDetail" => "Success");
        }
    }

	public function getthejson(){
		return $this->thejson;
	}

    public function getAddress(){
        return $this->sourceAddress;
    }

    public function getMessage(){
        return $this->message;
    }

    public function getRequestID(){
        return $this->requestId;
    }

    public function getApplicationId(){
        return $this->applicationId;
    }

    public function getEncoding(){
        return $this->encoding;
    }

    public function getVersion(){
        return $this->version;
    }

    public function getSessionId(){
        return $this->sessionId;
    }

    public function getUssdOperation(){
        return $this->ussdOperation;
    }

}

?>