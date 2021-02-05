<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author: Amirul Momenin
 * Desc:Landing Page
 */
class Pricing extends CI_Controller
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
            'content_title' => 'pricing'
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
        $data['pricing_content'] = $result['description'];

        $this->load->database();
        $this->db->where('status', 'active');
        $result = $this->db->get('subscription_item')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $data['subscription_item'] = $result;

        $data['_view'] = 'front/pricing/index';
        $this->load->view('layouts/front/body', $data);
    }

    function success()
    {
        $data['_view'] = 'front/pricing/success';
        $this->load->view('layouts/front/body', $data);
    }

    function notify()
    {
        $str = "";
        foreach ($_REQUEST as $key => $value) {
            $str .= "& $key => $value";
        }
        $fp = fopen('paypal.txt', 'w');
        fwrite($fp, $str);
        fclose($fp);
        if ($_REQUEST['payment_status'] == 'Completed') {
            /*
             * $subscriber_users_id = $this->session->userdata('id');
             * if (empty($subscriber_users_id)) {
             * $this->load->helper('cookie');
             * $subscriber_users_id = $this->input->cookie('users_id', TRUE);
             * }
             * else{
             */
            $subscriber_users_id = $_REQUEST['option_name2_1'];
            // }

            $this->load->model('Subscriber_model');
            $this->load->model('Subscription_item_model');

            $item = $this->Subscription_item_model->get_subscription_item($_REQUEST['item_number1']);
            $days_for = $item['days_for'];
            $Date = date("Y-m-d");
            $params = array(
                'subscription_item_id' => $_REQUEST['item_number1'],
                'subscriber_users_id' => $subscriber_users_id,
                'start_date' => date("Y-m-d"),
                'end_date' => date('Y-m-d', strtotime($Date . ' + ' . $days_for . ' days')),
                'transactionid' => $_REQUEST['txn_id'],
                'paid_amount' => $_REQUEST['mc_gross'],
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s")
            );
            $this->Subscriber_model->add_subscriber($params);
        }

        $this->load->library('email');
        $this->email->from('abc1@gmail.com', 'Digital Marketplace');
        $this->email->to('abc2@gmail.com');
        // $this->email->cc('another@another-example.com');
        // $this->email->bcc('them@their-example.com');

        $this->email->subject('NeoCart item has been sold');
        $this->email->message($str);

        $this->email->send();

        // $cost = $_REQUEST['mc_gross'];
        // $id = $_REQUEST['item_number1'];
    }
}