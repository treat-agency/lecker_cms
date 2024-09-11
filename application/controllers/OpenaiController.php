  <?php
  defined('BASEPATH') or exit('No direct script access allowed');

  class OpenaiController extends MY_Controller
    {

    //////// SET START

    // REQUIRED

    // prompt settings
    protected $topic = '';

    // OPTIONAL

    // input from client
    protected $data = ''; // customly made data array or string
    protected $userInput = '';  // user input - string

    // saving to db if used
    protected $isSavedChatConversation = true;


    protected $chat_id = 0;


    // placeholders - other modifiers like language etc.

    private $placeholder1 = '';
    private $language_id = 1;
    private $placeholder2 = '';
    private $placeholder3 = '';
    private $placeholder4 = '';

    // conversation

    private $conversation = array();

    // append elements
    private $appendElements = array();

    //// SET END

    // saving to custom table
    protected $databaseTable = ''; // by default is same as $this->topic

    protected $databaseResponseColumn = ''; // this one is required

    protected $databaseIdentifierColumn = ''; // optional

    protected $databaseIdentifierValue = ''; // optional


    // GENERATED

    // prompts

    protected $systemPrompt = '';

    protected $userPromptRaw = '';
    protected $userPrompt = '';
    protected $debug = 0;

    // response

    protected $role = "assistant";

    protected $response = '';
    protected $jsonResponse;

    // GENERAL

    // files
    protected $openaiFolder;

    // timestamp
    protected $timestamp;

    // error collector

    protected $error = '';

    protected $appendArticles = array();

    // chatgpt settings
    protected $gpt4Model = 'gpt-4-1106-preview';
    protected $gpt35Model = 'gpt-3.5-turbo-1106';
    protected $gpt4o = 'gpt-4o';
    protected $model;
    protected $temperature = 0.1;
    protected $frequencyPenalty = 0.2;
    protected $presencePenalty = 0;
    protected $maxTokens = 4000;

    function __construct()
      {


      parent::__construct();

      // customizable start
      $this->model = $this->gpt4o;

      // customizable end

      $this->timestamp = date('Y-m-d H:i:s');

      $this->detectDevice();

      $this->load->model('Authentication_model', 'am');
      $this->load->model('Frontend_model', 'fm');
      $this->load->model('Openai_model', 'om');

      $this->load->helper('besc_helper');

      $this->load->library('form_validation');
      $this->load->helper('cookie');
      // OLD URL $this->api_url = 'https://wim-local.ts.icbtech.net/';
      $this->openaiFolder = getcwd() . '/items/openai/';

      require_once(APPPATH . 'libraries/fpdf.php');
      require_once(APPPATH . 'libraries/FPDI/src/autoload.php');
      /* require_once(APPPATH . 'libraries/FPDI/src/Fpdi.php'); */
      require_once(APPPATH . 'libraries/PasswordHash.php');

      }

    /****************************************************************** **************************/
    /****************************************************************** **************************/
    /************************************ Concrete project openai ************** **************************/
    /****************************************************************** **************************/
    /****************************************************************** **************************/


    /**************************    APPLICATIONS    **********************/
    public function start()
      {



      $this->topic = isset($_POST['topic']) ? $_POST['topic'] : '';
      $this->userInput = isset($_POST['user_input']) ? $_POST['user_input'] : '';

      switch ($this->topic) {
        case 'about':
          $this->data = $this->getAboutInfo();
          break;
        case 'projects':
          $this->data = $this->getProjectsInfo();
          break;
        case 'brands':
          $this->data = $this->getBrandsInfo();
          break;
        default:
          $this->processError('Topic not found.');
        }

      $this->useAI();

      $this->createResponseJSON();
      // $this->appendElementsToJSON();
      $this->respond();

      }

  public function getBrandsInfo() {

    $this->appendArticles = array();

    $articles = $this->getBrandArticles();


    $data_text = $this->getDataTextFromArticlesAndAppend($articles, true);


      return $data_text;

  }

    public function vision() {

    $image_path = $_POST['image_path'];

      $this->maxTokens = 300;

   try {

    // Start the session if it's not already started
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    // Initialize the conversation array from the session if it exists, otherwise start a new one
    $this->conversation = isset($_SESSION[$this->topic]) ? $_SESSION[$this->topic] : [];

    $this->conversation[] =  [
          "role" => "user",
          "content" => [
            ["type" => "text", "text" => "What’s in this image? Please answer in maximally 300 characters."],
            [
              "type" => "image_url",
              "image_url" => [
                "url" => $image_path,
              ],
            ],
          ],
        ];


      $result = $this->client->chat()->create([
              'model' => $this->model,
              'messages' => $this->conversation,
              'temperature' => $this->temperature, // 0 = no creativity, 1 = a lot of creativity
              'max_tokens' => $this->maxTokens, // size of the response
              'frequency_penalty' => $this->frequencyPenalty, // increases word repetition
              'presence_penalty' => $this->presencePenalty, // encourages model to talk about new topics (0 = no penalty)
            ]);


        $this->response = $result->choices[0]->message->content;



        $this->conversation[] = array('role' => 'assistant', 'content' => $this->response);

        // Save the conversation back to the session
        $_SESSION[$this->topic] = $this->conversation;

         echo json_encode(array("role" => "AI", "response" => $this->response, "success" => true)); // info for form in frontend

        } catch (\Exception $e) {

        $this->processError($e->getMessage(), false);

        }
      }


    public function quiz() {

        $this->topic = 'quiz';

        $this->userPrompt = isset($_POST['userPrompt']) ? $_POST['userPrompt'] : 'Restart quiz.';

      $this->maxTokens = 150;

      $this->temperature = 0.7;

        $this->systemPrompt = "You are an AI quiz master. I will provide you with a list of questions about the capitals of different countries and their correct answers. Ask me each question one by one. After I answer, tell me if I was correct or not, and then provide the correct answer if needed. Continue to the next question after providing feedback. Here are the questions and answers:\n1. What is the capital of Brazil? (Brasília)\n2. What is the capital of Australia? (Canberra)\n3. What is the capital of Japan? (Tokyo)\n4. What is the capital of Canada? (Ottawa)\n5. What is the capital of France? (Paris)\n6. What is the capital of India? (New Delhi)\n7. What is the capital of Russia? (Moscow)\n8. What is the capital of China? (Beijing)\n9. What is the capital of Egypt? (Cairo)\n10. What is the capital of South Africa? (Pretoria)\nStart by asking the first question.";

       $this->talktToChatGPT();

      $this->createResponseJSON();

      echo json_encode($this->jsonResponse);

      }

     public function heygenTalk()
      {

      $postData = file_get_contents('php://input');
      if (!empty($postData)) {
        $data = json_decode($postData, true);



        $this->userPrompt = $data['question'];

        } else {

        $data = [];
      }



      if($this->userPrompt == ''){
        $this->processError('No question provided.');
      }

      $this->userPrompt = 'QUESTION: ' .  $this->userPrompt;

      // COMMAND
      if (strpos($this->userPrompt, 'hey') !== false || strpos($this->userPrompt, 'Hey') !== false || strpos($this->userPrompt, 'Hej') !== false) {
        $command = $this->command();
        echo json_encode($command);
        return;
      } else

      // go from post
      if($this->topic == ''){
        $this->topic = 'heygenTalk';
      }

      $this->systemPrompt = 'You are a help desk assistant at Wien Museum. Your task is to respond to visitors in the language of their question and then always say "Byyye Stiiii!" as goodbye. There will be visitors from different countries, so please do not answer in German unless the question is in German. You can use the following CONTEXT:

Wiens Geschichte von der Frühzeit bis in die Gegenwart: Auf 3.300 m², über drei Etagen und anhand von 1.700 Objekten nimmt die Dauerausstellung "Wien. Meine Geschichte" die Besucher:innen mit auf eine Reise durch die Jahrhunderte. Im Mittelpunkt stehen die Menschen und ihr Leben im Spannungsfeld von Politik und Religion, sozialen Strukturen und der sie umgebenden Umwelt. Themen wie Arbeit, Wohnen, Verkehr, Zuwanderung und Ökologie bestimmten damals wie heute den Alltag. Die Geschichte der Stadt ist als chronologischer Rundgang erlebbar, mit der großen Halle als Zentrum. Hier treffen Besucher:innen auf ikonische Großobjekte der Sammlung, wie die originalen Figuren des Donnerbrunnens, ein fünfeinhalb Meter hohes Stephansdom-Modell sowie Praterwalfisch Poldi. Interaktive Formate und taktile Objekte sprechen verschiedene Sinne an, über 100 Medienstationen sowie ein Digital Guide bieten vertiefende Inhalte. Programme für Jung und Alt sowie Programme mit Fokus auf Inklusion werden im Kalender angeboten oder können als Gruppe gebucht werden. Informieren Sie sich hier über Ihren barrierefreien Besuch.';


      $this->talktToChatGPT();

      $this->createResponseJSON();

      echo json_encode($this->jsonResponse);


      }

    public function command() {

      $command = array("command" => "wrong command", "value"=> "", "success" => false);

      $redirectPages = array("backend", "back-end");

      foreach ($redirectPages as $page) {
        if(strpos($this->userPrompt, $page) !== false) {
          $page = str_replace('-', '', $page);
          $command = array( "command" => "redirect", "value"=> $page, "success" => true);
        }
      }

      return $command;


    }


  public function getBrandArticles()
    {

    $articles = $this->om->getBrandArticles();

    return $articles;

    }

    public function getAboutInfo()
      {


      $this->appendArticles = array();

      $articles = $this->getAboutArticles();


      $data_text = $this->getDataTextFromArticlesAndAppend($articles);

      return $data_text;

    }

    public function getAboutArticles()
      {

      $relation = $this->om->getAboutRelation();


      $article_array = array();
      foreach ($relation as $r) {
        $article = $this->fm->getItemById($r->item_id);

        if ($article) {
          $article_array[] = $article;
          }

        }

        return $article_array;
      }

      public function getDataTextFromArticlesAndAppend($articles, $exception = false) {
        $data_text = '';
        foreach ($articles as $a) {


          $article_full = $this->articleInfo($a->pretty_url, $exception);
          if ($article_full->data != '') {
            $data_text .= $article_full->data;
            }

        if($a){
          $this->appendArticles[] = $article_full;
          }


        }

        return $data_text;
        }


    public function getProjectsInfo()
      {

      $this->appendArticles = array();

      $articles = $this->getProjectArticles();

      $data_text = $this->getDataTextFromArticlesAndAppend($articles);



      return $data_text;


      }

    public function getProjectArticles()
      {

      $articles = $this->om->getProjectArticles();

      return $articles;

      }



    public function exampleAjaxCall()
      {

      ////////// required
      $this->topic = isset($_POST['topic']) ? $_POST['topic'] : '';

      $this->language_id = isset($_POST['language_id']) ? $_POST['language_id'] : 1;
      ////////// optional
      $this->userInput = isset($_POST['user_input']) ? $_POST['user_input'] : '';
      $this->data = $this->getLocationInfo(); // function that collects data from backend as string or array

      $this->appendElements = array(); // can be used to append elements to response
      $this->isSavedChatConversation = true; // if true, saves conversation to openai_chat_log and openai_chat

      // custom
      $this->databaseTable = 'openai_chat_log';
      $this->databaseResponseColumn = 'response'; // this one is required
      $this->databaseIdentifierColumn = 'timestamp';
      $this->databaseIdentifierValue = $this->timestamp;

      $this->useAI();

      $this->createResponseJSON();
      $this->appendElementsToJSON();
      $this->respond();


      }



    /**************************    GETTING DATA    **********************/



    public function getBrandInfo($a)
      {

      $a->Name = $this->language == LANG_EN ? $a->name_en : $a->name;
      $slides = $this->fm->getSlides($a->id);
      $slides_array = array();
      foreach ($slides as $s) {
        $s->Text = $this->language == LANG_EN ? $s->text_en : $s->text;
        $s->Image = site_url() . 'items/uploads/images/new_thumbs/' . $s->image;
        $slides_array[] = $s;
        }

      $brand_areas = $this->fm->getBrandAreas($a->id);

      $brand_areas_array = array();
      foreach ($brand_areas as $ar) {
        $area = $this->fm->getBrandAreaById($ar->brand_area_id);
        $brand_areas_array[] = $area;
        }

      $a->brand_areas = $brand_areas_array;


      $a->slides = $slides_array;
      return $a;
      }

    /**************************    DATA PREPARATION GENERAL  *********************/
    // articleInfo - get article info - teasers images
    // getBasicItemInfo - get basic item info - teasers images

    public function articleInfo($pretty_url, $exception = false)
      {



      $text_module = false;

      if(!$exception){

        $item = $this->om->getItemByPrettyUrl($pretty_url);

        if (!$item) {
          return false;
          }

        $item = $this->getBasicItemInfo($item);
        $text_modules = $this->om->getSomeTextModule($item->id);



        foreach ($text_modules as $t) {
          $text_module .= " " . $t->content;
          }

      } else {
        $item = $this->fm->getBrandByPrettyUrl($pretty_url);
      }


      $item->images = array();

      if($exception) {
        $brand = $item;

        $brand = $this->getBrandInfo($brand);

        if ($brand) {
          $data_string = '';
          $data_string .= "NAME: ";
          $data_string .= $brand->name;

          if (count($brand->brand_areas) > 0) {
            $data_string .= "; AREAS: ";
            foreach ($brand->brand_areas as $area) {
              $data_string .= $area->name . ", ";
              }
            }

          if (count($brand->slides) > 0) {
            $data_string .= "; DESCRIPTION: ";

            foreach ($brand->slides as $slide) {
              $data_string .= $slide->text;
              $item->images[] = $slide->Image;
              }
            }


          $data_string .= " | ";

          $item->pretty_url = site_url() . 'brands/' . $brand->pretty_url;
          $item->data = $data_string;
          }
      }
      elseif ($text_module) {



        $data_string = '';
        $data_string .= "NAME: ";
        $data_string .= $item->name;
        $data_string .= "; DESCRIPTION: ";
        $data_string .= strip_tags($text_module);
        $data_string .= " | ";

        $item->data = $data_string;

        $item->pretty_url = site_url() . $item->pretty_url;

        $item_images = $item->teaser_images;

        } elseif ($item->type == PROJECT_ARTICLE) {

        $project = $this->fm->getProjectById($item->project_id);

        if ($project) {

          $category = $this->fm->getProjectCategoryById($project->main_category);

          $data_string = '';
          $data_string .= "NAME: ";
          $data_string .= $project->display_title;
          $data_string .= "; SUBHEADLINE: ";
          $data_string .= strip_tags($project->subheadline);
          $data_string .= "; TEASER: ";
          $data_string .= strip_tags($project->teaser);
          $data_string .= "; QUOTE: ";
          $data_string .= strip_tags($project->quote_text) . ' - ' . $project->quote_company . $project->quote_name;
          $data_string .= "; YEAR: ";
          $data_string .= $project->year;
          if ($category):
            $data_string .= "; CATEGORY: ";
            $data_string .= $category->name;
          endif;

          $data_string .= " | ";

          $item->data = $data_string;
          $item->pretty_url = site_url() . 'projekte/' . $item->pretty_url;
          $item->images[] = site_url('items/uploads/images') . $project->image;
          }
          } else {


          }
        return $item;


        }


    public function getBasicItemInfo($item)
      {

      $teaser_image_relations = $this->fm->getImageTeaserRelations($item->id);


      $item_teaser_selection = $this->fm->getImageTeasers($teaser_image_relations);


      $teaser_images = array();
      foreach ($item_teaser_selection as $at) {

          $at->img_path = site_url() . 'items/uploads/images/' . $at->fname;
          $teaser_images[] = $at;

        }

      $item->teaser_images = $teaser_images;

      return $item;
      }


    /****************************************************************** **************************/
    /****************************************************************** **************************/
    /************************************ General openai ************** **************************/
    /****************************************************************** **************************/
    /****************************************************************** **************************/


    /**************************    QUESTION AND LANGLINE TRANSLATION    **********************/
    // saveLanguages - save languages used in project for translation
    // translateQuestion - translate question to all languages in project
    //


    public function saveLanguages()
      {

      $languages = [
        "English",
        "Spanish",
        "French",
        "German",
        "Chinese",
        "Japanese",
        "Korean",
        "Russian",
        "Italian",
        "Portuguese",
        "Dutch",
        "Arabic",
        "Hindi",
        "Bengali",
        "Punjabi",
        "Urdu",
        "Persian",
        "Turkish",
        "Vietnamese",
        "Polish",
        "Ukrainian",
        "Greek",
        "Hebrew",
        "Thai",
        "Swedish",
        "Danish",
        "Finnish",
        "Norwegian",
        "Hungarian",
        "Czech",
        "Slovak",
        "Romanian",
        "Bulgarian",
        "Croatian",
        "Serbian",
        "Lithuanian",
        "Latvian",
        "Estonian",
        "Slovenian",
        "Icelandic",
        "Swahili",
        "Malay",
        "Indonesian",
        "Tagalog",
        "Tamil",
        "Telugu",
        "Malayalam",
        "Kannada",
        "Marathi",
        "Gujarati"
      ];

      foreach ($languages as $key => $l) {
        $ddd = array('language' => $l);
        $this->om->saveLanguage($ddd);
        }
      }

    public function translateQuestions()
      {

      $this->topic = 'translate_sentence';

      $prompts = $this->om->getPromptsToTranslate();
      $languages = $this->om->getOpenaiLanguages();

      foreach ($prompts as $prompt) {


        foreach ($languages as $key => $l) {

          $translation_found = $this->om->getOpenaiTranslationsByPromptIdAndLanguage($prompt->id, $l->id);

          if (!$translation_found) { // put away
            $this->data = $prompt->question;
            $this->placeholder1 = $l->language;
            $response = $this->useAI();

            $translated_question = '<p>' . $response . '</p>';

            $dd = array('language' => $l->id, 'prompt_id' => $prompt->id, 'question' => $translated_question);
            $this->om->saveQuestionTranslation($dd);
            }

          }
        }

      echo "All questions have been translated.";
      }

    public function translateLangLines()
      {

      $this->topic = 'translate_sentence';

      $langlines = $this->om->getOpenaiLanglines();

      $languages = $this->om->getOpenaiLanguages();

      foreach ($langlines as $ln):

        $langline_key = $ln->key;

        foreach ($languages as $key => $l) {

          // english is first in languages
          $langline = $this->om->getOpenaiLangLineByKeyAndLanguage($langline_key, 1);

          if ($l->language == 'English') {


            continue;

            } elseif ($langline != false) {


            $translation_found = $this->om->getOpenaiLangLineByKeyAndLanguage($langline_key, $l->id);

            if (!$translation_found) {

              $this->data = $langline->translation;
              $this->placeholder1 = $l->language;
              $response = $this->useAI();
              $translated_line = $response;

              $dd = array('language' => $l->id, 'key' => $langline->key, 'translation' => $translated_line);
              $this->om->saveOpenaiLangline($dd);
              }
            }



          }

      endforeach;

      echo "All langlines have been translated.";

      }


    /**************************  CORE FUNCTIONS   *********************/

    public function useAI()
      {

      $this->isErrorData();

      $this->getMePromptDataBasedOnTopic();

      $this->prepareUserPrompt();

      $this->changeDataToString();

      $this->askOnceChatGPT();

      $this->saveDebugData();

      $this->saveChatConversation();

      $this->saveResponseToCustomTable();

      return $this->response;

      }

    public function isErrorData()
      {
      if ($this->topic == '') {
        $this->processError('Topic not set.');
        }

      }

    public function processError($errorDescription)
      {
      $this->error = $errorDescription;
      $this->insertError($this->error, current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
      $this->createResponseJSON();
      $this->respond();
      exit;
      }

    public function getMePromptDataBasedOnTopic()
      {

      $prompt = $this->om->getOpenaiPromptByTopic($this->topic);

      if ($prompt == false) {
        $this->processError('Prompt not found.');
        }

      if ($prompt->user_prompt == '') {
        $this->processError('User Prompt is required.');
        }

      $this->userPromptRaw = strip_tags($prompt->user_prompt);
      $this->systemPrompt = strip_tags($prompt->system_prompt);

      $modelSettings = $this->om->getOpenaiModelSettingsById($prompt->model);
      $this->model = $modelSettings->key == '' ? $this->model : $modelSettings->key;
      $this->temperature = $modelSettings->temperature == '' ? $this->temperature : (float)$modelSettings->temperature;
      $this->maxTokens = $modelSettings->max_tokens == '' ? $this->maxTokens : (int)$modelSettings->max_tokens;
      $this->frequencyPenalty = $modelSettings->frequency_penalty == '' ? $this->frequencyPenalty : (float)$modelSettings->frequency_penalty;
      $this->presencePenalty = $modelSettings->presence_penalty == '' ? $this->presencePenalty : (float)$modelSettings->presence_penalty;

      $this->debug = $prompt->debug;

      }

    public function prepareUserPrompt()
      {

      if ($this->data && $this->data != '') {
        $user_prompt = str_replace("|DATA|", $this->data, $this->userPromptRaw);
        }

      // USER INPUT:
      if ($this->userInput != '') {
        $user_prompt = str_replace("|USER_INPUT|", $this->userInput, $user_prompt);
        }

      // PLACEHOLDERS:
      if ($this->placeholder1 != '') {
        $user_prompt = str_replace("|PLACEHOLDER1|", $this->placeholder1, $user_prompt);
        }

      if ($this->placeholder2 != '') {
        $user_prompt = str_replace("|PLACEHOLDER2|", $this->placeholder2, $user_prompt);
        }

      if ($this->placeholder3 != '') {
        $user_prompt = str_replace("|PLACEHOLDER3|", $this->placeholder3, $user_prompt);
        }

      if ($this->placeholder4 != '') {
        $user_prompt = str_replace("|PLACEHOLDER4|", $this->placeholder4, $user_prompt);
        }

      $this->userPrompt = $user_prompt;
      }


    public function changeDataToString()
      {

      $data_string = '';
      if (gettype($this->data) == 'string') {
        $data_string = $this->data;
        } else {
        foreach ($this->data as $key => $d) {
          $data_string .= $d->data . "\n\n";
          }
        }

      $this->data = $data_string;
      }

    public function speechAskChatGPT()
      {


      if(!isset($_FILES['audio']) || !$_SERVER['REQUEST_METHOD'] === 'POST'){
        $this->processError('Invalid request method.');
      }


      $audio = $_FILES['audio'];
      $timestamp = time();
      $file = getcwd() . '/items/openai/recordings/' . $timestamp . '.mp3';

      $file_ready = move_uploaded_file($audio['tmp_name'], $file);



      if($file_ready){

       $response = $this->client->audio()->transcribe([
        'model' => 'whisper-1',
        'file' => fopen($file, 'r'),
        'response_format' => 'verbose_json',
      ]);



      $response->task; // 'transcribe'
      $response->duration; // 2.95
      $response->text; // 'Hello, how are you?'


      $transcribedAnswer = array('role' => 'You', "response" => $response->text, "success" => true);

      echo json_encode($transcribedAnswer);

      if (file_exists($file)) {
          unlink($file);
      }

      } else {
        $this->processError('File not uploaded.');
      }



      }







      public function talktToChatGPT() {

   try {

    // Start the session if it's not already started
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    // Initialize the conversation array from the session if it exists, otherwise start a new one


    $this->conversation = isset($_SESSION[$this->topic]) ? $_SESSION[$this->topic] : [];

    if ($this->systemPrompt != '' && count($this->conversation) == 0) {
      $this->conversation[] = array('role' => 'system', 'content' => $this->systemPrompt);
    }

     $this->conversation[] = array('role' => 'user', 'content' => $this->userPrompt);

        $this->conversation = array_filter($this->conversation, function ($message) {
          return $message['content'] !== null;
          });
        $this->conversation = array_values($this->conversation);



      $result = $this->client->chat()->create([
              'model' => $this->model,
              'messages' => $this->conversation,
              'temperature' => $this->temperature, // 0 = no creativity, 1 = a lot of creativity
              'max_tokens' => $this->maxTokens, // size of the response
              'frequency_penalty' => $this->frequencyPenalty, // increases word repetition
              'presence_penalty' => $this->presencePenalty, // encourages model to talk about new topics (0 = no penalty)
            ]);



        $this->response = $result->choices[0]->message->content;

        if ($this->response !== null) {
          $this->conversation[] = array('role' => $this->role, 'content' => $this->response);
        }
        // Save the conversation back to the session
        $_SESSION[$this->topic] = $this->conversation;

        } catch (\Exception $e) {

        $this->processError($e->getMessage(), false);

        }
      }





    public function askOnceChatGPT()
      {


      try {
        $message_input[] = array('role' => 'user', 'content' => $this->userPrompt);
        if ($this->systemPrompt != '') {
          $message_input[] = array('role' => 'system', 'content' => $this->systemPrompt);
          }


        $result = $this->client->chat()->create([
          'model' => $this->model,
          'messages' => $message_input,
          'temperature' => $this->temperature, // 0 = no creativity, 1 = a lot of creativity
          'max_tokens' => $this->maxTokens, // size of the response
          'frequency_penalty' => $this->frequencyPenalty, // increases word repetition
          'presence_penalty' => $this->presencePenalty, // encourages model to talk about new topics (0 = no penalty)
        ]);

        $this->response = $result->choices[0]->message->content;


        } catch (\Exception $e) {

        $this->processError($e->getMessage(), false);

        }
      }

    public function saveDebugData()
      {

      if ($this->debug == 1) {

        $modelSettings = "model: " . $this->model . " | temperature: " . $this->temperature . " | max_tokens: " . $this->maxTokens . " | frequency_penalty: " . $this->frequencyPenalty . " | presence_penalty: " . $this->presencePenalty;
        $dd = array('topic' => $this->topic, 'model_settings' => $modelSettings, 'user_input' => $this->userInput, 'data' => $this->data, 'placeholder1' => $this->placeholder1, 'placeholder2' => $this->placeholder2, 'placeholder3' => $this->placeholder3, 'placeholder4' => $this->placeholder4, 'user_prompt_raw' => $this->userPromptRaw, 'user_prompt' => $this->userPrompt, 'system_prompt' => $this->systemPrompt, 'response' => $this->response, 'timestamp' => $this->timestamp);
        $this->om->saveOpenaiDebug($dd);


        }

      }

    public function saveChatConversation()
      {

      if ($this->isSavedChatConversation == true && $this->response != '') {

        // first saving as log
        $log_row = array('topic' => $this->topic, 'created_at' => $this->timestamp);

        $this->chat_id = $this->om->saveOpenaiChatLog($log_row);

        $this->timestamp = date('Y-m-d H:i:s');
        // then saving the conversation itself
        $user_row = array('role' => 'user', 'message' => $this->userPrompt, 'topic' => $this->topic, 'chat_id' => $this->chat_id, 'timestamp' => $this->timestamp);
        $this->om->saveOpenaiChat($user_row);

        if ($this->systemPrompt != '') {
          $system_row = array('role' => 'system', 'message' => $this->systemPrompt, 'topic' => $this->topic, 'chat_id' => $this->chat_id, 'timestamp' => $this->timestamp);
          $this->om->saveOpenaiChat($system_row);
          }




        $assistant_row = array('role' => 'assistant', 'message' => $this->response, 'topic' => $this->topic, 'chat_id' => $this->chat_id, 'timestamp' => $this->timestamp);
        $this->om->saveOpenaiChat($assistant_row);

        }

      }

    public function saveResponseToCustomTable()
      {

      if ($this->databaseResponseColumn != '') {
        $dd = array();

        if ($this->databaseIdentifierColumn != '' && $this->databaseIdentifierValue != '') {
          $dd[$this->databaseIdentifierColumn] = $this->databaseIdentifierValue;
          }

        $dd[$this->databaseResponseColumn] = $this->response;

        $this->om->saveOpenaiToTable($dd, $this->databaseTable); // table has same name as topic if not set otherwise


        }

      }

    /**************************    RESPONSE    **********************/


    public function createResponseJSON()
      {

      if ($this->error != '' || $this->response == '') {
        $this->jsonResponse = array("success" => false, "response" => "Something went wrong. Please try again later.", "role" => $this->role);
        return;
        } else {
        // process response
        $response = str_replace("**", "<br>", $this->response);


        // $location_already_replaced = [];
        // foreach ($this->appendElements as $key => $l) {
        //   if (in_array($l->name, $location_already_replaced)) {
        //     continue;
        //     } else {
        //     $location_already_replaced[] = $l->name;
        //     }
        //   $pattern = "/" . $l->name . "/"; // replace this with your pattern
        //   $replacement = "<a href='https://wienmuseum.at/" . $l->pretty_url . "' target='_blank'>" . $l->name . "</a>"; // replace this with your replacement
        //   $response = preg_replace($pattern, $replacement, $response);
        //   }

        $json_response = array("success" => true, "response" => $response, "role" => $this->role);
        }

      $this->jsonResponse = $json_response; // info for form in frontend
      }


    public function appendElementsToJSON()
      {
      foreach ($this->appendElements as $l) {

        $elem =
          '<a class="locAnchor" href="' . site_url() . $l->pretty_url . '">
                        <div class="locElem df">
                          <div class="locElemLeft">
                          <img src="' . $l->teaser_images[0]->img_path . '" alt="">
                          </div>
                          <div class="locElemRight df-jcsb">
                            <div class="df-fdc-jcsb">
                              <div class="bold20 locTitle">' . $l->name . '</div>
                              <div class="locLine"></div>
                              <div class="locDownInfo">
                                <div class="locElemLoc reg14">' . $l->address_en . '</div>
                                <div class="locElemOpening reg14 ' . $l->open_class . '">' . $l->open_text . '</div>
                              </div>
                            </div>
                            <div>
                              <div class="locElemMoreRight ">
                              <img class="" src="' . site_url() . "items/frontend/img/svg/" . "normalArrow.svg" . '" alt="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>';

        $location_elements[] = $elem;
        }

      $this->jsonResponse['location_elements'] = $location_elements;

      }

    public function prepareChatFeedbackElement()
      {
      $feedback_answer = $this->om->getOpenaiLangLineByKeyAndLanguage('feedback_answer', $this->language_id);
      $feedback_question = $this->om->getOpenaiLangLineByKeyAndLanguage('feedback_question', $this->language_id);

      $chatFeedbackElement = '<div class="chatFeedback" chat_id="' . $this->chat_id . '"><div class="feedback_question">' . $feedback_question . '</div><div class="thumbHolder"><div class="js-thumbOption" id="js-thumbs_up">Yes</div><div class="js-thumbOption" id="js-thumbs-down">No</div></div><div class="feedback_answer" style="display:none">' . $feedback_answer . '</div></div>';

      return $chatFeedbackElement;
      }




    public function respond()
      {
      echo json_encode($this->jsonResponse); // info for form in frontend
      }



    /**************************  FINE TUNING   *********************/

    // openaiInputGenerator - generate examples for input
    // openaiFineTuning - fine tuning gpt

    public function openaiInputGenerator($topic, $numberOfInputs, $model = 'gpt-4-1106-preview')
      {

      $prompt = $this->om->getOpenaiPromptByTopic($topic);

      $user_prompt = strip_tags($prompt->user_prompt);
      $system_prompt = strip_tags($prompt->system_prompt);

      $conversation = array();

      for ($index = 0; $index < $numberOfInputs; $index++) {
        $prob1 = $this->chatgpt($conversation, $system_prompt, $user_prompt, $model); // first generating examples
        $conversation[] = $prob1;

        $dd = array('input' => $prob1, 'topic' => $topic);

        $this->om->saveInput($dd); // saving examples to database for future use
        }


      return $conversation; // returns array of examples


      }



    public function fineTuning($topic, $model = 'gpt-3.5-turbo-1106')
      {

      $checkedChatLogs = $this->om->getCheckedChatLogs($topic);


      $messages = [];

      foreach ($checkedChatLogs as $log) {
        $chats = $this->om->getChatById($log->id);

        $rows = [];

        foreach ($chats as $c) {
          $rows[] = array('role' => $c->role, 'content' => $c->message);
          }

        $messages[] = $rows;



        }

      $jsonlContent = '';

      foreach ($messages as $message) {
        $jsonlContent .= json_encode(['messages' => $message]) . "\n";
        }

      $file = $this->openai_folder . 'result_teachings/' . $topic . '_' . date('Ymd_His') . '.jsonl';


      // Write the JSONL content to a file
      file_put_contents($file, $jsonlContent);

      $upload = $this->client->files()->upload([
        'purpose' => 'fine-tune',
        'file' => fopen($file, 'r'),
      ]);


      $job = $this->client->fineTuning()->createJob([
        'training_file' => $upload->id,
        'validation_file' => null,
        'model' => $model,
        'hyperparameters' => [
          'n_epochs' => 4,
        ],
        'suffix' => null,
      ]);

      var_dump($job->id);

      return $job->id;


      }


    /**************************  FILE HELPERS    *********************/
    // readFile - read file from openai folder

    public function readFile($file)
      {
      $data = file_get_contents($this->openai_folder . $file);
      return $data;
      }


    /**************************  OTHER HELPERS    *********************/
    // dateCorrect - correct date format

    public function dateCorrect($date)
      {
      $locale = 'de_DE';
      $lang = $this->language;

      if ($lang == LANG_EN) {
        $locale = 'en_US';
        }

      $format = $locale == 'de_DE' ? 'd. MMMM y' : "MMMM d, y";

      $title_date = datefmt_create(
        $locale,
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'Europe/Vienna',
        IntlDateFormatter::GREGORIAN,
        $format
      );

      $finaldate = datefmt_format($title_date, new \DateTime($date));

      return $finaldate;
      }

    }
