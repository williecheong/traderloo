<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/API_Controller.php');

class Trades extends API_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('user');
        $this->load->model('trade');
        $this->load->model('stock');
        $this->load->model('balance');
    }

    public function index_get() {
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode($this->trade->retrieve());   
    }

    public function active_get() {
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode($this->trade->retrieve_active());           
    }

    public function history_get() {
        http_response_code("200");
        header('Content-Type: application/json');
        echo json_encode($this->trade->retrieve_history());           
    }    

    public function index_post() {
        $symbol = $this->post('symbol');
        $quantity = $this->post('quantity');
        if ( $symbol && $quantity ) {
            if ( is_numeric($quantity) && $quantity > 0 ) {
                $stock = $this->stock->retrieve($symbol);
                if ( $stock ) {
                    $trade = $this->trade->open($stock, $quantity);
                    if ( $trade ) {    
                        if ( isset($trade->id) ) {
                            http_response_code("201");
                            header('Content-Type: application/json');
                            echo json_encode($trade);
                        } else { // if ( $trade == 'insufficient_funds' ) {
                            http_response_code("424");
                            header('Content-Type: application/json');
                            echo $this->message("Insufficient funds in account");
                        }
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
                http_response_code("406");
                header('Content-Type: application/json');
                echo $this->message("Invalid quantity of shares");  
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