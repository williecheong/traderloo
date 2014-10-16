<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/API_Controller.php');

class Stocks extends API_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('stock');
    }

    public function index_get() {
        $symbol = $this->get('symbol');
        if ($symbol) {
            $this->retrieve_single($symbol);
        } else {
            $this->retrieve_list();    
        }
        return;
    }

    private function retrieve_single( $symbol = "" ) {
        $symbol = strtoupper($symbol);
        $stock = $this->stock->retrieve($symbol);
        if ( $stock ) {
            http_response_code("200");
            header('Content-Type: application/json');
            echo json_encode($stock);
        } else {
            http_response_code("404");
            header('Content-Type: application/json');
            echo $this->message("Stock not found: " . $symbol);
        }
        return;
    }

    private function retrieve_list() {
        $stocks = $this->stock->retrieve_all();
        
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode($stocks);
        return;
    }
}