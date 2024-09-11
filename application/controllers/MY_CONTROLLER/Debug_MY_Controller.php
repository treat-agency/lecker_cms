<? defined('BASEPATH') or exit('No direct script access allowed');


trait MY_Controller_Debug
  {

  // comment

  public function insertError($error_msg = 'Undefined Error Message', $page = 'Undefined Page', $file = '', $line = '')
    {

    $file = $file != '' ? $file : debug_backtrace()[0]['file'];
    $line = $line != '' ? $line : debug_backtrace()[0]['line'];

    $error_data = array(
      'text' => $error_msg,
      'page' => $page,
      'line' => $line,
      'file' => $file

    );

    $this->db->insert('error_log', $error_data);
    exit;
    }


  public function function_exists($method)
    {
    $method = $method;
    if (method_exists($this, $method)) {
      return true;
      }
    return false;
    }


  public function methodExists($model_shortcut, $method, $topic = 'Undefined Topic')
    {
    if (!$this->{$model_shortcut}->method_exists($method)) {
      $this->insertError($topic . ': ' . $model_shortcut . ' method ' . $method . ' does not exist', current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
      exit;

      }
    }

  public function functionExists($function_name, $topic = 'Undefined Topic')
    {
    if (!$this->function_exists($function_name)) {
      $this->insertError($topic . ': ' . $function_name . ' method ' . $function_name . ' does not exist', current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
      exit;

      }
    }

  public function tableExists($table_name, $topic = 'Undefined Topic')
    {
    if (!$this->db->table_exists($table_name)) {
      $this->insertError($topic . ': ' . 'Table ' . $table_name . ' does not exist.', current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
      exit;
      }
    }

  public function variableExists($variable_name, $variable, $topic = 'Undefined Topic')
    {
    if ($variable === false || $variable === null || $variable == 'undefined') {
      $this->insertError($topic . ': ' . 'Variable ' . $variable_name . ' does not exist.', current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
      exit;
      }
    }


  public function postPropertiesExist($properties, $topic = 'Undefined Topic')
    {
    foreach ($properties as $p) {
      if (!isset($_POST[$p])) {
        $this->insertError($topic . ': ' . $p . ' not properly sent via ajax post method', current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
        exit;
        }
      }
    }



  }
