<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Tags_Content
{


		/****************************************************************************************/
		/****************************************************************************************/
		/****************************************************************************************/
		/******************************   GENERAL   TAGS         *********************************/
		/****************************************************************************************/
		/****************************************************************************************/
		/****************************************************************************************/

		public function tags()
	{

		/************     AUTHENTICATION    **************/

		if ($this->user->is_admin != 1) {
			redirect('');
		}


		/************    COLUMNS    **************/


			$array_columns = array(
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
		);

		$column_names = array('name', 'name_en');

		foreach(ARTICLE_TYPES as $t): // getting relation for every article type

		$column_names[] = $t['name'] .'_tags_relation'; // adding keys for the display/filter list

		$array_columns[$t['name'] .'_tags_relation'] = array(
				'relation_id' => $t['name'] . '_tags_relation',
				'type' => 'm_n_relation',
				'table_mn' => 'entities_tags_relation',
				'table_mn_col_m_type' => $t['type_id'],
				'table_mn_pk' => 'id',
				'table_mn_col_m' => 'tag_id',
				'table_mn_col_n' => 'entity_id',
				'table_m' => 'tags',
				'table_n' => $t['name'] ,
				'table_n_pk' => 'id',
				'table_n_value' => 'name',
				'table_n_value2' => 'id',
				'display_as' => $t['name'],
				'box_width' => 400,
				'box_height' => 250,
				'filter' => true,
				);
			endforeach;

	/************     CRUD STUFF    **************/


		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Tags');
		$bc->table_name('');
		$bc->table('tags');
		$bc->primary_key('id');
		$bc->title('Tag');
		$bc->list_columns($column_names); // names of all columns collected above
		$bc->filter_columns($column_names);
		$bc->custom_buttons(array());



		$bc->columns($array_columns);

		// GET
		$pagination = 30;
		if (isset($_GET['pagination'])) {
			if ($_GET['pagination'] == 'all') {
				$pagination = 100000;
			} else {
				$pagination = $_GET['pagination'];
			}
		}


		$data['crud_data'] = $bc->execute($pagination);

		$this->page('backend/crud/crud', $data);
	}


		/****************************************************************************************/
		/****************************************************************************************/
		/****************************************************************************************/
		/*************      SPECIFIC TAGS AND CATEGORIES    *************************************/
		/****************************************************************************************/
		/****************************************************************************************/
		/****************************************************************************************/

		/*************************  MUSTER SPECIFIC TAG STARTS *******************************/

public function normal_tags()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$this->table = __FUNCTION__;
		$specialTag = str_replace('_tag', '', __FUNCTION__);



		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Tags');
		$bc->table_name('Special Standard Article');
		$bc->table('normal_tags');
		$bc->primary_key('id');
		$bc->title('Tag');

		$bc->custom_buttons(array());



		$select_array=array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		/************     COLUMNS/FILTERS    **************/

		$bc->list_columns(array('name', 'normals_tags_relation'));
		$bc->filter_columns(array('name', 'name_en', 'normals_tags_relation'));


			/************     BUTTONS    **************/

		$bc->custom_buttons(array(
		));

		/************     SELECT DATA PREPARATION    **************/

		$select_array=array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		/************     INPUT FIELDS    **************/



		$bc->columns(array(
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

			// specific tags - you can keep copy relation table structure with named like locations_tags_relation, columns entity_id and tag_id
				$specialTag .'_tags_relation' => array(
				'relation_id' => $specialTag . '_tags_relation',
				'type' => 'm_n_relation',
				'table_mn' => $specialTag . '_tags_relation',
				'table_mn_pk' => 'id',
				'table_mn_col_m' => 'tag_id',
				'table_mn_col_n' => 'entity_id',
				'table_m' => $this->table,
				'table_n' => $specialTag,
				'table_n_pk' => 'id',
				'table_n_value' => 'name',
				'table_n_value2' => 'id',
				'display_as' => $specialTag,
				'box_width' => 400,
				'box_height' => 250,
				'filter' => true,
			),


		));



		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

// 		/*************************  MUSTER SPECIFIC TAG ENDS *******************************/
}
