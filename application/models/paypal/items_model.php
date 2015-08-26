<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Items_model extends CI_Model {
 
function Items_model() {
	parent::__construct();
}


function show_prices($id) {

	$this->db->select('*');
	$this->db->where('subType', $id);
	$query = $this->db->get('pp_items');
	
	if($query->num_rows() >0)
	{
		return $query->row();
	}
}
		
		
function get_all() {
	return $this->db->get( 'pp_items' )->result();
}


function get( $id ) {
	$r = $this->db->where( 'id', $id )->get( 'pp_items' )->result();
	if ( $r ) return $r[0];
	return false;
}


function setup_payment( $item_id, $email, $key ) {
	$data = array(
		'item_id'  => $item_id,
		'key_code'      => $key,
		'email'    => $email,
		'active'   => 0 // hasn't been purchased yet
	);
	$this->db->insert( 'pp_purchases', $data );
}


function confirm_payment( $key, $paypal_email, $txn_id ) 
{
	$data = array(
		'purchased_at'  => time(),
		'active'        => 1,
		'paypal_email'  => $paypal_email,
		'paypal_txn_id' => $txn_id
	);
	$this->db->where( 'key_code', $key );
	$this->db->update( 'pp_purchases', $data );
}

 
function get_purchase_by_key( $key )
{
	$r = $this->db->where( 'key_code', $key )->get( 'pp_purchases' )->result();
	if ( $r ) return $r[0];
	return false;
}


function log_download( $item_id, $purchase_id, $ip_address, $user_agent ) {
	$data = array(
		'item_id'      => $item_id,
		'purchase_id'  => $purchase_id,
		'download_at'  => time(),
		'ip_address'   => $ip_address,
		'user_agent'   => $user_agent
	);
	$this->db->insert( 'pp_downloads', $data );
}


function get_purchase_downloads( $purchase_id, $limit ) {
	return $this->db->where( 'purchase_id', $purchase_id )->limit( $limit )->order_by( 'id', 'desc' )->get( 'pp_downloads' )->result();
}
 

} // ENDS class Items_model