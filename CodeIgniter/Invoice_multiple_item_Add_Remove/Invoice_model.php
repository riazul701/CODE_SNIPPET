<?php 
	class Invoice_model extends CI_Model {
	var $table='invoice';
	var $table1='customer';
	var $table2='service';
	var $table3='invoice_items';
	var $table4='payment';

	public function invoiceid()
	{
		$this->db->select_max('invoice_id');
		$this->db->from($this->table);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	public function customer_invoice()
	{
		$this->db->select('*');
		$this->db->from($this->table1);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function service_invoice()
	{
		$this->db->select('*');
		$this->db->from($this->table2);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function servicefield_invoice($id)
	{
		$this->db->select('*');
		$this->db->where('service_id', $id);
		$this->db->from($this->table2);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	public function companyname_ajax($id)
	{
		$this->db->select('*');
		$this->db->where('customer_id', $id);
		$this->db->from($this->table1);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	public function insertinvoice($data)
	{
		return $this->db->insert($this->table, $data);
		 //$this->db->insert_id();
	}
	public function insert_invoice_items($data)
	{
		return $this->db->insert($this->table3, $data);
	}
        public function payment($data)
	{
		return $this->db->insert($this->table4, $data);
	}
	public function invoice_display()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by("invoice_id","desc");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	public function paymentdisplay()
	{
		$this->db->select('*');
		$this->db->from($this->table4);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function customerfield_invoice($id)
	{
		$this->db->select('*');
		$this->db->where('customer_id', $id);
		$this->db->from($this->table1);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function invoice_delete($id)
    {
		$this->db->where('invoice_id', $id);
		$this->db->delete($this->table);
	}

	function invoice_update_display($id)
    {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('invoice_id', $id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
function payment_update_display($id)
    {
		$this->db->select('*');
		$this->db->from($this->table4);
		$this->db->where('invoice_id', $id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function service_update($id,$data)
    {
		$this->db->where('service_id', $id);
		return $this->db->update($this->table,$data);
	}

	function invoice_items_update_display($id)
    {
		$this->db->select('*');
		$this->db->from($this->table3);
		$this->db->where('invoice_id', $id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function servicefield_invoice_update($id)
	{
		$this->db->select('*');
		$this->db->where('service_id', $id);
		$this->db->from($this->table2);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function invoice_items_delete($id)
    {
		$this->db->where('invoice_item_id', $id);
		$this->db->delete($this->table3);
	}
	function invoice_update($id,$data)
    {
		$this->db->where('invoice_id', $id);
		return $this->db->update($this->table,$data);
	}
	
	public function customeridinvoice($id)
	{
		$this->db->select('customer_id');
		$this->db->from($this->table);
		$this->db->where('invoice_id', $id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	public function customeremailinvoice($id)
	{
		$this->db->select('customer_email');
		$this->db->from($this->table1);
		$this->db->where('customer_id', $id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	public function invoicenumber($id)
	{
		$this->db->select('invoice_number');
		$this->db->from($this->table);
		$this->db->where('invoice_id', $id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
        public function datesearch($from,$to)
	{
		$this->db->select('*');
		$this->db->from('invoice');
		$this->db->where('issue_date <=',$to);
		$this->db->where('issue_date >=',$from);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function invoice_payment_delete($id)
	{
		$this->db->where('payment_id', $id);
		$this->db->delete($this->table4);
	}

	public function withinvoice_payment_delete($id)
	{
		$this->db->where('invoice_id', $id);
		$this->db->delete($this->table4);
	}
	public function invoice_individual_customer($id,$inid)
	{
		$this->db->select('*');
		$this->db->where('customer_id', $id);
		$this->db->where('invoice_id', $inid);
		$this->db->from($this->table);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	public function all_payment()
	{
		$this->db->select('*');
		$this->db->from($this->table4);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function date_wise_all_payment($from,$to)
	{
		$this->db->select('*');
		$this->db->from($this->table4);
		$this->db->where('payment_date <=',$to);
		$this->db->where('payment_date >=',$from);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}