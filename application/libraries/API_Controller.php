<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');

class API_Controller extends REST_Controller {
    
    function __construct() {
        parent::__construct();
        // Facebook login referenced from:
        //  http://phpguidance.wordpress.com/2013/09/27/facebook-login-with-codeignator/comment-page-1/
        parse_str($_SERVER['QUERY_STRING'],$_REQUEST);
        $this->load->library('Facebook', 
            array(
                "appId" => FB_APPID, 
                "secret" => FB_SECRET
            )
        );

        $this->facebook_url = '';    
        $this->facebook_user = $this->facebook->getUser();
        
        if ( $this->facebook_user ) {
            // Registers the facebook user if not already done.
            // Always returns the local user ID of this person from our database.
            $user = $this->user->try_register( $this->facebook_user );
            $this->session->set_userdata('user_id', $user->id);
            $this->facebook_url = $this->facebook->getLogouturl(
                array(
                    "next" => base_url() . 'main/logout'
                )
            );
        } else {
            $this->facebook_url = $this->facebook->getLoginUrl(
                array(
                    "display" => "page"
                )
            );
        }
    }

    function index_get() {
        echo $this->session->userdata('user_id');
    }
}