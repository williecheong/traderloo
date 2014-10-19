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
            
            $new_balance = $this->balance->debit( 
                (float)$stock->LastTradePriceOnly * (float)$quantity,
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

                $new_balance = $this->balance->credit( 
                    (float)$current_price * (float)$trade->shares,
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

    function retrieve_active() {
        $query = array(
            'closed_user' => NULL,
            'closed_price' => NULL,
            'closed_datetime' => NULL
        );
        return $this->trade->retrieve($query);
    }

    function retrieve_history() {
        $query = array(
            'closed_user IS NOT NULL' => NULL,
            'closed_price IS NOT NULL' => NULL,
            'closed_datetime IS NOT NULL' => NULL
        );
        return $this->trade->retrieve($query);
    }

    function transform_users( $trades = array() ) {
        foreach ($trades as $key => $trade) {
            if ( $trade->opened_user ) {
                $trades[$key]->opened_user = $this->user->public_safe(
                    $this->user->retrieve_by_id( 
                        $trade->opened_user
                    ) 
                );
            }

            if ( $trade->closed_user ) {
                $trades[$key]->closed_user = $this->user->public_safe(
                    $this->user->retrieve_by_id( 
                        $trade->closed_user 
                    )
                );
            }
        }
        
        return $trades;
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
        $this->db->order_by("id", "desc"); 
        $this->db->where($data);
        $query = $this->db->get('trade');
        return $this->trade->transform_users( $query->result() );
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