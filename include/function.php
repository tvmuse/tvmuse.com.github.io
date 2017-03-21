<?php 
$id        = isset($_GET['id'])?$_GET['id'] : null;
$q         = isset($_GET['q'])?$_GET['q'] : null;
$v         = isset($_GET['v'])?$_GET['v'] : null;
$do        = isset($_GET['do'])?$_GET['do'] : null;
$page      = isset($_GET['page'])?$_GET['page'] : null;
$hostname  = $_SERVER['HTTP_HOST'];
$homeurl   = "http://$hostname";
$useragent = $_SERVER['HTTP_USER_AGENT'];
$refferer  = $_SERVER['HTTP_REFERER'];
$path	   = $_SERVER['REQUEST_URI'];
$ipaddress = get_ip_address();
class _Ocim{
        function canonical($seo = true, $base_url = false){
                $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
                $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
                $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
                $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);

                if ($base_url){
                        return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port;
                }

                if ( ! $seo){
                        $url = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['SCRIPT_NAME'];
                        $url .= ($_SERVER['QUERY_STRING'] != '') ? '?'. $_SERVER['QUERY_STRING'] : '';
                        return rtrim($url, "?&");
                }
                return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
        }

        function home_url(){
                return $this->canonical(false, true);
        }
        function is_home(){
                $host = $this->home_url().'/';
                if( $this->canonical == $host ){
                        return true;
                } else {
                        return false;
                }
        }
        function get_domain($url){
                $pieces = parse_url($url);
                $domain = isset($pieces['host']) ? $pieces['host'] : '';
                if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
                        return $regs['domain'];
                }
                return false;
        }
        function permalink($str, $delimiter = '-', $options = array()) {
	        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
	        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
	
	        $defaults = array(
		        'delimiter' =>  $delimiter,
		        'limit' => null,
		        'lowercase' => true,
		        'replacements' => array(),
		        'transliterate' => true,
	        );
	
	        // Merge options
	        $options = array_merge($defaults, $options);
	
		$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
		'ß' => 'ss', 
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
		'ÿ' => 'y',

		// Latin symbols
		'©' => '(c)',

		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',

		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
		'Ž' => 'Z', 
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z', 

		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
		'Ż' => 'Z', 
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',

		// Latvian
		'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
		'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
		'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
		'š' => 's', 'ū' => 'u', 'ž' => 'z'
		);
	
	        // Make custom replacements
	        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
	
	        // Transliterate characters to ASCII
	        if ($options['transliterate']) {
		        $str = str_replace(array_keys($char_map), $char_map, $str);
	        }
	
	        // Replace non-alphanumeric characters with our delimiter
	        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	
	        // Remove duplicate delimiters
	        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
	
	        // Truncate slug to max. characters
	        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : strlen($str)), 'UTF-8');
	
	        // Remove delimiter from ends
	        $str = trim($str, $options['delimiter']);
	
                return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
        }
        function get_contents($url) {
                if (function_exists('curl_exec')){ 
                $ch = curl_init();

                $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
                $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
                $header[] = "Cache-Control: max-age=0";
                $header[] = "Connection: keep-alive";
                $header[] = "Keep-Alive: 300";
                $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
                $header[] = "Accept-Language: en-us,en;q=0.5";
                $header[] = "Pragma: ";

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5 );
                curl_setopt($ch, CURLOPT_REFERER, "http://www.facebook.com");
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
          //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/".rand(3,5).".".rand(0,3)." (Windows NT ".rand(3,5).".".rand(0,2)."; rv:2.0.1) Gecko/20100101 Firefox/".rand(3,5).".0.1");

                $url_get_contents_data = curl_exec($ch);
                curl_close($ch);
                        if ($url_get_contents_data == false){
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                              //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                                curl_setopt($ch, CURLOPT_URL, $url);
                                $url_get_contents_data = curl_exec($ch);
                                curl_close($ch);
                        }
                }elseif(function_exists('file_get_contents')){
                        $url_get_contents_data = @file_get_contents($url);
                }elseif(function_exists('fopen') && function_exists('stream_get_contents')){
                        $handle = fopen ($url, "r");
                        $url_get_contents_data = stream_get_contents($handle);
                }else{
                        $url_get_contents_data = false;
                }
                return $url_get_contents_data;
        }
        function short($text, $len = 150, $more = '...') {
                $txt = ltrim(strip_tags($text));
                if (strlen($txt) > $len) {
                        $text = substr($txt, 0, $len);
                        $txt = substr($text, 0, strrpos($text, ' ')).$more;
                }
                return $txt;
        }
	function remove_repeating_chars($object){
		return preg_replace("/[^a-zA-Z0-9\s.?!\/]/", "", $object);
	}
	function fix_json( $j ){
        	$j = trim( $j );
        	$j = ltrim( $j, '(' );
        	$j = rtrim( $j, ')' );
        	$a = preg_split('#(?<!\\\\)\"#', $j );
        
        	for( $i=0; $i < count( $a ); $i+=2 ){
                	$s = $a[$i];
                	$s = preg_replace('#([^\s\[\]\{\}\:\,]+):#', '"\1":', $s );
                	$a[$i] = $s;
        	}
        
        	$j = implode( '"', $a );
        
        	return $j;
	}
	function slugify($text,$strict = false) {
        	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        	// replace non letter or digits by -
        	$text = preg_replace('~[^\\pL\d.]+~u', ' ', $text);

        	// trim
        	$text = trim($text, ' ');
        	setlocale(LC_CTYPE, 'en_GB.utf8');
        	// transliterate
        	if (function_exists('iconv')) {
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        	}

        	// lowercase
        	$text = strtolower($text);
        	// remove unwanted characters
        	$text = preg_replace('~[^-\w.]+~', ' ', $text);
        	if (empty($text)) {
			return 'empty_$';
        	}
        	if ($strict) {
			$text = str_replace(".", "_", $text);
        	}
        	return $text;
	}
	function removeDuplicates($sSearch, $sReplace, $sSubject){
		$i=0;
		do {
			$sSubject=str_replace($sSearch, $sReplace, $sSubject);         
			$pos=strpos($sSubject, $sSearch);
         
			$i++;
			if($i>100)
			{
				die('removeDuplicates() loop error');
			}
         
		}
		while($pos!==false);
		return $sSubject;
	}
	function strposa($haystack, $needle, $offset=0) {
        	if(is_array($needle)):
        	foreach($needle as $query) {
                	if(!empty($query)):
                        	if(strpos( (string) $haystack, $query, $offset) !== false) return true; // stop on first true result
                	endif;
        	}
        	endif;
        	return false;
	}
}
function get_ip_address(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}
function netipde($ip) {
    $response=ambil_contents('http://www.netip.de/search?query='.$ip);
    $patterns=array();
    $patterns["country"] = '#Country: (.*?)-.*?&nbsp;#i';
    $ipInfo=array();
    foreach ($patterns as $key => $pattern){
        $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
    }
    return $ipInfo['country'];
}
function ambil_contents($url) {
     if (function_exists('curl_exec')){ 
          $ch = curl_init();

          $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
          $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
          $header[] = "Cache-Control: max-age=0";
          $header[] = "Connection: keep-alive";
          $header[] = "Keep-Alive: 300";
          $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
          $header[] = "Accept-Language: en-us,en;q=0.5";
          $header[] = "Pragma: ";

          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5 );
          curl_setopt($ch, CURLOPT_REFERER, "http://www.facebook.com");
          curl_setopt($ch, CURLOPT_AUTOREFERER, true);
          curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/".rand(3,5).".".rand(0,3)." (Windows NT ".rand(3,5).".".rand(0,2)."; rv:2.0.1) Gecko/20100101 Firefox/".rand(3,5).".0.1");
          $url_get_contents_data = curl_exec($ch);
          curl_close($ch);
          if ($url_get_contents_data == false){
                      $ch = curl_init();
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                      curl_setopt($ch, CURLOPT_HEADER, 0);
                      curl_setopt($ch, CURLOPT_URL, $url);
                      $url_get_contents_data = curl_exec($ch);
                      curl_close($ch);
          }
     }elseif(function_exists('file_get_contents')){
          $url_get_contents_data = @file_get_contents($url);
     }elseif(function_exists('fopen') && function_exists('stream_get_contents')){
          $handle = fopen ($url, "r");
          $url_get_contents_data = stream_get_contents($handle);
     }else{
          $url_get_contents_data = false;
     }
return $url_get_contents_data;
}
?>