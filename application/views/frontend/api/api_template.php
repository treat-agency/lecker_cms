 <?

 <?php
defined('BASEPATH') or exit('No direct script access allowed');

class API extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Api_model', 'apim');

        $this->load->helper('besc_helper');
        $this->load->helper('handling_date');

        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->api_url = 'https://web';
    }


 protected function getToken()
    {


        $user = 'user';
        $pw = 'pw';
        $postData = array('email' => $user, 'password' => $pw);
        $url = $this->api_url.'api/customer/login?token=true';
        // Setup cURL
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'User-Agent: ',
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        // Send the request
        $response = curl_exec($ch);

        $json = json_decode($response);




        return $json->token;


    }

}