<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Forms_Frontend
{

        /**************************    FORM VIEW       *******************************/


    public function form($type)
    {

        $data = array();

        $data['pretty'] = $pretty_url = $_GET['ref'];


        $data['item'] = $this->fm->getItemByPrettyURL($pretty_url);

        if(!$data['item'])
        {
            //maybe add a 404 page?
            redirect('');
        }

        $data['item']->Pretty = $pretty_url;
        $data['item']->teaser_images = array();
        // if necessary for prefilled field
        $data['pretty_url_as_name'] = str_replace("_", " ", $pretty_url);

        // type of form - 8 in total
        $data['type'] = $type;

        $form_directory = 'frontend/forms/';
        $form_view = '';
        $email_to = '';
        $special_head = '';

        // getting data based on type
        switch ($type) {
            case PROGRAMME_SCHOOLS:
                $form_view = 'form_programme_schools';
                $email_to = 'vermittlung@wienmuseum.at';
                break;
            // ADD MORE FORM TYPES
        }

        $data['special_head'] = $special_head;
        $data['email_to'] = $email_to;



        if($form_view != ''){

            $data['table_name'] = $form_view;

            return $this->load_view($form_directory . $form_view, $data);
        }
    }

            /**************************    FORM PROCESSING       *******************************/



        public function form_processing()
        {


            $type = $_POST['type'];
            // $email_to = $_POST['email_to'];

            $required_fields = array();
            $fields = array();
            $checkbox_fields = array();



            switch($type){
                case PROGRAMME_SCHOOLS:
                    // add normal and checkbox fields also with the name to display if empty
                    $required_fields[] = array('key' => 'firstname', 'name' => $this->lang->line('firstname') );
                    $required_fields[] = array('key' => 'lastname', 'name' => $this->lang->line('lastname') );
                    $required_fields[] = array('key' => 'address', 'name' => $this->lang->line('address') );
                    $required_fields[] = array('key' => 'email', 'name' => $this->lang->line('email') );


                    $fields[] = array('key' => 'note', 'name' => $this->lang->line('form_note'));
                    $fields[] = array('key' => 'programme', 'name' => 'Referral');

                    //  confirmation message
                    $msg = $this->lang->line('reg_success_msg');
                    $table_name = 'form_programme_schools';

                    // $checkbox_fields[] =  array('key' => 'sonderfuerun', 'name' => 'Sonderführung');
                    break;

            }


            // validation of required fields
            foreach($required_fields as $f){
                $this->form_validation->set_rules($f['key'], $f['name'], 'required');
            }


            if ($this->language == SECOND_LANGUAGE) {
                $this->form_validation->set_message('is_unique', 'The %s is already taken!');
                $this->form_validation->set_message('required', 'The %s field is required!');
            } else {
                $this->form_validation->set_message('is_unique', '%s ist schon registriert!');
                $this->form_validation->set_message('required', '%s ist verpflichtend!');
            }


            if ($this->form_validation->run() == true) {

                // automatic creation of data for import
                foreach($fields as $f){
                    ${$f['key']} = $_POST[$f['key']];
                }
                foreach($required_fields as $f){

                    ${$f['key']} = $_POST[$f['key']];
                }
                foreach($checkbox_fields as $f){
                    ${$f['key']} = isset($_POST[$f['key']]) ? 1: 0;
                }

                $data = array();
                $email_data = array();
                foreach($required_fields as $f){
                    if($f['key'] != 'daten' && $f['key'] != 'agb')
                    {
                        $data[$f['key']] = ${$f['key']};
                        $email_data[$f['key']] = array('name' => $f['name'], 'value' => ${$f['key']});

                    }

                }


                foreach($fields as $f){
                    $data[$f['key']] = ${$f['key']};
                    $email_data[$f['key']] = array('name' => $f['name'], 'value' => ${$f['key']});
                }

                foreach($checkbox_fields as $f){
                    $data[$f['key']] = ${$f['key']};
                    $email_data[$f['key']] = array('name' => $f['name'], 'value' => ${$f['key']});
                }

                // inserting of data

                $insert_form = $this->fm->insert_form($data, $table_name);

                if($insert_form) {

                    // sending of mail based on provided data
                    $this->sendMailForm($email_data, $type, $table_name);



                    echo json_encode(array('success' => true, 'text' => $msg));
                } else {

                    $msg = 'Etwas hat nicht funktioniert';

                    echo json_encode(array('success' => false, 'text' => $msg));
                }




                // redirect(site_url('confirm'));


            } else {
                $msg = validation_errors();
                echo json_encode(array('success' => false, 'text' => $msg));
                exit;
            }
        }

    public function form_template()
    {
        $this->form_validation->set_rules('museum', 'Museum', 'required');
        $this->form_validation->set_rules('event', $this->lang->line('event'), 'required');
        $this->form_validation->set_rules('school_type', $this->lang->line('school_type'), 'required');
        $this->form_validation->set_rules('count', $this->lang->line('count'), 'required');
        $this->form_validation->set_rules('lang', $this->lang->line('language'), 'required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required');
        $this->form_validation->set_rules('time', $this->lang->line('time'), 'required');

        $this->form_validation->set_rules('firstname', $this->lang->line('firstname'), 'required');
        $this->form_validation->set_rules('lastname', $this->lang->line('lastname'), 'required');
        $this->form_validation->set_rules('school_name', $this->lang->line('school_name'), 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('street', $this->lang->line('street'), 'required');
        $this->form_validation->set_rules('plz', $this->lang->line('plz'), 'required');
        $this->form_validation->set_rules('terms', $this->lang->line('terms'), 'required');


    if ($this->language == SECOND_LANGUAGE) {
        $this->form_validation->set_message('is_unique', 'The %s is already taken!');
        $this->form_validation->set_message('required', 'The %s field is required!');
    } else {
        $this->form_validation->set_message('is_unique', '%s ist schon registriert!');
        $this->form_validation->set_message('required', '%s ist verpflichtend!');
    }


    if ($this->form_validation->run() == true) {

        $museum = $_POST['museum'];
        $event = $_POST['event'];
        $school_type = $_POST['school_type'];
        $count = $_POST['count'];
        $lang = $_POST['lang'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $school_name = $_POST['school_name'];
        $street = $_POST['street'];
        $plz = $_POST['plz'];
        $phone = $_POST['phone'];
        $hearing = isset($_POST['hearing']) ? 1: 0;
        $seeing = isset($_POST['seeing']) ? 1: 0;
        $learning = isset($_POST['learning']) ? 1: 0;
        $german = isset($_POST['german']) ? 1: 0;

        $nonverbal = isset($_POST['nonverbal']) ? 1: 0;
        $reading = isset($_POST['reading']) ? 1: 0;
        $mobility = isset($_POST['mobility']) ? 1: 0;
        $concentration = isset($_POST['concentration']) ? 1: 0;
        $note = $_POST['note'];

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        $token = $this->generateRandomString(32);


        $data = array(
            'museum' => $museum,
            'event' => $event,
            'school_type' => $school_type,
            'count' => $count,
            'lang' => $lang,
            'date' => $date,
            'time' => $time,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'school_name' => $school_name,
            'email' => $email,
            'street' => $street,
            'plz' => $plz,

            'phone' => $phone,
            'hearing' => $hearing,
            'seeing' => $seeing,
            'learning' => $learning,
            'german' => $german,
            'nonverbal' => $nonverbal,
            'reading' => $reading,
            'mobility' => $mobility,
            'concentration' => $concentration,
            'note' => $note,
            'confirmation_token' => $token,
        );

        $res_id = $this->fm->insert_booking_school($data);


        $this->sendMailRegistration2FA($data);


        $msg = $this->lang->line('registration_2fa_msg');

        echo json_encode(array('success' => true, 'text' => $msg));

        // redirect(site_url('confirm'));



    } else {
        $msg = validation_errors();
        echo json_encode(array('success' => false, 'text' => $msg));
        exit;
    }
}

        /**************************    MAILING       *******************************/

   /********    STANDARD FORM       ******/


public function sendMailForm($data, $type, $table_name)
{
    require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");

    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 2;  // prefix for secure protocol to connect to the server
    //  $mail->IsSMTP();
    $mail->Host       = "relay.dienste.wien.at";      // setting SMTP server
    $mail->Port       = 587;                   // SMTP port to connect to
    $mail->SMTPSecure = 'tls';  // prefix for secure protocol to connect to the server
    $mail->SMTPAuth   = false; // enabled SMTP authentication
    $mail->Username   = "noreply@wienmuseum.at";  // user email address
    //  $mail->Password   = 'Xhlf$eDXA4';            // password

    $mail->Sendmail = '/usr/sbin/sendmail';
    $mail->isSendmail();


    $mail->SetFrom('noreply@wienmuseum.at');  //Who is sending the email

       /*    CUSTOM BASED ON FORM TYPE PART STARTS     */


    $signature = '';
    $head = '';
    $special_head = '';
    $subject = '';
    // based on type you get subject, signature and head of mail - alredy finished
    switch($type) {
        case PROGRAMME_SCHOOLS:
            $email_to = 'vermittlung@wienmuseum.at';
            $subject = $this->lang->line('school_reg_email_subject');
            $head = $this->lang->line('school_reg_email_top');


            $body_text = '';
            foreach($data as $key => $value)
            {
                $body_text .= $key.": ".$value."<br/>";
            }
            $body_text .= "<br/>";

            $signature = $this->lang->line('school_reg_email_footer');

            break;
            // ADD MORE FORM TYPES

    }

    /*    CUSTOM BASED ON FORM TYPE PART ENDS     */


    $mail->AddReplyTo($email_to);  //email address that receives the response

    // use signature and head text in your mail
    $data['signature'] = $signature;
    $data['head'] = $head;
    $data['body'] = $body_text;
    // go to mail/mail_table_name and add field you want to display in mail
    $body = $this->load->view('mail/mail_form', $data, true);


    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->isHTML(true);

    $email = $data['email']['value'];
    $mail->AddAddress($email);

    // IMPORTANT!!!!!!!!!
    // $email2 = 'peter@treat.agency'; // delete when done
    $email2 = $email_to; // add when done
    $mail->AddAddress($email2);


    if (!$mail->Send()) {
        /*  return 'E-mail could not be sent, please check the provided email is valid.'; */
        return 'Mailer Error: ' . $mail->ErrorInfo;
        // return 'Mail could not be sent';
    } else {
        return 'ok';
    }

}


    /********    2FA       ******/


  public function sendMailRegistration2FA($data)
    {
        require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");


        // PROCESSING INPUTS FOR DISPLAY
        $count_array = array();
        $count_array[] = array('key' => '0', 'value' => 'something');
        $count_array[] = array('key' => '1', 'value' => 'something_else');


        $school_array = array();
        $school_array[] = array('key' => '0', 'value' => 'school type');
        $school_array[] = array('key' => '1', 'value' => 'school type 2');

        $lang = array();
        $lang[] = array('key' => '0', 'value' => 'Deutsch');
        $lang[] = array('key' => '1', 'value' => 'English');

        // getting name of museum and event
        $museum =$this->fm->getLocationById($data['museum']);
        $data['museum'] = $museum->name;

        $event = $this->fm->getEventById($data['event']);
        $data['event'] = $event->title_de;
        $data['count'] =  $count_array[  $data['count'] ]['value'];
        $data['school_type'] = $school_array [$data['school_type']]['value'];
        $data['lang'] = $lang [$data['lang'] ]['value'];

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;  // prefix for secure protocol to connect to the server
        $mail->IsSMTP();
        $mail->Host       = "smtp.office365.com";      // setting SMTP server
        $mail->Port       = 587;                   // SMTP port to connect to
        $mail->SMTPSecure = 'tls';  // prefix for secure protocol to connect to the server
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->Username   = "noreply@beautylash.com";  // user email address
        $mail->Password   = "noBE2023!#!";            // password

        $mail->SetFrom('noreply@beautylash.com');  //Who is sending the email
        $mail->AddReplyTo('noreply@beautylash.com');  //email address that receives the response

        // EDIT
        $subject = 'BeautyLash Gewinnwpiel';

        $body = $this->load->view('mail/new_front_user', $data, true);


        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        $email = 'lukas@treat.agency';
       // $email = 'peter@treat.agency';
        $mail->AddAddress($email, '');
        $email = $data['email'];




        $mail->AddAddress($email, '');


        if (!$mail->Send()) {
            /*  return 'E-mail could not be sent, please check the provided email is valid.'; */
            return 'Mailer Error: ' . $mail->ErrorInfo;
            // return 'Mail could not be sent';
        } else {
            return 'ok';
        }

    }

      //*** emails
    public function sendConfirmationEmail($data, $for_events, $curated)
    {

        $data['for_events'] = $for_events;
        $data['curated'] = $curated;


        require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;  // prefix for secure protocol to connect to the server
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = false;  // prefix for secure protocol to connect to the server
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        $mail->Host       = "";      // setting SMTP server
        $mail->Port       = 25;                   // SMTP port to connect to
        $mail->Username   = "";  // user email address
        $mail->Password   = "";            // password

        $mail->SetFrom('');  //Who is sending the email
        $mail->AddReplyTo('');  //email address that receives the response
        // $mail->addBcc("istvan@treat.agency");

        $mail->IsSMTP();

        $subject = '';
        $body = $this->load->view('mail/gallery_confirm_mail', $data, true);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        $email = $data['email'];
        $mail->AddAddress($email, '');



        if (!$mail->Send()) {
            return 'Confirmation E-mail could not be sent, please check the provided email is valid. ' . 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return 'ok';
        }
    }
}
