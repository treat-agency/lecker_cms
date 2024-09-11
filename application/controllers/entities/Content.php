<?php defined('BASEPATH') or exit('No direct script access allowed');

require (APPPATH . 'controllers/Backend.php');

include (APPPATH . 'controllers/CONTENT/' . "Item_Dev_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Modules_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Article_Entity_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Shop_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Image_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "File_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Noarticle_Entity_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Tags_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Meta_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Lecker_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Helper_Content.php");
include (APPPATH . 'controllers/CONTENT/' . "Openai_Content.php");



class Content extends Backend
	{

	public $table = 'items';
	public $tableSingular = 'item';
	public $typeOfTable = '';
	public $groupName = "Articles";
	public $bc;

	public $tablePrettyName = 'Articles';

	public $tablePrettyNameSingular = 'Article';
	public $customButtons = array();

	public $repoFilterKeys = array('date_added', 'date_taken', 'sort', 'tag', 'category', 'text');
	public $ArticleOrNoarticleOrNoneType = ARTICLE;

	public $entityTypeId = 0;

	public $pagination = 10;

	public $columns = array();

	public $filterColumns = array();

	public $listColumns = array();

	// repo
	public $repoEntityType = false;

	public $repoEntityId = false;

	public $repoHasArticle = true;



	function __construct()
		{
		parent::__construct();
		$this->solvePagination();


		}


	use Item_Dev_Content;
	use Tags_Content;
	use Article_Entity_Content;
	use Noarticle_Entity_Content;
	use Openai_Content;
	use Shop_Content;
	use Modules_Content;
	use File_Content;
	use Image_Content;
	use Meta_Content;
	use Lecker_Content;
	use Helper_Content;

	}