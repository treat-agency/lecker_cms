<?php

class Content_model extends CI_Model
    {

    // CHECKING IF METHOD EXISTS

    function method_exists($method)
        {
        $method = $method;
        if (method_exists($this, $method)) {
            return true;
            }
        return false;
        }

    function deleteRepoImage($id)
        {

        $this->db->where('id', $id);
        $this->db->delete('image_repository');
        }

    // WEBSHOP START
    function getCustomers()
        {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('s_customers');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function customizeImage($data)
        {
        // $this->db->query("UPDATE image_repository SET public ='". $data['public'] . "' WHERE id = " . $data['id'] .";");
        return $this->db->query("UPDATE image_repository SET public ='" . $data['public'] . "' WHERE id = " . $data['id'] . ";");

        }

    public function getImageTeasers($id, $type, $has_article = 1)
        {
        $this->db->where('entity_id', $id);
        $this->db->where('type', $type);
        $this->db->where('has_article', $has_article);
        $result = $this->db->get('entity_teaser_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    function getAllProducts()
        {
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('s_products');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getLeckerMenus()
        {
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('lecker_menus');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getLeckerAreas()
        {
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('lecker_areas');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getAllLocations()
        {
        // $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('locations');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getAllArtworks()
        {
        // $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('artworks');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getAllNormals()
        {
        // $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('normals');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    public function getExistingImageTag($image_tag, $repo_id)
        {
        $this->db->where("repo_id", $repo_id);
        $this->db->where("tag_id", $image_tag);
        $result = $this->db->get('image_tag_relation');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    public function getRepoTagNames($id)
        {
        // $this->db->select("image_tags.name");
        $this->db->where("id", $id);
        $result = $this->db->get('image_tags');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }


    function getTaxes()
        {
        $this->db->order_by('tax_percent', 'asc');
        $result = $this->db->get('s_taxes');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getOriginalAssociatedItem($entity_id, $type)
        {
        $this->db->where("entity_id", $entity_id);
        $this->db->where("type", $type);
        $this->db->where("lang", MAIN_LANGUAGE);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }




    function getAllCustomers()
        {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('s_customers');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    // WEBSHOP END


    // TEASER IMAGES

    function getEntityTeasersByIdAndType($id, $type)
        {
        $this->db->order_by('ordering', 'asc');
        $this->db->where("entity_id", $id);
        $this->db->where("type", $type);
        $result = $this->db->get('entity_teaser_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getRepoTags()
        {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('image_tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    function getAllNormalTags()
        {
        $result = $this->db->get('normal_tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    function getRepoTagById($id)
        {
        $this->db->where('id', $id);
        $result = $this->db->get('image_tags');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }



    function updateRepoImage($id, $data)
        {
        $this->db->where('id', $id);
        $this->db->update('image_repository', $data);
        }



    function getFiles()
        {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('files');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getColors()
        {
        $result = $this->db->get('colors');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }



    function getRepositoryImageTags()
        {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('image_tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    function getFileTags()
        {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('file_tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }





    function getAllEventCategories()
        {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('event_categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }




    function getAllEventTags()
        {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('event_tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getAllTags()
        {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('tags');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function getItemTagById($id)
        {
        $this->db->where("id", $id);
        $result = $this->db->get('tags');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    public function getEnglishItemFromOriginal($id)
        {
        $this->db->where("original_item_id", $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    public function getArticleForEntity($id, $type)
        {
        $this->db->where("entity_id", $id);
        $this->db->where('type', $type);
        $this->db->where('lang', MAIN_LANGUAGE);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }






    public function getItemEventTagById($id)
        {
        $this->db->where("id", $id);
        $result = $this->db->get('event_tags');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }
    // function getArtworks()
    // {
    //     $this->db->order_by('id', 'asc');
    //     $result = $this->db->get('artworks');
    //     return ($result->num_rows() > 0) ? $result->result() : array();
    // }

    // function getArtworkByID($id)
    // {
    //     $this->db->where('id', $id);
    //     $result = $this->db->get('artworks');
    //     return ($result->num_rows() > 0) ? $result->row() : false;
    // }

    function deleteArtworkImages($id)
        {
        $this->db->where('artwork_id', $id);
        $this->db->delete('artwork_images');
        }

    function addArtworkImages($data)
        {
        $this->db->insert('artwork_images', $data);
        }

    function insertTeaserImagesForType($data)
        {
        $this->db->insert('entity_teaser_relation', $data);
        }




    function getArtworkImages($id)
        {
        $this->db->where('artwork_id', $id);
        $this->db->order_by('ordering', 'asc');
        $result = $this->db->get('artwork_images');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }



    // items
    public function get_items()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function get_original_items()
        {
        $this->db->order_by("name", "asc");
        $this->db->where('lang', MAIN_LANGUAGE);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }



    public function getSecondItem($id)
        {
        $this->db->where('lang', SECOND_LANGUAGE);
        $this->db->where('original_item_id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }


    public function get_exhibitions()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('exhibitions');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    public function get_editorial_topics()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('editorial_topics');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    // public function get_artists()
    // {
    //     $this->db->order_by("name", "asc");
    //     $result = $this->db->get('artists');
    //     return ($result->num_rows() > 0) ? $result->result() : array();
    // }

    public function get_artists_by_exh($exh_id)
        {
        $this->db->select('artists.*');
        $this->db->join('exhibition_artist_relation', ' artists.id = exhibition_artist_relation.artist_id');
        $this->db->where("exhibition_artist_relation.exhibition_id", $exh_id);
        $this->db->order_by("first_name", "asc");
        $result = $this->db->get('artists');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function get_one_artist_by_exh($exh_id)
        {
        $this->db->select('artists.*');
        $this->db->join('exhibition_artist_relation', ' artists.id = exhibition_artist_relation.artist_id');
        $this->db->where("exhibition_artist_relation.exhibition_id", $exh_id);
        $this->db->order_by("first_name", "asc");
        $result = $this->db->get('artists');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    public function get_events()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('events');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    public function get_shop_percentages()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('shop_percentages');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function get_shop_shipping_types()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('shipping_types');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    function get_locations()
        {
        $this->db->order_by('id', 'asc');
        $result = $this->db->get('locations');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function get_languages()
        {
        $this->db->order_by("id", "asc");
        $result = $this->db->get('languages');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    public function get_shop_items()
        {
        $result = $this->db->get('shop_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    // categories
    public function get_items_categories()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function getItemCategoryById($id)
        {
        $this->db->where("id", $id);
        $result = $this->db->get('categories');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    public function get_repo_texts()
        {
        $this->db->order_by("text_id", "asc");
        $result = $this->db->get('text_repo');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    public function get_repo_text($column_name, $table_name, $row_id, $lang)
        {
        $this->db->select('text_repo.*');

        $this->db->join('text_repo_field_relation', 'text_repo.id = text_repo_field_relation.text_id');
        $this->db->where("text_repo_field_relation.column_name", $column_name);
        $this->db->where("text_repo_field_relation.table_name", $table_name);
        $this->db->where("text_repo_field_relation.row_id", $row_id);

        if ($lang >= 0) {
            $this->db->where("text_repo.language_id", $lang);
            }

        $result = $this->db->get('text_repo');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    public function get_repo_text_by_id($id)
        {
        $this->db->where('id', $id);
        $result = $this->db->get('text_repo');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    public function insert_repo_text($column_name, $table_name, $row_id, $lang, $text)
        {

        $this->db->insert(
            'text_repo',
            array(
                'language_id' => $lang,
                'text' => $text
            )
        );
        $text_id = $this->db->insert_id();

        $this->db->insert(
            'text_repo_field_relation',
            array(
                'column_name' => $column_name,
                'table_name' => $table_name,
                'row_id' => $row_id,
                'text_id' => $text_id
            )
        );

        return $this->db->insert_id();
        }

    public function update_repo_text($id, $text)
        {
        $this->db->where("id", $id);
        return $this->db->update('text_repo', array('text' => $text));
        }

    public function findArticleByEntityIdAndLanguage($entity_id, $lang)
        {
        $this->db->where('entity_id', $entity_id);
        $this->db->where('lang', $lang);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    public function updateArticle($id, $dd)
        {
        $this->db->where('id', $id);
        $this->db->update('items', $dd);
        }

    public function removeArticle($id)
        {
        $this->db->where('id', $id);
        $this->db->delete('items');
        }

    public function insertArticle($data)
        {
        $this->db->insert('items', $data);
        return $this->db->insert_id();
        }




    //************ not yet optimised for SKV *********/



    function getItemByIDTable($id, $db, $table)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        $result = $this->db->get($table);
        return ($result->num_rows() > 0) ? $result->row() : false;
        }
    function getSocailTemplatesRND($type)
        {
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $this->db->where('social_type', $type);
        $result = $this->db->get('social_templates');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    // Project related
    public function get_projects()
        {
        $this->db->order_by("title", "asc");
        $result = $this->db->get('projects');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    public function get_all_labels()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('project_labels');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    public function get_all_stages()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('project_stages');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    public function get_all_types()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('project_types');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    public function get_all_statuses()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('project_statuses');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }
    public function get_all_managers()
        {
        $this->db->order_by("name", "asc");
        $result = $this->db->get('managers');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }




    function getRepositoryImages($db)
        {

        // if($pagination > 0){
        //     $numberOfImages = intval($pagination) * 20;
        //     $this->db->limit($numberOfImages);
        // }
        $this->db->order_by('id', 'desc');        $this->db->where('fname !=', '');
        $this->db->select('image_repository.*, image_categories.name as category_name');
        $this->db->join('image_categories', 'image_categories.id = image_repository.category', 'left');
        $this->db->order_by('image_repository.id', 'desc');
        $result = $this->db->get('image_repository');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getRepositoryImageByID($id)
        {
        $this->db->select('image_repository.*, image_categories.name as category_name');
        $this->db->where('image_repository.id', $id);
        $this->db->join('image_categories', 'image_categories.id = image_repository.category');
        $result = $this->db->get('image_repository');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    function getRepoCategories()
        {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('image_categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function insertRepoImage($data)
        {
        $this->db->insert('image_repository', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
        }

    function deleteRepoImageTags($tag_id, $id)
        {
        $this->db->where('repo_id', $id);
        $this->db->where('tag_id', $tag_id);
        $result = $this->db->delete('image_tag_relation');
        }

    function insertRepoImageTags($data)
        {
        $this->db->insert('image_tag_relation', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
        }

    public function getTagsForRepositoryImage($id)
        {
        $this->db->where("repo_id", $id);
        $result = $this->db->get('image_tag_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }



    function deleteModulesForArticle($module_type, $id)
        {
        $this->db->where('item_id', $id);
        $this->db->delete('module_' . $module_type);
        }

    function getItemByIDSU($id, $db)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }


    function getArticles()
        {
        $this->db->where('lang', 0);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getItemById($id, $db = false)
        {
        // $this->db->db_select($db);
        $this->db->where('id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;


        }

    function getOtherLanguageItem($id, $db = false)
        {
        // $this->db->db_select($db);
        $this->db->where('original_item_id', $id);
        $this->db->where('lang', SECOND_LANGUAGE);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;


        }

    function getItemByIdAsArray($id, $db = false)
        {
        // $this->db->db_select($db);
        $this->db->where('id', $id);
        return $this->db->get('items');


        }
    function getItemByIdAndType($id, $type_name)
        {
        // $this->db->db_select($db);
        $this->db->where('id', $id);
        return $this->db->get($type_name);

        }
    function getEntityByIdAndType($id, $type_name)
        {
        // $this->db->db_select($db);
        $this->db->where('id', $id);
        return $this->db->get($type_name);

        }






    function getAnyEntityById($id, $type_name, $db = false)
        {
        // $this->db->db_select($db);
        $this->db->where('id', $id);
        $result = $this->db->get($type_name);
        return ($result->num_rows() > 0) ? $result->row() : false;


        }

    function getArticleById($id, $db = false)
        {
        $this->db->where('id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;

        }

    function getRelatedArticleById($id, $db = false)
        {
        // $this->db->db_select($db);
        $this->db->where('original_item_id', $id);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;

        }

    function getItemCollectionByID($id, $db)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }


    function getItemCollections()
        {
        $this->db->order_by('InvenotryNR', 'asc');
        $result = $this->db->get('collection_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    function getimageCategories()
        {
        $this->db->order_by('name', 'asc');
        $result = $this->db->get('image_categories');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getMenuID($id)
        {
        $this->db->where('id', $id);
        return $this->db->get('main_menu')->row();
        }

    function getOriginalItemPrettyUrlByType($id, $type)
        {
        $this->db->where('id', $id);
        $this->db->where('type', $type);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;

        }

    function getSecondLanguageArticle($id)
        {
        $this->db->where('original_item_id', $id);
        $this->db->where('lang', SECOND_LANGUAGE);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    function getLatestModule($item_id, $type)
        {
        $this->db->where('item_id', $item_id);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('module_' . $type);
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    function getSingleModuleImage($repoModuleType, $repoModuleId)
        {
        $this->db->where('id', $repoModuleId);
        $result = $this->db->get('module_' . $repoModuleType);
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    function getSubMenuID($id)
        {
        $this->db->where('id', $id);
        return $this->db->get('sub_menus')->row();
        }



    function getBackendUserByID($id, $db)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        return $this->db->get('backend_user');
        }
    function getFrontendUserByID($id, $db)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        return $this->db->get('frontend_user');
        }

    function getBackendUserByToken($token, $db)
        {
        $this->db->db_select($db);
        $this->db->where('reset_token', $token);
        $result = $this->db->get('backend_user');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }






    function cloneItem($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('items', $data);
        return $this->db->insert_id();
        }

    function cloneEntityByType($data, $type)
        {
        $this->db->insert($type, $data);
        return $this->db->insert_id();
        }

    function cloneCollectionItem($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('collection_items', $data);
        return $this->db->insert_id();
        }

    function getItemCollectionTags($db, $id)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $id);
        $result = $this->db->get('collection_tag_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function inserItemCollectiontTag($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('collection_tag_relation', $data);
        }


    function getArticleRelated($db, $id)
        {
        $this->db->db_select($db);
        $this->db->where('article_id', $id);
        $result = $this->db->get('related_items');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function insertRelated($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('related_items', $data);
        }

    function getArticleCategories($db, $id)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $id);
        $result = $this->db->get('category_item_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function insertArticleCategory($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('category_item_relation', $data);
        }

    function getArticleTags($db, $id)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $id);
        $result = $this->db->get('items_tags_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function getEntityTags($id, $type)
        {
        $this->db->where('entity_id', $id);
        $this->db->where('type', $type);
        $result = $this->db->get('entities_tags_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function insertTag($data, $db)
        {
        $this->db->insert('items_tags_relation', $data);
        }

    function insertEntityTag($data)
        {
        $this->db->insert('entities_tags_relation', $data);
        }

    function cloneText($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('text', $data);
        return $this->db->insert_id();
        }


    // Save Item Model Functions Start

    function deleteRelatedItemsByType($type, $module_id)
        {
        // $this->db->where('item_id', $item_id);
        $this->db->where('module_id', $module_id);
        $result = $this->db->delete('module_' . $type . '_items');

        }




    function insertRelatedItemsByType($type, $data)
        {
        $this->db->insert('module_' . $type . '_items', $data);
        }

    function getItemModulesByType($type, $itemId, $parent)
        {
        // $this->db->select('*, "text" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_' . $type);
        }

    function getItemModulesByTypeNew($type, $itemId, $parent)
        {
        // $this->db->select('*, "text" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $result = $this->db->get('module_' . $type);
        return ($result->num_rows() > 0) ? $result->result() : array();
        }



    // module images

    function deletePreviousModuleImages($type, $module_id)
        {
        $this->db->where('module_id', $module_id);
        $this->db->where('type', $type);
        $this->db->delete('module_image_relation');

        if ($this->db->affected_rows() > 0) {
            return true; // Deletion was successful
            } else {
            return false; // No rows were affected, deletion might not have been successful
            }
        }
    function getModuleImages($repoModuleType, $repoModuleId)
        {
        $this->db->where('module_id', $repoModuleId);
        $this->db->where('type', $repoModuleType);
        $result = $this->db->get('module_image_relation');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }

    function addModuleImages($data)
        {
        $this->db->insert('module_image_relation', $data);
        }

    //


    function updateModuleByType($type, $id, $data)
        {
        $this->db->where('id', $id);
        $this->db->update('module_' . $type, $data);
        $this->db->trans_complete();
        // was there any update or error?
        if ($this->db->affected_rows() == '1') {
            return TRUE;
            } else {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                return false;
                }
            return true;
            }
        }

    function updateUpdateTimestamp($id) {
        $this->db->where('id', $id);
        $this->db->update('items', array('date_updated' => date('Y-m-d H:i:s')));
    }

    function removeAnything($table_name, $id)
        {
        $this->db->where('id', $id);
        $this->db->delete($table_name);
        $this->db->trans_complete();
        // was there any update or error?
        if ($this->db->affected_rows() == '1') {
            return TRUE;
            } else {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                return false;
                }
            return true;
            }
        }



    function insertModuleByType($type, $data)
        {
        $this->db->insert('module_' . $type, $data);
        return $this->db->insert_id();
        }

    function deleteModulesByType($type, $id)
        {
        $this->db->where('id', $id);
        $this->db->delete('module_' . $type);
        }

    // Save Item Model Functions End



    function deleteModulesText($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_text');
        }

    function deleteModulesTextById($module_id, $db)
        {
        $this->db->db_select($db);
        $this->db->where('id', $module_id);
        $this->db->delete('module_text');
        }

    function insertModuleText($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_text', $data);
        }


    function updateModuleText($id, $data, $db)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        $this->db->update('module_text', $data);
        }

    function getModulesText($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "text" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_text');
        }


    function insertModuleCollapsable($data, $db)
    {
        $this->db->db_select($db);
        $this->db->insert('module_collapsable', $data);
    }


    function updateModuleCollapsable($id, $data, $db)
    {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        $this->db->update('module_collapsable', $data);
    }

    function getModulesCollapsable($itemId, $db, $parent)
    {
        $this->db->db_select($db);
        $this->db->select('*, "text" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_collapsable');
    }


    function deleteModulesMarquee($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_marquee');
        }

    function insertModuleMarquee($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_marquee', $data);
        }

    function getModulesMarquee($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "marquee" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_marquee');
        }


    function deleteModulesEvents($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_events');
        }

    function insertModuleEvents($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_events', $data);
        }

    function getModulesEvents($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "event" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_events');
        }

    function deleteModulesSectionTitle($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_sectiontitle');
        }

    function insertModuleSectionTitle($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_sectiontitle', $data);
        }

    function getModulesSectionTitle($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "sectiontitle" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_sectiontitle');
        }

    function deleteModulesHr($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_hr');
        }

    function insertModuleHr($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_hr', $data);
        }

    function getModulesHr($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "hr" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_hr');
        }




    function deleteModulesNews($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_news');
        }

    function insertModuleNews($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_news', $data);
        }

    function getModulesNews($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "news" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_news');
        }




    // function deleteModulesBox($itemId, $db, $parent)
    // {
    //     $this->db->db_select($db);
    //     $this->db->where('item_id', $itemId);
    //     $this->db->where('parent', $parent);
    //     $this->db->delete('module_box');
    // }

    function insertModuleBox($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_box', $data);
        }

    // function getModulesBox($itemId, $db, $parent)
    // {
    //     $this->db->db_select($db);
    //     $this->db->select('*, "box" as "mod"');
    //     $this->db->where('item_id', $itemId);
    //     $this->db->where('parent', $parent);
    //     return $this->db->get('module_box');
    // }


    function deleteModulesEnum($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_enum');
        }

    function insertModuleEnum($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_enum', $data);
        }

    function getModulesEnum($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "enum" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_enum');
        }




    function deleteModulesDropdown($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_dropdown');
        }

    function insertModuleDropdown($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_dropdown', $data);
        }

    function getModulesDropdown($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "dropdown" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_dropdown');
        }












    function deleteModulesVideo($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_video');
        }

    function insertModuleVideo($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_video', $data);
        }

    function getModulesVideo($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "video" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_video');
        }


    function deleteModulesDownload($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_download');
        }

    function insertModuleDownload($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_download', $data);
        }

    function getModulesDownload($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "download" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_download');
        }


    function deleteModulesImage($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_image');
        }

    function insertModuleImage($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_image', $data);
        }

    function getModulesImage($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "image" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_image');
        }


    function deleteModulesPDF($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_pdf');
        }

    function insertModulePDF($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_pdf', $data);
        }

    function getModulesPDF($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "pdf" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_pdf');
        }

    function deleteModulesStart($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_start');
        }

    function insertModuleStart($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_start', $data);
        }

    function getModulesStart($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "start" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_start');
        }

    function deleteModulesQuote($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_quote');
        }

    function insertModuleQuote($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_quote', $data);
        }

    function getModulesQuote($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "quote" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_quote');
        }

    function deleteModulesHTML($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_html');
        }

    function insertModuleHTML($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_html', $data);
        }

    function getModulesHtml($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "html" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_html');
        }








    function deleteModulesTicket($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_ticket');
        }

    function insertModuleTicket($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_ticket', $data);
        }

    function getModulesTicket($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "ticket" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_ticket');
        }














    function deleteModulesHeadline($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_headline');
        }

    function insertModuleHeadline($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_headline', $data);
        }

    function getModulesHeadline($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "headline" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_headline');
        }

    function deleteModulesContact($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_contact');
        }

    function insertModuleContact($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_contact', $data);
        }



    function deleteModulesNewsletter($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_newsletter');
        }

    function insertModuleNewsletter($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_newsletter', $data);
        }

    function getModulesNewsletter($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "newsletter" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_newsletter');
        }





    function deleteModulesRelated($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_related');
        }

    function deleteModulesRelatedItems($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_related_items');
        }

    function insertModuleRelated($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_related', $data);
        return $this->db->insert_id();
        }

    function insertModuleRelatedItem($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_related_items', $data);
        return $this->db->insert_id();
        }

    function getModulesRelated($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "related" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_related');
        }

    function getModulesRelatedItems($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('module_id', $itemId);
        return $this->db->get('module_related_items');
        }




    function deleteModulesShop($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->delete('module_shop');
        }

    function insertModuleShop($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_shop', $data);
        }

    function getModulesShop($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->select('*, "shop" as "mod"');
        $this->db->where('item_id', $itemId);
        return $this->db->get('module_shop');
        }

    function deleteModulesGallery($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_gallery');
        }

    function deleteModulesGalleryItems($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_gallery_items');
        }

    function insertModuleGallery($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_gallery', $data);
        return $this->db->insert_id();
        }

    function insertModuleGalleryItem($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_gallery_items', $data);
        return $this->db->insert_id();
        }



    function insertModuleGalleryRelated($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_gallery_items', $data);
        return $this->db->insert_id();
        }

    function getModulesGallery($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "gallery" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_gallery');
        }

    function getModulesImages($itemId, $type, $db)
        {
        $this->db->db_select($db);
        $this->db->where('module_id', $itemId);
        return $this->db->get('module_' . $type . '_items');
        }

    function getModulesGalleryImages($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('module_id', $itemId);
        return $this->db->get('module_gallery_items');
        }
    function getModulesGalleryRelated($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('module_id', $itemId);
        return $this->db->get('module_gallery_items');
        }

    function getModulesRelatedRelated($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('module_id', $itemId);
        return $this->db->get('module_related_items');
        }

    // universal function





    function getGalleryItems($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->order_by('id', 'asc');
        $this->db->where('item_id', $itemId);
        return $this->db->get('galleryitem');
        }

    function getGalleries()
        {
        $this->db->order_by('name', 'asc');
        return $this->db->get('galleries');
        }


    function getPendingByID($id, $db, $table)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        return $this->db->get($table);
        }

    function getModulesArtworks($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->select('*, "artwork" as "mod"');
        $this->db->where('item_id', $itemId);

        return $this->db->get('module_artwork');
        }

    function getModulesArtworkItems($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('module_id', $itemId);

        $this->db->order_by('ordering', 'asc');
        return $this->db->get('module_artwork_items');
        }



    function deleteModulesArtwork($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);

        $this->db->delete('module_artwork');
        }

    function deleteModulesArtworkItems($itemId, $db)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);

        $this->db->delete('module_artwork_items');
        }

    function insertModuleArtwork($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_artwork', $data);
        return $this->db->insert_id();
        }

    function insertModuleArtworkItem($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_artwork_items', $data);
        return $this->db->insert_id();
        }


    function findArticleByTypeAndIdAndLang($type, $entity_id, $lang)
        {
        $this->db->where('entity_id', $entity_id);
        $this->db->where('type', $type);
        $this->db->where('lang', $lang);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }
    function findArticleByTypeAndId($type, $entity_id)
        {
        $this->db->where('entity_id', $entity_id);
        $this->db->where('type', $type);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }

    function getArticlesByEntityId($id, $type)
        {
        $this->db->where('entity_id', $id);
        $this->db->where('type', $type);
        $result = $this->db->get('items');
        return ($result->num_rows() > 0) ? $result->result() : array();
        }


    function deleteModulesColumnStart($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_column_start');
        }

    function insertModuleColumnStart($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_column_start', $data);
        }

    function insertModulecolumn_start($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_column_start', $data);
        }

    function getModulesColumnStart($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "column_start" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_column_start');
        }

    // test
    function getModulescolumn_start($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "column_start" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_column_start');
        }

    function deleteModulesColumnEnd($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        $this->db->delete('module_column_end');
        }

    function insertModuleColumnEnd($data, $db)
        {
        $this->db->db_select($db);
        $this->db->insert('module_column_end', $data);
        }

    function getModulesColumnEnd($itemId, $db, $parent)
        {
        $this->db->db_select($db);
        $this->db->select('*, "column_end" as "mod"');
        $this->db->where('item_id', $itemId);
        $this->db->where('parent', $parent);
        return $this->db->get('module_column_end');
        }



    /*****************************************************************************************************************************************
     * MOSAIC MODULES
     *******************************************************************************************************************************************/
    function getMosaicText($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_text.*, "text" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 1);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_text');
        }

    function getMosaicImage($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_image.*, "image" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 1);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_image');
        }

    function getMosaicTextOpen($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_text.*, "text" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 2);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_text');
        }

    function getMosaicImageOpen($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_image.*, "image" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 2);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_image');
        }

    function getMosaicTextCategory($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_text_category.*, "text" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 1);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_text_category');
        }

    function getMosaicImageCategory($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_image_category.*, "image" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 1);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_image_category');
        }


    function getMosaicTextCategoryOpen($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_text_category.*, "text" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 2);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_text_category');
        }

    function getMosaicImageCategoryOpen($db, $contentId, $lang)
        {
        $this->db->db_select($db);
        $this->db->select('mosaic_image_category.*, "image" as "mosaic_type"');
        $this->db->where('item_id', $contentId);
        $this->db->where('type', 2);
        $this->db->where('lang', $lang);
        return $this->db->get('mosaic_image_category');
        }

    function deleteMosaicModule($db, $itemId, $ids, $type, $table, $lang)
        {

        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('type', $type);
        $this->db->where('lang', $lang);
        $this->db->where_not_in('id', $ids);
        $this->db->delete($table);
        }

    function deleteMosaicModuleSingle($db, $itemId, $type, $table, $lang)
        {
        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('type', $type);
        $this->db->where('lang', $lang);
        $this->db->delete($table);
        }

    function deleteMosaicModuleClone($db, $itemId, $type, $table, $lang)
        {

        $this->db->db_select($db);
        $this->db->where('item_id', $itemId);
        $this->db->where('type', $type);
        $this->db->where('lang', $lang);
        $this->db->delete($table);
        }

    function insertMosaicModule($db, $data, $table)
        {
        $this->db->db_select($db);
        $this->db->insert($table, $data);
        return $this->db->insert_id();
        }

    function updateMosaicModule($db, $data, $id, $table, $lang)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        $this->db->where('lang', $lang);
        $this->db->update($table, $data);
        }

    function updateData($db, $data, $id, $table)
        {
        $this->db->db_select($db);
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        }

    function cloneMosaicModule($db, $table, $data)
        {
        $this->db->db_select($db);
        $this->db->insert_batch($table, $data);
        }

    /***** Repository *****/

    function getRepoItem($itemId)
        {
        $this->db->where('id', $itemId);
        $result = $this->db->get('image_repository');
        return ($result->num_rows() > 0) ? $result->row() : false;
        }
    }