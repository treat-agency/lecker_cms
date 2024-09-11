<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Pages_Frontend
{

      /**************************    LANDING PAGE       *******************************/
    public function phpInfo () {
        phpinfo();
    }

    public function openai_controller()
    {
        $promt = $_POST['openai_prompt'];


        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => 'Writing 3 different funny words for ' . $promt],
            ],
            'temperature' => 1.0, // 0 = no creativity, 1 = a lot of creativity
            'max_tokens' => 150, // size of the response
            'frequency_penalty' => 0, // increases word repetition
            'presence_penalty' => 0, // encourages model to talk about new topics (0 = no penalty)
        ]);



        // Get Answer
        $answer = $result->choices[0]->message->content;

        if($answer != false){
            echo json_encode(array("success" => true, "answer" => $answer));

        } else {
            echo json_encode(array("success" => false));
        }

    }

    public function openai_view (){
        $data = array();
        $this->load_view('frontend/tools/openai_view', $data);

    }





  public function index($tag_id = false)
    {


        $data = array();
        $data['page_title'] = SITE_NAME;

        // $report = $this->GA_Analytics_Cities();



        // phpinfo();
        // $report = $this->reportPageviewToGoogleAnalytics(GA_VIEW_ID2);


        // $analytics = $this->initializeAnalytics();
        // $ga = $this->googleAnalytics($analytics);
        // $profile = $this->getFirstProfileId($analytics);
        // $results = $this->getResults($analytics, $profile);
        // $this->printResults($results);


        /*****   LANDING PAGE INFO   *****/

        $data['lpSettings'] = $this->fm->getLandingPageData();

        /*****   SHOP INFO   *****/

        if(IS_SHOP == 1):

        $shopInfo = $this->getGlobalShopInfo();
        foreach($shopInfo as $key=>$value){
            $data[$key] = $value;
        }

        endif;

        $this->load_view('frontend/home', $data);
    }




    /**************************    CATEGORY PAGE       *******************************/


    public function programme($pretty_url)
    {
        $data = array();

        //
        $eventCategory = $this->fm->getEventCategoryByPrettyURL($pretty_url);

        $data['eventCategory'] = $this->getCategoryInfo($eventCategory, 'event_exhibitions', 0);

        $data['events'] = $this->getEventsForCategory();

        $this->load_view('frontend/event_category_overview', $data);

    }
      /**************************    DETAIL PAGE       *******************************/



  /**************************    NORMAL PAGE  TEMPLATE     *******************************/

    public function normal_page_template()
    {

        $db = DB_NAME;

        $data = array();

        $data['print'] = false;
        $data['lang'] = $this->language;
        $data['front_logged_in'] = ($this->session->userdata('front_logged_in')) ? 1 : 0;
        $data['show_warning'] = true;

        $data['cookie_mark'] = get_cookie('cookie_mark');

        if (get_cookie('cookie_warning') == true) {
            $data['show_warning'] = false;
        }

        // by default is page title Pretty name from function name - feel free to change
        $function_name = __FUNCTION__; // name of this function
		$page_title = $this->getPrettyName($function_name);
        $data['page_title'] = SITE_NAME . ' - ' . $page_title;


        // *** YOUR DATA *** //

        $this->load_view('frontend/newsletter', $data);

    }


    public function custom_detail_without_modules($pretty_url)
    {
        $data = array();


        $data['front_logged_in'] = $this->session->userdata('front_logged_in');
        $data['lang'] = $this->language;

        switch ($this->language) {
            case '0':
                setlocale(LC_TIME, 'de_DE.utf8');
                break;
            case '1':
                setlocale(LC_TIME, 'en_US.utf8');
                break;
        }

        $artist = $this->fm->getArtistByPretty($pretty_url);



        $artistExhibitions = $this->fm->get_exhibitions_by_artist($artist->id);

        foreach($artistExhibitions as $exh) {
            $exh_article = $this->fm->get_item_by_exh_id($exh->id);
            if($exh_article != false)
            {
                $exh->pretty_url = $exh_article->pretty_url;
            }
            else
            {
                $exh->pretty_url = '';
            }

        }

        $artistEvents = $this->fm->get_events_by_artist($artist->id);

        foreach($artistEvents as $eve) {
            $eve_article = $this->fm->get_item_by_eve_id($eve->id);
            if($eve_article != false)
            {
                $eve->pretty_url = $eve_article->pretty_url;
            }
            else
            {
                $eve->pretty_url = '';
            }

        }

        $artistCurators = $this->fm->get_exhibitions_by_curator($artist->id);

        foreach($artistCurators as $exh) {
            $exh_article = $this->fm->get_item_by_exh_id($exh->id);
            if($exh_article != false)
            {
                $exh->pretty_url = $exh_article->pretty_url;
            }
            else
            {
                $exh->pretty_url = '';
            }

        }


        $data['page_title'] = SITE_NAME." - ".$artist->first_name . " " . $artist->last_name;

        if ($artist != false) {
            $data['item'] = $artist;
            $data['artistExhibitions'] = $artistExhibitions;
            $data['artistEvents'] = $artistEvents;
            $data['artistExhibitionsCurator'] = $artistCurators;
            $this->load_view('frontend/member_detail', $data);
        } else {

            $data['msg'] = '404 not found';
            $this->load_view('frontend/404', $data);
        }
    }

  /**************************    SITE MAP       *******************************/

    // site map
    public function site_map()
    {
        $pages = array();

        $items = $this->fm->get_all_items();

        foreach ($items as $item) {
            array_push($pages, $item->pretty_url);
        }

        $data['pages'] = $pages;
        $this->load->view('frontend/tools/site_map', $data);
    }

    /**************************    SEARCH       *******************************/


    public function search($search_term)
    {
        // arrays for data and items
        $data = array();
        $items = array();

        // make search term stripped and lower case
        $search_term = urldecode(htmlspecialchars($search_term));

        // save search term to data
        $data['search_term'] = $search_term;

        // articles that were found
        $finalResultArticles = array();

        $articles = $this->fm->getAllVisibleItems();


        $article_ids = array();
        $data['item_count'] = 0;

        foreach ($articles as $item) {

            // checking if item is in the right language
            if ($item->lang == $this->language) {


                // getting item info
                $item = $this->getArticleInfo($item);

                if ($item->entity) {

                    // getting item name from entity
                    $item->name = $this->getRowName($item->entity);
                    $item->result_string = '';


                    if (stripos($item->name, $search_term) !== false) {
                        if (!in_array($item->id, $article_ids)) {

                            array_push($finalResultArticles, $item);
                            array_push($article_ids, $item->id);
                            $data['item_count']++;
                        }
                    }


                }

            }
        }


        /* MODULES */

        $text_modules = $this->fm->getTextModules();

        // check text modules
        foreach ($text_modules as $item) {
            if (stripos($item->content, $search_term) !== false) {
                if (!in_array($item->item_id, $article_ids)) {
                    $article = $this->fm->getVisibleItemById($item->item_id);


                    if ($article != false) {
                        $article = $this->getArticleInfo($article);

                        if ($article->entity) {
                            $article->result_string = $this->getResultSearchString($item, $search_term);
                            $article->name = $this->getRowName($article->entity);



                            if ($article->lang == $this->language && !in_array($article->id, $article_ids)) {
                                array_push($finalResultArticles, $article);
                                array_push($article_ids, $article->id);
                                $data['item_count']++;
                            }

                        }
                    }
                }

            }

        }




        // sort based on type
        usort($finalResultArticles, function ($first, $second) {

            return $first->type <=> $second->type;
        });

        $data['articles'] = $finalResultArticles;

        $result_text = count($items) == 1 ? $this->lang->line('result') : $this->lang->line('results');
        $data['cat'] = (object) [
            'id' => 00,
            'name' => $data['item_count'] . ' ' . $result_text,
            'pretty_url' => 'search/' . $search_term,
            'allow_date_sort' => 0,
            'scale_images' => 0,
        ];

        // recommended searches
        $data['searches'] = $this->fm->getSelectorSearches();


        return $this->load_view('frontend/subpages/search', $data);
    }

    public function heygen() {
        if($this->logged_in()):
        $data = array();
        $this->load_view('frontend/tools/heygen', $data);
        endif;
    }

    public function cookies()
    {


        $data['cookie_warning'] = get_cookie('cookie_warning');
        $data['cookie_mark'] = get_cookie('cookie_mark');

        $this->load_view('frontend/subpages/cookies', $data);

    }



}
