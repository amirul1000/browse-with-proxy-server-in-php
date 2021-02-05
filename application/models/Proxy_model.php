<?php

/**
 * Author: Amirul Momenin
 * Desc:Proxy Model
 */
class Proxy_model extends CI_Model
{
	protected $proxy = 'proxy';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get proxy by id
	 *@param $id - primary key to get record
	 *
     */
    function get_proxy($id){
        $result = $this->db->get_where('proxy',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('proxy');
			foreach ($fields as $field)
			{
			   $result[$field] = ''; 	  
			}
		}
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all proxy
	 *
     */
    function get_all_proxy(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('proxy')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit proxy
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_proxy($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('proxy')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count proxy rows
	 *
     */
	function get_count_proxy(){
       $result = $this->db->from("proxy")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-proxy
	 *
     */
    function get_all_users_proxy(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('proxy')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-proxy
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_proxy($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('proxy')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-proxy rows
	 *
     */
	function get_count_users_proxy(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("proxy")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new proxy
	 *@param $params - data set to add record
	 *
     */
    function add_proxy($params){
        $this->db->insert('proxy',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update proxy
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_proxy($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('proxy',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete proxy
	 *@param $id - primary key to delete record
	 *
     */
    function delete_proxy($id){
        $status = $this->db->delete('proxy',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
