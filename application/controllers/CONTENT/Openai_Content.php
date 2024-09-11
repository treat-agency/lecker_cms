<? defined('BASEPATH') or exit('No direct script access allowed');


trait Openai_Content
{
  /***************?      PAGE       ***************************/


  public function openai_chat_log()
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();

    $segments = $bc->get_state_info_from_url();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Chats');
    $bc->table('openai_chat_log');
    $bc->primary_key('id');
    $bc->title('Menu');
    $bc->list_columns(array('topic', 'checked', 'created_at'));
    $bc->filter_columns(array('topic', 'checked', 'created_at'));
    $bc->custom_buttons(
      array(
        array(
          'name' => 'Chat',
          'icon' => site_url('items/backend/img/icon_itemlist.png'),
          'add_pk' => true,
          'url' => 'openai_chats'
        ),
      )
    );



    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');

    $topics = $this->om->getOpenaiPrompts();
    $topics_array = array();
    foreach ($topics as $topic) {
      $topics_array[] = array('key' => $topic->topic, 'value' => $topic->area . ' - ' . $topic->topic);
    }

    $bc->columns(
      array(

        'checked' => array(
          'db_name' => 'checked',
          'type' => 'select',
          'options' => $select_array,
          'display_as' => 'Checked',
        ),


        'created_at' => array(
          'db_name' => 'created_at',
          'type' => 'text',
          'display_as' => 'Created at',
        ),



        'topic' => array(
          'db_name' => 'topic',
          'type' => 'select',
          'options' => $topics_array,
          'display_as' => 'topic',
        ),


      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud/crud', $data);
  }

  public function openai_models()
    {

    if ($this->user->is_admin != 1) {
      redirect('');
      }

    $bc = new besc_crud();

    $segments = $bc->get_state_info_from_url();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Model Settings');
    $bc->table('openai_models');
    $bc->primary_key('id');
    $bc->title('Models');
    $bc->list_columns(array('name', 'key', 'temperature', 'max_tokens', 'frequency_penalty', 'presence_penalty'));
    $bc->filter_columns(array('name', 'key', 'temperature', 'max_tokens', 'frequency_penalty', 'presence_penalty'));
    $bc->custom_buttons(array());

    $scales_array = array();
    $scales_array[] = array('key' => 0.0, 'value' => 0.0);
    $scales_array[] = array('key' => 0.1, 'value' => 0.1);
    $scales_array[] = array('key' => 0.2, 'value' => 0.2);
    $scales_array[] = array('key' => 0.3, 'value' => 0.3);
    $scales_array[] = array('key' => 0.4, 'value' => 0.4);
    $scales_array[] = array('key' => 0.2, 'value' => 0.2);
    $scales_array[] = array('key' => 0.5, 'value' => 0.5);
    $scales_array[] = array('key' => 0.6, 'value' => 0.6);
    $scales_array[] = array('key' => 0.7, 'value' => 0.7);
    $scales_array[] = array('key' => 0.8, 'value' => 0.8);
    $scales_array[] = array('key' => 0.9, 'value' => 0.9);
    $scales_array[] = array('key' => 1.0, 'value' => 1.0);
    $scales_array[] = array('key' => 1.1, 'value' => 1.1);
    $scales_array[] = array('key' => 1.2, 'value' => 1.2);
    $scales_array[] = array('key' => 1.3, 'value' => 1.3);
    $scales_array[] = array('key' => 1.4, 'value' => 1.4);
    $scales_array[] = array('key' => 1.5, 'value' => 1.5);
    $scales_array[] = array('key' => 1.6, 'value' => 1.6);
    $scales_array[] = array('key' => 1.7, 'value' => 1.7);
    $scales_array[] = array('key' => 1.8, 'value' => 1.8);
    $scales_array[] = array('key' => 1.9, 'value' => 1.9);
    $scales_array[] = array('key' => 2.0, 'value' => 2.0);

    $scales_array2 = array();
    $scales_array2[] = array('key' => 0.0, 'value' => 0.0);
    $scales_array2[] = array('key' => 0.1, 'value' => 0.1);
    $scales_array2[] = array('key' => 0.2, 'value' => 0.2);
    $scales_array2[] = array('key' => 0.3, 'value' => 0.3);
    $scales_array2[] = array('key' => 0.4, 'value' => 0.4);
    $scales_array2[] = array('key' => 0.5, 'value' => 0.5);
    $scales_array2[] = array('key' => 0.6, 'value' => 0.6);
    $scales_array2[] = array('key' => 0.7, 'value' => 0.7);
    $scales_array2[] = array('key' => 0.8, 'value' => 0.8);
    $scales_array2[] = array('key' => 0.9, 'value' => 0.9);
    $scales_array2[] = array('key' => 1.0, 'value' => 1.0);


    $number_of_tokens = array();
    $number_of_tokens[] = array('key' => 500, 'value' => 500);
    $number_of_tokens[] = array('key' => 1000, 'value' => 1000);
    $number_of_tokens[] = array('key' => 1500, 'value' => 1500);
    $number_of_tokens[] = array('key' => 2000, 'value' => 2000);
    $number_of_tokens[] = array('key' => 3000, 'value' => 3000);
    $number_of_tokens[] = array('key' => 4096, 'value' => 4096);

    $bc->columns(
      array(

        'name' => array(
          'db_name' => 'name',
          'type' => 'text',
          'display_as' => 'Name',
        ),

        'key' => array(
          'db_name' => 'key',
          'type' => 'text',
          'display_as' => 'Key',
          'col_info' => 'OPTIONAL. This is the key used in the code to identify the model. It is case sensitive.',
        ),

        'temperature' => array(
          'db_name' => 'temperature',
          'type' => 'select',
          'options' => $scales_array,
          'display_as' => 'Temperature',
          'col_info' => "The temperature is used to control the randomness of the output. When you set it higher, you'll get more random outputs. When you set it lower, towards 0, the values are more deterministic.",
        ),

        'max_tokens' => array(
          'db_name' => 'max_tokens',
          'type' => 'select',
          'options' => $number_of_tokens,
          'display_as' => 'Max Tokens',
          'col_info' => 'The maximum number of tokens to output.',
        ),

        'frequency_penalty' => array(
          'db_name' => 'frequency_penalty',
          'type' => 'select',
          'options' => $scales_array2,
          'display_as' => 'Frequency Penalty',
          'col_info' => 'The frequency penalty addresses a common problem in text generation: repetition. By applying penalties to frequently appearing words, the model is encouraged to diversify language use. Higher values mean more penalty.',
        ),

        'presence_penalty' => array(
          'db_name' => 'presence_penalty',
          'type' => 'select',
          'options' => $scales_array2,
          'display_as' => 'Presence Penalty',
          'col_info' => 'Frequency Penalty helps us avoid using the same words too often. Higher value means more often using different words.',
        ),

      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud', $data);
    }



  public function openai_chats($id)
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Chat Logs');
    $bc->table('openai_chats');
    $bc->where('chat_id = ' . $id);
    $bc->primary_key('id');
    $bc->title('Chat');
    $bc->list_columns(array('role', 'message'));
    $bc->filter_columns(array('role', 'message'));
    $bc->custom_buttons(array());






    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');

    $role_select[] = array('key' => "assistant", 'value' => 'assistant');
    $role_select[] = array('key' => "user", 'value' => 'user');
    $role_select[] = array('key' => "system", 'value' => 'system');

    $topics = $this->om->getOpenaiPrompts();
    $topics_array = array();
    foreach ($topics as $topic) {
      $topics_array[] = array('key' => $topic->topic, 'value' => $topic->area . ' - ' . $topic->topic);
    }


    $bc->columns(
      array(




        'role' => array(
          'db_name' => 'role',
          'type' => 'select',
          'options' => $role_select,
          'display_as' => 'Role',
        ),

        'message' => array(
          'db_name' => 'message',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Message',
        ),



      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud/crud', $data);
  }



  public function openai_question_translations()
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Question Translations');
    $bc->table('openai_question_translations');
    $bc->primary_key('id');
    $bc->title('Translation');
    $bc->list_columns(array('prompt_id', 'language', 'question'));
    $bc->filter_columns(array('prompt_id', 'language', 'question'));
    $bc->custom_buttons(array());



    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');

    $prompts_array = array();
    $prompts = $this->om->getOpenaiPrompts();
    foreach ($prompts as $prompt) {
      $prompts_array[] = array('key' => $prompt->id, 'value' => $prompt->area . ' - ' . $prompt->topic);
    }

    $languages_array = array();
    $languages = $this->om->getOpenaiLanguages();
    foreach ($languages as $language) {
      $languages_array[] = array('key' => $language->id, 'value' => $language->language);
    }


    $bc->columns(
      array(
        'prompt_id' => array(
          'db_name' => 'prompt_id',
          'type' => 'select',
          'options' => $prompts_array,
          'display_as' => 'Prompt',
        ),

        'language' => array(
          'db_name' => 'language',
          'type' => 'select',
          'options' => $languages_array,
          'display_as' => 'Language',
        ),

        'question' => array(
          'db_name' => 'question',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Question',
        ),

      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud/crud', $data);
  }

  public function openai_langlines()
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Question Langlines');
    $bc->table('openai_langlines');
    $bc->primary_key('id');
    $bc->title('Langline');
    $bc->list_columns(array('key', 'language', 'translation'));
    $bc->filter_columns(array('key', 'language', 'translation'));
    $bc->custom_buttons(array());



    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');


    $languages_array = array();
    $languages = $this->om->getOpenaiLanguages();
    foreach ($languages as $language) {
      $languages_array[] = array('key' => $language->id, 'value' => $language->language);
    }


    $bc->columns(
      array(
        'key' => array(
          'db_name' => 'key',
          'type' => 'text',
          'display_as' => 'Key',
        ),

        'language' => array(
          'db_name' => 'language',
          'type' => 'select',
          'options' => $languages_array,
          'display_as' => 'Language',
        ),

        'translation' => array(
          'db_name' => 'translation',
          'type' => 'text',
          'display_as' => 'Translation',
        ),

      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud/crud', $data);
  }

  public function openai_inputs()
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Inputs');
    $bc->table('openai_inputs');
    $bc->primary_key('id');
    $bc->title('Langline');
    $bc->list_columns(array('topic', 'input'));
    $bc->filter_columns(array('topic', 'input'));
    $bc->custom_buttons(array());



    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');


    $languages_array = array();
    $languages = $this->om->getOpenaiLanguages();
    foreach ($languages as $language) {
      $languages_array[] = array('key' => $language->id, 'value' => $language->language);
    }


    $bc->columns(
      array(

        'topic' => array(
          'db_name' => 'topic',
          'type' => 'text',
          'display_as' => 'Topic',
        ),

        'input' => array(
          'db_name' => 'input',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Input',
        ),
      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud/crud', $data);
  }


  public function openai_languages()
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Languages');
    $bc->table('openai_languages');
    $bc->primary_key('id');
    $bc->title('Language');
    $bc->list_columns(array('language'));
    $bc->filter_columns(array('language'));
    $bc->custom_buttons(array());



    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');

    $prompts_array = array();
    $prompts = $this->om->getOpenaiPrompts();
    foreach ($prompts as $prompt) {
      $prompts_array[] = array('key' => $prompt->id, 'value' => $prompt->area . ' - ' . $prompt->topic);
    }


    $bc->columns(
      array(

        'language' => array(
          'db_name' => 'language',
          'type' => 'text',
          'display_as' => 'Language',
        ),


      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud/crud', $data);
  }



  public function openai_prompts()
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Prompts');
    $bc->table('openai_prompts');
    $bc->primary_key('id');
    $bc->title('Prompt');
    $bc->list_columns(array('area', 'topic', 'question', 'user_prompt', 'system_prompt', 'model', 'is_translated', 'debug'));
    $bc->filter_columns(array('area', 'topic', 'question', 'user_prompt', 'system_prompt', 'model', 'is_translated', 'debug'));
    $bc->custom_buttons(array());



    $models_array = $this->getSelector('openai_models', 'name', 'key', false);


    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');


    $area_array[] = array('key' => "user", 'value' => 'user');
    $area_array[] = array('key' => "general", 'value' => "general");


    $bc->columns(
      array(


        'area' => array(
          'db_name' => 'area',
          'type' => 'text',
          'display_as' => 'Area',
        ),

        'topic' => array(
          'db_name' => 'topic',
          'type' => 'text',
          'display_as' => 'Topic',
        ),

        'model' => array(
          'db_name' => 'model',
          'type' => 'select',
          'options' => $models_array,
          'display_as' => 'Model',
        ),

        'question' => array(
          'db_name' => 'question',
          'type' => 'ckeditor',
          'height' => '300',
          'col_info' => 'Real text of question is managed in Question Translations',
          'display_as' => 'Question Intern / Button Text',
        ),

        'user_prompt' => array(
          'db_name' => 'user_prompt',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'User Prompt',
        ),

        'system_prompt' => array(
          'db_name' => 'system_prompt',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'System Prompt',
        ),



        'is_translated' => array(
          'db_name' => 'is_translated',
          'type' => 'select',
          'options' => $select_array,
          'display_as' => 'Is Translated?',
        ),

        'debug' => array(
          'db_name' => 'debug',
          'type' => 'select',
          'options' => $select_array,
          'display_as' => 'Debug Mode',
        ),

      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud/crud', $data);
  }

  public function openai_debug()
  {

    if ($this->user->is_admin != 1) {
      redirect('');
    }

    $bc = new besc_crud();
    $data['show_mods'] = false; //Toggle for module editor

    $bc->database(DB_NAME);
    $bc->main_title('Openai');
    $bc->table_name('Prompts');
    $bc->table('openai_debug');
    $bc->primary_key('id');
    $bc->title('Prompt');
    $bc->list_columns(array('topic', 'timestamp', 'model_settings'));
    $bc->filter_columns(array('topic', 'model_settings', 'timestamp', 'user_input', 'data', 'placeholder1', 'placeholder2', 'placeholder3', 'placeholder4', 'user_prompt_raw', 'user_prompt', 'system_prompt', 'response'));
    $bc->custom_buttons(array());



    $select_array[] = array('key' => 0, 'value' => 'NO');
    $select_array[] = array('key' => 1, 'value' => 'YES');




    $bc->columns(
      array(
        'topic' => array(
          'db_name' => 'topic',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Topic',
        ),

        'model_settings' => array(
          'db_name' => 'model_settings',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Model Settings',
        ),

        'timestamp' => array(
          'db_name' => 'timestamp',
          'type' => 'text',
          'display_as' => 'Timestamp',
        ),

        'system_prompt' => array(
          'db_name' => 'system_prompt',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'System Prompt',
        ),

        'user_prompt_raw' => array(
          'db_name' => 'user_prompt_raw',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'User Prompt Raw',
        ),

        'data' => array(
          'db_name' => 'data',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Data',
        ),

        'response' => array(
          'db_name' => 'response',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Response',
        ),

        'user_prompt' => array(
          'db_name' => 'user_prompt',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'User Prompt',
        ),

        'user_input' => array(
          'db_name' => 'user_input',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'User Input',
        ),

        'placeholder1' => array(
          'db_name' => 'placeholder1',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Placeholder 1',
        ),

        'placeholder2' => array(
          'db_name' => 'placeholder2',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Placeholder 2',
        ),

        'placeholder3' => array(
          'db_name' => 'placeholder3',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Placeholder 3',
        ),

        'placeholder4' => array(
          'db_name' => 'placeholder4',
          'type' => 'ckeditor',
          'height' => '300',
          'display_as' => 'Placeholder 4',
        ),

      )
    );

    $data['crud_data'] = $bc->execute();
    $this->page('backend/crud', $data);
  }
}