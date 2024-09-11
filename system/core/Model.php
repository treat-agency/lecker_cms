<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/userguide3/libraries/config.html
 */
class CI_Model
{

	/**
	 * Class constructor
	 *
	 * @link	https://github.com/bcit-ci/CodeIgniter/issues/5332
	 * @return	void
	 */
	public function __construct()
	{
	}

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}


	/*************************  UNIVERSAL MODELS *******************************/
	// getAnything - gets all rows based on table name
	// getAnythingWhere - gets rows based on table name, key and value
	// getOneById - gets row based on table name and id
	// updateWithData - updates row based on table name, id and data
	// updateKeyWithData - updates row based on table name, key, value and data
	// getAnyRelation - gets rows from multiple relation based on $relation_key_a, $relation_key_b, $relation_table, $value_a, $table_b, $key_b


	public function updateWithData($table, $id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($table, $data);
	}
	public function updateKeyWithData($table, $key, $value, $data)
	{
		$this->db->where($key, $value);
		$this->db->update($table, $data);
	}

	public function getAnything($table)
	{
		$result = $this->db->get($table);
		return ($result->num_rows() > 0) ? $result->result() : array();
	}


	public function getAnythingWhere($table, $key, $value)
	{
		$this->db->where($key, $value);
		$result = $this->db->get($table);
		return ($result->num_rows() > 0) ? $result->result() : array();
	}

	public function getOneById($table, $id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get($table);
		return ($result->num_rows() > 0) ? $result->row() : false;
	}

	public function getLastIdOfTable($table)
	{
		$this->load->database();
		$this->db->select_max('id');
		$result = $this->db->get($table);

		if ($result->num_rows() > 0) {
			$last_id = $result->row()->id + 1;
		} else {
			$last_id = 1;
		}

		return $last_id;
	}

	function getNextTableId($table)
		{

		$db_name = DB_NAME;
		// Replace 'your_database_name' with the actual name of your database
		$query = $this->db->query("SELECT `AUTO_INCREMENT`
                               FROM  INFORMATION_SCHEMA.TABLES
                               WHERE TABLE_SCHEMA = '$db_name'
                               AND   TABLE_NAME   = '$table'");
		$result = $query->row();
		return ($result) ? $result->AUTO_INCREMENT : false;
		}





	// get any related "b" things to thing "a"
	function getAnyRelations($relation_key_a, $relation_key_b, $relation_table, $value_a, $table_b, $key_b)
	{

		// init empty array for results
		$results = array();

		// get the relation rows from the table
		$a_b_relations = $this->fm->getAnythingWhere($relation_table, $relation_key_a, $value_a);

		// loop through the relation rows and get the related stuff for each
		foreach ($a_b_relations as $relation) {

			// get "table b" and grab the relevant row from there
			$b = $this->fm->getAnythingWhere($table_b, $key_b, $relation->{$relation_key_b});
			$b = $b->num_rows() > 0 ? $b->row() : false;

			if ($b != false) {
				// push it to results array
				$results[] = $b;
			}

		}

		// return the resulted "b" rows as an array
		return $results;
	}


	/*************************  CONTENT FUNCTIONS *******************************/

	// getAnyEntityOrNoarticle - gets entity or noarticle  based on type_id and id. By default for ARTICLE, if $no_article == true it searches NOARTICLE.
	// getTypeTableName - gets name of type table based on its type_id. By default ARTICLE_TYPES. If second argument is true, it searches in NOARTICLE_TYPES,

	public function getSecondLanguageArticles($original_item_id){
		$this->db->where('original_item_id', $original_item_id);
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->result() : array();

	}
	public function getAnyEntityOrNoarticle($type_id, $id, $no_article = false)
	{

		$table_name = $this->getTypeTableName($type_id, $no_article);

		$this->db->where('id', $id);
		$result = $this->db->get($table_name);

		return ($result->num_rows() > 0) ? $result->row() : false;
	}

	public function getTypeTableName($type_id, $no_article = false)
	{

		$array_of_types = ARTICLE_TYPES;

		if ($no_article == true) {
			$array_of_types = NOARTICLE_TYPES;
		}


		$keys = array_keys(ARTICLE_TYPES);
		$key_number = array_search($type_id, array_column(ARTICLE_TYPES, 'type_id'));

		$associative_array_key = $keys[$key_number];
		return $associative_array_key;
	}

	/*************************  TEASER IMAGES *******************************/

	// getTeaserImagesForEntityAndType - getting relation between entity and image based on type_id and entity_id, optional parameter has_article if you have entity with articles
	// getAnyRepoItemById - gets actual repo image by id


	function getTeaserImagesForEntityAndType($type_id, $entity_id, $has_article = 1)
	{
		$this->db->order_by('ordering', 'asc');
		$this->db->where("entity_id", $entity_id);
		$this->db->where("type", $type_id);
		$this->db->where("has_article", $has_article);
		$result = $this->db->get('entity_teaser_relation');
		return ($result->num_rows() > 0) ? $result->result() : array();
	}

	function getPublicRepoItemById($itemId)
	{
		$this->db->where('id', $itemId);
		$this->db->where('public', 1);
		$result = $this->db->get('image_repository');
		return ($result->num_rows() > 0) ? $result->row() : false;
	}

	function getAnyRepoItemById($itemId)
	{
		$this->db->where('id', $itemId);
		// $this->db->where('public', 1);
		$result = $this->db->get('image_repository');
		return ($result->num_rows() > 0) ? $result->row() : false;
	}


	/*************************  MODULES *******************************/
	// getModulesUniversal - gets modules based on module name, item id, db name and parent id
	// deleteModulesUniversal - deletes modules based on module name, item id, db name and parent id
	// insertModuleUniversal - inserts module based on module name, data and db name
	// getModuleRelatedItems - gets module related items based on module name, item id and db name
	// insertModuleRelatedItems - inserts module related items based on module name, data and db name


	function getModulesUniversal($module_name, $itemId, $db, $parent)
	{
		$this->db->db_select($db);
		$this->db->select('*, "' . $module_name .  '" as "mod"');
		$this->db->where('item_id', $itemId);
		$this->db->where('parent', $parent);
		return $this->db->get('module_' . $module_name);
	}




	function deleteModulesUniversal($module_name, $itemId, $db, $parent)
	{
		$this->db->db_select($db);
		$this->db->where('item_id', $itemId);
		$this->db->where('parent', $parent);
		$this->db->delete('module_' . $module_name);
	}

	function insertModuleUniversal($module_name, $data, $db)
	{
		$this->db->db_select($db);
		$this->db->insert('module_' . $module_name, $data);
		return $this->db->insert_id();
	}

	// related items

	function getModuleRelatedItems($module_name, $itemId, $db)
	{
		$this->db->db_select($db);
		$this->db->where('module_id', $itemId);
		$result = $this->db->get('module_' . $module_name . '_items');
		return ($result->num_rows() > 0) ? $result->result() : array();

	}


	function insertModuleRelatedItems($module_name, $data, $db)
	{
		$this->db->db_select($db);
		$this->db->insert('module_' . $module_name . '_items', $data);
		return $this->db->insert_id();
	}

	/*************************  ITEMS *******************************/
	// getAnyItemById - gets item by id
	// getAllItems - gets all items
	// getAllVisibleItems - gets all visible items
	// getAllVisibleItemById - gets all visible items by id
	// getItemsOfKind - gets all items of kind


	function getAnyItemById($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->row() : false;
	}

	function getVisibleItemById($id){
		$this->db->where('id', $id);
		$this->db->where('visible', 1);
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->row() : false;
	}

	function getAllItems()
	{
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->result() : array();
	}

	function getAllVisibleItems()
	{
		$this->db->where('visible', 1);
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->result() : array();
	}

	function getAllVisibleItemById($id)
	{
		$this->db->where('visible', 1);
		$this->db->where('id', $id);
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->row() : false;

	}

	function getItemsOfKind($typeId)
	{
		$this->db->where("type", $typeId);
		$this->db->where("visible", 1);
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->result() : array();
	}

	function getItemOfKindByEntityId($entity_id, $type_name = 'normals')
	{
		$this->db->where("entity_id", $entity_id);
		$this->db->where("type", ARTICLE_TYPES[$type_name]['type_id']);
		$this->db->where("visible", 1);
		$result = $this->db->get('items');
		return ($result->num_rows() > 0) ? $result->row() : false;
	}


	/*************************   TAGS *******************************/

	function getGeneralTags () {
		$result = $this->db->get('tags');
		return ($result->num_rows() > 0) ? $result->result() : array();
	}

	/*************************  RELATED SAFE *******************************/

	function getRelatedModel($id, $table)
	{
		$this->db->where('related_id1', $id);
		$this->db->or_where('related_id2', $id);
		$result = $this->db->get($table);
		return ($result->num_rows() > 0) ? $result->result() : array();
	}



}