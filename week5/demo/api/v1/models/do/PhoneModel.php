<?php

/**
 * Description of PhoneModel
 *
 * @author GFORTI
 */

namespace API\models\services;


class PhoneModel extends BaseModel {
    
    private $phoneid;
    private $phone;
    private $phonetypeid;
    private $phonetype;
    private $phonetypeactive;
    private $logged;
    private $lastupdated;
    private $active;
    
    function getPhoneid() {
        return $this->phoneid;
    }

    function getPhone() {
        return $this->phone;
    }

    function getPhonetypeid() {
        return $this->phonetypeid;
    }
    
     function getPhonetype() {
        return $this->phonetype;
    }

    function getPhonetypeactive() {
        return $this->phonetypeactive;
    }

    function getLogged() {
        return $this->logged;
    }

    function getLastupdated() {
        return $this->lastupdated;
    }

    function getActive() {
        return $this->active;
    }

    function setPhoneid($phoneid) {
        $this->phoneid = $phoneid;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setPhonetypeid($phonetypeid) {
        $this->phonetypeid = $phonetypeid;
    }

    function setPhonetype($phonetype) {
        $this->phonetype = $phonetype;
    }

    function setPhonetypeactive($phonetypeactive) {
        $this->phonetypeactive = $phonetypeactive;
    }
    
    function setLogged($logged) {
        $this->logged = $logged;
    }

    function setLastupdated($lastupdated) {
        $this->lastupdated = $lastupdated;
    }

    function setActive($active) {
        $this->active = $active;
    }
    
}
