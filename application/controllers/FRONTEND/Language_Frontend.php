<?	defined('BASEPATH') or exit('No direct script access allowed');


trait Language_Frontend
{

        /**************************    CHANGE LANGUAGE COOKIE     *******************************/

    // cookies
    public function change_lang()
    {
        $lang = $_POST['lang'];

        $cookie = array(
            'name' => 'selected_lang',
            'value' => $lang,
            'expire' => '86500',
            'path' => '/',
            'prefix' => '',
            'secure' => TRUE
        );
        $this->input->set_cookie($cookie);
    }

            /**************************    CHECK FOR ARTICLE LANGUAGE AND REDIRECT     *******************************/

    function checkLanguageOfArticleOrRedirect($article)
        {
        if (NUMBER_OF_LANGUAGES == 1) {
            return;
            }

        if (get_cookie('selected_lang') == null) {
            set_cookie(MAIN_LANGUAGE);
            }


        if ($this->language == $article->lang) {
            // No redirection happens here

            } else {
            if ($this->language == MAIN_LANGUAGE) {

                $original_item_id = ($article->lang == SECOND_LANGUAGE) ? $article->original_item_id : $article->id;

                if ($original_item_id != 0) {
                    $go_to = $this->fm->get_article_by_id_with_lang($original_item_id, $this->language);

                    // var_dump($original_item_id);
                    if ($go_to != false) {
                        redirect($go_to->pretty_url); // Redirection 1
                        } else {
                        redirect($article->pretty_url); // Redirection 2
                        exit;
                        }
                    } else {
                    redirect($article->pretty_url); // Redirection 3
                    exit;
                    }
                } else {
                $go_to = $this->fm->get_article_where_original_id_item_id($article->id, $this->language);
                if ($go_to != false && $go_to->id != $article->id) {
                    redirect($go_to->pretty_url); // Redirection 4
                    } else {
                    redirect($article->pretty_url); // Redirection 5
                    exit;
                    }
                }
            }
        }

    // seo_purpose
    public function getOtherLanguageArticle($article)
    {

        $other_article = $article;
        if($article->original_item_id != 0){
            $other_article = $this->fm->getItemById($article->original_item_id);
        } else {
            $other_article = $this->fm->getItemWhereOriginArticleThis($article->id);
        }


        return $other_article;


    }





}
