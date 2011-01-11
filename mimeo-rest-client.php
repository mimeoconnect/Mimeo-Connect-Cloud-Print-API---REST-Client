<?php

require_once "../pear/Request2.php";

class MimeoRESTClient {

    private $root_url = "";
    private $curr_url = "";
    private $user_name = "";
    private $password = "";
    private $response = "";
    private $response_body = "";
    private $req = null;

    public function __construct($root_url = "", $user_name = "", $password = "") {
        $this->root_url = $root_url;
        $this->user_name = $user_name;
        $this->password = $password;
        return true;
    }

    public function createRequest($url, $method, $arr = null) {
    
    
    	if($this->root_url=='connect.sandbox.mimeo.com/2010/09/')
	    	{
	    	$sURL = "http://" . $this->root_url . "/" . $url;
	    	}
		else
    	    {
	    	$sURL = "https://" . $this->root_url . "/" . $url;
	    	}			    	
        $this->curr_url = $sURL;
        
        $this->req = new HTTP_Request2($sURL);

        if ($this->user_name != "" && $this->password != "") {
           $this->req->setAuth($this->user_name, $this->password);
        }        

        switch($method) {
            case "GET":
                $this->req->setMethod("GET");
                break;
            case "POST":
                $this->req->setMethod("POST");
                $this->addPostData($arr);
                break;
            case "PUT":
                $this->req->setMethod("PUT");
                // to-do
                break;
            case "DELETE":
                $this->req->setMethod("DELETE");
                // to-do
                break;
        }
    }

    private function addPostData($arr) {
        if ($arr != null) {
            foreach ($arr as $key => $value) {
                $this->req->addPostParameter($key, $value);
            }
        }
    }

    public function sendRequest() {
    
        $this->response = $this->req->send();
        $this->responseBody = $this->response->getBody();
        
    }
    
    public function setHeader($name,$value) {
    
        $this->req->setHeader($name,$value);
        
    }    
    
    public function setBody($xmlBody) {
    
        $this->req->setBody($xmlBody);
        
    }      

    public function getResponse() {
        return $this->response;
    }
    
    public function getResponseBody() {
        return $this->responseBody;
    }   

}

?>