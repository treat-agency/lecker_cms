<? defined('BASEPATH') or exit('No direct script access allowed');



trait Image_Content
	{
	/**************************    IMAGE  REPO FUNCTIONS       *******************************/

	// EDITING TEASER IMAGES FOR ARTICLE


	public function repository_overview()
		{
		$data['customize_selected'] = true;
		$this->loadRepoViewWithData($data);

		}

	public function teaser_selector($type = false, $entityId = false, $has_article = true)
		{

		$this->repoEntityType = $type;
		$this->repoEntityId = $entityId;
		$this->repoHasArticle = $has_article;


		if ($type):

			$this->addTeaserImagesData();

		endif;

		$this->loadRepoViewWithData($this->repoData);

		}


	public function repo_module($module_type = 'image', $item_id = false, $module_id = false)
		{

		$this->repoModuleType = $module_type;
		$this->repoModuleItemId = $item_id;
		$this->repoModuleId = $module_id;


		$this->getModuleImages();

		$data = $this->repoData;

		$data['module_type'] = $module_type;
		$data['module_item_id'] = $item_id;
		$data['module_id'] = $this->repoModuleId;


		$this->loadRepoViewWithData($data);

		}

	function loadRepoViewWithData($data = array())
		{
		$number = $_POST['number'] ?? null;
		$lastElem = $_POST['lastElem'] ?? null;
		$data = $this->repoFilter($data, $number, $lastElem);

		if (isset($number) && isset($lastElem)) {
			return $this->load->view('backend/repository_overview_more', $data);
			} else {
			return $this->page('backend/repository_overview', $data);
			}
		}





	public function repoFilter($data, $number = null, $lastElem = null)
		{
		$db = DB_NAME;

		$data['repo_categories'] = $this->cm->getRepoCategories($db);
		$data['repo_tags'] = $this->cm->getRepoTags($db);

		$data['repository_images'] = array();

		$date_added_selector = array();
		$repo = $this->cm->getRepositoryImages($db);

		$repository_images = array();

		$display_number = COUNT_LOADED_IMAGES;
		$data['display_number'] = $display_number;

		foreach ($repo as $r) {

			if ($r->fname):

				$date = explode(' ', $r->date_added)[0];

				$r->date_added = $date;

				if (!in_array($date, $date_added_selector)) {
					$date_added_selector[] = $date;


					}

				$r->img_path = site_url('items/uploads/images/thumbs/') . $r->fname;
				$r->img_path_full = site_url('items/uploads/images/') . $r->fname;

				$r->tags = array();
				foreach ($this->cm->getTagsForRepositoryImage($r->id) as $tag) {

					$ttt = $this->cm->getRepoTagById($tag->tag_id);
					if ($ttt) {
						$r->tags[] = $ttt;
						}

					}


				$repository_images[] = $r;
			endif;

			}

		// date added collected
		$data['date_added_selector'] = $date_added_selector;



		$source = ($number !== null) ? $_POST : $_GET;

		foreach ($this->repoFilterKeys as $k) {
			${$k} = "";
			if (isset($source[$k])) {
				if ($source[$k] == false || $source[$k] == 'false') {
					${$k} = "";
					} else {
					${$k} = urldecode($source[$k]);
					}

				$data[$k] = ${$k};
				}
			}

		if (isset($sort) && $sort == 'desc') {
			$repository_images = array_reverse($repository_images);
			}


		$filter = 0;

		// and filter
		$filtered_repo = [];

		if (!isset($text) && !isset($category) && !isset($tag) && !isset($date_taken) && !isset($date_added) && $text == '') {
			$filtered_repo = $repository_images;
			} else {

			foreach ($repository_images as $i) {



				$can_add = true;

				if (isset($text) && $text != '') {

					if (str_contains(strtolower($this->nullToString($i->title)), strtolower($text)) || str_contains(strtolower($this->nullToString($i->title_en)), strtolower($text))) {
						$filtered_repo[] = $i;
						}


					} else {

					$filter = 1;
					//FILTER IF NO TEXT SEARCH

					if (isset($category) && $category != false) {

						if ($i->category != $category) {
							$can_add = false;
							}

						}


					if (isset($tag) && $tag != false) {

						$can_add = false;
						foreach ($i->tags as $repo_tag) {
							if ($repo_tag->id == $tag) {
								$can_add = true;
								}
							}



						}

					if (isset($date_added) && $date_added != false) {

						if ($i->date_added != $date_added) {
							$can_add = false;
							}

						}

					if (isset($date_taken) && $date_taken != false) {

						if ($i->date_taken != $date_taken) {
							$can_add = false;
							}

						}




					if ($can_add == true) {
						$filtered_repo[] = $i;

						}
					}
				}


			}

		if ($number !== null && $lastElem !== null):
			$filtered_repo = array_slice($filtered_repo, $lastElem, $number);

		else:
			$data['repo_total'] = count($filtered_repo);
			$data['repo_current'] = COUNT_LOADED_IMAGES - 1;
		endif;



		$data['repository_images'] = $filtered_repo;


		return $data;

		}


	public function deletePreviousModuleImages()
	{
		$module_type = $_POST['module_type'];
		$module_id = $_POST['module_id'];


		$affected = $this->cm->deletePreviousModuleImages($module_type, $module_id);

		echo json_encode(
			array(
				'success' => true,
				'message' => 'Images deleted',
			)
		);

	}

	public function updateModuleImages()
		{


		$module_type = $_POST['module_type'];
		$repo_id = $_POST['repo_id'];
		$module_id = $_POST['module_id'];
		$description = isset($_POST['description']) ? $_POST['description'] : "";
		$ordering = $_POST['ordering'];

		$dd = array(
				'repo_id' => $repo_id,
				'description' => $description,
				'ordering' => $ordering,
				'module_id' => $module_id,
				'type' => $module_type,
			);


			$this->cm->addModuleImages($dd);


		echo json_encode(
			array(
				'success' => true,
				'message' => 'Image updated',
			)
		);



		}




	public function get_repo_image()
		{

		$repo_id = $_POST['repo_id'];
		$repo_item = $this->cm->getAnyRepoItemById($repo_id);
		$status = $repo_item ? true : false;
		echo json_encode(
			array(
				'success' => $repo_item ? true : false,
				'repo_item' => $repo_item,
			)
		);
		}

	public function image_categories()
		{
		if ($this->user->is_admin != 1) {
			redirect('');
			}

		$bc = new besc_crud();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Content');
		$bc->table_name('categories');
		$bc->table('image_categories');
		$bc->primary_key('id');
		$bc->title('Category');
		$bc->list_columns(array('name'));
		$bc->filter_columns(array('name'));


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


	function get_repo_data($data = array())
		{

		$data['repo_categories'] = $this->cm->getRepoCategories();
		$data['repository_images'] = array();

		$repo = $this->cm->getRepositoryImages();

		foreach ($repo as $r) {
			$r->inventoryNR = "";

			$data['repository_images'][] = $r;
			}
		return $data;
		}

	function crop_image()
		{

		$parsed_url = parse_url(site_url());
		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
		$hostUrl = $host . "/" . 'hdgoe/Website';

		$filename = $_POST['fname'];
		$upload_path = 'items/uploads/Website/module_image/';
		if (substr($upload_path, -1) != '/')
			$upload_path .= '/';

		$rnd = rand_string(12);
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$serverFile = time() . "_" . $rnd . "." . $ext;
		$fname = str_replace("." . $ext, "", $filename) . "_crop." . $ext;
		$folderPath = getcwd();
		$source = $folderPath . "/$upload_path/$filename";

		$this->load->library('image_moo');

		$size = getimagesize($source);
		$ratio = 1;
		$x1 = $_POST['x1'] * 2;
		$y1 = $_POST['y1'] * 2;
		$x2 = $_POST['x2'] * 2;
		$y2 = $_POST['y2'] * 2;
		$w = 800;
		$h = $_POST['h'] * 2;

		if ($size[0] < 800) {
			$ratio = $size[0] / 800;
			}

		//var_dump($x1 * $ratio." ".$y1 * $ratio." ".$x2 * $ratio." ".$y2 * $ratio);

		// $resize_height=($size[1]*746)/$size[0];


		//$this->image_moo->load($source)->resize($w,$h)->save($folderPath. "/$upload_path/$fname",true);
		$this->image_moo->load($folderPath . "/$upload_path/$filename")->resize($w, $h)->save($folderPath . "/$upload_path/$fname", true);
		$this->image_moo->load($folderPath . "/$upload_path/$fname")->crop($x1 * $ratio, $y1 * $ratio, $x2 * $ratio, $y2 * $ratio)->save($folderPath . "/$upload_path/$fname", true);
		//var_dump($this->image_moo->display_errors());

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