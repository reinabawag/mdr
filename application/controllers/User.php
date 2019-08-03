<?php
/**
* 
*/
class User extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['dr_model', 'user_model']);
		$this->load->helper(['url', 'form', 'html']);
		$this->load->library(['form_validation', 'session']);

		if ( ! $this->session->logged_in) {
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('main/user');
		$this->load->view('templates/footer');
	}

	public function password()
	{
		$logins = file_get_contents('login.txt');
		$login_array = explode(',', $logins);

		if (in_array($this->session->userId, $login_array)) {
			redirect('login');
		} else {
			$this->load->view('templates/header');
			$this->load->view('main/change_password');
			$this->load->view('templates/footer');
		}
	}

	public function change_password()
	{
		$json = [];

		if ($this->input->is_ajax_request() == false) {
			redirect('login');
		} else {
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[65]');
			$this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');

			if ($this->form_validation->run() == false) {
				$json['password'] = form_error('password');
				$json['c_password'] = form_error('c_password');

				echo json_encode(['status' => false, 'error' => $json]);
			} else {
				$password = trim($this->input->post('password'));
				$bool = $this->user_model->change_password($this->session->userId, $password);
				$logins = file_get_contents('login.txt');
				$login_array = explode(',', $logins);

				if (! in_array($this->session->userId, $login_array)) {
					if ($bool)
						file_put_contents('login.txt', $this->session->userId.',', FILE_APPEND | LOCK_EX);
				}
				$this->user_model->change_password_log($this->session->username, 'Initial Changed Password');
				echo json_encode(['status' => $bool, 'url' => site_url('login')]);
			}
		}
	}
}