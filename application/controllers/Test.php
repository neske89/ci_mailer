<?php


use app\application\entities\GeneralSettingsEntity;
use app\application\entities\SentEmailEntity;

defined('BASEPATH') OR exit('No direct script access allowed');
//annotate for autocomplete
/**
 * Class Contact
 * @property General_Settings_model $General_Settings_model
 * @property Sent_Email_model $Sent_Email_model
 */
class Test extends CI_Controller
{
    public function __construct()
    {
        //To:Do Handle logic so that end user cannot run tests
        parent::__construct();
        $this->load->library('unit_test');
        $this->load->model('Sent_Email_model');
        $this->load->model('General_Settings_model');

    }

    public function index()
    {
        $this->testInsertGeneralSettings();
        $this->testDeleteGeneralSettings();
        $this->testBatchDeleteGeneralSettings();
     //   $this->testSendEmail();
        $this->testDeleteSentEmail();
        $this->testSaveSentEmail();
        echo $this->unit->report();
    }

    private function testInsertGeneralSettings() {
        $data = array(
                array( 'name'=>'smtp_host', 'value'=>'smtp.sendgrid.net'),
                array( 'name'=>'smtp_ssl', 'value'=>'465'),
                array( 'name'=>'smtp_port', 'value'=>'25'),
                array( 'name'=>'smtp_username', 'value'=>'apikey'),
                array( 'name'=>'smtp_password', 'value'=>'test_password'),
                array(  'name'=>'smtp_tls', 'value'=>'587'));
        $status = $this->General_Settings_model->insert_batch($data);
        $insertedData = $this->General_Settings_model->get_smtp_settings([],count($data),['created'=>'desc']);
        //data read from database will be in different ordert
        //format data as models as that's the result of get_smtp_settings
        $originalModels = [];
        foreach ($data as $row) {
            //store name as index for easier access when setting up SMTP
            $originalModels[$row['name']] = GeneralSettingsEntity::FromArray($row);
        }
        //save inserted rows to prepare for deletion
        $insertedIds = [];
        /** @var GeneralSettingsEntity $row */
        $comparisonSuccess = true;
        foreach ($insertedData as $rowKey => $row) {
            $originalDataMatch = $originalModels[$rowKey];
            $insertedIds[] = $row->id;
            $comparisonSuccess = $originalDataMatch->name ===$row->name && $comparisonSuccess;
            $comparisonSuccess = $originalDataMatch->value ===$row->value && $comparisonSuccess;
            //$this->unit->run($originalDataMatch->name,$row->name,$rowKey . '-name',sprintf('%s vs %s',$originalDataMatch->name,$row->name));
            //$this->unit->run($originalDataMatch->value,$row->value,$rowKey . '-value',sprintf('%s vs %s',$originalDataMatch->value,$row->value));
        }
        $this->unit->run($comparisonSuccess,true,'Global Settings Model insert batch','Test process: Insert some data, compare it to saved data into DB, delete test data.');
        //delete inserted dummy records
        $status = $this->General_Settings_model->delete_batch($insertedIds);
    }

    private function  testDeleteGeneralSettings() {
        $data = array(array( 'name'=>'smtp_host', 'value'=>'smtp.sendgrid.net'));
        $this->General_Settings_model->insert_batch($data);
        $insertedData = $this->General_Settings_model->get_smtp_settings([],count($data),['created'=>'desc']);
        $insertedId = reset($insertedData)->id;
        $deleted = $this->General_Settings_model->delete($insertedId);
        $deletedData = $this->General_Settings_model->get_smtp_settings(['id'=>$insertedId]);
        //confirm that return value and result of the action are proper
        $this->unit->run($deleted && empty($deletedData),true,'Global Settings Model delete','Test process: Insert single data, delete it from db, check if data with inserted ID exists in db.');

    }
    private function  testBatchDeleteGeneralSettings() {
        $data = array(
            array( 'name'=>'smtp_host', 'value'=>'smtp.sendgrid.net'),
            array( 'name'=>'smtp_ssl', 'value'=>'465'));
        $this->General_Settings_model->insert_batch($data);
        $insertedData = $this->General_Settings_model->get_smtp_settings([],count($data),['created'=>'desc']);
        $insertedIds = [];
        foreach ($insertedData as $data) {
            $insertedIds[] = $data->id;
        }
        $deleted = $this->General_Settings_model->delete_batch($insertedIds);
        $deletedData = $this->General_Settings_model->get_smtp_settings(['id'=>$insertedIds]);
        //confirm that return value and result of the action are proper
        $this->unit->run($deleted && empty($deletedData),true,'Global Settings Model delete_batch','Test process: Insert multiple data, delete it from db, check if data with inserted ID exists in db.');
    }

    private function testDeleteSentEmail() {
        $_POST['email'] = 'mail@nenadmilosavljevic.com';
        $_POST['subject'] = 'Codeigniter trackstreet test';
        $_POST['message'] = 'This is the test email';
        $recipient = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $sentEmail = new SentEmailEntity($recipient,$subject,$message);
        $result = $this->Sent_Email_model->save_sent_email($sentEmail);
        $emailInDB = $this->Sent_Email_model->get_sent_emails([],1,['created'=>'desc']);
        $deleted = $this->Sent_Email_model->delete_sent_email($emailInDB[0]->id);
        $deletedRecord = $this->Sent_Email_model->get_sent_emails(['id'=>$emailInDB[0]->id]);
        $this->unit->run($deleted && empty($deletedRecord),true,'Sent_Email_model delete','Test process: Insert single data, delete it from db, check if data with inserted ID exists in db.');


    }

    private function testSaveSentEmail() {

        $_POST['email'] = 'mail@nenadmilosavljevic.com';
        $_POST['subject'] = 'Codeigniter trackstreet test';
        $_POST['message'] = 'This is the test email';
        $recipient = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $sentEmail = new SentEmailEntity($recipient,$subject,$message);
        $result = $this->Sent_Email_model->save_sent_email($sentEmail);
        $emailInDB = $this->Sent_Email_model->get_sent_emails([],1,['created'=>'desc']);
        $comparisonSuccess = true;
        $id = false;
        if (empty($emailInDB)) {
            $comparisonSuccess = false;
        }
        else {
            $comparisonSuccess = $recipient === $emailInDB[0]->to_email && $comparisonSuccess;
            $comparisonSuccess = $subject === $emailInDB[0]->subject && $comparisonSuccess;
            $comparisonSuccess = $message === $emailInDB[0]->body && $comparisonSuccess;
            $id = $emailInDB[0]->id;
        }
        $emailInDB = $this->Sent_Email_model->delete_sent_email($id);
        $this->unit->run($comparisonSuccess,true,'Saving email test','Test process: save email in db, fetch latest record and compare properties, remove fetched record');
    }

    private function testSendEmail() {
        $_POST['email'] = 'mail@nenadmilosavljevic.com';
        $_POST['subject'] = 'Codeigniter trackstreet test';
        $_POST['message'] = 'This is the test email';

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
        $this->email->from('nenadmilosavljevic89@gmail.com');
        $this->email->to($recipient);
        $this->email->subject($subject);
        $this->email->message($message);
        $result = $this->email->send();
        $this->unit->run($result,true,'Sending email test','Test process: read smtp settings from db, send mock email.');
    }
}
