<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'new_data');
function getDB() 
{
$dbhost=DB_SERVER;
$dbuser=DB_USERNAME;
$dbpass=DB_PASSWORD;
$dbname=DB_DATABASE;
try {
$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
$dbConnection->exec("set names utf8");
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $dbConnection;
}
catch (PDOException $e) {
echo 'Connection failed #: ' . $e->getMessage();
}
}
ini_set('max_execution_time', 0);
set_time_limit(0);
$db=getDB();
$array=array();
$statement=$db->prepare("SELECT * from sheet1 ORDER BY amount DESC");
$statement->execute();
$result=$statement->fetchAll(PDO::FETCH_NAMED);
//print_r($decoded_json);
//echo "</pre>";
$i=1;
foreach($result as $item)
{
    
$number=$item["number"];
$amount=$item["amount"];
$count=$item["count"];

image_maker($number,$amount,$count,$i);
$i++;
}

function image_maker($number,$amount,$count,$i){

    $font = dirname(__FILE__) . '/fonts/Supply-Regular.ttf';
    
    $image = imagecreate(2000, 2000);
    // Set the background color of image
    $background_color = imagecolorallocatealpha($image, 0, 0, 0, 127);
      
    // Set the text color of image
    $text_color = imagecolorallocate($image, 175, 175, 175);
      
    // // Function to create image which contains string.
    // imagestring($image, 40, 50, 100,  "ID : ".$text1, $text_color);
    // imagestring($image, 40, 800, 100,  "Amount In USD : ".$text, $text_color);
    // imagestring($image, 40, 1100, 100,  "Attack Date : ".$date, $text_color);
    // imagestring($image, 40, 1100, 100,  "Protocol : ".$protocol, $text_color);

    imagettftext($image, 16, 90,1950,300, $text_color,$font, "TOTAL: $ " . strtoupper($amount));
    imagettftext($image, 16, 90, 1950,950, $text_color,$font,"ATTACKS: ".strtoupper($count));
    //imagettftext($image, 20, 0, 1400,120, $text_color,$font, "Amount: ".$counter);
    imagettftext($image, 16, 90, 1950,1950, $text_color,$font,  $number);

    //header("Content-Type: image/png");
    header( "Content-type: image/png" );
   // imagepng($image);
   if (!file_exists("bot_angel/info_layer_$i")) {
    mkdir("bot_angel/info_layer_$i", 0777, true);
}
    $save = "bot_angel/info_layer_$i/".strtolower("info_layer_$i") .".png";
    imagepng($image, $save);
}
