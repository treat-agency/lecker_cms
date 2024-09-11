<?php

class Frontend_model extends CI_Model
{

    /*************************  CHECKING IF SOMETHING EXIST *******************************/

    function method_exists($method)
    {
        $method = $method;
        if (method_exists($this, $method)) {
            return true;
        }
        return false;
    }




    /*************************************************************************/
    /*************************  CURRENT MODELS  *******************************/
    /*************************************************************************/

    /*************************  GENERAL INFO *******************************/

    public function getColorById($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('colors');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    /*************************  ITEM INFO *******************************/

    function getGeneralTagsRelation($id, $type)
    {
        $this->db->where('entity_id', $id);
        $this->db->where('type', $type);
        $result = $this->db->get('entities_tags_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function getMeItemsPlease()
    {
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    public function getGeneralTagById($id)
    {
        $this->db->where('id', $id);
        $tags = $this->db->get('tags');
        return ($tags->num_rows() > 0) ? $tags->row() : false;
    }


    public function get_tags()
    {
        $tags = $this->db->get('tags');
        return ($tags->num_rows() > 0) ? $tags->result() : array();
    }

    public function get_tags_by_id($id)
    {
        $this->db->where('id', $id);
        $tags = $this->db->get('tags');
        return ($tags->num_rows() > 0) ? $tags->result() : array();
    }

    function get_article_by_id_with_lang($id, $lang)
        {

        $this->db->where('id', $id);
        $this->db->where('lang', $lang);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    function get_article_where_original_id_item_id($id, $lang) {

        $this->db->where('original_item_id', $id);
        $this->db->where('lang', $lang);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }




    public function get_tags_by_item($id)
    {
        $this->db->select('tags.*');
        $this->db->join('tag_item_relation', ' tags.id = tag_item_relation.tag_id');
        $this->db->where("tag_item_relation.item_id", $id);
        $this->db->limit(1);
        $result = $this->db->get('tags');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_items_by_tag($id, $item_id = false)
    {
        $this->db->select('items.*');
        $this->db->join('tag_item_relation', ' items.id = tag_item_relation.item_id');
        $this->db->where("tag_item_relation.tag_id", $id);

        if ($item_id) {
            $this->db->where("items.id !=", $item_id);
        }

        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }




    /*************************  ENTITIES *******************************/


    // GENERAL

    public function getEntityByTypeNameAndId($type_name, $id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get($type_name);
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    // LOCATIONS
    function getLocationById($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('locations');
        return ($result->num_rows() > 0) ? $result->row() : false;

    }

    function getLocationTags($id)
    {
        $this->db->where('entity_id', $id);
        $result = $this->db->get('locations_tags_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function getLocationTagById($id)
    {
        $this->db->where('id', $id);
        $tags = $this->db->get('location_tags');
        return ($tags->num_rows() > 0) ? $tags->row() : false;
    }

    // NORMALS

    function getNormalById($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('normals');
        return ($result->num_rows() > 0) ? $result->row() : false;

    }

    function getNormalTags($id)
    {
        $this->db->where('entity_id', $id);
        $result = $this->db->get('normals_tags_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function getAllNormalTags()
        {
        $result = $this->db->get('normals_tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    public function getNormalTagById($id)
    {
        $this->db->where('id', $id);
        $tags = $this->db->get('normal_tags');
        return ($tags->num_rows() > 0) ? $tags->row() : false;
    }




    /*************************  LANDING PAGE *******************************/

    // openai copy
    function getPageSettings()
    {
        $this->db->where('id', 1);
        $result = $this->db->get('page_settings');
        return ($result->num_rows() > 0) ? $result->row() : false;

    }

    // openai copy
    function getLandingPageData()
    {
        $result = $this->db->get('lp_settings');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_lp_categories()
    {
        $this->db->where("landing_page", 1);
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_menu_categories()
    {
        $this->db->where("menu", 1);
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_category_by_pretty($pretty)
    {
        $this->db->where("pretty_url", $pretty);
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    /*************************  FILE REPOSITORY *******************************/

    function getFileById($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('files');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function getFilesByTag($id)
    {
        $this->db->order_by('ordering', 'asc');
        $this->db->where('file_tag', $id);
        $result = $this->db->get('files');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    /*************************  SHOP *******************************/


    // PRODUCTS

    public function getProducts()
    {
        $this->db->select('items.*, items.id as article_id, s_products.*, s_products.name_en as product_name_en, s_products.name as product_name');
        $this->db->join('s_products', 'items.product_id = s_products.id');
        $this->db->where("items.product_id !=", 0);
        $this->db->where("items.visible =", 1);
        $this->db->order_by("s_products.ordering", "asc");
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function getProductById($id)
    {
        $this->db->select('items.*, items.id as article_id, s_products.*, s_products.name_en as product_name_en, s_products.name as product_name');
        $this->db->join('s_products', 'items.product_id = s_products.id');
        $this->db->where("items.product_id", $id);
        $this->db->where("items.visible", 1);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function getProductVersions($id)
    {
        $this->db->where("product_id", $id);
        $this->db->where("stock_amount >", 0);
        $result = $this->db->get('s_product_versions');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    public function getShopArticleById($id)
    {
        $this->db->where('shop_item_id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    public function getShopItemById($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('shop_items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }



    /*************************  AUTHENTICATION *******************************/


    function getArtistByToken($token)
    {
        $this->db->where('s_token', $token);
        $result = $this->db->get('artists');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    function getPW($username)
    {
        $this->db->where('email', $username);
        $this->db->select('password');
        return $this->db->get('artists');
    }

    function getUser($email)
    {
        $this->db->where('email', $email);
        $result = $this->db->get('artists');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function updateArtist($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('artists', $data);
    }


    public function getArtistByPretty($pretty_url)
    {
        $this->db->where('pretty_url', $pretty_url);
        $artists = $this->db->get('artists');
        return ($artists->num_rows() > 0) ? $artists->row() : false;
    }





    //digitorial
    public function getDigiData()
    {
        $this->db->where("visible", 1);
        $this->db->order_by("elem_order", "asc");
        $result = $this->db->get('digitorial');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    // menu
    public function get_menu_items()
    {

        $this->db->where("visible", 1);
        $this->db->or_where("visible", 2);
        $this->db->order_by("menu_order", "asc");
        $result = $this->db->get('main_menu');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_menu_id_by_item_cat($item_id)
    {
        $this->db->select('main_menu.*');
        $this->db->join('main_menu', ' main_menu.category = category_item_relation.category_id');
        $this->db->where("category_item_relation.item_id", $item_id);
        $this->db->limit(1);
        $result = $this->db->get('category_item_relation');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_sub_menu_id_by_item_cat($item_id)
    {
        $this->db->select('sub_menu.*');
        $this->db->join('sub_menu', ' sub_menu.category = category_item_relation.category_id');
        $this->db->where("category_item_relation.item_id", $item_id);
        $this->db->limit(1);
        $result = $this->db->get('category_item_relation');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_sub_menu_id_by_item_pretty($pretty_url)
    {
        $this->db->where("pretty_url", $pretty_url);
        $this->db->limit(1);
        $result = $this->db->get('sub_menu');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_sub_menu_by_main_menu($id)
    {

        $this->db->where("main_menu", $id);
        $this->db->group_start();
        $this->db->where("visible", 1);
        $this->db->or_where("visible", 2);
        $this->db->group_end();
        $this->db->order_by("menu_order", "asc");
        $result = $this->db->get('sub_menu');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    public function get_closed_times()
    {
        $result = $this->db->get('closed_times');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    // exhibitions
    public function get_exh_by_id($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('exhibitions');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    // Movie programms
    public function get_mp_by_id($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('movie_programs');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    // shop items
    public function get_shop_item_by_id($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('shop_items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    // ovrs
    public function get_ovr_by_id($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('ovrs');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }






    public function getAllVisibleItems()
    {
        $this->db->order_by("name", "asc");
        $this->db->where('visible', 1);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }





    /* function update_projects($id, $data)
    {
    $this->db->where('id', $id);
    $this->db->update('projects', $data);
    }
    function update_items($id, $data)
    {
    $this->db->where('id', $id);
    $this->db->update('items', $data);
    }
    */


    // attributes
    public function get_project_attributes()
    {
        $this->db->order_by("attr_order", "asc");
        $result = $this->db->get('project_attributes');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_project_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('projects');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }
    // clients
    public function get_clients_by_project($id)
    {
        $this->db->select('clients.*');
        $this->db->join('clients_project_relation', ' clients.id = clients_project_relation.client_id');
        $this->db->where('clients_project_relation.project_id', $id);
        $result = $this->db->get('clients');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    // collaborators
    public function get_collaborators_by_project($id)
    {
        $this->db->select('collaborators.*');
        $this->db->join('collaborators_project_relation', ' collaborators.id = collaborators_project_relation.collaborator_id');
        $this->db->where('collaborators_project_relation.project_id', $id);
        $result = $this->db->get('collaborators');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    // keywords
    public function get_keywords_by_project($id)
    {
        $this->db->select('project_keywords.*');
        $this->db->join('keywords_project_relation', ' project_keywords.id = keywords_project_relation.keyword_id');
        $this->db->where('keywords_project_relation.project_id', $id);
        $result = $this->db->get('project_keywords');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    // case studio
    public function get_case_studios()
    {
        $this->db->order_by("name", "asc");
        $this->db->where('visible', 1);
        $this->db->where('lang', $this->language);
        $result = $this->db->get('case_studios');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_case_studio_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('case_studios');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    public function get_projects_by_cs($id)
    {
        $this->db->select('projects.*');
        $this->db->join('case_project_relation', ' projects.id = case_project_relation.project_id');
        $this->db->where('case_project_relation.case_id', $id);
        $this->db->where('lang', $this->language);
        $this->db->where('visible', 1);
        $result = $this->db->get('projects');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    public function get_mediums_by_cs($id)
    {
        $this->db->select('medium.*');
        $this->db->join('medium_case_relation', ' medium.id = medium_case_relation.medium_id');
        $this->db->where('medium_case_relation.case_id', $id);
        $result = $this->db->get('medium');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    public function get_subject_by_cs($id)
    {
        $this->db->select('subject.*');
        $this->db->join('subject_case_relation', ' subject.id = subject_case_relation.subject_id');
        $this->db->where('subject_case_relation.case_id', $id);
        $result = $this->db->get('subject');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    public function get_metadata_by_cs($id)
    {
        $this->db->select('metadata.*');
        $this->db->join('metadata_case_relation', ' metadata.id = metadata_case_relation.metadata_id');
        $this->db->where('metadata_case_relation.case_id', $id);
        $result = $this->db->get('metadata');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    // items
    /*   public function get_items_and_projects()
    {
    $this->db->distinct();
    $this->db->select('items.id as i_id,projects.id as p_id ,projects.img as p_img,projects.header_img as p_h_img, items.img as i_img, items.header_img as i_h_img');
    $this->db->join('items', 'projects.id = items.project');
    $this->db->where('items.type', 1);
    $result = $this->db->get('projects');
    return ($result->num_rows() > 0) ? $result->result() : array();
    } */

    // ARTICLES

    public function get_items()
    {
        $this->db->order_by("article_order", "asc");
        $this->db->where('lang', $this->language);
        $this->db->where('visible', 1);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    // for sitemap - don't delete
        public function get_all_items()
    {
        $this->db->order_by("name", "asc");
        $this->db->where('visible', 1);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function getRelatedModelSame($id, $table)
    {
        $this->db->where('related_id1', $id);
        $this->db->where('related_id2', $id);
        $result = $this->db->get($table);
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_article_by_origin_lang($id, $lang)
    {

        $this->db->where('original_item_id', $id);

        $this->db->where('lang', $lang);
        $this->db->where('visible', 1);

        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    // seo_purpose
    function getItemWhereOriginArticleThis($id) {
        $this->db->where('original_item_id', $id);
        $this->db->where('visible', 1);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }





    function get_related_by_item($id)
    {
        $this->db->select('items.*');
        $this->db->join('items', 'related_items.related_id = items.id');
        $this->db->where('related_items.article_id', $id);
        $this->db->where('items.visible', 1);
        $this->db->where('lang', $this->language);
        $this->db->order_by('items.name', 'asc');
        $result = $this->db->get('related_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_items_by_user($id)
    {
        $this->db->select('items.*');
        $this->db->join('user_items_relation', 'user_items_relation.item_id = items.id');
        $this->db->where('user_items_relation.user_id', $id);
        $this->db->where('items.visible', 1);
        $this->db->where('lang', $this->language);
        $this->db->order_by('items.name', 'asc');
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    function get_related_article($id)
    {
        $this->db->select('items.*');
        $this->db->join('items', 'related_items.related_id = items.id');
        $this->db->where('related_items.article_id', $id);
        $this->db->where('items.type', 0);
        $this->db->where('items.visible', 1);
        $this->db->where('items.lang', $this->language);
        $this->db->order_by('items.name', 'asc');
        $this->db->limit(3);
        $result = $this->db->get('related_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    public function get_items_by_cat($cat_id, $project = false, $order_date = false)
    {
        if ($project) {
            $this->db->select('items.*, projects.title as project_title, projects.country as project_country,projects.realisation_date_end as project_year, projects.project_order as project_order');
        } else {
            $this->db->select('items.*');
        }

        $this->db->join('category_item_relation', ' category_item_relation.item_id = items.id');
        $this->db->where("category_item_relation.category_id", $cat_id);

        if ($project) {
            // for sorting
            $this->db->join('projects', ' projects.id = items.project');
        }

        $this->db->where('items.lang', $this->language);
        $this->db->where('items.visible', 1);

        if ($order_date) {
            $this->db->order_by('items.date_added', 'desc');
        } else {
            $this->db->order_by('items.article_order', 'asc');
        }

        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    // FRONTEND USER

    public function check_is_registered_user_mail($email)
    {
        $this->db->where("email", $email);
        $this->db->where('expiry >= now()');
        $result = $this->db->get('frontend_user');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function check_is_registered_user($username)
    {
        $this->db->where("username", $username);
        $this->db->where('expiry >= now()');
        $result = $this->db->get('frontend_user');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    // users
    function update_frontend_user($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('frontend_user', $data);
    }

    function update_backend_user($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('backend_user', $data);
    }


    function get_frontend_user_by_id($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('backend_user');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function getAllTranslation()
    {
        $translation = $this->db->get('translations');
        return $translation->result();
    }


    public function insert_user_fav_relation($data)
    {
        $this->db->insert('user_items_relation', $data);
        return $this->db->insert_id();
    }
    public function insert_member($data)
    {
        $this->db->insert('members', $data);
        return $this->db->insert_id();
    }

    public function remove_user_fav_relation($item_id, $user_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('user_items_relation');
    }
    public function check_if_fav($item_id, $user_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->where('user_id', $user_id);
        $result = $this->db->get('user_items_relation');
        return ($result->num_rows() > 0) ? true : false;
    }




    public function add_user_project($data)
    {
        $this->db->insert('user_project_relation', $data);
        return $this->db->insert_id();
    }

    public function remove_user_project($user_id, $project_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('project_id', $project_id);
        $this->db->delete('user_project_relation');
    }



    function add_user($data)
    {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
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
        $result = $this->db->get('manager');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_managers()
    {
        $result = $this->db->get('manager');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_manager_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('manager');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function update_manager($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('manager', $data);
    }




    //***************** ToDos ************/

    function get_templates_by_agency($id)
    {
        $this->db->where('agency', $id);
        $result = $this->db->get('todos_template');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_template_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('todos_template');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    function add_template($data)
    {
        $this->db->insert('todos_template', $data);
        return $this->db->insert_id();
    }

    function update_template($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('todos_template', $data);
    }




    function get_template_todos_by_template($id)
    {
        $this->db->where('template', $id);
        $result = $this->db->get(' todos_template_todos');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    function get_todo_types()
    {
        $result = $this->db->get('todo_types');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function get_template_type_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('todo_types');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    //***************** End ToDos ************/




    //***************** projects ************/

    function get_projects_by_agency($id)
    {
        $this->db->where('agency', $id);
        $this->db->where('archived', 0);
        $result = $this->db->get('project');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_all_projects_by_agency($id)
    {
        $this->db->where('agency', $id);

        $result = $this->db->get('project');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }




    public function add_project($data)
    {
        $this->db->insert('project', $data);
        return $this->db->insert_id();
    }

    function update_project($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('project', $data);
    }

    //***************** end projects ************/


    //***************** Airports ************/

    function search_airports($term)
    {
        $term = trim($term);
        $term = strtolower($term);

        $this->db->or_like('LOWER(code)', $term, 'after');
        $this->db->or_like('LOWER(name)', $term, 'after');
        $this->db->or_like('LOWER(cityCode)', $term, 'after');
        $this->db->or_like('LOWER(cityName)', $term, 'after');
        $this->db->or_like('LOWER(countryName)', $term, 'after');
        $this->db->or_like('LOWER(countryCode)', $term, 'after');
        $this->db->limit(10);
        $result = $this->db->get('airports');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    //***************** end airports ************/






    //*****************  events ************/

    function get_event_categories()
    {

        $result = $this->db->get('event_categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_event_category_by_id($id)
    {

        $this->db->where('id', $id);
        $result = $this->db->get('event_categories');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    function get_events()
    {

        $result = $this->db->get('events');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_next5_events()
    {

        $this->db->limit(5);
        $this->db->order_by('start_date', 'asc');
        $this->db->where('start_date >= now()');
        $result = $this->db->get('events');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_events_by_agency($id)
    {

        $this->db->select('events.*');
        $this->db->join('project', 'events.project = project.id');
        $this->db->where('project.agency', $id);
        $this->db->order_by('events.title', 'asc');
        $result = $this->db->get('events');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_event_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('events');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }
    function get_events_by_project($id)
    {
        $this->db->where('project', $id);
        $result = $this->db->get('events');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function add_event($data)
    {
        $this->db->insert('events', $data);
        return $this->db->insert_id();
    }

    function update_event($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('events', $data);
    }
    //***************** end events ************/

    //*****************  Venus ************/

    function get_venue_types()
    {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('venue_types');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_venues()
    {
        $result = $this->db->get('venue');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_venues_by_agency($id)
    {
        $this->db->where('agency', $id);
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('venue');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_venue_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('venue');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function add_venue($data)
    {
        $this->db->insert('venue', $data);
        return $this->db->insert_id();
    }

    function update_venue($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('venue', $data);
    }

    //***************** end Venus ************/


    //*****************  contact people ************/

    function get_contact_people()
    {
        $result = $this->db->get('contact_people');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function get_contacts_by_agency($id)
    {
        $this->db->where('agency', $id);
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('contact_people');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function get_contact_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('contact_people');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function add_contact($data)
    {
        $this->db->insert('contact_people', $data);
        return $this->db->insert_id();
    }

    function update_contact($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('contact_people', $data);
    }


    //***************** end contact people ************/




    //***************** colors ************/

    public function get_color_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('colors');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }










    //***************** not used ************/



























    public function getSectionByID($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('sections');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function getSectionByUrl($pretty)
    {
        $this->db->where('section_preview', $pretty);
        $result = $this->db->get('sections');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function getCountries()
    {
        $this->db->order_by('name_en', 'asc');
        $result = $this->db->get('country');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    /*********  videos *******/
    public function get_main_video()
    {
        $this->db->where('visible', 1);
        // $this->db->where('main', 1);
        $this->db->where('time_stamp <=', date('Y-m-d H:i:s'));
        $this->db->order_by('time_stamp', 'desc');
        $result = $this->db->get('videos');
        return ($result->num_rows() > 0) ? $result->row() : array();
    }



    public function get_main_video_by_city($city, $section = 0)
    {
        $this->db->select('videos.*');
        $this->db->join('city', 'videos.city = city.id');
        $this->db->where('videos.visible', 1);
        $this->db->where('videos.city', $city);
        $this->db->where('videos.section', $section);
        $dst = date('I');

        $where = "`videos.time_stamp` <= CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);



        // $this->db->where('time_stamp <=', date('Y-m-d H:i:s'));
        $this->db->limit(1);
        $this->db->order_by('videos.time_stamp', 'desc');
        $result = $this->db->get('videos');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }
    public function get_videos_by_city($city, $section = 0)
    {
        $this->db->where('visible', 1);
        $this->db->where('city', $city);
        $this->db->where('section', $section);
        $this->db->order_by('time_stamp', 'asc');
        $result = $this->db->get('videos');
        return ($result->num_rows() > 0) ? $result->result() : false;
    }

    public function get_small_videos()
    {
        $this->db->where('visible', 1);
        // $this->db->where('main', 0);
        $this->db->where('time_stamp <=', date('Y-m-d H:i:s'));
        $this->db->order_by('time_stamp', 'desc');
        $result = $this->db->get('videos');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    public function get_small_videos_by_city($city, $section = 0)
    {
        $this->db->select('videos.*');
        $this->db->join('city', 'videos.city = city.id');
        $this->db->where('videos.visible', 1);
        $this->db->where('videos.city', $city);
        $this->db->where('videos.section', $section);
        $dst = date('I');

        $where = "`videos.time_stamp` <= CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);


        // $this->db->where('time_stamp <=', date('Y-m-d H:i:s'));
        $this->db->order_by('videos.time_stamp', 'desc');
        $result = $this->db->get('videos');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_videos_by_gallery($id, $section = 0)
    {
        $this->db->where('gallery', $id);
        $this->db->where('section', $section);
        $videos = $this->db->get('videos');
        return ($videos->num_rows() > 0) ? $videos->result() : array();
    }



    public function add_video($data)
    {
        $this->db->insert('videos', $data);
        return $this->db->insert_id();
    }


    public function update_video($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('videos', $data);
    }


    //********** zoom meetings *********/


    public function get_current_zoom_by_city($city, $section = 0)
    {
        $this->db->select('zoom_meetings.*');
        $this->db->join('city', 'zoom_meetings.city = city.id');
        $this->db->where('zoom_meetings.visible', 1);
        $this->db->where('zoom_meetings.city', $city);
        $this->db->where('zoom_meetings.section', $section);
        $dst = date('I');
        $where = "`zoom_meetings.start_date` <= CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);
        $where = "`zoom_meetings.end_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);


        //$this->db->where('start_date <=', date('Y-m-d H:i:s'));
        //$this->db->where('end_date >', date('Y-m-d H:i:s'));
        $this->db->order_by('zoom_meetings.start_date', 'desc');
        $result = $this->db->get('zoom_meetings');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_all_zoom_by_city($city, $section = 0)
    {
        $this->db->where('visible', 1);
        $this->db->where('city', $city);
        $this->db->where('section', $section);
        $this->db->order_by('start_date', 'desc');
        $result = $this->db->get('zoom_meetings');
        return ($result->num_rows() > 0) ? $result->result() : false;
    }


    public function get_zoom_meetings_by_gallery($id, $section = 0)
    {
        $this->db->where('gallery', $id);
        $this->db->where('section', $section);
        $zoom_meetings = $this->db->get('zoom_meetings');
        return ($zoom_meetings->num_rows() > 0) ? $zoom_meetings->result() : array();
    }


    public function add_meeting($data)
    {
        $this->db->insert('zoom_meetings', $data);
        return $this->db->insert_id();
    }

    public function update_meeting($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('zoom_meetings', $data);
    }

    public function delete_meeting($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('zoom_meetings');
    }






    //********** programm *********/

    public function get_grid_programm()
    {
        $this->db->where('visible', 1);
        $this->db->where('curated_circle_only', 0);
        $this->db->where('day(date_time) = day(now())');
        $this->db->where('month(date_time) = month(now())');
        $this->db->where('year(date_time) = year(now())');
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $result = $this->db->get('programm');
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            $this->db->where('visible', 1);
            $this->db->where('curated_circle_only', 0);
            $this->db->where('date_time >= now()');
            $this->db->order_by('rand()');
            $this->db->limit(1);
            $result = $this->db->get('programm');
            return ($result->num_rows() > 0) ? $result->row() : false;
        }
    }

    public function get_programm_by_gallery($gallery_id)
    {
        $this->db->where('visible', 1);
        $this->db->where('gallery', $gallery_id);
        $this->db->where('date_time >= now()');
        $this->db->order_by('date_time', 'asc');
        $result = $this->db->get('programm');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    public function get_programm_by_id($id)
    {

        $this->db->where('id', $id);
        $result = $this->db->get('programm');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_booked_by_programm($id)
    {
        $this->db->select('curated_circle.*');
        $this->db->join('programm_curated_relation', ' curated_circle.id = programm_curated_relation.curated_id');
        $this->db->where('programm_curated_relation.programm_id', $id);
        $result = $this->db->get('curated_circle');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_programm()
    {
        $this->db->where('visible', 1);
        $this->db->order_by('nr', 'desc');
        $result = $this->db->get('programm');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    public function add_programm($data)
    {
        $this->db->insert('programm', $data);
        return $this->db->insert_id();
    }
    public function add_booking($data)
    {
        $this->db->insert('programm_curated_relation', $data);
        return $this->db->insert_id();
    }

    public function update_programm($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('programm', $data);
    }




    //********** End programm *********/


    //********** social content *********/
    public function get_social_content_by_gallery($id)
    {
        $this->db->where('visible', 1);
        $this->db->where('gallery', $id);
        $this->db->order_by('rand()');
        $result = $this->db->get('social_mosaic');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    //********** End social content *********/


    //********** City *********/


    public function get_current_city()
    {
        $this->db->where('visible', 1);
        $this->db->where('is_space', 0);
        $dst = date('I');
        $where = "`starting_date` <= CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);
        $where = "`end_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);

        // $this->db->where('starting_date <=', date('Y-m-d H:i:s'));
        // $this->db->where('end_date >', date('Y-m-d H:i:s'));

        $this->db->order_by('starting_date', 'desc');
        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_all_cities()
    {
        $this->db->where('visible', 1);
        $this->db->where('is_space', 0);
        $dst = date('I');
        $where = "`starting_date` <= CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);


        // $this->db->where('starting_date <=', date('Y-m-d H:i:s'));

        $this->db->order_by('starting_date', 'desc');
        $this->db->where('end_date >', date('Y-m-d H:i:s'));
        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->result() : false;
    }

    public function get_all_future_cities()
    {
        $this->db->where('visible', 1);
        $this->db->where('is_space', 0);
        $dst = date('I');
        $where = "`starting_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);
        $where = "`end_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);

        // $this->db->where('starting_date <=', date('Y-m-d H:i:s'));
        // $this->db->where('end_date >', date('Y-m-d H:i:s'));

        $this->db->order_by('starting_date', 'asc');
        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->result() : false;
    }


    function getCitySectionsById($id)
    {
        $this->db->select('sections.*');
        $this->db->join('sections', 'city_section_relation.section_id = sections.id');
        $this->db->where('city_section_relation.city_id', $id);
        $result = $this->db->get('city_section_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function get_city_by_id($id)
    {
        $this->db->where('id', $id);
        $dst = date('I');
        $where = "`end_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);

        // $this->db->where('end_date >', date('Y-m-d H:i:s'));


        // $this->db->where('visible', 1);
        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }



    function get_city_by_pretty_url($pretty_url)
    {
        $this->db->where('pretty_url', $pretty_url);
        $this->db->where('visible', 1);
        $dst = date('I');
        $where = "`end_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);

        // $this->db->where('end_date >', date('Y-m-d H:i:s'));

        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function get_done_city_by_pretty_url($pretty_url)
    {
        $this->db->where('pretty_url', $pretty_url);
        $this->db->where('visible', 1);

        // $where = "`end_date` > CONVERT_TZ(now(), '+02:00', city.time_zone)";
        // $this->db->where($where);

        // $this->db->where('end_date >', date('Y-m-d H:i:s'));

        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function get_done_city_by_pretty_url_($pretty_url)
    {
        $this->db->where('pretty_url', $pretty_url);


        // $where = "`end_date` > CONVERT_TZ(now(), '+02:00', city.time_zone)";
        // $this->db->where($where);

        // $this->db->where('end_date >', date('Y-m-d H:i:s'));

        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }



    function get_space_by_pretty_url($pretty_url)
    {
        $this->db->where('pretty_url', $pretty_url);
        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    function get_future_city_by_pretty_url($pretty_url)
    {
        $this->db->where('pretty_url', $pretty_url);
        $this->db->where('visible', 1);
        $dst = date('I');

        $where = "`starting_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);
        $where = "`end_date` > CONVERT_TZ(now(), '+0" . (1 + $dst) . ":00', city.time_zone)";
        $this->db->where($where);

        // $this->db->where('starting_date <=', date('Y-m-d H:i:s'));
        // $this->db->where('end_date >', date('Y-m-d H:i:s'));


        $result = $this->db->get('city');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    /******* Spaces *******/

    public function add_city($data)
    {
        $this->db->insert('city', $data);
        return $this->db->insert_id();
    }

    public function update_city($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('city', $data);
    }

    public function update_city_by_url($pretty_url, $data)
    {
        $this->db->set('starting_date', 'starting_date', FALSE);
        $this->db->where('pretty_url', $pretty_url);
        $this->db->update('city', $data);
    }

    // space invite


    public function insert_space_invite($data)
    {
        $this->db->insert('space_invites', $data);
        return $this->db->insert_id();
    }

    function get_space_invite_by_invited_by($id)
    {
        $this->db->where('invited_by', $id);
        $result = $this->db->get('space_invites');
        return ($result->num_rows() > 0) ? $result->result() : false;
    }

    function get_space_invite_by_invited_email($email)
    {
        $this->db->where('invited_email', $email);
        $result = $this->db->get('space_invites');
        return ($result->num_rows() > 0) ? $result->result() : false;
    }
    function get_invite_by_email_and_invited_to($email, $space)
    {
        $this->db->where('invited_email', $email);
        $this->db->where('space', $space);
        $result = $this->db->get('space_invites');
        return ($result->num_rows() > 0) ? $result->result() : false;
    }

    function update_invite_by_id($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('space_invites', $data);
    }

    function delete_invite_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('space_invites');
    }

    /*********  collection items *******/
    public function get_collection_items()
    {
        $this->db->select('collection_items.* ,gallery.gallery_order ');
        $this->db->join('collection_gallery_relation', 'collection_items.id = collection_gallery_relation.item_id');
        $this->db->join('gallery', 'gallery.id = collection_gallery_relation.gallery_id');
        $this->db->where('visible', 1);
        $this->db->order_by('gallery.gallery_order , collection_items.nr', 'asc');
        // $this->db->order_by('collection_items.nr', 'asc');
        $collection_items = $this->db->get('collection_items');
        return ($collection_items->num_rows() > 0) ? $collection_items->result() : array();
    }

    public function get_collection_items_by_city($city_id)
    {
        $this->db->select('collection_items.* ,gallery.gallery_order, gallery.city ');
        $this->db->join('gallery', 'gallery.id = collection_items.gallery');
        $this->db->where('visible', 1);
        $this->db->where('gallery.city', $city_id);
        $this->db->order_by('gallery.gallery_order , collection_items.nr', 'asc');
        // $this->db->order_by('collection_items.nr', 'asc');
        $collection_items = $this->db->get('collection_items');
        return ($collection_items->num_rows() > 0) ? $collection_items->result() : array();
    }



    function getItemCollectionByPrettyURL($pretty)
    {
        $this->db->where('pretty_url', $pretty);
        //$this->db->where('visible', 1);
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    function getItemCollectionById($id)
    {
        $this->db->where('id', $id);
        //$this->db->where('visible', 1);
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function get_art()
    {
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function get_art_by_id($id)
    {
        $this->db->where('id', $id);
        //$this->db->where('visible', 1);
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    function get_art_by_gallery($id)
    {
        $this->db->where('gallery', $id);
        $this->db->order_by('nr', 'asc');
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }
    function get_home_art_by_gallery($id)
    {
        $this->db->where('gallery', $id);
        $this->db->where('visible', 1);
        $this->db->order_by('nr', 'asc');
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function replace_img($id, $img)
    {
        $this->db->set('img', $img);
        $this->db->where('id', $id);
        $this->db->update('collection_items');
    }
    function replace_thumb($id, $img)
    {
        $this->db->set('thumbnail', $img);
        $this->db->where('id', $id);
        $this->db->update('videos');
    }

    public function add_art($data)
    {
        $this->db->insert('collection_items', $data);
        return $this->db->insert_id();
    }

    public function update_art($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('collection_items', $data);
    }
    public function delete_art($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('collection_items');
    }

    function getObjectById($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('objects');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }


    function increase_inq_count($id)
    {
        $this->db->set('inq_count', 'inq_count + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('collection_items');
    }


    // sub image

    public function add_art_subimage($data)
    {
        $this->db->insert('sub_images', $data);
        return $this->db->insert_id();
    }
    function get_art_subimages_by_art($id)
    {
        $this->db->where('art_id', $id);
        $result = $this->db->get('sub_images');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function replace_subimage($id, $img)
    {
        $this->db->set('name', $img);
        $this->db->where('id', $id);
        $this->db->update('sub_images');
    }
    function delete_subimage($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sub_images');
    }




    /******* Calendar tages *******/
    public function get_calendar_tags()
    {
        $calendar_tags = $this->db->get('calendar_tags');
        return ($calendar_tags->num_rows() > 0) ? $calendar_tags->result() : array();
    }

    public function get_calendar_tags_by_item($id)
    {
        // SELECT `tag_id` FROM `collection_tag_relation` WHERE `item_id` = 2
        $this->db->select('calendar_tag_id');
        $this->db->where('item_id', $id);
        $calendar_tags = $this->db->get('article_calendar_tag_relation');
        return ($calendar_tags->num_rows() > 0) ? $calendar_tags->result() : array();
    }




    /******* artists *******/
    public function get_artists_by_gallery($id)
    {
        $this->db->where('gallery', $id);
        $this->db->order_by("sorting_letter", "asc");
        $artists = $this->db->get('artist');
        return ($artists->num_rows() > 0) ? $artists->result() : array();
    }








    public function get_artists()
    {
        $artist = $this->db->get('artist');
        // $this->db->order_by("sorting_letter", "asc");
        return ($artist->num_rows() > 0) ? $artist->result() : array();
    }

    public function get_artists_by_id($id)
    {
        $this->db->where('id', $id);
        $artists = $this->db->get('artist');
        return ($artists->num_rows() > 0) ? $artists->result() : array();
    }




    public function get_artists_by_city($city_id)
    {
        $this->db->select('artist.* , gallery.city');
        $this->db->join('gallery', 'gallery.id = artist.gallery');
        $this->db->where('gallery.city', $city_id);
        $this->db->order_by("sorting_letter", "asc");
        $artists = $this->db->get('artist');
        return ($artists->num_rows() > 0) ? $artists->result() : array();
    }

    public function get_artists_by_item($id)
    {
        // SELECT `tag_id` FROM `collection_tag_relation` WHERE `item_id` = 2
        // $this->db->select('tag_id');
        $this->db->where('item_id', $id);
        $artists = $this->db->get('collection_artist_relation');
        return ($artists->num_rows() > 0) ? $artists->result() : array();
    }


    public function add_artist($data)
    {
        $this->db->insert('artist', $data);
        return $this->db->insert_id();
    }

    public function update_artist($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('artist', $data);
    }


    /******* Galleries *******/


    public function get_galleries()
    {
        $this->db->order_by("gallery_order", "asc");
        $this->db->where("active", "1");
        $gallery = $this->db->get('gallery');
        return ($gallery->num_rows() > 0) ? $gallery->result() : array();
    }
    public function get_gallery_by_id($id)
    {
        $this->db->where('id', $id);
        $galleries = $this->db->get('gallery');
        return ($galleries->num_rows() > 0) ? $galleries->row() : false;
    }








    function getGallerySectionsById($id)
    {
        $this->db->select('sections.*');
        $this->db->join('sections', 'gallery_section_relation.section_id = sections.id');
        $this->db->where('gallery_section_relation.gallery_id', $id);
        $result = $this->db->get('gallery_section_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    public function get_galleries_by_id($id)
    {
        $this->db->where('id', $id);
        $galleries = $this->db->get('gallery');
        return ($galleries->num_rows() > 0) ? $galleries->result() : array();
    }




    public function get_galleries_by_city($id)
    {
        $this->db->where('city', $id);
        $this->db->order_by("gallery_order", "asc");
        $galleries = $this->db->get('gallery');
        return ($galleries->num_rows() > 0) ? $galleries->result() : array();
    }

    public function get_gallery_by_pretty($pretty_url)
    {
        $this->db->where('pretty_url', $pretty_url);
        $this->db->order_by("gallery_order", "asc");
        $galleries = $this->db->get('gallery');
        return ($galleries->num_rows() > 0) ? $galleries->row() : false;
    }




    public function check_promo_code($code)
    {
        $this->db->where('code', $code);
        $result = $this->db->get('promo_codes');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function get_galleries_by_item($id)
    {
        // SELECT `tag_id` FROM `collection_tag_relation` WHERE `item_id` = 2
        // $this->db->select('tag_id');
        $this->db->where('item_id', $id);
        $galleries = $this->db->get('collection_gallery_relation');
        return ($galleries->num_rows() > 0) ? $galleries->result() : array();
    }

    function insertgallery($data)
    {
        $this->db->insert('gallery', $data);
        return $this->db->insert_id();
    }


    function confirm_gallery($id)
    {
        $this->db->set('confirmed', 1, FALSE);
        $this->db->where('id', $id);
        $this->db->update('gallery');
    }


    function update_gallery($id, $amount, $data)
    {
        $this->db->set('amount_paid', 'amount_paid + ' . $amount, FALSE);
        $this->db->where('id', $id);
        $this->db->update('gallery', $data);
    }






    public function get_gallery_by_sub_id($sub_id)
    {
        $this->db->where('sub_id', $sub_id);
        $galleries = $this->db->get('gallery');
        return ($galleries->num_rows() > 0) ? $galleries->row() : false;
    }


    function insert_sub($data)
    {
        $this->db->insert('subs', $data);
        return $this->db->insert_id();
    }


    //****** End gallery *****/







    /******* all articles *******/


    function getItemByPrettyURL($pretty)
    {
        $this->db->where("trim(pretty_url)", $pretty);
        $this->db->where('visible', 1);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function getAnyItemByPrettyURL($pretty)
    {
        $this->db->where("trim(pretty_url)", $pretty);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function getAllArticles()
    {
        $this->db->where('visible', 1);
        $items = $this->db->get('items');
        return ($items->num_rows() > 0) ? $items->result() : false;
    }

    function getAllArticlesOfType($type)
    {
        $this->db->where('type', $type);
        $this->db->where('visible', 1);
        $items = $this->db->get('items');
        return ($items->num_rows() > 0) ? $items->result() : false;
    }


    function getArticleByOrigin($id)
    {
        $this->db->where('original_item_id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function getItemsByTags($tags, $type)
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->join('entities_tags_relation', 'items.id = entities_tags_relation.item_id AND entities_tags_relation.type = ' . $article_type);
        $this->db->join('tags', 'entities_tags_relation.tag_id = tags.id');
        if (is_array($tags) && count($tags) > 0) {
            // If you want items that match any of the tags
            $this->db->where_in('tags.tag', $tags);
            // If you want items that match all the tags, you might need a more complex query
        }
        $this->db->where('items.visible', 1);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result() : false;
    }

    function getItemById($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function updateEventByID($id, $num)
    {
        $this->db->set('num_ppl', 'num_ppl+' . $num, FALSE);
        $this->db->where('id', $id);
        $this->db->update('items');
    }


    function insertSignup($data)
    {

        $this->db->insert('event_signups', $data);
        return $this->db->insert_id();
    }

    function getSignups($id)
    {
        $this->db->where('tour_id', $id);
        $result = $this->db->get('event_signups');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function getRelatedArticles($id)
    {
        $this->db->select('items.*');
        $this->db->join('items', 'related_items.related_id = items.id');
        $this->db->where('related_items.article_id', $id);
        $this->db->where('items.visible', 1);
        $this->db->order_by('items.name', 'asc');
        $result = $this->db->get('related_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    /******** SEARCH **********/

    function getSearchByName($search)
    {
        $result = $this->db->query("SELECT * FROM searches WHERE name LIKE '%" . $search . "%';");
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function getSearchByNameEn($search)
    {
        $result = $this->db->query("SELECT * FROM searches WHERE name_en LIKE '%" . $search . "%';");
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function updateSearch($search)
    {
        $new_amount = $search->amount + 1;
        $data = array('amount' => $new_amount);
        $this->db->where('id', $search->id);
        $this->db->update('searches', $data);
    }

    public function addSearch($search)
    {
        $data = array('name' => $search, 'name_en' => '', 'amount' => 1);
        $this->db->insert('searches', $data);
        return $this->db->insert_id();
    }

    public function addSearchEn($search)
    {
        $data = array('name' => '', 'name_en' => $search, 'amount' => 1);
        $this->db->insert('searches', $data);
        return $this->db->insert_id();
    }

    public function getSelectorSearches()
    {
        $this->db->where('selector', 1);
        $result = $this->db->get('searches');
        return ($result->num_rows() > 0) ? $result->result() : array();

    }






    /******** CATEGORIES **********/
    public function get_categories()
    {
        $categories = $this->db->get('categories');
        return ($categories->num_rows() > 0) ? $categories->result() : array();
    }
    public function get_categories_by_item($id)
    {
        $this->db->select('categories.*');
        $this->db->join('category_item_relation', 'category_id = categories.id');
        $this->db->where('category_item_relation.item_id', $id);
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function getCategoryByPretty($table, $pretty)
    {
        $this->db->where('pretty_url', $pretty);
        $result = $this->db->get($table);
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function getCategoryById($table, $id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get($table);
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function getCalendarArticles()
    {
        $this->db->where('show_in_calendar', 1);
        $this->db->where('visible', 1);
        $this->db->order_by('calendar_display_date', 'asc');
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function getCategoryArticlesSub($id)
    {
        $this->db->select('items.*');
        $this->db->join('items', 'submenu_article_relation.article_id = items.id');
        $this->db->where('submenu_article_relation.submenu_id', $id);
        $this->db->where('items.visible', 1);
        // $this->db->order_by('items.name', 'asc');
        $this->db->order_by('items.calendar_display_date', 'asc');
        $result = $this->db->get('submenu_article_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function getCategoryArticlesSubSub($id)
    {
        $this->db->select('items.*');
        $this->db->join('items', 'sub_submenu_article_relation.article_id = items.id');
        $this->db->where('sub_submenu_article_relation.sub_submenu_id', $id);
        $this->db->where('items.visible', 1);
        $this->db->order_by('items.calendar_display_date', 'asc');
        $result = $this->db->get('sub_submenu_article_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    /*************************  MODULES  *******************************/

    // for search
    public function getTextModules()
    {
        $result = $this->db->get('module_text');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    function getModuleTextByItemId($itemId, $parent)
    {
        $this->db->select('*, "text" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_text');
    }

    
    function getModuleCollapsableByItemId($itemId, $parent)
    {
        $this->db->select('*, "collapsable" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_collapsable');
    }



    function getModuleSectionTitleByItemId($itemId, $parent)
    {
        $this->db->select('*, "sectiontitle" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_sectiontitle');
    }

    function getModuleHrByItemId($itemId, $parent)
    {
        $this->db->select('*, "hr" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_hr');
    }



    function getModuleMarqueeByItemId($itemId, $parent)
    {
        $this->db->select('*, "marquee" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_marquee');
    }



    function getModuleQuoteByItemId($itemId, $parent)
    {
        $this->db->select('*, "quote" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_quote');
    }

    function getModuleNewsByItemId($itemId, $parent)
    {
        $this->db->select('*, "news2" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_news');
    }



    function getModuleDropdownByItemId($itemId, $parent)
    {
        $this->db->select('*, "dropdown" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_dropdown');
    }

    function getModuleDownloadByItemId($itemId, $parent)
    {
        $this->db->select('*, "download" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_download');
    }

    function getModuleImageByItemId($itemId, $parent)
    {
        $this->db->select('module_image.*,  "image" as "mod"');
        $this->db->where('module_image.item_id', $itemId);
        $this->db->where('module_image.parent', $parent);
        return $this->db->get('module_image');
    }

    function getModuleHTMLByItemId($itemId, $parent)
    {
        $this->db->select('*, "html" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_html');
    }
    function getModuleVideoByItemId($itemId, $parent)
    {
        $this->db->select('*, "video" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_video');
    }

    function getModulesHeadline($itemId, $parent)
    {
        $this->db->select('*, "headline" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_headline');
    }

    function getModulesPdf($itemId, $parent)
    {
        $this->db->select('*, "pdf" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_pdf');
    }

    function getModulesStart($itemId, $parent)
    {
        $this->db->select('module_start.*,  "start" as "mod"');
        $this->db->where('module_start.item_id', $itemId);
        $this->db->where('module_start.parent', $parent);
        return $this->db->get('module_start');
    }

    function getModulesQuote($itemId, $parent)
    {
        $this->db->select('*, "quote" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_quote');
    }



    function getModulesNewsletter($itemId, $parent)
    {
        $this->db->select('*, "newsletter" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_newsletter');
    }



    function getModulesGallery($itemId, $db, $parent)
    {
        $this->db->db_select($db);
        $this->db->select('*, "gallery" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_gallery');
    }

    function getModulesGalleryImages($itemId, $db)
    {
        $this->db->db_select($db);
        $this->db->where('module_id', $itemId);
        return $this->db->get('module_gallery_items');
    }

    function getGalleryItems($itemId, $column_id)
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('item_id', $itemId);
        $this->db->where('type', $column_id);
        return $this->db->get('module_gallery_items');
    }

    function getModulesRelated($itemId, $db, $parent)
    {
        $this->db->db_select($db);
        $this->db->select('*, "related" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_related');
    }


    function getModuleColumnStartByItemId($itemId, $parent)
    {
        $this->db->select('*, "column_start" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_column_start');
    }

    function getModuleColumnEndByItemId($itemId, $parent)
    {
        $this->db->select('*, "column_end" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_column_end');
    }


    function getModulesEvents($itemId, $db, $parent)
    {
        $this->db->db_select($db);
        $this->db->select('*, "event" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_events');
    }

    /*************************  IMAGE REPOSITORY *******************************/

    function getRepoItem($itemId)
    {
        $this->db->where('id', $itemId);
        $this->db->where('public', 1);
        $result = $this->db->get('image_repository');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    public function getImagesForTag($tagId)
    {
        $this->db->where('tag_id', $tagId);
        $result = $this->db->get('image_tag_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function getAllRepoItems()
    {
        $result = $this->db->get('image_repository');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function updateRepoItem($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('image_repository', $data);
    }




    /*************************************************************************/
    /*************************  USEFUL FOR COPYING  *******************************/
    /*************************************************************************/


    /*************************  JOIN  *******************************/

    public function getShopItemsByExhibition($exh_id)
    {
        $this->db->select('shop_items.*');
        $this->db->join('exhibition_shop_relation', ' shop_items.id = exhibition_shop_relation.shop_id');
        $this->db->where("exhibition_shop_relation.exhibition_id", $exh_id);
        // $this->db->order_by("sorting_letter", "asc");
        $result = $this->db->get('shop_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    public function get_cats_by_item($item_id)
    {
        $this->db->select('categories.*, category_item_relation.*,categories.id as id,categories.name as category_name');
        $this->db->join('category_item_relation', ' categories.id = category_item_relation.category_id');
        $this->db->where("category_item_relation.item_id", $item_id);
        $this->db->where("categories.pretty_url != 'landing_page'");
        $this->db->order_by("categories.name", "asc");

        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }



    /*************************  UPDATE  *******************************/


    function updateEventSignup($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('event_signups', $data);
    }

    /*************************  INSERT  *******************************/

    function insertInquiry($data)
    {
        $this->db->insert('inquiry', $data);
        return $this->db->insert_id();
    }


    /*************************  GROUP  *******************************/


    public function get_cat_items_relation($cat_id)
    {
        $this->db->select('category_item_relation.*,items.*');
        $this->db->join('category_item_relation', ' items.id = category_item_relation.item_id');
        $this->db->where("category_item_relation.category_id", $cat_id);
        $this->db->where("items.lang", $this->language);

        $this->db->group_start();
        $this->db->where("visible", 1);
        $this->db->or_where("visible", 2);
        $this->db->group_end();


        $this->db->order_by("category_item_relation.item_order", "asc");

        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }


    /// needed

    public function get_category_by_id($id)
    {
        $this->db->where("id", $id);
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }



}