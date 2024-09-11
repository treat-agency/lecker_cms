<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once './vendor/autoload.php';

class Helper_Controller
{
    protected $documentRoot = "";
    public $language = NULL;
    protected $settings = NULL;
    public $is_mobile = NULL;
    public $is_ipad = NULL;




   public function getPrettyNameInAllCaps($name){
    // makes normal name from table name

        $name_array = explode('_', $name);
        $pretty_name = '';

          foreach($name_array as $key=>$word){

            $add = strtoupper($word);

            if($key != count($name_array)){
                 $pretty_name .= $add . ' ';
            } else {
                $pretty_name .= $add;
            }

          }
          return $pretty_name;
    }

  }