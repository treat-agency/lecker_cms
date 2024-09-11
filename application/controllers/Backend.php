<?php defined('BASEPATH') or exit('No direct script access allowed');

include(APPPATH . 'controllers/BACKEND/' . "Helper_Backend.php");


class Backend extends MY_Controller
{
	protected $user;
	protected $base_url;
	protected $module_tables = array();


	function __construct()
	{

		parent::__construct();
		$this->load->helper('url');


		if (!$this->logged_in()) {

			$url = '';
			$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$url = str_replace(site_url(), '', $current_url);

			redirect('authentication/showLogin?previous_url=' . $url);
		}
		$this->load->library('zip');

		$this->load->library('form_validation');
		$this->user = $this->Authentication_model->getUserdataByID($this->session->userdata('user_id'))->row();
		$this->load->library('Besc_crud');

		require_once(APPPATH . 'libraries/fpdf.php');
        require_once(APPPATH . 'libraries/FPDI/src/autoload.php');
        require_once(APPPATH . 'libraries/PHPExcel.php');
        require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');
	}

	use Helper_Backend;

	public function index()
	{
		$widget_data = $this->widget_data();
		$widgets_html = $this->load->view('backend/widgets', $widget_data, TRUE);
		$data['widgets'] = $widgets_html;

		$recently_added_items_original = $this->bm->getRecentlyAddedItems();

		$entity_array = array();
		foreach ($recently_added_items_original as $item) {

				$entity = $this->cm->getAnyEntityOrNoarticle($item->type, $item->entity_id);

				if($entity) {
					$other_language_items = $this->bm->getOtherLanguageItems($item->id);

				$this->repoEntityType = $item->type;
				$this->repoEntityId = $item->entity_id;
				$this->repoHasArticle = 1;

				$entity->teaser_images = $this->getTeaserImages();

				$entity->main_article = $item;
				$entity->other_language_articles = $other_language_items;

				$entity_array[] = $entity;
				}


		}

		$data['recent_entities'] = $entity_array;

		$this->page('backend/home', $data);
	}

	public function fix_pretty_url()
	{
		/*$artists = $this->bm->getAllArtists();
		foreach($artists as $artist)
		{
			if($artist->pretty_url == '' || $artist->pretty_url == NULL)
			{
				$new_pretty = $artist->first_name."-".$artist->last_name;
				$new_pretty = $this->remove_accents($new_pretty);
				$new_pretty = trim($new_pretty);
				$new_pretty = str_replace(' ', '-', $new_pretty);
				$new_pretty = str_replace('/', '-', $new_pretty);
				$url_pretty = str_replace('&', '-', $new_pretty);

				$update_data = array('pretty_url' => $url_pretty);

				$this->bm->updateArtist($artist->id, $update_data);

				echo $artist->first_name." ".$artist->last_name." -> ".$url_pretty."<br/>";
			}
		}*/
	}

	public function definingTypeOfSelected()
	{

		// add different type of processing here and required fields
		$type = '';
		$typeKeys = array(
			'entity_with_articles' => array('articleType', 'pk'),
			'universal' => array('table', 'pk')
		);

		foreach ($typeKeys as $typeName => $keyArray) {
			$can_add = true;
			foreach ($keyArray as $attribute) {
				if (isset($_POST[$attribute]) && !$_POST[$attribute]) {
					$can_add = false;
					break;
				}
			}

				if ($can_add == true) {
					$type = $typeName;
					break;
				}
				;


		}

		return $type;
	}

