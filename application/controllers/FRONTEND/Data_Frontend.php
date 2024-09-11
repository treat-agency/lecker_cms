<? defined('BASEPATH') or exit('No direct script access allowed');


trait Data_Frontend
    {


    /**************************    SINGLE ARTICLE INFO     *******************************/
    // getArticleInfo - get all info about article - add your entity
    // getItemVisibility - check if item is visible

    public function getNoArticleInfo($p, $noarticle_type_name = "persons")
        {

        $this->repoEntityId = $p->id;
        $this->repoEntityType = $this->getNoArticleTypeId($noarticle_type_name);
        $this->repoHasArticle = 0;

        switch ($noarticle_type_name) {
            case "artworks":
                break;
            case "persons":
                break;
            default:
                break;
            }

        $teaser_images = $this->getTeaserImages();

        $p->teaser_images = $teaser_images;

        return $p;

        }


    public function getArticleInfo($p, $has_related = true)
        {

        if (!$p) {
            return false;
            }



        if (!$p || $this->getItemVisibility($p) == false) {


            return false;
            }


        // SETTING PRETTY URL - either external link or pretty url



        // Ensure the URL starts with "https://"
        if ($p->external_url != '') {
            $external_url = $p->external_url;
            if (substr($p->pretty_url, 0, 5) !== "https" && !str_contains($p->pretty_url, site_url())) {

                $external_url = site_url() . $p->external_url;

                }

            redirect($external_url, 'refresh');
            } else {

            $p->pretty_url = site_url() . $p->pretty_url;
            }



        // DATE

        $p->Date = $this->getCorrectDateArticle(explode(' ', $p->date_added)[0]);


        $entity = false;

        /**************************    EDIT STARTS HERE     *******************************/


        // SET ENTITY AND  ASSOCIATED INFO

        if ($p->entity_id && $p->type): // entity id specific info start

            // CATEGORY DESCRIPTION

            $p->cat = 'normals';
            foreach (ARTICLE_TYPES as $type) {
                if ($type['type_id'] == $p->type) {
                    $p->cat = $type['name'];
                    break;
                    }
                }


            $entity = $this->fm->getEntityByTypeNameAndId($p->cat, $p->entity_id);


            if ($entity) {
                // method to get info is called getLocationInfo
                $get_method_name = 'get' . substr(ucfirst($p->cat), 0, -1) . 'Info';

                // every entity has method to get Info
                $this->functionExists($get_method_name, "Getting Info About Entity");

                // get info about the entity
                $entity = $this->{$get_method_name}($entity, $has_related);


                // add the entity to the item if it exixsts
                if ($entity) {
                    $p->entity = $entity;
                    }
                }

            // there can't be article without entity
            if (!isset($p->entity)) {
                return false;
                }

            $p->Name = $p->name;
            $p->Teaser = $p->teaser;


            /**************************    EDIT ENDS HERE     *******************************/



            $this->repoEntityId = $p->entity_id;
            $this->repoEntityType = $p->type;
            $this->repoHasArticle = 1;
            // GET TEASER IMAGES FROM ENTITY

            $teaser_images = $this->getTeaserImages();


            $p->teaser_images = $teaser_images;
            if (count($teaser_images)) {
                $p->first_teaser = $teaser_images[0];
                }

            if (count($teaser_images) > 1) {
                // second teaser
                $p->second_teaser = $teaser_images[1];
                } elseif (count($teaser_images) == 1) {
                $p->second_teaser = $p->first_teaser;
                }

            // GET TAGS

            $tags = $this->fm->getGeneralTagsRelation($p->entity_id, $p->type);

            $tags_array = array();

            if ($tags) {
                foreach ($tags as $tag) {
                    $one_tag = $this->fm->getGeneralTagById($tag->tag_id);
                    if ($one_tag) {
                        $one_tag->Name = $this->language == SECOND_LANGUAGE ? $one_tag->name_en : $one_tag->name;
                        $tags_array[] = $one_tag;
                        }
                    }

                }

            $p->tags = $tags_array;


        endif; // end of entity specific info


        // PUBLISH DATE CHECK

        return $p;

        }

    public function getItemVisibility($item)
        {


        if ($item->publish_date && $item->publish_date != '' && $item->publish_date != '0000-00-00') {


            $now = date(time());
            $article_publish = date(strtotime($item->publish_date));

            $publishing_day_already = $now >= $article_publish;
            } else {
            $publishing_day_already = false;
            }

        if ($item->visible != HIDDEN || $publishing_day_already) {


            if ($item->visible == VISIBLE) {
                return true;
                }


            $logged_only = $item->visible == LOGGED_ONLY;

            $direct_only = $item->visible == DIRECT_ONLY && isset($_SERVER['HTTP_REFERER']);

            if ($logged_only) {

                if ($this->logged_in() == false) {
                    redirect('authentication/showLogin?previous_url=' . $item->pretty_url);
                    }

                } else {
                return true;
                }

            if ($direct_only) {
                return true;
                }



            } else {
            return false;
            }


        }

    /**************************    ENTITIES     *******************************/

    public function getEntityTemplate($a, $has_related = true)
        {

        // proper language
        $a->Name = $this->language == SECOND_LANGUAGE ? $a->title_en : $a->title; //

        // related single
        $artist = $this->fm->getArtistById($a->artist);
        if ($artist) {
            $artist->Name = $artist->first_name . $artist->last_name;
            $a->artist = $artist; //

            }

        // another table with multiple data
        $availability = $this->fm->getAvailabilityById($a->availability);
        if ($availability) {
            $availability->Name = $this->language == SECOND_LANGUAGE ? $availability->name_en : $availability->name; //
            $availability->Image = site_url() . 'items/uploads/images/frontend_image/' . $availability->image; //
            }
        $a->availability = $availability;


        // from same table related multiple
        $related_artworks = $this->fm->getRelatedArtworks($a->id);

        $related_artworks_array = array();
        foreach ($related_artworks as $i) {
            if ($i->artwork2_id != $i->artwork1_id) {
                // var_dump($i->artwork2_id);
                // // $item = $this->fm->getArtworkById($i->artwork2_id);
                // $artwork_item = $this->getArtworkInfo($item);
                // if($artwork_item){
                // $artwork_item->Name = $this->language == SECOND_LANGUAGE ? $artwork_item->title_en : $artwork_item->title;
                // $related_artworks_array[] = $artwork_item;
                //     }
                }
            }


        // from different table related multiple
        $related_projects = $this->fm->getRelatedProjectsForArtwork($a->id);
        $related_projects_array = array();
        foreach ($related_projects as $p) {
            $project = $this->fm->getProjectById($p->project_id);

            $project_item = $this->fm->getProjectArticle($project->id, );
            $project_item = $this->getArticleInfo($project_item, $a->id);


            $related_projects_array[] = $project_item;
            }

        $a->related_projects = $related_projects_array; //

        // var_dump($a);

        return $a;
        }



    public function getNormalInfo($a)
        {

        $a->color = $this->getColor($a->color);

        $tags_relation_array = $this->fm->getNormalTags($a->id);
        $a->normal_tags = $this->getGeneralTags($tags_relation_array);


        return $a;

        }


    public function getLocationInfo($a)
        {


        // location tags
        $tags = $this->fm->getLocationTags($a->id);

        $tags_array = array();

        if ($tags) {
            foreach ($tags as $tag) {
                $one_tag = $this->fm->getLocationTagById($tag->tag_id);
                if ($one_tag) {
                    $tags_array[] = $one_tag;
                    }
                }
            }

        $a->location_tags = $tags_array;


        return $a;
        }





    /**************************   EVENTS   *******************************/
    // getFutureEvents - get all future events of certain type
    // getEventsOfCategory - get all events of certain category
    // getFutureEvent - get future event from event item or returns false

    public function getFutureEvents($type_name)
        {
        $events = $this->getArticleGroup($type_name);

        foreach ($events as $item) {
            $future_event = $this->getFutureEvent($item);
            if ($future_event) {
                $final_events[] = $future_event;
                }
            }

        usort($final_events, function ($a, $b) {
            $a_date = new DateTime($a->entity->start_date);
            $b_date = new DateTime($b->entity->start_date);
            return $a_date <=> $b_date;
            });

        return $final_events;

        }

    public function getEventsOfCategory($group_items, $cat_id)
        {

        $final_group = array();
        foreach ($group_items as $item) {
            if (isset($item->entity) && $item->entity->category == $cat_id) {
                $final_group[] = $item;
                }
            }

        return $final_group;


        }


    public function getFutureEvent($event_item)
        {

        $e = $event_item->entity;

        $now = new DateTime();
        $event_date = new DateTime($e->start_date);

        if ($now->format('Y-m-d') <= $event_date->format('Y-m-d')) {
            return $event_item;
            } else {
            return false;
            }

        }


    /**************************    GENERAL INFO     *******************************/

    // getTeaserImages - get all teaser images for article
    // getCategoryInfo - get all info about category
    // getNormalInfo - get all info about normal item
    // getLocationInfo - get all info about location item


    public function addCategoryInfo($cat)
        {

        $teaser_images = $this->getTeaserImages();

        $cat->teaser_images = $teaser_images;

        $cat->color = $this->fm->getColorById($cat->color);

        return $cat;

        }


    public function getColor($color_id)
        {
        $hex = DEFAULT_COLOR;
        $color = $this->fm->get_color_by_id($color_id);
        if ($color) {
            $hex = $color->hex;
            }

        return $hex;
        }

    public function getGeneralTags($tag_relation_array)
        {
        $tags_array = array();

        if ($tag_relation_array) {
            foreach ($tag_relation_array as $tag) {
                $one_tag = $this->fm->getNormalTagById($tag->tag_id);
                if ($one_tag) {
                    $tags_array[] = $one_tag;
                    }
                }
            }

        return $tags_array;
        }

    /**************************    GROUP  DATA   *******************************/
    // getArticleGroupByType - get all articles of certain type
    // getArticleGroupFromArray - get all articles of certain type from array
    // getArticleGroupByCategory - get all articles of certain category
    // getArticlesInfo - get all info about items in array


    public function getArticleGroupByType($typeId, $items = array())
        {

        if (count($items) == 0) {
            $items = $this->getAllVisibleItems();
            $prepared_items = array();
            foreach ($items as $i) {
                $item = $this->getArticleInfo($i);
                if ($item) {
                    $prepared_items[] = $item;
                    }
                }
            } else {
            $prepared_items = $items;
            }


        $final_items = array();

        foreach ($prepared_items as $it) {
            if (isset($it->entity)):
                $entity = $it->entity;

                if ($entity->type == $typeId) {
                    $final_items[] = $it;
                    } else
                    return array();
            endif;
            }


        if (isset($final_items[0]->entity->ordering)) {
            usort($final_items, function ($a, $b) {
                $a_ordering = $a->entity->ordering ?? 0;
                $b_ordering = $b->entity->ordering ?? 0;
                return $a_ordering <=> $b_ordering;
                });
            }

        return $final_items;


        }


    public function getArticleGroupByCategory($categoryId, $items = array())
        {

        if (count($items) == 0) {
            $items = $this->getAllVisibleItems();
            $prepared_items = array();
            foreach ($items as $i) {
                $item = $this->getArticleInfo($i);
                if ($item) {
                    $prepared_items[] = $item;
                    }
                }
            } else {
            $prepared_items = $items;
            }


        $final_items = array();

        foreach ($prepared_items as $it) {
            if (isset($it->entity)):
                $entity = $it->entity;

                if ($entity->category == $categoryId) {
                    $final_items[] = $it;
                    } else
                    return array();
            endif;
            }

        // if ordering

        if (isset($final_items[0]->entity->ordering)) {
            usort($final_items, function ($a, $b) {
                $a_ordering = $a->entity->ordering ?? 0;
                $b_ordering = $b->entity->ordering ?? 0;
                return $a_ordering <=> $b_ordering;
                });
            }


        return $final_items;
        }

    public function getArticleGroupFromArray($array, $type_name, $id_name = 'id')
        {


        $final_group = array();
        foreach ($array as $p) {

            $article = $this->fm->getItemOfKindByEntityId($p->{$id_name}, $type_name);

            if ($article != false) {
                $article = $this->getArticleInfo($article, false);
                if ($article && !in_array($article, $final_group)) {
                    array_push($final_group, $article);
                    }
                }


            }


        return $final_group;


        }

    function getArticlesInfo($items)
        {
        if (is_array($items)) {
            foreach ($items as $item) {
                $item = $this->getArticleInfo($item);
                }
            return $items;
            } else {
            $items->tags = $this->fm->get_tags_by_item($items->id);
            $items->categories = $this->fm->get_categories_by_item($items->id);
            return $items;
            }
        }

    /**************************    RELATED SAFE      *******************************/


    public function getRelated($id, $related_table, $origin_table, $same = false)
        {
        $related = $this->fm->getRelatedModel($id, $related_table);

        $related_array = array();

        foreach ($related as $r) {
            if ($r->related_id1 != $id) {
                $searched_id = $r->related_id1;
                } else {
                $searched_id = $r->related_id2;
                }

            $related_item = $this->fm->getOneById($origin_table, $searched_id);
            if ($related_item && !in_array($related_item, $related_array)) {
                if (!($same && $r->related_id1 == $r->related_id2) && $related_item->id != $id && !in_array($related_item, $related_array)) {
                    $related_array[] = $related_item;
                    }
                }
            }


        return $related_array;
        }








    /**************************    SEARCH      *******************************/
    // search_item - search for term in item



    // searching for term in items modules and stating if it can be added
    function search_item($item, $term)
        {
        $can_add = false;
        $parent = PARENT_ARTICLE;
        $itemId = $item->id;

        $text_modules = $this->fm->getModuleTextByItemId($itemId, $parent)->result_array();
        $dropdown_modules = $this->fm->getModuleDropdownByItemId($itemId, $parent)->result_array();
        $headline_modules = $this->fm->getModulesHeadline($itemId, $parent)->result_array();
        $start_modules = $this->fm->getModulesStart($itemId, $parent)->result_array();
        $pdf_modules = $this->fm->getModulesPdf($itemId, $parent)->result_array();

        // search article main attributes
        if (stripos($item->name, $term) !== false) {
            $can_add = true;
            }
        /* if (stripos($item->subheader, $term) !== false) {
         $can_add = true;
         } */
        if (stripos($item->pretty_url, $term) !== false) {
            $can_add = true;
            }
        if (stripos($item->teaser_text, $term) !== false) {
            $can_add = true;
            }
        if (stripos($item->og_description, $term) !== false) {
            $can_add = true;
            }
        if (stripos($item->seo_description, $term) !== false) {
            $can_add = true;
            }
        if (stripos($item->date_added, $term) !== false) {
            $can_add = true;
            }

        // search article text modules

        foreach ($text_modules as $text_module) {
            if (stripos($text_module['content'], $term) !== false) {
                $can_add = true;
                }
            }


        foreach ($dropdown_modules as $dropdown_module) {
            if (stripos($dropdown_module['content'], $term) !== false) {
                $can_add = true;
                }
            if (stripos($dropdown_module['title'], $term) !== false) {
                $can_add = true;
                }
            if (stripos($dropdown_module['sub_title'], $term) !== false) {
                $can_add = true;
                }
            }


        foreach ($headline_modules as $headline_module) {
            if (stripos($headline_module['content'], $term) !== false) {
                $can_add = true;
                }
            }
        foreach ($start_modules as $start_module) {
            if (stripos($start_module['title'], $term) !== false) {
                $can_add = true;
                }
            if (stripos($start_module['sub_title'], $term) !== false) {
                $can_add = true;
                }
            if (stripos($start_module['content'], $term) !== false) {
                $can_add = true;
                }
            }

        foreach ($pdf_modules as $pdf_module) {
            if (stripos($pdf_module['title'], $term) !== false) {
                $can_add = true;
                }
            if (stripos($pdf_module['button_text'], $term) !== false) {
                $can_add = true;
                }

            /*  if ($pdf_module['fname'] != '') {
             $pdf_path = site_url('items/uploads/module_pdf/') . $pdf_module['fname'];
             $pdf_path = preg_replace("/ /", "%20", $pdf_path);
             $pdf_text = preg_replace("/\s\s+/", " ", $this->pdf2text($pdf_path));
             if (stripos($pdf_text, $term) !== false) {
             $can_add = true;
             }
             } */
            }

        return $can_add;
        }



    // get item information functions

    /**************************    SHOP INFO       *******************************/
    // getGlobalShopInfo - get all info about shop items

    function getGlobalShopInfo()
        {

        $data = array();

        $products = $this->fm->getProducts();

        foreach ($products as $p) {
            $p = $this->getArticleInfo($p);


            if ($p->publish_date) {

                $now = date(time());
                $article_publish = date(strtotime($p->publish_date));

                $publishing_day_already = $now >= $article_publish;
                } else {
                $publishing_day_already = false;
                }

            if ($publishing_day_already) {

                $p->published = true;
                } else {
                $p->published = false;
                }
            }


        $data['products'] = $products;


        return $data;


        }




    }