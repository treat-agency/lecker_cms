<?	defined('BASEPATH') or exit('No direct script access allowed');

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;

trait Helper_Content
{

    public function prepareTable()
    {

        $this->authentication();

        // $this->articleOrNoarticle();

        $this->createCustomButtons();


        $this->createBC();



        }

    public function authentication()
        {
        if ($this->user->is_admin != 1) {
            redirect('');
            }
        }




    public function createCustomButtons()
        {
        switch ($this->typeOfTable) {
            case TABLE_ENTITY_WITH_ARTICLE:

                $this->ArticleOrNoarticleOrNoneType = ARTICLE;

                $this->solveTypes();
                /************ BUTTONS FOR ARTICLE ENTITIES **************/


                $this->customButtons = (
                    array(

                        // IMPORTANT: edit teaser and clone_item_universal are both universal functions. Modify within them different behavior
                        // based on type if necessary
                        array(
                            'name' => 'Clone',
                            'icon' => site_url('items/backend/icons/cloneIcon.svg'),
                            'add_pk' => true,
                            'add_type' => $this->entityTypeId,
                            // required for type specific cloning of columns and relations
                            'url' => 'clone_universal'
                        ),
                        array(
                            'name' => 'Teaser Images',
                            'icon' => site_url('items/backend/img/teaser_images.png'),
                            'add_pk' => true,
                            'add_type' => $this->entityTypeId,
                            // required for type specific teaser images relation
                            'url' => 'teaser_selector'
                        ),
                    )
                );
                break;

            case TABLE_NOARTICLE_WITH_ALL_BUTTONS:

                $this->ArticleOrNoarticleOrNoneType = NOARTICLE;
                $this->solveTypes();
                // STANDARD BUTTONS
                $this->customButtons = array(
                    array(
                        'name' => 'Clone',
                        'icon' => site_url('items/backend/img/clone_icon.png'),
                        'add_pk' => true,
                        'add_type' => 'noarticle/' . $this->entityTypeId . '/' . '1',
                        // special case for cloning noarticle table row
                        'url' => 'clone_universal'
                    ),

                    array(
                        'name' => 'Teaser Images',
                        'icon' => site_url('items/backend/img/teaser_images.png'),
                        'add_pk' => true,
                        'add_type' => $this->entityTypeId,
                        'has_article' => false,
                        // important for saving teaser images also on noarticle entities
                        'url' => 'teaser_selector'
                    ),
                );

                break;

            case TABLE_NOARTICLE_JUST_CLONE:

                $this->ArticleOrNoarticleOrNoneType = NOARTICLE;
                $this->solveTypes();
                /************ GETTING TYPE OF NOARTICLE AND CUSTOM BUTTONS **************/

                // STANDARD BUTTONS
                $this->customButtons = array(
                    array(
                        'name' => 'Clone',
                        'icon' => site_url('items/backend/img/clone_icon.png'),
                        'add_pk' => true,
                        'add_type' => 'noarticle/' . $this->entityTypeId . '/' . '0',
                        // special case for cloning noarticle table row
                        'url' => 'clone_universal'
                    ),
                );


                break;
            default:

                $this->ArticleOrNoarticleOrNoneType = NONE;

                $this->customButtons = array();


            }
        }


    public function solveTypes()
        {

        if ($this->ArticleOrNoarticleOrNoneType == ARTICLE) {
            $this->variableExists($this->table, ARTICLE_TYPES[$this->table]['type_id'], 'Article Type ' . $this->table . ' not found in constants.php');
            $this->entityTypeId = ARTICLE_TYPES[$this->table]['type_id'];


            } else if ($this->ArticleOrNoarticleOrNoneType == NOARTICLE) {
            $this->variableExists($this->table, NOARTICLE_TYPES[$this->table]['type_id'], 'Noarticle Type' . $this->table . 'note found in constants.php');
            $this->entityTypeId = NOARTICLE_TYPES[$this->table]['type_id'];
            }


        }

