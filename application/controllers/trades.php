<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/API_Controller.php');

class Trades extends API_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('trade');
        $this->load->model('stock');
        $this->load->model('account');
    }

    public function index_get() {
        return $this->trade->retrieve();
    }

    public function index_post() {
        $symbol = $this->post('symbol');
        $quantity = $this->post('quantity');
        if ( $symbol && $quantity ) {
            $stock = $this->stock->retrieve($symbol);
            if ( $stock ) {
                $trade = $this->trade->open($stock, $quantity);
                if ( $trade ) {
                    http_response_code("201");
                    header('Content-Type: application/json');
                    echo json_encode($trade);   
                } else {
                    http_response_code("417");
                    header('Content-Type: application/json');
                    echo $this->message("Unexpected error occurred: 58mh8");
                }
            } else {
                http_response_code("404");
                header('Content-Type: application/json');
                echo $this->message("Stock not found");            
            }    
        } else {
            http_response_code("400");
            header('Content-Type: application/json');
            echo $this->message("Stock not specified");
        }
        return;
    }

    public function index_put() {
        $trade_id = $this->put('trade_id');
        if ( $trade_id ) {
            $trade = $this->trade->retrieve_by_id($trade_id);
            if ( $trade ) {
                if ( ! $trade->closed_user ) {
                    $trade = $this->trade->close($trade);
                    if ( $trade ) {
                        http_response_code("202");
                        header('Content-Type: application/json');
                        echo json_encode($trade);   
                    } else {
                        http_response_code("417");
                        header('Content-Type: application/json');
                        echo $this->message("Unexpected error occurred: ku8yg");
                    }
                } else {    
                    http_response_code("410");
                    header('Content-Type: application/json');
                    echo $this->message("Trade has been closed");
                }
            } else {
                http_response_code("404");
                header('Content-Type: application/json');
                echo $this->message("Trade not found");            
            }
        } else {
            http_response_code("400");
            header('Content-Type: application/json');
            echo $this->message("Trade not specified");
        }
        return;
    }
}