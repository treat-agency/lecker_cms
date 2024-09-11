<?php

class Besc_crud_model extends CI_Model
{
	public function get($db, $table, $where, $limit, $offset, $filters, $order_by_col, $order_by_direction)
	{
	    $this->db->db_select($db);
	    $this->db->select($table . '.*');
			$this->db->order_by('id', 'desc');

		if($where != '')
            $this->db->where($where);

	    if($filters['select'] != array())
	        $this->db->where($filters['select']);
	    if($filters['date'] != array())
	        $this->db->where($filters['date']);
	    if($filters['text'] != array())
	        $this->db->like($filters['text']);

	    if($filters['m_n_relation'] != array())
	    {
	        foreach($filters['m_n_relation'] as $f)
	        {
	            $this->db->where_in($f['id'], $f['values']);
	        }
	    }

	    // DONT FORGET THE OTHER FUNCTION

	    if($order_by_col != '' && $order_by_direction != '')
	        $this->db->order_by($order_by_col, $order_by_direction);


		$result = $this->db->get($table, $limit, $offset);

		// var_dump($this->db->last_query());
		return $result;
	}

	    // CHECKING IF METHOD EXISTS

    function method_exists($method)
{
    $method = $method;
    if (method_exists($this, $method))
    {
        return true;
    }
    return false;
}

// new

