<?php

// error_reporting(E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authentication extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Authentication_model', 'am');
        $this->user = Authentication::getUser();
    }


    static function getUser()
    {
        $ci = &get_instance();
        $ci->load->model('Authentication_model', 'am');
        if ($ci->session->userdata('user_id') != null) {
            return $ci->am->getUserdataByID($ci->session->userdata('user_id'))->row();
        } else {
            return null;
        }
    }






    public function showLogin($errormessage = '')
    {
        $data = array();
        $data['errormessage'] = $errormessage;
        $data['username'] = Authentication::getUser() != null ? Authentication::getUser()->username : null;
        $data['previous_url'] = isset($_GET['previous_url']) ? $_GET['previous_url'] : false;




        //$this->load->view('backend/head', $data);
        //$this->load->view('backend/menu', $data);
        $this->load->view('authentication/login', $data);
        // $this->load->view('backend/footer', $data);

    }

    public function checkLogin()
    {
        if ($this->logged_in()) {
            $result = array(
                'success' => true,
                'message' => 'logged_id',
                'menu' => $this->lang->line('header_menu_logout')
            );
        } else {
            $result = array(
                'success' => false,
                'message' => 'not_logged_in',
                'menu' => $this->lang->line('header_menu_login')
            );
        }
        echo json_encode($result);
    }

    public function loginUser()
    {
        $username = purify($_POST['username']);
        $pword = purify($_POST['pword']);

        if ($this->am->getPW($username)->num_rows() > 0) {

            $pwcheck = check_hash($pword, $this->am->getPW($username)->row()->pword);
            if ($pwcheck) {

                $userId = $this->am->getUserdataByUsername($username)->row()->id;
                $this->session->set_userdata('user_id', $userId);

                $previous_url = (isset($_GET['previous_url']) ? $_GET['previous_url'] : false);

                if($previous_url != '' && $previous_url != null && $previous_url != false ){
                    $previous_url = str_replace(site_url(), '', $previous_url);
                    redirect($previous_url);
                } else {
                    redirect('backend');
                }

            } else {
                $data['errormessage'] = "Password incorrect";
                $this->showLogin('Password incorrect');
            }
        } else {
            $data['errormessage'] = "User not found";
            $this->showLogin('User not found');
        }
    }

    public function resetPwTest(){
        $user = $this->am->getUser('lukas@treat.agency');

        // var_dump($user);

    }

    // public function resetPw()
    // {
    //     $email = purify($_POST['email']);

    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         // invalid emailaddress
    //         $this->showLogin('Not valid email address!');
    //     } else {
    //         $user = $this->am->getUser($email);
    //         if ($user) {
    //             require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
    //             $mail = new PHPMailer();
    //             $mail->CharSet = 'UTF-8';
    //             $mail->Host = "wp1179835.mailout.server-he.de";      // setting SMTP server
    //             $mail->Port = 587;                   // SMTP port to connect to
    //             $mail->SMTPSecure = 'tls';  // prefix for secure protocol to connect to the server
    //             $mail->SMTPAuth = true; // enabled SMTP authentication
    //             $mail->Username = "wp1179835-noreply";  // user email address
    //             $mail->Password = "Kknoreply";            // password

    //             $mail->SetFrom('noreply@salzburger-kunstverein.at');  //Who is sending the email
    //             $mail->AddReplyTo('noreply@salzburger-kunstverein.at');  //email address that receives the response

    //             // $mail->addBcc("istvan@treat.agency");
    //             $mail->IsSMTP();

    //         //    require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
    //         //     $mail = new PHPMailer();
    //         //     $mail->CharSet = 'UTF-8';

    //         //     $mail->SMTPDebug = 0; // prefix for secure protocol to connect to the server
    //         //     $mail->Host = "mta.it-tects.at"; // setting SMTP server
    //         //     $mail->Port = 25; // SMTP port to connect to
    //         //     $mail->Username = "service/trt"; // user email address
    //         //     $mail->Password = "sbqhbSF3bwcBfBeOEs0iXhVq"; // password
    //         //     $mail->SMTPAuth = true; // enabled SMTP authentication
    //         //     $mail->SMTPSecure = "tls"; // prefix for secure protocol to connect to the server



    //         //     $mail->SetFrom('noreply@treat.agency', 'Noreply'); //Who is sending the email
    //         //     $mail->AddReplyTo("noreply@treat.agency"); //email address that receives the response

    //             $subject = 'Reset password';
    //             $length = 64;
    //             $token = bin2hex(random_bytes($length));
    //             $this->am->setToken($token, $email);
    //             $data['link'] = '' . $token;
    //             $data['username'] = $user->username;
    //             $data['user_id'] = $user->id;
    //             $data['token'] = $token;
    //             $data['user'] = $user;
    //             $body = $this->load->view('mail/reset_pw', $data, true);
    //             //  $body = "Your image titled: ".$title." has been approved on <a href='https://bilder.hdgoe.at'>https://bilder.hdgoe.at</a>";

    //             $mail->Subject = $subject;
    //             $mail->Body = $body;
    //             $mail->isHTML(true);


    //             $mail->AddAddress($email, '');

    //             if (!$mail->Send()) {
    //                 /* echo 'Message could not be sent.';
    //                 echo 'Mailer Error: ' . $mail->ErrorInfo;*/
    //             } else {
    //                 // echo 'Message has been sent';
    //                 $this->showLogin('Mail sent!');
    //             }
    //         } else {
    //             $this->showLogin('No user found!');
    //         }
    //     }
    // }

    // public function resetPw2()
    // {
    //     $email = purify($_POST['email']);

    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         // invalid emailaddress
    //         $this->showLogin('Not valid email address!');
    //     } else {
    //         $user = $this->am->getUser($email);
    //         if ($user) {
    //             require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
    //             $mail = new PHPMailer();
    //             $mail->CharSet = 'UTF-8';

    //             $mail->SMTPDebug = 0; // prefix for secure protocol to connect to the server
    //             $mail->Host = "mta.it-tects.at"; // setting SMTP server
    //             $mail->Port = 25; // SMTP port to connect to
    //             $mail->Username = "service/trt"; // user email address
    //             $mail->Password = "sbqhbSF3bwcBfBeOEs0iXhVq"; // password
    //             $mail->SMTPAuth = true; // enabled SMTP authentication
    //             $mail->SMTPSecure = "tls"; // prefix for secure protocol to connect to the server



    //             $mail->SetFrom('noreply@treat.agency', 'Noreply'); //Who is sending the email
    //             $mail->AddReplyTo("noreply@treat.agency"); //email address that receives the response


    //             // $mail->addBcc("istvan@treat.agency");
    //             $mail->IsSMTP();

    //             $subject = '';
    //             $length = 64;
    //             $token = bin2hex(random_bytes($length));
    //             $user_token = $this->am->setToken($token, $email);
    //             $data['link'] = '' . $token;
    //             $data['username'] = $user->username;
    //             $data['user_id'] = $user->id;
    //             $data['token'] = $token;
    //             $data['user'] = $user;
    //             $body = $this->load->view('mail/reset_pw', $data, true);
    //             //  $body = "Your image titled: ".$title." has been approved on <a href='https://bilder.hdgoe.at'>https://bilder.hdgoe.at</a>";

    //             $mail->Subject = $subject;
    //             $mail->Body = $body;
    //             $mail->isHTML(true);


    //             $mail->AddAddress($email, '');

    //             if (!$mail->Send()) {
    //                 /* echo 'Message could not be sent.';
	// 			    echo 'Mailer Error: ' . $mail->ErrorInfo;*/
    //             } else {
    //                 // echo 'Message has been sent';
    //                 $this->showLogin('Mail sent!');
    //             }
    //         } else {
    //             $this->showLogin('No user found!');
    //         }
    //     }
    // }


    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        $this->load->view('authentication/logout', array());
    }



    public function usersettings($success = false)
    {
        $this->load->helper('form');
        $data['success'] = $success;
        $data['userdata'] = $this->user;
        $data['dev'] = $this->user->dev;

        $data['user'] = $this->am->getUserdataByID($this->session->userdata('user_id'))->row();
        $data['menupoints'] = $this->am->getMenupoints($this->session->userdata('user_id'));
        $data['username'] = $data['user']->username;



        $this->load->view('backend/head', $data);
        $this->load->view('backend/menu', $data);
        $this->load->view('authentication/settings', $data);
        $this->load->view('backend/footer', $data);
    }

    public function password_check($password)
        {
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,50}$/';

        if (preg_match($pattern, $password)) {
            return TRUE;
            } else {
            $this->form_validation->set_message('password_check', 'The {field} must contain at least one number, one uppercase letter, one lowercase letter, and one special character. Allowed length of the password is between 8 and 50 characters.');
            return FALSE;
            }
        }

    public function updateUser()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('firstname', 'First name', 'trim|max_length[50]');
        $this->form_validation->set_rules('lastname', 'Last name', 'trim|max_length[50]');
        $this->form_validation->set_rules('email', 'E-Mail', 'trim|max_length[255]|valid_email');
        $this->form_validation->set_rules('pword', 'New password', 'callback_password_check');

        if ($this->input->post('pword') != '' && $this->input->post('pword') != null)
            $this->form_validation->set_rules('pword2', 'Confirm password', 'max_length[50]|matches[pword]|required');



        if ($this->form_validation->run() == FALSE) {

            $data['user'] = $this->am->getUserdataByID($this->session->userdata('user_id'))->row();
            $data['username'] = $data['user']->username;
            $data['userdata'] = $data['user'];
            $data['dev'] = $data['user']->dev;

            $data['menupoints'] = $this->am->getMenupoints($this->session->userdata('user_id'));



            $this->load->view('backend/head', $data);
            $this->load->view('backend/menu', $data);
            $this->load->view('authentication/settings', $data);
            $this->load->view('backend/footer', $data);
        } else {
            if ($this->input->post('userid') == $this->session->userdata('user_id')) {
                $user = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'email' => $this->input->post('email'),
                );

                if ($this->input->post('pword') != '' && $this->input->post('pword') != null) {
                    require_once(APPPATH . 'libraries/PasswordHash.php');
                    $hasher = new PasswordHash(8, false);
                    $user['pword'] = $hasher->HashPassword($this->input->post('pword'));
                }

                $this->am->updateUser($user, $this->session->userdata('user_id'));

                $this->usersettings(true);
            } else {
                $this->logout();
            }
        }
    }


    public function email_exists($email)
    {
        return $this->am->newsletterEmailExists($email)->num_rows() == 1;
    }
}

/* End of file authentication.php */
/* Location: ./application/controllers/authentication.php */