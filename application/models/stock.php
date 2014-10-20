<?php

class stock extends CI_Model{
    
    function retrieve( $symbol = "" ) {
        try {
            $url = "http://query.yahooapis.com/v1/public/yql";
            $query = encode_uri_component("select * from yahoo.finance.quotes where symbol in ('" . $symbol . "')");
            $extras = "&format=json&env=http://datatables.org/alltables.env";
            $full_query = $url . "?q=" . $query . $extras;
            
            $response = rest_curl( $full_query );
            $response_decoded = json_decode($response); 
            
            if ( isset($response_decoded->query->results->quote->LastTradePriceOnly) ) {
                if ( $response_decoded->query->results->quote->LastTradePriceOnly > 0 ) {
                    return $response_decoded->query->results->quote;  
                }
            } 
            return false;
        } catch ( Exception $e ) {
            return false;
        }
    }

    function retrieve_all() {
        try {
            $response = file_get_contents(FCPATH.'assets/js/stock_listing.json');
            $response_decoded = json_decode($response);        
        
            return $response_decoded;   

        } catch ( Exception $e ) {
            return false;
        }
    }
}