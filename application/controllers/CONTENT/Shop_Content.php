<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Shop_Content
{

		/***************????***********      SHOP STARTS       *************?>?????******************/



		/**************************      PRODUCT ENTITIES       *******************************/

		public function products()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Products');
		$bc->table_name('Products');
		$bc->table('s_products');
		$bc->primary_key('id');
		$bc->title('Products');
		$bc->list_columns(array('ordering', 'name', 'name_en', 'max_amount', 'amount', 'sku', 'description', 'description_en', 'price_net', 'tax_id', 'available', 'product_categories_relation', 'product_tags_relation'));
		$bc->filter_columns(array('ordering', 'name', 'name_en', 'max_amount','amount', 'sku', 'description', 'description_en', 'price_net', 'tax_id', 'available', 'product_categories_relation', 'product_tags_relation'));
		$bc->custom_buttons(array());


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

        $tax_holder = array();
        $taxes = $this->cm->getTaxes();
        foreach($taxes as $t)
        {
            $tax_holder[] = array('key' => $t->id, 'value' => $t->tax_percent);
        }

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

			'max_amount' => array(
				'db_name' => 'max_amount',
				'type' => 'text',
				'display_as' => 'Max Amount',
			),
			'amount' => array(
				'db_name' => 'amount',
				'type' => 'text',
				'display_as' => 'Amount',
			),

			'teaser' => array(
				'db_name' => 'teaser',
				'type' => 'text',
				'display_as' => 'Teaser',
			),
			'teaser_en' => array(
				'db_name' => 'teaser_en',
				'type' => 'text',
				'display_as' => 'Teaser EN',
			),

			'ordering' => array(
				'db_name' => 'ordering',
				'type' => 'text',
				'display_as' => 'ordering',
			),


			'description' => array(
				'db_name' => 'description',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Description',
			),

			'description_en' => array(
				'db_name' => 'description_en',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Description EN',
			),
			'sku' => array(
				'db_name' => 'sku',
				'type' => 'text',
				'display_as' => 'SKU',
			),
			'price_net' => array(
				'db_name' => 'price_net',
				'type' => 'text',
				'display_as' => 'Price Net',
			),

		    'tax_id' => array(
		        'db_name' => 'tax_id',
		        'type' => 'select',
		        'options' => $tax_holder,
		        'display_as' => 'Tax percent',
		    ),

			'available' => array(
				'db_name' => 'available',
				'type' => 'select',
				'options' => $select_array,
				'display_as' => 'Available?',
			),


			'product_categories_relation' => array(
				'relation_id' => 'product_categories_relation',
				'type' => 'm_n_relation',
				'table_mn' => 's_product_categories_relation',
				'table_mn_pk' => 'id',
				'table_mn_col_m' => 'product_id',
				'table_mn_col_n' => 'category_id',
				'table_m' => 's_products',
				'table_n' => 's_product_categories',
				'table_n_pk' => 'id',
				'table_n_value' => 'name',
				'table_n_value2' => 'id',
				'display_as' => 'Categories',
				'box_width' => 400,
				'box_height' => 250,
				'filter' => true,
			),

			'product_tags_relation' => array(
				'relation_id' => 'product_tags_relation',
				'type' => 'm_n_relation',
				'table_mn' => 's_product_tags_relation',
				'table_mn_pk' => 'id',
				'table_mn_col_m' => 'product_id',
				'table_mn_col_n' => 'tag_id',
				'table_m' => 's_products',
				'table_n' => 's_product_tags',
				'table_n_pk' => 'id',
				'table_n_value' => 'name',
				'table_n_value2' => 'id',
				'display_as' => 'Tags',
				'box_width' => 400,
				'box_height' => 250,
				'filter' => true,
			),
			// 'product_versions_relation' => array(
			// 	'relation_id' => 'product_versions_relation',
			// 	'type' => 'm_n_relation',
			// 	'table_mn' => 's_product_versions_relation',
			// 	'table_mn_pk' => 'id',
			// 	'table_mn_col_m' => 'p_id',
			// 	'table_mn_col_n' => 'version_id',
			// 	'table_m' => 's_products',
			// 	'table_n' => 's_product_versions',
			// 	'table_n_pk' => 'id',
			// 	'table_n_value' => 'name',
			// 	'table_n_value2' => 'id',
			// 	'display_as' => 'Versions',
			// 	'box_width' => 400,
			// 	'box_height' => 250,
			// 	'filter' => true,
			// ),
		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function product_categories()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Product Categories');
		$bc->table_name('Product Categories');
		$bc->table('s_product_categories');
		$bc->primary_key('id');
		$bc->title('Product Categories');
		$bc->list_columns(array('name', 'name_en'));
		$bc->filter_columns(array('name', 'name_en'));
		$bc->custom_buttons(array());


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


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

		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function product_tags()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Product Tags');
		$bc->table_name('Product Tags');
		$bc->table('s_product_tags');
		$bc->primary_key('id');
		$bc->title('Product Tags');
		$bc->list_columns(array('name', 'name_en'));
		$bc->filter_columns(array('name', 'name_en'));
		$bc->custom_buttons(array());


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


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

		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function product_versions()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Product Versions');
		$bc->table_name('Product Versions');
		$bc->table('s_product_versions');
		$bc->primary_key('id');
		$bc->title('Product Versions');
		$bc->list_columns(array('product_id', 'name', 'name_en', 'description', 'description_en', 'color', 'size', 'stock_amount'));
		$bc->filter_columns(array('product_id', 'name', 'name_en', 'description', 'description_en', 'color', 'size', 'stock_amount'));
		$bc->custom_buttons(array());


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		$products_array = array();
		foreach($this->cm->getAllProducts() as $product)
		{
			$products_array[] = array('key' => $product->id, 'value' => $product->name);
		}

		$bc->columns(array(
			'product_id' => array(
				'db_name' => 'product_id',
				'type' => 'select',
				'options' => $products_array,
				'display_as' => 'Product',
			),
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
			'description' => array(
				'db_name' => 'description',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Description',
			),

			'description_en' => array(
				'db_name' => 'description_en',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Description EN',
			),
			'color' => array(
				'db_name' => 'color',
				'type' => 'text',
				'display_as' => 'Color',
			),
			'size' => array(
				'db_name' => 'size',
				'type' => 'text',
				'display_as' => 'Size',
			),
			'stock_amount' => array(
				'db_name' => 'stock_amount',
				'type' => 'text',
				'display_as' => 'Stock Amount',
			),


		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

/****************************      ORDERS ENTITY       ****************************/


	public function orders()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Orders');
		$bc->table_name('Orders');
		$bc->table('s_orders');
		$bc->primary_key('id');
		$bc->title('Orders');
		$bc->list_columns(array('customer_id', 'lastname', 'paymentState' , 'bill_id', 'paymentState', 'complete', 'city'));
		$bc->filter_columns(array('customer_id', 'firstname', 'lastname', 'company', 'uid', 'city', 'street', 'street_nr', 'door_stair', 'zip', 'land', 'email', 'phone', 'order_date', 'amount', 'delivery_cost', 'order_data', 'completed','bill_id', 'yearly_bill_id', 'paymentState', 'state_change', 'sent', 'type', 'transaction_id', 'mail_error', 'diff_delivery', 'delivery_name', 'delivery_zip', 'delivery_city', 'delivery_street', 'delivery_country', 'promo_code', 'discount', 'free_product', 'bill_id',));
		$bc->custom_buttons(array());









		$customer_array = array();
		foreach($this->cm->getCustomers() as $customer)
		{
			$customer_array[] = array('key' => $customer->id, 'value' => $customer->lastname);
		}


		$payment_options[] = array('key' => 0, 'value' => 'NO'); // add
		$shipping_options[] = array('key' => 0, 'value' => 'NO'); // add



		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$status_array[] = array('key' => ORDER_STATUS_PENDING, 'value' => 'Pending');
		$status_array[] = array('key' => ORDER_STATUS_PAYMENT_PENDING, 'value' => 'Payment Pending');
		$status_array[] = array('key' => ORDER_STATUS_PAYMENT_SUCCESS, 'value' => 'Payment_Success');
		$status_array[] = array('key' => ORDER_STATUS_IN_PROGRESS, 'value' => 'In Progress');
		$status_array[] = array('key' => ORDER_STATUS_LABEL_CREATED, 'value' => 'Label Created');
		$status_array[] = array('key' => ORDER_STATUS_DONE, 'value' => 'Done');


		$bc->columns(array(
			'customer_id' => array(
				'db_name' => 'customer_id',
				'type' => 'text',
				'display_as' => 'Customer ID',
			),
			'firstname' => array(
				'db_name' => 'firstname',
				'type' => 'text',
				'display_as' => 'Firstname',
			),
			'lastname' => array(
				'db_name' => 'lastname',
				'type' => 'text',
				'display_as' => 'Lastname',
			),
			'company' => array(
				'db_name' => 'company',
				'type' => 'text',
				'display_as' => 'Company',
			),
			'uid' => array(
				'db_name' => 'uid',
				'type' => 'text',
				'display_as' => 'uid',
			),
			'city' => array(
				'db_name' => 'city',
				'type' => 'text',
				'display_as' => 'City',
			),
			'street' => array(
				'db_name' => 'street',
				'type' => 'text',
				'display_as' => 'Street',
			),
			'street_nr' => array(
				'db_name' => 'street_nr',
				'type' => 'text',
				'display_as' => 'Street Nr.',
			),
			'door_stair' => array(
				'db_name' => 'door_stair',
				'type' => 'text',
				'display_as' => 'Door/Stair',
			),
			'zip' => array(
				'db_name' => 'zip',
				'type' => 'text',
				'display_as' => 'Zip',
			),
			'land' => array(
				'db_name' => 'land',
				'type' => 'text',
				'display_as' => 'Land',
			),
			'email' => array(
				'db_name' => 'email',
				'type' => 'text',
				'display_as' => 'Email',
			),
			'phone' => array(
				'db_name' => 'phone',
				'type' => 'text',
				'display_as' => 'Phone',
			),
			'order_date' => array(
				'db_name' => 'order_date',
				'type' => 'text',
				'display_as' => 'Order date',
			),
			'amount' => array(
				'db_name' => 'amount',
				'type' => 'text',
				'display_as' => 'Amount',
			),
			'delivery_cost' => array(
				'db_name' => 'delivery_cost',
				'type' => 'text',
				'display_as' => 'Delivery Cost',
			),
			'order_data' => array(
				'db_name' => 'order_data',
				'type' => 'multiline',
				'height' => '300',
				'display_as' => 'order_data',
			),
			'completed' => array(
				'db_name' => 'completed',
				'type' => 'select',
				'options' => 	$select_array,
				'display_as' => 'completed',
			),

			'yearly_bill_id' => array(
				'db_name' => 'yearly_bill_id',
				'type' => 'text',
				'display_as' => 'Yearly Bill ID',
			),
			'state_change' => array(
				'db_name' => 'state_change',
				'type' => 'text',
				'display_as' => 'State Change',
			),
			'sent' => array(
				'db_name' => 'sent',
				'type' => 'select',
				'options' => 	$select_array,
				'display_as' => 'sent',
			),
			'type' => array(
				'db_name' => 'type',
				'type' => 'text',
				'display_as' => 'Type',
			),
			'transaction_id' => array(
				'db_name' => 'transaction_id',
				'type' => 'text',
				'display_as' => 'Transaction ID',
			),
			'mail_error' => array(
				'db_name' => 'mail_error',
				'type' => 'multiline',
				'height' => '300',
				'display_as' => 'Mail Error',
			),
			'diff_delivery' => array(
				'db_name' => 'diff_delivery',
				'type' => 'select',
				'options' => 	$select_array,
				'display_as' => 'Different Delivery',
			),
			'delivery_name' => array(
				'db_name' => 'delivery_name',
				'type' => 'text',
				'display_as' => 'Delivery Name',
			),
			'delivery_zip' => array(
				'db_name' => 'delivery_zip',
				'type' => 'text',
				'display_as' => 'Delivery ZIP',
			),
			'delivery_city' => array(
				'db_name' => 'delivery_city',
				'type' => 'text',
				'display_as' => 'Delivery City',
			),
			'delivery_street' => array(
				'db_name' => 'delivery_street',
				'type' => 'text',
				'display_as' => 'Delivery Street',
			),
			'delivery_country' => array(
				'db_name' => 'delivery_country',
				'type' => 'text',
				'display_as' => 'Delivery Country',
			),
			'discount' => array(
				'db_name' => 'discount',
				'type' => 'text',
				'display_as' => 'Discount',
			),
			'free_product' => array(
				'db_name' => 'free_product',
				'type' => 'text',
				'display_as' => 'Free Product',
			),
			'promo_code' => array(
				'db_name' => 'promo_code',
				'type' => 'text',
				'display_as' => 'Promo Code',
			),
			'paymentState' => array(
				'db_name' => 'paymentState',
				'type' => 'select',
				'options' => $status_array,
				'display_as' => 'Status',
			),

			'bill_id' => array(
				'db_name' => 'bill_id',
				'type' => 'text',
				'display_as' => 'Bill ID',
			),


		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function ordered_products()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Order Notes');
		$bc->table_name('Order Notes');
		$bc->table('s_ordered_products');
		$bc->primary_key('id');
		$bc->title('Order Notes');
		$bc->list_columns(array('order_id', 'customer', 'created_at', 'note'));
		$bc->filter_columns(array('order_id', 'customer','created_at','note'));
		$bc->custom_buttons(array());


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$customer_array = array();
		foreach($this->cm->getCustomers() as $customer)
		{
			$customer_array[] = array('key' => $customer->id, 'value' => $customer->lastname);
		}


		$bc->columns(array(
			'order_id' => array(
				'db_name' => 'order_id',
				'type' => 'text',
				'display_as' => 'Order ID',
			),

			'customer' => array(
				'db_name' => 'customer_id',
				'type' => 'select',
				'options' => $customer_array,
				'display_as' => 'Customer',
			),

			'created_at' => array(
				'db_name' => 'created_at',
				'type' => 'text',
				'display_as' => 'Created At',
			),
			'note' => array(
				'db_name' => 'note',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Note',
			),

		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function order_notes()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Order Notes');
		$bc->table_name('Order Notes');
		$bc->table('s_order_notes');
		$bc->primary_key('id');
		$bc->title('Order Notes');
		$bc->list_columns(array('order_id', 'customer', 'created_at', 'note'));
		$bc->filter_columns(array('order_id', 'customer','created_at','note'));
		$bc->custom_buttons(array());


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$customer_array = array();
		foreach($this->cm->getCustomers() as $customer)
		{
			$customer_array[] = array('key' => $customer->id, 'value' => $customer->lastname);
		}


		$bc->columns(array(
			'order_id' => array(
				'db_name' => 'order_id',
				'type' => 'text',
				'display_as' => 'Order ID',
			),

			'customer' => array(
				'db_name' => 'customer_id',
				'type' => 'select',
				'options' => $customer_array,
				'display_as' => 'Customer',
			),

			'created_at' => array(
				'db_name' => 'created_at',
				'type' => 'text',
				'display_as' => 'Created At',
			),
			'note' => array(
				'db_name' => 'note',
				'type' => 'ckeditor',
				'height' => '300',
				'display_as' => 'Note',
			),

		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function taxes()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Shop');
		$bc->table_name('Taxes');
		$bc->table('s_taxes');
		$bc->primary_key('id');
		$bc->title('Taxes');
		$bc->list_columns(array('tax_percent'));
		$bc->filter_columns(array('tax_percent'));
		$bc->custom_buttons(array());


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');


		$bc->columns(array(
			'tax_percent' => array(
				'db_name' => 'tax_percent',
				'type' => 'text',
				'display_as' => 'Tax Percent',
			),


		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

	public function vouchers()
	{

		if ($this->user->is_admin != 1) {
			redirect('');
		}

		$bc = new besc_crud();

		$segments = $bc->get_state_info_from_url();
		$data['show_mods'] = false; //Toggle for module editor

		$bc->database(DB_NAME);
		$bc->main_title('Shop');
		$bc->table_name('Vouchers');
		$bc->table('s_vouchers');
		$bc->primary_key('id');
		$bc->title('Voucher');
		$bc->list_columns(array('code',  'discount', 'type', 'product', 'valid_start', 'valid_end'));
		$bc->filter_columns(array('code',  'discount', 'type', 'product'));
		$bc->custom_buttons(array());

		$products_array = array();
		$products_array[] = array('key' => 0, 'value' => 'NONE');
		foreach($this->cm->getAllProducts() as $product)
		{

			$products_array[] = array('key' => $product->id, 'value' => $product->name);
		}

		$voucher_type_array[] = array('key' => VOUCHER_ENTIRE_CART_PERCENT, 'value' => 'Entire Cart Percent');
		$voucher_type_array[] = array('key' => VOUCHER_ENTIRE_CART_FLAT, 'value' => 'Entire Cart Flat');
		$voucher_type_array[] = array('key' => VOUCHER_ATTACHED_PRODUCT_PERCENT, 'value' => 'Attached Product Percent');
		$voucher_type_array[] = array('key' => VOUCHER_ATTACHED_PRODUCT_FLAT, 'value' => 'Attached Product Flat');
		$voucher_type_array[] = array('key' => VOUCHER_FREE_EXTRA_PRODUCT, 'value' => 'Free Product');


		$select_array[] = array('key' => 0, 'value' => 'NO');
		$select_array[] = array('key' => 1, 'value' => 'YES');

		$bc->columns(array(
		    'code' => array(
		        'db_name' => 'code',
		        'type' => 'text',
		        'display_as' => 'Promo Code',
		    ),

		    'discount' => array(
		        'db_name' => 'discount',
		        'type' => 'text',
		        'display_as' => 'Discount',
		        'col_info' => 'Amount in % or flat EUR, number only'
		    ),

		    'type' => array(
				'db_name' => 'type',
				'type' => 'select',
				'options' => $voucher_type_array,
				'display_as' => 'Type',
			),

			'product' => array(
				'db_name' => 'product_id',
				'type' => 'select',
				'options' => $products_array,
				'display_as' => 'Product',
			),

			'valid_start' => array(
				'db_name' => 'valid_start',
				'type' => 'text',
				'display_as' => 'Valid Start',
			    'col_info' => 'Fromat: YYYY-MM-DD HH:MM (2023-01-01 10:00)'
			),

			'valid_end' => array(
				'db_name' => 'valid_end',
				'type' => 'text',
				'display_as' => 'Valid End',
			    'col_info' => 'Fromat: YYYY-MM-DD HH:MM (2023-01-01 10:00)'
			),


		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}

		/**********      CUSTOMER ENTITY       ************/


		public function customers()
		{

			if ($this->user->is_admin != 1) {
				redirect('');
			}

			$bc = new besc_crud();

			$segments = $bc->get_state_info_from_url();
			$data['show_mods'] = false; //Toggle for module editor

			$bc->database(DB_NAME);
			$bc->main_title('Customers');
			$bc->table_name('Customers');
			$bc->table('s_customers');
			$bc->primary_key('id');
			$bc->title('Customers');
			$bc->list_columns(array('firstname', 'lastname', 'country', 'city', 'zip', 'street', 'street_number', 'stair', 'email', 'phone', 'created_at'));
			$bc->filter_columns(array('firstname', 'lastname', 'country', 'city', 'zip', 'street', 'street_number', 'stair', 'email', 'phone', 'created_at'));
			$bc->custom_buttons(array());


			$select_array[] = array('key' => 0, 'value' => 'NO');
			$select_array[] = array('key' => 1, 'value' => 'YES');


			$bc->columns(array(
				'firstname' => array(
					'db_name' => 'firstname',
					'type' => 'text',
					'display_as' => 'First Name',
				),
				'lastname' => array(
					'db_name' => 'lastname',
					'type' => 'text',
					'display_as' => 'lastname',
				),
				'country' => array(
					'db_name' => 'country',
					'type' => 'text',
					'display_as' => 'Country',
				),
				'city' => array(
					'db_name' => 'city',
					'type' => 'text',
					'display_as' => 'City',
				),
				'zip' => array(
					'db_name' => 'zip',
					'type' => 'text',
					'display_as' => 'ZIP',
				),
				'street' => array(
					'db_name' => 'street',
					'type' => 'text',
					'display_as' => 'Street',
				),
				'street_number' => array(
					'db_name' => 'street_number',
					'type' => 'text',
					'display_as' => 'Street Number',
				),
				'stair' => array(
					'db_name' => 'stair',
					'type' => 'text',
					'display_as' => 'Stair',
				),
				'email' => array(
					'db_name' => 'email',
					'type' => 'text',
					'display_as' => 'Email',
				),
				'phone' => array(
					'db_name' => 'phone',
					'type' => 'text',
					'display_as' => 'Phone',
				),
				'created_at' => array(
					'db_name' => 'created_at',
					'type' => 'text',
					'display_as' => 'Created At',
				),

			));

			$data['crud_data'] = $bc->execute();
			$this->page('backend/crud/crud', $data);
		}


		public function favorites()
		{

			if ($this->user->is_admin != 1) {
				redirect('');
			}

			$bc = new besc_crud();

			$segments = $bc->get_state_info_from_url();
			$data['show_mods'] = false; //Toggle for module editor

			$bc->database(DB_NAME);
			$bc->main_title('Favorites');
			$bc->table_name('Favorites');
			$bc->table('s_favorites');
			$bc->primary_key('id');
			$bc->title('Favorites');
			$bc->list_columns(array('customer_id', 'product_id', 'created_at'));
			$bc->filter_columns(array('customer_id', 'product_id', 'created_at'));
			$bc->custom_buttons(array());


			$select_array[] = array('key' => 0, 'value' => 'NO');
			$select_array[] = array('key' => 1, 'value' => 'YES');

			$products_array = array();
			foreach($this->cm->getProducts() as $product)
			{
				$products_array[] = array('key' => $product->id, 'value' => $product->name);
			}

			$customer_array = array();
			foreach($this->cm->getCustomers() as $customer)
			{
				$customer_array[] = array('key' => $customer->id, 'value' => $customer->lastname);
			}



			$bc->columns(array(
				'customer_id' => array(
					'db_name' => 'customer_id',
					'type' => 'select',
					'options' => $customer_array,
					'display_as' => 'Customer',
				),
				'product_id' => array(
					'db_name' => 'product_id',
					'type' => 'select',
					'options' => $products_array,
					'display_as' => 'Product',
				),

				'created_at' => array(
					'db_name' => 'created_at',
					'type' => 'text',
					'display_as' => 'Created At',
				),

			));

			$data['crud_data'] = $bc->execute();
			$this->page('backend/crud/crud', $data);
		}

				/**************************      // WEBSHOP END        *******************************/
  }