		public function editSelected()
	{

		/**************************  TYPE SELECTOR REQUIRED FIELDS *****************************/

		$type = $this->definingTypeOfSelected();


		$table = $_POST['table'];
		$pk = $_POST['pk'];


		/***************  ENTITIES WITH ARTICLES ******************/



		/****  attributes to edit ****/
		// ARTICLE
		if($type == 'entity_with_articles'){

			$visible = $_POST['visible']  === "true" ? 1 : 0;
			$delete = $_POST['deleted']  === "true" ? 1 : 0;
			$general_tag_add = $_POST['general_tag_add'];
			$general_tag_delete = $_POST['general_tag_delete'];



		// ENTITY

		/****  identifying ****/
		$articleType = $_POST['articleType'];
		$articleIds = explode(',', $_POST['articleIds']);


		// get articles

		$articlesArray = array();

		foreach($articleIds as $articleId){
			$article = $this->cm->getAnyItemById($articleId);
			if($article){
				$articlesArray[] = $article;
			}
		}



		/****  updating ****/

		// ARTICLE
		foreach($articlesArray as $article){
			$article->visible = $visible;
			$this->bm->updateItemById($article->id, $article);

			if($delete){
				$this->cm->removeAnything('items', $article->id);
			}
		}

		// ENTITY

		// get type
		$entityName = $this->getEntityName($articleType);
		if($delete){
			$this->cm->removeAnything($entityName, $pk);
		}


		// get entity
		if($general_tag_add){
			$existing_tag = $this->bm->getTagRelationByEntityIdAndTagId($pk, $articleType, $general_tag_add);
			if(!$existing_tag){
				$newTagRelation = array(
					'entity_id' => $pk,
					'tag_id' => $general_tag_add,
					'type' => $articleType
				);

				$this->bm->insertTagRelation($newTagRelation);

			}
		}

		if($general_tag_delete){
			$existing_tag = $this->bm->getTagRelationByEntityIdAndTagId($pk, $articleType, $general_tag_delete);
			if($existing_tag){
				$this->bm->removeTagRelation($existing_tag->id);
			}
		}


			/***************  PUT ANY ******************/
			/***************  SPECIFIC ******************/
			/***************  HERE ******************/



			/***************  UNIVERSAL ******************/



		} elseif($type == 'universal'){


			$delete = $_POST['deleted'] === "true" ? 1 : 0;

			if($delete){
				$this->cm->removeAnything($table, $pk);
			}


		}



		echo json_encode(array('success' => true));


	}


	public function updatRepo()
	{

		$post_properties = ['repo_id', 'entity_id', 'ordering', 'type', 'has_article'];

		$this->postPropertiesExist($post_properties, 'Teaser Selector'); // check if all post properties are present



		$repo_id = $_POST['repo_id'];
		$entity_id = $_POST['entity_id'];
		$ordering = $_POST['ordering'];
		$type = $_POST['type'];
		$has_article = $_POST['has_article'];

		$this->methodExists('bm', 'insertEntityTeaserImage' ,'Teaser Selector');

		$data = array('repo_id' => $repo_id, 'entity_id' => $entity_id, 'ordering' => $ordering, 'type' => $type, 'has_article' => $has_article);

		$this->bm->insertEntityTeaserImage($data);



		echo json_encode(array('success' => true));
	}

	public function updateRepoItem()
	{

		$post_properties = ['repo_id', 'entity_id', 'ordering', 'type', 'has_article'];

		$this->postPropertiesExist($post_properties, 'Teaser Selector'); // check if all post properties are present

		$repo_id = $_POST['repo_id'];
		$entity_id = $_POST['entity_id'];
		$ordering = $_POST['ordering'];
		$type = $_POST['type'];
		$has_article = $_POST['has_article'];


		// checking for existing tables and methods
		$this->methodExists('bm', 'updateEntityTeaserImage' ,'Teaser Selector');

		$data = array('repo_id' => $repo_id, 'entity_id' => $entity_id, 'ordering' => $ordering, 'type' => $type, 'has_article' => $has_article);

		$this->bm->updateEntityTeaserImage($entity_id, $repo_id, $data, $type, $has_article);

		echo json_encode(array('success' => true));
	}

	public function zip()
	{

				$this->zip->clear_data();


	        $srcs = json_decode($_POST['srcs']);




					if(count($srcs)){
					foreach($srcs as $s){
						$src = str_replace(site_url(), getcwd() . '/', $s);

				    $add_file = $this->zip->read_file($src);

					}

					$path = getcwd() . '/items/uploads/zip/' . 'images.zip';


					$archive = $this->zip->archive($path);

					$path_json = 'items/uploads/zip/' . 'images.zip';

					echo json_encode(array('path' => $path_json));


					// $this->zip->download('images.zip');


	}
}


