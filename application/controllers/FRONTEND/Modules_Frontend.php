 <?

            //////////////// TO INCLUDE SOMEWHERE USE THIS ///////////

            // include(APPPATH . 'controllers/FRONTEND/Insert_Modules_Frontend.php');

            //////////////// NEED $parent and $itemId ///////////


            $data['modulesText'] = $this->fm->getModuleTextByItemId($itemId, $parent);
            $modulesCollapsable = $this->fm->getModuleCollapsableByItemId($itemId, $parent)->result_array();
            $data['modulesSectionTitle'] = $this->fm->getModuleSectionTitleByItemId($itemId, $parent);
            $data['modulesHr'] = $this->fm->getModuleHrByItemId($itemId, $parent);
            $data['modulesMarquee'] = $this->fm->getModuleMarqueeByItemId($itemId, $parent);
            $data['modulesQuote'] = $this->fm->getModuleQuoteByItemId($itemId, $parent);
            $data['modulesNews'] = $this->fm->getModuleNewsByItemId($itemId, $parent);
            $data['modulesDropdown'] = $this->fm->getModuleDropdownByItemId($itemId, $parent);
            $modulesDownload = $this->fm->getModuleDownloadByItemId($itemId, $parent)->result_array();
            $modulesImage = $this->fm->getModuleImageByItemId($itemId, $parent)->result_array();
            $data['modulesHTML'] = $this->fm->getModuleHTMLByItemId($itemId, $parent);
            $data['modulesVideo'] = $this->fm->getModuleVideoByItemId($itemId, $parent);
            $data['modulesHeadline'] = $this->fm->getModulesHeadline($itemId, $parent);
            $modulesPdf = $this->fm->getModulesPdf($itemId, $parent)->result_array();
            $modulesStart = $this->fm->getModulesStart($itemId, $parent)->result_array();
            $data['modulesNewsletter'] = $this->fm->getModulesNewsletter($itemId, $parent);
            $modulesGalleries = $this->fm->getModulesGallery($itemId, $db, $parent)->result_array();
            $modulesRelated = $this->fm->getModulesRelated($itemId, $db, $parent)->result_array();
            $modulesEvent = $this->fm->getModulesEvents($itemId, $db, $parent)->result_array();

            $data['modulesColumnStart'] = $this->fm->getModuleColumnStartByItemId($itemId, $parent);
            $data['modulesColumnEnd'] = $this->fm->getModuleColumnEndByItemId($itemId, $parent);


            /**********      DOWNLOAD MODULE       ************/

            $modulesCollapsableArray = array();

            foreach ($modulesCollapsable as $item) {
              $modulesCollapsableArray[] = $this->prepareModuleImages($item);
            }


            $files_modules_array = [];
            foreach ($modulesDownload as $p) :

                $files = array();
                $images = array();

               // FILES pdf or zip
               if($p['pdf']){
                $file = $this->fm->getFileById($p['pdf']);
                $files[] = $file;
               }

               if($p['file_tag']){
                $files = $this->fm->getFilesByTag($p['file_tag']);
               }

               // CLOUD PATH


              $p['files'] = $files;
              $p['images'] = $images;

              $files_modules_array[] = $p;
            endforeach;


            /**********      GALLERY MODULE       ************/

            $gallery_modules_array = array();
            foreach ($modulesGalleries as $gallery) {
              $gallery_modules_array[] = $this->prepareModuleImages($gallery);
            }

            $image_modules_array = array();
            foreach ($modulesImage as $item) {
             $image_modules_array[] = $this->prepareModuleImages($item);
            }





            /**********      MODULES START        ************/


            $data['modulesStart'] = array();
            foreach ($modulesStart as $item) {
                $item['alt'] = '';
                $item['credits'] = '';
                if ($item['repo_id'] != NULL) {
                    $repo_item = $this->fm->getPublicRepoItemById($item['repo_id']);

                    if ($repo_item != false) {

                        $item['header_img'] = $repo_item->fname;


                        if ($this->language == SECOND_LANGUAGE) {
                            $item['alt'] = $repo_item->alt_text_en;
                            $item['credits'] = $repo_item->credits_en;
                        } else {
                            $item['alt'] = $repo_item->alt_text;
                            $item['credits'] = $repo_item->credits;
                        }
                    }
                }
                $data['modulesStart'][] = $item;
            }





