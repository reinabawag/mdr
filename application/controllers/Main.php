<?php
/**
* 
*/
use JasperPHP\JasperPHP as JasperPHP;
use Faker\Factory as Faker;

class Main extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['dr_model']);
		$this->load->helper(['url', 'form', 'html', 'path']);
		$this->load->library(['form_validation', 'session']);

		if ( ! $this->session->logged_in) {
			redirect('login');
		}
	}

	public function index()
	{
		$data['number'] = $this->dr_model->get_last_dr() + 1;

		$this->load->view('templates/header');
		$this->load->view('main/index', $data);
		$this->load->view('templates/footer');
	}

	public function logs()
	{
		$this->load->view('templates/header');
		$this->load->view('main/logs');
		$this->load->view('templates/footer');
	}

	public function create_dr()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		// dr is now 
		// $this->form_validation->set_rules('number', 'Number', 'required|is_unique[dr.id]|numeric');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('plate', 'Plate Number', 'required');
		$this->form_validation->set_rules('type', 'Delivery Type', 'required');
		$this->form_validation->set_rules('deliver', 'Delivery To', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		// additional
		$this->form_validation->set_rules('auditor', 'Auditor', 'required|in_list[Egan Tobias,Aries Saquibal,Vianney Legacion]');
		$this->form_validation->set_rules('approver', 'Approver', 'required');

		if ($this->form_validation->run() == FALSE) {
			$json['number'] = form_error('number');
			$json['date'] = form_error('date');
			$json['plate'] = form_error('plate');
			$json['type'] = form_error('type');
			$json['deliver'] = form_error('deliver');
			$json['address'] = form_error('address');
			// additional
			$json['auditor'] = form_error('auditor');
			$json['approver'] = form_error('approver');
			$json['remarks'] = form_error('remarks');
			echo json_encode(['status' => FALSE, 'error' => $json, 'msg' => 'Please provide all the needed information']);
		} else {
			// declaration of variables
			$number = trim($this->input->post('number'));
			$date = trim($this->input->post('date'));
			$plate = trim($this->input->post('plate'));
			$type = trim($this->input->post('type'));
			$deliver = trim($this->input->post('deliver'));
			$address = trim($this->input->post('address'));
			// additional
			$auditor = trim($this->input->post('auditor'));
			$approver = trim($this->input->post('approver'));
			$approver = ucwords($approver);
			$name = trim($this->session->lastName.', '.$this->session->firstName);
			$remarks = trim($this->input->post('remarks'));
			// die(var_dump($number));
			$bool = $this->dr_model->insert_dr($number, $date, $plate, $type, $deliver, $address, $auditor, $approver, $name, $remarks);

			if ($bool['bool']) {
				$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, "MDR CREATED ".str_pad($bool['number'], 6, 0, STR_PAD_LEFT), 'Create MDR');
				echo json_encode(['status' => TRUE, 'msg' => 'MISC - DR Information saved', 'number' => str_pad($bool['number'], 6, 0, STR_PAD_LEFT)]);
			} else {
				echo json_encode(['status' => FALSE, 'msg' => 'MISC - DR Information not saved']);
			}				
		}
	}

	public function update_dr()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('plate', 'Plate Number', 'required');
		$this->form_validation->set_rules('type', 'Delivery Type', 'required');
		$this->form_validation->set_rules('deliver', 'Delivery To', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		// additional
		$this->form_validation->set_rules('auditor', 'Auditor', 'required|in_list[Egan Tobias,Aries Saquibal]');
		$this->form_validation->set_rules('approver', 'Approver', 'required');

		if ($this->form_validation->run() == FALSE) {
			$json['number'] = form_error('number');
			$json['date'] = form_error('date');
			$json['plate'] = form_error('plate');
			$json['type'] = form_error('type');
			$json['deliver'] = form_error('deliver');
			$json['address'] = form_error('address');
			// additional
			$json['auditor'] = form_error('auditor');
			$json['approver'] = form_error('approver');
			$json['remarks'] = form_error('remarks');
			echo json_encode(['status' => FALSE, 'error' => $json, 'msg' => 'Please provide all the needed information']);
		} else {
			// declaration of variables
			$number = trim($this->input->post('number'));
			$date = trim($this->input->post('date'));
			$plate = trim($this->input->post('plate'));
			$type = trim($this->input->post('type'));
			$deliver = trim($this->input->post('deliver'));
			$address = trim($this->input->post('address'));
			// additional
			$auditor = trim($this->input->post('auditor'));
			$approver = trim($this->input->post('approver'));
			$approver = ucwords($approver);
			$name = trim($this->session->lastName.', '.$this->session->firstName);
			$remarks = trim($this->input->post('remarks'));

			$old = $this->dr_model->get_dr_by_number($number);
			$bool = $this->dr_model->update_dr($number, $date, $plate, $type, $deliver, $address, $auditor, $approver, $remarks);
			$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, "MDR $number Updated From [$old->date, $old->plate, $old->type, $old->deliver_to, $old->address, $old->auditor, $old->approver, $old->remarks] To [$date, $plate, $type, $deliver, $address, $auditor, $approver, $remarks]", 'Updated MDR');

			echo json_encode(['status' => $bool]);			
		}
	}

	public function remove_dr()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$number = $this->input->post('number');
		$empty = $this->input->post('empty');
		if (is_null($empty)) {
			$empty = '';
		}
		$bool = $this->dr_model->remove_dr($number);

		if ($empty == 'TRUE') {
			// if (count($this->dr_model->get_items($number)) == 0) {
				$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, "Empty MDR removed by the System ".str_pad($number, 6, 0, STR_PAD_LEFT), 'Removed MDR');
			// }
		} elseif ($empty == '') {
			$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, "MDR REMOVED ".str_pad($number, 6, 0, STR_PAD_LEFT), 'Removed MDR');
		}

		echo json_encode(['status' => $bool]);
	}

	public function add_item()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$this->form_validation->set_rules('qty', 'Quantity', 'required|numeric');
		$this->form_validation->set_rules('unit', 'Unit', 'required|max_length[5]');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if ($this->form_validation->run() == FALSE) {
			$json['qty'] = form_error('qty');
			$json['unit'] = form_error('unit');
			$json['description'] = form_error('description');

			echo json_encode(['status' => FALSE, 'error' => $json]);
		} else {
			$number = $this->input->post('number');
			$qty = $this->input->post('qty');
			$unit = $this->input->post('unit');
			$description = $this->input->post('description');

			$bool = $this->dr_model->insert_item($number, $qty, $unit, $description);
			echo json_encode(['status' => $bool]);
		}
	}

	public function get_items()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$number = $this->input->post('number');
		$data = $this->dr_model->get_items($number);

		echo json_encode(['items' => $data]);
	}

	public function remove_item()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$number = $this->input->post('number');
		$item = $this->input->post('item');
		$old = $this->dr_model->get_item($item);

		if ($this->dr_model->get_dr_by_number($number)->is_viewed) {
			die(json_encode(['status' => FALSE, 'msg' => 'MDR already previewed and assumed printed']));
		}

		if ($this->dr_model->remove_item($item)) {
			$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, "MDR $number Item Removed [$old->quantity, $old->unit, $old->description]", 'Removed MDR');
			echo json_encode(['status' => TRUE, 'msg' => 'Item removed from the MDR List']);
		} else {
			echo json_encode(['status' => FALSE, 'msg' => 'Item failed to removed']);
		}
	}

	public function get_item()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$item = $this->input->post('item');
		$data = $this->dr_model->get_item($item);

		if ( ! is_null($data)) {
			echo json_encode($data);
		}
	}

	public function update_item()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$this->form_validation->set_rules('qty', 'Quantity', 'required|numeric');
		$this->form_validation->set_rules('unit', 'Unit', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if ($this->form_validation->run() == FALSE) {
			$json['qty'] = form_error('qty');
			$json['unit'] = form_error('unit');
			$json['description'] = form_error('description');

			echo json_encode(['status' => FALSE, 'error' => $json]);
		} else {
			$number = $this->input->post('number');
			$item = $this->input->post('item');
			$qty = $this->input->post('qty');
			$unit = $this->input->post('unit');
			$description = $this->input->post('description');

			$old = $this->dr_model->get_item($item);
			$bool = $this->dr_model->update_item($item, $qty, $unit, $description);
			$new = $this->dr_model->get_item($item);
			$this->dr_model->audit_trail($this->session->userId, $this->session->lastName.', '.$this->session->firstName, "MDR $number Item Updated From [$old->quantity, $old->unit, $old->description] To [$new->quantity, $new->unit, $new->description] ", 'UPDATED MDR');			
			echo json_encode(['status' => $bool]);
		}
	}

	public function calendar()
	{
		$this->load->view('templates/header');
		$this->load->view('main/calendar');
		$this->load->view('templates/footer');
	}

	public function events()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$start = $this->input->get('start');
		$end = $this->input->get('end');	
		$result = $this->dr_model->get_dr_by_date($start, $end);

		if (count($result) > 0) {
			foreach ($result as $key => $value) {
				$dates[] = ['title' => $value->deliver_to, 'start' => $value->date, 'end' => $value->date, 'backgroundColor' => $value->date == date('Y-m-d') ? '#2d874b' : '', 'url' => site_url("main/mdr/").str_pad($value->id, 6, 0, 0)];
			}

			echo json_encode($dates);	
		}
	}

	public function get_dr_number()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$data = $this->dr_model->get_dr_number();
		$json = [];

		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$json[$value->id] = str_pad($value->id, 6, 0, 0);
			}
		}

		echo json_encode($json);
	}

	public function get_dr_by_number()
	{
		if ($this->input->is_ajax_request() == FALSE) {
			redirect('main');
		}

		$number = $this->input->post('number');
		$data = $this->dr_model->get_dr_by_number($number);

		if ( ! is_null($data)) {
			$data->date = date('m/d/Y', strtotime($data->date));
			echo json_encode($data);
		}
	}

	public function deprecated($number)//print_dr
	{
		include_once('class/tcpdf/tcpdf.php');
		include_once('class/PHPJasperXML.inc.php');
		$xml =  simplexml_load_file('report/mdr_file.jrxml');
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->debugsql=false;
		$remarks = $this->dr_model->get_description_by_number($number);
		$PHPJasperXML->arrayParameter=array('num' => str_pad($number, 6, 0, 0), 'number' => $number, 'remarks' => $remarks->remarks);
		// $PHPJasperXML->load_xml_file("report/mdr_file.jrxml"); // load xml using file instead of string
		$PHPJasperXML->xml_dismantle($xml);

		$PHPJasperXML->transferDBtoArray('localhost', 'root', '', 'mdr');
		$PHPJasperXML->outpage('I', 'MDR_'.str_pad($number, 6, 0, 0).'_'.date('mdY'));    //page output method I:standard output  D:Download file
	}

	// for datatables
	public function get_all_dr()
	{
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$lenght = $this->input->post('length');
		$search = $this->input->post('search[value]');
		$column = $this->input->post('order[0][column]');
		$order = $this->input->post('order[0][dir]');
		
		switch ($column) {
			case 0:
				$column = 'id';
				break;
			case 1:
				$column = 'deliver_to';
				break;
			case 2:
				$column = 'address';
				break;
			case 3:
				$column = 'date';
				break;
			default:
				$column = 'id';
				break;
		}
		$count = 0;
		$data = $this->dr_model->get_all_dr($start, $lenght, $search, $column, $order);
		foreach ($data['data'] as $key => $value) {
			$count++;
			$value->id = str_pad($value->id, 6, 0, 0);
		}

		echo json_encode(['draw' => $draw, 'recordsTotal' => $data['count'], 'recordsFiltered' => $data['filtered'], 'data' => $data['data']]);
	}

	public function audit_logs()
	{
		$this->load->helper('date');
		$json = array();
		$date = $this->input->get('date');
		$filter = $this->input->get('filter');
		$data = $this->dr_model->get_audit_logs(date('Y-m-d', strtotime($date)), $filter);
		
		if ( ! is_array($data) || count($data) == 0) {
			echo json_encode(['No matching logs found.']);
		} else {
			foreach ($data as $key => $value) {
				$json[] = "[$value->date] $value->name $value->description\r\n";
			}

			echo json_encode($json);
		}
	}

	public function print_dr($number)//jasper_new
	{
		$this->load->helper('file');
		try {
			$this->dr_model->lock_dr($number);
			// $temp = 'MDR_'.str_pad($number, 6, 0, 0).'_'.date('Ymd');
			$temp = 'mdr_file';
			$filename = 'MDR_'.str_pad($number, 6, 0, 0).'_'.date('Ymd');
			$file = 'report/'.$temp.'.pdf';
			delete_files($file);
			$jasper = new JasperPHP;
			// $jasper->compile('report/mdr_file.jrxml')->execute();

			// $output = $jasper->list_parameters(
			// 		"report/sample3.jasper"
			// 	)->execute();

			// foreach($output as $parameter_description)
			// 	echo $parameter_description;

			// $jasper->process(
			// 	'report/sample3.jasper',
			// 	// 'report/'.$temp,
			// 	FALSE,
			// 	array("pdf"),
			// 	//'num' => str_pad($number, 6, 0, 0), 'number' => intval($number), 
			// 	array('parameter1' => 1, 'SUBREPORT_DIR' => 'report/'),
			// 	array(
			// 		'driver' => 'mysql',
			// 		'username' => 'root',	
			// 		'host' => 'localhost',
			// 		'password' => '',
			// 		'database' => 'phpjasperxml',
			// 		'port' => '3306'
			// 	)
			// )->execute();

			$jasper->process(
				'report/mdr_file.jrxml',
				'report/'.$temp,
				// FALSE,
				['pdf'],
				['num' => str_pad($number, 6, 0, 0), 'number' => intval($number)], 
				// array('parameter1' => 1, 'SUBREPORT_DIR' => 'report/'),
				array(
					'driver' => 'mysql',
					'username' => 'root',	
					'host' => 'localhost',
					'password' => '',
					'database' => 'mdr',
					// 'database' => 'phpjasperxml',
					'port' => '3306'
				)
			)->execute();

			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="' . $filename .'.pdf"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			readfile($file);
		} catch (Exception $e) {
			echo $e->getMessage();
		}		
	}

	// public function make_item_data() 
	// {
	// 	for ($i=0; $i < 10; $i++) { 
	// 		$this->dr_model->insert_item(29, mt_rand(100, 9999), 'KGS', 'DESCRIPTION '.$i);
	// 		// $this->dr_model->insert_item(28, )
	// 	}
	// 	echo 'Done';
	// }

	// public function faker()
	// {
	// 	try {
	// 		$faker = Faker::create();
	// 		// dr
	// 		for ($i=0; $i < 50; $i++) {
	// 			$this->dr_model->insert_dr(0, $faker->date($format = 'Y-m-d', $max = 'next week'), strtoupper($faker->bothify('??? ####')), $faker->bothify('## Wheeler Truck'), $faker->company(), $faker->address(), $faker->randomElement($array = array ('Egan Tobias', 'Aries Saquibal')), 'Alfredo Medes', $faker->name(), '');
	// 		}
	// 		// items
	// 		for ($i=0; $i < 250; $i++) { 
	// 			$this->dr_model->insert_item($faker->numberBetween($min = 1, $max = 1000), $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 50), $faker->randomElement(array('KGS','PCS')), $faker->sentence());
	// 		}
	// 	} catch (Exception $e) {
			
	// 	}
	// }

	public function auditor()
	{
		$this->load->view('templates/header');
		$this->load->view('main/auditor');
		$this->load->view('templates/footer');
	}

	public function get_auditor()
	{
		
	}
}