	public function removeRepo()
	{

		$post_properties = ['repo_id', 'entity_id', 'type', 'has_article'];


		$repo_id = $_POST['repo_id'];
		$entity_id = $_POST['entity_id'];
		$type = $_POST['type'];
		$has_article = $_POST['has_article'];

		$this->methodExists('bm', 'removeEntityTeaserImage' ,'Teaser Selector');

			$data = array('repo_id' => $repo_id, 'entity_id' => $entity_id, 'type' => $type, 'has_article' => $has_article);

			$this->bm->removeEntityTeaserImage($data);




		echo json_encode(array('success' => true));
	}

	public function removeAny()
	{

		$pk_value = $_POST['pk_value'];
		$db_name = $_POST['db_name'];
		$table = $_POST['table'];
		$article_type = $_POST['article_type'];
		$pk_column = 'id';

		// if this is an item in original language it will also delete the second language
		 if($table == 'items'){
			$item = $this->cm->getItemById($pk_value);

			if($item && NUMBER_OF_LANGUAGES == 2 && $item->lang == MAIN_LANGUAGE){
					$other_language_item = $this->cm->getOtherLanguageItem($item->id);
					if($other_language_item){
								$this->cm->removeAnything($table, $other_language_item->id);
					}
			}
		}

		if (isset($article_type) && $article_type && $article_type > 0) {
			$articles = $this->cm->getArticlesByEntityId($pk_value, $article_type);

			foreach ($articles as $article) {
				$this->cm->removeAnything('items', $article->id);
				}

		}

	  if($this->bc_model->delete($db_name, $table, $pk_column, $pk_value, $article_type)>0){
					echo json_encode(array('success' => true));
		} else {
				echo json_encode(array('success' => false));
		}


	}




	public function files_relation($item_type, $item_id)
	{
		$data['item_type'] = $item_type;
		$data['item_id'] = $item_id;
		$err = false;
		if($item_type == 'artefakte' || $item_type == 'ereignis' || $item_type == 'person' || $item_type == 'edition' || $item_type == 'publication'){
			$selected_files = $this->bm->get_files_by_artefakte($item_id);
		}else{
			$err = true;
		}

		$selected_files = $this->bm->get_entity_files($item_type, $item_id);
		$data['selected_files'] = $selected_files;
		$data['repo_categories'] = $this->cm->getRepoCategories();

		$selected_files_ids = array_column($selected_files, 'id');

		if (!$err) {
			$all_files = $this->bm->get_files();

			foreach ($all_files as $file) {
				$file->selected = in_array($file->id, $selected_files_ids);
				$file_category = $this->bm->get_repo_category_by_id($file->category);
				$file->category_name = $file_category != false ? $file_category->name : 'NONE';
			}

			$data['all_files'] = $all_files;
			$this->page('backend/files_relation', $data);
		} else {
			echo 'Error: code IR01';
		}
	}


