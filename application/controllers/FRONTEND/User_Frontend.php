<?	defined('BASEPATH') or exit('No direct script access allowed');


trait User_Frontend {


             /**************************    VIEWS   *******************************/

      // log in
            public function login()
            {
                if ($this->session->userdata('front_logged_in')) {
                    redirect(site_url());
                } else {

                    $data = array();
                    $data['show_warning'] = true;

                    $data['cookie_mark'] = get_cookie('cookie_mark');

                    if (get_cookie('cookie_warning') == true) {
                        $data['show_warning'] = false;
                    }

                    $data['page_title'] = SITE_NAME . ': log in';

                    $this->load_view('frontend/tools/login', $data);
                }
            }

            public function reset_password_page($id, $token)
            {

                $user = $this->fm->get_frontend_user_by_id($id);

                if ($user->reset_token == $token) {

                    $data['status'] = true;
                    $data['user'] = $user;
                } else {
                    $data['status'] = false;
                    $data['msg'] = 'Something went wrong';
                }

                $data['lang'] = $this->language;
                $this->load_view('frontend/login/reset_password', $data);
            }



             /**************************    CUSTOM USER SELFSERVICE    *******************************/


    //*** *Artist self service area *****//
    public function artist($page, $err = '' )
    {

        $db = DB_NAME;

        $data = array();

        $data['print'] = false;
        $data['lang'] = $this->language;
        $data['front_logged_in'] = ($this->session->userdata('front_logged_in')) ? 1 : 0;
        $data['show_warning'] = true;

        $data['cookie_mark'] = get_cookie('cookie_mark');

        if (get_cookie('cookie_warning') == true) {
            $data['show_warning'] = false;
        }

        if($page == 'login')
        {
            if($data['front_logged_in'] == 1)
            {
                redirect('artist/edit');
            }

            $data['errormessage'] = '';

            switch($err)
            {
                case 400:{$data['errormessage'] = 'User not found';break;}
                case 401:{$data['errormessage'] = 'Incorrect password';break;}
                default:{$data['errormessage'] = '';}
            }


            $data['page_title'] = SITE_NAME . ' - artist login';
            $data['page'] = 'login';
            $this->load_view('authentication/artist_login', $data);
        }
        else if($page == 'edit')
        {
            if($data['front_logged_in'] == 0)
            {
                $this->session->unset_userdata('artist_id');
                $this->session->unset_userdata('front_logged_in');
                redirect('artist/login');
                exit;
            }

            $stoken = $this->session->userdata('artist_id');

            $data['artist'] = $this->fm->getArtistByToken($stoken);

            if(!$data['artist'])
            {
                $this->session->unset_userdata('artist_id');
                $this->session->unset_userdata('front_logged_in');
                redirect('artist/login/400');
                exit;
            }
            $data['errormessage'] = '';
            $data['page_title'] = SITE_NAME . ' - artist edit';
            $data['page'] = 'edit';
            $this->load_view('frontend/artist_edit', $data);
        }
        else if($page == 'logout')
        {

            $this->session->unset_userdata('artist_id');
            $this->session->unset_userdata('front_logged_in');
            redirect('artist/login');
            exit;
        }
        else
        {
            redirect('');
        }


    }

        public function loginArtist()
    {
        $username = purify($_POST['username']);
        $pword = purify($_POST['pword']);

        if ($this->fm->getPW($username)->num_rows() > 0) {

            $pwcheck = check_hash($pword, $this->fm->getPW($username)->row()->password);
            if ($pwcheck) {
                $user = $this->fm->getUser($username);

                if($user != false)
                {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < 24; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $update_data = array('s_token' => $randomString);
                    $this->fm->updateArtist($user->id, $update_data);

                    $this->session->set_userdata('artist_id', $randomString);
                    $this->session->set_userdata('front_logged_in', 1);
                    redirect('artist/edit');
                }
                else
                {
                    redirect('artist/login/400');
                }



            } else {
                redirect('artist/login/401');

            }
        } else {
            redirect('artist/login/400');
        }
    }


