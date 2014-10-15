<?php

class user extends CI_Model{
    
    function try_register( $facebook_id = 0 ) {
        $availability = $this->user->retrieve_by_id($facebook_id);
        
        if ( $availability ) {
            // user exists, 
            // update image and name
            // update last_active for last login
            $facebook_profile = $this->facebook->api('/me');
            $this->user->update(
                array(
                    'id' => $availability[0]->id
                ),
                array(
                    'name' =>$facebook_profile['name'],
                    'last_login' => date( 'Y-m-d H:i:s' )
                )
            );

            return $availability[0];

        } else {
            // user does not exist yet.
            // put this facebook person inside our database
            $facebook_profile = $this->facebook->api('/me');
            $user_id = $this->user->create(
                array(
                    'id' => $facebook_id,
                    'name' => $facebook_profile['name'],
                    'email' => ( isset($facebook_profile['email']) ) ? $facebook_profile['email'] : '',
                    'cell_number' => '',
                    'rating' => '',
                    'notifications' => '',
                    'last_login' => date( 'Y-m-d H:i:s' )
                )
            );

            $user = $this->user->retrieve_by_id( $user_id );

            return $user;
        }
    }

    function retrieve_by_id( $id = 0 ) {
        $objects = $this->user->retrieve(
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
        $this->db->insert('user', $data);    
        return $this->db->insert_id();
    }

    function retrieve( $data = array() ){
        $this->db->where($data);
        $query = $this->db->get('user');
        return $query->result();
    }
    
    function update( $criteria = array(), $new_data = array() ){
        $this->db->where($criteria);
        $this->db->update('user', $new_data);
    }
    
    function delete( $data = array() ){
        $this->db->where($data);
        $this->db->delete('user');
    }

}

?>