<?php
/**
 * @author pmoraitopoulos
 * @version 1.02.01
 * This plugin represents the http request wich the third party application (website) connects to ERP
 */
class Elogin extends Connection{

    private String $username;
    private String $password;
    private String $applicationname;
    private String $databasealias;
  
  /*
  *Constructor
  */
   
    public function __construct(String $apicode, String $baseUrl, String $uri, String $username, String $password, String $applicationname, String $databasealias){
        parent::__construct($apicode, $baseUrl, $uri);
        $this->username = $username;
        $this->password = $password;
        $this->applicationname = $applicationname;
        $this->databasealias = $databasealias;
    }
    
  
  /*
  *Method that creates the request of the http request
  *
  *
  */
    public function requestBody(): Array{
        $body = array(
            'headers' =>array(
                'Content-Type' =>'application/json'
            ),
            
            'body' =>json_encode(array(
                'username' => $this->username,
                'password' => $this->password,
                'apicode' => $this->getApicode(),
                'applicationname' => $this->applicationname,
                'databasealias' => $this->databasealias
            )),
            'method'=> 'POST',
            'data_format'=>'body'
        );
       return $body;
    }
    /*
    * Validates if the response is ok
    *
    */
    public function statusIsOk(){
        $status = $this->getSpecificValueFromResponseArrayForThisKey('Status');
        if($status === 'OK'){
            return true;
        }else{
            return false;
        }
    }
}
