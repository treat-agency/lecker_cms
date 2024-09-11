<?php defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'controllers/Backend.php');

class Users extends Backend
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('entities/Content_model', 'cm');
		if ($this->user->is_admin != 1 && $this->user->superadmin != 1) {
			redirect('');
		}
	}

	public function items()
	{
		if ($this->user->is_admin != 1 || $this->user->superadmin != 1) {
			redirect('');
		}

		$bc = new besc_crud();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->main_title('Users');
		$bc->table_name('Users');
		$bc->table('backend_user');
		//$bc->where('is_admin = 0');
		$bc->primary_key('id');
		$bc->title('User');


		$bc->list_columns(array('username', 'firstname', 'lastname', 'email'));
		$bc->filter_columns(array('username', 'firstname', 'lastname', 'email'));

		$bc->custom_buttons(
			array(
				array(
					'name' => 'Reset user password an email them',
					'icon' => site_url('items/backend/img/edit_icon.png'),
					'add_pk' => true,
					'url' => 'reset_view'
				),
			)
		);

		$select_array = array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		$bc->columns(
			array(
				'username' => array(
					'db_name' => 'username',
					'type' => 'text',
					'display_as' => 'Username',
					'disabled' => true,
					'validation' => 'required|is_unique[backend_user.username]',
				),

				'firstname' => array(
					'db_name' => 'firstname',
					'type' => 'text',
					'display_as' => 'Firstname',

				),

				'lastname' => array(
					'db_name' => 'lastname',
					'type' => 'text',
					'display_as' => 'Lastname',


				),


				'email' => array(
					'db_name' => 'email',
					'type' => 'text',
					'display_as' => 'Email',
					'validation' => 'required',

				),



				'is_admin' => array(
					'db_name' => 'is_admin',
					'type' => 'hidden',
					'value' => 1,
				),


			)
		);

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function frontend_user()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Content');
		$bc->table_name('frontend_user');
		$bc->table('frontend_user');
		$bc->primary_key('id');
		$bc->title('Frontend Users');


		$bc->list_columns(array('username', 'email', 'expiry'));
		$bc->filter_columns(array('username', 'email', 'expiry'));

		$bc->custom_buttons(
			array(
				array(
					'name' => 'Reset user password an email them',
					'icon' => site_url('items/backend/img/edit_icon.png'),
					'add_pk' => true,
					'url' => 'reset_view_front'
				),
			)
		);

		$bc->columns(
			array(
				'username' => array(
					'db_name' => 'username',
					'type' => 'text',
					'display_as' => 'Username',
				),

				'email' => array(
					'db_name' => 'email',
					'type' => 'text',
					'display_as' => 'E-mail',
				),

				'expiry' => array(
					'db_name' => 'expiry',
					'type' => 'text',
					'col_info' => 'yyyy-mm-dd hh:mm',
					'display_as' => 'expiry date',
				),
				'user_items_relation' => array(
					'relation_id' => 'user_items_relation',
					'type' => 'm_n_relation',
					'table_mn' => 'user_items_relation',
					'table_mn_pk' => 'id',
					'table_mn_col_m' => 'user_id',
					'table_mn_col_n' => 'item_id',
					'table_m' => 'frontend_user',
					'table_n' => 'items',
					'table_n_pk' => 'id',
					'table_n_value' => 'name',
					'table_n_value2' => 'pretty_url',
					'display_as' => 'Favourites',
					'box_width' => 400,
					'box_height' => 250,
					'filter' => true,
				),
			)
		);

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function reset_view($itemId)
	{
		$db = DB_NAME;
		$data = array();

		$html = $this->load->view('backend/reset_pw', TRUE);
		echo $html;
	}

	public function reset_view_front($itemId)
	{
		$db = DB_NAME;
		$data = array();

		$html = $this->load->view('backend/reset_pw_front', TRUE);
		echo $html;
	}


	public function giveMePassword()
	{


		$pword = $this->random_str(8);

		echo"pword:" . $pword . "<br>";

		require_once(APPPATH . 'libraries/PasswordHash.php');
		$hasher = new PasswordHash(8, false);
		$pw = $hasher->HashPassword($pword);

		echo "pw:" . $pw . "<br>";

	}

	public function reset_password($itemId)
	{

		// UNCOMMENT TO SEE PASSWORD RESET
		$db = DB_NAME;
		$data = array();

		$user = $this->cm->getBackendUserByID($itemId, $db)->row();
		// var_dump("user:");
		// var_dump($user);

		$pword = $this->random_str(8);

		// var_dump("pword:");
		var_dump($pword);

		require_once(APPPATH . 'libraries/PasswordHash.php');
		$hasher = new PasswordHash(8, false);
		$pw = $hasher->HashPassword($pword);
		// var_dump("pw:");
		// var_dump($pw);

		$update_data = array('pword' => $pw);
		$this->cm->updateData($db, $update_data, $itemId, 'backend_user');

		$this->sendUserMail($user->email, $user->username, $pword, false);

		echo json_encode(array('success' => true));
	}
	public function reset_password_front($itemId)
	{
		$db = DB_NAME;
		$data = array();

		$user = $this->cm->getFrontendUserByID($itemId, $db)->row();

		$pword = $this->random_str(8);

		require_once(APPPATH . 'libraries/PasswordHash.php');
		$hasher = new PasswordHash(8, false);
		$pw = $hasher->HashPassword($pword);

		$update_data = array('pword' => $pw);
		$this->cm->updateData($db, $update_data, $itemId, 'frontend_user');

		$this->sendUserMail($user->email, $user->username, $pword, true);

		echo json_encode(array('success' => true));
	}

	function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		if ($max < 1) {
			throw new Exception('$keyspace must be at least two characters long');
		}
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}
		return $str;
	}



	public function save_item()
	{
		$db = 'hdgoe_website';
		$this->cm->deleteModulesText($_POST['id'], $db);
		$this->cm->deleteModulesImage($_POST['id'], $db);
		$this->cm->deleteModulesHTML($_POST['id'], $db);
		$this->cm->deleteModulesHeadline($_POST['id'], $db);
		$this->cm->deleteModulesPdf($_POST['id'], $db);
		$this->cm->deleteModulesStart($_POST['id'], $db);
		$this->cm->deleteModulesQuote($_POST['id'], $db);


		if (isset($_POST['modules'])) {
			foreach ($_POST['modules'] as $module) {
				switch ($module['type']) {

					case 'text':
						$this->cm->insertModuleText(
							array(
								'item_id' => $_POST['id'],
								'top' => $module['top'],
								'content' => $module['content'],
							),
							$db
						);
						break;

					case 'quote':
						$this->cm->insertModuleQuote(
							array(
								'item_id' => $_POST['id'],
								'top' => $module['top'],
								'content' => $module['content'],
								'author' => $module['author'],
							),
							$db
						);
						break;

					case 'image':
						$this->cm->insertModuleImage(
							array(
								'item_id' => $_POST['id'],
								'top' => $module['top'],
								'fname' => $module['fname'],
								'text_wrap' => $module['text_wrap'],
								'description' => $module['description'],
							),
							$db
						);
						break;

					case 'html':
						$this->cm->insertModuleHTML(
							array(
								'item_id' => $_POST['id'],
								'top' => $module['top'],
								'html' => $module['html'],
							),
							$db
						);
						break;

					case 'headline':
						$this->cm->insertModuleHeadline(
							array(
								'item_id' => $_POST['id'],
								'top' => $module['top'],
								'content' => $module['headline'],
							),
							$db
						);
						break;

					case 'pdf':
						$this->cm->insertModulePdf(
							array(
								'item_id' => $_POST['id'],
								'fname' => $module['fname'],
								'top' => $module['top'],
								'text' => $module['text'],
							),
							$db
						);
						break;

					case 'start':
						$this->cm->insertModuleStart(
							array(
								'item_id' => $_POST['id'],
								'top' => $module['top'],
								'header_img' => $module['fname'],
								'title' => $module['title'],
								'sub_title' => $module['subtitle'],
								'content' => $module['description'],
							),
							$db
						);
						break;
				}
			}
		}


		$this->cm->deleteGalleryItems($_POST['id'], $db);
		if (isset($_POST['gallery_items'])) {

			$batch = array();
			foreach ($_POST['gallery_items'] as $galleryItem) {
				$batch[] = array(
					'item_id' => $_POST['id'],
					'type' => $column_id,
					'fname' => $galleryItem['filename'],
					'credits' => $galleryItem['credits'],
				);
			}
			$this->cm->insertGalleryItems($batch, $db);
		}



		echo json_encode(
			array(
				'success' => true,
			)
		);
	}



	public function upload_image()
	{
		$this->load->helper('besc_helper');

		$parsed_url = parse_url(site_url());
		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
		$hostUrl = $host . "/" . 'hdgoe/Website';

		$filename = $_POST['filename'];
		$upload_path = $_POST['uploadpath'];
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$serverFile = time() . "_" . $rnd . "." . $ext;
		$folderPath = str_replace("CMS", "", getcwd());
		$error = move_uploaded_file($_FILES['data']['tmp_name'], $folderPath . "/$upload_path/$serverFile");

		resize_max($folderPath . "/$upload_path/$serverFile", 1000, 1000);

		echo json_encode(
			array(
				'success' => true,
				'path' => $folderPath . "/$upload_path/$serverFile",
				'fullpath' => $host . "/$upload_path/$serverFile",
				'filename' => $serverFile
			)
		);
	}


	public function upload_pdf()
	{
		$this->load->helper('besc_helper');

		$parsed_url = parse_url(site_url());
		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
		$hostUrl = $host . "/" . 'hdgoe/Website';

		$filename = $_POST['filename'];
		$upload_path = $_POST['uploadpath'];
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$serverFile = time() . "_" . $rnd . "." . $ext;
		$folderPath = str_replace("CMS", "", getcwd());
		$error = move_uploaded_file($_FILES['data']['tmp_name'], $folderPath . "/$upload_path/$serverFile");



		echo json_encode(
			array(
				'success' => true,
				'path' => $folderPath . "/$upload_path/$serverFile",
				'fullpath' => $host . "/$upload_path/$serverFile",
				'filename' => $serverFile
			)
		);
	}

	public function uploadFile()
	{
		$filename = $this->input->post('filename');
		$upload_path = $this->input->post('uploadpath');

		$error = move_uploaded_file($_FILES['data']['tmp_name'], getcwd() . "/$upload_path/$filename");

		echo json_encode(
			array(
				'error' => $error,
				'success' => true,
				'filename' => $filename
			)
		);
	}





	public function sendUserMail($email, $username, $pw, $front)
	{

		require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';

		$mail->SMTPDebug = 0; // prefix for secure protocol to connect to the server
		$mail->Host = "mta.it-tects.at"; // setting SMTP server
		$mail->Port = 25; // SMTP port to connect to
		$mail->Username = "service/trt"; // user email address
		$mail->Password = "sbqhbSF3bwcBfBeOEs0iXhVq"; // password
		$mail->SMTPAuth = true; // enabled SMTP authentication
		$mail->SMTPSecure = "tls"; // prefix for secure protocol to connect to the server


		$mail->SetFrom('noreply@treat.agency', 'Noreply'); //Who is sending the email
		$mail->AddReplyTo("noreply@treat.agency"); //email address that receives the response


		// $mail->addBcc("istvan@treat.agency");
		$mail->IsSMTP();
		$subject = $front ? SITE_NAME : SITE_NAME . '  CMS';


		$data['username'] = $username;
		$data['pw'] = $pw;
		$data['front'] = $front;
		$body = $this->load->view('mail/new_user', $data, true);
		//  $body = "Your image titled: ".$title." has been approved on <a href='https://bilder.hdgoe.at'>https://bilder.hdgoe.at</a>";

		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->isHTML(true);


		$mail->AddAddress($email, '');

		if (!$mail->Send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			//    echo 'Message has been sent';
		}
	}



	public function regex_test()
	{
		echo preg_match('/is_unique/', 'is_unique[metatag.name]');
	}
}