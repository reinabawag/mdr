<?php 
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['user_model', 'dr_model']);
		$this->load->helper(['form', 'url', 'html']);
		$this->load->library(['form_validation', 'session']);
	}

	public function index()
	{
		if ($this->session->logged_in) {
			redirect('main');
		}

		$this->load->view('templates/header');
		$this->load->view('login');
		$this->load->view('templates/footer');
	}

	public function auth_login()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('login');
		}

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$json = [];

		if ($this->form_validation->run() == FALSE) {
			$bool = FALSE;
			$json['username'] = [form_error('username')];
			$json['password'] = [form_error('password')];

			echo json_encode(['status' => FALSE, 'validation' => $json]);
		} else {
			$json = array();
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$empInfo = $this->user_model->auth($username, $password, 3);
			$url = '';
			if ( ! is_array($empInfo) || is_null($empInfo) || is_bool($empInfo)) {
				$bool = FALSE;
				$json = array('message' => 'Invalid credentials or you don\'t have access to the system');
				$json['username'] = [' '];
				$json['password'] = [' '];
			} else {
				$this->session->set_userdata('logged_in', TRUE);
				$this->session->set_userdata($empInfo);
				$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, 'Login', 'login');
				$bool = TRUE;

				$logins = file_get_contents('login.txt');
				$login_array = explode(',', $logins);

				if (! in_array($this->session->userId, $login_array)) {
					$url = site_url('user/password');
					// file_put_contents('login.txt', $this->session->userId.',', FILE_APPEND | LOCK_EX);
				} else {
					$url = site_url('main');
				}

				$json = array('message' => 'Login successful', 'url' => $url);
				$json['username'] = [];
				$json['password'] = [];
			}	

			echo json_encode(['status' => $bool,'validation' => $json, 'url' => $url]);
		}
	}

	public function logout()
	{
		if ($this->session->logged_in) {
			$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, 'Logged Out', 'login');
		} else
		{
			$this->dr_model->audit_trail("NULL", "NULL", "Session Expired", 'login');
		}
		$this->session->sess_destroy();
		redirect('login');
	}
}