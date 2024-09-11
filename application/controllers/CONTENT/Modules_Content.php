<? defined('BASEPATH') or exit('No direct script access allowed');

// require(APPPATH . 'controllers/Backend.php');


trait Modules_Content
	{

	/**********      EDIT HERE       ************/

	// IMPORTANT!!! Naming below always TYPE . Names/DataKeys/RelatedItemsKeys
	// Check name of models insertModuleTypeRelated and getModuleTypeRelated


		// MODULE NAMES
		public $moduleNames = array('text', 'collapsable', 'start', 'image', 'sectiontitle', 'related', 'marquee', 'quote', 'news', 'gallery', 'video', 'html', 'headline', 'hr', 'column_start', 'column_end', 'download');

		// MODULE KEYS
		public $imageDataKeys = array('display_type', 'link');
    	public $textDataKeys = array('content', 'collapsable', 'layout');
		public $collapsableDataKeys = array('content', 'title');
		public $startDataKeys = array('header_img', 'title', 'img_credits', 'sub_title', 'content', 'repo_id');
		public $sectiontitleDataKeys = array('content', 'size');
		public $marqueeDataKeys = array('content', 'marquee', 'link');

		public $relatedDataKeys = array('rel_id', 'rel_type', 'num_items');
		public $quoteDataKeys = array('content', 'author');
		public $downloadDataKeys = array('pdf', 'file_tag', 'path');
		public $newsDataKeys = array('content', 'link');
		public $galleryDataKeys = array('slider', 'scale_images');
		public $videoDataKeys = array('text', 'url', 'autoplay', 'display_type');
		public $htmlDataKeys = array('html');
		public $headlineDataKeys = array('content');
		public $hrDataKeys = array('content', 'visible');
		public $column_startDataKeys = array('col_type');
		public $column_endDataKeys = array();



	// RELATED ITEMS FOR MODULE - name of table module_TYPE_items, sending array $module[TYPE_items]
	// here $ty_peRealtedItemsKeys

	public $galleryRelatedItemsKeys = array('fname', 'description', 'link', 'repo_id');

	// public $relatedRelatedItemsKeys = array('related_type', 'related_id', 'item_ordering');


	/**********      ENDS HERE       ************/



	/**************************      MODULE FUNCTIONS       *******************************/


	/***************************** MODULE EDITOR FUNCTION  ************************************************/





	public function module_editor($itemId, $parent = PARENT_ARTICLE)
		{

		$db = DB_NAME;
		$parsed_url = parse_url(site_url());

		/***************************** EDIT HERE - modules you want to change before inserting  ************************************************/

		$editedModules = array('modulesRelated', 'modulesGallery', 'modulesImage', 'modulesStart', 'modulesPdf' );
		$moduleNames = array();

		/***************************** EDIT HERE - modules you want to change before inserting  ************************************************/



		$host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
		// $data['hostUrl'] = $host."/";
		$data['hostUrl'] = site_url();

		$data['item'] = $this->cm->getItemById($itemId, $db);


		$readyModules = array();

		foreach ($this->moduleNames as $m):
			// preparation of variable names
			$module = $this->camelCaseMe($m);
			$PascalCase = ucfirst($module);


			// getting modules for item
			$var_name = 'modules' . $PascalCase;

			$this->methodExists('cm', 'getModulesUniversal', 'Module Editor');

			$$var_name = $this->cm->getModulesUniversal($m, $itemId, $db, $parent)->result_array();


			// adding those that don't require any further edit
			if (!in_array($var_name, $editedModules)) {
				$moduleNames[] = $var_name;
				$data[$var_name] = $$var_name;
				$readyModules[] = $data[$var_name];
				}

		endforeach;


		/***************************** CUSTOM ************************************************/


		$related_modules_array = array();

		// $modulesPascalCase
		foreach ($modulesRelated as $rel) {

			$rel['name'] = '';
			$rel['main_id'] = '';
			$rel_ids = $rel['rel_id'];
			$rel_ids_array = array_map('intval', explode(',', $rel_ids));

			$related_items_array = array();

			if ($rel['rel_type'] == 'tag') {
				foreach ($rel_ids_array as $rel_id) {
					$tt = $this->cm->getItemTagById($rel_id);
					if ($tt != false) {
						$rel['name'] = $tt->name;
						$rel['main_id'] = $tt->id;
						$related_items_array[] = $tt;
						}
					}
				}

			if ($rel['rel_type'] == 'articles') {
				foreach ($rel_ids_array as $rel_id) {
					$tt = $this->cm->getItemById($rel_id);

					if ($tt != false) {
						$rel['name'] = $tt->name;
						$rel['main_id'] = $tt->id;
						$related_items_array[] = $tt;
						}
					}

				}


			$rel['related_items'] = $related_items_array;
			$related_modules_array[] = $rel;
			}

		/***************************** ADDING EXTRA - add to readyModules  ************************************************/


		$readyModules[] = $related_modules_array;


		/***************************** ADDING EXTRA - modules you want to change before inserting  ************************************************/




		$gallery_modules_array = array();

		foreach ($modulesGallery as $gallery) {
			$gallery_modules_array[] = $this->prepareModuleImages($gallery);
			}

		/***************************** ADDING EXTRA - add to readyModules  ************************************************/


		$readyModules[] = $gallery_modules_array;

		/***************************** ADDING EXTRA - add to readyModules  ************************************************/



		$modules_image = array();

		foreach ($modulesImage as $item) {
			$modules_image[] = $this->prepareModuleImages($item);
			}

		$readyModules[] = $modules_image;


		$module_start = array();
		foreach ($modulesStart as $item) {
			$item['alt'] = '';

			if ($item['repo_id'] != NULL) {
				$repo_item = $this->cm->getPublicRepoItemById($item['repo_id']);

				if ($repo_item != false) {

					$item['header_img'] = $repo_item->fname;


					if ($this->language == SECOND_LANGUAGE) {
						$item['alt'] = $repo_item->alt_text_en;
						} else {
						$item['alt'] = $repo_item->alt_text;
						}
					}
				}
			$module_start[] = $item;
			}
		$readyModules[] = $module_start;


		// $modules_pdfs = array();
		// foreach ($modulesPdf as $item) {
		//  $item['alt'] = '';

		//  if ($item['repo_id'] != NULL) {
		//    $repo_item = $this->cm->getRepoItem($item['repo_id']);

		//    if ($repo_item != false) {

		//      $item['image'] = $repo_item->fname;


		//      if ($this->language == SECOND_LANGUAGE) {
		//        $item['alt'] = $repo_item->alt_text_en;
		//      } else {
		//        $item['alt'] = $repo_item->alt_text;
		//      }
		//    }
		//  }
		//  $modules_pdfs[] = $item;
		// }

		// $readyModules[] = $modules_pdfs;

		// var_dump($readyModules);

		$data['modules'] = array();

		foreach ($readyModules as $m):
			$data['modules'] = array_merge($data['modules'], $m);
		endforeach;

		// var_dump($data['modules']);

		// $data['modules'] = array_merge(array(), $data['modulesText']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesMarquee']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesComment']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesSectionTitle']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesHr']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesComm']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesBubble']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesNews']->result_array());
		// // $data['modules'] = array_merge($data['modules'], $data['modulesBox']->result_array());

		// $data['modules'] = array_merge($data['modules'], $data['modulesDropdown']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesDownload']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesImage']);
		// $data['modules'] = array_merge($data['modules'], $data['modulesHTML']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesTicket']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesVideo']);
		// $data['modules'] = array_merge($data['modules'], $data['modulesHeadline']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesPdf']);
		// $data['modules'] = array_merge($data['modules'], $data['modulesStart']);
		// $data['modules'] = array_merge($data['modules'], $data['modulesQuote']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesContact']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modules2Col']->result_array());
		// // $data['modules'] = array_merge($data['modules'], $data['modulesShop']->result_array());
		// $data['modules'] = array_merge($data['modules'], $gallery_modules_array);
		// $data['modules'] = array_merge($data['modules'], $artwork_modules_array);
		// $data['modules'] = array_merge($data['modules'], $related_modules_array);
		// $data['modules'] = array_merge($data['modules'], $event_modules_array);
		// $data['modules'] = array_merge($data['modules'], $data['modulesColumnStart']->result_array());
		// $data['modules'] = array_merge($data['modules'], $data['modulesColumnEnd']->result_array());
		usort($data['modules'], function ($a, $b) {
			return $a['top'] - $b['top'];
			});


		$data['repo_categories'] = $this->cm->getRepoCategories($db);
		$data['repo_tags'] = $this->cm->getRepoTags($db);

		$data['repository_images'] = array();
		$repo = $this->cm->getRepositoryImages($db);

		foreach ($repo as $r) {
			$r->inventoryNR = "";


			$r->img_path = site_url('items/uploads/images/') . $r->fname;

			$r->tags = array();
			foreach ($this->cm->getTagsForRepositoryImage($r->id) as $tag) {
				$r->tags[] = $this->cm->getRepoTagNames($tag->tag_id);
				}



			$data['repository_images'][] = $r;




			}



		$data['collection_array'] = array();
		// $data['all_artworks'] = $this->cm->getArtworks();
		// $data['artwork_artists'] = $this->cm->get_artists();

		return $data;
		}




	// Camel case
	public function camelCaseMe($item)
		{
		$array = explode('_', $item);
		$finalString = '';
		$finalString = $finalString . $array[0];
		foreach ($array as $key => $a) {
			if ($key > 0) {
				$finalString = $finalString . ucfirst($a);
				}
			}
		return $finalString;
		}

	/***************************** CLONE ITEM UNIVERSAL FUNCTION *********************************************/





	public function clone_universal($entityId, $type = 'noarticle', $noarticle_type = false, $hasTeasers = 1, $name = 'name')
		{
		$db = DB_NAME;
		$parent = PARENT_ARTICLE;

		/******** DEFINE TYPE OF ARTTICLE OR NOARTICLE TYPE ******/

		if ($type != 'noarticle') {

			foreach (ARTICLE_TYPES as $t) {
				if ($t['type_id'] == $type) {
					$type_name = $t['name']; // get the name o the table
					}
				}

			} elseif ($noarticle_type >= 0) {
			foreach (NOARTICLE_TYPES as $t) {
				if ($t['type_id'] == $noarticle_type) {
					$type_name = $t['name']; // get the name o the table
					}
				}

			}


		/******** GET AND CLONE ******/


		$this->variableExists('type_name', $type_name, 'Universal Clone Item');
		$this->methodExists('cm', 'getEntityByIdAndType', 'Universal Clone Item');

		$entity = $this->cm->getEntityByIdAndType($entityId, $type_name)->row_array();


		$this->variableExists('item', $entity, 'Universal Clone Item');
		$this->variableExists('item[name]', $entity[$name], 'Universal Clone Item');

		// preventing items of the same name
		$random_number = mt_rand(1, 1000);

		// name
		$entity[$name] = $entity[$name] . ' (CLONE_' . $random_number . ')';

		unset($entity['id']);

		$this->methodExists('cm', 'cloneEntityByType', 'Universal Clone Item');
		$newEntityId = $this->cm->cloneEntityByType($entity, $type_name);


		/**************  SPECIFIC RELATIONS BASED ON TYPE - BOTH ARTICLE AND NOARTICLE  *************/

		if ($type_name == 'locations') {
			// specific related tables for locations etc.
			}



		/******** TEASERS FOR TYPE ARTICLE/NOARTICLE ******/

		if ($hasTeasers != 0) { // start type noarticle


			$has_article = $type == 'noarticle' ? 0 : 1;
			$type = $type == 'noarticle' ? $noarticle_type : $type;

			$this->methodExists('cm', 'getTeaserImagesForEntityAndType', 'Universal Clone Item');

			// teaser images
			$teaser_images = $this->cm->getTeaserImagesForEntityAndType($type, $entityId, $has_article);

			foreach ($teaser_images as $i) {
				$batch = array(
					'entity_id' => $newEntityId,
					'repo_id' => $i->repo_id,
					'type' => $type,
					'has_article' => $has_article,
				);


				$this->methodExists('cm', 'insertTeaserImagesForType', 'Universal Clone Item');

				$this->cm->insertTeaserImagesForType($batch);
				}
			}

		/******** TAGS FOR TYPE ARTICLE ******/


		if ($type_name != 'noarticle') { // start type noarticle

			// tags
			$this->methodExists('cm', 'getEntityTags', 'Universal Clone Item');
			$tags = $this->cm->getEntityTags($entityId, $type);

			foreach ($tags as $t) {
				$batch = array(
					'entity_id' => $newEntityId,
					'tag_id' => $t->tag_id,
					'type' => $type,
				);

				$this->methodExists('cm', 'insertEntityTag', 'Universal Clone Item');
				$this->cm->insertEntityTag($batch);
				}

			// /******** CLONING ASSOCIATED ARTICLES ******/

			$this->methodExists('cm', 'getOriginalAssociatedItem', 'Universal Clone Item');
			$associatedOriginal = $this->cm->getOriginalAssociatedItem($entityId, $type);

			if ($associatedOriginal) {
				// if exist, then clone
				$newId = $this->clone_item_from_entity($associatedOriginal->id, false, $newEntityId, $type_name);

				// if there is a second language clone it as well

				if (NUMBER_OF_LANGUAGES == 2) {

					$this->methodExists('cm', 'getSecondItem', 'Universal Clone Item');
					// getting second language by original
					$associatedSecond = $this->cm->getSecondItem($associatedOriginal->id);

					// if exist clone
					if ($associatedSecond) {
						$this->clone_item_from_entity($associatedSecond->id, false, $newEntityId, $type_name, $newId);
						}
					}

				}

			} // end of type noarticle


		redirect('entities/Content/' . $type_name, 'refresh'); // redirect back

		}

	/***************************** CLONE ITEM FUNCTION  ************************************************/

	public function clone_item($itemId)
		{
		$db = DB_NAME;
		$parent = PARENT_ARTICLE;

		//clone item


		$newItem = $this->cm->getSecondLanguageArticle($itemId);
		$newItemId = $newItem->id;

		if (!$newItem) {
			echo json_encode(array('success' => false, 'message' => 'Item doesn\'t exist.'));
			}

		$this->deleteModulesForArticle($newItemId);

		foreach ($this->moduleNames as $m):
			$camelCase = $this->camelCaseMe($m);
			$PascalCase = ucfirst($camelCase);

			// check for tables and methods
			$this->tableExists('module_' . $m, 'clone item');

			foreach ($this->cm->getModulesUniversal($m, $itemId, $db, $parent)->result() as $data) {

				$batch = array();
				$batch['item_id'] = $newItemId;
				$batch['top'] = $data->top;
				$batch['parent'] = $data->parent;
				foreach ($data as $property => $value) {
					if (in_array($property, $this->{$m . 'DataKeys'})) {
						$batch[$property] = $value;
						}
					}

				$last_id = 0;

				$this->methodExists('cm', 'insertModuleUniversal', 'clone item');

				$last_id = $this->cm->insertModuleUniversal($m, $batch, $db);

				// if($m == 'gallery'){
				// var_dump($last_id);
				// var_dump(isset($this->{$m . 'RelatedItemsKeys'}));
				// var_dump(count($this->{$m . 'RelatedItemsKeys'}));
				// }


				if ($last_id && isset($this->{$m . 'RelatedItemsKeys'}) && count($this->{$m . 'RelatedItemsKeys'})):

					// check for tables and methods
					$this->methodExists('cm', 'getModuleRelatedItems', 'clone item');
					$this->methodExists('cm', 'insertModuleRelatedItems', 'clone item');
					$this->tableExists('module_' . $m . '_items', 'clone item');

					foreach ($this->cm->getModuleRelatedItems($m, $data->id, $db) as $item) {
						$ibatch = array();
						$ibatch['item_id'] = $newItemId;
						$ibatch['module_id'] = $last_id;
						foreach ($item as $property => $value) {
							if ($property != 'id' && $property != 'module_id' && $property != 'item_id') {
								$ibatch[$property] = $value;
								}
							}

						$this->cm->insertModuleRelatedItems($m, $ibatch, $db);
						}
				endif;
				}

		endforeach;

		echo json_encode(array('success' => true, 'message' => 'Modules cloned successfully.'));

		return;



		}

	function deleteModulesForArticle($itemId)
		{
		foreach ($this->moduleNames as $m):
			$this->cm->deleteModulesForArticle($m, $itemId);
		endforeach;

		}

	public function clone_item_from_entity($itemId, $article_related = false, $newEntityId = false, $type_name = false, $newOriginalItemId = false)
		{
		$db = DB_NAME;
		$parent = PARENT_ARTICLE;


		//clone item
		$item = $this->cm->getItemByIdAsArray($itemId)->row_array();
		if ($article_related && NUMBER_OF_LANGUAGES == 2) { // cloning for creation of second language version
			$item['original_item_id'] = $itemId;
			$item['lang'] = SECOND_LANGUAGE;
			}

		// cloning of existing second language item for newly cloned entity
		if ($newOriginalItemId && NUMBER_OF_LANGUAGES == 2) {
			$item['original_item_id'] = $newOriginalItemId;
			}

		if ($newEntityId) { // cloning of entity together with articles
			$item['entity_id'] = $newEntityId;
			}

		// preventing items of the same name
		$random_number = mt_rand(1, 1000);

		// pretty_url
		$item['pretty_url'] = $item['pretty_url'] . '_CLONE_' . $random_number;

		$item['visible'] = 0;

		unset($item['id']);
		$newItemId = $this->cm->cloneItem($item, $db);


		/******** GETTING MODULES  */


		// Check name of used models insertModuleTypeInPascalCaseRelated and getModuleTypeInPascalCaseRelated

		foreach ($this->moduleNames as $m):
			$camelCase = $this->camelCaseMe($m);
			$PascalCase = ucfirst($camelCase);

			// check for tables and methods
			$this->tableExists('module_' . $m, 'clone item');

			foreach ($this->cm->getModulesUniversal($m, $itemId, $db, $parent)->result() as $data) {

				$batch = array();
				$batch['item_id'] = $newItemId;
				$batch['top'] = $data->top;
				$batch['parent'] = $data->parent;
				foreach ($data as $property => $value) {
					if (in_array($property, $this->{$m . 'DataKeys'})) {
						$batch[$property] = $value;
						}
					}

				$last_id = 0;

				$this->methodExists('cm', 'insertModuleUniversal', 'clone item');

				$last_id = $this->cm->insertModuleUniversal($m, $batch, $db);

				if ($last_id && isset($this->{$m . 'RelatedItemsKeys'}) && count($this->{$m . 'RelatedItemsKeys'})):

					// check for tables and methods
					$this->methodExists('cm', 'getModuleRelatedItems', 'clone item');
					$this->methodExists('cm', 'insertModuleRelatedItems', 'clone item');
					$this->tableExists('module_' . $m . '_items', 'clone item');

					foreach ($this->cm->getModuleRelatedItems($m, $data->id, $db) as $item) {
						$ibatch = array();
						$ibatch['item_id'] = $newItemId;
						$ibatch['module_id'] = $last_id;
						foreach ($item as $property => $value) {
							if ($property != 'id' && $property != 'module_id' && $property != 'item_id') {
								$ibatch[$property] = $value;
								}
							}

						$this->cm->insertModuleRelatedItems($m, $ibatch, $db);
						}
				endif;
				}

		endforeach;



		// redirecting to new item in case the clone was also creation of language version
		if ($article_related) {
			redirect('entities/Content/items/edit/' . $newItemId, 'refresh');

			// or just simply back to the items overview

			} elseif ($newEntityId && $article_related == false && $type_name) {

			return $newItemId;
			// $this->clone_item($newItemId, false, $newEntityId, $type_name); // cloning for other language

			// } elseif ($newEntityId && $article_related == false && $type_name) { // and refresh then
			// 	redirect('entities/Content/' . $type_name, 'refresh');
			} else {
			redirect('entities/Content/items', 'refresh');

			}

		}

	/***********************************  SAVE MODULE FUNCTIONS START *******************************************/


	public function collectModuleIds($type, $itemId, $parent)
		{
		$moduleIds = array();

		foreach ($this->cm->getItemModulesByTypeNew($type, $itemId, $parent) as $m) {
			$moduleIds[] = $m->id;
			}
		;

		return $moduleIds;

		}

	public function addUpdateModule($type, $moduleIds, $data_keys, $module, $related_items = '', $relatedItemsDataKeys = array())
		{



		// set above error checker
		$errors = 0;

		// edited id by default 0
		$editedId = 0;
		$error_msg = '';

		// check if key for related items is specified
		$relatedItems = array();
		if ($related_items && count($relatedItemsDataKeys) > 0) {
			$relatedItems = $module[$related_items];
			}

		// set data

		$data = array('item_id' => $module['id'], 'parent' => $module['parent'], 'top' => $module['top']);
		foreach ($data_keys as $d):
			if (isset($module[$d])) {
				$data[$d] = $module[$d];
				} else {
				$errors = 1;
				$error_msg = 'Module saving: check data keys for module ' . $type . ' problem might be on data key ' . $d;
				}
		endforeach;

		// validating data if something is missing

		foreach ($data as $key => $d) {


			if ($d == 'undefined') {
				$errors = 1;
				$error_msg = 'Module saving: some data on key' . $key . 'is undefined at module ' . $type;
				}

			}

		if ($errors == 0) {
			// if exist update
			if (isset($module['dbid']) && in_array($module['dbid'], $moduleIds)) {

				// var_dump($data);
				$update_id = $this->cm->updateModuleByType($type, $module['dbid'], $data);
				// var_dump($update_id);
				if ($update_id != false) {
					$editedId = $module['dbid'];
					} else {
					$errors = 1;
					$error_msg = 'update of item failed with module ' . $type;
					}
				// add those updated into an array

				} else {
				// if doesn't exist insert new and add its id to an array
				$editedId = $this->cm->insertModuleByType($type, $data);

				if (!$editedId) {
					$errors = 1;
					$error_msg = 'Module saving: insert of item failed with module ' . $type;
					}

				}
			}


		// processing related items START
		if (count($relatedItems) > 0 && $editedId != 0):

			// prepare data for related items
			$relatedItemsData = array();
			foreach ($relatedItems as $r):
				$dataRelated = array('module_id' => $editedId, 'item_id' => $module['id'], 'parent' => $module['parent']);
				foreach ($relatedItemsDataKeys as $rk):
					if (isset($r[$rk])) {
						$dataRelated[$rk] = $r[$rk];
						} else {
						$errors = 1;
						$error_msg = 'Module saving: check related item data keys on module ' . $type . ' key ' . $rk;
						}
				endforeach;


				$relatedItemsData[] = $dataRelated;
			endforeach;

			foreach ($dataRelated as $key => $d) {

				if ($d == 'undefined') {
					$errors = 1;
					$error_msg = 'Module saving: some related item data is undefined for module ' . $type . ' on key ' . $key;
					}
				}

			if ($errors == 0 && $editedId != 0) {
				// delete existing related items
				$this->cm->deleteRelatedItemsByType($type, $editedId);
				// insert new one
				foreach ($relatedItemsData as $rd) {
					$this->cm->insertRelatedItemsByType($type, $rd);
					}
				}


		endif;

		if ($error_msg != '') {
			$error_data = array(
				'text' => $error_msg,
				'page' => current_url()
			);

			$this->insertError('Module saving:' . $error_msg, current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
			}

		// processing related items ENDS

		return array('errors' => $errors, 'error_msg' => $error_msg, 'editedId' => $editedId);

		}

	public function deleteModuleByType($originalIds, $editedIds, $type, $related_items = false)
		{
		foreach ($originalIds as $id):
			if (!in_array($id, $editedIds)):
				// delete original that doesn't exist anymore
				$this->cm->deleteModulesByType($type, $id);

				// delete also related items
				if ($related_items == true) {
					$this->cm->deleteRelatedItemsByType($type, $id);
					}
			endif;
		endforeach;
		}

	public function saveSpecificModuleForItem($module, $parent, $type, $originalIds, $dataKeys, $relatedItemsDataKeys = array(), $relatedItems = '')
		{

		$module['id'] = $_POST['id'];
		$module['parent'] = $parent;

		// check if related items actually exist
		if (count($relatedItemsDataKeys) == 0 || $relatedItems == '' || !isset($module[$relatedItems])) {
			$relatedItems = '';
			$relatedItemsDataKeys = array();
			}

		$returnedData = $this->addUpdateModule($type, $originalIds, $dataKeys, $module, $relatedItems, $relatedItemsDataKeys);

		if ($returnedData['editedId'] || $returnedData['errors'] != 1) {
			$editedId = $returnedData['editedId'];
			return $editedId;
			} else {
			// var_dump($returnedData['error_msg']);
			return false;
			}
		}


	// Error checker

	public function checkErrorsAndGetRelated($moduleType)
		{

		$error_msg = '';
		$relatedItemKeys = array();
		if (isset($this->{$moduleType . 'RelatedItemsKeys'}) && count($this->{$moduleType . 'RelatedItemsKeys'})) {
			$relatedItemKeys = $this->{$moduleType . 'RelatedItemsKeys'};

			if (!$this->db->table_exists('module_' . $moduleType . '_items')) {
				$error_msg = 'Module saving: table module_' . $moduleType . '_items does not exist';
				}
			}
		;

		if (!isset($this->{$moduleType . 'DataKeys'})) {
			$error_msg = 'Module saving: ' . $moduleType . 'DataKeys' . ' variable does not exist';
			}

		$data = array('relatedItemKeys' => $relatedItemKeys, 'error_msg' => $error_msg);

		// final
		return $data;


		}

	/*****  SAVE MODULE FUNCTION MAIN ******/

	public function save_item()
		{
		// required variables
		$db = DB_NAME;
		$parent = PARENT_ARTICLE;


		// setting two arrays - ORIGINAL that are existing and EDITED that will be new/updated (now empty)
		foreach ($this->moduleNames as $n) {
			${$n . 'ModuleOriginalIds'} = $this->collectModuleIds($n, $_POST['id'], $parent);
			${$n . 'ModuleEditedIds'} = array();
			}




		if (isset($_POST['modules'])) {
			if(count($_POST['modules']) > 0){

				$this->updateUpdateTimestamp($_POST['id']);

			}
			foreach ($_POST['modules'] as $module) {

				foreach ($this->moduleNames as $module_name) {
					switch ($module['type']) {
						// cases of modules
						case $module_name:

							$data = $this->checkErrorsAndGetRelated($module_name);

							if ($data['error_msg'] == '') {
								$lastId = $this->saveSpecificModuleForItem($module, $parent, $module_name, ${$module_name . 'ModuleOriginalIds'}, $this->{$module_name . 'DataKeys'}, $data['relatedItemKeys'], $module_name . '_items');
								if ($lastId) {
									${$module_name . 'ModuleEditedIds'}[] = $lastId;
									}
								} else {
								echo $data['error_msg'];
								$this->insertError($data['error_msg'], current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
								}

							break;

						}
					}
				}
			}


		// DELETE


		foreach ($this->moduleNames as $n) {
			$relatedItemsPresent = false;

			if (isset(${$n . 'RelatedItemsKeys'})) {
				$relatedItemsPresent = true;
				}
			$this->deleteModuleByType(${$n . 'ModuleOriginalIds'}, ${$n . 'ModuleEditedIds'}, $n, $relatedItemsPresent);
			}


		echo json_encode(
			array(
				'success' => true,
			)
		);
		}


		public function updateUpdateTimestamp($itemId){
			$this->cm->updateUpdateTimestamp($itemId);
		}

	}

/*****  SAVE MODULES END ******/
