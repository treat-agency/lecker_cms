<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Helper_Frontend
{



    function getVisibleEvent($event)
    {
        $show_event = false;
        $visible_start = false;
        $visible_end = false;

        if ($event->visible_start != NULL && $event->visible_start != '') {
            $visible_start = $event->visible_start;
        }

        if ($event->visible_end != NULL && $event->visible_end != '') {
            $visible_end = $event->visible_end;
        }



        if ($visible_start != false && $visible_end != false) {
            $now = new DateTime();
            $start = new DateTime($visible_start);
            $end = new DateTime($visible_end);

            $time_now = date('H:i');

            $time_start = $event->visible_start_time ?? '';



            if ($start <= $now && $now <= $end && $event->visible == 1) {
                $show_event = true;

                // if time specified, check also for time
                if ($time_start != '') {


                    $time_now = DateTime::createFromFormat('H:i', $time_now);

                    $time_start = DateTime::createFromFormat('H:i', $time_start);

                    if (($time_now && $time_start) && $time_now->format('H:i') < $time_start->format('H:i')) {
                        $show_event = false;
                    }

                }
            }
        } else {
            if ($event->visible == 1) {
                $show_event = true;
            }
        }

        if ($show_event == true) {
            return $event;
        } else {
            return false;
        }

    }





    //    public function reportPageviewToGoogleAnalytics($viewId = GA_VIEW_ID2)
// {
//     // Creates and returns the Analytics Reporting service object.

//     // Use the developers console and download your service account
//     // credentials in JSON format. Place them in this directory or
//     // change the key file location if necessary.
//     $KEY_FILE_LOCATION = getcwd() . '/items/frontend/js/ga_credentials.json';

//     // Create and configure a new client object.
//     $client = new Google_Client();
//     $client->setApplicationName("Google Analytics Homepage");
//     $client->setAuthConfig($KEY_FILE_LOCATION);
//     $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
//     $analytics = new Google_Service_AnalyticsReporting($client);

//     // Create the DateRange object.
//     $dateRange = new Google_Service_AnalyticsReporting_DateRange();
//     $dateRange->setStartDate("2023-01-01");
//     $dateRange->setEndDate("today");

//     // Create the Metrics object.
//     $pageviews = new Google_Service_AnalyticsReporting_Metric();
//     $pageviews->setExpression("ga:pageviews");
//     $pageviews->setAlias("pageviews");

//     // Create the ReportRequest object.
//     $request = new Google_Service_AnalyticsReporting_ReportRequest();
//     $request->setViewId($viewId);
//     $request->setDateRanges([$dateRange]);
//     $request->setMetrics([$pageviews]);

//     $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
//     $body->setReportRequests([$request]);

//     $response = $analytics->reports->batchGet($body);

//     // Send the pageview data to YOUR_MEASUREMENT_ID using YOUR_API_SECRET
//     $measurementId = GA_MEASUREMENT;
//     $apiSecret = GA_API_SECRET;
//     $data = array(
//         "measurement_id" => $measurementId,
//         "data" => array(
//             "pageviews" => $response->getReports()[0]->getData()->getTotals()[0]->getValues()[0]
//         )
//     );
//     $data_string = json_encode($data);

//     $ch = curl_init('https://api.your-analytics-provider.com/v1/data');
//     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//         'Content-Type: application/json',
//         'Content-Length: ' . strlen($data_string),
//         'Authorization: Bearer ' . $apiSecret
//     ));

//     $result = curl_exec($ch);
//     curl_close($ch);

//     return $response;
// }





    public function googleAnalytics($analytics)
    {

        // Get the current URL of the page
        $currentUrl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $viewId = 'ga:' . GA_VIEW_ID;

        // Create a new pageview hit
        $pageview = new Google_Service_AnalyticsReporting_Pageview();
        $pageview->setPagePath($currentUrl);

        // Create a new session
        $session = new Google_Service_AnalyticsReporting_Session();
        $session->setUserAgentOverride($_SERVER['HTTP_USER_AGENT']);

        // Create a new hit
        $hit = new Google_Service_AnalyticsReporting_Hit();
        $hit->setPageview($pageview);
        $hit->setSession($session);

        // Create a new request
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($viewId);
        $request->setDateRanges(
            array(
                new Google_Service_AnalyticsReporting_DateRange(
                    array(
                        'startDate' => '7daysAgo',
                        'endDate' => 'today'
                    )
                )
            )
        );
        $request->setMetrics(
            array(
                new Google_Service_AnalyticsReporting_Metric(
                    array(
                        'expression' => 'ga:pageviews'
                    )
                )
            )
        );
        $request->setDimensionFilterClauses(
            array(
                new Google_Service_AnalyticsReporting_DimensionFilterClause(
                    array(
                        'filters' => array(
                            new Google_Service_AnalyticsReporting_DimensionFilter(
                                array(
                                    'dimensionName' => 'ga:pagePath',
                                    'operator' => 'EXACT',
                                    'expressions' => array($currentUrl)
                                )
                            )
                        )
                    )
                )
            )
        );
        $request->setIncludeEmptyRows(true);
        $request->setPageSize(1);

        // Send the hit to Google Analytics
        $response = $analytics->reports->batchGet(
            array(
                'reportRequests' => array($request)
            )
        );

        // Check if the hit was successful
        if ($response->reports[0]->data->rowCount > 0) {
            // var_dump($response->reports[0]->data->rowCount);
            // The pageview was successfully tracked
        } else {
            // The pageview was not tracked
        }
    }

    // public function getFirstProfileId($analytics)
    // {

    //     var_dump($analytics);
    //     // Get the user's first view (profile) ID.

    //     // Get the list of accounts for the authorized user.
    //     $accounts = $analytics->management_accounts->listManagementAccounts();

    //     if (count($accounts->getItems()) > 0) {
    //         $items = $accounts->getItems();
    //         $firstAccountId = $items[0]->getId();

    //         // Get the list of properties for the authorized user.
    //         $properties = $analytics->management_webproperties
    //             ->listManagementWebproperties($firstAccountId);

    //         if (count($properties->getItems()) > 0) {
    //             $items = $properties->getItems();
    //             $firstPropertyId = $items[0]->getId();

    //             // Get the list of views (profiles) for the authorized user.
    //             $profiles = $analytics->management_profiles
    //                 ->listManagementProfiles($firstAccountId, $firstPropertyId);

    //             if (count($profiles->getItems()) > 0) {
    //                 $items = $profiles->getItems();

    //                 // Return the first view (profile) ID.
    //                 return $items[0]->getId();

    //             } else {
    //                 throw new Exception('No views (profiles) found for this user.');
    //             }
    //         } else {
    //             throw new Exception('No properties found for this user.');
    //         }
    //     } else {
    //         throw new Exception('No accounts found for this user.');
    //     }
    // }

    public function getResults($analytics, $profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '7daysAgo',
            'today',
            'ga:sessions'
        );
    }

    public function printResults($results)
    {
        // Parses the response from the Core Reporting API and prints
        // the profile name and total sessions.
        if (count($results->getRows()) > 0) {

            // Get the profile name.
            $profileName = $results->getProfileInfo()->getProfileName();

            // Get the entry for the first entry in the first row.
            $rows = $results->getRows();
            $sessions = $rows[0][0];

            // Print the results.
            print "First view (profile) found: $profileName\n";
            print "Total sessions: $sessions\n";
        } else {
            print "No results found.\n";
        }
    }


    /**************************    JAVASCRIPT RETURN     *******************************/




    public function get_events_with_js_return()
    {

        $clickedDate = $_POST['date'];

        $currEvents = $this->fm->getEventsForDay($clickedDate);

        // var_dump($currEvents);

        foreach ($currEvents as $event) {
            $event_article = $this->fm->getEventArticle($event->id);
            $category = $this->fm->get_event_category_by_id($event->category_id);
            $event->category = "";
            if ($category != false) {
                $event->category = ($this->language == MAIN_LANGUAGE) ? $category->name : $category->name_en;
            }

            $event->pretty_url = '';
            if ($event_article != false) {
                $event->pretty_url = $event_article->pretty_url;
            }
        }

        $locale = 'de_DE';

        if($this->language == SECOND_LANGUAGE)
        {
            $locale = 'en_US';
        }


        $cdate = new \DateTime($clickedDate);

        $formatted_date = datefmt_create(
            $locale,
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            'Europe/Vienna',
            IntlDateFormatter::GREGORIAN,
            'EEEE dd.MM.yyyy'
            );

        //echo json_encode(array('current_date' => strftime('%A, %d.%m.%Y', strtotime($clickedDate)), 'items' => $currEvents));
        echo json_encode(array('current_date' => datefmt_format($formatted_date, $cdate), 'items' => $currEvents));
    }






		/**************************    FILTERS TEMPLATES       *******************************/

     public function js_filter() {
        $data = array();

        $data = array();
        $target_groups = array();
        $topics = array();
        $months = array();
        $webinar_articles = $this->fm->getWebinarArticles();


        foreach($webinar_articles as $w){
            $webinar = $this->fm->getWebinarById($w->webinar);
            $webinar = $this->getWebinarInfo($webinar);
            if($webinar){
            foreach($webinar->target_groups as $t){
                $target_group = array('key' => $t->id, 'value' => $t->display_name);
                if(!in_array($target_group, $target_groups)){
                    $target_groups[] = $target_group;

                }
            }

            // $webinar->Month = explode(' ', $webinar->Date)[0];

            if(!in_array($webinar->Month, $months)){
                $months[] = $webinar->Month;
            }

            foreach($webinar->topics as $t){
                $topic = array('key' => $t->id, 'value' => $t->display_name);
                if(!in_array($topic, $topics)){
                    $topics[] = $topic;
                }
            }

            $w->entity = $webinar;
            $webinars_array[] = $w;
            }
        }

         usort($webinars_array,function($first,$second){

               return $first->entity->date <=> $second->entity->date;
         });


        $data['webinars'] = $webinars_array;
        $data['months'] = $months;
        $data['target_groups'] = $target_groups;
        $data['topics'] = $topics;

        $this->load_view('frontend/tools/jsfilter', $data);

    }

      public function get_filter() {
        // filter_get

        $data = array();


        $artwork_articles = $this->fm->getArtworks();

        $artwork_article_array = array();
        $artwork_names = array();


        $prices = array();
        $mediums = array();
        $artists = array();
        $eras = array();
        $availabilities = array();

        $availabilities_count = array();
        $artists_count = array();
        $eras_count = array();
        $mediums_count = array();

        $minPrice = -1;
        $maxPrice = -1;

        // getting data for filter selectors
        foreach($artwork_articles as $i){
             $a = $this->getArtworkInfo($i);

             if($minPrice == -1) {
                 $minPrice = $a->price;
             } else {
                 if($a->price < $minPrice) {
                    $minPrice = $a->price;
                 }
             }

             if($maxPrice == -1) {
                 $maxPrice = $a->price;
             } else {
                 if($a->price > $maxPrice) {
                    $maxPrice = $a->price;
                 }
             }




             $artwork_names[] = array('key' => $a->id, 'value' => $a->Name);
             $artwork_article_array[] = $a;


            $e = $a;


            if(!in_array($e->price, $prices)){
                $prices[] = $e->price;
            }

            if(count($prices)){
            usort($prices,function($first,$second){
                return $first <=> $second;
            });
            }

            foreach($e->related_mediums as $m){
                if($m){
                $mediums_count[] = $m->id;

                if(!in_array($m, $mediums)){
                    // ->Name
                    $mediums[] = $m;
                }
                }

            }

            $artist = $e->artist;
            if($artist){
                $artists_count[] = $e->artist->id;
                if(!in_array($artist, $artists)){
                    $artists[] = $artist;

                }
            }

            $availability = $e->availability;
            if($availability){
                $availabilities_count[] = $e->availability->id;
                if(!in_array($availability, $availabilities)){
                    // ->Name
                    $availabilities[] = $availability;
                }
                // else {
                //     $this->addCountToFilter($availabilities, $availability);

                // }
            }


            foreach($e->eras as $e){
                if($e){

                    $eras_count[] = $e->id;

                    if(!in_array($e, $eras)){
                    // ->Name
                    $eras[] = $e;
                // } else {
                //     $this->addCountToFilter($eras, $e);
                // }
                    }
                }

            }

        }

        $data['artwork_names'] = $artwork_names;


        $availabilities_count = array_count_values($availabilities_count);
        $artists_count =  array_count_values($artists_count);
        $eras_count =  array_count_values($eras_count);
        $mediums_count =  array_count_values($mediums_count);

        // all filters

        $mediums_f = [];
        $artists_f = [];
        $availabilities_f = [];
        $eras_f = [];

        foreach($mediums as $m){
            $m->Count = $mediums_count[$m->id];
            $mediums_f[] = $m;
        }
        foreach($eras as $m){
            $m->Count = $eras_count[$m->id];
            $eras_f[] = $m;

        }
        foreach($artists as $m){
            $m->Count = $artists_count[$m->id];
            $artists_f[] = $m;

        }
        foreach($availabilities as $m){
            $m->Count = $availabilities_count[$m->id];
            $availabilities_f[] = $m;
        }

        $data['prices'] = $prices;
        $data['mediums'] = $mediums_f;
        $data['artists'] = $artists_f;
        $data['availabilities'] = $availabilities_f;
        $data['eras'] = $eras_f;


        // selected filters
        $mediums_filter = [];
        $availabilities_filter = [];
        $eras_filter = [];
        $artists_filter = [];
        // $prices_filter = [];
        $priceLow_filter = "";
        $priceHigh_filter = "";

        // var_dump($minPrice);
        // var_dump($maxPrice);


        // if(isset($_GET['price'])){
        //     $prices_filter = explode(',', $_GET['price']);
        // }
        if(isset($_GET['priceLow'])){
            $priceLow_filter = $_GET['priceLow'];
        } else {
            $priceLow_filter = $minPrice;
        }

        if(isset($_GET['priceHigh'])){
            $priceHigh_filter = $_GET['priceHigh'];
        } else {
            $priceHigh_filter = $maxPrice;
        }

        if(isset($_GET['medium'])){
            $mediums_filter = explode(',', $_GET['medium']);
        }
        if(isset($_GET['artist'])){
            $artists_filter = explode(',', $_GET['artist']);
        }
        if(isset($_GET['availability'])){
            $availabilities_filter = explode(',', $_GET['availability']);
        }
        if(isset($_GET['era'])){
            $eras_filter = explode(',', $_GET['era']);
        }


        $data['sel_priceLow'] = $priceLow_filter;
        $data['sel_priceHigh'] = $priceHigh_filter;

        $data['sel_medium'] = $mediums_filter;
        $data['sel_artist'] = $artists_filter;
        $data['sel_availability'] = $availabilities_filter;
        $data['sel_era'] = $eras_filter;


        // and filter
        $filtered_artworks = [];
        $filter = 0;
        foreach($artwork_article_array as $a){

            $can_add = true;

            $e = $a;


            // if(!($e->price >= $priceLow_filter && $e->price <= $priceHigh_filter)) {
            //     // $filtered_artworks[] = $a;
            //     // $filter = 1;
            //     $can_add = false;
            //     break;

            // }

            // if(count($prices_filter)){
            //     if($e->price <= $prices_filter[1] && $e->price >= $prices_filter[0] && !in_array($a, $filtered_artworks)){
            //         $filtered_artworks[] = $a;
            //     }

            // }

            // if(count($mediums_filter)){

            //     foreach($e->related_mediums as $rm){
            //         if(in_array($rm->id, $mediums_filter) && !in_array($a, $filtered_artworks))
            //         $filtered_artworks[] = $a;
            //     }
            //     $filter = 1;

            // }

            // if(count($eras_filter)){

            //     foreach($e->eras as $er){
            //         if(in_array($er->id, $eras_filter) && !in_array($a, $filtered_artworks))
            //         $filtered_artworks[] = $a;
            //     }
            //     $filter = 1;

            // }

            // if(count($availabilities_filter)){

            //         if(in_array($e->availability->id , $availabilities_filter) && !in_array($a, $filtered_artworks))
            //         $filtered_artworks[] = $a;
            //     $filter = 1;

            // }

            // if(count($artists_filter)){

            //     $artist_id = '';

            //     if(!is_string($e->artist) && $e->artist){
            //         $artist_id = $e->artist->id;
            //         if(in_array($artist_id, $artists_filter) && !in_array($a, $filtered_artworks)){
            //         $filtered_artworks[] = $a;
            //         $filter = 1;
            //         }
            //     }

            // }



            if($e->price < $priceLow_filter) {
                $can_add = false;
            }
            if($e->price > $priceHigh_filter) {
                $can_add = false;
            }

            if(count($mediums_filter)){
                $inMedium = false;
                foreach($e->related_mediums as $rm){
                    if(in_array($rm->id, $mediums_filter)) {
                        $inMedium = true;
                    }
                }

                if(!$inMedium) {
                    $can_add = false;
                }


            }


            if(count($eras_filter)){
                $inEra = false;
                    foreach($e->eras as $er){
                        // var_dump($er);

                        if(in_array($er->id, $eras_filter)) {
                            $inEra = true;
                        }
                    }

                if(!$inEra) {
                    $can_add = false;
                }
            }


            if(count($availabilities_filter)){

                if(!in_array($e->availability->id , $availabilities_filter)) {
                    $can_add = false;
                }

            }


            if(count($artists_filter)){

                $artist_id = '';

                if(!is_string($e->artist) && $e->artist){
                    $artist_id = $e->artist->id;
                    if(!in_array($artist_id, $artists_filter)){
                        $can_add = false;
                    }
                }

            }


            if($can_add == true){
              $filtered_artworks[] = $a;
            }


        }

        // var_dump($filtered_artworks);

        // if no filter selected
        //    if($filter == 0) {
        //     $filtered_artworks = $artwork_article_array;
        //   }


        $data['artwork_articles'] = $filtered_artworks;


        $this->load_view('frontend/tools/query_filter', $data);


    }



    public function get_filters_for($type, $items)
    {
        $filters = array();

        $filters['Category'] = array();
        $stay_uniqe_g = array();


        // general filters
        foreach ($items as $item) {

            $cats = $this->fm->get_categories_by_item($item->id);
            foreach ($cats as $cat) {

                if (!in_array($cat->id, $stay_uniqe_g) && $cat->name != 'PROJECTS' && $cat->name != 'CASESTUDIOS') {
                    $stay_uniqe_g[] = $cat->id;

                    $filters['Category'][] = [
                        'filter_name' => $cat->name,
                        'filter_id' => $cat->id,
                    ];
                }
            }
        }


        // case studios
        if ($type == 'CS') {

            $stay_uniqe_1 = array();
            $stay_uniqe_1m = array();
            $stay_uniqe_1h = array();
            $stay_uniqe_1e = array();
            $filters['Genre'] = array();
            $filters['Medium'] = array();
            $filters['Metadata'] = array();
            $filters['Subject'] = array();

            foreach ($items as $item) {
                $cats = $this->fm->get_categories_by_item($item->id);

                foreach ($cats as $cat) {
                    if (!in_array($cat->id, $stay_uniqe_g) && $cat->name != 'PROJECTS' && $cat->name != 'CASESTUDIOS' && $cat->name != 'LANDING PAGE' && $cat->name != 'WUNDERKAMMER') {
                        $stay_uniqe_g[] = $cat->id;
                        $filters['Category'][] = [
                            'filter_name' => $cat->name,
                            'filter_id' => $cat->id,
                        ];
                    }
                }

                if ($item->item_case_studio != false) {
                    $genre = $item->item_case_studio->genre;
                    if (!in_array($genre, $stay_uniqe_1) && $genre != 'NONE') {
                        $stay_uniqe_1[] = $genre;

                        $filters['Genre'][] = [
                            'filter_name' => $genre,
                            'filter_id' => $genre,
                        ];
                    }
                    $mediums = $item->item_case_studio->mediums;
                    foreach ($mediums as $medium) {
                        if (!in_array($medium->id, $stay_uniqe_1m)) {
                            $stay_uniqe_1m[] = $medium->id;
                            $filters['Medium'][] = [
                                'filter_name' => $medium->name,
                                'filter_id' => $medium->id,
                            ];
                        }
                    }

                    $metadatas = $item->item_case_studio->metadata;
                    foreach ($metadatas as $metadata) {
                        if (!in_array($metadata->id, $stay_uniqe_1h)) {
                            $stay_uniqe_1h[] = $metadata->id;
                            $filters['Metadata'][] = [
                                'filter_name' => $metadata->name,
                                'filter_id' => $metadata->id
                            ];
                        }
                    }

                    $subjects = $item->item_case_studio->subjects;
                    foreach ($subjects as $subject) {
                        if (!in_array($subject->id, $stay_uniqe_1e)) {
                            $stay_uniqe_1e[] = $subject->id;
                            $filters['Subject'][] = [
                                'filter_name' => $subject->name,
                                'filter_id' => $subject->id,
                            ];
                        }
                    }
                };
            }
        } else if ($type == 'projects') {  // filters for the projects articles

            $stay_uniqe_2 = array();
            $filters['Country'] = array();
            $filters['Type'] = array();
            $filters['Stage'] = array();
            $filters['Date'] = array();

            $max_date = 0;
            $min_date = 99999;

            foreach ($items as $item) {

                if ($item->item_project != false) {
                    $project = $item->item_project;

                    $country = $project->country;
                    if (!in_array($country, $stay_uniqe_2) && $country != '' && $country != 'NONE') {
                        $stay_uniqe_2[] = $country;

                        $filters['Country'][] = [
                            'filter_name' => $country,
                            'filter_id' => $country,
                        ];
                    }

                    $type = $project->type;
                    if (!in_array($type, $stay_uniqe_2) && $type !== '0' && $type != 'NONE' && $type != '') {
                        $stay_uniqe_2[] = $type;

                        $filters['Type'][] = [
                            'filter_name' => $type,
                            'filter_id' => $type,
                        ];
                    }

                    /* $stage = $project->stages;
                    if (!in_array($stage, $stay_uniqe_2) && $stage !== '0' && $stage != 'NONE'&& $stage != '') {
                        $stay_uniqe_2[] = $stage;

                        $filters['Stage'][] = [
                            'filter_name' => $stage,
                            'filter_id' => $stage,
                        ];
                    } */

                    $dates = [$project->period_start, $project->period_end, $project->design_date_start, $project->design_date_end, $project->realisation_date_start, $project->realisation_date_end];

                    foreach ($dates as $date) {
                        if (!in_array($date, $stay_uniqe_2) && $date != '') {
                            $stay_uniqe_2[] = $date;
                            $date_1 =  $date;

                            if ($date_1 < $min_date) {
                                $min_date = $date;
                            }

                            if ($date_1 > $max_date) {
                                $max_date = $date;
                            }
                        }
                    }
                };
            }

            $filters['Date'] = [
                'max_date' => $max_date,
                'min_date' => $min_date,
            ];
        } else if ($type == 'news') {  // filters for the projects articles

            $stay_uniqe_3 = array();
            $filters['Category'] = array();

            foreach ($items as $item) {
                if ($this->session->userdata('front_logged_in') == 1 || $item->logged_in == 0) {

                    $cats = $this->fm->get_categories_by_item($item->id);
                    foreach ($cats as $cat) {

                        if (!in_array($cat->id, $stay_uniqe_3) && $cat->name != 'PROJECTS' && $cat->name != 'CASESTUDIOS' && $cat->name != 'LANDING PAGE' && $cat->name != 'WUNDERKAMMER') {
                            $stay_uniqe_3[] = $cat->id;

                            $filters['Category'][] = [
                                'filter_name' => $cat->name,
                                'filter_id' => $cat->id,
                            ];
                        }
                    }
                }
            };

            if (count($filters['Category']) < 2) {
                $filters['Category'] = array();
            };
        } else if ($type == 'shop') {  // filters for the projects articles

            $stay_uniqe_4 = array();
            $filters['Category'] = array();

            foreach ($items as $item) {
                if ($this->session->userdata('front_logged_in') == 1 || $item->logged_in == 0) {

                    $cats = $this->fm->get_categories_by_item($item->id);
                    foreach ($cats as $cat) {

                        if (!in_array($cat->id, $stay_uniqe_4) && $cat->name != 'Shop' && $cat->name != 'OVR' && $cat->name != 'Landing page' && $cat->name != 'Exhibitions') {
                            $stay_uniqe_4[] = $cat->id;

                            $filters['Category'][] = [
                                'filter_name' => $cat->name,
                                'filter_id' => $cat->id,
                            ];
                        }
                    }
                }
            };

            if (count($filters['Category']) < 2) {
                $filters['Category'] = array();
            };
        } else {
            return false;
        }

        return $filters;
    }



      /**************************    IMAGE       *******************************/


    public function getArtworkZoom()
    {
        $artwork_id = $_POST['aid'];
        $ordering = $_POST['ordering'];

        $prev_ordering = $ordering - 1;
        $next_ordering = $ordering + 1;

        $prev = $this->fm->getArtworkZoom($artwork_id, $prev_ordering);
        $current = $this->fm->getArtworkZoom($artwork_id, $ordering);
        $next = $this->fm->getArtworkZoom($artwork_id, $next_ordering);

        $response = array('prev' => $prev, 'current' => $current, 'next' => $next);

        echo json_encode($response);
    }


      public function upload_image()
    {
        $this->load->helper('besc_helper');

        $filename = $_POST['filename'];
        $upload_path = '/items/uploads/images/';
        if (substr($upload_path, -1) != '/') {
            $upload_path .= '/';
        }

        $rnd = rand_string(12);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $serverFile = time() . "_dz_" . $rnd . "." . $ext;

        $image = getcwd() . $upload_path . $serverFile;

        $error = move_uploaded_file($_FILES['data']['tmp_name'], $image);

        if ($ext != 'gif') {
            resize_max($image, 1000, 1000);
        }

        echo json_encode(array(
            'success' => true,
            'path' => "$upload_path/$serverFile",
            'filename' => $serverFile
        ));
    }

        public function dropzone()
    {
        $img = $_POST['file'];
    }


    public function replace_img()
    {
        if ($this->session->userdata('front_logged_in')) {

            $id = $_POST['id'];
            $fname = $_POST['fname'];
            $iid = $this->fm->replace_img($id, $fname);
            echo json_encode(array('status' => 'success'));
        } else {
            echo 'login';
        }
    }


      /**************************    COOKIES       *******************************/


    public function set_cookie($name, $val)
    {

        $cookie = array(
            'name' => $name,
            'value' => $val,
            'expire' => '86500',
            'path' => '/',
            'prefix' => '',
            'secure' => TRUE
        );
        $this->input->set_cookie($cookie);
    }


  public function saveCookie()
    {
        $cookie_mark = $_POST['cookie_mark'];
        $cookie_warning = $_POST['cookie_warning'];

        $this->set_cookie('cookie_warning', $cookie_warning);
        $this->set_cookie('cookie_mark', $cookie_mark);
    }

          /**************************    MAIL       *******************************/


      public function send_internal_email($data)
    {

        require_once(APPPATH . "libraries/phpmailer/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $mail->SMTPDebug = 0; // prefix for secure protocol to connect to the server
        $mail->Host = "mta.it-tects.at"; // setting SMTP server
        $mail->Port = 25; // SMTP port to connect to
        $mail->Username = "service/trt"; // user email address
        $mail->Password = "sbqhbSF3bwcBfBeOEs0iXhVq"; // password
        $mail->SMTPAuth = true; // enabled SMTP authentication
        $mail->SMTPSecure = "tls"; // prefix for secure protocol to connect to the server


        $mail->SetFrom('noreply@treat.agency', 'Noreply'); //Who is sending the email
        $mail->AddReplyTo("noreply@treat.agency"); //email address that receives the response


        // $mail->addBcc("istvan@treat.agency");
        $mail->IsSMTP();

        $subject = 'New member registered';

        $body = $this->load->view('mail/internal_email', $data, true);


        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        $email = 'sameh@treat.agency';
        // $email = 'gaisberger@salzburger-kunstverein.at';
        $mail->AddAddress($email, '');



        if (!$mail->Send()) {
            /*  return 'E-mail could not be sent, please check the provided email is valid.'; */
            return 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return 'ok';
        }
    }



    public function add_to_mailchimp()
    {
        $list_id = '4fd6354402';
        $key = 'us6';
        $authToken = '13a99a5611e5f01a107ca3907d7f3926-us6';
        $email = $_POST['email'];
        // The data to send to the API
        $postData = array(
            "email_address" => $email,
            "status" => "pending",
        );

        // Setup cURL
        $ch = curl_init('https://' . $key . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: apikey ' . $authToken,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        // Send the request
        $response = curl_exec($ch);

        echo ($response);
    }

    public function addToMailchimp($email, $firstname, $lastname)
    {
        $apiKey = 'YOUR_API_KEY'; // your Mailchimp API key (https://mailchimp.com/help/about-api-keys/)
        $listId = 'YOUR_AUDIENCE_ID'; // your Mailchimp list/audience ID (https://mailchimp.com/help/find-audience-id/)

        $memberId = md5(strtolower($email));
        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed', // options: "subscribed", "unsubscribed", "cleaned", "pending"
            'merge_fields'  => [
                'FNAME'     => $firstname,
                'LNAME'     => $lastname
            ]
        ]);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // print_r($result); // for debugging
    }


    /**************************    SEARCH HELPER       *******************************/


    // getting text around search term
    function getResultSearchString($item, $search_term)
    {
        // getting string around
        $position = stripos($item->content, $search_term);
        $length = strlen($item->content);
        $word_length = strlen($search_term);

        $content = strip_tags($item->content);
        $content = trim($content, " \t\n\r\0\x0B\xC2\xA0");



        $position_start = $position - 3;
        if ($position > 50) {
            $position_start = $position - 50 - 3;
        }




        $position_end = $word_length + 3;

        if (($length - $position) > 50) {
            $position_end = $word_length + 100;
        }


        $endofword = $position + $word_length + 3;


        $string = substr($content, $position_start, $position_end);
        $result_string = '...' . $string . '...';

        $bold = '<b class="searchHighlight">' . $search_term . '</b>';
        $pos_in_substr = stripos($result_string, $search_term);


        $result_string = substr_replace($result_string, $bold, $pos_in_substr, strlen($search_term));

        return $result_string;
    }


    // saving search term
    public function search_save($tag_id = false)
    {


        $input_val = $_POST['input_val'];

        if ($this->language == SECOND_LANGUAGE) {
            $existing_search = $this->fm->getSearchByNameEn($input_val);
        } else {
            $existing_search = $this->fm->getSearchByName($input_val);
        }

        if ($existing_search) {
            $this->fm->updateSearch($existing_search);
        } else {
            if ($this->language == SECOND_LANGUAGE) {
                $this->fm->addSearchEn($input_val);
            } else {
                $this->fm->addSearch($input_val);
            }
        }


    }

}
