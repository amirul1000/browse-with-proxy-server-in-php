<?php

 /**
 * Author: Amirul Momenin
 * Desc:Proxy Controller
 *
 */
class Proxy extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Proxy_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of proxy table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['proxy'] = $this->Proxy_model->get_limit_proxy($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/proxy/index');
		$config['total_rows'] = $this->Proxy_model->get_count_proxy();
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
		
        $data['_view'] = 'admin/proxy/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save proxy
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		$created_at = "";
$updated_at = "";

		if($id<=0){
															 $created_at = date("Y-m-d H:i:s");
														 }
else if($id>0){
															 $updated_at = date("Y-m-d H:i:s");
														 }

		$params = array(
					 'server_name' => html_escape($this->input->post('server_name')),
'location' => html_escape($this->input->post('location')),
'ip' => html_escape($this->input->post('ip')),
'port' => html_escape($this->input->post('port')),
'username' => html_escape($this->input->post('username')),
'password' => html_escape($this->input->post('password')),
'price' => html_escape($this->input->post('price')),
'created_at' =>$created_at,
'updated_at' =>$updated_at,

				);
		 
		if($id>0){
							                        unset($params['created_at']);
						                          }if($id<=0){
							                        unset($params['updated_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['proxy'] = $this->Proxy_model->get_proxy($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Proxy_model->update_proxy($id,$params);
				$this->session->set_flashdata('msg','Proxy has been updated successfully');
                redirect('admin/proxy/index');
            }else{
                $data['_view'] = 'admin/proxy/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $proxy_id = $this->Proxy_model->add_proxy($params);
				$this->session->set_flashdata('msg','Proxy has been saved successfully');
                redirect('admin/proxy/index');
            }else{  
			    $data['proxy'] = $this->Proxy_model->get_proxy(0);
                $data['_view'] = 'admin/proxy/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details proxy
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['proxy'] = $this->Proxy_model->get_proxy($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/proxy/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting proxy
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $proxy = $this->Proxy_model->get_proxy($id);

        // check if the proxy exists before trying to delete it
        if(isset($proxy['id'])){
            $this->Proxy_model->delete_proxy($id);
			$this->session->set_flashdata('msg','Proxy has been deleted successfully');
            redirect('admin/proxy/index');
        }
        else
            show_error('The proxy you are trying to delete does not exist.');
    }
	
	/**
     * Search proxy
	 * @param $start - Starting of proxy table's index to get query
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
$this->db->or_like('server_name', $key, 'both');
$this->db->or_like('location', $key, 'both');
$this->db->or_like('ip', $key, 'both');
$this->db->or_like('port', $key, 'both');
$this->db->or_like('username', $key, 'both');
$this->db->or_like('password', $key, 'both');
$this->db->or_like('price', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['proxy'] = $this->db->get('proxy')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/proxy/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('server_name', $key, 'both');
$this->db->or_like('location', $key, 'both');
$this->db->or_like('ip', $key, 'both');
$this->db->or_like('port', $key, 'both');
$this->db->or_like('username', $key, 'both');
$this->db->or_like('password', $key, 'both');
$this->db->or_like('price', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("proxy")->count_all_results();
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
		$data['_view'] = 'admin/proxy/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export proxy
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'proxy_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $proxyData = $this->Proxy_model->get_all_proxy();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Server Name","Location","Ip","Port","Username","Password","Price","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($proxyData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $proxy = $this->db->get('proxy')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/proxy/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Proxy controller