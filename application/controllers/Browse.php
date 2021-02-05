<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author: Amirul Momenin
 * Desc:Landing Page
 */
class Browse extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url',
            'captcha'
        ));
        $this->load->database();
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of About_us table's index to get query
     *            
     */
    function index($start = 0)
    {
		if (! $this->session->userdata('validated')) {
            redirect('member/login/index');
        }
		if (! empty($this->input->get('key'))) {
            $key = $this->input->get('key');
            $_SESSION['key'] = $key;
        } else {
            $key = $_SESSION['key'];
        }
		$output = '';
     
		   $output = $this->get_proxy_content($key);
		   $data['output'] = $this->replace_links($output,$key);
		$data['key'] = $key;	
        $data['_view'] = 'front/browse/index';
        $this->load->view('layouts/front/body', $data);
    }
	
	function get_proxy_content($key){
		  //The URL you want to send a cURL proxy request to.
			$url = $key;
			
			$this->db->order_by('id', 'desc');
			$result = $this->db->get('proxy')->result_array();
			$db_error = $this->db->error();
			if (!empty($db_error['code'])){
				echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
				exit;
			}
			//The IP address of the proxy you want to send
			//your request through.
			$proxyIP = trim($result[0]['ip']);
			
			//The port that the proxy is listening on.
			$proxyPort = $result[0]['port'];
			
			//The username for authenticating with the proxy.
			$proxyUsername = $result[0]['username'];
			
			//The password for authenticating with the proxy.
			$proxyPassword = $result[0]['password'];
			
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
			
			//Set the proxy IP.
			curl_setopt($ch, CURLOPT_PROXY, $proxyIP);
			
			//Set the port.
			curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
			
			//Specify the username and password.
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$proxyUsername:$proxyPassword");
			
			//Execute the request.
			$output = curl_exec($ch);
			
			//Check for errors.
			if(curl_errno($ch)){
				throw new Exception(curl_error($ch));
			}
			
			//Print the output.
		
			return $output;
	}
  
  function replace_links($contents,$key){
	  $this->load->library('Scrapper');
	  $tag ='';
	  //href
	  $arr = $this->scrapper->getLinks($contents,$tag);
	  for($i=0;$i<count($arr);$i++){
		  if($this->is_absolute($arr[$i])){
			  $new_link = site_url('browse').'/?key='.$arr[$i];
		  $contents = str_replace($arr[$i],site_url('browse').'/?key='.$arr[$i],$contents);
		  }
		  else{
			  $url = parse_url($key, PHP_URL_HOST);
			  $new_link = site_url('browse').'/?key='.$url.$arr[$i];
			  $contents = str_replace($arr[$i],$new_link,$contents);
		  }
	  }
	  
	  //img
	  $arr = $this->scrapper->getPhotosLinks($contents,$tag);
	  for($i=0;$i<count($arr);$i++){
		  if(!$this->is_absolute($arr[$i])){
			  $url = parse_url($key, PHP_URL_HOST);
			  $new_link = $url.'/'.$arr[$i];
			  $contents = str_replace($arr[$i],$new_link,$contents);
		  }
	  }
	  //css 
	  $arr = $this->scrapper->getScriptLinksByTagAttributes($contents,'link');
	  for($i=0;$i<count($arr);$i++){
		  if(!$this->is_absolute($arr[$i])){
			  $url = parse_url($key, PHP_URL_HOST);
			  $new_link = $url.'/'.$arr[$i];
			  $contents = str_replace($arr[$i],$new_link,$contents);
		  }
	  }
	  
	  //script 
	  $arr = $this->scrapper->getScriptLinksByTagAttributes($contents,'script');
	  for($i=0;$i<count($arr);$i++){
		  if(!$this->is_absolute($arr[$i])){
			  $url = parse_url($key, PHP_URL_HOST);
			  $new_link = $url.'/'.$arr[$i];
			  $contents = str_replace($arr[$i],$new_link,$contents);
		  }
	  }
	  
	  return $contents;
  }
  public function is_absolute($url)
	{
		$pattern = "/^(?:ftp|https?|feed):\/\/(?:(?:(?:[\w\.\-\+!$&'\(\)*\+,;=]|%[0-9a-f]{2})+:)*
		(?:[\w\.\-\+%!$&'\(\)*\+,;=]|%[0-9a-f]{2})+@)?(?:
		(?:[a-z0-9\-\.]|%[0-9a-f]{2})+|(?:\[(?:[0-9a-f]{0,4}:)*(?:[0-9a-f]{0,4})\]))(?::[0-9]+)?(?:[\/|\?]
		(?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})*)?$/xi";
	
		return (bool) preg_match($pattern, $url);
	}
}