<?php defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'controllers/Backend.php');

class Repository extends Backend
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('entities/Content_model', 'cm');
		if ($this->user->is_admin != 1) {
			redirect('');
		}
	}




	public function saveOneImage()
	{
		$title_en = $_POST['image_title_en'];
		$title = $_POST['image_title'];

		$image_credits_text = $_POST['image_credits_text'];
		$image_credits_text_en = $_POST['image_credits_text_en'];
		$image_id = $_POST['image_id'];


		$data = array(
			'title_en' => $title_en,
			'title' => $title,
			'credits_en' => $image_credits_text_en,
			'credits' => $image_credits_text,
		);

		// <div class="repo_item_title">' . $item->category_name . '</div>


		$elem = $this->cm->updateRepoImage($image_id, $data);

		echo json_encode(array('success' => 'yes', 'item' => $elem));

	}


	public function categories()
	{
		$bc = new besc_crud();
		$data['show_mods'] = false; //Toggle for module editor
		$bc->database(DB_NAME);
		$bc->main_title('Repository');
		$bc->table_name('Categories');
		$bc->table('image_categories');
		$bc->primary_key('id');
		$bc->title('Category');
		$bc->list_columns(array('name'));
		$bc->filter_columns(array('name'));
		$bc->custom_buttons(array());

		$bc->columns(
			array(
				'name' => array(
					'db_name' => 'name',
					'type' => 'text',
					'display_as' => 'Name',
				),

			)
		);

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function tags()
	{
		$bc = new besc_crud();
		$data['show_mods'] = false; //Toggle for module editor
		$bc->database(DB_NAME);
		$bc->main_title('Repository');
		$bc->table_name('Tags');
		$bc->table('image_tags');
		$bc->primary_key('id');
		$bc->title('Tag');
		$bc->list_columns(array('name'));
		$bc->filter_columns(array('name'));
		$bc->custom_buttons(array());

		$bc->columns(
			array(
				'name' => array(
					'db_name' => 'name',
					'type' => 'text',
					'display_as' => 'Name',
				),

			)
		);

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function items()
	{



		$bc = new besc_crud();
		$data['show_mods'] = false; //Toggle for module editor
		$bc->database(DB_NAME);
		$bc->main_title('Repository');
		$bc->table_name('Images');
		$bc->table('image_repository');
		$bc->folder('empty_8');

		// 	if($this->user->privacy_tag != 1) {
		// 	$bc->getRepoItemsForId($this->user->privacy_tag);
		// }
		$bc->primary_key('id');
		$bc->title('Image');
		$bc->list_columns(array('fname', 'title', 'image_tag_relation', 'date_added'));
		$bc->filter_columns(array('title', 'title_en', 'fname', 'category', 'image_tag_relation', 'credits', 'credits_en', 'description_en', 'description', 'alt_text', 'alt_text_en', 'image_tag_relation'));



		$bc->custom_buttons(array());

		$categories_array = array();
		$categories = $this->cm->getimageCategories();

		$categories_array[] = array('key' => '', 'value' => 'None');
		foreach ($categories as $art) {
			$categories_array[] = array('key' => $art->id, 'value' => $art->name);
		}

		// $privacy_tags_array = array();
		// $privacy_tags = $this->cm->getPrivacyTags();

		// foreach ($privacy_tags as $t) {
		// 	$privacy_tags_array[] = array('key' => $art->id, 'value' => $art->name);
		// }

		// $projects_array = array();
		// $project = $this->cm->getProjects();
		// foreach($project as $p){
		// 	$projects_array[] = array('key' => $p->id, 'value' => $p->name);
		// }

		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		/*  $collection_array = array();
		$collection = $this->cm->getItemCollections();
		$collection_array[] = array('key' => 0, 'value' => "NON COLLECTION ITEM");
		foreach ($collection as $col) {
		$collection_array[] = array('key' => $col->id, 'value' => $col->InvenotryNR." - ".$col->Title_DE." (".$col->Header_DE.")");
		} */

		$bc->columns(
			array(

				'fname' => array(
					'db_name' => 'fname',
					'type' => 'image',
					'display_as' => 'Image',
					'col_info' => 'filetypes: .png, .jpg, .jpeg, .gif',
					'accept' => '.png,.jpg,.jpeg,.gif',
					'uploadpath' => 'items/uploads/images',
					'thumbnail' => true,
				),

				'public' => array(
					'db_name' => 'public',
					'type' => 'select',
					'display_as' => 'Public',
					'options' => $select_array,
				),


				// 'fname_orig' => array(
				// 	'db_name' => 'fname_orig',
				// 	'type' => 'image',
				// 	'display_as' => 'Original Image',
				// 	'col_info' => 'filetypes: .png, .jpg, .jpeg, .gif',
				// 	'accept' => '.png,.jpg,.jpeg,.gif',
				// 	'uploadpath' => 'items/uploads/images',
				// ),

				// 'fname' => array(
				// 	'db_name' => 'fname',
				// 	'type' => 'file',
				// 	'display_as' => 'File',
				// 	'col_info' => 'filetypes: .png, .jpg, .jpeg, .pdf',
				// 	'accept' => '.png,.jpg,.jpeg,.pdf',
				// 	'uploadpath' => 'items/uploads/images',
				// ),



				'title' => array(
					'db_name' => 'title',
					'type' => 'multiline',
					'height' => 100,
					'display_as' => 'Title',
				),



				'title_en' => array(
					'db_name' => 'title_en',
					'type' => 'multiline',
					'height' => 100,
					'display_as' => 'Title EN',
				),



				// 	'project' => array(
				// 		'db_name' => 'project',
				// 		'type' => 'select',
				// 		'display_as' => 'Project',
				// 		'options' => $projects_array,
				// ),


				// 'date_taken' => array(
				// 	'db_name' => 'date_taken',
				// 	'type' => 'text',
				// 	'col_info' => 'Format: YYYY-MM-DD',
				// 	'display_as' => 'Date Taken',
				// ),


				// 'display_title_de' => array(
				// 	'db_name' => 'display_title_de',
				// 	'type' => 'text',
				// 	'display_as' => 'Display Title DE',
				// ),

				// 'display_title_en' => array(
				// 	'db_name' => 'display_title_en',
				// 	'type' => 'text',
				// 	'display_as' => 'Display Title EN',
				// ),

				'image_tag_relation' => array(
					'relation_id' => 'image_tag_relation',
					'type' => 'm_n_relation',
					'table_mn' => 'image_tag_relation',
					'table_mn_pk' => 'id',
					'table_mn_col_m' => 'repo_id',
					'table_mn_col_n' => 'tag_id',
					'table_m' => 'image_repository',
					'table_n' => 'image_tags',
					'table_n_pk' => 'id',
					'table_n_value' => 'name',
					'table_n_value2' => 'id',
					'display_as' => 'Tags',
					'box_width' => 400,
					'box_height' => 250,
					'filter' => true,
				),
				//   'image_privacy_tag_relation' => array(
				// 	'relation_id' => 'image_privacy_tag_relation',
				// 	'type' => 'm_n_relation',
				// 	'table_mn' => 'image_privacy_tag_relation',
				// 	'table_mn_pk' => 'id',
				// 	'table_mn_col_m' => 'repo_id',
				// 	'table_mn_col_n' => 'privacy_tag_id',
				// 	'table_m' => 'image_repository',
				// 	'table_n' => 'privacy_tags',
				// 	'table_n_pk' => 'id',
				// 	'table_n_value' => 'name',
				// 	'table_n_value2' => 'id',
				// 	'display_as' => 'Privacy Tags',
				// 	'box_width' => 400,
				// 	'box_height' => 250,
				// 	'filter' => true,
				// ),




				'description' => array(
					'db_name' => 'description',
					'type' => 'multiline',
					'height' => 100,
					'display_as' => 'Description',
				),

				'description_en' => array(
					'db_name' => 'description_en',
					'type' => 'multiline',
					'height' => 100,
					'display_as' => 'Description English',
				),

				'credits' => array(
					'db_name' => 'credits',
					'type' => 'multiline',
					'height' => 100,
					'display_as' => 'Credits',
				),

				'credits_en' => array(
					'db_name' => 'credits_en',
					'type' => 'multiline',
					'height' => 100,
					'display_as' => 'Credits English',
				),

				'category' => array(
					'db_name' => 'category',
					'type' => 'select',
					'display_as' => 'Category',
					'options' => $categories_array,
				),



				// 'last_edited' => array(
				// 	'db_name' => 'last_edited',
				// 	'type' => 'hidden',
				// 	'display_as' => 'Last Edit',
				// ),
				'date_added' => array(
					'db_name' => 'date_added',
					'type' => 'hidden',
					'display_as' => 'Date Created',
				),


				'alt_text' => array(
					'db_name' => 'alt_text',
					'type' => 'text',
					'display_as' => 'Alt text DE',
				),

				'alt_text_en' => array(
					'db_name' => 'alt_text_en',
					'type' => 'text',
					'display_as' => 'Alt text EN',
				),




			)
		);

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}



	public function customizeImage()
	{

		$id = $_POST['id'];

		if (isset($_POST['image_delete'])) {
			// var_dump($_POST['image_delete']);
			if ($_POST['image_delete'] == 'on') {
				// var_dump('assd');
				$this->cm->deleteRepoImage($id);
				exit;
			}

		}


		$public = 0;

		if (isset($_POST['image_public'])) {
			if ($_POST['image_public'] == 'on') {
				$public = 1;
			} else {
				$public = 0;
			}
		}


		$image_tag = $_POST['image_tag'];
		$image_tag_remove = $_POST['image_tag_remove'];
		// $privacy_tag = $_POST['privacy_tag'];
		// $visibility = $_POST['image_visible'];

		$data = array(
			'public' => $public,
			'id' => $id,
		);

		$this->cm->customizeImage($data);



			$existing = $this->cm->getExistingImageTag($image_tag, $id);
			if ($existing == false) {

			if ($image_tag) {
				$data2 = array(
					'tag_id' => $image_tag,
					'repo_id' => $id
				);

				$this->cm->insertRepoImageTags($data2);
			} else {
				if ($image_tag_remove) {
					$this->cm->deleteRepoImageTags($image_tag_remove, $id);
				}
			}

		}

		// if($privacy_tag){

		// 	$data3 = array(
		// 		'privacy_tag_id' => $privacy_tag,
		// 		'repo_id' => $id
		// 	);

		// $existing = $this->cm->getExistingPrivacyTag($privacy_tag, $id);
		// if($existing == false){
		// 	$this->cm->insertRepoPrivacyTags($data3);
		// }
	}




	public function saveImage()
	{
		$title_en = $_POST['image_title_en'];
		$title = $_POST['image_title'];
		$repo_type = isset($_POST['repo_type']) ? $_POST['repo_type'] : 'undefined';


		if (isset($_POST['image_public'])) {
			$public = $_POST['image_public'];

			if ($public == 'on' || $public == 1 || $public == '1' || $public == 'true' || $public == true) {
				$public = 1;
			} else {
				$public = 0;
			}
		} else {
			$public = 0;
		}


		// $privacy_tag = $_POST['privacy_tag'];
		$image_tag = $_POST['image_tag'];
		// $date_taken = $_POST['date_taken'];

		$fname = $_POST['repo_fname'];
		// $fname_orig = $_POST['repo_fname_orig'];
		// $type = $_POST['repo_type'];
		$image_category = $_POST['image_category'];




		$image_alt_text = $_POST['image_alt_text'];
		$image_alt_text_en = $_POST['image_alt_text_en'];

		$image_credits_text = $_POST['image_credits_text'];
		$image_credits_text_en = $_POST['image_credits_text_en'];


		$data = array(
			'title_en' => $title_en,
			'title' => $title,
			'category' => $image_category,
			'fname' => $fname,
			'public' => $public,
			// 'fname_orig' => $fname_orig,
			'alt_text' => $image_alt_text,
			'alt_text_en' => $image_alt_text_en,
			'credits' => $image_credits_text,
			'credits_en' => $image_credits_text_en,
		);




		// store file based on type
		$explode = explode('.', $fname);
		$ext = end($explode);

		if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
			$data['fname'] = $fname;
		} else {
			$data['fname'] = $fname;
		}

		// <div class="repo_item_title">' . $item->category_name . '</div>


		$iid = $this->cm->insertRepoImage($data);

		if ($image_tag) {
			$data2 = array(
				'tag_id' => $image_tag,
				'repo_id' => $iid
			);

			$this->cm->insertRepoImageTags($data2);
		}



		$item = $this->cm->getRepositoryImageByID($iid);
		$inr = '';

		$elem = '<div class="repo_item" data-id="' . $iid . '"  data-title="' . $title . '" inr="' . $inr . '">
        			<img class="repo_img" src="' . site_url('items/uploads/images/' . $fname) . '" />
        			<div class="repo_item_title">' . $title . '</div>
        			<div class="repo_item_title">' . $inr . '</div>
        			<div class="repo_item_select" title="' . $title . '" iid="' . $iid . '" fname="' . $fname . '">Select</div>
        		</div>';

		echo json_encode(array('status' => 'success', 'item' => $elem, 'type' => $repo_type));
	}


	public function upload_image()
	{

		$this->load->helper('besc_helper');


		$parsed_url = parse_url(site_url());
		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
		// $hostUrl = $host . "/" . 'hdgoe/Website';

		// FILENAME
		$filename = $_POST['filename'];

		$upload_path = $_POST['uploadpath'];
		$file_size = $_POST['file_size'];
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$serverFile = time() . "_" . $rnd . "." . $ext;
		$folderPath = str_replace("CMS", "", getcwd());
		$error = move_uploaded_file($_FILES['data']['tmp_name'], $folderPath . "/$upload_path/$serverFile");
		$serverFileOrig = '';


		// THUMBNAIL

		$pathTofile = $folderPath . "/$upload_path/$serverFile";
		$pathToThumbs = $folderPath . "/$upload_path/thumbs/$serverFile";
		$pathTofrontendImages = $folderPath . "/$upload_path/frontend_images/$serverFile";

		$thumbWidth = THUMB_WIDTH;
		$frontendImageWidth = FRONTEND_WIDTH;



		if($ext != 'svg'):

			$dataSize = getimagesize($folderPath . "/$upload_path/$serverFile");
			$size = $dataSize[0] . "x" . $dataSize[1];


			try {

				// THUMBNAIL
				$image = new Imagick();

				$image->readImage($pathTofile);


				// load image and get image size
				$d = $image->getImageGeometry();

				$w = $d['width'];
				$h = $d['height'];

				if ($w < $thumbWidth) {
					$thumbWidth = $w;
					$frontendImageWidth = $w;
				}


				// calculate thumbnail size
				$new_width = $thumbWidth;
				$new_height = floor($h * ($thumbWidth / $w));

				// set compression
				$image->setImageCompressionQuality(85);


				// create a new thumb image
				$image->resizeImage($new_width, $new_height, Imagick::FILTER_LANCZOS, 1, true);

				// clear and destroy
				$image->writeImage($pathToThumbs);
				$image->clear();
				$image->destroy();

				// FRONTEND IMAGE
				$frontend_image = new Imagick();

				$frontend_image->readImage($pathTofile);


				// calculate thumbnail size
				$new_width = $frontendImageWidth;
				$new_height = floor($h * ($frontendImageWidth / $w));

				$frontend_image->setImageCompressionQuality(85);

				$frontend_image->resizeImage($new_width, $new_height, Imagick::FILTER_LANCZOS, 1, true);

				$frontend_image->writeImage($pathTofrontendImages);
				$frontend_image->clear();
				$frontend_image->destroy();


			} catch (ImagickException $e) {
				// var_dump($e);
			}


		else:

			$size = 'x';
       copy($pathTofile, $pathToThumbs);
        copy($pathTofile, $pathTofrontendImages);
		endif;

		echo json_encode(
			array(
				'success' => true,
				'path' => $folderPath . "/$upload_path/$serverFile",
				'fullpath' => $host . "/$upload_path/$serverFile",
				'size' => $size,
				'filename' => $serverFile,
				'filename_orig' => $serverFileOrig
			)
		);
	}

	function crop_image()
	{

		$db = DB_NAME;
		$parsed_url = parse_url(site_url());
		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
		$hostUrl = $host . "/" . 'secession';
		$type = $_POST['type'];
		$collection = $_POST['collection'];
		$title = $_POST['title'] . " Cropped";
		$image_alt_text = $_POST['alt'];
		$image_alt_text_en = $_POST['alt_en'];
		$image_category = $_POST['category'];
		$image_tag = $_POST['tag'];
		$filename = $_POST['fname'];
		$upload_path = 'items/uploads/images/';
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$serverFile = time() . "_" . $rnd . "." . $ext;
		$fname = str_replace("." . $ext, "", $filename) . "_crop." . $ext;
		$folderPath = getcwd();
		$source = $folderPath . "/$upload_path/$filename";

		$this->load->library('image_moo');

		//300*225
		$size = getimagesize($source);
		$ratio = 1;
		$x1 = $_POST['x1'];
		$y1 = $_POST['y1'];
		$x2 = $_POST['x2'];
		$y2 = $_POST['y2'];
		$w = isset($_POST['w']) ? $_POST['w'] : 278;
		$h = isset($_POST['h']) ? $_POST['h'] : 200;

		/*   if($size[0] < 800)
		{
		$ratio = $size[0] / 800;
		}
		*/
		//var_dump($x1 * $ratio." ".$y1 * $ratio." ".$x2 * $ratio." ".$y2 * $ratio);

		// $resize_height=($size[1]*746)/$size[0];


		//$this->image_moo->load($source)->resize($w,$h)->save($folderPath. "/$upload_path/$fname",true);
		// $this->image_moo->load($folderPath. "/$upload_path/$filename")->resize($w,$h)->save($folderPath. "/$upload_path/$fname",true);
		$this->image_moo->load($folderPath . "/$upload_path/$filename")->crop($x1 * $ratio, $y1 * $ratio, $x2 * $ratio, $y2 * $ratio)->save($folderPath . "/$upload_path/$fname", true);
		//var_dump($this->image_moo->di splay_errors());

		$data = array(
			'fname' => $fname,
			'title' => $title,

			'category' => $image_category,
			'tag' => $image_tag,
			'alt_text' => $image_alt_text,
			'alt_text_en' => $image_alt_text_en
		);

		$iid = $this->cm->insertRepoImage($data, $db);

		echo json_encode(
			array(
				'success' => true,
				'path' => $folderPath . "/$upload_path/$fname",
				'fullpath' => $host . "/$upload_path/$fname",
				'filename' => $fname
			)
		);
	}
}