<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Meta_Content
{

			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/
			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/
		  /*||||||||||||||||||||||||||      META / CONTENT        |||||||||||||||||||||||||||||*/
			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/
			/*|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||*/

// Settings
	public function main_menu()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Meta');
		$bc->table_name('Menu');
		$bc->table('main_menu');
		$bc->primary_key('id');
		$bc->title('Menu');
		$bc->list_columns(array('name', 'pretty_url', 'visible', 'menu_order', 'category'));
		$bc->filter_columns(array('name',  'pretty_url', 'visible', 'menu_order', 'category'));
		$bc->custom_buttons(array(
			array(
				'name' => 'Edit articles',
				'icon' => site_url('items/backend/img/icon_itemlist.png'),
				'add_pk' => true,
				'url' => 'sub_menu'
			),
		));



		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');
		$select_array[] = array('key' => 2, 'value' => 'Logged in only');


		$category_array[] = array('key' => 0, 'value' => 'NONE');
		$categories = $this->cm->get_items_categories();
		foreach ($categories as $category) {
			$category_array[] = array('key' => $category->id, 'value' => $category->name);
		}


		$items_array[] = array('key' => 'NONE', 'value' => 'NONE');
		$items = $this->cm->get_items();
		foreach ($items as $item) {
			$items_array[] = array('key' => $item->pretty_url, 'value' => $item->name . ' (' . $item->id . ')');
		}
		$bc->columns(array(
			'name' => array(
				'db_name' => 'name',
				'type' => 'multiline',
				'height' => 50,
				'display_as' => 'Name',
			),
			'category' => array(
				'db_name' => 'category',
				'type' => 'select',
				'options' => $category_array,
				'display_as' => 'Category',
			),
			'pretty_url' => array(
				'db_name' => 'pretty_url',
				'type' => 'text',
				'display_as' => 'Pretty URL'
			),

			'menu_order' => array(
				'db_name' => 'menu_order',
				'type' => 'text',
				'display_as' => 'Order',
			),

			'visible' => array(
				'db_name' => 'visible',
				'type' => 'select',
				'options' => $select_array,
				'display_as' => 'Visible',
			),


		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function  sub_menu($id)
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Meta');
		$bc->table_name('Sub-menu');
		$bc->table('sub_menu');
		$bc->where('main_menu = ' . $id);
		$bc->primary_key('id');
		$bc->title('Sub-menu');
		$bc->list_columns(array('name', 'pretty_url', 'visible', 'menu_order', 'category'));
		$bc->filter_columns(array('name',  'pretty_url', 'visible', 'menu_order', 'category'));
		$bc->custom_buttons(array());



		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');
		$select_array[] = array('key' => 2, 'value' => 'Logged in only');


		$category_array[] = array('key' => 0, 'value' => 'NONE');
		$categories = $this->cm->get_items_categories();
		foreach ($categories as $category) {
			$category_array[] = array('key' => $category->id, 'value' => $category->name);
		}


		$items_array[] = array('key' => 'NONE', 'value' => 'NONE');
		$items = $this->cm->get_items();
		foreach ($items as $item) {
			$items_array[] = array('key' => $item->pretty_url, 'value' => $item->name . ' (' . $item->id . ')');
		}



		$bc->columns(array(
			'name' => array(
				'db_name' => 'name',
				'type' => 'text',
				'display_as' => 'Name',
			),
			'category' => array(
				'db_name' => 'category',
				'type' => 'select',
				'options' => $category_array,
				'display_as' => 'Category',
			),
			'pretty_url' => array(
				'db_name' => 'pretty_url',
				'type' => 'text',
				'display_as' => 'Pretty URL'
			),
			'menu_order' => array(
				'db_name' => 'menu_order',
				'type' => 'text',
				'display_as' => 'Order',
			),

			'main_menu' => array(
				'db_name' => 'main_menu',
				'type' => 'hidden',
				'value' => $id,
			),

			'visible' => array(
				'db_name' => 'visible',
				'type' => 'select',
				'options' => $select_array,
				'display_as' => 'Visible',
			),


		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function lp_settings()
	{

		$this->groupName = "Landing Page";
		$this->typeOfTable = '';
		$this->setTableName();


	// 	/*************   CRUD STUFF   ****************/


		$this->listColumns  = (array('intro_text', 'has_topvideo', 'has_marquee1', 'marquee1_img', 'has_marquee2', 'marquee2_img'));
		$this->filterColumns = (array('intro_text'));


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		$lang_array[] = array('key' => MAIN_LANGUAGE, 'value' => 'German');
		$lang_array[] = array('key' => SECOND_LANGUAGE, 'value' => 'English');


		$columns = (array(
			'intro_text' => array(
				'db_name' => 'intro_text',
				'type' => 'text',
				'display_as' => 'Intro Text',
			),
			'has_topvideo' => array(
				'db_name' => 'has_topvideo',
				'type' => 'select',
				'options' => $select_array,
				'display_as' => 'Has Top Video',
			),
			'has_marquee1' => array(
				'db_name' => 'has_marquee1',
				'type' => 'select',
				'options' => $select_array,
				'display_as' => 'Has Marquee 1',
			),
			'marquee1_img' => array(
				'db_name' => 'marquee1_img',
				'type' => 'file',
				'display_as' => 'Marquee 1 Image',
				'col_info' => 'filetypes: .jpg, .png, .gif',
				'accept' => '.jpg, .png, .gif',
				'uploadpath' => 'items/uploads/images',
			),
			'has_marquee2' => array(
				'db_name' => 'has_marquee2',
				'type' => 'select',
				'options' => $select_array,
				'display_as' => 'Has Marquee 2',
			),
			'marquee2_img' => array(
				'db_name' => 'marquee2_img',
				'type' => 'file',
				'display_as' => 'Marquee 2 Image',
				'col_info' => 'filetypes: .jpg, .png, .gif',
				'accept' => '.jpg, .png, .gif',
				'uploadpath' => 'items/uploads/images',
			),
		));

		$this->columns = $columns;
		$data['show_mods'] = false;
		$this->prepareTable();
		$data['crud_data'] = $this->bc->execute($this->pagination);
		$this->page('backend/crud/crud', $data);
	}



	public function languages()
	{
		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Meta');
		$bc->table_name('Languages');
		$bc->table('languages');
		$bc->primary_key('id');
		$bc->title('Language');


		$bc->list_columns(array('name', 'short_name', 'iso_code'));
		$bc->filter_columns(array('name', 'short_name', 'iso_code'));
		$bc->custom_buttons(array());


		$bc->columns(array(
			'name' => array(
				'db_name' => 'name',
				'type' => 'text',
				'display_as' => 'Name',

			),

			'short_name' => array(
				'db_name' => 'short_name',
				'type' => 'text',
				'display_as' => 'Short Name',
			),

			'iso_code' => array(
				'db_name' => 'iso_code',
				'type' => 'text',
				'display_as' => 'ISO Code',
			),
		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}


	// COLORS

		public function colors()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Meta');
		$bc->table_name('Colors');
		$bc->table('colors');
		$bc->primary_key('id');
		$bc->title('Colors');
		$bc->list_columns(array('name', 'hex'));
		$bc->filter_columns(array('name', 'hex'));
		$bc->custom_buttons(array());

		$bc->columns(array(
			'name' => array(
				'db_name' => 'name',
				'type' => 'text',
				'display_as' => 'Name',
			),
			'hex' => array(
				'db_name' => 'hex',
				'type' => 'colorpicker',
				'hexinput' => true,
				'display_as' => 'HEX',
				'col_info' => '#XXXXXX or #XXX'
			)
		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}




}