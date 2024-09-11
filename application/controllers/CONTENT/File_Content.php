<?	defined('BASEPATH') or exit('No direct script access allowed');



trait File_Content
{


	// FILE REPOSITORY


	public function files()
	{
		$this->groupName = "Files";
		$this->typeOfTable = '';
    $this->setTableName();


		$this->listColumns = array('title_en',  'title', 'file_tag', 'ordering', 'file_download');
		$this->filterColumns = array('title_en',  'title', 'file_tag',  'file_download', 'ordering' );




		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$file_tag_array = $this->getSelector('file_tags', 'name', 'id');

		$colors_array = $this->getSelector('colors', 'name', 'hex');


		$data['colors'] = $colors_array;


		$columns = array(
			'title_en' => array(
				'db_name' => 'title_en',
				'type' => 'text',
				'display_as' => 'Title EN',
			),

			'title' => array(
				'db_name' => 'title',
				'type' => 'text',
				'display_as' => 'Title DE',
			),

			'ordering' => array(
				'db_name' => 'ordering',
				'type' => 'text',
				'display_as' => 'Ordering',
			),

			'description' => array(
				'db_name' => 'description',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Description DE',
			),


			'description_en' => array(
				'db_name' => 'description_en',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Description EN',
			),

			'image' => array(
				'db_name' => 'image',
				'type' => 'image',
				'display_as' => 'Image/logo',
				'col_info' => 'filetypes: .png, .jpg, .jpeg, .gif, .svg',
				'accept' => '.png,.jpg,.jpeg,.gif,.svg',
				'uploadpath' => 'items/uploads/images',
				'thumbnail' => true,
			),

			// 'color' => array(
			// 	'db_name' => 'color',
			// 	'type' => 'select',
			// 	'options' => $colors_array,
			// 	'display_as' => 'Color',
			// ),



			'file_tag' => array(
				'db_name' => 'file_tag',
				'type' => 'select',
				'options' => $file_tag_array,
				'display_as' => 'File Tag',
			),


			'file_download' => array(
				'db_name' => 'file_download',
				'type' => 'file',
				'display_as' => 'File',
				'col_info' => 'filetypes: .pdf, .zip, .rar',
				'accept' => '.pdf, .zip',
				'uploadpath' => 'items/uploads/files',
			),

		);

		$this->columns = $columns;
		$data['show_mods'] = false;
		$this->prepareTable();
		$data['crud_data'] = $this->bc->execute($this->pagination);
		$this->page('backend/crud/crud', $data);
	}



	public function file_tags()
	{

		$this->groupName = "Files";
		$this->typeOfTable = '';
		$this->setTableName();


		$this->listColumns = array('name' );
		$this->filterColumns = array('name');



		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$columns = array();
		$columns['name'] =
		 array(
			'db_name' => 'name',
			'type' => 'text',
			'display_as' => 'Name',
		);


		$this->columns = $columns;
		$data['show_mods'] = false;
		$this->prepareTable();
		$data['crud_data'] = $this->bc->execute($this->pagination);
		$this->page('backend/crud/crud', $data);
	}

	// COLORS





		/**************************    UPLOAD FILE REPO FUNCTIONS       *******************************/


	public function uploadFile()
	{
		$this->load->helper('besc_helper');
		$parsed_url = parse_url(site_url());
		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
		$filename = $_POST['filename'];
		$upload_path = $_POST['uploadpath'];
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		//$serverFile = time() . "_" . $rnd . "." . $ext;
		$serverFile = $filename;
		$folderPath =  str_replace("CMS", "", getcwd());


		$allowed =  array('pdf', 'zip', 'vtt');
		if (!in_array($ext, $allowed)) {
			echo json_encode(array(
				'success' => false,
				'path' => "$upload_path/$serverFile",
				'filename' => $serverFile
			));
		} else {
			$error = move_uploaded_file($_FILES['data']['tmp_name'], $folderPath . "/$upload_path/$serverFile");

			echo json_encode(array(
				'success' => true,
				'path' => $folderPath . "/$upload_path/$serverFile",
				'fullpath' => $host . "/$upload_path/$serverFile",
				'filename' => $serverFile
			));
		}
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
		$folderPath =  str_replace("CMS", "", getcwd());
		$error = move_uploaded_file($_FILES['data']['tmp_name'], $folderPath . "/$upload_path/$serverFile");

		resize_max($folderPath . "/$upload_path/$serverFile", 1000, 1000);

		echo json_encode(array(
			'success' => true,
			'path' => $folderPath . "/$upload_path/$serverFile",
			'fullpath' => $host . "/$upload_path/$serverFile",
			'filename' => $serverFile
		));
	}


		public function upload_pdf()
	{
		$this->load->helper('besc_helper');

		$parsed_url = parse_url(site_url());
		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];

		$filename = $_POST['filename'];
		$upload_path = $_POST['uploadpath'];
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		//$serverFile = time() . "_" . $rnd . "." . $ext;
		$serverFile = time()."_".$filename;
		$folderPath =  getcwd();


		$allowed =  array('pdf', 'zip', 'jpg', 'jpeg', 'png');
		if (!in_array($ext, $allowed)) {
			echo json_encode(array(
				'success' => false,
				'path' => "$upload_path/$serverFile",
				'filename' => $serverFile
			));
		} else {
			$error = move_uploaded_file($_FILES['data']['tmp_name'], $folderPath . "/$upload_path/$serverFile");

			echo json_encode(array(
				'success' => true,
				'path' => $folderPath . "/$upload_path/$serverFile",
				'fullpath' => $host . "/$upload_path/$serverFile",
				'filename' => $serverFile
			));
		}
	}




}
