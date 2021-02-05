<?php

 /**
 * Author: Amirul Momenin
 * Desc:Location Controller
 *
 */
class Location extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Location_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of location table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['location'] = $this->Location_model->get_limit_location($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/location/index');
		$config['total_rows'] = $this->Location_model->get_count_location();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/location/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save location
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'contry' => html_escape($this->input->post('contry')),
'state' => html_escape($this->input->post('state')),
'city' => html_escape($this->input->post('city')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['location'] = $this->Location_model->get_location($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Location_model->update_location($id,$params);
				$this->session->set_flashdata('msg','Location has been updated successfully');
                redirect('admin/location/index');
            }else{
                $data['_view'] = 'admin/location/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $location_id = $this->Location_model->add_location($params);
				$this->session->set_flashdata('msg','Location has been saved successfully');
                redirect('admin/location/index');
            }else{  
			    $data['location'] = $this->Location_model->get_location(0);
                $data['_view'] = 'admin/location/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details location
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['location'] = $this->Location_model->get_location($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/location/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting location
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $location = $this->Location_model->get_location($id);

        // check if the location exists before trying to delete it
        if(isset($location['id'])){
            $this->Location_model->delete_location($id);
			$this->session->set_flashdata('msg','Location has been deleted successfully');
            redirect('admin/location/index');
        }
        else
            show_error('The location you are trying to delete does not exist.');
    }
	
	/**
     * Search location
	 * @param $start - Starting of location table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('contry', $key, 'both');
$this->db->or_like('state', $key, 'both');
$this->db->or_like('city', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['location'] = $this->db->get('location')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/location/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('contry', $key, 'both');
$this->db->or_like('state', $key, 'both');
$this->db->or_like('city', $key, 'both');

		$config['total_rows'] = $this->db->from("location")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/location/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export location
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'location_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $locationData = $this->Location_model->get_all_location();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Contry","State","City"); 
		   fputcsv($file, $header);
		   foreach ($locationData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $location = $this->db->get('location')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/location/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Location controller