    public function solvePagination()
        {


        if (isset($_GET['pagination'])) {
            if ($_GET['pagination'] == 'all') {
                $pagination = 100000;
                } else {
                $pagination = $_GET['pagination'];
                }
            } else {
            $pagination = ROWS_PER_PAGE_OF_TABLE;
            }

        $this->pagination = $pagination;
        }

    public function createBC()
        {

        $this->bc = new besc_crud();

        $segments = $this->bc->get_state_info_from_url();

        $this->bc->custom_buttons($this->customButtons);
        $this->bc->database(DB_NAME);
        $this->bc->main_title($this->groupName);
        $this->bc->table_name($this->tablePrettyName);
        $this->bc->table($this->table); // equals name of this function
        $this->bc->primary_key('id');
        $this->bc->title($this->tablePrettyNameSingular);


        $this->bc->list_columns($this->listColumns);
        $this->bc->filter_columns($this->filterColumns);
        $this->bc->columns($this->columns);

        $this->bc->languageArray = $this->getLangArray();

        if ($this->ArticleOrNoarticleOrNoneType == ARTICLE) {

            $this->bc->article_type($this->entityTypeId);
            } else if ($this->ArticleOrNoarticleOrNoneType == NOARTICLE) {
            $this->bc->noarticle_type($this->entityTypeId);
            }



    }







//


    public function setTableName()
        {
        $backtrace = debug_backtrace();
        $caller = $backtrace[1]['function'];

        $this->table = $caller;


        $this->checkPluralFunctionName();

        $this->tableSingular = $this->singularizeName($this->table);
        $this->tablePrettyName = $this->getPrettyName($this->table);
        $this->tablePrettyNameSingular = $this->singularizeName($this->tablePrettyName);

        }

    public function checkPluralFunctionName()
        {
        $exceptions = ['information', 'equipment', 'rice', 'money', 'species', 'series', 'fish', 'sheep', 'moose', 'deer', 'news']; // add more if needed

        if (!substr($this->table, -1) == "s" && !in_array($this->table, $exceptions)) {
            $this->insertError('Name of table and function needs to be with -s at the end or be an exception', current_url(), debug_backtrace()[0]['file'], debug_backtrace()[0]['line']);
            }

        }


    public function getLangArray()
    {
        if (NUMBER_OF_LANGUAGES == 1 && MAIN_LANGUAGE == 'de') {
            $lang_array[] = array('key' => MAIN_LANGUAGE, 'value' => 'German', 'short_caps' => strtoupper(SECOND_LANGUAGE));
        } elseif (NUMBER_OF_LANGUAGES == 1 && MAIN_LANGUAGE == 'en') {
            $lang_array[] = array('key' => MAIN_LANGUAGE, 'value' => 'English', 'short_caps' => strtoupper(MAIN_LANGUAGE));
        } elseif (NUMBER_OF_LANGUAGES == 2 && MAIN_LANGUAGE == 'de') {
            $lang_array[] = array('key' => MAIN_LANGUAGE, 'value' => 'German', 'short_caps' => strtoupper(SECOND_LANGUAGE));
            $lang_array[] = array('key' => SECOND_LANGUAGE, 'value' => 'English', 'short_caps' => strtoupper(SECOND_LANGUAGE));
        } elseif (NUMBER_OF_LANGUAGES == 2 && MAIN_LANGUAGE == 'en') {
            $lang_array[] = array('key' => MAIN_LANGUAGE, 'value' => 'English' ,'short_caps' => strtoupper(MAIN_LANGUAGE));
            $lang_array[] = array('key' => strtoupper(SECOND_LANGUAGE), 'value' => 'German');
        }

        return $lang_array;
    }


    /**************************    GOOGLE ANALYTICS API    *******************************/

    public function initializeAnalytics()
    {
        // Creates and returns the Analytics Reporting service object.

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = getcwd() . '/items/frontend/js/ga_credentials.json';

        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName("Google Analytics Homepage");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Google_Service_Analytics($client);

        return $analytics;
    }


