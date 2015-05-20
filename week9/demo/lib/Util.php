<?php

/**
 * Util - functions used to help with the over all application
 *
 * @author User
 */
class Util {
    
    
    /**
    * A method to check if a Post request has been made.
    *    
    * @return boolean
    */    
    public function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }
    
    /**
    * A method to check if a Get request has been made.
    *    
    * @return boolean
    */    
    public function isGetRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' );
    }
    
    public function isLoggedin() {
        return ( isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true );
    }
    
    public function setLoggedin($value) {
        $_SESSION['loggedin'] = $value;
    }
    
    /**
     * Generate link.
     * @param string $page target page
     * @param array $params page parameters
     */
    public function createLink($page, array $params = array()) {        
        return $page . '?' .http_build_query($params);
    }
    
     /**
     * Redirect to the given page.
     * @param type $page target page
     * @param array $params page parameters
     */
    public function redirect($page, array $params = array()) {
        header('Location: ' . $this->createLink($page, $params));
        die();
    }
    
}
