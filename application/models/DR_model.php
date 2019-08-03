<?php
/**
* 
*/
class DR_model extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	public function get_last_dr()
	{
		return $this->db->count_all('dr');
	}

	public function insert_item($number, $qty, $unit, $description)
	{
		$this->db->insert('item', ['quantity' => $qty, 'unit' => $unit, 'description' => $description]);
		return $this->db->insert('dr_item', ['dr' => $number, 'item' => $this->db->insert_id()]);
	}

	public function insert_dr($number, $date, $plate, $type, $deliver, $address, $auditor, $approver, $name, $remarks)
	{
		$this->db->order_by('id', 'DESC');
		$tmp = @$this->db->get('dr')->row()->id + 1;
		$result = $this->db->insert('dr', ['id' => $tmp, 'date' => date('Y-m-d', strtotime($date)), 'plate' => $plate, 'type' => $type, 'deliver_to' => $deliver, 'address' => $address, 'name' => $name, 'auditor' => $auditor, 'approver' => $approver, 'remarks' => $remarks]);
		return ['bool' => $result, 'number' => $tmp];
	}

	public function update_dr($number, $date, $plate, $type, $deliver, $address, $auditor, $approver, $remarks)
	{
		$this->db->where('id', $number);
		return $this->db->update('dr', ['id' => $number, 'date' => date('Y-m-d', strtotime($date)), 'plate' => $plate, 'type' => $type, 'deliver_to' => $deliver, 'address' => $address, 'auditor' => $auditor, 'approver' => $approver, 'remarks' => $remarks]);
	}

	public function remove_dr($number)
	{
		$this->db->trans_begin();

		$this->db->where('id', $number);
		$this->db->delete('dr');

		$this->db->where('dr', $number);
		$data = $this->db->get('dr_item')->result();

		foreach ($data as $key => $value) {
			$this->db->where('id', $value->item);
			$this->db->delete('item');
		}

		$this->db->where('dr', $number);
		$this->db->delete('dr_item');

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return FALSE;
		}
		else {
	        $this->db->trans_commit();
	        return TRUE;
		}
	}

	public function get_items($number)
	{
		$this->db->where('dr_item.dr', $number);
		$this->db->join('dr_item', 'dr_item.item=item.id', 'left');
		return $this->db->get('item')->result();
	}

	public function remove_item($item)
	{
		$this->db->trans_begin();

		$this->db->where('id', $item);
		$this->db->delete('item');

		$this->db->where('item', $item);
		$this->db->delete('dr_item');
		
		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return FALSE;
		}
		else {
	        $this->db->trans_commit();
	        return TRUE;
		}
	}

	// for single item
	public function get_item($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('item')->row();
	}

	public function update_item($item, $qty, $unit, $description)
	{
		$this->db->where('id', $item);
		return $this->db->update('item', ['quantity' => $qty, 'unit' => $unit, 'description' => $description]);
	}

	public function get_dr_by_date($start, $end)
	{
		$this->db->where("date BETWEEN '$start' AND '$end'");
		return $this->db->get('dr')->result();
	}

	public function get_dr_number()
	{
		$this->db->select('id');
		$this->db->order_by('id', 'DESC');
		return $this->db->get('dr')->result();
	}

	public function get_dr_by_number($number)
	{
		$this->db->where('id', $number);
		return $this->db->get('dr')->row();
	}

	public function get_all_quantity($number)
	{
		$this->db->where('dr_item.dr', $number);
		$this->db->join('dr_item', 'dr_item.item=item.id', 'left');
		return $this->db->get('item')->result();

		die($this->db->last_query());
	}

	public function get_all_dr($start, $lenght, $search, $column, $order)
	{
		$count = $this->db->count_all_results('dr');
		$this->db->select('id, deliver_to, address, date');
		$this->db->or_like(['id' => $search, 'deliver_to' => $search, 'address' => $search, 'date' => $search]);
		$this->db->order_by($column, $order);
		$data = $this->db->get('dr', intval($lenght), intval($start));
		return ['data' => $data->result(), 'count' => $count, 'filtered' => $this->count_dr_result($search)];
	}

	public function count_dr_result($search)
	{
		$this->db->select('id, deliver_to, address, date');
		$this->db->or_like(['id' => $search, 'deliver_to' => $search, 'address' => $search, 'date' => $search]);
		$this->db->from('dr');
		return $this->db->count_all_results();
	}

	public function audit_trail($id, $name, $description, $type)
	{
		$data = array(
			'userId' => $id,
			'name' => $name,
			'description' => $description,
			'type' => $type
		);

		return $this->db->insert('audittrail', $data, TRUE);
	}

	public function get_audit_logs($date, $filter)
	{
		$this->db->like('date', $date, 'after');
		switch ($filter) {
			case 1:
				$this->db->where('type', 'Login');
				break;
			case 2:
				$this->db->where('type', 'Create MDR');
				break;
			default:
				# code...
				break;
		}
		$result = $this->db->get('audittrail');

		return $result->result();
	}

	public function get_description_by_number($number)
	{
		$this->db->select('remarks');
		$this->db->where('id', $number);
		$result = $this->db->get('dr');

		return $result->row();
	}

	public function lock_dr($number)
	{
		$this->db->where('id', $number);
		return $this->db->update('dr', ['is_viewed' => 1]);
	}
}