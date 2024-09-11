<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Item_Dev_Content
{
    /****************************************************************************************/
		/****************************************************************************************/
		/****************************************************************************************/
		/******************************      ARTICLES       *************************************/
		/****************************************************************************************/
		/****************************************************************************************/
		/****************************************************************************************/

	public function removeArticle() {
		$id = $this->input->post('id');
		$lang = $this->input->post('lang');


		// var_dump($lang);
		if($lang != MAIN_LANGUAGE){
			$this->cm->removeArticle($id);


		} else {

			$original_article = $this->cm->getArticleById($id);

			// var_dump($original_article);
			$second_language_articles = $this->cm->getSecondLanguageArticles($original_article->id);

			foreach($second_language_articles as $article){
				$this->cm->removeArticle($article->id);
			}

			$this->cm->removeArticle($original_article->id);

		}

		echo json_encode(array('success' => true));


	}

	public function articlesGeneralSave()
		{


		$postData = $this->input->post();
		$dd = [];

		$ignoredKeys = array('languageName', 'entityId');
		foreach ($postData as $key => $value) {
			if (!in_array($key, $ignoredKeys)) {
				$dd[$key] = $value;
				${$key} = $value;
				}
			}


		if ($pretty_url == '') {
			$pretty_url = bin2hex(random_bytes(10)); // generates a 20-character random string
			}

		$existingArticle = $this->fm->getAnyItemByPrettyURL($pretty_url);

		if ($existingArticle && $existingArticle->id != $id) {
			echo json_encode(array('success' => false, 'message' => 'Pretty URL already exists'));
			return;
			}


		if (!preg_match('/^[a-zA-Z0-9-_]+$/', $pretty_url)) {
			echo json_encode(array('success' => false, 'message' => 'Pretty URL should only contain letters, numbers, hyphens, and underscores'));
			return;
			}


		if ($id != 0) {

			$this->cm->updateArticle($id, $dd);


			} else {

			$existingOriginalArticle = $this->cm->findArticleByEntityIdAndLanguage($entity_id, 'de');

			if (!$existingOriginalArticle) {
				$this->cm->insertArticle($dd);

				} else {
				$dd['original_item_id'] = $existingOriginalArticle->id;
				$dd['lang'] = SECOND_LANGUAGE;

				$this->cm->insertArticle($dd);
				}





			}

		echo json_encode(array('success' => true, 'message' => 'Articles and Entity saved'));


		}


	public function items()
	{

	   /******      AUTHENTICATION    *******/


		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();
		$data = array();

		/**********      MODULE STUFF       ************/

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false;
		$bc->show_mods(false);
		if ($segments->first_parameter != NULL) {

			$itemId = $segments->first_parameter;

			$data = $this->module_editor($itemId);
			$data['show_mods'] = true;
			$bc->show_mods(true);
		}


		/**********  CRUD STUFF   *********/

		$bc->database(DB_NAME);
		$bc->main_title('Articles');
		$bc->table_name('Articles');
		$bc->table('items');
		$bc->primary_key('id');
		$bc->title('Article');

		/*********   SELECTOR BASIC      **********/

		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		$lang_array = $this->getLangArray();

		/*********    OTHER NECESSARY DATA     *********/

		$items_array[] = array('key' => '', 'value' => 'none');
		$items = $this->cm->get_original_items();
		foreach ($items as $item) {

			$items_array[] = array('key' => $item->id, 'value' => $item->pretty_url . ' (' . $item->id . ')');
			$data['module_related_articles'][] = array('id' => $item->id, 'name' => $item->pretty_url . ' (' . $item->id . ')');
			}
		/************     PROCESSING ARTICLE TYPES      **************/


		$types_array = array();
		$types_names = array();

		foreach(ARTICLE_TYPES as $type){ // specified in constants.php
				$Type = ucfirst($type['name']);

				$types_array[] = array('key' => $type['type_id'], 'value' => $type['name']);
				$types_names []=  $type['name'] . '_id';


					${$type['name']} = $this->cm->getAnything($type['name']);


				${$type['name'] . '_array'} = array();
				${$type['name'] . '_array'}[] = array('key' => '', 'value' => 'No ' . $type['name'] . ' selected');

			foreach (${$type['name']} as $ent) {

				$name = $this->getRowName($ent);
				// if(isset($ent->name) && $ent->name != NULL){
				$this->variableExists('entity name', $name, 'Getting Entity Info'); // entity always need to have column name
				${$type['name'] . '_array'}[] = array('key' => $ent->id, 'value' => $name . ' (' . $ent->id . ')');
				// }

			}


		}

		/************     LIST OF COLUMNS/FILTERS      **************/


		$list = array('article_type', 'lang', 'original_item_id', 'pretty_url', 'visible'); // list of columns to display, if necessary edit or add another list for filters

		$bc->list_columns($list);
		$bc->filter_columns($list);


		/************     COLUMNS/FILTERS INPUT SETTINGS     **************/


		$columns_array = array();


			$columns_array['pretty_url'] = array(
				'db_name' => 'pretty_url',
				'type' => 'text',
				'validation' => 'required|is_unique[items.pretty_url]', // validation for pretty url field
				'display_as' => 'Pretty url',
			);

			$columns_array['visible'] = array(
				'db_name' => 'visible',
				'type' => 'select',
				'options' => $select_array,
				'display_as' => 'Visible',
			);


			$columns_array['seo_description'] = array(
				'db_name' => 'seo_description',
				'type' => 'text',
				'display_as' => 'SEO description',
			);

			$columns_array['og_description'] = array(
				'db_name' => 'og_description',
				'type' => 'text',
				'display_as' => 'OG description',
				'col_info' => 'This description will show up when you share the link to this article on a social media website.',
			);

			$columns_array['external_url'] = array(
				'db_name' => 'external_url',
				'type' => 'text',
				'display_as' => 'External url (instead of pretty url)',
			);

			// 'publish_date' => array(
			// 	'db_name' => 'publish_date',
			// 	'type' => 'text',
			// 	'display_as' => 'Publish Date',
			// 	'col_info' => 'Format: YYYY-MM-DD hh:mm:ss',
			// ),

			// 'article_order' => array(
			// 	'db_name' => 'article_order',
			// 	'type' => 'text',
			// 	'display_as' => 'Order',
			// ),

			$article_type = array(
				'db_name' => 'type',
				'type' => 'select',
				'options' => $types_array,
				'disabled' => true, // put to false if you want to allow changing entity/type manually
				'display_as' => 'Type',
				'control' => 'article_type',
			);

		$columns_array['article_type'] = $article_type;

		foreach(ARTICLE_TYPES as $t){
			${$t['name']. 'array_input'} = array( // keys are various based on type
				'db_name' => 'entity_id', // column for entity id is however always same
				'type' => 'select',
				'disabled' => true, // put to false if you want to allow changing entity/type
				'options' => ${$t['name']. '_array'},
				  // put to false if you want to allow changing entity/type manually
				'display_as' => $t['name'],
				'controlled_by' => 'article_type',
				'controlled_id' => $t['type_id'], // controlled by type id
			);
			$columns_array[$t['name'] . '_id'] = 	${$t['name']. 'array_input'};
		}

			$columns_array['lang'] = array(
				'db_name' => 'lang',
				'type' => 'select',
				'options' => $lang_array,
				'disabled' => true, // put to false if you want to manipulated language/original item manually
				'display_as' => 'Language',
				'control' => 'lang',
			);

			$columns_array['original_item_id'] = array(
				'db_name' => 'original_item_id',
				'type' => 'select',
				'options' => $items_array,
				'disabled' => true, // put to false if you want to manipulated language/original item manually
				'col_info' => 'The original english article',
				'display_as' => 'Original article',
				'controlled_by' => 'lang',
				'controlled_id' => SECOND_LANGUAGE,
			);


		$bc->columns($columns_array);

		// var_dump($this->pagination);

		$data['module_names'] = $this->moduleNames;

		$data['crud_data'] = $bc->execute($this->pagination);

		$this->page('backend/crud/crud', $data);
	}




			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/
			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/
		  /*||||||||||||||||||||||||||      DEV AREA OTHER      |||||||||||||||||||||||||||||||||||||*/
			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/
			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/

 public function translations()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Dev');
		$bc->table_name('Translations');
		$bc->table('translations');
		$bc->primary_key('id');
		$bc->title('Translations');
		$bc->list_columns(array('name', 'lang_de', 'lang_en'));
		$bc->filter_columns(array('name',  'lang_de', 'lang_en'));
		$bc->custom_buttons(array());

		$bc->columns(array(
			'name' => array(
				'db_name' => 'name',
				'type' => 'text',
				'display_as' => 'Name',
			),


			'lang_de' => array(
				'db_name' => 'lang_de',
				'type' => 'text',
				'display_as' => 'Translation DE',
			),

			'lang_en' => array(
				'db_name' => 'lang_en',
				'type' => 'text',
				'display_as' => 'Translation EN',
			),

		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

		public function constants()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Dev');
		$bc->table_name('Constants');
		$bc->table('constants');
		$bc->primary_key('id');
		$bc->title('Constant');
		$bc->list_columns(array('name', 'value'));
		$bc->filter_columns(array('name', 'value'));
		$bc->custom_buttons(array());

		$bc->columns(array(
			'name' => array(
				'db_name' => 'name',
				'type' => 'text',
				'display_as' => 'Name',
			),


			'value' => array(
				'db_name' => 'value',
				'type' => 'text',
				'display_as' => 'Value',
			),

		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

			public function error_log()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Dev');
		$bc->table_name('Error Log');
		$bc->table('error_log');
		$bc->primary_key('id');
		$bc->title('Error Log');
		$bc->list_columns(array('date_added', 'text', 'page', 'file', 'line'));
		$bc->filter_columns(array('date_added', 'page', 'text', 'file', 'line'));
		$bc->custom_buttons(array());

		$bc->columns(array(
			'date_added' => array(
				'db_name' => 'date_added',
				'type' => 'text',
				'display_as' => 'Date added',
			),


			'text' => array(
				'db_name' => 'text',
				'type' => 'text',
				'display_as' => 'Text',
			),

			'page' => array(
				'db_name' => 'page',
				'type' => 'text',
				'display_as' => 'Page',
			),
			'line' => array(
				'db_name' => 'line',
				'type' => 'text',
				'display_as' => 'Line',
			),
			'file' => array(
				'db_name' => 'file',
				'type' => 'text',
				'display_as' => 'File',
			),

		));

		$data['crud_data'] = $bc->execute($this->pagination);

		$this->page('backend/crud/crud', $data);
	}



	}