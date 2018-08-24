<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('home_model');
	}

	public function index()
	{
		$this->check_auth();
		$data = array(
            'title'=> 'Gasnet - ATK! - Login',
            'nav' => 'nav.php',
            'isi' => 'pages/home',
            'nav_active' => ''
        );
        $this->load->view('layout/wrapper',$data);
	}

	public function login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$data = array(
			'email' => $email,
			'password' => $password			
		);

		$whereS = array(
		    'email' => $email
        );

        if($email == "" || $password == ""){
        	$this->session->set_userdata('login_error', 'Harap masukkan semua input...');
        	redirect(base_url());
        }else{
            $login = $this->home_model->get_users($data);

            if($login != "not_registered"){
                $status = $this->home_model->get_usersStatus($whereS)->status;
            }

            if($login == "not_registered") {
            	$this->session->set_userdata('login_error', 'Email belum terdaftar....');
            	redirect(base_url());
            } elseif($status != "aktif") {
            	$this->session->set_userdata('login_error', 'Akun anda sudah di nonaktifkan....');
            	redirect(base_url());
            } else {
                $db_pass = $this->home_model->get_users_pass($email)->password;
                $name = $this->home_model->get_users_data($email)->nama;
                $level = $this->home_model->get_users_level($email);

                if(password_verify($password, $db_pass)){
                    $this->session->set_userdata('atk_email', $email);
                    $this->session->set_userdata('atk_password', $password);
                    $this->session->set_userdata('atk_level', $level);

                    $_SESSION['success'] = ["Berhasil Login!","Selamat datang kembali di Gasnet ATK, ".$name];

                    redirect(base_url()."permintaan");
                } else {
                	$this->session->set_userdata('login_error', 'Password yang dimasukkan salah....');
                	redirect(base_url());
                }
            }
        }

	}

	function logout()
    {   
        if( $this->session->has_userdata('atk_email')){
            unset(
                $_SESSION['atk_email'],
                $_SESSION['atk_password'],
                $_SESSION['atk_level']
            );
            $this->session->sess_destroy();
        }
        $_SESSION['login_success'] = "Anda berhasil logout";
        redirect(base_url());
    }

    // user authentication based on session 'atk_level'
    public function check_auth()
    {
        if (isset($_SESSION['atk_email'])) {
            redirect(base_url()."permintaan/");
        }
    }
}
