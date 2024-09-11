<?php defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'controllers/Backend.php');

class TextRepo extends Backend
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('entities/Content_model', 'cm');
		$this->load->model('Frontend_model', 'fm');
	}



	public function text()
	{

		$bc = new besc_crud();


		$data['show_mods'] = false;
		$bc->database(DB_NAME);
		$bc->main_title('Text Repository');
		$bc->table_name('Text Phrases');
		$bc->table('text_repo');
		$bc->primary_key('id');
		$bc->title('Text Phrase');
		$bc->list_columns(array('language_id', 'text_id', 'text'));
		$bc->filter_columns(array('language_id', 'text_id', 'text'));
		$bc->custom_buttons(array(
			/* array(
				'name' => 'Clone Article',
				'icon' => site_url('items/backend/img/clone_icon.png'),
				'add_pk' => true,
				'url' => 'clone_item'
			), */));


		$languages_array = array();
		$languages = $this->cm->get_languages();
		foreach ($languages as $language) {
			$languages_array[] = array('key' => $language->id, 'value' => $language->name);
		}


		$bc->columns(array(


			'language_id' => array(
				'db_name' => 'language_id',
				'type' => 'select',
				'options' => $languages_array,
				'display_as' => 'Language',
			),

			'text_id' => array(
				'db_name' => 'text_id',
				'type' => 'text',
				'display_as' => 'Text Id',
			),

			'text' => array(
				'db_name' => 'text',
				'type' => 'multiline',
				'height' => '120px',
				'display_as' => 'Text',
			),

		));

		$data['crud_data'] = $bc->execute();
		$this->page('backend/crud/crud', $data);
	}


	public function get_text_repo_info()
	{
		$languages = $this->cm->get_languages();
		$text_phrases = $this->cm->get_repo_texts();

		echo json_encode(array(
			'success' => true,
			'languages' => $languages,
			'text_phrases' => $text_phrases
		));
	}

	public function get_text_repo_text()
	{
		$column_name = $_POST['column_name'];
		$table_name = $_POST['table_name'];
		$row_id = $_POST['row_id'];
		$lang = $_POST['lang'];


		$text_phrases = $this->cm->get_repo_text($column_name, $table_name, $row_id, $lang);

		if ($lang >= 0) {

			$text_phrase = count($text_phrases) > 0 ? $text_phrases[0]->text : '';
		} else {
			$text_phrase = (count($text_phrases) > 0?count($text_phrases).'<br>':''). implode(',<br>', array_column($text_phrases, 'text'));
		}


		echo json_encode(array(
			'success' => true,
			'query' => 'fetch',
			'exists' => (count($text_phrases) > 0),
			'phrases' => $text_phrases,
			'text_phrase' => $text_phrase,
		));
	}

	public function set_text_repo_text()
	{
		$column_name = $_POST['column_name'];
		$table_name = $_POST['table_name'];
		$row_id = $_POST['row_id'];
		$lang = $_POST['lang'];
		$text = $_POST['text'];

		$text_phrases = $this->cm->get_repo_text($column_name, $table_name, $row_id, $lang, $text);

		if (count($text_phrases) > 0) {
			$this->cm->update_repo_text($text_phrases[0]->id, $text);
			$query = 'update';
		} else {
			$text_phrase_id = $this->cm->insert_repo_text($column_name, $table_name, $row_id, $lang, $text);
			$text_phrase = $this->cm->get_repo_text_by_id($text_phrase_id);
			$query = 'insert';
		}

		echo json_encode(array(
			'success' => true,
			'query' => $query,
			'phrases' => $text_phrases,
		));
	}
}
