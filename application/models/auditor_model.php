<?php
/**
 * 
 */
class auditor_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	private $id;
	private $name;

	public function get_auditors()
	{
		$this->load->database();


		$query = $this->db->get('auditor');
	}
}