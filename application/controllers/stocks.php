<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/API_Controller.php');

class Stocks extends API_Controller {
    
    public function index_get() {
        $stock_code = $this->get('code');
        if ($stock_code) {
            $this->retrieve_single($stock_code);
        } else {
            $this->retrieve_list();    
        }
        return;
    }

    private function retrieve_single( $stock_code = "" ) {
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode(array($stock_code));
        return;
    }

    private function retrieve_list() {
        
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode(array(1,2,3));
        return;
    }
}