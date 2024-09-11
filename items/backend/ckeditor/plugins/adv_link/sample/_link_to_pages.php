<?php
/**
 * PHP sample
 * You may want to query the database to populate the dedicated field
 */

session_start();
header('Content-Type: text/html; charset=utf-8');

// encodeURIComponent() is needed when working with accents
// If not used, generate a JS error in CKEDITOR link plugin
function encodeURIComponent( $str ){

	$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
	return strtr(rawurlencode($str), $revert);

}


$a = array();


// Getting pages from your database
// Uncomment and adapt to generate your content - do not forget to remove sample data below

$servername = "localhost";
$username = "manufaktur";
$password = "Kkhdgoe1";
$dbname = "hdgoe_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, title, pretty_url FROM items ORDER BY title ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {       
        $tmp = array($row["title"], $row["pretty_url"]);
		array_push($a, $tmp);
        
    }
} else {
    
}
$conn->close();





// $data = $sql->getMyPages();

// foreach ($data as &$el) {

// 	$name = encodeURIComponent($el['title']);
// 	$link = 'index.php?p='.$el['id'];
	
// 	$tmp = array($name, $link);
// 	array_push($a, $tmp);
// }



// we finally encode the array into JSON
$string = json_encode($a);
echo $string;
exit;
?>