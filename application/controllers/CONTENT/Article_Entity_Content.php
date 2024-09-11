<? defined('BASEPATH') or exit('No direct script access allowed');


trait Article_Entity_Content
{


	/****************************************************************************************/
	/****************************************************************************************/
	/****************************************************************************************/
	/***************?      ENTITIES WITH ARTICLES       *************?>?????******************/
/****************************************************************************************/
/****************************************************************************************/
/****************************************************************************************/

/************************* MUSTER ENTITY WITH ARTICLES START *******************************/

public function normals() // name ending with -s
{

$this->groupName = "Articles";
$this->typeOfTable = TABLE_ENTITY_WITH_ARTICLE;
// options are TABLE_ENTITY_WITH_ARTICLE, TABLE_NOARTICLE_WITH_ALL_BUTTONS, TABLE_NOARTICLE_JUST_CLONE or leave blank
$this->setTableName();

	/************ COLUMNS/FILTERS **************/

$this->listColumns = array(

			'name',

				'entities_tags_relation',
			// IMPORTANT: if you want to add tags to this entity. Delete if not.
			// 'color',
			// type specific properties to display
			$this->table . '_tags_relation', // specific tags
			'id',
			'date_added',
		);

$this->filterColumns = array(
			'name',
			'entities_tags_relation',
			// IMPORTANT: if you want to add general tags to this entity. Delete if not.
			// 'description',
			// 'color',
			// type specific properties
			$this->table . '_tags_relation',
			// specific tags
			// 'original_article',


			'date_added',
);


		/************ SELECT DATA PREPARATION **************/

// FLAG
$select_array = array();
$select_array[] = array('key' => 0, 'value' => 'NO');
$select_array[] = array('key' => 1, 'value' => 'YES');


// COLORS
$colors_array = $this->getSelector('colors', 'name', 'hex');
$data['colors'] = $colors_array;

/************ INPUT FIELDS **************/

$columns = array();



$columns['id'] = array(
'db_name' => 'id',
'type' => 'hidden',
'display_as' => 'ID'
);

$columns['date_added'] = array(
'db_name' => 'date_added',
'type' => 'hidden',
'display_as' => 'Date Added',
'value' => date('Y-m-d H:i:s')
);

$columns['name'] =  array(
'db_name' => 'name',
'type' => 'text',
'display_as' => 'Intern Name'
);




$columns['entities_tags_relation'] = array(
'relation_id' => 'entities_tags_relation',
'type' => 'm_n_relation',
'table_mn' => 'entities_tags_relation',
'table_mn_pk' => 'id',
'table_mn_col_m_type' => $this->entityTypeId,
'table_mn_col_m' => 'entity_id',
'table_mn_col_n' => 'tag_id',
'table_m' => $this->table,
'table_n' => 'tags',
'table_n_pk' => 'id',
'table_n_value' => 'name',
'table_n_value2' => 'id',
'display_as' => 'Tags',
'box_width' => 400,
'box_height' => 250,
'filter' => true,
);

// specific tags - you can keep copy relation table structure with named like locations_tags_relation, columns entity_id
// and tag_id

$columns[$this->table . '_tags_relation'] = array(
'relation_id' => $this->table . '_tags_relation',
'type' => 'm_n_relation',
'table_mn' => $this->table . '_tags_relation',
'table_mn_pk' => 'id',
'table_mn_col_m' => 'entity_id',
'table_mn_col_n' => 'tag_id',
'table_m' => $this->table,
'table_n' => $this->tableSingular . '_tags',
'table_n_pk' => 'id',
'table_n_value' => 'name',
'table_n_value2' => 'id',
'display_as' => $this->tablePrettyName . ' Tags',
'box_width' => 400,
'box_height' => 250,
'filter' => true,
);

$this->columns = $columns;
$data['show_mods'] = false;
$this->prepareTable();
$data['crud_data'] = $this->bc->execute($this->pagination);
$this->page('backend/crud/crud', $data);
}


/************************* MUSTER ENTITY WITH ARTICLES ENDS *******************************/


}