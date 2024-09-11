<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// openai_copy
require_once './vendor/autoload.php';
// openai_copy


include (APPPATH . 'controllers/MY_CONTROLLER/' . "Data_MY_Controller.php");
include (APPPATH . 'controllers/MY_CONTROLLER/' . "Lingual_MY_Controller.php");
include (APPPATH . 'controllers/MY_CONTROLLER/' . "Modules_MY_Controller.php");
include (APPPATH . 'controllers/MY_CONTROLLER/' . "Debug_MY_Controller.php");

class MY_Controller extends CI_Controller
    {
    // rest
    protected $documentRoot = "";
    public $language = NULL;
    protected $settings = NULL;
    public $is_mobile = NULL;
    public $is_ipad = NULL;

    // openai_copy
    public $open_ai_key = "";
    public $client = NULL;
    // openai_copy

    public $calledClassName;


    function __construct()
        {
        parent::__construct();
        //$this->checkIP();

        // timezone setting
        date_default_timezone_set('Europe/Vienna');
        $this->load->library('session');
        $this->detectDevice();
        $this->_setLang();
        $this->calledClassName = get_called_class();
        $this->load->model('entities/Content_model', 'cm');
        $this->load->model('Frontend_model', 'fm');
        $this->load->model('Backend_model', 'bm');
        $this->load->model('Openai_model', 'om');
        $this->load->model('Authentication_model');
        $this->load->model('Authentication_model', 'am');
        $this->load->helper('besc_helper');

        // openai_copy
        $this->open_ai_key = '<YOUR_OPENAI_API_KEY>';

        $this->client = OpenAI::client($this->open_ai_key);
        // openai_copy

        }

    use MY_Controller_Data;
    use MY_Controller_Debug;
    use MY_Controller_Lingual;


    /**********    LOGIN/CHECK FUNCTIONS ************/
    // logged_in - checks if user is logged in
    // _setLang - sets language based on cookie or default language
    // detectDevice - detects if user is on mobile or ipad
    // checkIP - checks if user is on allowed IP


    protected function logged_in()
        {
        return (bool) $this->session->userdata('user_id');
        }




    protected function detectDevice()
        {
        $this->is_ipad = $this->agent->is_mobile('ipad');

        if ($this->agent->is_mobile() && !$this->is_ipad)
            $this->is_mobile = true;
        else
            $this->is_mobile = false;
        }

    protected function checkIP()
        {
        $db = DB_NAME;
        $table = 'ip_list';
        $this->load->model('Authentication_model', 'am');
        $user_ip = $this->input->ip_address();

        $hdgo_list = array();
        for ($x = 0; $x < 256; $x++) {
            $item = "193.170.112." . $x;
            $hdgo_list[] = $item;

            $item = "193.170.113." . $x;
            $hdgo_list[] = $item;
            }

        for ($x = 1; $x < 127; $x++) {
            $item = "193.171.142." . $x;
            $hdgo_list[] = $item;
            }

        $checkIP = $this->am->checkIP($db, $table, $user_ip);

        if (!$checkIP && !in_array($user_ip, $hdgo_list)) {
            echo "Restricted!";
            exit;
            }
        }

    /**********     BILLS FUNCTIONS   ************/
    // sendBill - sends bill to client and user email


    public function sendBill($email, $user_email, $bill_id, $bill_id_pdf)
        {

        $bill = $this->em->getBillByID($bill_id)->row();
        $client = $this->em->getClientByID($bill->client_id)->row();

        $this->load->library('My_phpmailer');
        $mail = new PHPMailer();

        $mail->SMTPDebug = 1;
        $mail->CharSet = 'UTF-8';


        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPDebug = 0;  // prefix for secure protocol to connect to the server
        $mail->SMTPAuth = true; // enabled SMTP authentication
        $mail->SMTPSecure = false;  // prefix for secure protocol to connect to the server
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        $mail->Host = "";      // setting SMTP server
        $mail->Port = 25;                   // SMTP port to connect to
        $mail->Username = "";  // user email address
        $mail->Password = "";            // password

        $mail->SetFrom('');  //Who is sending the email
        $mail->AddReplyTo('');  //email address that receives the response
        // $mail->addBcc("istvan@treat.agency");

        $mail->Subject = "Rechnung - Bill No. " . $bill_id_pdf;

        $mail->AddAttachment($_SERVER["DOCUMENT_ROOT"] . '/billing_tool/items/uploads/pdfs/' . $bill_id_pdf . '.pdf', 'treat_Rechnung_' . $bill_id_pdf . '.pdf', 'base64', 'application/pdf');



        $response_data = array();
        $response_data['recipient'] = $client->name;
        $body = $this->load->view('mail/bill', $response_data, true);

        $mail->Body = $body;
        $mail->isHTML(true);



        $mail->AddAddress($email, '');
        $mail->AddAddress($user_email, '');
        if (!$mail->Send()) {
            echo "Error sending: " . $mail->ErrorInfo;
            } else {
            echo "Email geschickt!";
            }
        }




    }
