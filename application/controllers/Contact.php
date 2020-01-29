<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller
{
    /*** @var string */
    private $layout;

    /**
     * Migrate constructor.
     * @param string $layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'layout/master';
    }


    public function index()
    {
        $this->load->helper('form');
        $data['content'] = 'contact/contact';
        $this->load->view($this->layout, $data);
    }

    public function send_email()
    {

        $this->load->library('form_validation');
        $this->load->model('General_Settings_model');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() != FALSE)
        {
            //send email here
            $recipient = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');

            $smtpSettings = $this->General_Settings_model->get_smtp_settings();

        }
        $data['content'] = 'contact/contact';
        $this->load->view($this->layout, $data);
    }
}
