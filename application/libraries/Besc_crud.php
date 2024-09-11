<?php defined('BASEPATH') or exit('No direct script access allowed');



define('BC_ADD', 0);
define('BC_EDIT', 1);

class Besc_crud extends MY_Controller
{
    protected $ci = null;

    protected $db_name = "";

    public $languageArray = array();
    protected $db_table = "";

    protected $per_page;
    protected $host = "";
    protected $folder = "";
    protected $full_url = "";
    protected $article_type = null;
    protected $noarticle_type = null;
    protected $show_entity = false;
    protected $show_mods = false;
    protected $back_to = NULL;
    protected $extra_data_title = "";
    protected $extra_data_content = "";
    protected $db_primary_key = "";
    protected $db_columns = array();
    protected $db_where = "";
    protected $db_order_by_field = '';
    protected $db_order_by_direction = '';

    protected $list_columns = array();
    protected $filter_columns = array();
    protected $filters = array(
        'select' => array(),
        'text' => array(),
        'm_n_relation' => array(),
        'date' => array(),
    );
    protected $ordering = array();

    protected $sortableTypes = array('text', 'select', 'combobox', 'datetime');

    protected $states = array('list', 'add', 'insert', 'edit', 'update', 'delete', 'refresh_list', 'imageupload', 'fileupload', 'validation', 'filter', 'ordering', 'save_ordering', 'imagecrop');
    protected $state_info = array();
    protected $base_url = "";

    protected $main_title = "";
    protected $table_name = "";
    protected $title = "";
    protected $hashname = "";

    protected $custom_actions = array();
    protected $custom_buttons = array();

    protected $allow_add = true;
    protected $allow_delete = true;
    protected $allow_edit = true;


    protected $paging_offset = 0;

    protected $custom_upload = null;



    function __construct()
    {

        $this->ci = &get_instance();
        $this->ci->load->database();
        $this->ci->load->model('Besc_crud_model', 'bc_model');
        $this->ci->load->model('entities/Content_model', 'cm');
        $parsed_url = parse_url(site_url());
        $this->host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
    }

    public function back_to($name = null)
    {
        $this->back_to = $name != null ? $name : $this->back_to;
        return $this->back_to;
    }

    public function article_type($article_type = null)
    {
        $this->article_type = $article_type !== null ? $article_type : null;
        return $this->article_type;
    }

    public function noarticle_type($noarticle_type = null)
    {
        $this->noarticle_type = $noarticle_type !== null ? $noarticle_type : null;
        return $this->noarticle_type;
    }

    public function show_entity($show_entity = false)
    {
        $this->show_entity = $show_entity != false ? true : false;
        return $this->show_entity;
    }


    public function folder($name = null)
    {
        $this->folder = $name != null ? $name : $this->folder;
        return $this->folder;
    }

    public function extra_data_title($name = null)
    {
        $this->extra_data_title = $name != null ? $name : $this->extra_data_title;
        return $this->extra_data_title;
    }

    public function extra_data_content($name = null)
    {
        $this->extra_data_content = $name != null ? $name : $this->extra_data_content;
        return $this->extra_data_content;
    }

    public function full_url($name = null)
    {
        $this->full_url = $name != null ? $name : $this->full_url;
        return $this->full_url;
    }

    public function show_mods($toggle)
    {
        $this->show_mods = $toggle != null ? $toggle : false;
        return $this->show_mods;
    }

    public function database($name = null)
    {
        $this->db_name = $name != null ? $name : $this->db_name;
        return $this->db_name;
    }

    public function table($table = null)
    {
        $this->db_table = $table != null ? $table : $this->db_table;
        return $this->db_table;
    }

    public function primary_key($pk = null)
    {
        $this->db_primary_key = $pk != null ? $pk : $this->db_primary_key;
        return $this->db_primary_key;
    }



    public function columns($columns = array())
    {
        $this->db_columns = $columns != array() ? $columns : $this->db_columns;
        return $this->db_columns;
    }

    public function list_columns($list_columns = array())
    {
        $this->list_columns = $list_columns != array() ? $list_columns : $this->list_columns;
        return $this->list_columns;
    }

    public function main_title($title = null)
    {
        $this->main_title = $title != array() ? $title : $this->main_title;
        return $this->main_title;
    }

    public function table_name($name = null)
    {
        $this->table_name = $name != array() ? $name : $this->table_name;
        return $this->table_name;
    }

    public function title($title = null)
    {
        $this->title = $title != array() ? $title : $this->title;
        return $this->title;
    }

    public function base_url($url = null)
    {
        $this->base_url = $url != null ? $url : $this->base_url;
        return $this->base_url;
    }

    public function custom_actions($custom_actions = null)
    {
        $this->custom_actions = $custom_actions != null ? $custom_actions : $this->custom_actions;
        return $this->custom_actions;
    }

    public function custom_buttons($custom_buttons = null)
    {
        $this->custom_buttons = $custom_buttons != null ? $custom_buttons : $this->custom_buttons;
        return $this->custom_buttons;
    }

    public function where($where_string = "")
    {
        $this->db_where = $where_string != "" ? $where_string : $this->db_where;
        return $this->db_where;
    }

    public function order_by_field($order_by_string = "")
    {
        $this->db_order_by_field = $order_by_string != "" ? $order_by_string : $this->db_order_by_field;
        return $this->db_order_by_field;
    }

    public function order_by_direction($order_by_string = "")
    {
        $this->db_order_by_direction = $order_by_string != "" ? $order_by_string : $this->db_order_by_direction;
        return $this->db_order_by_direction;
    }

    public function ordering($ordering = array())
    {
        $this->ordering = $ordering != "" ? $ordering : $this->ordering;
        return $this->ordering;
    }

    public function unset_add()
    {
        $this->allow_add = false;
        return $this->allow_add;
    }

    public function unset_edit()
    {
        $this->allow_edit = false;
        return $this->allow_edit;
    }

    public function unset_delete()
    {
        $this->allow_delete = false;
        return $this->allow_delete;
    }

    public function custom_upload($custom_upload = null)
    {
        $this->custom_upload = $custom_upload != null ? $custom_upload : $this->custom_upload;
        return $this->custom_upload;
    }

    public function filter_columns($filter_columns = array())
    {
        $this->filter_columns = $filter_columns != array() ? $filter_columns : $this->filter_columns;
        return $this->filter_columns;
    }


    public function get_state_info_from_url()
    {
        $segment_position = count($this->ci->uri->segments) + 1;
        $operation = 'list';

        $segements = $this->ci->uri->segments;
        foreach ($segements as $num => $value) {
            if ($value != 'unknown' && in_array($value, $this->states)) {
                $segment_position = (int) $num;
                $operation = $value; //I don't have a "break" here because I want to ensure that is the LAST segment with name that is in the array.
            }
        }

        $function_name = $this->ci->router->method;

        if ($function_name == 'index' && !in_array('index', $this->ci->uri->segments))
            $segment_position++;

        $first_parameter = isset($segements[$segment_position + 1]) ? $segements[$segment_position + 1] : null;
        $second_parameter = isset($segements[$segment_position + 2]) ? $segements[$segment_position + 2] : null;

        return (object) array('segment_position' => $segment_position, 'operation' => $operation, 'first_parameter' => $first_parameter, 'second_parameter' => $second_parameter);
    }

    protected function get_urls()
    {
        switch ($this->state_info->operation) {
            case 'list':
            case 'refresh_list':
                return array(
                    'bc_delete_url' => $this->base_url . 'delete/',
                    'bc_list_url' => substr($this->base_url, 0, -1),
                    'bc_refresh_url' => $this->base_url . 'refresh_list/',
                    'bc_edit_url' => $this->base_url . 'edit/',
                );
                break;
            case 'add':

                return array(
                    'bc_insert_url' => $this->base_url . 'insert',
                    'bc_list_url' => substr($this->base_url, 0, -1),
                    'bc_upload_url' => $this->base_url . 'imageupload',
                    'bc_file_upload_url' => $this->base_url . 'fileupload',
                    'bc_validation_url' => $this->base_url . 'validation/',
                    'bc_crop_url' => $this->base_url . 'imagecrop',
                );
            case 'edit':
                return array(
                    'bc_edit_url' => $this->base_url . 'update/',
                    'bc_list_url' => substr($this->base_url, 0, -1),
                    'bc_upload_url' => $this->base_url . 'imageupload',
                    'bc_file_upload_url' => $this->base_url . 'fileupload',
                    'bc_validation_url' => $this->base_url . 'validation/',
                    'bc_crop_url' => $this->base_url . 'imagecrop',
                );
                break;
            case 'ordering':
                return array(
                    'bc_list_url' => substr($this->base_url, 0, -1),
                    'bc_ordering_url' => $this->base_url . 'save_ordering/',
                );
                break;
                break;
            default:
                return array();
        }
    }

    protected function die_with_error($message = 'ERROR!!!')
    {
        echo json_encode(
            array(
                'success' => false,
                'message' => $message
            )
        );
        die();
    }

    protected function get_base_url()
    {
        $i = 1;
        $url = site_url();
        while ($i < $this->state_info->segment_position) {
            $url .= $this->ci->uri->segment($i) . '/';
            $i++;
        }
        return $url;
    }


    protected function prepare()
    {
        $this->hashname = hash_hmac("md5", $this->db_table . $this->title, $this->ci->session->session_id);
        $this->state_info = $this->get_state_info_from_url();
        $this->base_url = $this->get_base_url();
    }

