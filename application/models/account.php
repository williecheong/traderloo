<?php

class account extends CI_Model{
    
    function debit( $amount = 0, $reason = "", $reason_detail = "" ) {
        $current_balance = $this->account->get_balance();
        $new_balance = $this->account->update_balance(
            (float)$current_balance - (float)$amount,
            $reason, $reason_detail
        );

        return $new_balance;    
    }

    function credit( $amount = 0, $reason = "", $reason_detail = "" ) {
        $current_balance = $this->account->get_balance();
        $new_balance = $this->account->update_balance(
            (float)$current_balance + (float)$amount,
            $reason, $reason_detail
        );

        return $new_balance;    
    }

    function update_balance( $amount = 0, $reason = "", $reason_detail = "" ) {
        $this->db->insert('balance', 
            array(
                'value' => $amount,
                'reason' => $reason,
                'reason_detail' => $reason_detail
            )
        );
        return $this->account->get_balance();
    } 

    function get_balance( $full_object = false ) {
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
}

?>