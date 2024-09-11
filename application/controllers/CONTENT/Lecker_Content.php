<? defined('BASEPATH') or exit('No direct script access allowed');


trait Lecker_Content
{

	public function page_settings()
	{

		/************     AUTHENTICATION    **************/

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		/************     GETTING TYPE INFO - don't edit    **************/
		$table_name = __FUNCTION__; // name of this function
		// $noarticle_type = NOARTICLE_TYPES[$table_name]['type_id']; // type id got based on function name which is same as key at ARTICLE_TYPES array

		/************     CRUD STUFF    **************/
		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Settings');
		$bc->table_name('Page');
		// $bc->noarticle_type($noarticle_type);
		$bc->table($table_name);
		$bc->primary_key('id');
		$bc->title('Page Settings');

		/************     BUTTONS    **************/

		$bc->custom_buttons(
			array(


			)
		);

		/************     SELECT DATA PREPARATION    **************/


		$select_array = array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		// COLORS
		$colors_array = $this->getSelector('colors', 'name', 'hex');


		/************     SELECT TRAITS AND EXCEPTION TO INCLUDE   **************/
		// getting tables
		$tables_array = array();


		// Traits
		$Entity_Content = get_class_methods('Article_Entity_Content');
		$Noarticle_Content = get_class_methods('Noarticle_Entity_Content');
		$Tags_Content = get_class_methods('Tags_Content');

		// additional tables you can add manually
		$tables_additional = array('colors');


		// Combining them
		$raw_tables_array = array_merge($Entity_Content, $Noarticle_Content, $Tags_Content, $tables_additional);

		// exceptions
		$table_exceptions = array('lecker_dashboard', 'error_log');


		// checking exception and getting final array
		foreach ($raw_tables_array as $r) {
			if (!in_array($r, $table_exceptions)) {
				$tables_array[] = array('key' => $r, 'value' => $this->getPrettyName($r));
			}
		}



		/************     COLUMNS/FILTERS    **************/

		$bc->list_columns(array('show_openai', 'rows_on_one_page'));
		$bc->filter_columns(array('show_openai'));
		$bc->custom_buttons(array());


		/************     INPUT FIELDS    **************/



		$bc->columns(
			array(

				'show_openai' => array(
					'db_name' => 'show_openai',
					'type' => 'select',
					'options' => $select_array,
					'display_as' => 'Show OpenAI',
				),


				'rows_on_one_page' => array(
					'db_name' => 'rows_on_one_page',
					'type' => 'text',
					'display_as' => 'Rows on one page',

				),

			)
		);

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function google_analytics()
	{

		// $report = $this->GA_Analytics_User_Data();

		// THIS ONE
		$data['report'] = $this->GA_Analytics_Cities();
		// $data['crud_data'] = $bc->execute();

		$this->load->view('backend/g_analytics', $data);
	}

	public function lecker_dashboard()
	{

		/************     AUTHENTICATION    **************/

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		/************     GETTING TYPE INFO - don't edit    **************/
		$table_name = __FUNCTION__; // name of this function
		// $noarticle_type = NOARTICLE_TYPES[$table_name]['type_id']; // type id got based on function name which is same as key at ARTICLE_TYPES array

		/************     CRUD STUFF    **************/
		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Lecker');
		$bc->table_name('Widgets');
		// $bc->noarticle_type($noarticle_type);
		$bc->table($table_name);
		$bc->primary_key('id');
		$bc->title('Lecker Widget');

		/************     BUTTONS    **************/

		$bc->custom_buttons(
			array(


			)
		);

		/************     SELECT DATA PREPARATION    **************/


		$select_array = array();
		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		// COLORS
		$colors_array = $this->getSelector('colors', 'name', 'hex');


		/************     SELECT TRAITS AND EXCEPTION TO INCLUDE   **************/
		// getting tables
		$tables_array = array();


		// Traits
		$Entity_Content = get_class_methods('Article_Entity_Content');
		$Noarticle_Content = get_class_methods('Noarticle_Entity_Content');
		$Tags_Content = get_class_methods('Tags_Content');

		// additional tables you can add manually
		$tables_additional = array('colors');


		// Combining them
		$raw_tables_array = array_merge($Entity_Content, $Noarticle_Content, $Tags_Content, $tables_additional);

		// exceptions
		$table_exceptions = array('lecker_dashboard', 'error_log');


		// checking exception and getting final array
		foreach ($raw_tables_array as $r) {
			if (!in_array($r, $table_exceptions)) {
				$tables_array[] = array('key' => $r, 'value' => $this->getPrettyName($r));
			}
		}



		/************     COLUMNS/FILTERS    **************/

		$bc->list_columns(array('table', 'ordering', 'color'));
		$bc->filter_columns(array('table', 'ordering', 'color'));
		$bc->custom_buttons(array());


		/************     INPUT FIELDS    **************/



		$bc->columns(
			array(

				'ordering' => array(
					'db_name' => 'ordering',
					'type' => 'text',
					'display_as' => 'Ordering',

				),
				'table' => array(
					'db_name' => 'table',
					'type' => 'select',
					'options' => $tables_array,
					'display_as' => 'Table',
				),

				'color' => array(
					'db_name' => 'color',
					'type' => 'select',
					'options' => $colors_array,
					'display_as' => 'Color',
				),


			)
		);

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	// public function lecker_areas()
	// {

	// 	/************     AUTHENTICATION    **************/

	// 	if ($this->user->is_admin != 1) {
	// 		redirect('');
	// 	}

	// 	/************     GETTING TYPE INFO - don't edit    **************/
	// 	$table_name = __FUNCTION__; // name of this function
	// 	// $noarticle_type = NOARTICLE_TYPES[$table_name]['type_id']; // type id got based on function name which is same as key at ARTICLE_TYPES array

	// 	/************     CRUD STUFF    **************/
	// 	$bc = new besc_crud();

	// 	$segments = $bc->get_state_info_from_url();
	// 	$data['show_mods'] = false; //Toggle for module editor

	// 	$bc->database(DB_NAME);
	// 	$bc->main_title('Lecker');
	// 	$bc->table_name('Areas');
	// 	// $bc->noarticle_type($noarticle_type);
	// 	$bc->table($table_name);
	// 	$bc->primary_key('id');
	// 	$bc->title('Lecker Area');

	// 	/************     BUTTONS    **************/

	// 	$bc->custom_buttons(
	// 		array(
	// 			array(
	// 				'name' => 'Edit menus',
	// 				'icon' => site_url('items/backend/img/icon_itemlist.png'),
	// 				'add_pk' => true,
	// 				'url' => 'lecker_menus'
	// 			),
	// 		)
	// 	);

	// 	/************     SELECT DATA PREPARATION    **************/


	// 	$select_array = array();
	// 	$select_array[] = array('key' => 0, 'value' => 'NO');
	// 	$select_array[] = array('key' => 1, 'value' => 'YES');


	// 	// COLORS
	// 	$colors_array = array();
	// 	$colors = $this->cm->getColors();
	// 	foreach ($colors as $c) {
	// 		$colors_array[] = array('key' => $c->id, 'value' => $c->name . ' (' . $c->hex . ')');
	// 	}

	// 	/************     SELECT TRAITS AND EXCEPTION TO INCLUDE   **************/





	// 	/************     COLUMNS/FILTERS    **************/

	// 	$bc->list_columns(array('name', 'ordering', 'color'));
	// 	$bc->filter_columns(array('name', 'ordering', 'color'));
	// 	$bc->custom_buttons(array());


	// 	/************     INPUT FIELDS    **************/



	// 	$bc->columns(
	// 		array(

	// 			'name' => array(
	// 				'db_name' => 'name',
	// 				'type' => 'text',
	// 				'display_as' => 'Name',
	// 			),

	// 			'ordering' => array(
	// 				'db_name' => 'ordering',
	// 				'type' => 'text',
	// 				'display_as' => 'Ordering',

	// 			),

	// 			'color' => array(
	// 				'db_name' => 'color',
	// 				'type' => 'select',
	// 				'options' => $colors_array,
	// 				'display_as' => 'Color',
	// 			),


	// 		)
	// 	);

	// 	$data['crud_data'] = $bc->execute();
	// 	$this->page('backend/crud/crud', $data);
	// }

	// public function lecker_menus($id)
	// {

	// 	/************     CORRECTION OF URL    **************/

	// 	$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	// 	if (str_contains($url, 'lecker_submenus')) {
	// 		$new_url = str_replace('lecker_menus/', '', $url);
	// 		$http = DB_ACTIVE_GROUP != 'productive' ? 'http://' : 'https://';
	// 		header('Location: ' . $http . $new_url);
	// 		die();

	// 	}


	// 	/************     AUTHENTICATION    **************/

	// 	if ($this->user->is_admin != 1) {
	// 		redirect('');
	// 	}

	// 	/************     GETTING TYPE INFO - don't edit    **************/
	// 	$table_name = __FUNCTION__; // name of this function
	// 	// $noarticle_type = NOARTICLE_TYPES[$table_name]['type_id']; // type id got based on function name which is same as key at ARTICLE_TYPES array

	// 	/************     CRUD STUFF    **************/
	// 	$bc = new besc_crud();

	// 	$segments = $bc->get_state_info_from_url();
	// 	$data['show_mods'] = false; //Toggle for module editor

	// 	$bc->database(DB_NAME);
	// 	$bc->main_title('Lecker');
	// 	$bc->table_name('Menus');
	// 	$bc->where('area = ' . $id);
	// 	// $bc->noarticle_type($noarticle_type);
	// 	$bc->table($table_name);
	// 	$bc->primary_key('id');
	// 	$bc->title('Lecker Menu');

	// 	/************     BUTTONS    **************/

	// 	$bc->custom_buttons(
	// 		array(
	// 			array(
	// 				'name' => 'Edit submenus',
	// 				'icon' => site_url('items/backend/img/icon_itemlist.png'),
	// 				'add_pk' => true,
	// 				'url' => 'lecker_submenus'
	// 			),
	// 		)
	// 	);

	// 	/************     SELECT DATA PREPARATION    **************/


	// 	$select_array = array();
	// 	$select_array[] = array('key' => 0, 'value' => 'NO');
	// 	$select_array[] = array('key' => 1, 'value' => 'YES');


	// 	// COLORS
	// 	$colors_array = array();
	// 	$colors = $this->cm->getColors();
	// 	foreach ($colors as $c) {
	// 		$colors_array[] = array('key' => $c->id, 'value' => $c->name . ' (' . $c->hex . ')');
	// 	}

	// 	// AREAS
	// 	$areas_array = array();
	// 	$areas = $this->cm->getLeckerAreas();
	// 	foreach ($areas as $c) {
	// 		$areas_array[] = array('key' => $c->id, 'value' => $c->name);
	// 	}



	// 	/************     COLUMNS/FILTERS    **************/

	// 	$bc->list_columns(array('name', 'area', 'ordering', 'color', ));
	// 	$bc->filter_columns(array('name', 'area', 'ordering', 'color', ));
	// 	$bc->custom_buttons(array());


	// 	/************     INPUT FIELDS    **************/



	// 	$bc->columns(
	// 		array(

	// 			'name' => array(
	// 				'db_name' => 'name',
	// 				'type' => 'text',
	// 				'display_as' => 'Name',
	// 			),

	// 			'area' => array(
	// 				'db_name' => 'area',
	// 				'type' => 'select',
	// 				'options' => $areas_array,
	// 				'display_as' => 'Area',
	// 			),

	// 			'ordering' => array(
	// 				'db_name' => 'ordering',
	// 				'type' => 'text',
	// 				'display_as' => 'Ordering',
	// 			),


	// 			'color' => array(
	// 				'db_name' => 'color',
	// 				'type' => 'select',
	// 				'options' => $colors_array,
	// 				'display_as' => 'Color',
	// 			),

	// 		)
	// 	);

	// 	$data['crud_data'] = $bc->execute();
	// 	$this->page('backend/crud/crud', $data);
	// }



	// public function lecker_submenus($id)
	// {


	// 	/************     AUTHENTICATION    **************/

	// 	if ($this->user->is_admin != 1) {
	// 		redirect('');
	// 	}

	// 	/************     GETTING TYPE INFO - don't edit    **************/
	// 	$table_name = __FUNCTION__; // name of this function
	// 	// $noarticle_type = NOARTICLE_TYPES[$table_name]['type_id']; // type id got based on function name which is same as key at ARTICLE_TYPES array

	// 	/************     CRUD STUFF    **************/
	// 	$bc = new besc_crud();

	// 	$segments = $bc->get_state_info_from_url();
	// 	$data['show_mods'] = false; //Toggle for module editor

	// 	$bc->database(DB_NAME);
	// 	$bc->main_title('Lecker');
	// 	$bc->table_name('Submenus');
	// 	$bc->where('menu = ' . $id);

	// 	// $bc->noarticle_type($noarticle_type);
	// 	$bc->table($table_name);
	// 	$bc->primary_key('id');
	// 	$bc->title('Lecker Submenu');

	// 	/************     BUTTONS    **************/

	// 	$bc->custom_buttons(
	// 		array(


	// 		)
	// 	);

	// 	/************     SELECT DATA PREPARATION    **************/


	// 	$select_array = array();
	// 	$select_array[] = array('key' => 0, 'value' => 'NO');
	// 	$select_array[] = array('key' => 1, 'value' => 'YES');


	// 	// COLORS
	// 	$colors_array = array();
	// 	$colors = $this->cm->getColors();
	// 	foreach ($colors as $c) {
	// 		$colors_array[] = array('key' => $c->id, 'value' => $c->name . ' (' . $c->hex . ')');
	// 	}

	// 	// MENUS
	// 	$menus_array = array();
	// 	$menus = $this->cm->getLeckerMenus();
	// 	foreach ($menus as $c) {
	// 		$menus_array[] = array('key' => $c->id, 'value' => $c->name);
	// 	}

	// 	/************     SELECT TRAITS AND EXCEPTION TO INCLUDE   **************/
	// 	// getting tables
	// 	$tables_array = array();


	// 	// Traits
	// 	$Entity_Content = get_class_methods('Entity_Content');
	// 	$Noarticle_Content = get_class_methods('Noarticle_Content');
	// 	$Tags_Content = get_class_methods('Tags_Content');
	// 	$Meta_Content = get_class_methods('Meta_Content');
	// 	$Image_Content = get_class_methods('Image_Content');
	// 	$File_Content = get_class_methods('File_Content');

	// 	$Shop_Content = array();
	// 	if (IS_SHOP == 1) {
	// 		$Shop_Content = get_class_methods('Shop_Content');
	// 	}

	// 	// additional tables you can add manually
	// 	$tables_additional = array();


	// 	// Combining them
	// 	$raw_tables_array = array_merge($Entity_Content, $Noarticle_Content, $Tags_Content, $Shop_Content, $Meta_Content, $Image_Content, $File_Content, $tables_additional);


	// 	// exceptions
	// 	$table_exceptions = array();


	// 	// checking exception and getting final array
	// 	foreach ($raw_tables_array as $r) {
	// 		if (!in_array($r, $table_exceptions)) {
	// 			$tables_array[] = array('key' => $r, 'value' => $this->getPrettyName($r));
	// 		}
	// 	}



	// 	/************     COLUMNS/FILTERS    **************/

	// 	$bc->list_columns(array('table', 'menu', 'ordering', 'color', 'controller'));
	// 	$bc->filter_columns(array('table', 'menu', 'ordering', 'color', 'controller'));
	// 	$bc->custom_buttons(array());


	// 	/************     INPUT FIELDS    **************/



	// 	$bc->columns(
	// 		array(

	// 			'table' => array(
	// 				'db_name' => 'table',
	// 				'type' => 'select',
	// 				'options' => $tables_array,
	// 				'display_as' => 'Table',
	// 			),

	// 			'menu' => array(
	// 				'db_name' => 'menu',
	// 				'type' => 'select',
	// 				'options' => $menus_array,
	// 				'display_as' => 'Menu',
	// 			),

	// 			'ordering' => array(
	// 				'db_name' => 'ordering',
	// 				'type' => 'text',
	// 				'display_as' => 'Ordering',
	// 			),


	// 			'color' => array(
	// 				'db_name' => 'color',
	// 				'type' => 'select',
	// 				'options' => $colors_array,
	// 				'display_as' => 'Color',
	// 			),

	// 			'controller' => array(
	// 				'db_name' => 'controller',
	// 				'type' => 'text',
	// 				'value' => 'Content',
	// 				'display_as' => 'Controller',
	// 			),



	// 		)
	// 	);

	// 	$data['crud_data'] = $bc->execute();
	// 	$this->page('backend/crud/crud', $data);
	// }


}