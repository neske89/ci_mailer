<?php

use app\application\entities\SentEmailEntity;

defined('BASEPATH') OR exit('No direct script access allowed');
//annotate for autocomplete
/**
 * Class Contact
 * @property General_Settings_model $General_Settings_model
 * @property Sent_Email_model $Sent_Email_model
 */
class Contact extends CI_Controller
{
    //email in sendgrid account
    CONST SENDER_EMAIL = 'nenadmilosavljevic89@gmail.com';

    /*** @var string */
    private $layout;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'layout/master';
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');

    }

    public function index()
    {
        $data['content'] = 'contact/contact';
        $this->load->model('General_Settings_model');
        $smtpSettings = $this->General_Settings_model->get_smtp_settings();

        $this->load->view($this->layout, $data);
    }

    public function send_email()
    {
        $this->load->library('form_validation');
        $this->load->model('General_Settings_model');
        $this->load->model('Sent_Email_model');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() != FALSE) {
            //send email here
            $recipient = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');

            $smtpSettings = $this->General_Settings_model->get_smtp_settings();
            //send email
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => $smtpSettings['smtp_host']->value,
                'smtp_port' => $smtpSettings['smtp_port']->value,
                'smtp_user' => $smtpSettings['smtp_username']->value,
                'smtp_pass' => $smtpSettings['smtp_password']->value,
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(self::SENDER_EMAIL);
            $this->email->to($recipient);
            $this->email->subject($subject);
            $this->email->message($message);
            $result = $this->email->send();
            try {
                if ($result) {
                    //ToDo:save success message to session and display it after redirect or use ajax form
                    //codeigniter 3.1.0 has some issues with sessions on php >= 7.2 so not done
                    $sentEmail = new SentEmailEntity($recipient,$subject,$message);
                    $this->Sent_Email_model->save_sent_email($sentEmail);
                    //redirect($this->uri->uri_string());
                } else {
                    echo $this->email->print_debugger();
                }
            } catch (Exception $e) {
                show_error($e->getMessage());
            }
        }
        $data['content'] = 'contact/contact';
        $this->load->view($this->layout, $data);
    }
}