    public function execute($per_page = ROWS_PER_PAGE_OF_TABLE)
        {

        $this->prepare();

        $this->per_page = $per_page;

        if ($this->ci->session->userdata('current_list') != $this->ci->uri->segment(3)) {
            $this->ci->session->set_userdata('current_page', NULL);
            }

        if ($this->ci->input->get('page') !== NULL) {

            $this->ci->session->set_userdata('current_page', $this->ci->input->get('page'));
            $this->ci->session->set_userdata('current_list', $this->ci->uri->segment(3));
            }

        $current_page = $this->ci->input->get('page');
        if ($this->ci->session->userdata('current_page') !== NULL) {
            $current_page = $this->per_page > ROWS_PER_PAGE_OF_TABLE ? 0 : $this->ci->session->userdata('current_page');
        }


        $this->paging_offset = $current_page * $this->per_page;




        switch ($this->state_info->operation) {
            case 'list':
                $this->getSortingFromSession();
                $this->getFiltersFromSession();
                return $this->render_list();
                break;

            case 'delete':
                if ($this->allow_delete)
                    $this->delete();
                break;

            case 'refresh_list':


                $this->getFiltersFromAjax($this->ci->input->get('filter'));
                $this->getSortingFromAjax($this->ci->input->get('sorting'));
                $this->render_list(true);
                break;

            case 'add':
                if ($this->allow_add)
                    return $this->render_edit();
                break;

            case 'edit':
                if ($this->allow_edit)

                    return $this->render_edit();
                break;

            case 'insert':
                if ($this->allow_add)
                    $this->insert();
                break;

            case 'update':
                if ($this->allow_edit)
                    $this->update();
                break;

            case 'imageupload':
                $this->imageupload();
                break;

            case 'fileupload':
                $this->fileupload();
                break;

            case 'validation':
                $this->validate();
                break;

            case 'ordering':
                if ($this->ordering != array())
                    return $this->render_ordering();
                break;

            case 'save_ordering':
                if ($this->ordering != array())
                    $this->save_ordering();
                break;

            case 'imagecrop':
                $this->imagecrop();
                break;
            }
        die();
        }


