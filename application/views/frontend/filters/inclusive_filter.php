      <?

            // Getting possible options for filter
                $target_group_array = array();
                $event_categories_array = array();
                $event_locations_array = array();
                $event_exhibitions_array = array();


                foreach($event_array as $e){


                    $event_categories = $this->fm->getEventCategories($e->entity->id);
                    foreach($event_categories as $ec){
                        $cat = $this->fm->getEventCategoryById($ec->event_category_id);

                        if(!in_array($cat, $event_categories_array) && $cat){
                            $event_categories_array[] = $cat;
                        };
                    }

                    $target_groups = $this->fm->getEventTargetGroups($e->entity->id);
                    foreach($target_groups as $et){
                        $tg = $this->fm->getTargetGroupById($et->target_group_id);

                        if(!in_array($tg, $target_group_ar) && $tg){
                            $target_group_ar[] = $tg;
                        };
                    }

                    $loc = $this->fm->getLocationById($e->entity->location_id);

                    if(!in_array($loc, $event_locations_array) && $loc){
                        $event_locations_array[] = $loc;
                    }


                    $exh = $this->fm->getExhibitionById($e->entity->exhibition);

                    if(!in_array($exh, $event_exhibitions_array) && $exh ){
                        $event_exhibitions_array[] = $exh;
                    }
                }

                // Saving possible options for filter

                $data['event_categories'] = $event_categories_array;
                $data['event_locations'] = $event_locations_array;
                $data['event_exhibitions'] = $event_exhibitions_array;
                $data['target_groups_array'] = $target_group_ar;


                // Making array from GET filter values

                $categories = [];
                $locations = [];
                $exhibitions = [];
                $targets = [];
                $filter_text = "";

                if(isset($_GET['exhibition'])){
                    $exhibitions = explode(',', $_GET['exhibition']);
                }
                if(isset($_GET['location'])){
                    $locations = explode(',', $_GET['location']);
                }
                if(isset($_GET['target'])){
                    $targets = explode(',', $_GET['target']);
                }
                if(isset($_GET['category'])){
                    $categories = explode(',', $_GET['category']);
                }

                if(isset($_GET['text'])){
                  $filter_text = (isset($_GET['text']))? $_GET['text'] : "";
                }

                // not in array
                if(isset($_GET['date'])){
                    $s_date = $_GET['date'];

                    // saving selected date for view
                     $data['sel_date'] = $s_date;
                }


                // Saving array from GET filter values - for checkboxes on filter

                $data['sel_cat'] = $categories;
                $data['sel_exh'] = $exhibitions;
                $data['sel_loc'] = $locations;
                $data['sel_tg'] = $targets;
                $data['sel_text'] = $filter_text;


                // and filter
                $filtered_events = [];
                $filter = 0;
                foreach($event_array as $e) {

                    $can_add = false;
                    $event = $e->entity;

                     //check event title for text search
                     if($filter_text != '')
                     {
                       $event_title = ($this->language == SECOND_LANGUAGE)? $event->title_en : $event->title_de;

                        if (!str_contains(strtolower($event_title), strtolower($filter_text))) {

                         $can_add = false;
                       }
                     }


                   if(count($categories) > 0){
                        $found_matching = false;
                        $event_categories = $this->fm->getEventCategories($event->id);

                        foreach($event_categories as $ec){
                            if(in_array($ec->event_category_id, $categories))
                            {
                                $can_add = true;
                              break;
                            }
                        }

                    }

                    if(count($targets)){
                      $found_matching = false;
                      $target_groups = $this->fm->getEventTargetGroups($event->id);

                      foreach($target_groups as $et){
                          if(in_array($et->target_group_id, $targets))
                          {
                            $can_add = true;
                            break;
                          }
                      }


                    }

                    if(count($locations)){

                        if(in_array($event->location_id, $locations)){
                            $can_add = true;
                        }



                    }

                    if(count($exhibitions)){

                        if(in_array($event->exhibition, $exhibitions)){
                           $can_add = true;
                        }


                    }


                    //check if passed filters and not yet in the array
                    if($can_add && !in_array($e, $filtered_events)){
                        $filtered_events[] = $e;
                    }
                }

                // Sort it
                usort($filtered_events, function ($a, $b) {
                    return strtotime($a->start_date) - strtotime($b->start_date);
                });

                // Save to data
                $data['events'] = $filtered_events;
