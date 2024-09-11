<?php

    if(! defined('BASEPATH')) exit('No direct script access allowed');
    require('fpdf/fpdf.php');
    
    class myfpdf extends Fpdf {
        function __construct(){
            parent::construct();
            $CI =& get_instance();
        }
    }

?>