<?php

/**
 * Description of PhoneTypeRestServer
 *
 * @author User
 */

namespace App\models\services;

use App\models\interfaces\IService;
use App\models\interfaces\IModel;
use App\models\interfaces\ILogging;

use Exception;

class RestServer implements IService {
    
    private $response;
    private $model;
    
    private $status_codes = array(  
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            400 => 'Bad Request',
            404 => 'Not Found',
            409 => 'Conflict',
            500 => 'Internal Server Error',
        );

    protected $DI = array();
    
    public function addDIResourceRequest($resource, $func) {
        $this->DI[$this->getResourceRequestName($resource)] = $func;
        return $this;
    }

    protected function getResourceRequestName($resource) {
        return ucfirst(strtolower($resource)).'Request';
    }


    public function __construct( IModel $restModel, IModel $responseModel, ILogging $log) {
        
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
                
        set_exception_handler(array($this, 'handleException'));
        
        
        $this->response = $responseModel;
        $this->model = $restModel;        
        $this->log = $log;
               
        $this->model->setVerb($this->getHTTPVerb());
        $this->model->setRequestData($this->getHTTPData());
        
        $this->model->setEndpoint( filter_input(INPUT_GET, 'endpoint') );
        
        $endpoint = $this->model->getEndpoint();
        
        $restArgs = explode('/', rtrim($endpoint, '/'));
        $this->model->setResource(array_shift($restArgs));
        
        if ( isset($restArgs[0]) && is_numeric($restArgs[0]) ) {
            $this->model->setId($restArgs[0]);
        }
       
    }
    
    public function process() {
        
        $status = 404;
        $data = null;
        
        $class_name = $this->getResourceRequestName($this->model->getResource());
        if (array_key_exists($class_name,$this->DI)) {                
            $Request = $this->DI[$class_name](); 
            
            $data = $Request->{$this->model->getVerb()}($this->model);            
            $status = 200;
        } 
        
        return $this->_response($data, $status);
        
    }
    
    protected function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->getStatusMessage($status));
        
        $this->setStatusCode($status);
        $this->response->setData($data);
        
        return $this->getFullJSONReponse();
    }
    
    
    protected function getHTTPVerb(){        
        
        $verb = filter_input(INPUT_SERVER, 'REQUEST_METHOD');        
        $verbs_allowed = array('GET','POST','PUT','DELETE');
        
        if ( !in_array($verb, $verbs_allowed) ) {
            throw new BadRequestException("Unexpected Header Requested ". $verb);
        }
               
        return $verb;
    }
    
    
    protected function getHTTPData() {
        $data = array();// file_get_contents("php://input");
        
        $verb = $this->getHTTPVerb();
                
        switch($verb) {
            case 'DELETE':
            case 'POST':
                $data = filter_input_array(INPUT_POST);
                break;
            case 'GET':
                $data = filter_input_array(INPUT_GET);
                break;
            case 'PUT':
                parse_str(file_get_contents('php://input'), $data);            
                break;       
        }
       
        return $data;
    }
    
    
    
    
    
    protected function setStatusCode($code) {       
        if ( isset($this->getStatusCodes()[$code]) ) {
            $this->response->setStatus_code($code);
            $this->response->setStatus_message($this->getStatusMessage($code));            
        }
    }
    
    protected function getFullReponse() {
        return $this->response->getAllPropteries();
    }
   
    protected function getFullJSONReponse() {
        return json_encode($this->getFullReponse(), JSON_PRETTY_PRINT);
    }
    
    protected function getStatusCodes() {
        return $this->status_codes;
    }
    
    protected function getStatusMessage($code) {
        return ( isset($this->status_codes[$code]) ? $this->status_codes[$code] : $this->status_codes[500] );
    }
    
    
    
    /**
    * Exception handler.
    */
   public function handleException($ex) { 
       
        $status = 500;
        
        if ($ex instanceof ContentCreatedException) {  
            $status = 201;                
        }
        
        if ($ex instanceof NoContentRequestException) {  
            $status = 404;                
        }
          
        if ($ex instanceof BadRequestException) {  
            $status = 400;                
        }
        if ($ex instanceof ConflictRequestException) {  
            $status = 409;                
        }
        
        
        if ( $status !== 201 ) {
            $this->getLog()->logException($ex->getMessage()); 
        }
        
      
        echo $this->_response(null, $status);
        exit();
   }

    protected function getLog() {
        return $this->log;
    }
    
}
