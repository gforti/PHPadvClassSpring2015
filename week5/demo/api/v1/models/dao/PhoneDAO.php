<?php
/**
 * Description of PhoneDAO
 *
 * @author GFORTI
 */

namespace API\models\services;

use API\models\interfaces\IDAO;
use API\models\interfaces\IModel;
use API\models\interfaces\ILogging;
use \PDO;


class PhoneDAO extends BaseDAO implements IDAO {
        
     public function __construct( PDO $db, IModel $model, ILogging $log ) {        
        $this->setDB($db);
        $this->setModel($model);
        $this->setLog($log);
    }
    
    
    public function idExisit($id) {
                
        $db = $this->getDB();
        $stmt = $db->prepare("SELECT phoneid FROM phone WHERE phoneid = :phoneid");
         
        if ( $stmt->execute(array(':phoneid' => $id)) && $stmt->rowCount() > 0 ) {
            return true;
        }
         return false;
    }
    
    public function read($id) {
         
         $model = clone $this->getModel();
         
         $db = $this->getDB();
         
         $stmt = $db->prepare("SELECT phone.phoneid, phone.phone, phone.phonetypeid, phonetype.phonetype, phonetype.active as phonetypeactive, phone.logged, phone.lastupdated, phone.active"
                 . " FROM phone LEFT JOIN phonetype on phone.phonetypeid = phonetype.phonetypeid WHERE phoneid = :phoneid");
         
        if ( $stmt->execute(array(':phoneid' => $id)) && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetch(PDO::FETCH_ASSOC);
             $model->map($results);
        }
         
        return $model;
         
        
    }
    
    
    public function create(IModel $model) {
                 
         $db = $this->getDB();
         
         $binds = array( ":phone" => $model->getPhone(),
                         ":active" => $model->getActive(),
                         ":phonetypeid" => $model->getPhonetypeid()             
                    );
                         
         if ( !$this->idExisit($model->getPhoneid()) ) {
             
             $stmt = $db->prepare("INSERT INTO phone SET phone = :phone, phonetypeid = :phonetypeid, active = :active, logged = now(), lastupdated = now()");
             
             if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
                return true;
             }
         }
                  
         
         return false;
    }
    
    
     public function update(IModel $model) {
                 
         $db = $this->getDB();
         
        $binds = array( ":phone" => $model->getPhone(),
                        ":active" => $model->getActive(),
                        ":phonetypeid" => $model->getPhonetypeid(),
                        ":phoneid" => $model->getPhoneid()
                    );
         
                
         if ( $this->idExisit($model->getPhoneid()) ) {
            
             $stmt = $db->prepare("UPDATE phone SET phone = :phone, phonetypeid = :phonetypeid,  active = :active, lastupdated = now() WHERE phoneid = :phoneid");
         
             if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
                return true;
             } else {
                 $error = implode(",", $db->errorInfo());
                 $this->getLog()->logError($error);
             }
             
         } 
         
         return false;
    }
    
    public function delete($id) {
          
        $db = $this->getDB();         
        $stmt = $db->prepare("Delete FROM phone WHERE phoneid = :phoneid");

        if ( $stmt->execute(array(':phoneid' => $id)) && $stmt->rowCount() > 0 ) {
            return true;
        } else {
            $error = implode(",", $db->errorInfo());
            $this->getLog()->logError($error);
        }
         
         return false;
    }
    
    public function getAllRows() {
       $db = $this->getDB();
       $values = array();
       
        $stmt = $db->prepare("SELECT phone.phoneid, phone.phone, phone.phonetypeid, phonetype.phonetype, phonetype.active as phonetypeactive, phone.logged, phone.lastupdated, phone.active"
                 . " FROM phone LEFT JOIN phonetype on phone.phonetypeid = phonetype.phonetypeid");
        
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $value) {
               $model = clone $this->getModel();
               $model->reset()->map($value);
               $values[] = $model;
            }
        }
        
        $stmt->closeCursor();
         return $values;
    }
    
    
}
