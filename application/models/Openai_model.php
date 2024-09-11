<?php

class Openai_model extends CI_Model
  {

  // models settings

  public function getOpenaiModelSettingsById($id)
    {
    $this->db->where('id', $id);
    $result = $this->db->get('openai_models');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }

  // languages and translations

  public function saveLanguage($data)
    {
    $this->db->insert('openai_languages', $data);
    return $this->db->insert_id();
    }

  public function saveQuestionTranslation($data)
    {
    $this->db->insert('openai_question_translations', $data);
    return $this->db->insert_id();
    }

  public function getOpenaiLanguages()
    {

    $result = $this->db->get('openai_languages');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getOpenaiLanguageById($id)
    {
    $this->db->where('id', $id);
    $result = $this->db->get('openai_languages');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getOpenaiTranslationsByPromptIdAndLanguage($prompt, $language)
    {
    $this->db->where('prompt_id', $prompt);
    $this->db->where('language', $language);
    $result = $this->db->get('openai_question_translations');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }


  public function getOpenaiTranslationsByPromptId($id)
    {
    $this->db->where('prompt_id', $id);
    $result = $this->db->get('openai_question_translations');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }


  // universal function
  public function saveOpenaiToTable($data, $table)
    {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
    }

  // debug
  public function saveOpenaiDebug($data)
    {
    $this->db->insert('openai_debug', $data);
    return $this->db->insert_id();
    }

  // inputs
  public function saveInput($data)
    {
    $this->db->insert('openai_inputs', $data);
    return $this->db->insert_id();
    }

  public function getInputById($id)
    {
    $this->db->where('id', $id);
    $result = $this->db->get('openai_inputs');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }

  //  chats saved
  public function saveOpenaiChat($data)
    {
    $this->db->insert('openai_chats', $data);
    return $this->db->insert_id();
    }

  public function saveOpenaiChatLog($data)
    {
    $this->db->insert('openai_chat_log', $data);
    return $this->db->insert_id();
    }

  public function openaigetLastChat()
    {
    $this->db->select('*');
    $this->db->from('openai_chats');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get();
    return $query->row_array();
    }

  // getting data
  public function getItemByPrettyUrl($pretty_url)
    {
    $this->db->where('pretty_url', $pretty_url);
    $result = $this->db->get('items');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }
  public function getSomeTextModule($id)
    {
    $this->db->order_by('top', 'ASC');
    $this->db->where('item_id', $id);
    $result = $this->db->get('module_text');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getAboutRelation()
    {
    $this->db->where('tag_id', 2);
    $result = $this->db->get('items_tags_relation');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getProjectArticles()
    {
    $this->db->where('type', PROJECT_ARTICLE);
    $result = $this->db->get('items');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getBrandArticles()
    {
    $result = $this->db->get('brands');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  // getting prompts

  public function getOpenaiPromptByArea($area)
    {
    $this->db->where('area', $area);
    $result = $this->db->get('openai_prompts');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getOpenaiPromptByTopic($topic)
    {
    $this->db->where('topic', $topic);
    $result = $this->db->get('openai_prompts');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }

  public function getOpenaiPromptByAreaAndTopic($area, $topic)
    {
    $this->db->where('area', $area);
    $this->db->where('topic', $topic);
    $result = $this->db->get('openai_prompts');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }


  public function getOpenaiPrompts()
    {
    $result = $this->db->get('openai_prompts');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getPromptsToTranslate()
    {
    $this->db->where('is_translated', 1);
    $result = $this->db->get('openai_prompts');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }


  public function getOpenaiPromptById($id)
    {
    $this->db->where('id', $id);
    $result = $this->db->get('openai_prompts');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }



  // langlines

  public function getOpenaiLanglines()
    {
    $result = $this->db->get('openai_langlines');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getOpenaiLangLineByIdAndLanguage($id, $language)
    {
    $this->db->where('id', $id);
    $this->db->where('language', $language);
    $result = $this->db->get('openai_langlines');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getOpenaiLangLineByKeyAndLanguage($key, $language)
    {
    $this->db->where('key', $key);
    $this->db->where('language', $language);
    $result = $this->db->get('openai_langlines');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }

  public function saveOpenaiLangline($data)
    {
    $this->db->insert('openai_langlines', $data);
    return $this->db->insert_id();
    }


  // teaching
  public function getCheckedChatLogs($topic)
    {
    $this->db->where('topic', $topic);
    $this->db->where('checked', 1);
    $result = $this->db->get('openai_chat_log');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  public function getChatById($id)
    {
    $this->db->where('chat_id', $id);
    $result = $this->db->get('openai_chats');
    return ($result->num_rows() > 0) ? $result->result() : array();
    }

  // feedback

  public function getOpenaiLanguageByLanguage($language)
    {
    $this->db->where('language', $language);
    $result = $this->db->get('openai_languages');
    return ($result->num_rows() > 0) ? $result->row() : false;
    }

  // feedback

  public function addThumbToChatId($id)
    {
    $this->db->where('id', $id);
    $this->db->set('checked', 1);
    $this->db->update('openai_chat_log');

    // Check if the update was successful
    if ($this->db->affected_rows() > 0) {
      return $id;
      } else {
      return false;
      }
    }
  }