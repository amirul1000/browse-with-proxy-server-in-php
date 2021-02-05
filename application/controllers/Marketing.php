<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author: Amirul Momenin
 * Desc:Landing Page
 */
class Marketing extends CI_Controller
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
        $result = $this->db->get_where('content', array(
            'content_title' => 'marketing'
        ))->row_array();
        if (! (array) $result) {
            $fields = $this->db->list_fields('content');
            foreach ($fields as $field) {
                $result[$field] = '';
            }
        }
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $data['marketing_content'] = $result['description'];

        $data['_view'] = 'front/marketing/index';
        $this->load->view('layouts/front/body', $data);
    }
}