    function getRepoItemByFname($fname)
    {
        $this->db->where('fname', $fname);
        $result = $this->db->get('image_repository');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

	function deleteRepositoryTagRelation($repo_id)
	{
		$this->db->where('repo_id', $repo_id);
		$this->db->delete('image_tag_relation');
	}




	public function get_ordering($db, $table, $where, $ordering)
	{
	    $this->db->db_select($db);
	    if($where != '')
	        $this->db->where($where);

	    $this->db->order_by($ordering, 'asc');

	    return $this->db->get($table);
	}

	public function get_total($db, $table, $where, $filters)
	{
		$this->db->db_select($db);

	    if($where != '')
	        $this->db->where($where);

	    if($filters['select'] != array())
	        $this->db->where($filters['select']);

	    if($filters['text'] != array())
	        $this->db->like($filters['text']);

	    if($filters['m_n_relation'] != array())
	    {
	        foreach($filters['m_n_relation'] as $f)
	        {
	            $this->db->where_in($f['id'], $f['values']);
	        }
	    }

	    return $this->db->get($table);
	}

	public function get_sum($db, $table, $where, $filters,$sum_columns)
	{
		$this->db->db_select($db);

		if($sum_columns != array()){
			foreach($sum_columns as $sum_column){
				$this->db->select_sum($sum_column);
			}
		}

	    if($where != '')
	        $this->db->where($where);

	    if($filters['select'] != array())
	        $this->db->where($filters['select']);

	    if($filters['text'] != array())
	        $this->db->like($filters['text']);

	    if($filters['m_n_relation'] != array())
	    {
	        foreach($filters['m_n_relation'] as $f)
	        {
	            $this->db->where_in($f['id'], $f['values']);
	        }
	    }


	    return $this->db->get($table);
	}

	public function insert($db, $table, $data)
	{
		$this->db->db_select($db);
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function delete($db, $table, $pk_column, $pk_value, $article_type = false)
	{

		// if article type present, then delete also associated articles
		if($article_type){
		$this->db->db_select($db);
		$this->db->where('entity_id', $pk_value);
		$this->db->delete('items');
		}

		$this->db->db_select($db);
	    $this->db->trans_start();
		$this->db->where($pk_column, $pk_value);
		$this->db->delete($table);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		    return false;
	    else
	        return true;
	}

	public function getByID($db, $table, $pk_column, $pk_value)
	{
		$this->db->db_select($db);
		$this->db->where($pk_column, $pk_value);
		return $this->db->get($table);
	}

	public function update($db, $table, $pk_column, $pk_value, $data)
	{
	    $this->db->db_select($db);
	    $this->db->trans_start();
		$this->db->where($pk_column, $pk_value);
		$this->db->update($table, $data);
		$this->db->trans_complete();
		if( $this->db->affected_rows() == 1)
		    return true;
	    else
	        if ($this->db->trans_status() === FALSE)
	            return false;
	        else
	            return true;
	}

	public function get_m_n_relation_filter_ids($db, $table_mn, $table_mn_col_m, $table_mn_col_n, $table_m_value, $table_n, $table_n_value, $table_n_value2, $table_n_pk, $filter)
	{
	    $this->db->db_select($db);
	    $this->db->select($table_mn . '.' . $table_mn_col_m);
		$this->db->join($table_n, $table_n . '.' . $table_n_pk . '=' . $table_mn . '.' . $table_mn_col_n);
        $this->db->like($table_n . '.' . $table_n_value, $filter);
        $this->db->or_like($table_n . '.' . $table_n_value2, $filter);
	    return $this->db->get($table_mn);
	}

	public function get_m_n_relation($db, $table_mn, $table_mn_col_m, $table_mn_col_n, $table_m_value, $table_n, $table_n_value, $table_n_pk, $type = false)
		{
		$this->db->db_select($db);
		//  $this->db->select($table_n . '.' . $table_n_value);
		$this->db->select($table_n . '.*');
		if ($type) {
			$this->db->where('type', $type);
			}
		$this->db->from($table_mn);
		$this->db->join($table_n, $table_n . '.' . $table_n_pk . '=' . $table_mn . '.' . $table_mn_col_n);


		$this->db->where($table_mn . '.' . $table_mn_col_m, $table_m_value);
		return $this->db->get();
		}


	public function get_m_n_relation_m_values($db, $table_mn, $table_mn_col_m, $table_m_value, $table_n, $table_n_pk, $table_mn_col_n, $table_n_value, $table_n_value2, $table_n_value_mn = false)
		{
		$this->db->db_select($db);
		$this->db->select("$table_mn.$table_mn_col_n,$table_n.$table_n_pk, $table_n.$table_n_value, $table_n.$table_n_value2");
		$this->db->where($table_mn_col_m, $table_m_value);
		if ($table_n_value_mn) {
			$this->db->where('type', $table_n_value_mn);

			}
		$this->db->join($table_n, $table_n . '.' . $table_n_pk . '=' . $table_mn . '.' . $table_mn_col_n);
		$this->db->order_by("$table_n.$table_n_value", 'asc');
		return $this->db->get($table_mn);
		}

	public function get_m_n_relation_m_values_name($db, $table_mn, $table_mn_col_m, $table_m_value, $table_n, $table_n_pk, $table_mn_col_n, $table_n_value, $table_mn_col_name)
	{
		$this->db->db_select($db);
		$this->db->select("$table_mn.$table_mn_col_n, $table_n.$table_n_value $table_mn.$table_mn_col_name");
		$this->db->where($table_mn_col_m, $table_m_value);
		$this->db->join($table_n, $table_n . '.' . $table_n_pk .'=' . $table_mn . '.' . $table_mn_col_n);
		$this->db->order_by("$table_n.$table_n_value", 'asc');
		return $this->db->get($table_mn);
	}

	public function get_m_n_relation_n_values($db, $table_n, $table_n_pk, $already_selected, $table_n_value, $where = array(),$that_has = false)
	{
		$this->db->db_select($db);
		if (count($where) > 0) {
			$this->db->where($where);
		}
		//$this->db->where_not_in($table_n_pk, $already_selected);

		if($that_has){
			$this->db->join($that_has['from_table'], " $table_n.id = ".$that_has['from_table'].".".$that_has['pk']);
			$this->db->where($that_has['from_table'].".".$that_has['field_name'], $that_has['field_value']);
		}

		$this->db->order_by($table_n_value, 'asc');
		return $this->db->get($table_n);
	}

	public function get_m_n_value($db, $table, $table_pk, $table_val)
	{
		$this->db->db_select($db);
		$this->db->where($table_pk, $table_val);
		return $this->db->get($table);
	}

	public function delete_m_n_relationByID($db, $selected_ids, $table_mn, $table_mn_col_m, $table_mn_col_n, $table_mn_pk, $type)
		{
		$this->db->db_select($db);
		$this->db->trans_start();
		$this->db->where($table_mn_col_m, $table_mn_pk);
		if ($type) {
			$this->db->where('type', $type);
			}

		if (count($selected_ids) > 0) {
			$this->db->where_not_in($table_mn_col_n, $selected_ids);
			}

		$this->db->delete($table_mn);
		$this->db->trans_complete();
		return $this->db->trans_status() === false ? false : true;
		}


	public function insert_m_n_relation($db, $table_mn, $batchdata)
	{
	    $this->db->db_select($db);
	    $this->db->trans_start();
	    $this->db->insert_batch($table_mn, $batchdata);
	    $this->db->trans_complete();
	    return $this->db->trans_status() === false ? false : true;
	}

	public function insert_m_n_relationSingle($db, $table_mn, $data)
	{
	    $this->db->db_select($db);

	    $this->db->insert($table_mn, $data);


	}

	public function get_m_n_relation_saved($db, $table, $table_mn_m, $table_mn_n, $m_val, $n_val, $type = false)
		{
		$this->db->db_select($db);
		$this->db->where($table_mn_m, $m_val);
		if ($type) {
			$this->db->where('type', $type);
			}
		$this->db->where($table_mn_n, $n_val);
		$result = $this->db->get($table);
		return ($result->num_rows() > 0) ? true : false;
		}
	public function get_image_gallery_items($db, $table, $fk, $key)
	{
	    $this->db->db_select($db);
	    $this->db->trans_start();
	    $this->db->where($fk, $key);
	    $get = $this->db->get($table);
	    $this->db->trans_complete();
	    if($this->db->trans_status() === false)
	        return false;
	    else
	        return $get;
	}

	function save_ordering($db, $table, $batchdata, $key)
	{
	    $this->db->db_select($db);
	    $this->db->trans_start();
	    $this->db->update_batch($table, $batchdata, $key);
	    $this->db->trans_complete();
	    return $this->db->trans_status() === false ? false : true;
	}
}
