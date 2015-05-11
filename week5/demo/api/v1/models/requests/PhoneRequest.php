<?php
/**
 * Description of PhoneRequest
 *
 * @author User
 */

namespace API\models\services;

use API\models\interfaces\IRequest;
use API\models\interfaces\IService;
use API\models\interfaces\IModel;

class PhoneRequest implements IRequest {
     protected $service;
            
    public function __construct( IService $service) {
        $this->service = $service;
    }
    
    public function POST( IModel $model ) { 
        $phoneModel = $this->service->getNewPhoneModel();
        $phoneModel->map($model->getRequestData());
        if ( $this->service->create($phoneModel) ) {
            throw new ContentCreatedException('Created');           
        }
        $errors = $this->service->validate($phoneModel);
        
        if ( count($errors) > 0 ) {
            throw new ValidationException($errors, 'New Phone Not Created');
        }
        throw new ConflictRequestException('New Phone Not Created');
    }
    
    public function GET( IModel $model ) {
        $id = intval($model->getId());
        
        if ( $id > 0 ) { 
            if ( $this->service->idExist($model->getId()) ) {
                return $this->service->read($model->getId())->getAllPropteries();
            } else {
                throw new NoContentRequestException($id . ' ID does not exist');
            }
        }
        $data = $this->service->getAllRows();
        $values = array();
        
        foreach ($data as $value) {
            $values[] = $value->getAllPropteries();
        }
        
        return $values;
    }
    
    public function PUT( IModel $model ) {
        $id = intval($model->getId());
        $phoneModel = $this->service->getNewPhoneModel();
        $phoneModel->map($model->getRequestData());
        $phoneModel->setPhoneid($id);
        
        if ( !$this->service->idExist($id) ) {
            throw new NoContentRequestException($id . ' ID does not exist');
        }
        
        if ( $this->service->update($phoneModel) ) {
            throw new ContentCreatedException('Created');           
        }
                
        $errors = $this->service->validate($phoneModel);
        
        if ( count($errors) > 0 ) {
            throw new ValidationException($errors, 'Phone Not Updated');
        }        
        
        throw new ConflictRequestException('New Phone Not Updated for id ' . $id);
    }
    
    public function DELETE( IModel $model ) {
        $id = intval($model->getId());        
        if ( $this->service->delete($id) ) {
            return null;          
        }
        throw new ConflictRequestException($id . ' ID Phone Not Deleted');
    }
}