	public function add_delete_file_relation()
	{
		$item_id = $_POST['item_id'];
		$item_type = $_POST['item_type'];
		$repo_item_id = $_POST['repo_item_id'];
		$selected = $_POST['selected'];
		$file_order = $_POST['file_order'];
		$insert_id = -1;
		$err = false;
		$success = true;
		/* switch ($item_type) {
			case 'artefakte':
				if ($selected == "true") {
					$this->bm->remove_files_artefakte_relation($item_id, $repo_item_id);
					$action = 'remove';
				} else {
					$insert_data = array(
						'artefakte_id' => $item_id,
						'file_id' => $repo_item_id,
						'file_order' => $file_order,
					);
					$insert_id =	$this->bm->insert_files_artefakte_relation($insert_data);
					$action = 'insert';
				}
				break;
			case 'ereignis':
				if ($selected == "true") {
					$this->bm->remove_files_ereignis_relation($item_id, $repo_item_id);
					$action = 'remove';
				} else {
					$insert_data = array(
						'ereignis_id' => $item_id,
						'file_id' => $repo_item_id,
						'file_order' => $file_order,
					);
					$insert_id = $this->bm->insert_files_ereignis_relation($insert_data);
					$action = 'insert';
				}
				break;
			case 'person':
				if ($selected == "true") {
					$this->bm->remove_files_person_relation($item_id, $repo_item_id);
					$action = 'remove';
				} else {
					$insert_data = array(
						'person_id' => $item_id,
						'file_id' => $repo_item_id,
						'file_order' => $file_order,
					);
					$insert_id = $this->bm->insert_files_person_relation($insert_data);
					$action = 'insert';
				}
				break;
			case 'types':
				if ($selected == "true") {
					$this->bm->remove_files_type_relation($item_id, $repo_item_id);
					$action = 'remove';
				} else {
					$insert_data = array(
						'typ_id' => $item_id,
						'file_id' => $repo_item_id,
						'file_order' => $file_order,
					);
					$insert_id = $this->bm->insert_files_type_relation($insert_data);
					$action = 'insert';
				}
				break;
			default:
				$success = false;
				$err = 'Not a valid type';
		} */

		if (in_array($item_type, ['artefakte', 'ereignis', 'person', 'edition', 'publication'])) {
			if ($selected == "true") {
				$this->bm->remove_files_entity_relation($item_type,$item_id, $repo_item_id);
				$action = 'remove';
			} else {
				$insert_data = array(
					$item_type.'_id' => $item_id,
					'file_id' => $repo_item_id,
					'file_order' => $file_order,
				);
				$insert_id = $this->bm->insert_files_entity_relation($item_type,$insert_data);
				$action = 'insert';
			}
		}else{
			$success = false;
			$err = 'Not a valid type';
		}


		echo json_encode(array(
			'success' => $success,
			'selected' => $selected,
			'item_type' => $item_type,
			'insert_id' => $insert_id,
			'action' => $action,
			'err' => $err,
		));
	}

	public function get_update_file_order()
	{

		$item_id = $_POST['item_id'];
		$item_type = $_POST['item_type'];
		$order_array = $_POST['order_array'];
		$err = false;
		$success = true;
		$update_list = true;
		$selected_files = false;

		if (in_array($item_type, ['artefakte', 'ereignis', 'person', 'edition', 'publication'])) {
			if ($order_array != 'false') {
				foreach ($order_array as $item_order) {
					$con_id = intval($item_order['con_id']);
					$order = intval($item_order['order']);
					$this->bm->update_entity_file_order($item_type, $con_id, $order);
				}
				$update_list = false;
			}
			$selected_files = $this->bm->get_entity_files($item_type, $item_id);
		}


		echo json_encode(array(
			'success' => $success,
			'item_type' => $item_type,
			'item_id' => $item_id,
			'selected_files' => $selected_files,
			'update_list' => $update_list,
			'err' => $err,
		));
	}



