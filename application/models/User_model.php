<?php

class User_model extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	public function auth($username, $password, $systemId)
	{
		$db = $this->load->database('security', TRUE);

		$db->where(array('username' => $username, 'systemId' => $systemId));
		$db->join('empinfo', 'empinfo.userId=user.userId', 'left');
		$db->join('system_user', 'system_user.userId=empinfo.userId');
		$query = $db->get('user');
		
		if (is_null($query->row()) == FALSE) {
			if (password_verify($password, $query->row()->password)) {
				return $query->row_array();
			} else {
				return FALSE;
			}
		}

		return FALSE;
	}

	public function change_password($id, $password)
	{
		$db = $this->load->database('security', TRUE);

		$db->where('userId', $id);
		return $db->update('user', ['password' => password_hash($password, PASSWORD_BCRYPT)]);
	}

	public function change_password_log($username, $desc)
	{
		$db = $this->load->database('security', true);
		$db->insert('password_logs', ['username' => $username, 'description' => $desc]);
	}
}