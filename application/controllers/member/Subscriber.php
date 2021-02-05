<?php

/**
 * Author: Amirul Momenin
 * Desc:Subscriber Controller
 *
 */
class Subscriber extends CI_Controller
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
            'url'
        ));
        $this->load->database();
        $this->load->model('Subscriber_model');
        if (! $this->session->userdata('validated')) {
            redirect('member/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of subscriber table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['subscriber'] = $this->Subscriber_model->get_limit_users_subscriber($limit, $start);
        // pagination
        $config['base_url'] = site_url('member/subscriber/index');
        $config['total_rows'] = $this->Subscriber_model->get_count_users_subscriber();
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['_view'] = 'member/subscriber/index';
        $this->load->view('layouts/member/body', $data);
    }

    /**
     * Save subscriber
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

        $params = array(
            'subscription_item_id' => html_escape($this->input->post('subscription_item_id')),
            'subscriber_users_id' => html_escape($this->input->post('subscriber_users_id')),
            'start_date' => html_escape($this->input->post('start_date')),
            'end_date' => html_escape($this->input->post('end_date')),
            'transactionid' => html_escape($this->input->post('transactionid')),
            'paid_amount' => html_escape($this->input->post('paid_amount')),
            'status' => html_escape($this->input->post('status')),
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );

        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['subscriber'] = $this->Subscriber_model->get_subscriber($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Subscriber_model->update_subscriber($id, $params);
                $this->session->set_flashdata('msg', 'Subscriber has been updated successfully');
                redirect('member/subscriber/index');
            } else {
                $data['_view'] = 'member/subscriber/form';
                $this->load->view('layouts/member/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $subscriber_id = $this->Subscriber_model->add_subscriber($params);
                $this->session->set_flashdata('msg', 'Subscriber has been saved successfully');
                redirect('member/subscriber/index');
            } else {
                $data['subscriber'] = $this->Subscriber_model->get_subscriber(0);
                $data['_view'] = 'member/subscriber/form';
                $this->load->view('layouts/member/body', $data);
            }
        }
    }

    /**
     * Details subscriber
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['subscriber'] = $this->Subscriber_model->get_subscriber($id);
        $data['id'] = $id;
        $data['_view'] = 'member/subscriber/details';
        $this->load->view('layouts/member/body', $data);
    }

    /**
     * Deleting subscriber
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $subscriber = $this->Subscriber_model->get_subscriber($id);

        // check if the subscriber exists before trying to delete it
        if (isset($subscriber['id'])) {
            $this->Subscriber_model->delete_subscriber($id);
            $this->session->set_flashdata('msg', 'Subscriber has been deleted successfully');
            redirect('member/subscriber/index');
        } else
            show_error('The subscriber you are trying to delete does not exist.');
    }

    /**
     * Search subscriber
     *
     * @param $start -
     *            Starting of subscriber table's index to get query
     */
    function search($start = 0)
    {
        if (! empty($this->input->post('key'))) {
            $key = $this->input->post('key');
            $_SESSION['key'] = $key;
        } else {
            $key = $_SESSION['key'];
        }

        $limit = 10;
        $this->db->like('id', $key, 'both');
        $this->db->or_like('subscription_item_id', $key, 'both');
        $this->db->or_like('subscriber_users_id', $key, 'both');
        $this->db->or_like('start_date', $key, 'both');
        $this->db->or_like('end_date', $key, 'both');
        $this->db->or_like('transactionid', $key, 'both');
        $this->db->or_like('paid_amount', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['subscriber'] = $this->db->get('subscriber')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('member/subscriber/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('subscription_item_id', $key, 'both');
        $this->db->or_like('subscriber_users_id', $key, 'both');
        $this->db->or_like('start_date', $key, 'both');
        $this->db->or_like('end_date', $key, 'both');
        $this->db->or_like('transactionid', $key, 'both');
        $this->db->or_like('paid_amount', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $config['total_rows'] = $this->db->from("subscriber")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['key'] = $key;
        $data['_view'] = 'member/subscriber/index';
        $this->load->view('layouts/member/body', $data);
    }

    /**
     * Export subscriber
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'subscriber_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $this->db->order_by('id', 'desc');
            $subscriberData = $this->Subscriber_model->get_all_users_subscriber();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Subscription Item Id",
                "Subscriber Users Id",
                "Start Date",
                "End Date",
                "Transactionid",
                "Paid Amount",
                "Status",
                "Created At",
                "Updated At"
            );
            fputcsv($file, $header);
            foreach ($subscriberData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $this->db->order_by('id', 'desc');
            $subscriber = $this->db->get('subscriber')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/member/subscriber/print_template.php');
            $html = ob_get_clean();
            require_once FCPATH . 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            exit();
        }
    }
}
//End of Subscriber controller