	public function widget_data()
	{

		$widget_data['widgets'] = $this->bm->getWidgets($this->session->userdata('user_id'));

		// custom, default and shop widgets init
		$new_widgets = array();
		$default_widgets = array();
		$shop_widgets = array();

			// check if the methods were not deleted
	 $this->methodExists('bm', 'getAnything', 'Widget Display');
	 $this->methodExists('bm', 'getLeckerDashboard', 'Widget Display');
	 $this->tableExists('lecker_dashboard', 'Widget Display');

		// getting custom widgets
		$dashboard = $this->bm->getLeckerDashboard();
		 foreach($dashboard as $b) {

      if($b->table != ''){
          // checking if method to get any table and table exist
          $this->tableExists($b->table, $topic = 'Widget Display');

          // name
          $table_name = $b->table;
          $pretty_name = $this->getPrettyName($table_name);

          // color
          $color = $this->bm->get_color_by_id($b->color);
          $hexColor = $color->hex;

          // item
          $items = $this->bm->getAnything($table_name);

					// tags or categories

					$url_categories = '';

					$table_name_singular = $this->singularizeName($table_name);

					$tags_table_exists = $this->db->table_exists($table_name_singular . '_tags');



					$url_tags = $tags_table_exists ? 'entities/Content/' . $table_name_singular . '_tags' : '';


					$categories_table_exists = $this->db->table_exists($table_name . '_tags');
					$url_categories = $categories_table_exists ? 'entities/Content/' . $table_name_singular . '_categories' : '';


          // adding widget
          $new_widgets[] = (object)[
          "title" => $pretty_name,
          "count" => count($items),
          "text" => $pretty_name,
          "color" => $hexColor,
          "url" => 'entities/Content/' . $table_name,
          "url_tags" => $url_tags,
          "url_categories" => $url_categories,
        ];
    }
	}


	 // default widgets

    $items = $this->bm->get_items();
    $default_widgets[] = (object)[
      "title" => 'Pretty URLS',
      "count" => count($items),
      "text" => 'Articles',
      "color" => ITEMS_COLOR,
      "url" => 'entities/Content/normals',
		"url_tags" => 'entities/Content/normal_tags',
    ];

    $images = $this->bm->getRepoImages();
    $default_widgets[] = (object)[
     "title" => 'Images',
     "count" => count($images),
     "text" => 'Images',
     "color" => IMAGES_COLOR,
     "url" => 'entities/Content/teaser_selector',
     "url_tags" => 'entities/Repository/tags',
     "url_categories" => 'entities/Repository/categories',
    ];

		$files = $this->bm->getFiles();
    $default_widgets[] = (object)[
     "title" => 'Files',
     "count" => count($files),
     "text" => 'Files',
     "color" => FILES_COLOR,
     "url" => 'entities/Content/files',
		 "url_tags" => 'entities/Content/file_tags',
    ];

		// shop widgets

		$shop_widgets = false;
		if(IS_SHOP == 1):
		// getting shop table in use WITHOUT s_
			$products_tables = array('products', 'product_categories', 'product_tags', 'product_versions', );
			$orders_tables = array('orders', 'ordered_products', 'order_notes', 'taxes', 'vouchers');
			$customers_tables = array('customers', 'favorites');

			$products_array = array();
			$orders_array = array();
			$customers_array = array();

			foreach($products_tables as $p){
				$this->tableExists('s_' . $p, 'Getting Shop Widgets');

			  $pretty_name = $this->getPrettyName($p);

				$items = $this->bm->getAnything('s_' . $p);

				$products_array[] = (object)[
						"title" => $pretty_name,
						"count" => count($items),
						"text" => $pretty_name,
						"url" => 'entities/Content/' . 's_' . $p,
						];
			}

			foreach($orders_tables as $p){
				$this->tableExists('s_' . $p, 'Getting Shop Widgets');

			  $pretty_name = $this->getPrettyName($p);

				$items = $this->bm->getAnything('s_' . $p);

				$orders_array[] = (object)[
						"title" => $pretty_name,
						"count" => count($items),
						"text" => $pretty_name,
						"url" => 'entities/Content/' . 's_' . $p,
						];
			}

			foreach($customers_tables as $p){
				$this->tableExists('s_' . $p, 'Getting Shop Widgets');

			  $pretty_name = $this->getPrettyName($p);

				$items = $this->bm->getAnything('s_' . $p);

				$customers_array[] = (object)[
						"title" => $pretty_name,
						"count" => count($items),
						"text" => $pretty_name,
						"url" => 'entities/Content/' . 's_' . $p,
						];
			}

		$shop_widgets = (object)[
			"products" => $products_array,
			"orders" => $orders_array,
			"customers" => $customers_array,
		];

	   endif;



		// adding widgets to data
    $widget_data['new_widgets'] = $new_widgets;
    $widget_data['default_widgets'] = $default_widgets;
    $widget_data['shop_widgets'] = $shop_widgets;
    return $widget_data;
  }




	public function add_widget()
	{
		$category = $_POST['category'];
		$table = $_POST['table'];
		$icon = $_POST['icon'];
		$color = $_POST['color'];
		$note = $_POST['note'];

		$data = array(
			'category' => $category,
			'subpage' => $table,
			'img' => $icon,
			'short_text' => $note,
			'color' => $color,
			'user_id' => $this->session->userdata('user_id')
		);
		$this->bm->addWidget($data);

		echo json_encode(array('success' => true));
	}