/******************************      RARE MODULES       ************/



           /**********      RELATED MODULE       ************/


        $related_modules_array = array();
        foreach ($modulesRelated as $rel) {
            $related_items_array = array();

            $rel_ids = $rel['rel_id'];
            $rel_ids_array = array_map('intval', explode(',', $rel_ids));

            $related_items_array = array();

            if ($rel['rel_type'] == 'tag') {
                foreach ($rel_ids_array as $rel_id) {
                    $related_items_array = $this->getRelatedItemsByNormalTag($rel_id);

                    }

                } elseif ($rel['rel_type'] == 'articles') {
                foreach ($rel_ids_array as $rel_id) {
                    $rel_article = $this->cm->getItemById($rel_id);

                    if ($rel_article != false) {
                        $rel_article = $this->getArticleInfo($rel_article);

                        if ($rel_article != false):

                            $related_items_array[] = $rel_article;
                        endif;
                        }
                    }

                }








            if ($rel['num_items'] != NULL && $rel['num_items'] != 0) {
                $related_items_array = array_slice($related_items_array, 0, $rel['num_items']);
                }

            $rel['related_items'] = $related_items_array;
            $related_modules_array[] = $rel;
            }

           /**********      EVENT MODULE       ************/

            $event_modules_array = array();
            foreach ($modulesEvent as $rel) {
                $event_items_array = array();

                if($rel['future_events'] == 0 || $article->type != ARTICLE_TYPE_EXHIBITION)
                {
                    $module_related_events = $this->fm->getEventTagModuleRelatedItems($rel['rel_id']);

                    foreach ($module_related_events as $ei) {

                        $rel_article = $this->fm->getEventArticle($ei['id']);

                        if($rel_article != false)
                        {
                            $ei['pretty_url'] = $rel_article->pretty_url;
                        }
                        else
                        {
                            $ei['pretty_url'] = '';
                        }

                        $ei['display_title'] = ($this->language == MAIN_LANGUAGE) ? $ei['name'] : $ei['name_en'];
                        $ei['display_subheader'] = ($this->language == MAIN_LANGUAGE) ? $ei['subheader'] : $ei['subheader_en'];
                        $ei['display_date'] = $ei['start_date'];


                        $event_items_array[] = $ei;
                    }


                    if($rel['num_items'] != NULL && $rel['num_items'] != 0)
                    {
                       $event_items_array = array_slice($event_items_array, 0, $rel['num_items']);
                    }

                    $rel['related_items'] = $event_items_array;
                    $event_modules_array[] = $rel;
                }
                else
                {


                    $start_date = date('Y-m-d', strtotime('-1 day', strtotime($article->exh->start_date_time)));

                    $module_related_events = $this->fm->getEventModuleFutureItems($start_date);
                    foreach ($module_related_events as $ei) {
                        $rel_article = $this->fm->getEventArticle($ei['id']);

                        if($rel_article != false)
                        {
                            $ei['pretty_url'] = $rel_article->pretty_url;
                        }
                        else
                        {
                            $ei['pretty_url'] = '';
                        }
                        // $ei['display_title'] = $ei['name'];
                        $ei['display_title'] = ($this->language == MAIN_LANGUAGE) ? $ei['name'] : $ei['name_en'];
                        $ei['display_subheader'] = $ei['subheader'];
                        $ei['display_date'] = $ei['start_date'];


                        $event_items_array[] = $ei;
                    }



                    $rel['related_items'] = $event_items_array;
                    $event_modules_array[] = $rel;
                }

            }

           /**********      ARTWORK MODULE       ************/


            // $artwork_modules_array = array();
            // foreach ($modulesArtworks as $module) {
            //     $artworks_holder = array();
            //     $artworks = $this->fm->getModulesArtworkItems($module['id'])->result_array();
            //     foreach ($artworks as $artwork) {

            //         $artwork_item = $this->fm->getArtworkByID($artwork['artwork_id']);
            //         if ($artwork_item != false) {
            //             $artwork_images = $this->fm->getArtworkImages($artwork_item->id);
            //             $artist = $this->fm->get_artist_by_id($artwork_item->artist);
            //             $artwork_item->images = $artwork_images;
            //             $artwork_item->artist = $artist;
            //             $artwork_item->artist_name = '';

            //             if ($artist != false) {
            //                 $artwork_item->artist_name = $artist->name;
            //             }

            //             $artworks_holder[] = $artwork_item;
            //         }
            //     }

            //     $module['artworks'] = $artworks_holder;
            //     $artwork_modules_array[] = $module;
            // }

            /**********      PDF MODULE       ************/


            $data['modulesPdf'] = array();
            foreach ($modulesPdf as $item) {
                $item['alt'] = '';
                $item['credits'] = '';
                if ($item['repo_id'] != NULL) {
                    $repo_item = $this->fm->getPublicRepoItemById($item['repo_id']);

                    if ($repo_item != false) {

                        $item['image'] = $repo_item->fname;


                        if ($this->language == SECOND_LANGUAGE) {
                            $item['alt'] = $repo_item->alt_text_en;
                            $item['credits'] = $repo_item->credits_en;
                        } else {
                            $item['alt'] = $repo_item->alt_text;
                            $item['credits'] = $repo_item->credits;
                        }
                    }
                }
                $data['modulesPdf'][] = $item;
            }


            $data['modules'] = array_merge(array(), $data['modulesText']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesSectionTitle']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesHr']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesMarquee']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesQuote']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesNews']->result_array());
            $data['modules'] = array_merge($data['modules'], $files_modules_array);
            $data['modules'] = array_merge($data['modules'], $modulesCollapsableArray);
            $data['modules'] = array_merge($data['modules'], $data['modulesDropdown']->result_array());
            $data['modules'] = array_merge($data['modules'], $image_modules_array);
            $data['modules'] = array_merge($data['modules'], $data['modulesHTML']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesVideo']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesHeadline']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesPdf']);
            $data['modules'] = array_merge($data['modules'], $data['modulesStart']);
            $data['modules'] = array_merge($data['modules'], $data['modulesNewsletter']->result_array());
            $data['modules'] = array_merge($data['modules'], $gallery_modules_array);
            $data['modules'] = array_merge($data['modules'], $related_modules_array);
            $data['modules'] = array_merge($data['modules'], $event_modules_array);
            $data['modules'] = array_merge($data['modules'], $data['modulesColumnStart']->result_array());
            $data['modules'] = array_merge($data['modules'], $data['modulesColumnEnd']->result_array());
            usort($data['modules'], function ($a, $b) {
                return $a['top'] <=> $b['top'];
            });

            function getRelatedItemsByTag($tag_id)
            {

                $article_type = $this->getArticleTypeId('normals');

                $articles = $this->fm->getArticlesByTag($tag_id, $article_type);

                return $articles;
            }