<?php

class Backend_model extends CI_Model
{

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

    public function getRecentlyAddedItems()
        {

            $this->db->order_by('id', 'desc');
            $this->db->limit(4);
            $this->db->where('lang', MAIN_LANGUAGE);
            $result = $this->db->get('items');
            return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function getOtherLanguageItems($original_item_id) {
        $this->db->where('original_item_id', $original_item_id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    // artists
    public function getAllArtists()
    {
        $result = $this->db->get('artists');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function updateArtist($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('artists', $data);
    }

        function removeItemById($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('items');
    }

    // entity tag relation

    function getTagRelationByEntityIdAndTagId($id, $type, $tag_id){
        $this->db->where('entity_id', $id);
        $this->db->where('type', $type);
        $this->db->where('tag_id', $tag_id);
        $result = $this->db->get('entities_tags_relation');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function insertTagRelation($data)
    {
        $this->db->insert('entities_tags_relation', $data);
    }

    function removeTagRelation($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('entities_tags_relation');
    }


    // categories
    public function get_items_categories()
    {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    // items
    public function get_items()
    {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function updateItemById($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('items', $data);
    }


    public function getRepoImages()
    {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('image_repository');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

          public function getFiles()
    {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('files');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_tags()
    {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_exhibitions()
    {
        $result = $this->db->get('exhibitions');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_ovrs()
    {
        $result = $this->db->get('ovrs');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    public function get_movie_programs()
    {
        $result = $this->db->get('movie_programs');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    public function get_shop_items()
    {
        $result = $this->db->get('shop_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    // Teaser images

    function removeEntityTeaserImage($data)
    {
        $this->db->where('repo_id', $data['repo_id']);
        $this->db->where('entity_id', $data['entity_id']);
        $this->db->where('type', $data['type']);
        $this->db->where('has_article', $data['has_article']);
        $this->db->delete('entity_teaser_relation');
    }



    function insertEntityTeaserImage($data)
    {
        $this->db->insert('entity_teaser_relation', $data);
    }

    function insertTextTeaserImage($data, $type)
    {
        $this->db->insert($type . '_teaser_relation', $data);
    }

function updateEntityTeaserImage($entity_id, $repo_id, $data, $type, $has_article = 1)
    {
        $this->db->where('entity_id', $entity_id);
        $this->db->where('repo_id', $repo_id);
        $this->db->where('type', $type);
        $this->db->where('has_article', $has_article);
        $this->db->update('entity_teaser_relation', $data);
    }

    function updateTextTeaserImage($item_id, $repo_id, $data)
    {
        $this->db->where('text_id', $item_id);
        $this->db->where('repo_id', $repo_id);
        $this->db->update('text_teaser_relation', $data);
    }




    function removeTextTeaserImage($data)
    {
        $this->db->where('repo_id', $data['repo_id']);
        $this->db->where('text_id', $data['text_id']);
        $this->db->delete('text_teaser_relation');
    }





    //****************** Agency ***************/


    public function get_agencies()
    {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('agency');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_agencies_user()
    {
        $this->db->order_by("name", "asc");
        $this->db->where("type", 0);
        $result = $this->db->get('agency');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_agencies_manager()
    {
        $this->db->order_by("name", "asc");
        $this->db->where("type", 1);
        $result = $this->db->get('agency');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    //****************** user ***************/

    public function check_is_registered_user($email)
    {
        $this->db->where('email', $email);
        /* $this->db->where('confirmed', 1); */
        $gallery = $this->db->get('user');
        return ($gallery->num_rows() > 0) ? $gallery->row() : false;
    }


    public function get_user_by_id($id)
    {
        $this->db->where('id', $id);
        $galleries = $this->db->get('user');
        return ($galleries->num_rows() > 0) ? $galleries->row() : false;
    }
    public function get_users()
    {

        $galleries = $this->db->get('user');
        return ($galleries->num_rows() > 0) ? $galleries->result() : array();
    }

    function update_user($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }

    //****************** manager ***************/

    public function check_is_registered_manager($email)
    {
        $this->db->where('email', $email);
        /* $this->db->where('confirmed', 1); */
        $gallery = $this->db->get('manager');
        return ($gallery->num_rows() > 0) ? $gallery->row() : false;
    }

    public function get_manager_by_id($id)
    {
        $this->db->where('id', $id);
        $galleries = $this->db->get('manager');
        return ($galleries->num_rows() > 0) ? $galleries->row() : false;
    }

    function update_manager($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('manager', $data);
    }
    function get_managers()
    {
        $galleries = $this->db->get('manager');
        return ($galleries->num_rows() > 0) ? $galleries->result() : array();
    }

    //***************** not used ************/




    function addWidget($data)
    {
        $this->db->insert('widgets', $data);
    }

    function removeWidget($wid)
    {
        $this->db->where('id', $wid);
        $this->db->delete('widgets');
    }

    function getWidgets($user_id)
    {
        $this->db->where('user_id', $user_id);
        $result =  $this->db->get('widgets');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_colors()
    {
        $result =  $this->db->get('colors');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_art_works()
    {
        $result =  $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_videos()
    {
        $result =  $this->db->get('videos');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_curated_circle()
    {
        $this->db->where('confirmed', 1);
        $result =  $this->db->get('curated_circle');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    function get_pending_galleries()
    {
        $this->db->where('active', 0);
        $result =  $this->db->get('gallery');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_galleries()
    {
        $result =  $this->db->get('gallery');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_inquiries()
    {

        $result =  $this->db->get('inquiry');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_future_programm()
    {

        $this->db->where('date_time >= now()');
        $this->db->order_by('date_time', 'asc');
        $result = $this->db->get('programm');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


        function getLeckerDashboard()
    {
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('lecker_dashboard');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

        function getLeckerAreas()
    {
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('lecker_areas');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

         function getLeckerMenus($id)
    {
        $this->db->where('area', $id);
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('lecker_menus');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

       function getLeckerSubmenus($id)
    {
        $this->db->where('menu', $id);
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('lecker_submenus');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


        public function get_color_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('colors');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }




    function addQuicklink($data)
    {
        $this->db->insert('menupoints', $data);
    }

    function removeQuicklink($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('menupoints');
    }

    function getQuicklinks($user_id)
    {
        $this->db->where('user_id', $user_id);
        $result =  $this->db->get('menupoints');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function getMenupoints($id, $db)
    {
        $this->db->db_select($db);
        $this->db->where('user_id', $id);
        $result = $this->db->get('menupoints');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function updateSorting($id, $data)
    {
        $this->db->db_select('hdgoe_website');
        $this->db->where('id', $id);
        $this->db->update('slider_article_relation', $data);
    }

    function updateStartingOrder($id, $data)
    {
        $this->db->db_select('hdgoe_website');
        $this->db->where('id', $id);
        $this->db->update('startingpage_setup', $data);
    }


    function updateRepo($id, $table, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }
}