	public function remove_widget()
	{
		$wid = $_POST['wid'];
		$this->bm->removeWidget($wid);
		echo json_encode(array('success' => true));
	}

	public function refresh_widgets()
	{
		$widget_data['widgets'] = $this->bm->getWidgets($this->session->userdata('user_id'));
		/*	$widget_data['pending_images'] = count($this->bm->getPendingImages());
		$widget_data['pending_images_multi'] = count($this->bm->getPendingImagesMulti());
		$widget_data['pending_images_heldenplatz'] = count($this->bm->getPendingImagesHeldenplatz());
		$widget_data['pending_contacts'] = count($this->bm->getPendingContacts());
		$widget_data['pending_tours'] = count($this->bm->getPendingTours());
		$widget_data['pending_videos'] = count($this->bm->getPendingVideosMulti());*/
		$widgets_html = $this->load->view('backend/widgets', $widget_data, TRUE);

		echo json_encode(array('html' => $widgets_html));
	}



	public function add_quicklink()
	{
		$category = $_POST['category'];
		$table = $_POST['table'];
		$note = $_POST['note'];

		$data = array(
			'category' => $category,
			'subpage' => $table,
			'short_text' => $note,
			'user_id' => $this->session->userdata('user_id')
		);

		$this->bm->addQuicklink($data);

		echo json_encode(array('success' => true));
	}

	public function remove_quicklink()
	{
		$id = $_POST['id'];
		$this->bm->removeQuicklink($id);
		echo json_encode(array('success' => true));
	}







	public function deleteParticipant()
	{
		$id = $_POST['participant'];
		$status = $this->cm->deleteParticipantByID($id);

		echo json_encode(array('success' => $status));
	}



	public function editParticipant()
	{
		$id = $_POST['id'];
		$tour_num_people = $_POST['tour_num_people'];
		$tour_num_children = $_POST['tour_num_children'];
		$tour_name = $_POST['tour_name'];
		$tour_email = $_POST['tour_email'];
		$tour_phone = $_POST['tour_phone'];
		$tour_comment = $_POST['tour_comment'];


		$status = $this->cm->editParticipantByID($id, $tour_num_people, $tour_num_children, $tour_name, $tour_email, $tour_phone, $tour_comment);


		echo json_encode(array('success' => $status));
	}


	public function updateSorting()
	{
		$items = $_POST['items'];

		foreach ($items as $item) {
			$data = array('ordering' => $item['order']);

			$this->bm->updateSorting($item['id'], $data);
		}

		echo json_encode(array('success' => true));
	}

	public function updateStartOrder()
	{
		$items = $_POST['items'];

		foreach ($items as $item) {
			$data = array('ordering' => $item['order']);

			$this->bm->updateStartingOrder($item['id'], $data);
		}

		echo json_encode(array('success' => true));
	}




	public function export(){
		$error = false;
		$table = $_POST['table'];
		$ids = $_POST['ids'];
		$fields = $_POST['fields'];
		$items = $this->bm->get_entity_by_ids($table, $ids, $fields);

		$file = fopen($_SERVER["DOCUMENT_ROOT"] . '/kunstraum_archiv/items/general/lecker_export_'.$table.'.csv', 'w');

		// save the column headers
		fputcsv($file, explode(', ',$fields), ";");
		// Sample data. This can be fetched from mysql too
		$data = $items;

		// save each row of the data
		foreach ($items as $row) {
			fputcsv($file, (array) $row, ";");
		}

		// Close the file
		fclose($file);

		if(!$error){
			$result = array(
				'success' => true,
				'file' => base_url() . 'items/general/lecker_export_'.$table.'.csv'
			);
		}else{
			$result = array(
					'success' => false,
					'error' => $error
			);
		};

		echo json_encode($result);
	}




	/***********************************************************************************
	 * DISPLAY FUNCTIONS
	 **********************************************************************************/

