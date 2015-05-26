<?php

class SignupDAO {
    
    private $DB = null;
    private $model = null;

    public function __construct( PDO $db, $model ) {        
        $this->setDB($db);
        $this->setModel($model);
    }
    
    private function setDB( PDO $DB) {        
        $this->DB = $DB;
    }
    
    private function getDB() {
        return $this->DB;
    }
    
    private function getModel() {
        return $this->model;
    }

    private function setModel($model) {
        $this->model = $model;
    }
    
    public function login($model) {
         
        $email = $model->getEmail();
        $password = $model->getPassword();
        $db = $this->getDB();

        $stmt = $db->prepare("SELECT * FROM signup WHERE email = :email");

        if ( $stmt->execute(array(':email' => $email)) && $stmt->rowCount() > 0 ) {            
            $results = $stmt->fetch(PDO::FETCH_ASSOC);            
            return password_verify($password, $results['password']);            
        }
         
        return false;
    }
    
    
    public function create($model) {
                 
        $db = $this->getDB();

        $binds = array( ":email" => $model->getEmail(),
                        ":password" => password_hash($model->getPassword(), PASSWORD_DEFAULT)
                    );
                     
        $stmt = $db->prepare("INSERT INTO signup SET email = :email, password = :password, created = now()");
         
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
            return true;
        }
         
         return false;
    }
    
    
    public function update($model) {
          
        $db = $this->getDB();
        $binds = array( ":id" => $model->getId(),
                        ":email" => $model->getEmail(),
                        ":password" => password_hash($model->getPassword(), PASSWORD_DEFAULT),
                        ":active" => $model->getActive()
                    );

        $stmt = $db->prepare("UPDATE signup SET email = :email, password = :password, active = :active WHERE id = :id");

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
          
}
