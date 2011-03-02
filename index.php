<?

	include 'config.php';

	$url = $latitudeBadgeUrl;
	$json = file_get_contents($url);
	$onskype = file_get_contents("http://mystatus.skype.com/$skypeUserName.txt");
    $whereami = json_decode($json, true);
	
    $countrystring = $whereami['features'][0]['properties']['reverseGeocode'];
    $lon = $whereami['features'][0]['geometry']['coordinates'][0];
    $lat = $whereami['features'][0]['geometry']['coordinates'][1];


	// where's our user?
	$xml = simplexml_load_file("http://api.hostip.info/get_xml.php?ip=".$_SERVER['REMOTE_ADDR']);
    $userCountry = ucwords(strtolower($xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip->countryName));

	// are they on mobile?
	include("Mobile_Detect.php");
	$detect = new Mobile_Detect();
	if ($detect->isMobile()) {
	  $callProtocol = "tel:";
	  $isMobile=true;
	}
	else {  $callProtocol = "callto:";$isMobile=false; }
	
	
	// find the local time

	$url = "http://ws.geonames.org/timezoneJSON?lat=$lat&lng=$lon";
	
			$json = @file_get_contents($url);
			if($json == FALSE) { // this could be dangerous, but I'll bet on that geonames will be more stable
				  header('Location: http://call.mortenjust.com') ;
			}
			$result = json_decode($json, true);
			$localtime = $result['time'];
			$lt = explode(" ", $localtime);
			$localtime = $lt[1];
			$country = $result['countryName'];

	// find the country I'm in and determine the right number
	foreach($countryNumbers as $countryNumber => $number)
	{
		if(strpos($countrystring, $countryNumber)>0) $phone=$number;		
	}
	
	// if user is in different country and I'm available on Skype
//	if($userCountry!=$country) { // (skipping the different country part here)
		if($onskype=='Online') {
			$showSkype=true;
		}
		
//	}


?>

<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Call <?=$ownerName?></title>
	<meta name="viewport" content="width=320,user-scalable=false" />
	<meta name="apple-mobile-web-app-capable" content="yes" /> 
	<meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
	<link rel="apple-touch-icon" href="icon.png"/> 
	<link rel="apple-touch-startup-image" href="default.png"/>
	<style>
	
	body { font-family:helvetica,arial; background-color:black;padding:20px; color:#ddd; }
	
	.btn {
		display: inline-block;
		width:90%;
		font-size:50px;		
		background: url(btn.bg.png) repeat-x 0px 0px;
		padding:5px 10px 6px 10px;
		font-weight:bold;
		text-shadow: 1px 1px 1px rgba(255,255,255,0.5);
		border:1px solid rgba(0,0,0,0.4);
		-moz-border-radius: 5px;
		-moz-box-shadow: 0px 0px 2px rgba(0,0,0,0.5);
		-webkit-border-radius: 5px;
		-webkit-box-shadow: 0px 0px 2px rgba(0,0,0,0.5);
		margin-bottom:10px;
		text-align:center;
		font-family:arial;
	}
	a {text-decoration:none;}
	.country { font-size:50%; font-weight:normal;}
	
	.local-time { text-align:center; font-size:90%; color:#777; }
	
	.gray		{background-color: #CCCCCC; color: #141414;}
	
	.center { text-align:center; }
	
	h1,body {color: rgba(255, 255, 255, 0.4); }
	</style>
	
</head>
<body>
	
	<h1><?=$ownerName?></h1>

<div class='center'>
	
	
	<a class="gray btn" href='<?=$callProtocol?><?=$phone?>'>
		<? if($isMobile){
			echo "Call";
			 } else { 
			echo "Skype to phone";
			} ?>

		<div class='country'><?=$country?></div>
	</a>
	
	<? if($showSkype){?>
	<a class="gray btn" href='skype:<?=$skypeUserName?>?call'>
		<? if($isMobile){
			echo "Skype";
			 } else { 
			echo "Skype to Skype";
			} ?>
		</a>
	<? } ?>
	
		
	<? if($isMobile){?> 
		<a class="gray btn" href='sms:<?=$phone?>'>SMS</a>
	<? } ?>
	
	<div class="local-time">Local time is <?=$localtime?></div>
</div>

</body>
<html>