    public function GA_Analytics_Cities()
    {

        // last week
        $dateRanges = [
            'startDate' => date('Y-m-d', strtotime('-1 year')),
            'endDate' => date('Y-m-d')
        ];

        $property_id = GA_PROPERTY_ID;

        // Using a default constructor instructs the client to use the credentials
// specified in GOOGLE_APPLICATION_CREDENTIALS environment variable.
        $client = new BetaAnalyticsDataClient([
            'credentials' => getcwd() . '/items/frontend/js/ga_credentials.json',
        ]);

        // Make an API call.
        $response = $client->runReport([
            'property' => 'properties/' . $property_id,
            'dateRanges' => [
                new DateRange([
                    'start_date' => $dateRanges['startDate'],
                    'end_date' => $dateRanges['endDate'],
                ]),
            ],
            'dimensions' => [
                new Dimension(
                    [
                        'name' => 'city',
                    ]
                ),
            ],
            'metrics' => [
                new Metric(
                    [
                        'name' => 'activeUsers',
                    ]
                )
            ],
            'filtersExpression' => 'ga:hostname==' . site_url() // Replace example.com with your site's hostname
        ]);

        // Print results of an API call.
        // print 'Report result: ' . PHP_EOL;

        $return = array();
        foreach ($response->getRows() as $row) {
            $return[] = array(
                'city' => $row->getDimensionValues()[0]->getValue(),
                'number' => $row->getMetricValues()[0]->getValue()
            );
        }


        return $return;
    }

    public function GA_Analytics_User_Data()
    {

        // last week
        $dateRanges = [
            'startDate' => date('Y-m-d', strtotime('-1 day')),
            'endDate' => date('Y-m-d')
        ];

        $property_id = GA_PROPERTY_ID;

        // Using a default constructor instructs the client to use the credentials
// specified in GOOGLE_APPLICATION_CREDENTIALS environment variable.
        $client = new BetaAnalyticsDataClient([
            'credentials' => getcwd() . '/items/frontend/js/ga_credentials.json',
        ]);

        // Make an API call.
        $response = $client->runReport([
            'property' => 'properties/' . $property_id,
            'dateRanges' => [
                new DateRange([
                    'start_date' => $dateRanges['startDate'],
                    'end_date' => $dateRanges['endDate'],
                ]),
            ],
            'dimensions' => [
                new Dimension(
                    [
                        'name' => 'city',
                    ],
                ),
                new Dimension([
                    'name' => 'firstUserSource',
                ]),

                new Dimension(
                    [
                        'name' => 'date',
                    ]
                ),




            ],
            'metrics' => [
                new Metric(
                    [
                        'name' => 'activeUsers',
                    ]
                ),
                new Metric([
                    "name" => "sessions"
                ])

            ],
            'filtersExpression' => 'ga:hostname==' . site_url() . ';ga:pagePath==/',

        ]);



        $params = [
            'dimensions' => [
                new Dimension([
                    'name' => 'city',
                ]),
                new Dimension([
                    'name' => 'firstUserSource',
                ]),
                new Dimension([
                    'name' => 'date',
                ])
            ],
            'metrics' => [
                new Metric([
                    'name' => 'activeUsers',
                ]),
                new Metric([
                    'name' => 'sessions',
                ])
            ],
            'filtersExpression' => 'ga:hostname==' . site_url() . ';ga:pagePath==/',
            'dateRanges' => [
                new DateRange([
                    'start_date' => $dateRanges['startDate'],
                    'end_date' => $dateRanges['endDate'],
                ]),
            ],
        ];


        // Print results of an API call.
        // print 'Report result: ' . PHP_EOL;

        foreach ($response->getRows() as $row) {

            $return[] = [
                'city' => $row->getDimensionValues()[0]->getValue(),
                'source' => $row->getDimensionValues()[1]->getValue(),
                'users' => $row->getMetricValues()[0]->getValue(),
                'sessions' => $row->getMetricValues()[1]->getValue(),
                'date' => $row->getDimensionValues()[2]->getValue(),

            ];

        }

        // var_dump($return);

    }

    /**************************    CSV TABLE    *******************************/