    public function updateArtist()
    {
        $artist_id = $_POST['aid'];
        $bio = $_POST['bio'];
        $exhibitions = $_POST['exhibitions'];
        $bio_en = $_POST['bio_en'];
        $exhibitions_en = $_POST['exhibitions_en'];

        $stoken = $this->session->userdata('artist_id');

        $artist = $this->fm->getArtistByToken($stoken);
        if(!$artist)
        {
            echo json_encode(array('success' => false));
            exit;
        }

        if ($artist->id == $artist_id) {

            $update_data = array('bio' => $bio, 'exhibitions' =>$exhibitions, 'bio_en' => $bio_en, 'exhibitions_en' =>$exhibitions_en);
            $this->fm->updateArtist($artist->id, $update_data);
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }


    public function showLogin() {
        $data = array();

        $this->load_view('authentication/reset_pw', $data);

    }

                 /**************************    LOGIN LOGOUT   *******************************/

    public function  user_login()
    {

        $email = $_POST['email'];
        $password = $_POST['password'];


        $is_registered = $this->fm->check_is_registered_user_mail($email);
        $is_registered = $is_registered != false ? $is_registered : $this->fm->check_is_registered_user($email);

        if ($is_registered != false) {



            // check password
            $checkpass = check_hash($password, $is_registered->pword);
            if ($checkpass) {
                $this->session->set_userdata('front_logged_in', true);
                $this->session->set_userdata('front_user_id', $is_registered->id);
                $this->session->set_userdata('front_user_email', $is_registered->email);
                $this->session->set_userdata('front_username', $is_registered->username);

                echo 'ok';
                return false;
            } else {
                echo 'password';
                return false;
            }
        } else {
            echo 'something went wrong, Expired user?';
            return false;
        }
    }

        public function  logout()
    {
        $this->session->set_userdata('front_logged_in', false);
        $this->session->unset_userdata('front_user_id');
        $this->session->unset_userdata('front_user_email');
        $this->session->unset_userdata('front_username');
    }


                 /**************************    RESET PASSWORD   *******************************/


     public function  reset_password_final()
    {

        require_once(APPPATH . 'libraries/PasswordHash.php');

        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];
        $user_id = $_POST['user_id'];

        if ($password != '') {
            $hasher = new PasswordHash(8, false);
            $insert_data['pword'] = $hasher->HashPassword($password);
            $length = 12;
            $token = bin2hex(random_bytes($length));
            $insert_data['reset_token'] = $token;
            if ($password_repeat != '' && $password_repeat == $password) {
                $this->fm->update_frontend_user($user_id, $insert_data);
            } else {
                echo "Passwords don't match, please try again.";
                return 'faild';
            }
            echo 'true';
        } else {
            echo 'Please enter a password.';
            return 'faild';
        }
    }


    public function reset_password_backend()
    {

        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];
        $user_id = $_POST['user_id'];


        if ($password != '' && $this->password_check($password)) {
            $hasher = new PasswordHash(8, false);
            $insert_data['pword'] = $hasher->HashPassword($password);
            $length = 12;
            $token = bin2hex(random_bytes($length));
            $insert_data['reset_token'] = $token;
            if ($password_repeat != '' && $password_repeat == $password) {
                $this->fm->update_backend_user($user_id, $insert_data);
            } else {
                echo json_encode(array('success' => false, 'message' => "Passwords don't match, please try again."));
            }


            echo json_encode(array('success' => true, 'message' => 'Password changed successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Password must contain at least one number, one uppercase letter, one lowercase letter, and one special character. Allowed length of the password is between 8 and 50 characters.'));
        }
    }

    public function password_check($password)
        {
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,50}$/';

        if (preg_match($pattern, $password)) {
            return true;
            } else {
            return false;
            }
        }




    }