<?php

class user extends CI_Model{
    
    function try_register( $facebook_id = 0 ) {
        $user = $this->user->retrieve_by_id($facebook_id);
        
        if ( $user ) {
            $facebook_profile = $this->facebook->api('/me');
            $this->user->update(
                array(
                    'id' => $user->id
                ),
                array(
                    'name' =>$facebook_profile['name'],
                    'last_login' => time()
                )
            );

            return $user;

        } else {
            // user does not exist yet.
            // put this facebook person inside our database
            $facebook_profile = $this->facebook->api('/me');
            $user_id = $this->user->create(
                array(
                    'id' => $facebook_id,
                    'name' => $facebook_profile['name'],
                    'last_login' => time()
                )
            );

            $user = $this->user->retrieve_by_id( $user_id );

            return $user;
        }
    }

    function public_safe( $user = array() ) {
        unset( $user->rating );
        unset( $user->last_login );
        unset( $user->last_updated );
        return $user;
    }

    function retrieve_active() {
        return $this->user->retrieve(
            array(
                'last_login >' => time() - ACTIVE_THRESHOLD
            )
        );
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