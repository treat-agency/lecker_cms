<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends MY_Controller
{
	protected $shop = null;


	function __construct()
	{
		parent::__construct();
		$this->load->model('Shop_model', 'sm');
		$this->load->model('Frontend_model', 'fm');

		$this->stripe_secret = "<YOUR_DATA>";
		$this->stripe_pk = "<YOUR_DATA>";

		$this->bill_prefix = 'lecker-';

		$this->abei_token = '<YOUR_DATA>';
		$this->abei_url = '<YOUR_DATA>';
	}




	public function sendABEI($order_id)
	{
		$token = "<YOUR_DATA>";

		$orderlines = array();

		/*  $line_item = array("itemCode" => ,"quantity" => ,"price" => ,"discountPercentage" => ,"vatPercentage" => ,);

	    $data = array('ext_ordernr' =>,
	        'ext_invoicenr' =>,
	        'country' =>,
	        'customerID' =>,
	        'firstName' =>,
	        'lastName' =>,
	        'streetAddress' =>,
	        'postalCode' =>,
	        'city' =>,
	        'phoneNumber' =>,
	        'emailAddress' =>,
	        'paymentMethodID' =>,
	        'paymentMethod' =>,
	        'orderTotal' =>,
	        'orderDate' =>,
	        'OrderLines' =>$orderlines,

	    );




	    */





		$post_data = http_build_query($data);

		$url = $this->abei_url;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$httpHeaders = [
			'Accept: application/json',
			'Authorization: Bearer ' . $this->abei_token,
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
		curl_close($ch);
		// var_dump($response);

		/* $update_data = array('edudip_response' => $response);
	    $this->sm->updateOrderStatus($order_id, $update_data);*/
	}








	public function customer_registration()
	{
		$data = array();
		$data['countries'] = $this->fm->getCountries();


		$this->load_view('shop/register_customer', $data);
	}


	public function register_customer()
	{

		$this->form_validation->set_rules('vorname', $this->lang->line('firstname'), 'required');
		$this->form_validation->set_rules('nachname', $this->lang->line('lastname'), 'required');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[s_customers.email]');
		$this->form_validation->set_rules('street', $this->lang->line('street'), 'required');
		$this->form_validation->set_rules('house_nr', $this->lang->line('house_nr'), 'required');
		$this->form_validation->set_rules('zip', $this->lang->line('zip'), 'required');
		$this->form_validation->set_rules('city', $this->lang->line('city'), 'required');
		$this->form_validation->set_rules('agb', $this->lang->line('agb'), 'required');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'min_length[6]|required');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('confirm_password'), 'required|matches[password]');


		if ($this->language == SECOND_LANGUAGE) {
			$this->form_validation->set_message('is_unique', 'The %s is already taken!');
			$this->form_validation->set_message('required', 'The %s field is required!');
		} else {
			$this->form_validation->set_message('is_unique', '%s ist schon registriert!');
			$this->form_validation->set_message('required', '%s ist verpflichtend!');
		}


		if ($this->form_validation->run() == true) {

			$data['firstname'] = $this->input->post('vorname');
			$data['lastname'] = $this->input->post('nachname');
			$data['company'] = $this->input->post('firmenname');
			$data['country'] = $this->input->post('spende_land');
			$data['street'] = $this->input->post('street');
			$data['street_number'] = $this->input->post('house_nr');
			$data['stair'] = $this->input->post('door_staircase');
			$data['zip'] = $this->input->post('zip');
			$data['city'] = $this->input->post('city');
			$data['email']  = $this->input->post('email');
			$data['phone'] = $this->input->post('phone');
			$password = $this->input->post('password');

			$length = 24;
			$data['confirmation_token'] = bin2hex(openssl_random_pseudo_bytes($length));



			$data['password'] = password_hash($password, PASSWORD_BCRYPT);


			$res_id = $this->sm->insertCustomerRegistration($data);


			$this->sendMailCustomerRegistration($data,  $data['email']);


			$msg = 'Vielen Dank!<br> Eine E-Mail mit einem Link zur Bestätigung Ihrer E-Mail Adresse wurde an die von Ihnen angegebene Adresse versendet.';

			echo json_encode(array('success' => true, 'msg' => $msg));
		} else {
			$msg = validation_errors();
			echo json_encode(array('success' => false, 'msg' => $msg));
			exit;
		}
	}

	public function sendMailCustomerRegistration($data, $user_email)
	{


		/* CHANGE ON LIVE */
		require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();

		$mail->IsSMTP(); // we are going to use SMTP
		$mail->SMTPDebug = 0;  // prefix for secure protocol to connect to the server
		$mail->Host       = "mta.it-tects.at";      // setting SMTP server
		$mail->Port       = 25;                   // SMTP port to connect to
		$mail->Username   = "service/trt";  // user email address
		$mail->Password   = "sbqhbSF3bwcBfBeOEs0iXhVq";            // password
		$mail->SMTPAuth   = true; // enabled SMTP authentication
		$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server

		$mail->SetFrom('office@treat.agency', '');  //Who is sending the email
		$mail->AddReplyTo("noreply@treat.agency");  //email address that receives the response


		$mail->Subject = SITE_NAME . " registration";

		//$mail->AddAttachment($_SERVER["DOCUMENT_ROOT"] . '/billing_tool/items/uploads/pdfs/' . $bill_id_pdf . '.pdf', 'treat_Rechnung_' . $bill_id_pdf . '.pdf', 'base64', 'application/pdf');


		$body = $this->load->view('mail/customer_confirmation', $data, true);

		$mail->Body = $body;
		$mail->isHTML(true);



		// $mail->AddAddress($email, '');
		$mail->AddAddress($user_email, '');
		if (!$mail->Send()) {
			//  echo "Error sending: " . $mail->ErrorInfo;
		} else {
			//  echo "Email geschickt!";
		}
	}

	public function confirm_registration($token)
	{

		$customer = $this->sm->getCustomerByToken($token);

		if (!$customer) {

			$data['msg'] = 'INVALID or EXPIRED Token';
		} else {
			if ($customer->confirmed == 0) {

				$update = array('confirmed' => 1);
				$this->sm->updateCustomer($customer->id, $update);
				$data['msg'] = 'Thank You, Your account has been activated!';
			} else {
				$data['msg'] = 'INVALID or EXPIRED Token';
			}
		}

		$this->load_view('shop/shop_response', $data);
	}


	public function customer_login()
	{
		$username = trim($_POST['user']);
		$password = $_POST['pw'];

		$user = $this->sm->getUserByEmail($username);

		if (!$user) {
			$success = false;
			$msg = "Email or password is wrong";
		} else {
			if (!password_verify($password, $user->password)) {
				$success = false;
				$msg = "Email or password is wrong";
			} else {
				if ($user->confirmed == 1) {
					$this->session->set_userdata('customer_logged_in', $user);
					$success = true;
					$msg = "Logging in";
				} else {
					$success = false;
					$msg = "Email or password is wrong";
				}
			}
		}

		echo json_encode(array('success' => $success, 'msg' => $msg));
	}


	public function customer_logout()
	{
		$this->session->unset_userdata('customer_logged_in');
		echo json_encode(array('success' => true));
	}

	public function removePromoCode()
	{
		$data['cartitems'] = $this->cart->contents();
		foreach ($data['cartitems'] as $cart_item) {
			if ($cart_item['options']['category'] == 'free_product') {

				$this->cart->remove($cart_item['rowid']);
			}
		}

		$this->session->unset_userdata('promo_code');
		$this->session->unset_userdata('promo_discount');
		$this->session->unset_userdata('promo_free_item');
	}


	public function addPromoCode()
	{
		$promo_code = $_POST['promo_code'];

		if ($promo_code != '') {
			$promo = $this->sm->getVoucher($promo_code);

			if (!$promo) {
				echo json_encode(array('success' => false, 'msg' => 'Invalid code'));
			} else {

				$now = new DateTime();
				$start = new DateTime($promo->valid_start);
				$end = new DateTime($promo->valid_end);

				if ($start < $now && $now < $end) {
					$this->session->set_userdata('promo_code', $promo_code);
					echo json_encode(array('success' => true, 'msg' => 'Promo code added'));
				} else {
					echo json_encode(array('success' => false, 'msg' => 'Code expired!'));
				}
			}
		}
	}


	public function stripeWebhook()
	{


		// This is your Stripe CLI webhook secret
		$endpoint_secret = 'whsec_3juudF7cQYlD8bX44oQtQiPVJKn5a9VJ';

		$payload = @file_get_contents('php://input');
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
		$event = null;

		try {
			$event = \Stripe\Webhook::constructEvent(
				$payload,
				$sig_header,
				$endpoint_secret
			);
		} catch (\UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400);
			exit();
		} catch (\Stripe\Exception\SignatureVerificationException $e) {
			// Invalid signature
			http_response_code(400);
			exit();
		}

		// Handle the event
		switch ($event->type) {
			case 'payment_intent.succeeded':
				$paymentIntent = $event->data->object;

				$order_id = $paymentIntent->metadata->order_id;
				$treat_token = $paymentIntent->metadata->order_id;


				$update_data = array('paymentState' => ORDER_STATUS_PAYMENTINTENT_SUCCESS, 'order_data' => $paymentIntent);

				$this->sm->updateOrderStatus($order_id, $update_data);
				break;

			case 'charge.succeeded':
				$paymentIntent = $event->data->object;

				$order_id = $paymentIntent->metadata->order_id;
				$treat_token = $paymentIntent->metadata->order_id;


				$update_data = array('paymentState' => ORDER_STATUS_CHARGE_SUCCESS, 'order_data' => $paymentIntent);
				$this->sm->updateOrderStatus($order_id, $update_data);

				//Add Bill generation and mailing here

				$order = $this->sm->getOrderByID($order_id);

				if ($order->sent == 1) {
					echo "Order already sent";
					http_response_code(400);
					exit;
				}

				$max_invoice = $this->sm->getLatestInvoicenumber()->row()->bill_id;
				$max_yearly_invoice =  $this->sm->getLatestInvoicenumberYearly(date('Y', strtotime($order->order_date)));
				$new_yearly_invoice = $max_yearly_invoice + 1;



				$this->sendOrderCustomer($order_id);


				break;

			case 'checkout.session.completed':
				$paymentIntent = $event->data->object;

				$order_id = $paymentIntent->metadata->order_id;
				$treat_token = $paymentIntent->metadata->order_id;


				$update_data = array('paymentState' => ORDER_STATUS_CHECKOUT_SUCCESS, 'order_data' => $paymentIntent);

				$this->sm->updateOrderStatus($order_id, $update_data);
				break;

			case 'payment_intent.canceled':
				$paymentIntent = $event->data->object;

				$order_id = $paymentIntent->metadata->order_id;
				$treat_token = $paymentIntent->metadata->order_id;


				$update_data = array('paymentState' => ORDER_STATUS_CANCEL, 'order_data' => $paymentIntent);

				$this->sm->updateOrderStatus($order_id, $update_data);
				break;



			default:
				echo 'Received unknown event type ' . $event->type;
		}

		http_response_code(200);
	}

	public function stripeInit($amount, $order_id, $treat_redirect_token)
	{


		\Stripe\Stripe::setApiKey($this->stripe_secret);
		// header('Content-Type: application/json');

		$YOUR_DOMAIN = site_url();

		$checkout_session = \Stripe\Checkout\Session::create([
			'line_items' => [[
				'price_data' => [
					'currency' => 'eur',
					'unit_amount' => $amount,
					'product_data' => [
						'name' => "Shop order",
						'description' => 'Your order',
					],
				],
				'quantity' => 1,
			]],
			"payment_intent_data" => [
				'metadata' => ["order_id" => $order_id, 'treat_token' => $treat_redirect_token]
			],
			'mode' => 'payment',
			'success_url' => $YOUR_DOMAIN . 'shop_success',
			'cancel_url' => $YOUR_DOMAIN . 'shop_cancel',
		]);


		// header("HTTP/1.1 303 See Other");

		return $checkout_session->url;
		//  header("Location: " . $checkout_session->url);

	}



	public function load_view($view, $viewdata)
	{

		$data = array();
		$data = $viewdata;
		$data['front_logged_in'] = $this->session->userdata('front_logged_in');


		// treatstart
		$data['page_title'] = (isset($viewdata['page_title'])) ? $viewdata['page_title'] : SITE_NAME;
		$data['og_img'] = (isset($viewdata['og_img'])) ? site_url('items/uploads/images/') . $viewdata['og_img'] :  site_url('items/frontend/img/logo/logo.png');
		$data['og_title'] = (isset($viewdata['og_title'])) ? $viewdata['og_title'] : SITE_NAME;
		$data['og_description'] = (isset($viewdata['og_description'])) ? $viewdata['og_description'] : SITE_NAME;
		$data['og_url'] = (isset($viewdata['og_url'])) ? $viewdata['og_url'] : site_url();
		$data['seo_description'] = (isset($viewdata['seo_description'])) ? $viewdata['seo_description'] : SITE_NAME;


		$data['show_warning'] = true;

		$data['cookie_mark'] = get_cookie('cookie_mark');

		if (get_cookie('cookie_warning') == true) {
			$data['show_warning'] = false;
		}

		$data['lang'] = $this->language;

		$data['page'] = str_replace(".php", "", basename($_SERVER['PHP_SELF']));

		$data['user'] = false;
		if ($this->session->userdata('customer_logged_in')) {
			$data['user'] = $this->session->userdata('customer_logged_in');
		}


		$data['menu_items'] = array();



		switch ($this->language) {
			case '0':
				setlocale(LC_TIME, 'de_DE.utf8');
				break;
			case '1':
				setlocale(LC_TIME, 'en_US.utf8');
				break;
		}

		$this->load->view('frontend/head', $data);
		$this->load->view($view, $viewdata);
		$this->load->view('frontend/footer', $data);
	}


	protected function getRandomInteger($min, $max)
	{
		$range = ($max - $min);

		if ($range < 0) {
			// Not so random...
			return $min;
		}

		$log = log($range, 2);

		// Length in bytes.
		$bytes = (int) ($log / 8) + 1;

		// Length in bits.
		$bits = (int) $log + 1;

		// Set all lower bits to 1.
		$filter = (int) (1 << $bits) - 1;

		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));

			// Discard irrelevant bits.
			$rnd = $rnd & $filter;
		} while ($rnd >= $range);

		return ($min + $rnd);
	}


	public function cart_view()
	{
		$data['show_warning'] = true;

		if (get_cookie('cookie_warning') == true) {

			$data['show_warning'] = false;
		}

		$data['a_cookie'] = get_cookie('a_cookie') == true ? true : false;

		$data['lang'] = $this->language;
		$data['mainmenu'] = array();
		$data['menus'] = array();

		$data['cartitems'] = $this->cart->contents();

		$data['total'] = $this->cart->total();

		$data['promo'] = false;
		$promo_code = $this->session->userdata('promo_code');

		if ($promo_code) {
			$promo = $this->sm->getVoucher($promo_code);

			if ($promo != false) {
				$now = new DateTime();
				$start = new DateTime($promo->valid_start);
				$end = new DateTime($promo->valid_end);

				if ($start < $now && $now < $end) {


					switch ($promo->type) {
						case VOUCHER_ENTIRE_CART_PERCENT: {
								$cart_total = $data['total'];
								$discount = $cart_total * ($promo->discount / 100);
								$this->session->set_userdata('promo_discount', $discount);
								$discounted_total = $cart_total - $discount;
								$data['promo'] = array('code' => $promo_code, 'discount' => number_format($discount, 2, ',', ''), 'total' => number_format($discounted_total, 2, ',', ''));


								break;
							}
						case VOUCHER_ENTIRE_CART_FLAT: {
								$cart_total = $data['total'];
								$discount = $promo->discount;
								$this->session->set_userdata('promo_discount', $discount);
								$discounted_total = $cart_total - $discount;
								$data['promo'] = array('code' => $promo_code, 'discount' => number_format($discount, 2, ',', ''), 'total' => number_format($discounted_total, 2, ',', ''));
								break;
							}
						case VOUCHER_ATTACHED_PRODUCT_PERCENT: {
								$cart_total = $data['total'];
								$product = $this->sm->getShopItemById($promo->product_id);
								if ($product != false) {

									foreach ($data['cartitems'] as $cart_item) {
										if ($cart_item['id'] == $promo->product_id) {
											$discount_per_item = $cart_item['price'] * ($promo->discount / 100);
											$discount = $cart_item['qty'] * $discount_per_item;
											$this->session->set_userdata('promo_discount', $discount);
											$discounted_total = $cart_total - $discount;
											$data['promo'] = array('code' => $promo_code, 'discount' => number_format($discount, 2, ',', ''), 'total' => number_format($discounted_total, 2, ',', ''));
										}
									}
								}

								break;
							}
						case VOUCHER_ATTACHED_PRODUCT_FLAT: {
								$cart_total = $data['total'];
								$product = $this->sm->getShopItemById($promo->product_id);
								if ($product != false) {

									foreach ($data['cartitems'] as $cart_item) {
										if ($cart_item['id'] == $promo->product_id) {

											$discount_per_item = $promo->discount;
											$discount = $cart_item['qty'] * $discount_per_item;
											$this->session->set_userdata('promo_discount', $discount);
											$discounted_total = $cart_total - $discount;
											$data['promo'] = array('code' => $promo_code, 'discount' => number_format($discount, 2, ',', ''), 'total' => number_format($discounted_total, 2, ',', ''));
										}
									}
								}
								break;
							}
						case VOUCHER_FREE_EXTRA_PRODUCT: {

								$cart_total = $discounted_total = $data['total'];
								$discount = 0;
								$product = $this->sm->getShopItemById($promo->product_id);
								if ($product != false) {
									$this->session->set_userdata('promo_discount', 0);
									$this->session->set_userdata('promo_free_item', $product->id);
									$name = $product->name . '(Free)';
									$description = $product->description;
									$type = 'free_product';
									if ($this->language == SECOND_LANGUAGE) {
										$name = $product->name_en . '(Free)';
										$description = $product->description_en;
									}

									$gross = number_format(0, 2, '.', '');
									$tax = 0;
									$cart_ids = array();
									foreach ($data['cartitems'] as $cart_item) {
										if (!in_array($cart_item['id'], $cart_ids)) {
											$cart_ids[] = $cart_item['id'];
										}
									}

									$can_add = false;

									if (!in_array($promo->product_id, $cart_ids)) {
										$can_add = true;
									} else {
										$types_counter = 0;
										foreach ($data['cartitems'] as $cart_item) {
											if ($cart_item['options']['category'] == 'free_product') {
												$types_counter++;
											}
										}

										if ($types_counter < 1) {
											$can_add = true;
										}
									}

									if ($can_add) {
										$data = array(
											'id' => $product->id,
											'qty' => 1,
											'price' => $gross,
											'name' => $name,
											'options' => array(
												'desc' => $product->description_en,
												'price_net' => $product->price_net,
												'price_tax' => $tax,
												'category' => $type,
											),
										);

										$this->cart->product_name_rules = '[:print:]';
										$this->cart->insert($data);
									}


									$data['promo'] = array('code' => $promo_code, 'discount' => number_format($discount, 2, ',', ''), 'total' => number_format($discounted_total, 2, ',', ''));
								}


								break;
							}
					}
				}
			}
		} else {
		}

		$data['cartitems'] = $this->cart->contents();

		$data['total'] = $this->cart->total();

		$data['cart_num'] = $this->cart->total_items();
		$footer_array = array();
		$data['footer'] = $footer_array;

		$this->load_view('shop/cart_view', $data);
	}


	public function sixCurl($endpoint, $payload)
	{
		$url = $this->six_url . $endpoint;

		//$username and $password for the http-Basic Authentication
		//$url is the SaferpayURL eg. https://www.saferpay.com/api/Payment/v1/PaymentPage/Initialize
		//$payload is a multidimensional array, that assembles the JSON structure. Example see above
		//Set Options for CURL
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		//Return Response to Application
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//Set Content-Headers to JSON
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json", "Accept: application/json; charset=utf-8"));
		//Execute call via http-POST
		curl_setopt($curl, CURLOPT_POST, true);
		//Set POST-Body
		//convert DATA-Array into a JSON-Object
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
		//WARNING!!!!!
		//This option should NOT be "false", otherwise the connection is not secured
		//You can turn it of if you're working on the test-system with no vital data
		//PLEASE NOTE:
		//Under Windows (using WAMP or XAMP) it is necessary to manually download and save the necessary SSL-Root certificates!
		//To do so, please visit: http://curl.haxx.se/docs/caextract.html and Download the .pem-file
		//Then save it to a folder where PHP has write privileges (e.g. the WAMP/XAMP-Folder itself)
		//and then put the following line into your php.ini:
		//curl.cainfo=c:\path\to\file\cacert.pem
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		//HTTP-Basic Authentication for the Saferpay JSON-API.
		//This will set the authentication header and encode the password & username in Base64 for you
		curl_setopt($curl, CURLOPT_USERPWD, $this->six_user . ":" . $this->six_pw);
		//CURL-Execute & catch response
		$jsonResponse = curl_exec($curl);
		//Get HTTP-Status
		//Abort if Status != 200
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($status != 200) {
			//IF ERROR
			//Get http-Body (if aplicable) from CURL-response
			$body = json_decode(curl_multi_getcontent($curl), true);
			//Build array, containing the body (Response data, like Error-messages etc.) and the http-status-code
			$response = array(
				"status" => $status,
				"body" => $body
			);
		} else {
			//IF OK
			//Convert response into an Array
			$body = json_decode($jsonResponse, true);
			//Build array, containing the body (Response-data) and the http-status-code
			$response = array(
				"status" => $status,
				"body" => $body
			);
		}
		//IMPORTANT!!!
		//Close connection!
		curl_close($curl);
		//$response, again, is a multi-dimensional Array, containing the status-code ($response["status"]) and the API-response (if available) itself ($response["body"])


		//redirect($response['body']['RedirectUrl']);

		return $response;
	}


	public function billing_info()
	{
		if (get_cookie('cookie_warning') == true) {

			$data['show_warning'] = false;
		}
		$data['a_cookie'] = get_cookie('a_cookie') == true ? true : false;

		$data['lang'] = $this->language;


		$data['countries'] = $this->fm->getCountries($data['lang']);

		$user = false;
		if ($this->session->userdata('customer_logged_in')) {
			$user = $this->session->userdata('customer_logged_in');
		}

		if (!$user || $this->session->flashdata('street')) {
			$data['message_billing'] = $this->session->flashdata('message_billing');
			$data['reg_fail'] = $this->session->flashdata('reg_fail');
			$data['firstname'] = ($this->session->userdata('yearly_first')) ? $this->session->userdata('yearly_first') : $this->session->flashdata('firstname');
			$data['lastname'] = ($this->session->userdata('yearly_last')) ? $this->session->userdata('yearly_last') : $this->session->flashdata('lastname');
			$data['email'] = ($this->session->userdata('yearly_email')) ? $this->session->userdata('yearly_email') : $this->session->flashdata('email');
			$data['street'] = $this->session->flashdata('street');
			$data['street_nr'] = $this->session->flashdata('street_nr');
			$data['stair_door'] = $this->session->flashdata('stair_door');
			$data['zip'] = $this->session->flashdata('zip');
			$data['city'] = $this->session->flashdata('city');
			$data['country_select'] = $this->session->userdata('country');
			$data['phone'] = $this->session->userdata('phone');
			$data['uid'] = $this->session->flashdata('uid');
			$data['company'] = $this->session->flashdata('company');
		} else {
			$data['message_billing'] = '';
			$data['reg_fail'] = '';
			$data['firstname'] = $user->firstname;
			$data['lastname'] = $user->lastname;
			$data['email'] = $user->email;
			$data['street'] = $user->street;
			$data['street_nr'] = $user->street_number;
			$data['stair_door'] = $user->stair;
			$data['zip'] = $user->zip;
			$data['city'] = $user->city;
			$data['country_select'] = $user->country;
			$data['phone'] = $user->phone;
			$data['uid'] = '';
			$data['company'] = $user->company;
		}




		$data['cart_num'] = $this->cart->total_items();


		$this->load_view('shop/billing_info', $data);
	}


	public function checkout()
	{



		$cookie_lang = get_cookie('lang');
		if ($cookie_lang == null)
			$lang = MAIN_LANGUAGE;
		else
			$lang = $cookie_lang;

		if ($lang == SECOND_LANGUAGE) {
			$this->lang->load('frontend', 'english');
		} else {
			$this->lang->load('frontend', 'german');
		}


		$this->form_validation->set_rules('firstname', $this->lang->line('firstname'), 'required');
		$this->form_validation->set_rules('lastname', $this->lang->line('lastname'), 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('street', $this->lang->line('street'), 'required');
		$this->form_validation->set_rules('street_nr', $this->lang->line('street_nr'), 'required');
		$this->form_validation->set_rules('zip', $this->lang->line('zip'), 'required');
		$this->form_validation->set_rules('city', $this->lang->line('city'), 'required');
		$this->form_validation->set_rules('agb', $this->lang->line('agb'), 'required');
		$this->form_validation->set_rules('billing_country', $this->lang->line('country'), 'required');
		if ($this->input->post('billing_country') == "AT") {
			$this->form_validation->set_rules('billing_state', $this->lang->line('county'), 'required');
		}

		if ($lang == SECOND_LANGUAGE) {
			$this->form_validation->set_message('is_unique', 'The %s is already taken!');
			$this->form_validation->set_message('required', 'The %s field is required!');
		} else {
			$this->form_validation->set_message('is_unique', '%s ist schon registriert!');
			$this->form_validation->set_message('required', '%s ist verpflichtend!');
		}


		if ($this->form_validation->run() == true) {

			$user = false;
			if ($this->session->userdata('customer_logged_in')) {
				$user = $this->session->userdata('customer_logged_in');
			}

			if ($user != false) {
				$data['customer_id'] = $user->id;
			}

			$data['firstname'] = $this->input->post('firstname');
			$data['lastname'] = $this->input->post('lastname');
			$data['email']  = $this->input->post('email');
			$data['street'] = $this->input->post('street');
			$data['street_nr'] = $this->input->post('street_nr');
			$data['door_stair'] = $this->input->post('door_stair');
			$data['zip'] = $this->input->post('zip');
			$data['city'] = $this->input->post('city');
			$data['phone'] = $this->input->post('phone');
			$data['company'] = $this->input->post('company');
			$data['uid'] = $this->input->post('uid');
			$payment_type = $this->input->post('payment_type');

			$data['amount'] = $this->cart->total();

			//$data['newsletter'] = ($this->input->post('newsletter') !== NULL)? 1 : 0;


			$data['diff_delivery'] = ($this->input->post('diff_delivery') !== NULL) ? 1 : 0;
			$data['delivery_name'] = $this->input->post('delivery_name');

			$data['delivery_street'] = $this->input->post('street');
			$data['delivery_zip'] = $this->input->post('zip');
			$data['delivery_city'] = $this->input->post('city');
			$deliv_state = $this->input->post('delivery_state');
			$deliv_country = $this->input->post('delivery_country');

			if ($deliv_state != 0) {
				$data['delivery_country'] = $deliv_state;
			} else {
				$data['delivery_country'] = $deliv_country;
			}




			$data['paymentState'] = ORDER_STATUS_CREATED;

			$state = $this->input->post('billing_state');
			$data['land'] = $this->input->post('billing_country');



			$delivery_cost = 0;
			$mailcount = 0;
			$cart_items =  $this->cart->contents();


			$data['delivery_cost'] = $delivery_cost;


			/* GENERATE TREAT REDIRECT TOKEN*/
			$alphabet = implode(range('a', 'z')) . implode(range('A', 'Z')) . implode(range(0, 9));
			$alphabetLength = strlen($alphabet);

			$length = 32;

			$data['treat_redirect_token'] = "";

			for ($i = 0; $i < $length; $i++) {
				$randomKey = $this->getRandomInteger(0, $alphabetLength);
				$data['treat_redirect_token'] .= $alphabet[$randomKey];
			}

			$data['promo_code'] = ($this->session->userdata('promo_code') !== NULL) ?  $this->session->userdata('promo_code') : NULL;
			$data['discount'] =  ($this->session->userdata('promo_discount') !== NULL) ?  $this->session->userdata('promo_discount') : NULL;
			$data['free_product'] =  ($this->session->userdata('promo_free_item') !== NULL) ?  $this->session->userdata('promo_free_item') : NULL;




			$data['amount'] =  number_format($this->cart->total(), 2, '.', '');

			$last_id = $this->sm->insertShopOrder($data);

			/*BILL ID*/
			$order = $this->sm->getOrderByID($last_id);
			$max_invoice = $this->sm->getLatestInvoicenumber()->row()->bill_id;
			$max_yearly_invoice =  $this->sm->getLatestInvoicenumberYearly(date('Y', strtotime($order->order_date)));
			$new_yearly_invoice = $max_yearly_invoice + 1;


			if ($max_invoice == NULL)
				$new_invoice = 1;
			else
				$new_invoice = $max_invoice + 1;

			if ($max_yearly_invoice == NULL || $max_yearly_invoice == 0)
				$new_yearly_invoice = 1;
			else
				$new_yearly_invoice = $max_yearly_invoice + 1;


			$bill_year = date('y', strtotime($order->order_date));
			$bill_id = str_pad($new_yearly_invoice, 5, '0', STR_PAD_LEFT);

			$extref = 'EOH' . $bill_year . "-" . $bill_id;


			$total_sum =  number_format($this->cart->total(), 2, '.', '');

			/* PAyment needs the total in the smallest unit so cents in EUR */

			if ($data['discount'] == NULL) {
				$total_sum = $total_sum * 100;
			} else {
				$total_sum = ($total_sum - $data['discount']) * 100;
			}






			/* SIX PAYMENT PAGE*/

			$data['paymentUrl'] = "";
			$ip_address = $this->input->ip_address();
			$payer_email = $data['email'];

			$order_id = $last_id;


			$data['payment_url'] = $this->stripeInit($total_sum, $last_id, $data['treat_redirect_token']);



			$order_items = array();


			foreach ($cart_items as $item) {
				$desc = NULL;
				$order_items = array();
				$delivery = 0;
				$product = $this->sm->getShopItemById($item['id']);

				$product_name = $product->name;

				if ($lang == SECOND_LANGUAGE) {
					$product_name = $product->name_en;
				}

				switch ($item['options']['category']) {
					case 'free_product':
					case 'product': {
							$order_items = array(
								'order_id' => $last_id,
								'item_id' => $item['id'],
								'quantity' => $item['qty'],
								'price' => number_format($item['price'], 2, '.', ''),
								'tax' => $product->tax,
								'price_net' => $product->price_net,
								'desc' => $product_name,
								'delivery' => $delivery,
							);
						};
						break;
					case 'group':
					case 'ticket': {
							$order_items = array(
								'order_id' => $last_id,
								'item_id' => $item['id'],
								'quantity' => $item['qty'],
								'price' => number_format($item['price'], 2, '.', ''),
								'tax' => $product->tax,
								'price_net' => $product->price_net,
								'desc' => $product_name,
								'delivery' => $delivery,
							);
						};
						break;
				}



				$this->sm->insertShopOrderItems($order_items);
			}

			$delivery_cost = 0;
			$the_adress = $data['street'] . " " . $data['street_nr'] . " " . $data['door_stair'] . " " . $data['zip'] . " " . $data['city'];
			$data['agb'] = ($this->input->post('agb') !== NULL) ? 1 : 0;




			$this->checkout_view($data, $delivery_cost, $last_id, $the_adress);
		} else {
			$this->session->set_flashdata('reg_fail', true);
			$this->session->set_flashdata('message_billing', validation_errors());
			$this->session->set_flashdata('email', $this->input->post('email'));
			$this->session->set_flashdata('firstname', $this->input->post('firstname'));
			$this->session->set_flashdata('lastname', $this->input->post('lastname'));
			$this->session->set_flashdata('street', $this->input->post('street'));
			$this->session->set_flashdata('street_nr', $this->input->post('street'));
			$this->session->set_flashdata('stair_door', $this->input->post('door_stair'));
			$this->session->set_flashdata('zip', $this->input->post('zip'));
			$this->session->set_flashdata('city', $this->input->post('city'));
			$this->session->set_flashdata('country', $this->input->post('country'));
			$this->session->set_flashdata('phone', $this->input->post('phone'));
			$this->session->set_flashdata('company', $this->input->post('company'));
			$this->session->set_flashdata('uid', $this->input->post('uid'));

			redirect('billing_info');
		}
	}


	public function checkout_view($userdata, $delivery_cost, $order_id, $the_adress)
	{
		$data = array();

		$data['cartitems'] = $this->cart->contents();
		$data['delivery'] = $delivery_cost;

		if ($userdata['discount'] == NULL) {
			$data['requestParameters']["amount"] = number_format((float)$this->cart->total() + $delivery_cost, 2, '.', '');
		} else {
			$am = $this->cart->total() - $userdata['discount'];
			$data['requestParameters']["amount"] = number_format((float)$am + $delivery_cost, 2, '.', '');
		}

		$data['requestParameters']["currency"] = "EUR";

		$description = $userdata['firstname'] . " " . $userdata['lastname'] . ", " . $the_adress;
		$data['requestParameters']["orderDescription"] = $description;

		// sets your custom request parameters
		$data['requestParameters']["order_id"] = $order_id;
		$data['requestParameters']["delivery_cost"] = $delivery_cost;
		$data['requestParameters']["base_val"] = $this->cart->total();
		$data['requestParameters']["billing_info"] = $userdata['firstname'] . " " . $userdata['lastname'] . ", " . $the_adress;

		$data['paymentTypes'] = array();

		$update_data = array('paymentState' => ORDER_STATUS_INITIATED, 'state_change' => date('Y-m-d H:i:s'));
		$this->sm->updateOrderStatus($order_id, $update_data);




		if (get_cookie('cookie_warning') == true) {

			$data['show_warning'] = false;
		}

		$data['a_cookie'] = get_cookie('a_cookie') == true ? true : false;
		$data['lang'] = $this->language;
		$data['mainmenu'] = array();


		$data['userdata'] = $userdata;

		$data['cart_num'] = $this->cart->total_items();

		$data['footer'] = array();

		$this->load_view('shop/checkout', $data);
	}




	public function clearCart()
	{
		$this->removePromoCode();
		$this->cart->destroy();
	}

	public function getCartItemCount($message = '')
	{
		echo json_encode(array(
			'success' => true,
			'message' => $message,
			'count' => $this->cart->total_items()
		));
	}

	public function getCartTotal()
	{
		return number_format((float)$this->cart->total(), 2, '.', '');
	}

	public function removeFromCart()
	{
		$rowId = $this->input->post('rowId');
		$remove_array = array();

		$this->cart->remove($rowId);

		$this->session->set_userdata('orderIdent', '');
		$this->session->set_userdata('storageId', '');


		echo json_encode(array(
			'success' => true,
			'rowid' => $rowId,
			'count' => 0,
			'total' => $this->getCartTotal(),
		));
	}

	public function addToCart()
	{
		$productId = $_POST['sid'];
		$qty = $_POST['qty'];
		$type = $_POST['type'];

		$product = $this->sm->getShopItemById($productId);

		if (!$product) {
			//var_dump('No product');
		} else {
			$name = $product->name;
			$description = $product->description;

			if ($this->language == SECOND_LANGUAGE) {
				$name = $product->name_en;
				$description = $product->description_en;
			}

			$gross = number_format($product->price_net + ($product->price_net * ($product->tax / 100)), 2, '.', '');
			$tax = $product->price_net * ($product->tax / 100);

			$data = array(
				'id' => $productId,
				'qty' => $qty,
				'price' => $gross,
				'name' => $name,
				'options' => array(
					'desc' => $product->description_en,
					'price_net' => $product->price_net,
					'price_tax' => $tax,
					'category' => $type,
				),
			);
			$this->cart->product_name_rules = '[:print:]';
			$this->cart->insert($data);


			$this->session->set_userdata('orderIdent', '');
			$this->session->set_userdata('storageId', '');

			$this->getCartItemCount('Added to cart');
		}
	}


	public function updateItemCartQty()
	{
		$rowId = $this->input->post('rowId');
		$change = $this->input->post('change');

		$cartrow = $this->cart->get_item($rowId);

		$this->cart->update(array(
			'rowid' => $rowId,
			'qty' => $cartrow['qty'] + $change,
		));

		$this->session->set_userdata('orderIdent', '');
		$this->session->set_userdata('storageId', '');



		echo json_encode(array(
			'success' => true,
			'rowid' => $rowId,
			'count' => $cartrow['qty'] + $change,
			'price' => number_format((float)($cartrow['qty'] + $change) * $cartrow['price'], 2, '.', ''),
			'price_net' => number_format((float)($cartrow['qty'] + $change) * $cartrow['options']['price_net'], 2, '.', ''),
			'price_tax' => number_format((float)($cartrow['qty'] + $change) * $cartrow['options']['price_tax'], 2, '.', ''),
			'total' => $this->getCartTotal(),
		));
	}




	public function success()
	{
		$msg = $this->lang->line('paymentresult_success');
		$this->cart->destroy();

		$this->shop_response($msg);
	}

	public function notification()
	{
		//Not needed in Stripe
		exit;
		$treat_token = (isset($_GET['t'])) ? $_GET['t'] : NULL;
		$order_id = (isset($_GET['o'])) ? $_GET['o'] : NULL;

		$can_proceed = false;
		$update_data = array('paymentState' => ORDER_STATUS_NOTIFICATION_CALLED);
		$this->sm->updateOrderStatus($order_id, $update_data);
		if ($treat_token == NULL || $order_id == NULL) {

			$msg = 'TOKEN NOT FOUND';
		} else {

			$order = $this->sm->getOrderByID($order_id);

			if (!$order || ($order->treat_redirect_token != $treat_token)) {

				$msg = "TOKEN MISMATCH";
			} else {
				/* Request the state of the payment from Six*/
				$payload = array(
					'RequestHeader' => array(
						'SpecVersion' => "1.7",
						'CustomerId' => $this->six_client,
						'RequestId' => $order->treat_redirect_token,
						'RetryIndicator' => 0,
						'ClientInfo' => array(
							'ShopInfo' => "HdGÖ Webshop"
						)
					),
					'Token' => $order->six_payment_token
				);

				$endpoint = "Payment/v1/PaymentPage/Assert";

				$response = $this->sixCurl($endpoint, $payload);


				if ($response['status'] == 200) {
					$six_transaction_id = $response['body']['Transaction']['Id'];
					$six_transaction_status = $response['body']['Transaction']['Status'];


					if ($six_transaction_status == "AUTHORIZED") {
						$update_data = array('transaction_id' => $six_transaction_id, 'order_data' => json_encode($response), 'paymentState' => ORDER_STATUS_NOTIFICATION_ASSERT_SUCCESS);
						$this->sm->updateOrderStatus($order_id, $update_data);


						/* INIT CAPTURE of the Authorized Payment*/
						$capture_payload = array(
							'RequestHeader' => array(
								'SpecVersion' => "1.7",
								'CustomerId' => $this->six_client,
								'RequestId' => $order->treat_redirect_token,
								'RetryIndicator' => 0
							),
							'TransactionReference' => array(
								'TransactionId' => $six_transaction_id
							)
						);

						$capture_endpoint = "Payment/v1/Transaction/Capture";

						$capture_response = $this->sixCurl($capture_endpoint, $capture_payload);


						if ($capture_response['status'] == 200) {
							$update_data = array('paymentState' => ORDER_STATUS_NOTIFICATION_CAPTURE_SUCCESS);
							$this->sm->updateOrderStatus($order_id, $update_data);
							$can_proceed = true;
						} else {
							$update_data = array('paymentState' => ORDER_STATUS_NOTIFICATION_CAPTURE_FAIL);
							$this->sm->updateOrderStatus($order_id, $update_data);

							$msg = $capture_response['body']['ErrorMessage'];
						}
					} elseif ($six_transaction_status == "CAPTURED") {
						$update_data = array('transaction_id' => $six_transaction_id, 'order_data' => json_encode($response), 'paymentState' => ORDER_STATUS_SUCCESS);
						$this->sm->updateOrderStatus($order_id, $update_data);
						$can_proceed = true;
					}
				} else {
					/* SIX ERROR*/
					$update_data = array('order_data' => json_encode($response), 'paymentState' => ORDER_STATUS_NOTIFICATION_ASSERT_FAIL);
					$this->sm->updateOrderStatus($order_id, $update_data);

					$msg = response['body']['ErrorMessage'];
				}
			}



			if ($can_proceed) {





				$order = $this->sm->getOrderByID($order_id);

				if ($order->sent == 1) {
					redirect('');
				}

				$max_invoice = $this->sm->getLatestInvoicenumber()->row()->bill_id;
				$max_yearly_invoice =  $this->sm->getLatestInvoicenumberYearly(date('Y', strtotime($order->order_date)));
				$new_yearly_invoice = $max_yearly_invoice + 1;


				if ($max_invoice == NULL)
					$new_invoice = 1;
				else
					$new_invoice = $max_invoice + 1;

				if ($max_yearly_invoice == NULL || $max_yearly_invoice == 0)
					$new_yearly_invoice = 1;
				else
					$new_yearly_invoice = $max_yearly_invoice + 1;



				//$cart_items = $this->cart->contents();
				$cart_items = $this->sm->getOrderItemsByID($order_id);

				$reduced_tickets = 0;
				$adult_tickets = 0;
				$group_tickets = 0;
				$senior_tickets = 0;
				$oe1_club_tickets = 0;

				$family_card_children = 0;
				$yearly_card = 0;

				$yearly_birthday = '';
				$yearly_email = '';
				$yearly_firstname = '';
				$yearly_lastname = '';
				$yearly_array = array();

				foreach ($cart_items as $item) {
					$product = $this->sm->getShopItemById($item->item_id);

					if ($product->is_ticket) {
						// Erm��igt
						if ($product->id == 3) {
							$reduced_tickets += $item->quantity;
						}
						// Erwachsene
						else if ($product->id == 4) {
							$adult_tickets += $item->quantity;
						}
						// SeniorInnen
						else if ($product->id == 5) {
							$senior_tickets += $item->quantity;
						}
						// �1-Clubmitglieder, CLUB WIEN
						else if ($product->id == 6) {
							$oe1_club_tickets += $item->quantity;
						}
						// Familien-Karte (2 Erwachsene mit mind. einem Kind unter 19 J.)
						else if ($product->id == 7) {
							$family_card_children = $item->family_children_count;
						}
						// Jahreskarte
						else if ($product->id == 8) {
							$yearly_card += $item->quantity;
							$yearly_item = array(
								'qty' => $item->quantity,
								'birthday' => $item->yearly_ticket_birthday,
								'email' => $item->yearly_ticket_email,
								'firstname' => $item->yearly_ticket_firstname,
								'lastname' => $item->yearly_ticket_lastname
							);


							$yearly_array[] = $yearly_item;


							/* $yearly_birthday = $item['options']['birthday'];
											 $yearly_email = $item['options']['email'];
											 $yearly_firstname = $item['options']['firstname'];
											 $yearly_lastname = $item['options']['lastname'];*/
						}
						// Gruppe
						else if ($product->id == 9) {
							$group_tickets += $item->quantity;
						}
					}
				}

				$amephias_response = '';
				$has_ticket = false;
				$has_yearly = false;
				$bill_year = date('y', strtotime($order->order_date));
				$bill_id = str_pad($new_yearly_invoice, 5, '0', STR_PAD_LEFT);

				$extref = 'EOH' . $bill_year . "-" . $bill_id;

				if ($adult_tickets > 0 || $reduced_tickets > 0 || $senior_tickets > 0 || $oe1_club_tickets > 0 || $family_card_children > 0 || $group_tickets > 9) {
					$has_ticket = true;

					if ($yearly_card > 0) {
						$has_yearly = true;
						$amephias_response = $this->bookTicketAmephias($order_id, $extref, $adult_tickets, $reduced_tickets, $senior_tickets, $oe1_club_tickets, $family_card_children, $group_tickets, true, $yearly_array, $order->land /*$yearly_birthday, $yearly_email, $yearly_firstname, $yearly_lastname*/);
					} else {
						$amephias_response = $this->bookTicketAmephias($order_id, $extref, $adult_tickets, $reduced_tickets, $senior_tickets, $oe1_club_tickets, $family_card_children, $group_tickets, false, $yearly_array, $order->land);
					}
				}

				if ($yearly_card > 0 && $adult_tickets == 0 && $reduced_tickets == 0 && $senior_tickets == 0 && $oe1_club_tickets == 0 && $family_card_children == 0 && $group_tickets < 10) {
					$has_ticket = true;
					$has_yearly = true;
					$amephias_response = $this->bookTicketAmephiasYearly($order_id, $extref, $yearly_array, $order->land /*$yearly_birthday, $yearly_email, $yearly_firstname, $yearly_lastname*/);
				}

				//var_dump($amephias_response);



				if ($order != false && $order->sent == 0) {
					$update_data = array('paymentState' => ORDER_STATUS_SUCCESS, 'state_change' => date('Y-m-d H:i:s'), 'bill_id' => $new_invoice, 'yearly_bill_id' => $new_yearly_invoice, 'order_data' => $decoded_response, 'sent' => 1, 'barcode' => $amephias_response);
					$this->sm->updateOrderStatus($order_id, $update_data);
					$this->createXML($order_id);

					$this->create_pdf_bill($order_id);


					$this->sendOrderConfirmation($order_id, $amephias_response, $has_ticket);
					$this->sendOrderCustomer($order_id, $amephias_response, $has_ticket, $has_yearly);
				}

				if ($amephias_response != 'Error') {
					$msg = $this->lang->line('paymentresult_success') . "<br/><br/>" . $this->lang->line('paymentresult_success2') . $extref . "<br/>" . $this->lang->line('paymentresult_success3');
				} else {
					$msg = $this->lang->line('amephias_error');
				}
			}
		}
	}


	public function cancel()
	{


		$msg = $this->lang->line('paymentresult_cancel');

		$this->shop_response($msg);
	}

	public function error()
	{

		$order_id = $_GET['o'];
		$treat_token = $_GET['t'];

		$order = $this->sm->getOrderByID($order_id);

		if ($order->language != NULL) {
			if ($order->language == SECOND_LANGUAGE) {
				$this->lang->load('frontend', 'english');
			} else {
				$this->lang->load('frontend', 'german');
			}
		}


		if ($treat_token == $order->treat_redirect_token) {
			$update_data = array('paymentState' => ORDER_STATUS_FAILURE, 'state_change' => date('Y-m-d H:i:s'));
			$this->sm->updateOrderStatus($order_id, $update_data);
		}


		$msg = $this->lang->line('paymentresult_failure');

		$this->shop_response($msg);
	}

	public function pending()
	{
		$msg = $this->lang->line('paymentresult_pending');
		$this->cart->destroy();
		$this->shop_response($msg);
	}

	public function shop_response($msg)
	{
		if (get_cookie('cookie_warning') == true) {

			$data['show_warning'] = false;
		}

		$data['lang'] = $this->language;
		$data['mainmenu'] = array();


		$data['menus'] = array();



		$data['cart_num'] = $this->cart->total_items();
		$data['msg'] = $msg;

		$footer_array = array();
		$data['footer'] = $footer_array;


		$this->load_view('shop/response', $data);
	}


	public function sendOrderConfirmation($order_id, $amephias_response, $has_ticket)
	{

		require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPDebug = 0;  // prefix for secure protocol to connect to the server
		$mail->SMTPAuth   = true; // enabled SMTP authentication
		$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
		$mail->Host       = "smtp.office365.com";      // setting SMTP server
		$mail->Port       = 587;                   // SMTP port to connect to
		$mail->Username   = "infohdgoe@onb.ac.at";  // user email address
		$mail->Password   = "Bibliothek2018";            // password

		$mail->SetFrom('info@hdgoe.at');  //Who is sending the email
		$mail->AddReplyTo('noreply@hdgoe.at');  //email address that receives the response
		$mail->IsSMTP();

		$subject = 'Eine neue Bestellung ist eingetroffen!';
		$data = array();

		$order = $this->sm->getOrderByID($order_id);

		if ($order != false) {
			$items = $this->sm->getOrderItemsByID($order->id);
			$data['items'] = $items;
			$data['order'] = $order;


			$body =  $this->load->view('shop/mail_shop', $data, TRUE);

			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->isHTML(true);


			$mail->AddAddress('shop@hdgoe.at', '');
			// $mail->AddAddress('peter@treat.agency', '');

			if (!$mail->Send()) {
				/* echo 'Confirmation Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;*/
			} else {
				// echo 'Message has been sent';
			}
		}
	}


	public function sendOrderCustomer($order_id)
	{
		require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPDebug = 0;  // prefix for secure protocol to connect to the server
		$mail->SMTPAuth   = true; // enabled SMTP authentication
		$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
		$mail->Host       = "smtp.office365.com";      // setting SMTP server
		$mail->Port       = 587;                   // SMTP port to connect to
		$mail->Username   = "infohdgoe@onb.ac.at";  // user email address
		$mail->Password   = "Bibliothek2018";            // password

		$mail->SetFrom('info@hdgoe.at');  //Who is sending the email
		$mail->AddReplyTo('noreply@hdgoe.at');  //email address that receives the response
		$mail->IsSMTP();

		$subject = 'Ihre Bestellung auf hdgoe.at';
		$data = array();

		$order = $this->sm->getOrderByID($order_id);

		if ($order != false) {
			$items = $this->sm->getOrderItemsByID($order->id);
			$data['items'] = $items;
			$data['order'] = $order;
			$body =  $this->load->view('shop/mail_customer', $data, TRUE);

			$this->create_pdf_bill_mail($order->id);
			$mail->AddAttachment(getcwd() . '/items/uploads/pdfs/order_' . $order->id . '.pdf', $this->bill_prefix . date('y', strtotime($order->order_date)) . '-' . $order->yearly_bill_id . '.pdf', 'base64', 'application/pdf');

			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->isHTML(true);


			// $mail->AddAddress('peter@treat.agency', '');
			$mail->AddAddress($order->email, '');

			if (!$mail->Send()) {
				//echo 'Customer Message could not be sent.';
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
				unlink($_SERVER["DOCUMENT_ROOT"] . 'items/uploads/pdfs/order_' . $order->id . '.pdf');
			} else {
				// echo 'Message has been sent '. $mail->ErrorInfo;

				unlink($_SERVER["DOCUMENT_ROOT"] . 'items/uploads/pdfs/order_' . $order->id . '.pdf');
			}

			$update_data = array('mail_error' => $mail->ErrorInfo);
			$this->sm->updateOrderStatus($order_id, $update_data);
		}
	}

	public function create_pdf_mail_new($barcode, /*$order_data,*/ $items, $lang, $pdfame, $order, $yearly_ticket = false)
	{
		/* $barcode = 218200000396;
		$lang = MAIN_LANGUAGE;
		$items = $this->sm->getOrderItemsByID(1056);
		$order = $this->sm->getOrderByID(1056);
		$pdfname = 'testingpdf';*/
		//$items = $this->sm->getOrderItemsByID($order_data->id);
		$total_gross = 0;

		$bill_year = date('y', strtotime($order->order_date));
		$bill_id = str_pad($order->yearly_bill_id, 5, '0', STR_PAD_LEFT);

		$extref = 'EOH' . $bill_year . "-" . $bill_id;

		$yearly_fn = '';
		$yearly_ln = '';
		$yearly_bday = '';
		$yearly_email = '';
		$show_yearly_name = false;

		foreach ($items as $item) {
			if ($item->is_ticket == 1 && $item->item_id == 4) {
				$item_net = 1 * $item->price_net;
				$item_sum = number_format($item_net, 2) + number_format(($item_net * ($item->tax / 100)), 2);
				$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc);
				if ($item->item_id == 4 && $item->quantity == 1) {
					$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc) . "r";
				}

				$data[] = array(1, $desc/*."(� ".number_format($item->price,2,',', ' ').")"*/, $item_sum, $item->tax);
				$total_gross += $item_sum;
			} elseif ($item->is_ticket == 1 && $item->item_id != 8 && $item->item_id != 4) {
				$item_net = $item->quantity * $item->price_net;
				$item_sum = number_format($item_net, 2) + number_format(($item_net * ($item->tax / 100)), 2);
				$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc);
				if ($item->item_id == 4 && $item->quantity == 1) {
					$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc) . "r";
				}

				$data[] = array($item->quantity, $desc/*."(� ".number_format($item->price,2,',', ' ').")"*/, $item_sum, $item->tax);
				$total_gross += $item_sum;
			}

			if ($item->item_id == 8) {
				$yearly_fn = $item->yearly_ticket_firstname;
				$yearly_ln = $item->yearly_ticket_lastname;
				$yearly_bday = $item->yearly_ticket_birthday;
				$yearly_email = $item->yearly_ticket_email;
				$show_yearly_name = true;
			}
		}

		$url = getcwd() . '/items/uploads/pdfs/' . $pdfame . '.pdf';
		$usage_image = getcwd() . '/items/frontend/img/ticket_use.jpg';
		$ticket_logo = getcwd() . '/items/frontend/img/ticket_logo_new.jpg';
		require_once(APPPATH . 'libraries/tfpdf.php');

		//define the path to the .ttf files you want to use
		define('FPDF_FONTPATH', APPPATH . 'libraries/font/');


		$pdf = new tFPDF();

		// Add Unicode fonts (.ttf files)
		$fontName = 'equitan';

		$pdf->AddFont($fontName, '', 'equitan_sans_regular-webfont.php');
		$pdf->AddFont($fontName, 'B', 'equitan_sans_bold-webfont.php');
		$pdf->footer = 0;
		$pdf->AliasNbPages();
		$pdf->AddPage('P');





		/* TOP LEFT */

		$pdf->Image($ticket_logo, 60, 10, 35, 35, 'JPG');

		$pdf->SetFont($fontName, '', 12);
		$pdf->SetXY(15, 100);
		$pdf->MultiCell(70, 6, iconv('UTF-8', 'windows-1252', 'Haus der Geschichte Österreich Österreichische Nationalbibliothek Heldenplatz - Neue Burg, Wien'), 0, 'L', false);
		$pdf->SetX(15);
		$pdf->MultiCell(55, 6, 'Tel: +43 1 534 10 - 805', 0, 'L', false);
		$pdf->SetX(15);
		$pdf->MultiCell(55, 6, 'office@hdgoe.at', 0, 'L', false);
		$pdf->SetX(15);
		$pdf->MultiCell(55, 6, 'www.hdgoe.at', 0, 'L', false);

		/* TOP RIGHT */

		$pdf->SetXY(115, 40);
		$pdf->SetFont($fontName, '', 14);

		if (!$yearly_ticket) {
			$pdf->Cell(40, 4, 'Eintritt', 0, 0, 'L');
		} else {
			$pdf->Cell(40, 4, 'Jahreskarte', 0, 0, 'L');
		}
		$pdf->SetXY(115, 45);
		$pdf->SetFont($fontName, 'B', 36);
		$pdf->MultiCell(62, 12, iconv('UTF-8', 'windows-1252', 'Haus der Geschichte Österreich'), 0, 'L', false);
		//$pdf->SetDash(0,0); //5mm on, 5mm off
		//$pdf->SetDrawColor(0,0,0);
		$pdf->SetLineWidth('3');
		$pdf->Line(118, 83, 170, 83);

		/**  ITEMS TABLE **/

		$pdf->SetXY(70, 87);
		$pdf->SetFont($fontName, '', 14);
		$pdf->SetDrawColor(0);

		// Column widths
		$w = array(10, 70, 20, 30);

		// Header

		$pdf->SetFont($fontName, '', 12);

		foreach ($data as $row) {

			$pdf->SetX(115);
			$pdf->MultiCell(100, 5, $row[0] . ' ' . $row[1], '', 'L');
			/* $pdf->SetX(115);
		   $pdf->Cell(40,4,iconv('UTF-8', 'windows-1252', 'Gültig bis ').date("d. m. Y", strtotime("+6 month")),0,0,'L');*/
			$pdf->Ln();
			$pdf->SetX(115);
			$pdf->MultiCell(100, 5, 'EUR ' . number_format($row[2], 2, ',', ' ') . ' (inkl. ' . $row[3] . '% MwSt.)', '', 'L');

			/*
			$description = $row[1];
			$column_width = $w[1];
			$total_string_width = $pdf->GetStringWidth($description);
			$number_of_lines = $total_string_width / ($column_width );

			$number_of_lines = ceil( $number_of_lines );
			$line_height = 6;
			$height_of_cell = $number_of_lines * $line_height;
			$height_of_cell = ceil( $height_of_cell );

			$x = $pdf->GetX();
			$y = $pdf->GetY();

			$pdf->MultiCell($w[0],$line_height,$row[0],'','L');
			$x += $w[0];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[1],$line_height,$row[1],'','L');
			$x += $w[1];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[2],$line_height,'� '.number_format($row[2],2,',', ' '),'','L');
			$x += $w[2];




			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[3],$line_height,'inkl. '.$row[3].'% Mwst','','C');

			$pdf->SetXY(70, $y+$height_of_cell);*/
		}
		/*  $pdf->SetLineWidth(0.1);
			$pdf->setDrawColor(0);
			$currentY = $pdf->getY();
			$pdf->Line($leftMargin,$currentY,196,$currentY);
		*/

		$pdf->SetFont($fontName, '', 10);

		$pdf->SetXY(115, 132);
		if (!$yearly_ticket) {
			$pdf->MultiCell(100, 4, 'Berechtigt zum einmaligen Eintritt', '', 'L');
		} else {
			$pdf->MultiCell(100, 4, iconv('UTF-8', 'windows-1252', 'Gültig bis ') . date("d. m. Y", strtotime("+12 month")), '', 'L');
		}

		$pdf->SetX(115);
		$pdf->MultiCell(100, 4, 'Kaufdatum: ' . date('d.m.Y', strtotime($order->order_date)), '', 'L');

		/* BOTTOM LEFT */


		$pdf->SetFont($fontName, '', 12);
		$pdf->SetLineWidth('1');
		$pdf->Line(16, 160, 95, 160);
		$pdf->SetXY(15, 164);
		$pdf->MultiCell(85, 5, iconv('UTF-8', 'windows-1252', 'Ihre persönliche Grußkarte aus dem Haus der Geschichte Österreich unter postkarte.hdgoe.at. Postkarten-App herunterladen und echte Postkarten gratis verschicken! Gutscheincode erhältlich am Welcome Desk (Mezzanin) direkt beim Eingang zur Ausstellung!'), 0, 'L', false);
		$pdf->Line(16, 198, 95, 198);

		$pdf->SetFont($fontName, '', 10);
		$pdf->SetXY(15, 203);
		$pdf->MultiCell(85, 4, iconv('UTF-8', 'windows-1252', 'Der Eintritt in das Haus der Geschichte Österreich inkludiert den Besuch des Ephesos Museums.'), 0, 'L', false);

		if ($show_yearly_name) {

			$pdf->SetXY(15, 225);
			$pdf->Cell(30, 4, $yearly_fn . " " . $yearly_ln, 0, 0, 'L');
			$pdf->Ln();
			$pdf->SetX(15);
			$pdf->Cell(30, 4, date('d.m.Y', strtotime($yearly_bday)), 0, 0, 'L');
			$pdf->Ln();
			$pdf->SetX(15);
			$pdf->Cell(30, 4, $yearly_email, 0, 0, 'L');
		}

		$pdf->SetXY(15, 250);
		$pdf->Cell(30, 4, 'Ticketnummer ' . $barcode, 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX(15);
		$pdf->Cell(30, 4, 'Auftrag ' . $extref, 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX(15);
		$pdf->Cell(30, 4, 'UID-Nummer: ATU54091307', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX(15);
		$pdf->Cell(30, 4, 'FBG: Handelsgericht Wien: FN 221029v', 0, 0, 'L');




		/* BOTTOM RIGHT */


		$pdf->i25(120, 160, $barcode, 1.5, 18);
		$pdf->Image($usage_image, 143, 190, 30, 58, 'JPG');






		/*	$pdf->SetXY(70,124);
		$pdf->SetFont($fontName,'',22);
		$pdf->Cell(40,4,'Regul�r: Erwachsener',0,0,'L');
		$pdf->SetXY(70,134);
		$pdf->Cell(40,4,'G�ltig bis '.date("d. m. Y", strtotime("+6 month")),0,0,'L');
		$pdf->SetXY(70,143);
		$pdf->SetFont($fontName,'',10);
		$pdf->Cell(40,4,'� '.number_format($order_data->amount,2,',', ' ').' (inkl. 10%  Mwst.)',0,0,'L');
		*/

		/* Dashed lines */
		$pdf->SetLineWidth(0.1);
		$pdf->SetDash(3, 5); //5mm on, 5mm off
		$pdf->Line(105, 0, 105, 297);
		$pdf->Line(0, 148, 210, 148);



		//$pdf->Output('test.pdf', 'D');
		$pdf->Output($url, 'F');
	}


	public function create_pdf_mail($barcode, /*$order_data,*/ $items, $lang, $pdfame)
	{

		//$items = $this->sm->getOrderItemsByID($order_data->id);
		$total_gross = 0;


		foreach ($items as $item) {
			if ($item->is_ticket == 1 && $item->item_id == 4) {
				$item_net = 1 * $item->price_net;
				$item_sum = number_format($item_net, 2) + number_format(($item_net * ($item->tax / 100)), 2);
				$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc);
				if ($item->item_id == 4 && $item->quantity == 1) {
					$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc) . "r";
				}

				$data[] = array(1, $desc . "(� " . number_format($item->price, 2, ',', ' ') . ")", $item_sum, $item->tax);
				$total_gross += $item_sum;
			} elseif ($item->is_ticket == 1 && $item->item_id != 8 && $item->item_id != 4) {
				$item_net = $item->quantity * $item->price_net;
				$item_sum = number_format($item_net, 2) + number_format(($item_net * ($item->tax / 100)), 2);
				$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc);
				if ($item->item_id == 4 && $item->quantity == 1) {
					$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc) . "r";
				}

				$data[] = array($item->quantity, $desc . "(� " . number_format($item->price, 2, ',', ' ') . ")", $item_sum, $item->tax);
				$total_gross += $item_sum;
			}
		}

		$url = getcwd() . '/items/uploads/pdfs/' . $pdfame . '.pdf';
		$side_image = getcwd() . '/items/frontend/img/side_img.jpg';
		$ticket_logo = getcwd() . '/items/frontend/img/ticket_logo.jpg';
		require_once(APPPATH . 'libraries/tfpdf.php');

		//define the path to the .ttf files you want to use
		define('FPDF_FONTPATH', APPPATH . 'libraries/font/');


		$pdf = new tFPDF();

		// Add Unicode fonts (.ttf files)
		$fontName = 'equitan';

		$pdf->AddFont($fontName, '', 'equitan_sans_regular-webfont.php');
		$pdf->AddFont($fontName, 'B', 'equitan_sans_bold-webfont.php');

		$pdf->AliasNbPages();
		$pdf->AddPage('P');


		$pdf->Image($side_image, 0, 0, 63, 297, 'JPG');
		$pdf->Image($ticket_logo, 170, 20, 20, 15, 'JPG');
		$pdf->i25(152, 262, $barcode, 1, 15);


		$pdf->SetXY(70, 60);
		$pdf->SetFont($fontName, '', 22);
		$pdf->Cell(40, 4, 'Eintritt', 0, 0, 'L');
		$pdf->SetXY(70, 70);
		$pdf->SetFont($fontName, 'B', 36);
		$pdf->MultiCell(62, 15, 'Haus der Geschichte �sterreich', 0, 'L', false);

		$pdf->SetDrawColor(0, 0, 0);
		$pdf->SetLineWidth('3');
		$pdf->Line(72, 118, 125, 118);

		/**  ITEMS TABLE **/

		$pdf->SetXY(70, 124);
		$pdf->SetFont($fontName, '', 14);
		$pdf->SetDrawColor(0);

		// Column widths
		$w = array(10, 70, 20, 30);

		// Header

		$pdf->SetFont($fontName, '', 12);

		foreach ($data as $row) {

			$pdf->SetX(70);

			$description = $row[1];
			$column_width = $w[1];
			$total_string_width = $pdf->GetStringWidth($description);
			$number_of_lines = $total_string_width / ($column_width);

			$number_of_lines = ceil($number_of_lines);
			$line_height = 6;
			$height_of_cell = $number_of_lines * $line_height;
			$height_of_cell = ceil($height_of_cell);

			$x = $pdf->GetX();
			$y = $pdf->GetY();

			$pdf->MultiCell($w[0], $line_height, $row[0], '', 'L');
			$x += $w[0];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[1], $line_height, $row[1], '', 'L');
			$x += $w[1];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[2], $line_height, '� ' . number_format($row[2], 2, ',', ' '), '', 'L');
			$x += $w[2];




			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[3], $line_height, 'inkl. ' . $row[3] . '% Mwst', '', 'C');

			$pdf->SetXY(70, $y + $height_of_cell);
		}
		/*  $pdf->SetLineWidth(0.1);
			$pdf->setDrawColor(0);
			$currentY = $pdf->getY();
			$pdf->Line($leftMargin,$currentY,196,$currentY);
		*/


		$pdf->SetXY(70, 153);
		$pdf->SetFont($fontName, '', 22);
		$pdf->Cell(40, 4, 'Gültig bis ' . date("d. m. Y", strtotime("+6 month")), 0, 0, 'L');




		/*	$pdf->SetXY(70,124);
		$pdf->SetFont($fontName,'',22);
		$pdf->Cell(40,4,'Regul�r: Erwachsener',0,0,'L');
		$pdf->SetXY(70,134);
		$pdf->Cell(40,4,'G�ltig bis '.date("d. m. Y", strtotime("+6 month")),0,0,'L');
		$pdf->SetXY(70,143);
		$pdf->SetFont($fontName,'',10);
		$pdf->Cell(40,4,'� '.number_format($order_data->amount,2,',', ' ').' (inkl. 10%  Mwst.)',0,0,'L');
		*/

		$pdf->SetFont($fontName, '', 10);
		$pdf->SetXY(70, 160);
		$pdf->SetLineWidth('1');
		$pdf->Line(71, 160, 170, 160);
		$pdf->SetXY(70, 163);
		$pdf->MultiCell(100, 6, 'Deine pers�nliche Gru�karte aus dem Haus der Geschichte �sterreich unter postkarte.hdgoe.at', 0, 'L', false);
		$pdf->SetXY(70, 176);
		$pdf->MultiCell(105, 6, 'Postkarten-App herunterladen und echte Postkarten gratis verschicken! Gutscheincode erh�ltlich am Welcome Desk (Mezzanin) direkt beim Eingang zur Ausstellung!', 0, 'L', false);
		$pdf->Line(71, 196, 170, 196);

		$pdf->SetXY(70, 205);
		$pdf->MultiCell(105, 6, 'Der Eintritt in das Haus der Geschichte �sterreich inkludiert den Besuch des Ephesos Museums.', 0, 'L', false);

		$pdf->SetXY(70, 225);
		$pdf->MultiCell(55, 6, 'Haus der Geschichte �sterreich �sterreichische Nationalbibliothek Heldenplatz - Neue Burg, Wien www.hdgoe.at', 0, 'L', false);

		$pdf->SetFont($fontName, '', 7);
		$pdf->SetXY(70, 262);
		$pdf->MultiCell(74, 3, 'Keramikfigur T�nzerin Firma Keramos, K�nstler: Rudolf Podany, um 1921, Leihgeber: Sammlung ceramicum/Uta M. Matschiner - Markus Guschelbauer', 0, 'L', false);




		$pdf->Output($url, 'F');
	}

	public function create_pdf_bill($order_id)
	{

		$order_data = $this->sm->getOrderByID($order_id);
		$year = date('y', strtotime($order_data->order_date));
		$bill_id = str_pad($order_data->yearly_bill_id, 5, '0', STR_PAD_LEFT);
		$barcode = '218200000021';
		$lang = MAIN_LANGUAGE;
		$pdfame = 'test_pdf';

		$url = getcwd() . '/items/uploads/pdfs/order_' . $order_data->id . '.pdf';
		$ticket_logo = getcwd() . '/items/frontend/img/ticket_logo.jpg';
		require_once(APPPATH . 'libraries/tfpdf.php');

		//define the path to the .ttf files you want to use
		define('FPDF_FONTPATH', APPPATH . 'libraries/font/');


		$pdf = new tFPDF();

		// Add Unicode fonts (.ttf files)
		$fontName = 'equitan';
		$pdf->AddFont($fontName, '', 'equitan_sans_regular-webfont.php');
		$pdf->AddFont($fontName, 'B', 'equitan_sans_bold-webfont.php');
		$leftMargin = 15;
		setlocale(LC_CTYPE, 'en_US');


		$items = $this->sm->getOrderItemsByID($order_data->id);
		$total_gross = 0;
		$total_net = 0;

		$net_5 = 0;
		$tax_5 = 0;

		$net_10 = 0;
		$tax_10 = 0;

		$net_15 = 0;
		$tax_15 = 0;

		$net_20 = 0;
		$tax_20 = 0;

		$bemessung_height = 0;

		foreach ($items as $item) {


			$item_net = $item->quantity * $item->price_net;
			$item_sum = $item_net + ($item_net * ($item->tax / 100));
			$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc);
			if ($item->item_id == 4 && $item->quantity == 1) {
				$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc) . "r";
			}
			$data[] = array($desc, $item->quantity, $item->price, $item_sum);


			$total_gross += $item_sum;
			$total_net += $item_net;

			if ($item->tax == 5) {
				$net_5 += $item_net;
				$tax_5 += $item_sum - $item_net;
			} else if ($item->tax == 10) {
				$net_10 += $item_net;
				$tax_10 += $item_sum - $item_net;
			} else if ($item->tax == 15) {
				$net_15 += $item_net;
				$tax_15 += $item_sum - $item_net;
			} else if ($item->tax == 20) {
				$net_20 += $item_net;
				$tax_20 += $item_sum - $item_net;
			}
		}

		if ($tax_5 != 0) {
			$bemessung_height++;
		}

		if ($tax_10 != 0) {
			$bemessung_height++;
		}

		if ($tax_15 != 0) {
			$bemessung_height++;
		}

		if ($tax_20 != 0) {
			$bemessung_height++;
		}


		$pdf->AliasNbPages();
		$pdf->AddPage('P');

		/* LOGO */
		$pdf->Image($ticket_logo, 115, 10, 30, 22, 'JPG');
		$pdf->SetXY(145, 10);
		$pdf->SetFont($fontName, '', 20);
		$pdf->MultiCell(40, 6, iconv('UTF-8', 'windows-1252', 'Haus der Geschichte Österreich'), 0, 'L', false);

		/* HDGö desc*/
		$pdf->SetXY(145, 30);
		$pdf->SetFont($fontName, '', 10);
		$pdf->Cell(40, 4, iconv('UTF-8', 'windows-1252', 'Österreichische Nationalbibliothek'), 0, 0, 'L');
		$pdf->SetXY(145, 34);
		$pdf->Cell(40, 4, iconv('UTF-8', 'windows-1252', 'Haus der Geschichte Österreich'), 0, 0, 'L');
		$pdf->SetXY(145, 38);
		$pdf->Cell(40, 4, 'Josefplatz 1 - 1015 Wien', 0, 0, 'L');
		$pdf->SetXY(145, 42);
		$pdf->Cell(40, 4, 'Tel.: +43 1 53410-805', 0, 0, 'L');
		$pdf->SetXY(145, 46);
		$pdf->Cell(40, 4, 'office@hdgoe.at - www.hdgoe.at', 0, 0, 'L');

		/* RECIPIENT*/
		$pdf->SetXY($leftMargin, 60);
		$pdf->SetFont($fontName, '', 14);

		if ($order_data->company != '' && $order_data->company != NULL) {
			$pdf->Cell(40, 5, iconv('UTF-8', 'iso-8859-2//TRANSLIT', $order_data->company), 0, 0, 'L');
			$pdf->Ln();
			$pdf->SetX($leftMargin);
		}

		$pdf->Cell(40, 5, iconv('UTF-8', 'iso-8859-2//TRANSLIT', $order_data->firstname) . " " . iconv('UTF-8', 'iso-8859-2//TRANSLIT', $order_data->lastname), 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX($leftMargin);
		$pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $order_data->street), 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX($leftMargin);
		$pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $order_data->zip . " " . $order_data->city), 0, 0, 'L');
		$pdf->Ln();

		/* BILL data*/
		$pdf->SetX(120);
		$pdf->SetFont($fontName, 'B', 17);
		$pdf->Cell(40, 10, 'E-Rechnung / E-Invoice', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->setFillColor(230, 230, 230);
		$pdf->SetFont($fontName, '', 11);
		$pdf->Cell(50, 5, 'Rechnungsnummer:', 0, 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 5, 'EOH' . $year . '-' . $bill_id, 0, 0, 'L', 1);
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->SetFont($fontName, '', 11);
		$pdf->Cell(50, 5, 'Datum:', 0, 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 5, date('d.m.Y', strtotime($order_data->order_date)), 0, 0, 'L', 1);
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->SetFont($fontName, '', 11);
		$pdf->Cell(50, 5, 'Rechnungsdatum', 0, 0, 'L', 1);

		$pdf->SetX(160);
		$pdf->Cell(20, 5, '=', 0, 0, 'L', 1);

		$pdf->SetX(170);
		$pdf->Cell(26, 5, 'Lieferdatum', 0, 0, 'L', 1);
		$pdf->Ln(8);


		$pdf->SetX(120);
		$pdf->Cell(20, 5, 'E-Mail-Versand:', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->Cell(20, 5, $order_data->email, 0, 0, 'L');
		$pdf->Ln(15);


		/**  ITEMS TABLE **/


		$pdf->SetX($leftMargin);
		$pdf->SetFont($fontName, '', 11);
		$pdf->SetDrawColor(0);

		// Column widths
		$w = array(100, 16, 24, 41);
		$Y = 85;
		$header = array('Bezeichnung', 'Menge', 'Einzelpreis', 'Gesamt Brutto');
		// Header
		for ($i = 0; $i < count($header); $i++) {
			$border = 'TB';
			$align = 'L';

			if ($i == 0) {
				$border = 'TBL';
			}

			if ($i > 1) {
				$align = 'R';
			}


			if ($i < 3) {

				$pdf->Cell($w[$i], 7, $header[$i], $border, 0, $align, 1);
			} else {
				$pdf->Cell($w[$i], 7, $header[$i], 'TBR', 0, $align, 1);
			}
		}

		$pdf->Ln();


		$pdf->SetFont($fontName, '', 11);

		foreach ($data as $row) {

			$pdf->SetX($leftMargin);

			$description = $row[0];
			$column_width = $w[0];
			$total_string_width = $pdf->GetStringWidth($description);
			$number_of_lines = $total_string_width / ($column_width);

			$number_of_lines = ceil($number_of_lines);
			$line_height = 8;
			$height_of_cell = $number_of_lines * $line_height;
			$height_of_cell = ceil($height_of_cell);

			$x = $pdf->GetX();
			$y = $pdf->GetY();

			$pdf->MultiCell($w[0], $line_height, $row[0], 'L', 'L');
			$x += $w[0];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[1], $line_height, $row[1], '', 'C');
			$x += $w[1];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[2], $line_height, 'EUR ' . number_format($row[2], 2, ',', ' '), '', 'R');
			$x += $w[2];


			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[3], $line_height, 'EUR ' . number_format($row[3], 2, ',', ' '), 'R', 'R');



			$pdf->SetXY(75, $y + $height_of_cell);
		}
		$pdf->SetLineWidth(0.1);
		$pdf->setDrawColor(0);
		$currentY = $pdf->getY();
		$pdf->Line($leftMargin, $currentY, 196, $currentY);

		/* TAX SUMMARY */
		$pdf->Ln(10);
		$pdf->SetFont($fontName, '', 11);
		$pdf->SetX($leftMargin);
		$pdf->Cell(40, 8, 'Bemessung', 'LTB', 0, 'C');
		$pdf->SetX(53);
		$pdf->Cell(40, 8, 'Steuersatz', 'TB', 0, 'C');
		$pdf->SetX(90);
		$pdf->Cell(40, 8, 'Umsatzsteuer', 'RTB', 0, 'C');

		$pdf->SetX(130);
		$pdf->Cell(40, 8, 'Nettosumme', 'LT', 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 8, number_format($total_net, 2, ',', ' '), 'RT', 0, 'R', 1);
		$pdf->Ln();
		$y = $pdf->getY();
		$pdf->SetX(130);
		$pdf->Cell(40, 5, 'Steuer gesamt', 'LB', 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 5, number_format((number_format($total_gross, 2) - number_format($total_net, 2)), 2, ',', ' '), 'RB', 0, 'R', 1);


		if ($bemessung_height == 1) {
			$pdf->Ln();
			$pdf->SetX(130);
			$pdf->Cell(40, 7, 'Rechnungssumme EUR', 'LB', 0, 'L', 1);
			$pdf->SetX(170);
			$pdf->Cell(26, 7, number_format($total_gross, 2, ',', ' '), 'RB', 0, 'R', 1);
		} else {
			for ($i = 1; $i < $bemessung_height; $i++) {
				$pdf->Ln();
				$pdf->SetX(130);
				$pdf->Cell(40, 12, '', 'L', 0, 'L', 1);
				$pdf->SetX(170);
				$pdf->Cell(26, 12, '', 'R', 0, 'R', 1);
			}
			$pdf->Ln();
			$pdf->SetX(130);
			$pdf->Cell(40, 7, 'Rechnungssumme EUR', 'LB', 0, 'L', 1);
			$pdf->SetX(170);
			$pdf->Cell(26, 7, number_format($total_gross, 2, ',', ' '), 'R', 0, 'R', 1);
		}


		$pdf->SetXY($leftMargin, $y);
		if ($tax_5 != 0) {
			$pdf->Cell(40, 12, number_format($net_5, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '5%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_5, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}
		if ($tax_10 != 0) {
			$pdf->Cell(40, 12, number_format($net_10, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '10%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_10, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}
		if ($tax_15 != 0) {
			$pdf->SetX($leftMargin);
			$pdf->Cell(40, 12, number_format($net_15, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '15%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_15, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}
		if ($tax_20 != 0) {
			$pdf->SetX($leftMargin);
			$pdf->Cell(40, 12, number_format($net_20, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '20%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_20, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}

		$pdf->SetLineWidth(0.1);
		$pdf->setDrawColor(0);
		$currentY = $pdf->getY();
		$pdf->Line($leftMargin, $currentY, 196, $currentY);


		/* FOOTER */
		$pdf->Ln(10);
		$pdf->SetFont($fontName, '', 11);
		$pdf->SetX($leftMargin);

		if ($order_data->type == 'cc') {
			$pdf->Cell(20, 5, 'Zahlung erfolgte bereits per Kreditkarte', 0, 0, 'L');
		} else {
			$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', 'Zahlung erfolgte bereits per Überweisung'), 0, 0, 'L');
		}

		$currrentPath = getcwd();
		$bk_path = str_replace('Website', 'Bookkeeping', $currrentPath);

		$filepath = $bk_path . '/EOH' . $year . '-' . $bill_id . '.pdf';

		$pdf->Output($filepath, 'F');
		chmod($filepath, 0664);



		$currrentPath = getcwd();
		$bk_path = str_replace('Website', 'bk', $currrentPath);

		$filepath = $bk_path . '/EOH' . $year . '-' . $bill_id . '.pdf';

		$pdf->Output($filepath, 'F');
		chmod($filepath, 0664);
	}


	public function create_pdf_bill_mail($order_id)
	{

		$order_data = $this->sm->getOrderByID($order_id);
		$year = date('y', strtotime($order_data->order_date));
		$bill_id = str_pad($order_data->yearly_bill_id, 5, '0', STR_PAD_LEFT);
		$barcode = '218200000021';
		$lang = MAIN_LANGUAGE;
		$pdfame = 'test_pdf';

		$url = getcwd() . '/items/uploads/pdfs/order_' . $order_data->id . '.pdf';
		$ticket_logo = getcwd() . '/items/frontend/img/ticket_logo.jpg';
		require_once(APPPATH . 'libraries/tfpdf.php');

		//define the path to the .ttf files you want to use
		define('FPDF_FONTPATH', APPPATH . 'libraries/font/');


		$pdf = new tFPDF();

		// Add Unicode fonts (.ttf files)
		$fontName = 'equitan';
		$pdf->AddFont($fontName, '', 'equitan_sans_regular-webfont.php');
		$pdf->AddFont($fontName, 'B', 'equitan_sans_bold-webfont.php');
		$leftMargin = 15;
		setlocale(LC_CTYPE, 'en_US');


		$items = $this->sm->getOrderItemsByID($order_data->id);
		$total_gross = 0;
		$total_net = 0;

		$net_5 = 0;
		$tax_5 = 0;

		$net_10 = 0;
		$tax_10 = 0;

		$net_15 = 0;
		$tax_15 = 0;

		$net_20 = 0;
		$tax_20 = 0;

		$bemessung_height = 0;

		foreach ($items as $item) {


			$item_net = $item->quantity * $item->price_net;
			$item_sum = $item_net + ($item_net * ($item->tax / 100));
			$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc);
			if ($item->item_id == 4 && $item->quantity == 1) {
				$desc = iconv('UTF-8', 'iso-8859-2//TRANSLIT', $item->desc) . "r";
			}
			$data[] = array($desc, $item->quantity, $item->price, $item_sum);


			$total_gross += $item_sum;
			$total_net += $item_net;

			if ($item->tax == 5) {
				$net_5 += $item_net;
				$tax_5 += $item_sum - $item_net;
			} else if ($item->tax == 10) {
				$net_10 += $item_net;
				$tax_10 += $item_sum - $item_net;
			} else if ($item->tax == 15) {
				$net_15 += $item_net;
				$tax_15 += $item_sum - $item_net;
			} else if ($item->tax == 20) {
				$net_20 += $item_net;
				$tax_20 += $item_sum - $item_net;
			}
		}

		if ($tax_5 != 0) {
			$bemessung_height++;
		}

		if ($tax_10 != 0) {
			$bemessung_height++;
		}

		if ($tax_15 != 0) {
			$bemessung_height++;
		}

		if ($tax_20 != 0) {
			$bemessung_height++;
		}


		$pdf->AliasNbPages();
		$pdf->AddPage('P');

		/* LOGO */
		$pdf->Image($ticket_logo, 115, 10, 30, 22, 'JPG');
		$pdf->SetXY(145, 10);
		$pdf->SetFont($fontName, '', 20);
		$pdf->MultiCell(40, 6, iconv('UTF-8', 'windows-1252', 'Haus der Geschichte Österreich'), 0, 'L', false);

		/* HDGö desc*/
		$pdf->SetXY(145, 30);
		$pdf->SetFont($fontName, '', 10);
		$pdf->Cell(40, 4, iconv('UTF-8', 'windows-1252', 'Österreichische Nationalbibliothek'), 0, 0, 'L');
		$pdf->SetXY(145, 34);
		$pdf->Cell(40, 4, iconv('UTF-8', 'windows-1252', 'Haus der Geschichte Österreich'), 0, 0, 'L');
		$pdf->SetXY(145, 38);
		$pdf->Cell(40, 4, 'Josefplatz 1 - 1015 Wien', 0, 0, 'L');
		$pdf->SetXY(145, 42);
		$pdf->Cell(40, 4, 'Tel.: +43 1 53410-805', 0, 0, 'L');
		$pdf->SetXY(145, 46);
		$pdf->Cell(40, 4, 'office@hdgoe.at - www.hdgoe.at', 0, 0, 'L');

		/* RECIPIENT*/
		$pdf->SetXY($leftMargin, 60);
		$pdf->SetFont($fontName, '', 14);

		if ($order_data->company != '' && $order_data->company != NULL) {
			$pdf->Cell(40, 5, iconv('UTF-8', 'iso-8859-2//TRANSLIT', $order_data->company), 0, 0, 'L');
			$pdf->Ln();
			$pdf->SetX($leftMargin);
		}

		$pdf->Cell(40, 5, iconv('UTF-8', 'iso-8859-2//TRANSLIT', $order_data->firstname) . " " . iconv('UTF-8', 'iso-8859-2//TRANSLIT', $order_data->lastname), 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX($leftMargin);
		$pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $order_data->street), 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX($leftMargin);
		$pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $order_data->zip . " " . $order_data->city), 0, 0, 'L');
		$pdf->Ln();

		/* BILL data*/
		$pdf->SetX(120);
		$pdf->SetFont($fontName, 'B', 17);
		$pdf->Cell(40, 10, 'E-Rechnung / E-Invoice', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->setFillColor(230, 230, 230);
		$pdf->SetFont($fontName, '', 11);
		$pdf->Cell(50, 5, 'Rechnungsnummer:', 0, 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 5, 'EOH' . $year . '-' . $bill_id, 0, 0, 'L', 1);
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->SetFont($fontName, '', 11);
		$pdf->Cell(50, 5, 'Datum:', 0, 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 5, date('d.m.Y', strtotime($order_data->order_date)), 0, 0, 'L', 1);
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->SetFont($fontName, '', 11);
		$pdf->Cell(50, 5, 'Rechnungsdatum', 0, 0, 'L', 1);

		$pdf->SetX(160);
		$pdf->Cell(20, 5, '=', 0, 0, 'L', 1);

		$pdf->SetX(170);
		$pdf->Cell(26, 5, 'Lieferdatum', 0, 0, 'L', 1);
		$pdf->Ln(8);


		$pdf->SetX(120);
		$pdf->Cell(20, 5, 'E-Mail-Versand:', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetX(120);
		$pdf->Cell(20, 5, $order_data->email, 0, 0, 'L');
		$pdf->Ln(15);

		/**  ITEMS TABLE **/


		$pdf->SetX($leftMargin);
		$pdf->SetFont($fontName, '', 11);
		$pdf->SetDrawColor(0);

		// Column widths
		$w = array(100, 16, 24, 41);
		$Y = 85;
		$header = array('Bezeichnung', 'Menge', 'Einzelpreis', 'Gesamt Brutto');
		// Header
		for ($i = 0; $i < count($header); $i++) {
			$border = 'TB';
			$align = 'L';

			if ($i == 0) {
				$border = 'TBL';
			}

			if ($i > 1) {
				$align = 'R';
			}


			if ($i < 3) {

				$pdf->Cell($w[$i], 7, $header[$i], $border, 0, $align, 1);
			} else {
				$pdf->Cell($w[$i], 7, $header[$i], 'TBR', 0, $align, 1);
			}
		}

		$pdf->Ln();


		$pdf->SetFont($fontName, '', 11);

		foreach ($data as $row) {

			$pdf->SetX($leftMargin);

			$description = $row[0];
			$column_width = $w[0];
			$total_string_width = $pdf->GetStringWidth($description);
			$number_of_lines = $total_string_width / ($column_width);

			$number_of_lines = ceil($number_of_lines);
			$line_height = 8;
			$height_of_cell = $number_of_lines * $line_height;
			$height_of_cell = ceil($height_of_cell);

			$x = $pdf->GetX();
			$y = $pdf->GetY();

			$pdf->MultiCell($w[0], $line_height, $row[0], 'L', 'L');
			$x += $w[0];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[1], $line_height, $row[1], '', 'C');
			$x += $w[1];

			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[2], $line_height, 'EUR ' . number_format($row[2], 2, ',', ' '), '', 'R');
			$x += $w[2];


			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w[3], $line_height, 'EUR ' . number_format($row[3], 2, ',', ' '), 'R', 'R');



			$pdf->SetXY(75, $y + $height_of_cell);
		}
		$pdf->SetLineWidth(0.1);
		$pdf->setDrawColor(0);
		$currentY = $pdf->getY();
		$pdf->Line($leftMargin, $currentY, 196, $currentY);

		/* TAX SUMMARY */
		$pdf->Ln(10);
		$pdf->SetFont($fontName, '', 11);
		$pdf->SetX($leftMargin);
		$pdf->Cell(40, 8, 'Bemessung', 'LTB', 0, 'C');
		$pdf->SetX(53);
		$pdf->Cell(40, 8, 'Steuersatz', 'TB', 0, 'C');
		$pdf->SetX(90);
		$pdf->Cell(40, 8, 'Umsatzsteuer', 'RTB', 0, 'C');

		$pdf->SetX(130);
		$pdf->Cell(40, 8, 'Nettosumme', 'LT', 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 8, number_format($total_net, 2, ',', ' '), 'RT', 0, 'R', 1);
		$pdf->Ln();
		$y = $pdf->getY();
		$pdf->SetX(130);
		$pdf->Cell(40, 5, 'Steuer gesamt', 'LB', 0, 'L', 1);
		$pdf->SetX(170);
		$pdf->Cell(26, 5, number_format((number_format($total_gross, 2) - number_format($total_net, 2)), 2, ',', ' '), 'RB', 0, 'R', 1);


		if ($bemessung_height == 1) {
			$pdf->Ln();
			$pdf->SetX(130);
			$pdf->Cell(40, 7, 'Rechnungssumme EUR', 'LB', 0, 'L', 1);
			$pdf->SetX(170);
			$pdf->Cell(26, 7, number_format($total_gross, 2, ',', ' '), 'RB', 0, 'R', 1);
		} else {
			for ($i = 1; $i < $bemessung_height; $i++) {
				$pdf->Ln();
				$pdf->SetX(130);
				$pdf->Cell(40, 12, '', 'L', 0, 'L', 1);
				$pdf->SetX(170);
				$pdf->Cell(26, 12, '', 'R', 0, 'R', 1);
			}
			$pdf->Ln();
			$pdf->SetX(130);
			$pdf->Cell(40, 7, 'Rechnungssumme EUR', 'LB', 0, 'L', 1);
			$pdf->SetX(170);
			$pdf->Cell(26, 7, number_format($total_gross, 2, ',', ' '), 'R', 0, 'R', 1);
		}


		$pdf->SetXY($leftMargin, $y);
		if ($tax_5 != 0) {
			$pdf->Cell(40, 12, number_format($net_5, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '5%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_5, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}
		if ($tax_10 != 0) {
			$pdf->Cell(40, 12, number_format($net_10, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '10%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_10, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}
		if ($tax_15 != 0) {
			$pdf->SetX($leftMargin);
			$pdf->Cell(40, 12, number_format($net_15, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '15%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_15, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}
		if ($tax_20 != 0) {
			$pdf->SetX($leftMargin);
			$pdf->Cell(40, 12, number_format($net_20, 2, ',', ' '), 'L', 0, 'C');
			$pdf->SetX(53);
			$pdf->Cell(40, 12, '20%', '', 0, 'C');
			$pdf->SetX(90);
			$pdf->Cell(40, 12, number_format($tax_20, 2, ',', ' '), 'R', 0, 'C');
			$pdf->Ln();
		}

		$pdf->SetLineWidth(0.1);
		$pdf->setDrawColor(0);
		$currentY = $pdf->getY();
		$pdf->Line($leftMargin, $currentY, 196, $currentY);


		/* FOOTER */
		$pdf->Ln(10);
		$pdf->SetFont($fontName, '', 11);
		$pdf->SetX($leftMargin);

		if ($order_data->type == 'cc') {
			$pdf->Cell(20, 5, 'Zahlung erfolgte bereits per Kreditkarte', 0, 0, 'L');
		} else {
			$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', 'Zahlung erfolgte bereits per Überweisung'), 0, 0, 'L');
		}



		$pdf->Output($url, 'F');
	}

	public function dompdf_test()
	{
		// prepare data
		$data = array();

		// prepare data
		$data['data'] = $data_param;

		// load template
		$html = $this->load->view('pdf/dompdf_test', $data, true);

		// instantiate and use the dompdf class
		$dompdf = new Dompdf\Dompdf();
		$dompdf->set_option('isHtml5ParserEnabled', true);
		$dompdf->set_option('isRemoteEnabled', true);
		$dompdf->set_option("isPhpEnabled", true);
		$dompdf->loadHtml($html);

		// (optional) setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// render the HTML as PDF
		$dompdf->render();

		// output the generated PDF to Browser
		$dompdf->stream();
	}

	public function dompdf_test_save_to_file()
	{
		$data = array();

		// prepare data
		$data['data'] = $data;

		// load template
		$html = $this->load->view('pdf/dompdf_test', $data, true);

		// instantiate and use the dompdf class
		$dompdf = new Dompdf\Dompdf();
		$dompdf->set_option('isHtml5ParserEnabled', true);
		$dompdf->set_option('isRemoteEnabled', true);
		$dompdf->set_option("isPhpEnabled", true);
		$dompdf->loadHtml($html);

		// (optional) setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// render the HTML as PDF
		$dompdf->render();

		// get a unique filename (e.g., using timestamp)
		$timestamp = time();
		$filename = 'FILENAME_' . $timestamp . '.pdf';
		$file_path = 'items/uploads/pdfs/' . $filename;

		// save the PDF to a file
		file_put_contents($file_path, $dompdf->output());

		// (optional) output a message or redirect the user
		echo "PDF saved successfully at: " . $file_path;
	}
}
