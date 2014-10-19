<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/API_Controller.php');

class Account extends API_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('trade');
        $this->load->model('stock');
        $this->load->model('balance');
    }

    public function index_get() {
        $return_object = array(
            'current_balance' => $this->balance->get_current(),
            'active_trades' => $this->trade->retrieve_active()
        );

        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode($return_object);  
    }

    public function balances_get() {
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode( $this->balance->get_all() );
    }
}