<?	defined('BASEPATH') or exit('No direct script access allowed');



trait Helper_Backend
{



	/**************************    REGEX FUNCTIONS       *******************************/


	// This function tests the regex_match function by attempting to match the regex for is_unique[metatag.name]

	public function regex_test()
	{
		echo $this->regex_match('is_unique', 'is_unique[metatag.name]');
	}

		/**************************    CSV UPLOAD       *******************************/

		// csv_upload() is called by the frontend to display the upload form
		// upload_file() is called by the frontend to upload a CSV file to the server
		// handleCSVUpload() is called by the frontend to handle the uploaded CSV file

		public function csv_upload($itemId)
		{

			$data = array();

			$data['itemId'] = $itemId;

			$this->page('backend/upload_csv', $data);
		}


		public function upload_file()
		{
			$this->load->helper('besc_helper');

			$filename = $_POST['filename'];
			$upload_path = '/items/uploads/csv';
			if (substr($upload_path, -1) != '/')
				$upload_path .= '/';

			$rnd = rand_string(12);
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$serverFile = time() . "_" . $rnd . "." . $ext;

			$error = move_uploaded_file($_FILES['data']['tmp_name'], getcwd() . "/$upload_path/$serverFile");

			echo json_encode(
				array(
					'success' => true,
					'path' => getcwd() . "/$upload_path/$serverFile",
					'filename' => $serverFile
				)
			);
		}


		public function csvUpdateWhereId()
		{

			// EDIT THIS
			$divider = ','; // divider in csv file
			$keyOfItemId = 'event_id'; // key of item id in csv file
			$tableName = 'table'; // table name in database
			// order same as in csv file
			$keyArray = array('firstname', 'lastname', 'email', 'phone', 'num_reg_ppl'); // keys in csv file
			//

			$item_id = $_POST['iid'];
			$filename = $_POST['filename'];

			$filepath = getcwd() . "/items/uploads/csv/" . $filename;
			$open = fopen($filepath, 'r');

			$header = array();
			$data = array();

			$first = true;

			while (!feof($open)) {
				if ($first) {
					$tempArray = explode($divider, fgets($open));
					array_push($header, $tempArray);
					$first = false;
				} else {
					$tempArray = explode($divider, fgets($open));
					array_push($data, $tempArray);
				}
			}
			//  array_pop($data);

			$returnData = array();
			$rowCounter = 1;

			$update_data = array();
			foreach ($data as $dataRow) {


				if (!empty($dataRow)) {

					if (count($dataRow) > 1) {
						$update_data[$keyOfItemId] = $item_id;

						foreach ($keyArray as $key => $value) {
							$update_data[$value] = $dataRow[$key];
						}

						$this->cm->updateKeyWithData($tableName, $keyOfItemId, $item_id, $update_data);


						array_push($returnData, $update_data);
					}

				}

				$rowCounter++;
			}

			fclose($open);
			if (file_exists($filepath))
				unlink($filepath);

			echo json_encode(array('status' => 'success', 'returndata' => $returnData));
		}



}