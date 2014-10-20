<?php

class balance extends CI_Model{
    
    function debit( $amount = 0, $reason = "", $reason_detail = "" ) {
        $current_balance = $this->balance->get_current();
        $new_balance = $this->balance->insert(
            (float)$current_balance - (float)$amount,
            $reason, $reason_detail
        );

        return $new_balance;    
    }

    function credit( $amount = 0, $reason = "", $reason_detail = "" ) {
        $current_balance = $this->balance->get_current();
        $new_balance = $this->balance->insert(
            (float)$current_balance + (float)$amount,
            $reason, $reason_detail
        );

        return $new_balance;    
    }

    function insert( $amount = 0, $reason = "", $reason_detail = "" ) {
        $this->db->insert('balance', 
            array(
                'value' => $amount,
                'reason' => $reason,
                'reason_detail' => $reason_detail
            )
        );
        return $this->balance->get_current();
    } 

    function get_current( $full_object = false ) {
        $query = "select * from balance order by id DESC limit 1";
        $response = $this->db->query( $query );
        $results = $response->result();

        if ( count($results) > 0 ) {
            if ( $full_object ) {
                return $results[0];
            } else {
                return $results[0]->value;
            }
        } else {
            return false;
        }
    }

    function transform_trades( $balances = array() ) {
        foreach ($balances as $key => $balance) {
            if ( $balance->reason == "opened_trade" || $balance->reason == "closed_trade" ) {
                if ( $balance->reason_detail ) {
                    $balances[$key]->reason_detail = $this->trade->retrieve_by_id( $balance->reason_detail );                    
                }
            }
        }
        return $balances;
    }

    function get_all() {
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get('balance');
        return $this->balance->transform_trades( $query->result() );
    }
}

?>