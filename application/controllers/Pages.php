<?php
/**
 * Created by PhpStorm.
 * User: putra.liowono
 * Date: 8/29/2016
 * Time: 2:22 PM
 */
    class Pages extends CI_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
        }

        public function index()
        {
            $this->load->view('ecoupon/'.'index'.'.html');
        }

        public function view()
        {
            $page = $this->uri->segment(1);
            if ( ! file_exists(APPPATH.'views/ecoupon/'.$page.'.html'))
            {
                show_404();
            }
            $this->load->view('ecoupon/'.$page.'.html');
        }
    }

?>