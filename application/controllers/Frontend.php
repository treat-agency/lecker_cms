<?php
defined('BASEPATH') or exit('No direct script access allowed');

include(APPPATH . 'controllers/FRONTEND/' . "Helper_Frontend.php");
include(APPPATH . 'controllers/FRONTEND/' . "Pages_Frontend.php");
include(APPPATH . 'controllers/FRONTEND/' . "User_Frontend.php");
include(APPPATH . 'controllers/FRONTEND/' . "Detail_Load_Frontend.php");
include(APPPATH . 'controllers/FRONTEND/' . "Data_Frontend.php");
include(APPPATH . 'controllers/FRONTEND/' . "Format_Frontend.php");
include(APPPATH . 'controllers/FRONTEND/' . "Forms_Frontend.php");
include(APPPATH . 'controllers/FRONTEND/' . "Language_Frontend.php");



// export GOOGLE_APPLICATION_CREDENTIALS="[PATH]";


class Frontend extends MY_Controller
{

// see3assdssdssdfss4dd

    function __construct()
    {
        parent::__construct();
        $this->detectDevice();
        $this->load->helper('besc_helper');
        $this->load->library('form_validation');
        $this->load->library('braintree-php-5.0.0/lib/Braintree');
        $this->load->helper('cookie');
        require_once(APPPATH . 'libraries/fpdf.php');
        require_once(APPPATH . 'libraries/FPDI/src/autoload.php');
        /* require_once(APPPATH . 'libraries/FPDI/src/Fpdi.php'); */
        require_once(APPPATH . 'libraries/PasswordHash.php');
    }



    use Helper_Frontend;
    use Pages_Frontend;
    use Detail_Load_Frontend;
    use Data_Frontend;
    use Format_Frontend;
    use Forms_Frontend;
    use User_Frontend;
    use Language_Frontend;

}