<?php
/**
*
 * @author pmoraitopoulos
 * @version 1.02.01
 * This abstract class represents all the common elements of all API Connectivity types (eLogin, PostData, GetData). 
 * The manufacturer's instructions have been used. The inheritance principle is used.
 * This class is the parent class.
 *
 */
abstract class Connection{
    
    /**
     * apicode is a String. Provided from the ERP API Connectivity Scenario. Is Unigue for each ERP DB Alias
     */
    private String $apicode;
    private String $baseUrl;
    private String $uri;
    private String $url;
    private $request; 
    private String $response; 

    /*
    * Constructor 
    *
    */
    public function __construct( String $apicode, String $baseUrl, String $uri ){
        $this->apicode = $apicode;
        $this->baseUrl = $baseUrl;
        $this->uri = $uri;
        $this->url = $baseUrl . '/' . $uri;
        $this->request = $this->response = json_encode( array() );
    }
  
    /*
    *Method for creating the HTTP Request. Its different for each subclasses
    *
    */
    
    abstract public function requestBody() :Array; //array type
    
     /*
    *Method for Posting the HTTP Request. Its common for all subclasses
    *
    */
  
  
    public function postRequest(){
        $this->setRequest( wp_remote_post( $this->getUrl() , $this->requestBody() ) );
    }
  
  
  
  
   /*
    *Method for Retrieving and Evaluating Response of the HTTP Request. Its common for all subclasses
    *
    */
    
    public function retrieveResponse(){
        if ( is_wp_error( $this->getRequest() ) || wp_remote_retrieve_response_code( $this->getRequest()) != 200 ) {
            if(wp_remote_retrieve_response_code($this->getRequest())==null && $this instanceof Elogin){
                throw new Exception('Error: Connection Failed. There is no server response. Check your login credentials.');
            }
            throw new Exception('Error Occured (Code: ' . wp_remote_retrieve_response_code($this->getRequest()) . '): ' .wp_remote_retrieve_response_message($this->getRequest()));
        } else {
            $this->setResponse(wp_remote_retrieve_body($this->getRequest()));
        }     
    }
  
    /*
    *Method for converting json to php Array
    *
    */
    
    public function responseToArray() : Array{
        $responseArray = json_decode($this->getResponse(), true);
        return $responseArray; 
    }
  
    /*
    *Method returning specific value of the HTTP Response
    *
    */
    
    public function getSpecificValueFromResponseArrayForThisKey(String $key) : String{
        $response = $this->responseToArray();
        $results = json_decode($response['Result'],true);
        $value = '';
        if(array_key_exists($key,$response)){
            $value = $response[$key];
            return $value;
        } else if(array_key_exists($key,$results)){
            $value = $results[$key];
            return $value;
        } else{
            throw new Exception('Error: The $key you search for in the response array does not exist.');
        }        
    }
  
  //Getters and Setters
    
    public function getApicode():String{
        return $this->apicode;
    }
    
    public function getBaseUrl():String{
        return $this->baseUrl;
    }
    
    public function getUrl():String{
        return $this->url;
    }
    
    public function getRequest(){
        return $this->request;
    }
    
    public function getResponse() : String{
        return $this->response;
    }
    
    public function setRequest($request){
        $this->request = $request;
    }
    
    public function setResponse($response){
        $this->response = $response;
    }
    
    
    
}
