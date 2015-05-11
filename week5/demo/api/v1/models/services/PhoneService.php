<?php
/**
 * Description of PhoneService
 *
 * @author GFORTI
 */

namespace API\models\services;

use API\models\interfaces\IDAO;
use API\models\interfaces\IService;
use API\models\interfaces\IModel;

class PhoneService implements IService {
    
    protected $phoneDAO;
    protected $phoneTypeService;
    protected $validator;
    protected $model;
                function getValidator() {
        return $this->validator;
    }

    function setValidator($validator) {
        $this->validator = $validator;
    }                
     
    function getPhoneDAO() {
        return $this->phoneDAO;
    }

    function setPhoneDAO(IDAO $DAO) {
        $this->phoneDAO = $DAO;
    }
    
    function getPhoneTypeService() {
        return $this->phoneTypeService;
    }

    function setPhoneTypeService(IService $service) {
        $this->phoneTypeService = $service;
    }
    
    
    function getModel() {
        return $this->model;
    }

    function setModel(IModel $model) {
        $this->model = $model;
    }

        public function __construct( IDAO $phoneDAO, IService $phoneTypeService, IService $validator, IModel $model  ) {
        $this->setPhoneDAO($phoneDAO);
        $this->setPhoneTypeService($phoneTypeService);
        $this->setValidator($validator);
        $this->setModel($model);
    }
    
    
    public function getAllPhoneTypes() {       
        return $this->getPhoneTypeService()->getAllRows();   
        
    }
    
     public function getAllRows() {       
        return $this->getPhoneDAO()->getAllRows();   
        
    }
    
    public function create(IModel $model) {
        
        if ( count($this->validate($model)) === 0 ) {
            return $this->getPhoneDAO()->create($model);
        }
        return false;
    }
    
    
    public function validate( IModel $model ) {
        $errors = array();
        
        if ( !$this->getPhoneTypeService()->idExist($model->getPhonetypeid()) ) {
            $errors[] = 'Phone Type is invalid';
        }
       
        if ( !$this->getValidator()->phoneIsValid($model->getPhone()) ) {
            $errors[] = 'Phone is invalid';
        }
               
        if ( !$this->getValidator()->activeIsValid($model->getActive()) ) {
            $errors[] = 'Phone active is invalid';
        }
       
        
        return $errors;
    }
    
    public function idExist($id) {
        return $this->getPhoneDAO()->idExisit($id);
    }
    
    public function read($id) {
        return $this->getPhoneDAO()->read($id);
    }
    
    public function delete($id) {
        return $this->getPhoneDAO()->delete($id);
    }
    
    
     public function update(IModel $model) {
        
        if ( count($this->validate($model)) === 0 ) {
            return $this->getPhoneDAO()->update($model);
        }
        return false;
    }
    
    
     public function getNewPhoneModel() {
        return clone $this->getModel();
    }
    
    
}