    function csvToDb($tableName)
        {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['file'])) {
                $temp_file = $_FILES['file'];

                // Check for upload errors
                if ($temp_file['error'] != 0) {
                    die('An error occurred during the file upload');
                    }

        // Open the CSV file
        $file = fopen($temp_file['tmp_name'], 'r');

        // Read the first line and get the column names
        $columns = fgetcsv($file, 0, ";");


        foreach ($columns as $i => $column) {
                    preg_match('/^(.*?)\s/', $column, $matches);
                    $columns[$i] = $matches[1];
        }



        // var_dump($columns);

        $data = [];

        // Loop through the rest of the CSV file
        while ($row = fgetcsv($file, 0, ';')) {

            // Prepare an associative array with the values from the CSV file
            $data[] = array_combine($columns, $row);
        }

                foreach ($data as $row) {
                    try {
                        $this->db->insert($tableName, $row);
                        if ($this->db->error()['code'] != 0) {
                            $response = array(
                                'error' => true,
                                'message' => 'Error during insert: ' . $this->db->error()['message']
                            );
                            echo json_encode($response);
                            die();

                            } else {
                            echo json_encode(array('success' => true));
                         }
                        } catch (Exception $e) {
                        // Handle the error
                        $response = array(
                            'error' => true,
                            'message' => 'Error during insert: ' . $e->getMessage()
                        );
                        echo json_encode($response);
                        die();
                        }

                }

                fclose($file);


                }



            }
        }



    public function dbTableToBlankCSV($tableName)
        {

        // Open a new CSV file for writing
        $filePath = $this->createNewCSVFile($tableName);

        $header = $this->getMeTableColumns($tableName);

;
        // Prepare the second row with blank fields
        $rows = array_fill(0, count($header), '');
        $rowsArray = array($rows);


        $this->makeCSV($filePath, $header, $rowsArray);

        $downloadMessage = $this->downloadCSVFile($filePath);

        echo json_encode($downloadMessage);

    }


    function exportTableToCSV($tableName)
        {


        $filePath = $this->createNewCSVFile($tableName);

        $header = $this->getMeTableColumns($tableName);

        $tableData = $this->fm->getAnything($tableName);

        // Initialize an empty array for the rows
        $rows = [];

        // Loop through the data
        foreach ($tableData as $object) {
            // Convert the object to an array and add it to the rows
            $rows[] = array_values((array) $object);
        }

        $this->makeCSV($filePath, $header, $rows);

        $downloadMessage = $this->downloadCSVFile($filePath);

        echo json_encode($downloadMessage);

        }

    public function makeCSV($filePath, $header, $rows)
        {
        $file = fopen($filePath, 'w');

        // Write the first row to the CSV file
        fputcsv($file, $header, ';');

        // Write the second row to the CSV file

        foreach ($rows as $row) {
            fputcsv($file, $row, ';');
        }

        // Close the CSV file
        fclose($file);
        }


    public function getMeTableColumns($tableName, $withId = false)
        {
        // Get table schema
        $query = $this->db->query("DESCRIBE $tableName");
        $table_schema = $query->result();

        // Open a new CSV file for writing
        $filepath = getcwd() . '/items/uploads/csv/' . $tableName . ".csv";
        $file = fopen($filepath, 'w');

        // Prepare the first row with column names and types
        $header = [];
        foreach ($table_schema as $column) {
            if ($withId == true) {
                $header[] = $column->Field . ' (' . $column->Type . ')';
                } else {
                if ($column->Field != 'id') {
                    $header[] = $column->Field . ' (' . $column->Type . ')';
                    }
                }




            }

        return $header;

        }

       public function createNewCSVFile($tableName)
        {

        $randomNumber = rand(1000, 9999);
        $filepath = getcwd() . '/items/uploads/csv/' . $tableName . $randomNumber . ".csv";

        return $filepath;
        }

        public function downloadCSVFile($filePath)
        {
        $success = false;

        if (file_exists($filePath)) {
            // Send file headers
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            flush(); // Flush system output buffer
            readfile($filePath);
            $success = true;

            } else {
            $success = false;
            }

        return array(
            'success' => $success,
        );
        }



    }
