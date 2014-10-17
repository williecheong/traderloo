<?php

class trade extends CI_Model{
    
    function open( $stock = array(), $quantity = 0 ) {
        try {
            $trade_id = $this->trade->create(
                array(
                    'stock' => $stock->symbol,
                    'shares' => $quantity,
                    'opened_user' => $this->session->userdata('user_id'),
                    'opened_price' => $stock->LastTradePriceOnly,
                    'opened_datetime' => time()
                )
            );            
            
            $current_balance = $this->account->get_balance();
            $cost = (float)$stock->LastTradePriceOnly * (float)$quantity;
            $new_balance = $this->account->update_balance( 
                (float)$current_balance - (float)$cost,
                "opened_trade", $trade_id 
            );
            return $this->trade->retrieve_by_id( $trade_id );
        } catch ( Exception $e ) {
            return false;
        }
    }

    function close( $trade = array() ) {
        if ( $trade ) {
            $stock = $this->stock->retrieve($trade->stock);
            if ( $stock ) {
                $current_price = $stock->LastTradePriceOnly;
                $this->trade->update(
                    array(
                        'id' => $trade->id
                    ),
                    array(
                        'closed_user' => $this->session->userdata('user_id'),
                        'closed_price' => $stock->LastTradePriceOnly,
                        'closed_datetime' => time()
                    )
                );

                $quantity = $trade->shares;
                $current_balance = $this->account->get_balance();
                $holding_value = (float)$current_price * (float)$quantity;
                $new_balance = $this->account->update_balance( 
                    (float)$current_balance + (float)$holding_value,
                    "closed_trade", $trade->id 
                );
                
                return $this->trade->retrieve_by_id( $trade->id );
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function retrieve_by_id( $id = 0 ) {
        $objects = $this->trade->retrieve(
            array(
                'id' => $id
            )
        );

        if ( count($objects) > 0 ) {
            return $objects[0];
        } else {
            return false;
        }
    }

    // BEGIN BASIC CRUD FUNCTIONALITY

    function create( $data = array() ){
        $this->db->insert('trade', $data);    
        return $this->db->insert_id();
    }

    function retrieve( $data = array() ){
        $this->db->where($data);
        $query = $this->db->get('trade');
        return $query->result();
    }
    
    function update( $criteria = array(), $new_data = array() ){
        $this->db->where($criteria);
        $this->db->update('trade', $new_data);
    }
    
    function delete( $data = array() ){
        $this->db->where($data);
        $this->db->delete('trade');
    }

}

?>