<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
	}

	public function Captcha($sessionname="FrontCaptcha"){
        $this->load->helper('captcha');
        $this->load->helper('string');
        $random_string  =   random_string('numeric',4);
        $this->session->set_userdata([$sessionname=>strtolower($random_string)]);
        $this->captcha_setting  =   [
                                        'word'          =>  $random_string,
                                        'img_path'      =>  './captcha/',
                                        'expiration'    =>  7200,
                                        'img_width'     =>  65,
                                        'img_height'    =>  30,
                                        'img_url'       =>  base_url('captcha'),
                                        'word_length'   =>  0,
                                    ];
		create_captcha($this->captcha_setting);
	}
}
