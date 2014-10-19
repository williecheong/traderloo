<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/API_Controller.php');

class Users extends API_Controller {
    
    public function index_get() {
        $users = $this->user->retrieve_active();
        foreach($users as $key => $user) {
            $users[$key] = $this->user->public_safe( $user );
        }
        
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode($users);
        return;
    }
}