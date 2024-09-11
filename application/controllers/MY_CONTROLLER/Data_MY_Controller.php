<? defined('BASEPATH') or exit('No direct script access allowed');


trait MY_Controller_Data
  {


  public $repoModuleItemId = false;

  public $repoData = array();

  public $repoModuleId = false;

  public $repoModuleType = false;


  public function getArticleTypeId($type_name)
    {
    return ARTICLE_TYPES[$type_name]['type_id'];
    }

  public function getNoArticleTypeId($type_name)
    {
    return NOARTICLE_TYPES[$type_name]['type_id'];
    }

  public function getEntityName($typeId, $article = true)
    {
    // makes normal name from table name

    $name = '';

    if ($article == true):
      // go through all article types of constant ARTICLE_TYPES
      foreach (ARTICLE_TYPES as $article_type) {
        if ($article_type['type_id'] == $typeId) {
          $name = $article_type['name'];
          }
        }
    else:
      // go through all article types of constant NOARTICLE_TYPES

      foreach (NOARTICLE_TYPES as $noarticle_type) {
        if ($noarticle_type['type_id'] == $typeId) {
          $name = $noarticle_type['name'];
          }
        }
    endif;

    return $name;
    }


  public function getRowName($entity)
    {
    $name = '';

    if (isset($entity->name) && $entity->name) {
      $name = $entity->name;
      } elseif (isset($entity->title) && $entity->title) {
      $name = $entity->title;
      } elseif (isset($entity->title_de) && $entity->title_de) {
      $name = $entity->title_de;
      } elseif (isset($entity->title_en) && $entity->title_en) {
      $name = $entity->title_en;
      }

    return $name;

    }


  private function _setDocumentRoot()
    {
    $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
    }

  public function getFrontendOrBackendImages($images)
    {
    if ($this->calledClassName == "Frontend") {
      $images = $this->getTeaserImagesFrontend($images);
      } else {
      $images = $this->getBackendTeaserImages($images);
      }

    return $images;
    }

  public function prepareModuleImages($data)
    {
    $this->repoModuleType = $data['mod'];
    $this->repoModuleId = $data['id'];
    $this->repoModuleData = $data;
    $this->getModuleImages();
    return array_merge($data, $this->repoData);
    }

  public function getModuleImages()
    {

    $data = array();

    $newModuleForExistingItem = $this->repoModuleItemId !== false && ($this->repoModuleId === false || $this->repoModuleId === "false");

    if ($newModuleForExistingItem) {

      // get latest module id
      $lastModule = $this->cm->getLatestModule($this->repoModuleItemId, $this->repoModuleType);

      $this->repoModuleId = $lastModule->id;

      if ($this->repoModuleId === false || $this->repoModuleId === "false") {
        return false;
        }

      }

    switch ($this->repoModuleType) {
      case 'image':
      case 'sectiontitle':
        $multiple = false;
        break;
      default:
        $multiple = true;
        break;
      }

    $data['multiple'] = $multiple;


    $moduleImages = array();


    $moduleImages = $this->cm->getModuleImages($this->repoModuleType, $this->repoModuleId);

    $images = $this->getFrontendOrBackendImages($moduleImages);


    $data['teaser_count'] = count($images);

    $data['images'] = $images;

    $this->repoData = $data;

    }


  public function getTeaserImagesFrontend($images)
    {


    $teaser_images_array = array();
    foreach ($images as $ti) {

      $image = $this->fm->getPublicRepoItemById($ti->repo_id);
      if ($image) {
        $image->Credits = $this->language == SECOND_LANGUAGE ? $image->credits_en : $image->credits;
        $image->img_path = site_url() . 'items/uploads/images/frontend_images/' . $image->fname;
        $teaser_images_array[] = $image;

        }
      }

    return $teaser_images_array;
    }

  public function getTeaserImages()
    {
    $entityTeasers = $this->cm->getTeaserImagesForEntityAndType($this->repoEntityType, $this->repoEntityId, $this->repoHasArticle);

    $images = $this->getFrontendOrBackendImages($entityTeasers);

    return $images;

    }


  public function addTeaserImagesData()
    {

    $db = DB_NAME;

    $data = array();
    $data['multiple'] = true;
    $data['type'] = $this->repoEntityType;

    $type_name = $this->getEntityName($this->repoEntityType, $this->repoHasArticle);

    $entity = $this->cm->getAnyEntityById($this->repoEntityId, $type_name); // will get concrete entity for this images

    $this->variableExists('entity', $entity, 'Teaser Selector'); // checks if the entity exists


    $data['entity'] = $entity; // saves for data use


    $this->tableExists('entity_teaser_relation', 'Teaser Selector');

    $this->methodExists('cm', 'getEntityTeasersByIdAndType', 'Teaser Selector');

    $entityTeasers = $this->cm->getTeaserImagesForEntityAndType($this->repoEntityType, $this->repoEntityId, $this->repoHasArticle);

    $images = $this->getFrontendOrBackendImages($entityTeasers);

    $data['images'] = $images;


    $data['teaser_count'] = count($images);


    $data['entityId'] = $this->repoEntityId;
    $data['typeName'] = $this->getEntityName($this->repoEntityType);

    $articleForTeaser = $this->cm->getArticleForEntity($this->repoEntityId, $this->repoEntityType);

    $englishArticleForTeaser = false;
    if ($articleForTeaser) {
      $englishArticleForTeaser = $this->cm->getEnglishItemFromOriginal($articleForTeaser->id);
      }

    $data['articleForTeaser'] = $articleForTeaser;
    $data['englishArticleForTeaser'] = $englishArticleForTeaser;

    $data['has_article'] = $this->repoHasArticle ? 1 : 0;

    $this->repoData = $data;



    }




  public function getBackendTeaserImages($images)
    {
    $imagesArray = array();
    if (count($images) > 0) {
      foreach ($images as $teaser) {
        if ($teaser):
          $image = $this->cm->getAnyRepoItemById($teaser->repo_id);
          if ($image) {
            $image->img_path = site_url('items/uploads/images/thumbs/') . $image->fname;
            $image->publicClass = $image->public == 1 ? "" : "unPublicImage";

            if (isset($teaser->description) && $teaser->description != "") {
              $image->specialDescription = $teaser->description;
              } else {
              $image->specialDescription = $this->language == SECOND_LANGUAGE ? $image->credits_en : $image->credits;
              }

            if (isset($teaser->ordering)) {
              $image->ordering = $teaser->ordering;
              }

            $imagesArray[] = $image;
            }
        endif;
        }
      }

    return $imagesArray;

    }



  }
