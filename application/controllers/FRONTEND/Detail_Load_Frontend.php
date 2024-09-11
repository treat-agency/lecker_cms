<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Detail_Load_Frontend
{

         /**************************    DETAIL     *******************************/

    public function detail($pretty_url, $print = false, $return = false)
    {
        $db = DB_NAME;

        $data = array();


        // getting general data
        $data['print'] = $print;
        $data['lang'] = $this->language;
        $data['front_logged_in'] = ($this->session->userdata('front_logged_in')) ? 1 : 0;
        $data['show_warning'] = true;
        $data['cookie_mark'] = get_cookie('cookie_mark');

        // show cooking warning
        if (get_cookie('cookie_warning') == true) {
            $data['show_warning'] = false;
        }

        // if logged in, then gets even invisible articles
        $article = $this->fm->getAnyItemByPrettyURL($pretty_url);

        /////////////////////////////// BLOCKING ACCESS IF NOT LOGGED IN
        // if ($article != false) {
            //     $article->logged_in = $this->logged_in() == true ? 0 : $article->logged_in;
            // }
            /////////////////////////////// BLOCKING ACCESS IF NOT LOGGED IN

        if (NUMBER_OF_LANGUAGES > 1) {
            $this->checkLanguageOfArticleOrRedirect($article);
            // seo_purpose
            $data['other_language_article'] = $this->getOtherLanguageArticle($article);
        }


        $article = $this->getArticleInfo($article);


        // var_dump($article);

        // var_dump($article);


        if ($article != false )
        /////////////////////////////// BLOCKING ACCESS IF NOT LOGGED IN
        // && ($data['front_logged_in'] == 1 || $article->logged_in == 0 )
        /////////////////////////////// BLOCKING ACCESS IF NOT LOGGED IN

        {

            // GETTING THE RIGHT LANGUAGE VERSION

           // GETTING ARTICLE INFO




            $data['item'] = $article;


            // if the article has other languages
            $data['detail_has_de'] =  true;
            $data['detail_has_en'] =  ($this->fm->get_article_by_origin_lang($data['item']->id, SECOND_LANGUAGE) != false) ? true : false;


            if ($this->language != MAIN_LANGUAGE) {
                $data['detail_has_en'] =  true;
                $data['detail_has_de'] =  ($data['item']->original_item_id != 0 && $this->fm->getItemById($data['item']->original_item_id) != false) ? true : false;
            }

            if (!$data['item']) {
                //redirect('');
                exit;
            }


            $related_articles =  array();
            $related_articles = $this->fm->get_related_by_item($data['item']->id);

            // get 3 automated related article if none are set in lecker
            // if (count($related_articles) < 3) {
            //     foreach ($article->tags as $tag) {
            //         $related_articles = array_merge($related_articles, $this->fm->get_items_by_tag($tag->id, $data['item']->id));
            //     }
            // }

            $final_related_articles = array();
            foreach ($related_articles as $key => $item) {
                if (in_array($item->id, $final_related_articles)) {
                    unset($related_articles[$key]);
                } else {
                    // $item = $this->get_items_info($item);
                    $final_related_articles[] = $item->id;
                }
            }




            // RELATED ARTICLES VIEW
            // $data['related_items_html'] = $this->load->view('frontend/overview', array('items' => array_slice($related_articles, 0, 3)), true);



            //** SEO

            // seo_purpose
            $data['og_title'] = isset($data['item']->entity) ? $this->getRowName($data['item']->entity) : '';
            $data['og_img'] = '';
            if (isset($data['item']->first_teaser)) {
                $data['og_img'] = $data['item']->first_teaser->img_path;
            }

            $data['og_description'] = $data['item']->og_description;
            $data['og_url'] = $data['item']->pretty_url;
            $data['seo_description'] = $data['item']->seo_description;


            $parsed_url = parse_url(site_url());
            $host = $parsed_url['scheme'] . "://" . $parsed_url['host'];
            $data['hostUrl'] = site_url();
            $title = urldecode($data['item']->name);

            // MODULE PART START
            $itemId = $data['item']->id;
            $parent = PARENT_ARTICLE;



            include(APPPATH . 'controllers/FRONTEND/Modules_Frontend.php');

            // MODULE PART END




            $page_title = $this->language == SECOND_LANGUAGE ? isset($article->entity->name_en) ? $article->entity->name_en : $article->entity->name : $article->entity->name;
            $data['page_title'] = SITE_NAME . ' - ' . $page_title;
            $data['page'] = 'detail';

            if($return == false) {
                $this->load_view('frontend/detail', $data);
            } else {
                return $this->load->view('frontend/detail', $data, TRUE);
            }

        } else { //if no article is found or for logged in only


            $data['msg'] = $this->lang->line('no_results');


            $this->load_view('frontend/404', $data);

        }


    }

         /**************************    LOAD VIEW     *******************************/

    // openai_copy
    public function getOpenaiData($data)
    {

        // conditional display of openai
        $data['page_settings'] = $this->fm->getPageSettings();

        $data['show_openai'] = $data['page_settings']->show_openai;


        // languages
        $languages = $this->om->getOpenaiLanguages();
        $data['languages'] = $languages;
        $languages_ids = array_column($languages, 'id'); // for checking if translation exists

        // langlines
        $data['langlines'] = $this->om->getOpenaiLanglines();

        // prompts
        $prompts = $this->om->getOpenaiPromptByArea('user');
        $prompts_array = array();
        foreach ($prompts as $p) {
            // translations for prompts
            $translations = $this->om->getOpenaiTranslationsByPromptId($p->id);
            $translation_ids = array_column($translations, 'language');

            $difference_lang_trans = array_diff($languages_ids, $translation_ids);

            // translations and languages are having same ids
            if (empty($difference_lang_trans)) {
                $p->translations = $translations;
                $prompts_array[] = $p;
            }

        }

        $data['prompts'] = $prompts_array;

        $data['preselected_language'] = $this->language == 1 ? 2 : 1; // if language not coming from selector but from the website

        // getting last chat id
        $last_chat = $this->om->openaigetLastChat();

        $data['last_chat_id'] = 1;
        if ($last_chat != false) {
            $data['last_chat_id'] = $last_chat['chat_id'] + 1;
        }


        return $data;
    }
    // openai_copy

    public function load_view($view, $viewdata)
    {

        $data = array();

        // openai_copy
        $data = $this->getOpenaiData($data);
        $viewdata = $this->getOpenaiData($viewdata);
        // openai_copy

        $data = $viewdata;
        $data['front_logged_in'] = $this->session->userdata('front_logged_in');

        // treatstart

        // seo_purpose
        $data['page_title'] = (isset($viewdata['page_title'])) ? $viewdata['page_title'] : PAGE_TITLE;
        $data['og_img'] = isset($viewdata['og_img']) ? $viewdata['og_img'] : site_url(OG_IMAGE);
        $data['og_title'] = (isset($viewdata['og_title'])) ? $viewdata['og_title'] : OG_TITLE;
        $data['og_description'] = (isset($viewdata['og_description'])) ? $viewdata['og_description'] : OG_DESCRIPTION;
        $data['og_url'] = (isset($viewdata['og_url'])) ? $viewdata['og_url'] : site_url();
        $data['seo_description'] = (isset($viewdata['seo_description'])) ? $viewdata['seo_description'] : SEO_DESCRIPTION;

        // canonical
        $current_url = current_url();
        $canonical = str_replace("www.", "", $current_url);
        if(defined('CANONICAL_REPLACE') && count(CANONICAL_REPLACE) ):
        foreach(CANONICAL_REPLACE as $replace){
            $canonical = str_replace($replace['from'], $replace['to'], $canonical);
        }
        endif;
        $data['canonical'] = $canonical;


        $data['show_warning'] = true;

        $data['cookie_mark'] = get_cookie('cookie_mark');

        if (get_cookie('cookie_warning') === 'true') {
            $data['show_warning'] = false;
        }

        $data['lang'] = $this->language;

        $data['user'] = false;
        if($this->session->userdata('customer_logged_in'))
        {
            $data['user'] = $this->session->userdata('customer_logged_in');
        }


        $data['page'] = str_replace(".php", "", basename($_SERVER['PHP_SELF']));



        // menu translation and url control
        $menu_items = $this->fm->get_menu_items();
        foreach ($menu_items as $key => $menu_item) {
            if ($this->lang->line($menu_item->name)) {
                $menu_item->name = $this->lang->line($menu_item->name);
            }

            $sub_menus = $this->fm->get_sub_menu_by_main_menu($menu_item->id);

            if (count($sub_menus) != 0) {
                foreach ($sub_menus as $key => $sub_menu) {
                    if ($this->lang->line($sub_menu->name)) {
                        $sub_menu->name = $this->lang->line($sub_menu->name);
                    }

                    $sub_category = $this->fm->get_category_by_id($sub_menu->category);

                    if ($sub_menu->archive_item == 0) {
                        $sub_menu->url = ($sub_category) ? 'category/' . $sub_category->pretty_url : $sub_menu->pretty_url;
                    } else {
                        $sub_menu->url = ($sub_category) ? 'archive/' . $sub_category->pretty_url : $sub_menu->pretty_url;
                    }


                    // var_dump($sub_menu);

                    if ($sub_menu->visible == 2 && $data['front_logged_in'] != true) {
                        unset($sub_menus[$key]);
                    };
                };

                $menu_item->sub_menus = $sub_menus;
                $menu_item->has_sub_menu = true;
            } else {
                $menu_item->has_sub_menu = false;
            }


            $category = $this->fm->get_category_by_id($menu_item->category);
            $menu_item->url = ($category) ? 'category/' . $category->pretty_url : $menu_item->pretty_url;

            if ($menu_item->visible == 2 && $data['front_logged_in'] != true) {
                unset($menu_items[$key]);
            };
        };

        $data['menuItems'] = $menu_items;

        $categories = $this->fm->get_menu_categories();
        // $data['menu_categories'] = $this->get_categories_info($categories, $limit = false);

        $data["lpSettings"] = $this->fm->getLandingPageData();


        switch ($this->language) {
            case '0':
                setlocale(LC_TIME, 'de_DE.utf8');
                break;
            case '1':
                setlocale(LC_TIME, 'en_US.utf8');
                break;
        }



        $this->load->view('frontend/head', $data);
        $this->load->view($view, $viewdata);
        $this->load->view('frontend/footer', $data);
    }




  }