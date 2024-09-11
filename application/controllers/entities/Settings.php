<?php defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'controllers/Backend.php');

class Content extends Backend
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('entities/Content_model', 'cm');
	}

	public function pending_images()
	{
		$bc = new besc_crud();

		$bc->table('pending_images');
		$bc->primary_key('id');
		$bc->order_by_field('upload_date');
		$bc->order_by_direction('desc');

		$bc->title('Pending Image');

		$bc->unset_add();
		$bc->unset_delete();

		$bc->list_columns(array('fname', 'chapter_id', 'short_description', 'description', 'upload_date'));
		$bc->filter_columns(array('chapter_id', 'short_description', 'description', 'upload_date'));

		$bc->custom_buttons(array(
			array(
				'name' => 'Accept Image',
				'icon' => site_url('items/besc_crud/img/add.png'),
				'add_pk' => true,
				'url' => 'accept_image'
			),

			array(
				'name' => 'Check Image',
				'icon' => site_url('items/backend/img/icon_clone.png'),
				'add_pk' => true,
				'url' => 'check_image'
			),

			array(
				'name' => 'Decline Image',
				'icon' => site_url('items/besc_crud/img/delete.png'),
				'add_pk' => true,
				'url' => 'decline_image'
			),

		));

		$select_array = array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$category_array = array();
		$status_array = array();


		$categories = $this->cm->getCategories();
		foreach ($categories as $cat) {
			$category_array[] = array('key' => $cat->id, 'value' => $cat->name);
		}


		$bc->columns(array(
			'short_description' => array(
				'db_name' => 'short_description',
				'type' => 'text',
				'display_as' => 'Short Description',
				'validation' => 'required',
			),

			'description' => array(
				'db_name' => 'description',
				'type' => 'text',
				'display_as' => 'Description',
			),

			'chapter_id' => array(
				'db_name' => 'chapter_id',
				'type' => 'select',
				'display_as' => 'Chapter',
				'options' => $category_array,
			),


			'fname' => array(
				'db_name' => 'fname',
				'type' => 'image',
				'display_as' => 'Image',
				'col_info' => 'filetypes: .png, .jpg, .jpeg',
				'accept' => '.png,.jpg,.jpeg',
				'uploadpath' => 'items/uploads/images',
			),

			'photographer' => array(
				'db_name' => 'photographer',
				'type' => 'text',
				'display_as' => 'Photographer',
			),

			'year' => array(
				'db_name' => 'year',
				'type' => 'text',
				'display_as' => 'Year',
			),

			'place' => array(
				'db_name' => 'place',
				'type' => 'text',
				'display_as' => 'Place',
			),

			'upload_date' => array(
				'db_name' => 'upload_date',
				'type' => 'date',
				'display_as' => 'Upload Date',
				'edit_format' => 'yy-mm-dd',
				'list_format' => 'd/m/Y',

			),



		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}


	public function images()
	{
		$bc = new besc_crud();

		$bc->table('chapter_images');
		$bc->primary_key('id');
		$bc->order_by_field('upload_date');
		$bc->order_by_direction('desc');

		$bc->title('Image');

		$bc->list_columns(array('fname', 'chapter_id', 'short_description', 'description', 'visible', 'likes'));
		$bc->filter_columns(array('chapter_id', 'short_description', 'description'));

		$bc->custom_buttons(array());

		$select_array = array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$category_array = array();
		$status_array = array();


		$categories = $this->cm->getCategories();
		foreach ($categories as $cat) {
			$category_array[] = array('key' => $cat->id, 'value' => $cat->name);
		}


		$bc->columns(array(
			'short_description' => array(
				'db_name' => 'short_description',
				'type' => 'text',
				'display_as' => 'Title',
				'validation' => 'required',
			),

			'description' => array(
				'db_name' => 'description',
				'type' => 'text',
				'display_as' => 'Description',
			),

			'chapter_id' => array(
				'db_name' => 'chapter_id',
				'type' => 'select',
				'display_as' => 'Chapter',
				'options' => $category_array,
			),


			'fname' => array(
				'db_name' => 'fname',
				'type' => 'image',
				'display_as' => 'Image',
				'col_info' => 'filetypes: .png, .jpg, .jpeg',
				'accept' => '.png,.jpg,.jpeg',
				'uploadpath' => 'items/uploads/images',
			),

			'photographer' => array(
				'db_name' => 'photographer',
				'type' => 'text',
				'display_as' => 'Photographer',
			),

			'year' => array(
				'db_name' => 'year',
				'type' => 'text',
				'display_as' => 'Year',
			),

			'place' => array(
				'db_name' => 'place',
				'type' => 'text',
				'display_as' => 'Place',
			),

			'visible' => array(
				'db_name' => 'visible',
				'type' => 'select',
				'display_as' => 'Visible',
				'options' => $select_array,
			),

			'likes' => array(
				'db_name' => 'likes',
				'type' => 'text',
				'display_as' => 'Likes',
			),

			'curatorial_content' => array(
				'db_name' => 'curatorial_content',
				'type' => 'multiline',
				'height' => 200,
				'display_as' => 'Curatorial content',
			),




		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}


	public function chapters()
	{
		$bc = new besc_crud();

		$bc->table('chapters');
		$bc->primary_key('id');
		$bc->order_by_field('name');
		$bc->order_by_direction('asc');

		$bc->title('Chapter');

		$bc->list_columns(array('name', 'ordering', 'visible', 'centered'));
		$bc->filter_columns(array('name', 'ordering', 'visible', 'centered'));

		$bc->custom_buttons(array());

		$select_array = array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');



		$bc->columns(array(
			'name' => array(
				'db_name' => 'name',
				'type' => 'text',
				'display_as' => 'Name',
				'validation' => 'required',
			),

			'ordering' => array(
				'db_name' => 'ordering',
				'type' => 'text',
				'display_as' => 'Ordering',
				'col_info' => 'Ascending list - smaller comes first',
			),


			'visible' => array(
				'db_name' => 'visible',
				'type' => 'select',
				'display_as' => 'Visible',
				'options' => $select_array,
			),

			'centered' => array(
				'db_name' => 'centered',
				'type' => 'select',
				'display_as' => 'Show in center',
				'options' => $select_array,
			),



		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}





	public function accept_image($itemId)
	{
		$data = array();

		//get image data
		$item = $this->cm->getPendingByID($itemId)->row();

		//send out notification to user
		//$this->sendAcceptMail($item->email, $item->name, $item->title);

		//move to accepted table
		$data = array(
			'fname' => $item->fname,
			'chapter_id' => $item->chapter_id,
			'upload_date' => $item->upload_date,
			'ip_address' => $item->ip_address,
			'short_description' => $item->short_description,
			'description' => $item->description,
			'photographer' => $item->photographer,
			'year' => $item->year,
			'place' => $item->place,
			'email' => $item->email,
			'name' => $item->name
		);
		$this->cm->insertAcceptedImage($data);

		//remove DB entry from pending_images
		$this->cm->deletePendingByID($itemId);

		$response = array('success' => true);

		echo json_encode($response);
	}


	public function decline_image($itemId)
	{
		$data = array();

		//get image data
		$item = $this->cm->getPendingByID($itemId)->row();

		//send out notification to user
		//$this->sendDeclineMail($item->email, $item->name, $item->title);

		//remove file from server
		$path_to_file = getcwd() . '/items/uploads/images/' . $item->fname;
		unlink($path_to_file);

		//remove DB entry
		$this->cm->deletePendingByID($itemId);


		//redirect('entities/Content/pending_images');
		$response = array('success' => true);

		echo json_encode($response);
	}


	public function check_image($itemId)
	{
		$data = array();

		//get image data
		$item = $this->cm->getPendingByID($itemId)->row();

		$image_url = site_url('items/uploads/images/' . $item->fname);



		$api_url = "https://api.tineye.com/rest/search/";
		$api_private_key = "6mm60lsCNIB,FwOWjJqA80QZHh9BMwc-ber4u=t^";
		$api_public_key = "LCkn,2K7osVwkX95K4Oy";

		$p = array(
			"offset" => "0",
			"limit" => "100",
			"image_url" => $image_url
		);
		$sorted_p = ksort($p);
		$query_p = http_build_query($p);
		$signature_p = strtolower($query_p);
		$http_verb = "GET";
		$date = time();
		$nonce = uniqid();
		$string_to_sign = $api_private_key . $http_verb . $date . $nonce . $api_url . $signature_p;
		$api_sig = hash_hmac("sha256", $string_to_sign, $api_private_key);
		$url = $api_url . "?api_key=" . $api_public_key . "&";
		$url .= $query_p . "&date=" . $date . "&nonce=" . $nonce . "&api_sig=" . $api_sig;
		$api_json_response = json_decode(file_get_contents($url), True);
		if ($api_json_response['code'] == 200) {
			/* print "status: Ok,  ";
	        print "num results: " . count($api_json_response['results']['matches']);*/
		} else {
			//print "status: Error, ";
		}
		/* echo "<pre>";
		print_r($api_json_response);
	*/
		$found = false;

		if (count($api_json_response['results']['matches']) > 0) {
			$found = true;
		}

		$response = array('success' => true, 'found' => $found, 'response_data' => $api_json_response);

		echo json_encode($response);
	}



	public function edit_item($itemId)
	{
		$data = array();




		$data['item'] = $this->cm->getItemByID($itemId)->row();
		$column_id = 2;

		$data['modulesText'] = $this->cm->getModulesText($itemId, $column_id);
		$data['modulesImage'] = $this->cm->getModulesImage($itemId, $column_id);
		$data['modulesHTML'] = $this->cm->getModulesHTML($itemId, $column_id);
		$data['modulesBulletpoint'] = $this->cm->getModulesBulletpoint($itemId, $column_id);


		$data['modules'] = array_merge(array(), $data['modulesText']->result_array());
		$data['modules'] = array_merge($data['modules'], $data['modulesImage']->result_array());
		$data['modules'] = array_merge($data['modules'], $data['modulesHTML']->result_array());
		$data['modules'] = array_merge($data['modules'], $data['modulesBulletpoint']->result_array());

		usort($data['modules'], function ($a, $b) {
			return $a['top'] - $b['top'];
		});

		$data['galleryItems'] = $this->cm->getGalleryItems($itemId, $column_id);
		$data['crud_data'] = $this->load->view('backend/edit_item', $data, true);
		$this->page('backend/crud/crud', $data);
	}

	public function image_overwatch()
	{
		$data = array();

		$data['items'] = $this->cm->getPendingImages();

		$data['crud_data'] = $this->load->view('backend/image_overwatch', $data, true);
		$this->page('backend/crud/crud', $data);
	}



	public function save_item()
	{
		$column_id = 2;
		$this->cm->deleteModulesText($_POST['id'], $column_id);
		$this->cm->deleteModulesImage($_POST['id'], $column_id);
		$this->cm->deleteModulesHTML($_POST['id'], $column_id);

		if (isset($_POST['modules'])) {
			foreach ($_POST['modules'] as $module) {
				switch ($module['type']) {
					case 'text':
						$this->cm->insertModuleText(array(
							'item_id' => $_POST['id'],
							'column_id' => $column_id,
							'top' => $module['top'],
							'content' => $module['content'],
						));
						break;

					case 'image':
						$this->cm->insertModuleImage(array(
							'item_id' => $_POST['id'],
							'column_id' => $column_id,
							'top' => $module['top'],
							'fname' => $module['fname'],
							'text_wrap' => $module['text_wrap'],
							'description' => $module['description'],
						));
						break;

					case 'html':
						$this->cm->insertModuleHTML(array(
							'item_id' => $_POST['id'],
							'column_id' => $column_id,
							'top' => $module['top'],
							'html' => $module['html'],
						));
						break;

				}
			}
		}


		$this->cm->deleteGalleryItems($_POST['id'], $column_id);
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
			$this->cm->insertGalleryItems($batch);
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

		$filename = $_POST['filename'];
		$upload_path = $_POST['uploadpath'];
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$serverFile = time() . "_" . $rnd . "." . $ext;

		$error = move_uploaded_file($_FILES['data']['tmp_name'], getcwd() . "/$upload_path/$serverFile");

		resize_max(getcwd() . "/$upload_path/$serverFile", 1000, 1000);

		echo json_encode(array(
			'success' => true,
			'path' => getcwd() . "/$upload_path/$serverFile",
			'filename' => $serverFile
		));
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





	public function regex_test()
	{
		echo preg_match('/is_unique/', 'is_unique[metatag.name]');
	}
}