    protected function validate()
    {
        $form_validation = new Besc_Form_validation();

        $validate_array = array();
        $content = json_decode(file_get_contents('php://input'));
        $validate_columns = array();
        foreach ($content as $column) {
            if (isset($this->db_columns[$column->name]['validation']) && $this->db_columns[$column->name]['validation'] != '') {
                $validate_columns[] = $column->name;
                switch ($column->type) {
                    case 'text':
                    case 'hidden':
                    case 'hidden_list':
                    case 'file':
                    case 'image':
                    case 'multiline':
                    case 'select':
                    case 'combobox':
                    case 'colorpicker':
                        $validate_array[$column->name] = $column->value;
                        break;
                    case 'm_n_relation':
                        break;
                    case 'url':
                        $validate_array[$column->name] = prep_url($column->value);
                        break;
                    case 'date':
                        $validate_array[$column->name] = date('Y-m-d', strtotime($column->value));
                        break;
                    case 'datetime':
                        $validate_array[$column->name] = date('Y-m-d H:i', strtotime($column->value));
                        break;
                    case 'colorpicker':
                        //$this->db_columns[$column->name]['validation'] .= '|/#([a-fA-F0-9]{3}){1,2}\b/';
                        $validate_array[$column->name] = $column->value;
                        break;
                }

                $rules = $form_validation->fix_is_unique_rule($this->db_primary_key, $this->state_info->first_parameter, $this->db_columns[$column->name]['validation']);

                $form_validation->set_rules($column->name, isset($this->db_columns[$column->name]['display_as']) ? $this->db_columns[$column->name]['display_as'] : $this->db_columns[$column->name]['db_name'], $rules);
            }
        }
        if (count($validate_array) > 0) {
            $form_validation->set_data($validate_array);
            $form_validation->set_message('required', '{field} is mandatory.');
            $form_validation->set_error_delimiters('', '');

            if ($form_validation->run() == FALSE) {
                $error_columns = array();
                foreach ($validate_columns as $col) {
                    if ($form_validation->error($col) != '')
                        $error_columns[] = array(
                            'name' => $col,
                            'error' => $form_validation->error($col),
                        );
                }

                echo json_encode(
                    array(
                        'success' => false,
                        'error_columns' => $error_columns,
                    )
                );
            } else {
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'success validation',
                    )
                );
            }
        } else
            echo json_encode(
                array(
                    'success' => true,
                    'message' => 'success validation',
                    'dummy' => 'no_validation',
                )
            );
    }

    protected function delete()
    {

        if (strpos($this->ci->uri->uri_string, 'Repository') != false) {
            $this->ci->bc_model->deleteRepositoryTagRelation($this->db_primary_key);
        }

        if ($this->ci->bc_model->delete($this->db_name, $this->db_table, $this->db_primary_key, $this->state_info->first_parameter, $this->article_type) > 0) {
            $result['success'] = true;
            $result['message'] = "Dataset deleted.";
        } else {
            $result['success'] = false;
            $result['message'] = "Error while deleting dataset";
        }

        echo json_encode($result);
    }

    protected function insert()
    {
        $content = json_decode(file_get_contents('php://input'));

        $col = array();
        $col_after = array();
        foreach ($content as $column) {
            switch ($column->type) {
                case 'text':
                case 'hidden':
                case 'image':
                case 'repo_image':
                case 'file':
                case 'multiline':
                case 'select':
                case 'ckeditor':
                case 'combobox':
                case 'colorpicker':
                    $col[$column->name] = $column->value;
                    break;
                case 'm_n_relation':
                    $col_after[] = $column;
                    break;
                case 'repo_text':
                    $col_after[] = $column;
                    break;
                case 'url':
                    $col[$column->name] = prep_url($column->value);
                    break;
                case 'date':
                    $col[$column->name] = date('Y-m-d', strtotime($column->value));
                    break;
                case 'datetime':
                    $col[$column->name] = date('Y-m-d H:i', strtotime($column->value));
                    break;
            }
        }
        $new_id = $this->ci->bc_model->insert($this->db_name, $this->db_table, $col);
        if ($new_id > 0) {
            $after_success = true;

            foreach ($col_after as $col) {
                $test = $col->type;
                switch ($col->type) {
                    case 'm_n_relation':
                        $after_success = $this->saveMNRelation($col, true, $new_id);
                        break;
                    case 'repo_text':
                        $after_success = $this->save_repo_text_relation($col, $new_id);
                        break;
                }
            }

            if ($after_success) {
                $result['new_id'] = $new_id;
                $result['success'] = true;
                $result['message'] = $this->title . ' successfully added.';
            } else {
                $result['success'] = false;
                $result['message'] = 'Error while adding ' . $this->title . '.';
            }
            //   $result['test'] = $test;
            $result['after_success'] = $after_success;
        } else {
            $result['success'] = false;
            $result['message'] = 'Error while adding ' . $this->title . '.';
        }

        echo json_encode($result);
    }

    protected function update()
    {
        $content = json_decode(file_get_contents('php://input'));
        $col = array();
        $col_after = array();

        // var_dump($content);
        // exit;


        foreach ($content as $column) {
            switch ($column->type) {
                case 'text':
                case 'hidden':
                case 'repo_image':
                case 'image':
                case 'file':
                case 'multiline':
                case 'select':
                case 'ckeditor':
                case 'combobox':
                case 'colorpicker':

                    $col[$column->name] = $column->value;
                    break;
                case 'm_n_relation':
                    $col_after[] = $column;
                    break;
                case 'url':
                    $col[$column->name] = prep_url($column->value);
                    break;
                case 'date':
                    $col[$column->name] = $column->value == 'null' ? NULL : date('Y-m-d H:i:s', strtotime($column->value));
                    break;
                case 'datetime':
                    $col[$column->name] = $column->value == 'null' ? NULL : date('Y-m-d H:i', strtotime($column->value));
                    break;
            }
        }

        if ($this->ci->bc_model->update($this->db_name, $this->db_table, $this->db_primary_key, $this->state_info->first_parameter, $col)) {
            $after_success = true;
            foreach ($col_after as $col) {
                switch ($col->type) {
                    case 'm_n_relation':
                        $after_success = $this->saveMNRelation($col, true);
                        break;
                }
            }

            if ($after_success) {
                $result['success'] = true;
                $result['message'] = $this->title . ' successfully updated.';
            } else {
                $result['success'] = false;
                $result['message'] = 'Error while updating ' . $this->title . '.';
            }
        } else {
            $result['success'] = false;
            $result['message'] = 'Error while updating ' . $this->title . '.';
        }

        echo json_encode($result);
    }



    protected function imageupload()
    {
        $filename = $this->ci->input->post('filename');
        $col_name = $this->ci->input->post('element');


        if (isset($this->custom_upload[$col_name])) {
            $serverFile = call_user_func($this->custom_upload[$col_name], $this->db_columns[$col_name]['uploadpath']); // upload path specified in the db_columns array
        } else {

            $upload_path = $this->db_columns[$col_name]['uploadpath']; // upload path specified in the db_columns array

            //   correcting ending of upload path
            if (substr($upload_path, -1) != '/')
                $upload_path .= '/';

            // random name of the file
            $rnd = $this->rand_string(12);
            // getting extension of the file
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            // server file name
            $serverFile = time() . "_" . $rnd . "." . $ext;
            $folderPath = getcwd();

            // loading library
            $this->ci->load->library('image_moo');

            // final path of the file
            $finalPath = getcwd() . "/" . $upload_path . $serverFile;

            // moving file to the final path
            $error = move_uploaded_file($_FILES['data']['tmp_name'], $folderPath . "/$upload_path$serverFile");

            /*****  same for svg and other images *****/
            $fold = getcwd();

            // normal image path
            $pathToImages = $fold . "/items/uploads/images/";

            // thumbnail path
            $pathToThumbs = $fold . "/items/uploads/images/thumbs/";
            $pathTofrontendImages = $fold . "/items/uploads/images/frontend_images/";

            /*****  same for svg and other images *****/



            // FIRST SAVING
            // resizing doesn't work with svg files
            if ($ext != 'svg'):
                // RESIZE ?
                // by default false
                $allow_resize = isset($this->db_columns[$col_name]['allow_resize']) ? $this->db_columns[$col_name]['allow_resize'] : false; // check if the image should be resized

                $resizeWidth = RESIZE_WIDTH; // default width of the resized image

                // if allow_resize is true, then resize the image on the default destination
                if ($allow_resize == true) {

                    // width of the thumbnail

                    // switch for the extension
                    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg') {


                        // load image and get image size
                        $img = imagecreatefromjpeg($finalPath);
                        $width = imagesx($img);
                        $height = imagesy($img);

                        // calculate thumbnail size
                        if ($width >= $height) {
                            $new_width = $resizeWidth;
                            $new_height = floor($height * ($resizeWidth / $width));
                        } else {
                            $new_height = $resizeWidth;
                            $new_width = floor($width * ($resizeWidth / $height));
                        }



                        // create a new temporary image
                        $tmp_img = imagecreatetruecolor($new_width, $new_height);

                        // copy and resize old image into new image
                        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                        // save thumbnail into a file
                        imagejpeg($tmp_img, $finalPath, 100);
                    }

                    if (strtolower($ext) == 'png') {


                        // load image and get image size
                        $img = imagecreatefrompng($finalPath);
                        $width = imagesx($img);
                        $height = imagesy($img);

                        // calculate thumbnail size
                        if ($width >= $height) {
                            $new_width = $resizeWidth;
                            $new_height = floor($height * ($resizeWidth / $width));
                        } else {
                            $new_height = $resizeWidth;
                            $new_width = floor($width * ($resizeWidth / $height));
                        }


                        $thumb = imagecreatetruecolor($new_width, $new_height);
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);

                        $source = imagecreatefrompng($finalPath);
                        imagealphablending($source, true);

                        imagecopyresampled($thumb, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                        imagepng($thumb, $finalPath, 0);
                    }
                }


                // cropping and thumbnailing doesn't work with svg files


                // CROP ?
                $crop = isset($this->db_columns[$col_name]['crop']) ? $this->db_columns[$col_name]['crop'] : null;

                // THUMBNAIL ?
                $thumbnail = isset($this->db_columns[$col_name]['thumbnail']) ? $this->db_columns[$col_name]['thumbnail'] : false;


                // setting a width of a thumbnail
                $thumbWidth = THUMB_WIDTH;
                $frontendImageWidth = FRONTEND_WIDTH;



                    // open the directory
                    $dir = opendir($pathToImages);


                    // parse path for the extension
                    $info = pathinfo($pathToImages . $serverFile);
                    // continue only if this is a JPEG image


                    try {

                        // THUMBNAIL
                        $image = new Imagick();

                        $image->readImage($finalPath);


                        // load image and get image size
                        $d = $image->getImageGeometry();

                        $w = $d['width'];
                        $h = $d['height'];

                        if ($w < $thumbWidth) {
                            $thumbWidth = $w;
                            $frontendImageWidth = $w;
                        }

                        // calculate thumbnail size
                        $new_width = $thumbWidth;

                        $new_height = floor($h * ($thumbWidth / $w));



                        // set compression
                        $image->setImageCompressionQuality(85);


                        // create a new thumb image
                        $image->resizeImage($new_width, $new_height, Imagick::FILTER_LANCZOS, 1, true);

                        // clear and destroy
                        $image->writeImage($pathToThumbs . $serverFile);
                        $image->clear();
                        $image->destroy();

                        // FRONTEND IMAGE
                        $frontend_image = new Imagick();

                        $frontend_image->readImage($finalPath);


                        // calculate thumbnail size
                        $new_width = $frontendImageWidth;
                        $new_height = floor($h * ($frontendImageWidth / $w));

                        $frontend_image->setImageCompressionQuality(85);

                        $frontend_image->resizeImage($new_width, $new_height, Imagick::FILTER_LANCZOS, 1, true);

                        $frontend_image->writeImage($pathTofrontendImages . $serverFile);
                        $frontend_image->clear();
                        $frontend_image->destroy();

                    } catch (ImagickException $e) {
                        // var_dump($e);
                    }


                    closedir($dir);





                $data = getimagesize($folderPath . "/$upload_path$serverFile");
                $size = $data[0] . "x" . $data[1];
            else: // for svg files

                $crop = null;

                copy($pathTofile, $pathToThumbs);
                copy($pathTofile, $pathTofrontendImages);


                $size = "x";
            endif;




            echo json_encode(
                array(
                    'success' => true,
                    'filename' => $serverFile,
                    'fullpath' => site_url() . "/$upload_path" . 'thumbs/' . "$serverFile",
                    'size' => $size,
                    'crop' => $crop,
                )
            );
        }
    }



    protected function fileupload()
        {
        $filename = $this->ci->input->post('filename');
        $col_name = $this->ci->input->post('element');

        if (isset($this->custom_upload[$col_name])) {
            $serverFile = call_user_func($this->custom_upload[$col_name], $this->db_columns[$col_name]['uploadpath']);
            } else {
            $upload_path = $this->db_columns[$col_name]['uploadpath'];
            if (substr($upload_path, -1) != '/')
                $upload_path .= '/';

            $serverFile = $filename;
            $fullPath = getcwd() . "/$upload_path/$serverFile";


            // Check if file exists, if yes, add a random number to the filename
            if (file_exists($fullPath)) {

                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $filenameWithoutExt = basename($filename, '.' . $ext);
                $serverFile = $filenameWithoutExt . rand(0, 1000) . '.' . $ext;
                $fullPath = getcwd() . "/$upload_path/$serverFile";
                }

            $error = move_uploaded_file($_FILES['data']['tmp_name'], $fullPath);
            }

        $crop = isset($this->db_columns[$col_name]['crop']) ? $this->db_columns[$col_name]['crop'] : null;

        echo json_encode(
            array(
                'success' => true,
                'filename' => $serverFile,
                'crop' => $crop,
            )
        );
        }

    protected function imagecrop()
    {
        $filename = $this->ci->input->post('filename');
        $col = $this->ci->input->post('col');
        $ratio = $this->ci->input->post('ratio');

        $x1 = intval($this->ci->input->post('x1') * $ratio);
        $y1 = intval($this->ci->input->post('y1') * $ratio);
        $x2 = intval($this->ci->input->post('x2') * $ratio);
        $y2 = intval($this->ci->input->post('y2') * $ratio);


        $uploadpath = $this->db_columns[$col]['uploadpath'];
        $cropdata = $this->db_columns[$col]['crop'];

        if (substr($uploadpath, -1) != '/')
            $uploadpath .= '/';

        $width = $destWidth = $x2 - $x1;
        $height = $destHeight = $y2 - $y1;

        if ($destWidth > $cropdata['maxWidth'])
            $destWidth = $cropdata['maxWidth'];

        if ($destHeight > $cropdata['maxHeight'])
            $destHeight = $cropdata['maxHeight'];

        $new_img = imagecreatetruecolor($destWidth, $destHeight);
        $col = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
        imagefill($new_img, 0, 0, $col);

        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        switch ($ext) {
            case 'png':
                $img = imagecreatefrompng(getcwd() . '/' . $uploadpath . $filename);
                break;
            case 'jpg':
            case 'jpeg':
                $img = imagecreatefromjpeg(getcwd() . '/' . $uploadpath . $filename);
                break;
        }

        imagecopyresampled($new_img, $img, 0, 0, $x1, $y1, $destWidth, $destHeight, $width, $height);
        imagepng($new_img, getcwd() . '/' . "$uploadpath/$filename");

        echo json_encode(array('success' => true));
    }

    function rand_string($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        $str = base64_encode(openssl_random_pseudo_bytes($length, $strong));
        $str = substr($str, 0, $length);
        $str = preg_replace("/[^a-zA-Z0-9\s]/", "", $str);
        return $str;
    }


    public function getFullUrl()
    {
        return (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') .
            (isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
                    $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
            substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }


    protected function saveMNRelation($column, $delete = false, $pk = null)
    {
        $m = null;
        foreach ($this->db_columns as $c) {
            if (isset($c['relation_id']) && $c['relation_id'] == $column->relation_id) {
                $m = $c;
            }
        }
        if ($m != null) {


            $batch = array();
            $selected_ids = array();
            foreach ($column->selected as $sel) {

                if (!in_array($sel, $selected_ids)) {
                    $selected_ids[] = $sel;
                }

                if (isset($m['add_name']) && $m['add_name'] === true) {

                    if (isset($m['from_mn']) && $m['from_mn'] === true) {
                        $display_name = $this->ci->bc_model->get_m_n_value($this->db_name, $m['table_n'], $m['table_n_pk'], $sel)->row()->{$m['add_name_col']};
                    } else {
                        $display_name_m = $this->ci->bc_model->get_m_n_value($this->db_name, $m['table_m'], 'id', $pk == null ? $this->state_info->first_parameter : $pk)->row()->{$m['add_name_col_m']};
                        $display_name_n = $this->ci->bc_model->get_m_n_value($this->db_name, $m['table_n'], $m['table_n_pk'], $sel)->row()->{$m['table_n_value']};

                        $display_name = $display_name_m . " " . $display_name_n;
                    }



                    $batch[] = array($m['table_mn_col_m'] => $pk == null ? $this->state_info->first_parameter : $pk, $m['table_mn_col_n'] => $sel, $m['add_name_col'] => $display_name);




                } else {
                    $special_batch = array($m['table_mn_col_m'] => $pk == null ? $this->state_info->first_parameter : $pk, $m['table_mn_col_n'] => $sel);

                    isset($m['table_mn_col_m_type']) ? $special_batch['type'] = $m['table_mn_col_m_type'] : '';

                    $batch[] = $special_batch;

                }
            }

            if ($delete) {
                // also edit
                $table_mn_col_m_type = isset($m['table_mn_col_m_type']) ? $m['table_mn_col_m_type'] : false;

                $this->ci->bc_model->delete_m_n_relationByID($this->db_name, $selected_ids, $m['table_mn'], $m['table_mn_col_m'], $m['table_mn_col_n'], $pk == null ? $this->state_info->first_parameter : $pk, $table_mn_col_m_type);
            }

            foreach ($batch as $b) {


                if (isset($m['table_mn_col_m_type'])) {
                    $type = isset ($m['table_mn_col_m_type']) ? $m['table_mn_col_m_type'] : false;

                    $checkSaved = $this->ci->bc_model->get_m_n_relation_saved($this->db_name, $m['table_mn'], $m['table_mn_col_m'], $m['table_mn_col_n'], $b[$m['table_mn_col_m']], $b[$m['table_mn_col_n']], 'type', $type);
                } else {
                    $checkSaved = $this->ci->bc_model->get_m_n_relation_saved($this->db_name, $m['table_mn'], $m['table_mn_col_m'], $m['table_mn_col_n'], $b[$m['table_mn_col_m']], $b[$m['table_mn_col_n']], );
                }



                if (!$checkSaved) {

                    $this->ci->bc_model->insert_m_n_relationSingle($this->db_name, $m['table_mn'], $b);
                    }
                }

            return true;
        } else
            return false;
    }

    function save_repo_text_relation($column, $row_id = null)
    {

        foreach ($column->text_phrases as $phrase) {
            $this->ci->cm->insert_repo_text($column->column_name, $column->table_name, $row_id, $phrase->lang, $phrase->text);
        }

        //return json_encode($column['column_name'], $column['table_name'], $row_id, $phrase['lang'], $phrase['text']);
        return true;
    }



    protected function render_list($ajax = false)
    {

        $get = $this->getData();



        foreach ($this->db_columns as $key => $column) {
            $show_in_list = true;
            if ($this->list_columns != array())
                $show_in_list = in_array($key, $this->list_columns);

            if ($column['type'] == 'hidden') {
                // $show_in_list = false;
            }


            if ($show_in_list)
                $data['headers'][] = array(
                    'display_as' => isset($column['display_as']) ? $column['display_as'] : $key,
                    'sortable' => in_array($column['type'], $this->sortableTypes),
                    'id' => $key,
                );
        }



        $rows = array();

        $has_article = 0;
        $has_related_article = 0;


        if ($this->article_type >= 0 && $this->article_type !== null) {

            $has_article = 1;
            // put to 0 if this project doesn't have two languages
            $has_related_article = 1;
        }

        $has_entity = 0;


        foreach ($get['data']->result_array() as $row) {



            $has_this_article = 0;
            $has_this_related = 0;

            // going through data
            $columns = array();
            $columns['pk'] = $row[$this->db_primary_key];
            $columns['table_name'] = strtolower($this->table_name);



            // table pretty_urls showing articles and entities
            if ($this->show_entity == true) {
                $has_entity = 1;



                $article = $this->ci->cm->getArticleById($columns['pk']);

                foreach (ARTICLE_TYPES as $t) {
                    if ($t['type_id'] == $article->type) {
                        $type_name = $t['name'];
                    }
                }


                $entity = $this->ci->cm->getAnyEntityById($article->entity_id, $type_name);


                if ($entity) {
                    $columns['entity_link'] = $this->list_entity($entity, $type_name, $t['type_id']);
                }

            }



            // get teaser images

            $article_noarticle_type = $this->article_type === null ? $this->noarticle_type : $this->article_type;

            $has_article_teaser = $this->article_type === null ? 0 : 1;

            $first_teaser_path = site_url() . 'assets/img/placeholder.png';

            $existing_teasers = $this->getExistingTeasers($columns['pk'], $article_noarticle_type, $has_article_teaser);



            $count_teasers = count($existing_teasers);


            if ($count_teasers > 0) {
                $first_teaser = $existing_teasers[0];
                $first_teaser_path = $first_teaser->fname;
            }

            // for entities that have article - displaying article links

                if (($this->article_type >= 0 && $this->article_type !== null) || ($article_noarticle_type >= 0 && $article_noarticle_type !== null)) {


                    // delete related if website doesn't have it
                $article = $this->ci->cm->findArticleByTypeAndIdAndLang($this->article_type, $columns['pk'], MAIN_LANGUAGE);

                // separate teaser button
                    $teaser_button_id = array_search('teaser_selector', array_column($this->custom_buttons, 'url'));
                    if ($teaser_button_id !== false) {
                        $teaser_button = $this->custom_buttons[$teaser_button_id];
                        $data['teaser_button'] = $teaser_button;
                        unset($this->custom_buttons[$teaser_button_id]); // remove teaser button from custom buttons
                    }

                    if (isset($teaser_button)) {
                        $teaser_button['count_teasers'] = $count_teasers;
                        $image_path = str_contains($first_teaser_path, 'placeholder') ? $first_teaser_path : site_url() . 'items/uploads/images/thumbs/' . $first_teaser_path;
                        $teaser_button['image_path'] = $image_path;
                        $teaser_button['article_noarticle_type'] = $article_noarticle_type;
                        $teaser_button['public'] = str_contains($first_teaser_path, 'placeholder') ? 1 : (isset($first_teaser->public) ? $first_teaser->public : 0);
                        $teaser_button['pk'] = $row[$this->db_primary_key];
                        $columns['teaser_button'] = $this->list_teaser($teaser_button);
                    }
                }

            if ($this->article_type >= 0 && $this->article_type !== null) {


                if ($article) {
                    $has_article = 1;
                    $has_this_article = 1;
                    $columns['article_id'] = $article->id;
                    $columns['original_article'] = $this->list_article(1, $has_this_article, $article);

                    $related_article = $this->ci->cm->getRelatedArticleById($article->id);
                    if ($related_article) {
                        $has_related_article = 1;
                        $has_this_related = 1;
                        $columns['related_article_id'] = $related_article->id;

                        $columns['related_article'] = $this->list_article(0, $has_this_related, $related_article, $this->article_type, $columns['pk']);
                    }  else {
                        $columns['related_article'] = $this->list_article(0, $has_this_related, 0, $this->article_type, $columns['pk'], $article->id);
                    }


                    // saving also article type
                    $data['article_type'] = $this->article_type;




                } else {
                    $columns['original_article'] = $this->list_article(1, 0, 0, $this->article_type, $columns['pk']);
                    $columns['related_article'] = $this->list_article(0, 0, 0, $this->article_type, $columns['pk'], 0);
                }

            }

            foreach ($this->db_columns as $key => $column) {
                $show_in_list = true;
                if ($this->list_columns != array()) {
                    $show_in_list = in_array($key, $this->list_columns);
                }



                if ($show_in_list) {
                    switch ($column['type']) {
                        case 'hidden':
                        case 'text':
                            $columns[$key] = $this->list_text($row, $column);
                            break;
                        case 'repo_text':
                            $columns[$key] = $this->list_repo_text($row, $column);
                            break;
                        case 'image':
                            $columns[$key] = $this->list_image($row, $column);
                            break;
                        case 'repo_image':
                            $columns[$key] = $this->list_repo_image($row, $column);
                            break;
                        case 'file':
                            $columns[$key] = $this->list_file($row, $column);
                            break;
                        case 'm_n_relation':
                            $columns[$key] = $this->list_m_n_relation($row, $column);
                            break;
                        case 'url':
                            $columns[$key] = $this->list_url($row, $column);
                            break;
                        case 'select':
                            $columns[$key] = $this->list_select($row, $column);
                            break;
                        case 'image_gallery':
                            $columns[$key] = $this->list_image_gallery($row, $column);
                            break;
                        case 'multiline':
                        case 'ckeditor':
                            $columns[$key] = $this->list_multiline($row, $column);
                            break;
                        case 'date':
                            $columns[$key] = $this->list_date($row, $column);
                            break;
                        case 'datetime':
                            $columns[$key] = $this->list_datetime($row, $column);
                            break;
                        case 'combobox':
                            $columns[$key] = $this->list_combobox($row, $column);
                            break;
                        case 'colorpicker':
                            $columns[$key] = $this->list_colorpicker($row, $column);
                            break;
                    }
                }
            }
            $rows[] = $columns;
        }


        $data['rows'] = $rows;

        $data['title'] = $this->title;
        $data['host'] = $this->host;
        $data['folder'] = $this->folder;
        $data['full_url'] = $this->full_url;
        $data['back_to'] = $this->back_to;
        $data['main_title'] = $this->main_title;
        $data['table_name'] = $this->table_name;
        $data['table'] = $this->db_table;

        $data['allow_add'] = $this->allow_add;
        $data['allow_edit'] = $this->allow_edit;
        $data['allow_delete'] = $this->allow_delete;
        $data['custom_button'] = $this->custom_buttons;
        $data['custom_action'] = $this->custom_actions;
        $data['bc_urls'] = $this->get_urls();
        $data['paging_and_filtering'] = $this->paging_and_filtering($get);

        $data['paging'] = $this->paging($get);


        $data['filtering'] = $this->filtering($get);
        $data['sorting_col'] = $this->db_order_by_field;
        $data['sorting_direction_class'] = $this->db_order_by_direction == 'asc' ? 'bc_table_sort_asc' : 'bc_table_sort_desc';
        $data['ordering'] = $this->ordering;

        // additional for processing articles and entities
        $data['has_article'] = $has_article;
        $data['has_entity'] = $has_entity;
        $data['has_related_article'] = $has_related_article;

        // additional to edit selected
        $data['general_tags'] = $this->ci->cm->getGeneralTags();

        // var_dump($data['paging']);
        $newPagination = $this->ci->load->view('besc_crud/_pageNav', $data['paging'], true);



        $data['ajax'] = $ajax;
        $data['is_table'] = true;

        if (!$ajax) {

            return $this->ci->load->view('besc_crud/table_view', $data, true);

        } else {

            echo json_encode(
                array(
                    'success' => true,
                    'data' => $this->ci->load->view('besc_crud/table_view', $data, true),
                    'paging_and_filtering' => $data['paging_and_filtering'],
                    'sess_cp' => $this->ci->session->userdata('current_page'),
                    'pagination' => $newPagination,
                )
            );
        }
    }

    protected function getFiltersFromAjax($ajaxfilter)
    {

        // var_dump($ajaxfilter);
        $select = array();
        $text = array();
        $m_n = array();
        $date = array();


        if ($ajaxfilter != null) {
            foreach ($ajaxfilter as $filter) {
                switch ($filter['type']) {
                    case 'select':
                        if ($filter['value'] != 'null' && $filter['value'] != '' && $filter['value'] != 'undefined' && $filter['value'] != 'all' && $filter['value'] != '0') {
                            $select[$filter['name']] = $filter['value'];
                        }
                        break;
                    case 'date':
                        if ($filter['value'] != '') {
                            $filter['name'] = 'DATE (' . $filter['name'] . ') =';
                            $date[$filter['name']] = date('Y-m-d', strtotime($filter['value']));
                        }
                        break;
                    case 'date':
                        if ($filter['value'] != '') {
                            $date[$filter['name']] = date('Y-m-d', strtotime($filter['value']));
                        }
                        break;
                    case 'text':
                        if ($filter['value'] != '') {
                            $text[$filter['name']] = $filter['value'];
                        }
                        break;

                    case 'm_n_relation':
                        if ($filter['value'] != '') {
                            $col = $this->db_columns[$filter['name']];

                            $elements = array();

                            foreach ($this->ci->bc_model->get_m_n_relation_filter_ids($this->db_name, $col['table_mn'], $col['table_mn_col_m'], $col['table_mn_col_n'], $this->db_primary_key, $col['table_n'], $col['table_n_value'], $col['table_n_value2'], $col['table_n_pk'], $filter['value'])->result_array() as $row) {
                                $elements[] = $row[$col['table_mn_col_m']];
                            }

                            $m_n[$filter['name']] = array(
                                'id' => $this->db_primary_key,
                                'values' => $elements == array() ? array(null) : $elements,
                                'val' => $filter['value'],
                            );
                        }
                        break;
                }
            }
        }


        $this->filters = array(
            'select' => $select,
            'text' => $text,
            'date' => $date,
            'm_n_relation' => $m_n,
        );

        // var_dump($this->filters);

        if ($select != array() || $text != array() || $m_n != array() || $date != array())
            $this->ci->session->set_userdata($this->hashname . '_filter', $this->filters);
        else
            $this->ci->session->unset_userdata($this->hashname . '_filter');
    }

    protected function getSortingFromAjax($ajaxSorting)
    {
        if ($ajaxSorting != null) {
            $direction = '';
            if (intval($ajaxSorting['direction']) == 0)
                $direction = 'asc';

            if (intval($ajaxSorting['direction']) == 1)
                $direction = 'desc';

            if ($this->columnExists($ajaxSorting['col_id']) && $direction != '') {
                $this->db_order_by_direction = $direction;
                $this->db_order_by_field = $ajaxSorting['col_id'];

                $this->ci->session->set_userdata($this->hashname . '_sortcol', $this->db_order_by_field);
                $this->ci->session->set_userdata($this->hashname . '_sortdir', $this->db_order_by_direction);
            } else {
                $this->ci->session->unset_userdata($this->hashname . '_sortcol');
                $this->ci->session->unset_userdata($this->hashname . '_sortdir');
            }
        } else {
            $this->ci->session->unset_userdata($this->hashname . '_sortcol');
            $this->ci->session->unset_userdata($this->hashname . '_sortdir');
        }
    }

    protected function getSortingFromSession()
    {
        $sortfield = $this->ci->session->userdata($this->hashname . '_sortcol');
        $sortdir = $this->ci->session->userdata($this->hashname . '_sortdir');

        if (($sortdir == 'asc' || $sortdir == 'desc') && $this->columnExists($sortfield)) {
            $this->db_order_by_direction = $sortdir;
            $this->db_order_by_field = $sortfield;
        }
    }

    protected function getFiltersFromSession()
    {
        $filters = $this->ci->session->userdata($this->hashname . '_filter');
        if ($filters != NULL)
            $this->filters = $filters;
    }

    protected function getData()
    {

        return array(
            'data' => $this->ci->bc_model->get($this->db_name, $this->db_table, $this->db_where, $this->per_page, $this->paging_offset, $this->filters, $this->db_order_by_field, $this->db_order_by_direction),
            'pagination' => $this->per_page,
            'total' => $this->ci->bc_model->get_total($this->db_name, $this->db_table, $this->db_where, $this->filters)->num_rows(),
        );
    }

    protected function columnExists($col)
    {
        $exists = false;
        foreach ($this->db_columns as $key => $column) {
            if ($col == $key)
                $exists = true;
        }

        return $exists;
    }

    protected function paging_and_filtering($get)
    {
        $data['paging'] = $this->paging($get);
        $data['filtering'] = $this->filtering($get);

        return $this->ci->load->view('besc_crud/paging_and_filtering', $data, true);
    }

    protected function filtering($get)
    {
        $html = '';

        foreach ($this->filter_columns as $filter) {

            $data['pretty_name_plural'] = My_Controller::pluralizeName(My_Controller::getPrettyName($filter));

            switch ($this->db_columns[$filter]['type']) {
                case 'select':
                case 'combobox':
                    $data['filter_value'] = isset($this->filters['select'][$filter]) ? $this->filters['select'][$filter] : '';
                    $data['options'] = $this->db_columns[$filter]['options'];
                    $data['db_name'] = $this->db_columns[$filter]['db_name'];
                    $data['display_as'] = $this->db_columns[$filter]['display_as'];
                    $data['type'] = $this->db_columns[$filter]['type'];
                    $html .= $this->ci->load->view('besc_crud/filters/select', $data, true);
                    break;
                case 'm_n_relation':
                    $data['filter_value'] = isset($this->filters['m_n_relation'][$filter]['val']) ? $this->filters['m_n_relation'][$filter]['val'] : '';


                    $data['settings'] = $this->db_columns[$filter];
                    $data['display_as'] = $this->db_columns[$filter]['display_as'];
                    $data['db_name'] = $filter;

                    $values = $this->getFilterValuesMN($this->db_columns[$filter]);

                    $data['values'] = $values;


                    $data['type'] = $this->db_columns[$filter]['type'];
                    $html .= $this->ci->load->view('besc_crud/filters/text', $data, true);
                    break;
                case 'date':
                case 'datetime':
                    $key = 'DATE (' . $filter . ') =';
                    $filter2 = $filter;
                    if (array_key_exists($key, $this->filters['date'])) {
                        $filter2 = $key;
                    }
                    $data['filter_value'] = isset($this->filters['date'][$filter2]) ? date('d.m.Y', strtotime($this->filters['date'][$filter2])) : '';
                    $data['display_as'] = $this->db_columns[$filter]['display_as'];
                    $data['db_name'] = $this->db_columns[$filter]['db_name'];
                    $data['type'] = 'date';
                    $html .= $this->ci->load->view('besc_crud/filters/text', $data, true);
                    break;
                case 'hidden':
                case 'text':
                case 'file':
                case 'multiline':
                    $data['filter_value'] = isset($this->filters['text'][$filter]) ? $this->filters['text'][$filter] : '';

                    $values = $this->getFilterValues($filter);


                    $data['values'] = $values;


                    $data['display_as'] = $this->db_columns[$filter]['display_as'];
                    $data['db_name'] = $this->db_columns[$filter]['db_name'];
                    // var_dump( $data['db_name']);
                    $data['type'] = 'text';
                    $html .= $this->ci->load->view('besc_crud/filters/text', $data, true);
                    break;
            }

        }




        return $html;
    }

    protected function getFilterValues($filter) {


        $query = $this->ci->db->distinct()->select($filter)->get($this->db_table);
        $result = $query->result_array();

        $values = array();
        foreach ($result as $row) {
            $values[] = $row[$filter];
            }

        $values = array_unique($values);

        $emptyStringIndex = array_search('', $values);
        if ($emptyStringIndex !== false) {
            unset($values[$emptyStringIndex]);
        }

        array_unshift($values, '');


        return $values;
    }

        protected function getFilterValuesMN($data) {


        $query = $this->ci->db->distinct()->select($data['table_n_value'])->get($data['table_n']);
        $result = $query->result_array();

        $values = array();
        foreach ($result as $row) {
            $values[] = $row[$data['table_n_value']];
        }

        $values = array_unique($values);

        $emptyStringIndex = array_search('', $values);
        if ($emptyStringIndex !== false) {
            unset($values[$emptyStringIndex]);
        }

        array_unshift($values, '');


        return $values;
    }





    protected function paging($get)
    {

        $pagination = $get['pagination'];
        $totalPages = $pagination > ROWS_PER_PAGE_OF_TABLE ? 1 : ceil($get['total'] / $pagination);

        $current = $pagination > ROWS_PER_PAGE_OF_TABLE ? 0 : ($this->paging_offset / $get['pagination']);

        // $current = $this->paging_offset / $get['pagination'];


        if ($this->ci->session->userdata('current_page') !== NULL && $current == ROWS_PER_PAGE_OF_TABLE) {
            $current = $this->ci->session->userdata('current_page');
        }



        $paging = array(
            'total' => $get['total'],
            'currentPage' => $current,
            'totalPages' => $totalPages,
            'list_start' => $current,
            'list_end' => $current,
        );

        // var_dump($paging); die();


        $i = 1;
        while ($i < 3 && $paging['currentPage'] - $i >= 0) {
            $paging['list_start'] = $paging['currentPage'] - $i;
            $i++;
        }

        $i = 1;
        while ($i < 3 && $paging['currentPage'] + $i < $paging['totalPages']) {
            $paging['list_end'] = $paging['currentPage'] + $i;
            $i++;
        }


        return $paging;
    }

    protected function render_edit()
    {
        $columns = array();
        $additional_columns = array();
        if ($this->state_info->first_parameter != null) {
            $get = $this->ci->bc_model->getByID($this->db_name, $this->db_table, $this->db_primary_key, $this->state_info->first_parameter);
            if ($get->num_rows() != 1)
                $this->die_with_error("key not unique!");
            else
                $get = $get->row_array();

            $data['pk_value'] = $this->state_info->first_parameter;
        }

        // is english article
        $is_second_lang = false;
        $originalId = false;


        if (isset($get['original_item_id']) && $get['original_item_id'] > 0) {
            $is_second_lang = true;
            $originalId = $get['original_item_id'];
        }

        // this is for entity


        $data['is_second_lang'] = $is_second_lang;
        $data['originalId'] = $originalId;



        $i = 0;

        if ($this->state_info->first_parameter != null)
            $data['edit_or_add'] = BC_EDIT;
        else
            $data['edit_or_add'] = BC_ADD;


        $is_article = $this->db_table == 'items' ? true : false;
        $article_type = $this->article_type;


        foreach ($this->db_columns as $key => $col) {
            $col['num_row'] = $i;
            if (!isset($col['col_info']))
                $col['col_info'] = "";

            if (!isset($col['height']))
                $col['height'] = "";

            if (!isset($col['placeholder']))
                $col['placeholder'] = "";

            if (!isset($col['disabled']))
                $col['disabled'] = "";

            if (!isset($col['dropdown']))
                $col['dropdown'] = false;

            if (!isset($col['control']))
                $col['control'] = false;

            if (!isset($col['controlled_by']))
                $col['controlled_by'] = false;


            if ($this->state_info->first_parameter != null && !isset($col['value']) && $col['type'] != 'm_n_relation' && $col['type'] != 'image_gallery') {
                $col['value'] = $get[$col['db_name']];
            }

            $entity_id = 0;
            $original_id = 0;
            if (isset($_GET['type']) && isset($_GET['entity_id'])) {
                $article_type = $_GET['type'];
                $entity_id = $_GET['entity_id'];
            }

            if (isset($_GET['original_id'])) {
                $original_id = $_GET['original_id'];
            }


            switch ($col['type']) {
                case 'select':
                    $col['article_type'] = $article_type;
                    $col['entity_id'] = $entity_id;
                    $col['original_id'] = $original_id;


                    if (!$col['dropdown']) {

                        $columns[$i] = $this->edit_select($col);
                    } else {
                        $additional_columns[$i] = $this->edit_select($col);
                    }

                    break;
                case 'repo_image':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_repo_image($col);
                    } else {
                        $additional_columns[$i] = $this->edit_repo_image($col);
                    }

                    break;
                case 'text':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_text($col);
                    } else {
                        $additional_columns[$i] = $this->edit_text($col);
                    }
                    break;
                case 'repo_text':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_repo_text($col);
                    } else {
                        $additional_columns[$i] = $this->edit_repo_text($col);
                    }
                    break;
                case 'multiline':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_multiline($col);
                    } else {
                        $additional_columns[$i] = $this->edit_multiline($col);
                    }
                    break;
                case 'hidden':
                    $columns[($i * -1) - 2] = $this->edit_hidden($col);
                    break;
                case 'image':
                    if (!isset($col['js_callback_after_upload']))
                        $col['js_callback_after_upload'] = "";

                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_image($col);
                    } else {
                        $additional_columns[$i] = $this->edit_image($col);
                    }
                    break;
                case 'm_n_relation':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_m_n_relation($col);
                    } else {
                        $additional_columns[$i] = $this->edit_m_n_relation($col);
                    }
                    break;
                case 'url':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_url($col);
                    } else {
                        $additional_columns[$i] = $this->edit_url($col);
                    }
                    break;
                case 'date':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_date($col, $data['edit_or_add']);
                    } else {
                        $additional_columns[$i] = $this->edit_date($col, $data['edit_or_add']);
                    }
                    break;
                case 'datetime':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_datetime($col, $data['edit_or_add']);
                    } else {
                        $additional_columns[$i] = $this->edit_datetime($col, $data['edit_or_add']);
                    }
                    break;
                case 'combobox':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_combobox($col);
                    } else {
                        $additional_columns[$i] = $this->edit_combobox($col);
                    }
                    break;
                case 'file':
                    if (!isset($col['js_callback_after_upload']))
                        $col['js_callback_after_upload'] = "";
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_file($col);
                    } else {
                        $additional_columns[$i] = $this->edit_file($col);
                    }
                    break;
                case 'ckeditor':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_ckeditor($col);
                    } else {
                        $additional_columns[$i] = $this->edit_ckeditor($col);
                    }
                    break;
                case 'colorpicker':
                    if (!$col['dropdown']) {
                        $columns[$i] = $this->edit_colorpicker($col);
                    } else {
                        $additional_columns[$i] = $this->edit_colorpicker($col);
                    }
                    break;
            }
            $i++;
        }


        $articleForEntity = false;
        $englishArticleForEntity = false;
        $articles = array();


         $data['languageArray'] = $this->languageArray;

        if (!$is_article && $article_type && isset($data['pk_value'])) {


         // if doesn't exist then next

            $articleForEntity = $this->ci->cm->getArticleForEntity($data['pk_value'], $article_type);

            if ($articleForEntity) {

                $articles[] = $articleForEntity;

                if (NUMBER_OF_LANGUAGES > 1) {
                    $englishArticleForEntity = $this->ci->cm->getEnglishItemFromOriginal($articleForEntity->id);




                    if ($englishArticleForEntity) {
                        $articles[] = $englishArticleForEntity;
                        }
                    }

                }
        }

        $data['articlesForEntity'] = $articles;

        $data['englishArticleForEntity'] = $englishArticleForEntity;

        $data['articleForEntity'] = $articleForEntity;


        ksort($columns, SORT_NUMERIC);


        $data['columns'] = $columns;
        $data['additional_columns'] = $additional_columns;
        $data['title'] = $this->title;
        $data['show_mods'] = $this->show_mods;


        // tells me if this is article (in items table) and if it's english
        $data['is_article'] = $is_article;

        $data['article_type'] = $article_type ? $article_type : $this->article_type;



        $data['pk'] = $this->state_info->first_parameter;



        // teaser images count
        $existing_teasers = $this->getExistingTeasers($data['pk'], $data['article_type']);


        $data['teaser_count']  = count($existing_teasers);



        // info for deleting item
        $data['table'] = $this->db_table;


        // if articles in general
        $englishArticle = false;
        // $originalArticle = false;
        if($this->db_table == 'items'){

            $data['article_type_name'] = $this->getEntityName($article_type);

            $item = $this->ci->cm->getItemById($data['pk']);

            $data['item'] = $item;

            if ($item) {
                $data['article_type_name'] = $this->getEntityName($item->type);
            }

            $englishArticle = $this->ci->cm->getEnglishItemFromOriginal($data['pk']);

        }


        $data['englishArticle'] = $englishArticle;
        // $data['originalArticle'] = $originalArticle;



        $data['entity_table'] = $this->getEntityName($article_type);
        // getting teaser image button to articles
        if ($is_article && $data['edit_or_add'] == BC_EDIT) {
            $item = $this->ci->cm->getItemById($data['pk']);


            if ($item) {
                $data['article_type'] = $item->type;
                $data['entity_id'] = $item->entity_id;

                $entity = $this->ci->cm->getAnyEntityOrNoarticle($item->type, $item->entity_id);

                $data['one_entity_name'] = $this->getRowName($entity);
                $data['entity_table'] = $this->ci->cm->getTypeTableName($item->type);
            }

            $existing_teasers = $this->getExistingTeasers($data['entity_id'], $data['article_type']);

            $data['teaser_count'] = count($existing_teasers);

        } elseif ($article_type) {


            foreach (ARTICLE_TYPES as $t) {
                if ($t['type_id'] == $article_type) {
                    $type_name = $t['name'];
                }
            }

            $next_entity_id = $this->ci->cm->getNextTableId($type_name);

            $data['next_entity_id'] = $next_entity_id;

        }

        $data['db_name'] = $this->db_name;

        $data['bc_urls'] = $this->get_urls();

        $data = $this->addModuleSelectors($data);


        return $this->ci->load->view('besc_crud/edit_view', $data, true);
    }


    protected function addModuleSelectors($data) {


        $normal_tags = $this->ci->cm->getAllNormalTags();
        foreach ($normal_tags as $tag) {
            $data['module_related_normal_tags'][] = array('id' => $tag->id, 'name' => $tag->name . ' (' . $tag->id . ')');
        }

		$pdf_array = array();
		$pdf_array[] = array('key' => '0', 'value' => 'Select File');
		$pdfs = $this->ci->cm->getFiles();
		foreach ($pdfs as $p) {

			$pdf_array[] = array('key' => $p->id, 'value' => $p->title . ' (' . $p->id . ')');
			// $data['module_related_articles'][] = array('id' => $item->id, 'name' => $item->name . '.' .  $item->pretty_url .  ' (' . $item->id . ')');
			}




		$data['files_array'] = $pdf_array;

		$file_tag_array = array();
		$file_tag_array[] = array('key' => '0', 'value' => 'Select File Tag');
		$file_tags = $this->ci->cm->getFileTags();
		foreach ($file_tags as $t) {

			$file_tag_array[] = array('key' => $t->id, 'value' => $t->name . ' (' . $t->id . ')');
			}


		$data['file_tags'] = $file_tag_array;

		$repository_images_tags_array = array();
		$repository_images_tags_array[] = array('key' => 0, 'value' => 'Select Image Tag');
		$repository_images_tags = $this->ci->cm->getRepositoryImageTags();

		foreach ($repository_images_tags as $r) {
			$repository_images_tags_array[] = array('key' => $r->id, 'value' => $r->name);
			}

		$data['image_tags'] = $repository_images_tags_array;

		// $colors_array = $this->getSelector('colors', 'name', 'hex');


		// $data['colors'] = $colors_array;



		$items_array[] = array('key' => '', 'value' => 'none');
		$items = $this->ci->cm->get_original_items();
		foreach ($items as $item) {

			$items_array[] = array('key' => $item->id, 'value' => $item->pretty_url . ' (' . $item->id . ')');
			$data['module_related_articles'][] = array('id' => $item->id, 'name' => $item->pretty_url . ' (' . $item->id . ')');
		}

        $data['module_related_articles'] = $items_array;


		$general_tags = $this->ci->cm->getAllTags();
		foreach ($general_tags as $tag) {
			$data['module_related_general_tags'][] = array('id' => $tag->id, 'name' => $tag->name . ' (' . $tag->id . ')');
		}

        return $data;

}




    /***************************************************************************************************************************************************************************************
     *
     * RENDER LIST FUNCTIONS
     *
     **************************************************************************************************************************************************************************************/



    protected function list_text($row, $column)
    {
        $dummy = array('text' => $row[$column['db_name']]);
        return $this->ci->load->view('besc_crud/table_elements/text', $dummy, true);
    }

    protected function list_entity($entity, $type_name, $type_id)
    {



        $data = array();

        $existing_teasers = $this->getExistingTeasers($entity->id, $type_id);

        $data['teaser_count'] = count($existing_teasers);

        $data['teaser_link'] = site_url() . 'entities/Content/teaser_selector/' . $type_id . '/' . $entity->id;
        $data['link'] = site_url() . 'entities/Content/' . $type_name . '/edit/' . $entity->id;
        $data['type_name'] = $type_name;
        $data['text'] = $entity->name;
        return $this->ci->load->view('besc_crud/table_elements/entity_connect', $data, true);
    }

    protected function list_teaser($data)
    {
        return $this->ci->load->view('besc_crud/table_elements/teaser_button', $data, true);
    }

    protected function getExistingTeasers($entity_id, $type_id, $has_article = 1){
        $teaser_relation = $this->ci->cm->getTeaserImagesForEntityAndType($type_id, $entity_id, $has_article);

        $existing_teasers = [];
        foreach ($teaser_relation as $t) {
            $existing_image = $this->ci->cm->getAnyRepoItemById($t->repo_id);
            if ($existing_image) {
                $existing_teasers[] = $existing_image;
            }
        }

        return $existing_teasers;
    }

    protected function list_article($original, $has_article, $article = 0, $article_type = false, $entity_id = false, $original_id = false)
    {




        $answer = 'X';


        $pk = is_object($article) ? $article->id : 0;
        // edit or add if possible
        $link = $has_article == 1 ? (site_url() . 'entities/Content/items/edit/' . $pk) : ('');


        $data['link'] = $link;


        $data['text'] = is_object($article) ? $article->pretty_url : $answer;


        if (is_object($article) && $has_article == 1) {
            if ($article->visible == 1) {
                $color = 'green';
            } else {
                $color = 'blue';
            }
        } else {
            $color = 'red';
        }

        $data['color'] = $color;

        return $this->ci->load->view('besc_crud/table_elements/article_connect', $data, true);
    }

    protected function list_repo_text($row, $column)
    {
        $dummy = array(
            'col_name' => $column['db_name'],
            'table_name' => $this->table_name,
            'row_id' => $row['id'],
        );
        return $this->ci->load->view('besc_crud/table_elements/repo_text', $dummy, true);
    }

    protected function list_select($row, $column)
    {
        $dummy = array(
            'options' => $column['options'],
            'value' => $row[$column['db_name']]
        );
        return $this->ci->load->view('besc_crud/table_elements/select', $dummy, true);
    }

    protected function list_image($row, $column)
    {

        if ($this->full_url != null) {
            $upload_path = $this->full_url . "/" . $column['uploadpath'];
        } else {
            $upload_path = site_url() . "/" . $column['uploadpath'];
        }

        $public = isset($row['public']) ? $row['public'] : 1;

        $dummy = array(
            'uploadpath' => $upload_path,
            'filename' => $row[$column['db_name']],
            'public' => $public
        );

        return $this->ci->load->view('besc_crud/table_elements/image', $dummy, true);
    }

    protected function list_repo_image($row, $column)
    {
        $dummy = array(
            'repo_id' => $row[$column['db_name']],
        );
        return $this->ci->load->view('besc_crud/table_elements/repo_image', $dummy, true);
    }


    protected function list_file($row, $column)
    {
        if ($this->full_url != null) {
            $upload_path = $this->full_url . "/" . $column['uploadpath'];
        } else {
            $upload_path = site_url() . "/" . $column['uploadpath'];
        }

        $dummy = array(
            'uploadpath' => $upload_path,
            'filename' => $row[$column['db_name']]
        );
        return $this->ci->load->view('besc_crud/table_elements/file', $dummy, true);
    }

    protected function list_m_n_relation($row, $column)
    {
        $type = isset($column['table_mn_col_m_type']) ? $column['table_mn_col_m_type'] : false;



        $dummy['n_values'] = $this->ci->bc_model->get_m_n_relation($this->db_name, $column['table_mn'], $column['table_mn_col_m'], $column['table_mn_col_n'], $row[$this->db_primary_key], $column['table_n'], $column['table_n_value'], $column['table_n_pk'], $type);
        $dummy['table_n_value'] = $column['table_n_value'];

        // value 2 like id is optional
        $table_n_value2 = isset($column['table_n_value2']) ? $column['table_n_value2'] : '';
        $dummy['table_n_value2'] = $table_n_value2;
        return $this->ci->load->view('besc_crud/table_elements/m_n_relation', $dummy, true);
    }

    protected function list_url($row, $column)
    {
        $dummy = array('url' => $row[$column['db_name']]);
        return $this->ci->load->view('besc_crud/table_elements/url', $dummy, true);
    }

    protected function list_image_gallery($row, $column)
    {
        $items = $this->ci->bc_model->get_image_gallery_items($this->db_name, $column['gallery_table'], $column['gallery_table_fk'], $row[$this->db_primary_key]);
        $dummy = array(
            'items' => ($items == false ? array() : $items),
            'uploadpath' => $column['uploadpath'],
            'fname' => $column['gallery_fname']
        );

        return $this->ci->load->view('besc_crud/table_elements/image_gallery', $dummy, true);
    }

    protected function list_multiline($row, $column)
    {
        $text = isset($row[$column['db_name']]) ? $row[$column['db_name']] : '';
        $dummy = array('text' => nl2br($text));
        return $this->ci->load->view('besc_crud/table_elements/text', $dummy, true);
    }

    protected function list_date($row, $column)
    {
        if ($row[$column['db_name']] != null && $row[$column['db_name']] != "0000-00-00 00:00:00" && $row[$column['db_name']] != "" && $row[$column['db_name']] != "1970-01-01 01:00:00")
            $dummy = array('date' => date($column['list_format'], strtotime($row[$column['db_name']])));
        else
            $dummy = array('date' => "");
        return $this->ci->load->view('besc_crud/table_elements/date', $dummy, true);
    }

    protected function list_datetime($row, $column)
    {
        if ($row[$column['db_name']] != null && $row[$column['db_name']] != "0000-00-00 00:00:00" && $row[$column['db_name']] != "" && $row[$column['db_name']] != "1970-01-01 01:00:00")
            $dummy = array('date' => date($column['list_format'], strtotime($row[$column['db_name']])));
        else
            $dummy = array('date' => "");
        return $this->ci->load->view('besc_crud/table_elements/datetime', $dummy, true);
    }

    protected function list_combobox($row, $column)
    {
        $dummy = array(
            'options' => $column['options'],
            'value' => $row[$column['db_name']]
        );
        return $this->ci->load->view('besc_crud/table_elements/combobox', $dummy, true);
    }

    protected function list_colorpicker($row, $column)
    {
        $dummy = array(
            'value' => $row[$column['db_name']]
        );
        return $this->ci->load->view('besc_crud/table_elements/colorpicker', $dummy, true);
    }


    /***************************************************************************************************************************************************************************************
     *
     * RENDER EDIT FUNCTIONS
     *
     **************************************************************************************************************************************************************************************/

    protected function edit_text($col)
    {
        $col['value'] = isset($col['value']) ? $col['value'] : '';
        $col['disabled'] = array_key_exists('disabled', $col) ? $col['disabled'] : false;
        return $this->ci->load->view('besc_crud/edit_elements/text', $col, true);
    }

    protected function edit_repo_text($col)
    {
        $col['table_name'] = $this->db_table;
        $col['row_id'] = $this->state_info->first_parameter != null ? $this->state_info->first_parameter : 'add';

        return $this->ci->load->view('besc_crud/edit_elements/repo_text', $col, true);
    }

    protected function edit_hidden($col)
    {
        return $this->ci->load->view('besc_crud/edit_elements/hidden', $col, true);
    }

    protected function edit_image($col)
    {

        if (substr($col['uploadpath'], -1) != '/')
            $col['uploadpath'] .= '/';

        if ($this->full_url != null) {
            $col['hostUrl'] = $this->full_url . "/";
        } else {
            $col['hostUrl'] = site_url();
        }


        if(isset($col['value'])){
            $col['image'] = $this->ci->bc_model->getRepoItemByFname($col['value']);
        }
        // $image = $this->ci->fm->getImageByFname($col['value']);



        return $this->ci->load->view('besc_crud/edit_elements/image', $col, true);
    }



    protected function edit_repo_image($col)
    {
        return $this->ci->load->view('besc_crud/edit_elements/repo_image', $col, true);
    }

    protected function edit_select($col)
    {
        $col['disabled'] = array_key_exists('disabled', $col) ? $col['disabled'] : false;
        return $this->ci->load->view('besc_crud/edit_elements/select', $col, true);
    }

    protected function edit_multiline($col)
    {
        if (!isset($col['formatting']))
            $col['formatting'] = array();

        return $this->ci->load->view('besc_crud/edit_elements/multiline', $col, true);
    }

    protected function edit_m_n_relation($col)
        {
        $col['show_name'] = isset ($col['show_name']) ? $col['show_name'] : false;
        $col['from_mn'] = isset ($col['from_mn']) ? $col['from_mn'] : false;

        if ($col['show_name'] === true) {
            $col['selected'] = $this->ci->bc_model->get_m_n_relation_m_values_name($this->db_name, $col['table_mn'], $col['table_mn_col_m'], $this->state_info->first_parameter, $col['table_n'], $col['table_n_pk'], $col['table_mn_col_n'], $col['table_n_value'], $col['table_mn_display']);

            } else {

            // here
            $col['table_n_value2'] = (!isset ($col['table_n_value2'])) ? 'id' : $col['table_n_value2'];

            // var_dump($col['table_mn_col_m_type']);
            $table_mn_col_m_type = isset ($col['table_mn_col_m_type']) ? $col['table_mn_col_m_type'] : false;


            $col['type_check'] = $table_mn_col_m_type;
            $col['selected'] = $this->ci->bc_model->get_m_n_relation_m_values($this->db_name, $col['table_mn'], $col['table_mn_col_m'], $this->state_info->first_parameter, $col['table_n'], $col['table_n_pk'], $col['table_mn_col_n'], $col['table_n_value'], $col['table_n_value2'], $table_mn_col_m_type);

            }



        $selected = array();
        foreach ($col['selected']->result() as $sel) {
            $selected[] = $sel->{$col['table_mn_col_n']};
            }

        if (count($selected) <= 0)
            $selected[] = -1;

        $where = isset ($col['where']) ? $col['where'] : array();
        $that_has = isset ($col['that_has']) ? $col['that_has'] : false;
        $col['avail'] = $this->ci->bc_model->get_m_n_relation_n_values($this->db_name, $col['table_n'], $col['table_n_pk'], $selected, $col['table_n_value'], $where, $that_has);

        $col['filter'] = isset ($col['filter']) ? $col['filter'] : false;
        $col['add_name'] = isset ($col['add_name']) ? $col['add_name'] : false;
        $col['table_n_value2'] = isset ($col['table_n_value2']) ? $col['table_n_value2'] : false;


        return $this->ci->load->view('besc_crud/edit_elements/m_n_relation', $col, true);
        }

    protected function edit_url($col)
    {
        return $this->ci->load->view('besc_crud/edit_elements/url', $col, true);
    }

    protected function edit_date($col, $add_or_edit)
    {
        $col['corr_value'] = '';
        if ($add_or_edit == BC_ADD) {
            if (isset($col['defaultvalue'])) {
                $col['corr_value'] = $col['defaultvalue'];
            }
        } else {
            if (isset($col['value']) && $col['value'] != "" && $col['value'] != 1 && $col['value'] != "0000-00-00 00:00:00" && $col['value'] != null && $col['value'] != '1970-01-01 01:00:00') {
                $col['corr_value'] = $col['value'];
            }
        }

        return $this->ci->load->view('besc_crud/edit_elements/date', $col, true);
    }

    protected function edit_datetime($col, $add_or_edit)
    {
        $col['corr_value'] = '';
        if ($add_or_edit == BC_ADD) {
            if (isset($col['defaultvalue'])) {
                $col['corr_value'] = $col['defaultvalue'];
            }
        } else {
            if (isset($col['value']) && $col['value'] != "" && $col['value'] != 1 && $col['value'] != "0000-00-00 00:00:00" && $col['value'] != null && $col['value'] != '1970-01-01 01:00:00') {
                $col['corr_value'] = date('Y-m-d H:i', strtotime($col['value']));
            }
        }

        return $this->ci->load->view('besc_crud/edit_elements/datetime', $col, true);
    }

    protected function edit_combobox($col)
    {
        return $this->ci->load->view('besc_crud/edit_elements/combobox', $col, true);
    }

    protected function edit_file($col)
    {
        if (substr($col['uploadpath'], -1) != '/')
            $col['uploadpath'] .= '/';

        return $this->ci->load->view('besc_crud/edit_elements/file', $col, true);
    }

    protected function edit_ckeditor($col)
    {
        return $this->ci->load->view('besc_crud/edit_elements/ckeditor', $col, true);
    }

    protected function edit_colorpicker($col)
    {
        $col['hexinput'] = isset($col['hexinput']) && $col['hexinput'];
        return $this->ci->load->view('besc_crud/edit_elements/colorpicker', $col, true);
    }


    protected function render_ordering()
    {
        $data['title'] = $this->title;
        $data['bc_urls'] = $this->get_urls();
        $data['items'] = array();

        $value_col = $this->db_columns[$this->ordering['value']];

        foreach ($this->ci->bc_model->get_ordering($this->db_name, $this->db_table, $this->db_where, $this->ordering['ordering'])->result_array() as $column) {
            switch ($value_col['type']) {
                case 'select':
                case 'combobox':
                    foreach ($value_col['options'] as $col) {
                        if ($col['key'] == $column[$this->ordering['value']]) {
                            $val = $col['value'];
                            break;
                        }
                    }
                    break;
                case 'text':
                case 'url':
                case 'date':
                case 'datetime':
                case 'multiline':
                    $val = $column[$this->ordering['value']];
                    break;
                case 'file':
                    $val = $column[$this->ordering['value']];
                    break;
                default:
                    $val = null;
                    break;
            }

            if ($val != null) {
                $data['items'][] = array(
                    'id' => $column[$this->db_primary_key],
                    'value' => $val,
                    'ordering' => $column[$this->ordering['ordering']],
                );
            }
        }

        return $this->ci->load->view('besc_crud/ordering_view', $data, true);
    }

    protected function save_ordering()
    {
        $content = json_decode(file_get_contents('php://input'));
        $batch = array();
        foreach ($content as $column) {
            $batch[] = array(
                $this->db_primary_key => $column->id,
                $this->ordering['ordering'] => $column->ordering,
            );
        }

        if ($this->ci->bc_model->save_ordering($this->db_name, $this->db_table, $batch, $this->db_primary_key)) {
            $result['success'] = true;
            $result['message'] = $this->title . ' sorting successfully updated.';
        } else {
            $result['success'] = false;
            $result['message'] = 'Error while updating ' . $this->title . '.';
        }

        echo json_encode($result);
    }
}

require_once SYSDIR . '/libraries/Form_validation.php';

class Besc_Form_validation extends CI_Form_validation
{
    function __construct()
    {
        parent::__construct();
    }

    public function is_unique($str, $field)
    {
        //$this->db->db_select($this->db_name);
        if (substr_count($field, '.') == 3) {
            list($table, $field, $id_field, $id_val) = explode('.', $field);
            $query = $this->CI->db->limit(1)->where($field, $str)->where($id_field . ' != ', $id_val)->get($table);
        } else {
            list($table, $field) = explode('.', $field);
            $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
        }

        return $query->num_rows() === 0;
    }

    public function fix_is_unique_rule($pk, $id, $rules)
    {
        if ($id != 'null') {
            $new_rule = $rules;
            $rules = explode('|', $rules);
            foreach ($rules as $rule) {
                if (preg_match('/is_unique/', $rule)) {
                    $replace = str_replace(']', ".$pk.$id]", $rule);
                    $new_rule = str_replace($rule, $replace, $new_rule);
                }
            }
        } else
            $new_rule = $rules;

        return $new_rule;
    }
}