<?php
header('Content-type: application/json');

//!!!PLEASE EDIT LINE 44 with your ElectricImp api key!!!!!

$hueBaseIp = '192.168.2.10'; //Your PhilipsHue base station IP
$hueUsername = 'electricimp'; //Your PhilipsHue username

$baseUrl = "http://".$hueBaseIp."/api".$hueUsername;
require 'Slim/Slim.php';

use Slim\Slim;
Slim::registerAutoloader();

$app = new Slim();


$app->get('/getbulbs','getbulbs'); //get the number of Bulbs
$app->get('/getcolor/:bulbid','getcolor');
$app->get('/setcolor/:bulbid/:x/:y','setcolor');
$app->get('/setbrightness/:bulbid/:brightness','setbrightness');

$app->run();

function getbulbs() {
 global $baseUrl;
 $getbulbsdata = getdata($baseUrl."/lights");
 $words = explode(',', $getbulbsdata);
 //echo count ($words);
 $bulbcount = count($words);
 echo("<html><head></head>
 <body><select id =sel onchange='writeImp(this.value)'>");
  
  for ($i = 1; $i < $bulbcount +1;$i++){
        
        $bulbdata = getdata($baseUrl."/lights"."/".$i);
        $bulbdata = json_decode($bulbdata);
        $phuename = $bulbdata->name;
        echo("<option value=$i>Hue Bulb $i: $phuename</option>");
    }
    echo ("</select>");
    echo("<script type='text/javascript'>
    function writeImp(value){
    console.log('Writing Number of bulb to IMP: ' +value);
        var oReq = new XMLHttpRequest(); 
        oReq.open('GET', 'https://agent.electricimp.com/YOURAPIKEY/?setphuebulb='+value, true);  // synchronous request  
	    oReq.send();
    }
    </script>
    </body>
    </html>"
    );

};

function getcolor($bulbid) {
 global $baseUrl;
 $getbulbsdata = getdata($baseUrl."/lights/".$bulbid);
 echo($getbulbsdata);

};

function setcolor($bulbid, $x, $y) { //currently unused
    echo "setcolor for ID: ". $bulbid;
    echo "X: ".$x;
    echo "Y: ".$y;
};


function setbrightness($bulbid, $brightness) { //currently unused
    echo "getbrigthness for ID:" .$bulbid;
    echo "Brigthness: ".$brigtness;
};

function getdata($url){
 $ch = curl_init();
 // setze die URL und andere Optionen 
 curl_setopt($ch, CURLOPT_URL, $url); 
 curl_setopt($ch, CURLOPT_HEADER, 0); 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

 // führe die Aktion aus und gebe die Daten an den Browser weiter 
 $response = curl_exec($ch); 

 // schließe den cURL-Handle und gebe die Systemresourcen frei 
 curl_close($ch);
 return ($response);
 }
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
