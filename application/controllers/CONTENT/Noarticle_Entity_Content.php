<? defined('BASEPATH') or exit('No direct script access allowed');


trait Noarticle_Entity_Content
{

	/****************************************************************************************/
	/****************************************************************************************/
	/****************************************************************************************/
	/***************?      ENTITIES WITHOUT ARTICLES       *********?>?????******************/
/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/

/************************* MUSTER ENTITY WITH NO ARTICLES START *******************************/


// 	public function normals() // name ending with -s
// {

// 		  $data = array();


// 		// 1) article type
// 		  $bc = $this->bc;
// 			$segments = $bc->get_state_info_from_url();

// 			$entity_type = ARTICLE_TYPES[__FUNCTION__]['type_id'];

// 			// type id got based on function name which is same as key at ARTICLE_TYPES array

// 			$bc->article_type($entity_type);

// 			$this->groupName = "Articles";
//       // $this->typeOfTable = TABLE_ENTITY_WITH_ARTICLE;

// 	// options are TABLE_ENTITY_WITH_ARTICLE, TABLE_NOARTICLE_WITH_ALL_BUTTONS, TABLE_NOARTICLE_JUST_CLONE or leave blank

// 		$this->table = __FUNCTION__;

// 		$this->checkPluralFunctionName();

// 		$this->tableSingular = $this->singularizeName($this->table);
// 		$this->tablePrettyName = $this->getPrettyName($this->table);
// 		$this->tablePrettyNameSingular = $this->singularizeName($this->tablePrettyName);
//       $this->setTableName();

// 		// 2) buttons
// 		$customButtons = (
// 			array(

// 				// IMPORTANT: edit teaser and clone_item_universal are both universal functions. Modify within them different behavior
// 				// based on type if necessary
// 				array(
// 					'name' => 'Clone',
// 					'icon' => site_url('items/backend/img/clone_icon.png'),
// 					'add_pk' => true,
// 					'add_type' => $entity_type,
// 					// required for type specific cloning of columns and relations
// 					'url' => 'clone_universal'
// 				),
// 				array(
// 					'name' => 'Teaser Images',
// 					'icon' => site_url('items/backend/img/teaser_images.png'),
// 					'add_pk' => true,
// 					'add_type' => $entity_type,
// 					// required for type specific teaser images relation
// 					'url' => 'repository_overview'
// 				),
// 			)
// 		);


// 		$bc->custom_buttons($customButtons);

// 			/************ COLUMNS/FILTERS **************/

// 	$this->listColumns = array(
// 			'name',

// 					'entities_tags_relation',
// 			// IMPORTANT: if you want to add  tags to this entity. Delete if not.
// 			'color',
// 			// type specific properties to display
// 			$this->table . '_tags_relation' // specific tags
// 		);

// 	$this->filterColumns = array(
// 			'name',
// 			'entities_tags_relation',
// 			// IMPORTANT: if you want to add tags to this entity. Delete if not.
// 			'description',
// 			'color',
// 			// type specific properties
// 			$this->table . '_tags_relation',
// 			// specific tags
// );


// 		// 3) db and table
// 		$bc->database(DB_NAME);
// 		$bc->main_title($this->groupName);
// 		$bc->table_name($this->tablePrettyName);
// 		$bc->table($this->table); // equals name of this function
// 		$bc->primary_key('id');
// 		$bc->title($this->tablePrettyNameSingular);


// 		$bc->list_columns($this->listColumns);
// 		$bc->filter_columns($this->filterColumns);

// 		// 4) columns


// 			/************ SELECT DATA PREPARATION **************/

// 	// FLAG
// $select_array = array();
// $select_array[] = array('key' => 0, 'value' => 'NO');
// $select_array[] = array('key' => 1, 'value' => 'YES');


// 	// COLORS
// $colors_array = $this->getSelector('colors', 'name', 'hex');
// $data['colors'] = $colors_array;

// 	/************ INPUT FIELDS **************/

// 	$columns = array();

// 	$columns['name'] =  array(
// 'db_name' => 'name',
// 'type' => 'text',
// 'display_as' => 'Name'
// );

// 	if(NUMBER_OF_LANGUAGES > 1):
// $columns['name_en'] = array(
// 'db_name' => 'name_' . SECOND_LANGUAGE,
// 'type' => 'text',
// 'display_as' => 'Name EN',
// );
// endif;

// 	$columns['color' ] = array(
// 'db_name' => 'color',
// 'type' => 'select',
// 'options' => $colors_array,
// 'display_as' => 'Colors',
// );

// 	$columns['description'] = array(
// 'db_name' => 'description',
// 'type' => 'ckeditor',
// 'height' => '200',
// 'display_as' => 'Description DE',
// );

// 	if(NUMBER_OF_LANGUAGES > 1):
// $columns['description_en'] = array(
// 	'db_name' => 'description_' . SECOND_LANGUAGE,
// 	'type' => 'ckeditor',
// 	'height' => '300',
// 	'display_as' => 'Description EN',
// );
// endif;

// 	$columns['entities_tags_relation'] = array(
// 'relation_id' => 'entities_tags_relation',
// 'type' => 'm_n_relation',
// 'table_mn' => 'entities_tags_relation',
// 'table_mn_pk' => 'id',
// 'table_mn_col_m_type' => $this->entityType,
// 'table_mn_col_m' => 'entity_id',
// 'table_mn_col_n' => 'tag_id',
// 'table_m' => $this->table,
// 'table_n' => 'tags',
// 'table_n_pk' => 'id',
// 'table_n_value' => 'name',
// 'table_n_value2' => 'id',
// 'display_as' => 'Tags',
// 'box_width' => 400,
// 'box_height' => 250,
// 'filter' => true,
// );

// 	// specific tags - you can keep copy relation table structure with named like locations_tags_relation, columns entity_id
// // and tag_id

// 	$columns[$this->table . '_tags_relation'] = array(
// 'relation_id' => $this->table . '_tags_relation',
// 'type' => 'm_n_relation',
// 'table_mn' => $this->table . '_tags_relation',
// 'table_mn_pk' => 'id',
// 'table_mn_col_m' => 'entity_id',
// 'table_mn_col_n' => 'tag_id',
// 'table_m' => $this->table,
// 'table_n' => $this->tableSingular . '_tags',
// 'table_n_pk' => 'id',
// 'table_n_value' => 'name',
// 'table_n_value2' => 'id',
// 'display_as' => $this->tablePrettyName . ' Tags',
// 'box_width' => 400,
// 'box_height' => 250,
// 'filter' => true,
// );

// 	$this->columns = $columns;
// // $this->prepareTable();

// 			// $bc->languageArray = $this->getLangArray();

// 			// if ($this->ArticleOrNoarticleOrNoneType == ARTICLE) {

// 			// 	$bc->article_type($this->entityType);
// 		// 	} else if ($this->ArticleOrNoarticleOrNoneType == NOARTICLE) {
// 		// 	$bc->noarticle_type($this->entityType);
// 		// 	}



// $bc->columns($this->columns);

// $data['show_mods'] = false;
// $data['crud_data'] = $bc->execute($this->pagination);

// $this->page('backend/crud/crud', $data);
// }

public function artworks() //name ending with -s
{

		$this->groupName = "Tables";
		$this->typeOfTable = '';
		$this->setTableName();



$select_array = array();
$select_array[] = array('key' => 0, 'value' => 'NO');
$select_array[] = array('key' => 1, 'value' => 'YES');

/************ COLUMNS/FILTERS **************/

$this->listColumns = (array('name', ));
$this->filterColumns = (array('name', ));


/************ INPUT FIELDS **************/



$columns = (
array(
'name' => array(
'db_name' => 'name',
'type' => 'text',
'display_as' => 'Name',

),


)
);

		$this->columns = $columns;
		$data['show_mods'] = false;
		$this->prepareTable();
		$data['crud_data'] = $this->bc->execute($this->pagination);
		$this->page('backend/crud/crud', $data);
}




	public function searches() //name ending with -s
	{

		$this->groupName = "Tables";
		$this->typeOfTable = '';
		$this->setTableName();


		$select_array = array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		/************ COLUMNS/FILTERS **************/

		$this->listColumns(array('name', 'name_en', 'amount', 'selector'));
		$this->filterColumns(array('name', 'name_en', 'amount', 'selector'));


		/************ INPUT FIELDS **************/



		$columns = (
			array(
				'name' => array(
					'db_name' => 'name',
					'type' => 'text',
					'display_as' => 'Name',
				),

				'name_en' => array(
					'db_name' => 'name_en',
					'type' => 'text',
					'display_as' => 'Name EN',
				),

				'amount' => array(
					'db_name' => 'amount',
					'type' => 'text',
					'display_as' => 'Amount',
				),
				'selector' => array(
					'db_name' => 'selector',
					'type' => 'select',
					'options' => $select_array,
					'display_as' => 'Is Selector?',
				),

			)
		);

		$this->columns = $columns;
		$data['show_mods'] = false;
		$this->prepareTable();
		$data['crud_data'] = $this->bc->execute($this->pagination);
		$this->page('backend/crud/crud', $data);
	}






}