	public function page($content_view, $content_data = array())
	{

		$data = array();
		$data['userdata'] = $this->user;
		$data['username'] = $this->user->username;
		$data['dev'] = $this->user->dev;
		$data['additional_css'] = isset($content_data['additional_css']) ? $content_data['additional_css'] : array();
		$data['additional_js'] = isset($content_data['additional_js']) ? $content_data['additional_js'] : array();
		$data['colors'] = $this->bm->get_colors();
		$data['teaser_counts'] = isset($content_data['teaser_counts']) ? $content_data['teaser_counts'] : 0;

		if(isset($content_data['typeName'])):
		$data['typeName'] = $content_data['typeName'];
		$data['entityId'] = $content_data['entityId'];
		$data['articleForTeaser'] = $content_data['articleForTeaser'];
		$data['englishArticleForTeaser'] = $content_data['englishArticleForTeaser'];
		endif;



		$db = DB_NAME;
		$data['menupoints'] = $this->bm->getMenupoints($this->session->userdata('user_id'), $db);


		/***** CUSTOM MENUS *****/
		// checking used methods and tables
		$this->methodExists('bm', 'getLeckerAreas', "Getting Lecker Menus");
		$this->methodExists('bm', 'getLeckerMenus', "Getting Lecker Menus");
		$this->methodExists('bm', 'getLeckerSubmenus', "Getting Lecker Menus");

		$this->tableExists('lecker_areas', "Getting Lecker Menus");
		$this->tableExists('lecker_menus', "Getting Lecker Menus");
		$this->tableExists('lecker_submenus', "Getting Lecker Menus");

		$lecker_areas = $this->bm->getLeckerAreas();
		$lecker_menu_array = array();


		foreach($lecker_areas as $l){
			$menus = $this->bm->getLeckerMenus($l->id);
			$menus_array = array();

			foreach ($menus as $m){

				// getting snake case from name
				$m->snake_case = lcfirst(str_replace(' ', '_', $m->name));
				// getting submenus
				$submenus = $this->bm->getLeckerSubmenus($m->id);
				$submenus_array = array();


				foreach ($submenus as $sm){
					$sm->name = $this->getPrettyName($sm->table);
					$sm->snake_case = $sm->table;
					$submenus_array[] = $sm;
				}

				$m->submenus = $submenus_array;
			  $menus_array[] = $m;

			}
			$l->menus = $menus_array;

			$lecker_menu_array[] = $l;
		}

		$data['custom_menus'] = $lecker_menu_array;



		$this->load->view('backend/head', $data);
		$this->load->view('backend/menu', $data);
		$this->load->view($content_view, $content_data);
		$this->load->view('backend/footer', $data);
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

		$error = move_uploaded_file($_FILES['data']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $upload_path . $serverFile);


		echo json_encode(array(
			'success' => true,
			'path' => "$upload_path/$serverFile",
			'filename' => $serverFile
		));
	}


	public function save_images()
	{
		$item_id = $_POST['item_id'];
		$images = $_POST['images'];

		$this->cm->deleteArtworkImages($item_id);

		foreach ($images as $image) {
			$insert_data = array('artwork_id' => $item_id, 'fname' => $image['fname'], 'ordering' => $image['ordering']);
			$this->cm->addArtworkImages($insert_data);
		}

		echo json_encode(array('success' => true));
	}


	public function upload_file()
	{
		$this->load->helper('besc_helper');

		$filename = $_POST['filename'];
		$upload_path = $_POST['uploadpath'];
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		/*  $rnd = rand_string(12);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);*/
		$serverFile = $filename;

		$error = move_uploaded_file($_FILES['data']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $upload_path . $serverFile);


		echo json_encode(array(
			'success' => true,
			'path' => "$upload_path/$serverFile",
			'filename' => $serverFile
		));
	}





	public function checkLoggedin()
	{
		if (!$this->logged_in()) {
			echo json_encode(
				array(
					'success' => false,
				)
			);
		} else {
			echo json_encode(
				array(
					'success' => true,
				)
			);
		}
	}
}
