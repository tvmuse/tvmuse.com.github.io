<?php error_reporting(E_ALL ^ E_NOTICE); 
require_once('include/function.php');
require_once('include/GeoIP.php');


if ( $country == "US" ) {
    $uri_affilate = 'OFFER';
} elseif ( $country == "DK" || $country == "FR" || $country == "SE" || $country == "NL" || $country == "JP" || $country == "NZ" || $country == "CA" || $country == "QA" || $country == "AE" || $country == "CY" || $country == "JM" || $country == "CO" || $country == "KY" || $country == "BS" || $country == "BM" || $country == "SA" || $country == "EC" || $country == "GY" || $country == "AU" || $country == "ES" || $country == "PR" || $country == "GB" || $country == "IS" || $country == "HK" || $country == "PY" ) {
    $uri_affilate = 'OFFER';
} elseif ( $country == "BE" || $country == "NO" || $country == "FI" || $country == "CH" || $country == "LU" || $country == "TT" || $country == "KW" || $country == "IE" || $country == "DE" || $country == "TR" || $country == "IT" || $country == "PT" || $country == "CL" || $country == "PE" || $country == "SG" ) {
    $uri_affilate = 'OFFER';
} elseif ( $country == "AF" || $country == "AL" || $country == "DZ" || $country == "AO" || $country == "AI" || $country == "BB" || $country == "BY" || $country == "BJ" || $country == "BT" || $country == "BA" || $country == "BW" || $country == "BF" || $country == "BI" || $country == "CM" || $country == "CF" || $country == "TD" || $country == "CN" || $country == "CG" || $country == "CD" || $country == "CI" || $country == "CU" || $country == "DJ" || $country == "DO" || $country == "EG" || $country == "GQ" || $country == "ER" || $country == "ET" || $country == "GA" || $country == "GM" || $country == "GE" || $country == "GH" || $country == "GN" || $country == "GW" || $country == "IN" || $country == "ID" || $country == "IR" || $country == "IQ" || $country == "IL" || $country == "KE" || $country == "KP" || $country == "KR" || $country == "LS" || $country == "LR" || $country == "LY" || $country == "MK" || $country == "MG" || $country == "MY" || $country == "MV" || $country == "ML" || $country == "MR" || $country == "YT" || $country == "MA" || $country == "MZ" || $country == "MM" || $country == "NA" || $country == "NE" || $country == "NG" || $country == "PK" || $country == "RO" || $country == "AR" || $country == "TW" || $country == "PH" || $country == "MX" || $country == "BR" || $country == "ZA" || $country == "RU" || $country == "RW" || $country == "SM" || $country == "ST" || $country == "SN" || $country == "SL" || $country == "SO" || $country == "SD" || $country == "SZ" || $country == "SY" || $country == "TZ" || $country == "TH" || $country == "TG" || $country == "TN" || $country == "UG" || $country == "UA" || $country == "UZ" || $country == "VN" || $country == "EH" || $country == "ZM" || $country == "ZW" ) {
    $uri_affilate = '//hlok.qertewrt.com/offer?prod=3&ref=5078872';
} else {
    $uri_affilate = '//hlok.qertewrt.com/offer?prod=3&ref=5078872';
} 
?>
<html>
<head>
<title>Ayo Sales</title> 
<meta http-equiv="refresh" content="0;url=<?php echo $uri_affilate;?>">
<link rel="stylesheet" href="/include/css/style.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<style>body {padding-top: 70px;padding-bottom: 30px;}
.centered {position: fixed;top: 50%;left: 50%;margin-top: -200px;margin-left: -250px;border: 1px solid #DBDBDB;width: 500px;text-align: center;height: 225px;padding: 20px;font-size: 20px;background-color: rgba(233, 233, 233, 0.44);font-family: Arial, Helvetica, sans-serif;text-shadow: 1px 1px 1px #5F5F5F;}
</style>
</head>
<body>
<div class="centered">
<h2>Please Wait </h2>
You Are Automatic Redirecting<br>
To Secure Page<br><br>
<img src="/include/images/load.gif">
</div>
</body>
  <!-- Histats.com  START  (aync)-->
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,3763267,4,0,0,0,00010000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?3763267&101" alt="counter free hit invisible" border="0"></a></noscript>
<!-- Histats.com  END  -->


</html>