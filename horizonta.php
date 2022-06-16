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
$statement=$db->prepare("SELECT * from info2  LIMIT 169");
$statement->execute();
$result=$statement->fetchAll(PDO::FETCH_NAMED);
//print_r($decoded_json);
//echo "</pre>";
$i=1;
foreach($result as $item)
{
    
$number=$item["number"];
$amount=$item["amount"];
$protocol=$item["protocol"];

    $triggerOn = $item["date"];
    $newdate = new DateTime($triggerOn);
    $newdate->setTimezone(new DateTimeZone("UTC"));
    $this_date=$newdate->format("M-d-Y h:i:s A +e"); 


echo $date=$this_date;
if($amount>5 && $amount <=12){
image_maker($number,$amount,$date,$protocol,$i);
}
$i++;
}
function image_maker($text1,$text,$date,$protocol,$i){

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

    imagettftext($image, 16, 0,50,50, $text_color,$font,$text1);
    imagettftext($image, 16, 0, 980,50, $text_color,$font, "$ ".$text);
    //imagettftext($image, 20, 0, 1400,120, $text_color,$font, "Amount: ".$counter);
    imagettftext($image, 16, 0, 1200,50, $text_color,$font, "DATE: ".strtoupper($date));
    imagettftext($image, 16, 0, 1700,50, $text_color,$font, "PROTOCOL: ".strtoupper($protocol));
    //header("Content-Type: image/png");
    header( "Content-type: image/png" );
   // imagepng($image);
   if (!file_exists("sandwich_horizontal_5_12_new/info_layer_$i")) {
    mkdir("sandwich_horizontal_5_12_new/info_layer_$i", 0777, true);
}
    $save = "sandwich_horizontal_5_12_new/info_layer_$i/".strtolower("info_layer_$i") .".png";
    imagepng($image, $save);
    //imagedestroy($image);
}
?>