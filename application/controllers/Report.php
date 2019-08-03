<?php 
use JasperPHP\JasperPHP;
class Report extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['dr_model']);
		$this->load->helper(['url', 'form', 'html']);
		$this->load->library(['form_validation', 'session']);
		if ( ! $this->session->logged_in) {
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('report/index');
		$this->load->view('templates/footer');
	}

	public function audit_report()
	{
		$from = $this->input->get('startDate');
		$to = $this->input->get('endDate');

		$jasper = new JasperPHP;
		$jasper->process(
			'report/audit_rpt.jrxml',
			FALSE,
			['pdf', 'xls'],
			['startDate' => date('Y-m-d', strtotime($from)), 'endDate' => date('Y-m-d', strtotime($to))],
			array(
				'driver' => 'mysql',
				'username' => 'root',	
				'host' => 'localhost',
				'password' => '',
				'database' => 'mdr',
				'port' => '3306'
			)
		)->execute();
		$filename = 'MDR_AUDIT_REPORT_'.date('mdY', strtotime($from)).'-'.date('mdY', strtotime($to));
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename .'.pdf"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		@readfile('report/audit_rpt.pdf');
	}
}