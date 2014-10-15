<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
            // $user = $this->user->try_register( $this->facebook_user );
            
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('email', $user->email);
            
            $this->facebook_url = $this->facebook->getLogouturl(
                array(
                    "next" => base_url() . 'api/misc/logout'
                )
            );
        
        } else {
            $this->facebook_url = $this->facebook->getLoginUrl(
                array(
                    "scope" => "email,manage_notifications",
                    "display" => "page"
                )
            );
        }
    }
    
	public function index( $load_personal = false ) {
        // Is session available when user is requesting the personal page?
        if ( $this->session->userdata('user_id') ) {
            $this->load->view('main_logged_in');
        } else {
            $this->load->view('main_logged_out');
        }
    }
}