<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| ARTICLE AND NOARTICLE TYPES
|--------------------------------------------------------------------------
|
*/


$article_types = array('normals');
$article_types_array = getTypesArray($article_types);


$noarticle_types = array('artworks', 'normal_tags');
$noarticle_types_array = getTypesArray($noarticle_types);


define('ARTICLE_TYPES', $article_types_array); // start always with 1

define('NOARTICLE_TYPES', $noarticle_types_array); // for type specific cloning and teaser images
// start with 1

// treatstart start

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
|
*/

define('NUMBER_OF_LANGUAGES', 2); // change if the website uses just one language

define('MAIN_LANGUAGE', 'de');
define('SECOND_LANGUAGE', 'en'); // don't delete, just flip main or second languages




/*
|--------------------------------------------------------------------------
| General - please check
|--------------------------------------------------------------------------
|
*/
// treatstart

// default it takes name of root folder - feel free to change
$DB_NAME = 'lecker';

define('DB_NAME', $DB_NAME);

// make a pretty name from db name - feel free to change
require_once(PATH_WITHOUT_SLASH . '/application/core/Helper_Controller.php');
$helper_controller = new Helper_Controller;
$SITE_NAME = $helper_controller->getPrettyNameInAllCaps(DB_NAME);

// change if different
define('SITE_NAME', 'Lecker');
define('IS_SHOP', 0);
define('DEFAULT_COLOR', 'white');

/*
|--------------------------------------------------------------------------
| Related module types
|--------------------------------------------------------------------------
|
*/


/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
|
*/

// seo_purpose
define('PAGE_TITLE', SITE_NAME);
define('OG_TITLE', SITE_NAME);

define('OG_DESCRIPTION', SITE_NAME);
define('SEO_DESCRIPTION', SITE_NAME);


define('OG_IMAGE', 'assets/img/placeholder.png');
define('LOGO_IMAGE', ''); // if left as empty string, writes site name instead of logo

// canonical issues
define(
    'CANONICAL_REPLACE',
    // start always with 1
    [
        ['from' => 'produkte', 'to' => 'products'],

    ]
);



/*
|--------------------------------------------------------------------------
| Lecker settings - rarely changed
|--------------------------------------------------------------------------
|
*/

// article or no article
define('ARTICLE', 0);
define('NOARTICLE', 1);
define('NONE', 2);

// types of tables preparation
define('TABLE_ENTITY_WITH_ARTICLE', 0);
define('TABLE_NOARTICLE_WITH_ALL_BUTTONS', 1);
define('TABLE_NOARTICLE_JUST_CLONE', 2);


// image sizes for thumbs
define('THUMB_WIDTH', 400);
define('FRONTEND_WIDTH', 2000);
define('RESIZE_WIDTH', 400);
define('COUNT_LOADED_IMAGES', 30);

// GA

define('GA_VIEW_ID', '<YOUR_DATA>');
define('GA_VIEW_ID2', '<YOUR_DATA>');
define('GA_PROPERTY_ID', '<YOUR_DATA>');

define('GA_MEASUREMENT', '<YOUR_DATA>');
define('GA_API_SECRET', '<YOUR_DATA>');

// heygen

define("HEYGEN_API", "<YOUR_DATA>");

// visible type article
define('VISIBLE', 1);
define('HIDDEN', 0);
define('LOGGED_ONLY', 2);
define('DIRECT_ONLY', 3);


// default that almost never changes
define('PARENT_ARTICLE', 0);
define('VERSION', time());
define('ROWS_PER_PAGE_OF_TABLE', 20);


/*
|--------------------------------------------------------------------------
| Widgets
|--------------------------------------------------------------------------
|
*/


// default widget color
define('ITEMS_COLOR', '#81dbc6');
define('IMAGES_COLOR', '#fbbd80');
define('FILES_COLOR', '#9ba4c2');


// SHOP WIDGETS




/*
|--------------------------------------------------------------------------
| Module Constants
|--------------------------------------------------------------------------
|
*/


define('MODULE_COLUMN_LEFT_50', 0);
define('MODULE_COLUMN_RIGHT_50', 1);


/*
|--------------------------------------------------------------------------
| Form Types
|--------------------------------------------------------------------------
|
*/

define('PROGRAMME_SCHOOLS', 1);


/*
|--------------------------------------------------------------------------
| Shop variables
|--------------------------------------------------------------------------
|

// PAYMENT OPTIONS

// SHIPPING OPTION


/******* ORDERS *******/

define('ORDER_STATUS_CREATED', 0);
define('ORDER_STATUS_INITIATED', 1);
define('ORDER_STATUS_SUCCESS', 2);

define('ORDER_STATUS_CANCEL', 3);
define('ORDER_STATUS_FAILURE', 4);

define('ORDER_STATUS_CHECKOUT_SUCCESS', 5);

define('ORDER_STATUS_CHARGE_SUCCESS', 6);
define('ORDER_STATUS_PAYMENTINTENT_SUCCESS', 7);

// orders further

define('ORDER_STATUS_PENDING', 8);
define('ORDER_STATUS_PAYMENT_PENDING', 9);
define('ORDER_STATUS_PAYMENT_SUCCESS', 10);

define('ORDER_STATUS_IN_PROGRESS', 11);
define('ORDER_STATUS_LABEL_CREATED', 12);

define('ORDER_STATUS_DONE', 13);


// VOUCHER TYPES

define('VOUCHER_ENTIRE_CART_PERCENT', 0);
define('VOUCHER_ENTIRE_CART_FLAT', 1);
define('VOUCHER_ATTACHED_PRODUCT_PERCENT', 2);
define('VOUCHER_ATTACHED_PRODUCT_FLAT', 3);
define('VOUCHER_FREE_EXTRA_PRODUCT', 4);




/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| Constants defined from db
|--------------------------------------------------------------------------
|
*/

require_once(BASEPATH . 'database/DB.php');

$db =& DB();

$query = $db->get('constants');

$result = $query->result();

foreach ($result as $row) {
    define($row->name, $row->value);
}

/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
|
*/

function getTypesArray($types)
{
    $types_array = array();
    foreach ($types as $key => $type) {
        $types_array[$type] = array('name' => $type, 'type_id' => $key + 1);
    }
    return $types_array;
}