<?php

class Shop_model extends CI_Model  
{
    function insertCustomerRegistration($data)
    {
        $this->db->insert('s_customers', $data);
        return $this->db->insert_id();
    }
    
    function getCustomerByToken($code)
    {
        $this->db->where('confirmation_token', $code);
        $result = $this->db->get('s_customers');
        return ($result->num_rows() >0)? $result->row() : false;
    }
    
    function getUserByEmail($email)
    {
        $this->db->where('email', $email);
        $result = $this->db->get('s_customers');
        return ($result->num_rows() >0)? $result->row() : false;
    }
    
    function updateCustomer($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('s_customers', $data);
    }
    
    
	function getVoucher($code)
	{
		$this->db->where('code', $code);
		$result = $this->db->get('s_vouchers');
		return ($result->num_rows() >0)? $result->row() : false;
	}
	
	
	function getCountryByID($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('country');
		return ($result->num_rows() >0)? $result->row() : false;
	}
	
	function getShopItemById($id)
	{
		$this->db->select('s_products.*, s_taxes.tax_percent as tax');
		$this->db->join('s_taxes', ' s_taxes.id = s_products.tax_id');
		$this->db->where('s_products.id', $id);
		$result = $this->db->get('s_products');
		return ($result->num_rows() >0)? $result->row() : false;
	}
	
	function insertShopOrder($data)
	{
		$this->db->insert('s_orders', $data);
		return $this->db->insert_id();
	}
	
	function insertShopOrderItems($data)
	{
		$this->db->insert('s_ordered_items', $data);
	}
	
	function updateOrderStatus($orderId, $data)
	{
		$this->db->where('id', $orderId);
		$this->db->update('s_orders', $data);
	}
	
	function getLatestInvoicenumber()
	{
		$this->db->select_max('bill_id');
		return $this->db->get('s_orders');
	}
	
	function getLatestInvoicenumberYearly($order_date)
	{	
		$this->db->where("YEAR(order_date)", $order_date);
		$this->db->order_by('yearly_bill_id', 'desc');
		$this->db->limit(1);
		$result = $this->db->get('s_orders');
		return ($result->num_rows() > 0)? $result->row()->yearly_bill_id : 0; 
	}
	
	
	function getOrderByID($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('s_orders');
		return ($result->num_rows() >0)? $result->row() : false;
	}
	
	
	function getOrderItemsByID($id)
	{
		$this->db->select('s_ordered_items.*, shop_items.is_ticket as is_ticket');
		$this->db->join('shop_items', 'shop_items.id = s_ordered_items.item_id');
		$this->db->where('s_ordered_items.order_id', $id);
		$result = $this->db->get('s_ordered_items');
		return ($result->num_rows() >0)? $result->result() : array();
	}
	
	function getOrderItemsByIDAndItem($id, $item_id)
	{
		$this->db->select('s_ordered_items.*, shop_items.is_ticket as is_ticket');
		$this->db->join('shop_items', 'shop_items.id = s_ordered_items.item_id');
		$this->db->where('s_ordered_items.order_id', $id);
		$this->db->where('s_ordered_items.item_id', $item_id);
		$result = $this->db->get('s_ordered_items');
		return ($result->num_rows() >0)? $result->result() : array();
	}
	
}
