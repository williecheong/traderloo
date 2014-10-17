<?php

class account extends CI_Model{
    
    function deduct( $amount = 0 ) {
        $current_balance = $this->account->get_balance();
        $new_balance = (float)$current_balance - (float)$amount;
        $this->account->put_balance( $new_balance );
        return $new_balance;
    } 

    function get_balance() {
        $this->db->where('property', 'balance');
        $query = $this->db->get('account');
        $results = $query->result();

        if ( count($results) > 0 ) {
            return $results[0]->value;
        } else {
            return false;
        }
    }

    function put_balance( $new_balance = 0 ) {
        if ( $new_balance ) {
            $this->db->where('property', 'balance');
            $this->db->update('account', array('value' => $new_balance));            
        }

        return $this->account->get_balance();
    }
}

?>