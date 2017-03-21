<?php
class TMDB{
	const _API_URL_ = "http://api.themoviedb.org/3/";
	private $_apikey;
	private $_lang;
	private $_debug;
        function _get($url) {
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
	public function __construct($apikey, $lang = 'en', $debug = false) {
		$this->setApikey($apikey);
		$this->setLang($lang);
		$this->_debug = '';
	}
	public function ___construct($data) {
		$this->_data = $data;
	}
	private function setApikey($apikey) {
		$this->_apikey = (string) $apikey;
	}
	private function getApikey() {
		return $this->_apikey;
	}
	public function setLang($lang = 'en') {
		$this->_lang = $lang;
	}
	public function getLang() {
		return $this->_lang;
	}
        private function _call($action, $appendToResponse, $lang = '&language=en' ){
		$url = self::_API_URL_.$action .'?api_key='. $this->getApikey() . '&'.$appendToResponse;
		$contents = $this->_get($url);
                $results = mb_convert_encoding($contents, "HTML-ENTITIES", "UTF-8" );
                if ($this->_debug == 'debug') {
			echo '<pre>'; print_r( $url ); echo '</pre>';
		}
		return (array) json_decode(($results), true);
	}
        public function getMovie($idMovie, $appendToResponse = 'append_to_response=trailers,images,credits,translations,similar_movies,alternative_titles,keywords') {
		return $this->_call('movie/' . $idMovie, $appendToResponse, '&language='. $this->getLang());
        }
	public function getTVShow($idTVShow, $appendToResponse = 'append_to_response=trailers,images,credits,translations,alternative_titles,keywords') {
                return $this->_call('tv/' . $idTVShow, $appendToResponse, '&language='. $this->getLang());
        }
	public function getTVSeason($idTVShow, $season = '', $appendToResponse = 'append_to_response=trailers,images,credits,translations,alternative_titles,keywords') {
                return $this->_call('tv/' . $idTVShow . $season, $appendToResponse, '&language='. $this->getLang());
        }
	public function getLatestMovie() {
		return $this->_call('movie/latest','', '&language='. $this->getLang());
	}
	public function getPopularMovies($page = 1) {
		return $this->_call('movie/popular', 'page='. $page, '&language='. $this->getLang());
	}
        public function getNowPlayingMovies($page = 1) {
		return $this->_call('movie/now_playing', 'page='. $page, '&language='. $this->getLang() );
	}
	public function getTopRatedMovies($page = 1) {
		return $this->_call('movie/top_rated', 'page='. $page, '&language='. $this->getLang());
	}
	public function getUpcomingMovies($page = 1) {
		return $this->_call('movie/upcoming', 'page='. $page, '&language='. $this->getLang());
	}
	public function GetGenreMovies($id, $page = 1) {
		return $this->_call('genre/'. $id .'/movies', 'page='. $page, '&language='. $this->getLang());
	}
	public function getLatestTVShow($page = 1) {
		return $this->_call('tv/latest','page='. $page, '&language='. $this->getLang());
	}
	public function getTopRatedTVShows($page = 1) {
		return $this->_call('tv/top_rated','page='. $page, '&language='. $this->getLang());
	}
        public function getPopularTVShows($page = 1) {
		return $this->_call('tv/popular','page='. $page, '&language='. $this->getLang());
	}
        public function getOnTheAirTVShows($page = 1) {
		return $this->_call('tv/on_the_air','page='. $page, '&language='. $this->getLang());
	}
	public function getAiringTodayTVShows($page = 1) {
		return $this->_call('tv/airing_today','page='. $page, '&language='. $this->getLang());
	}
	public function searchMulti($movieTitle,$page = 1) {
		return $this->_call('search/multi','query='. urlencode($movieTitle).'&page='. $page, '&language='. $this->getLang());
 	}
	public function searchMovie($movieTitle,$page = 1) {
		return $this->_call('search/movie','query='. urlencode($movieTitle).'&page='. $page, '&language='. $this->getLang());
 	}
	public function searchTVShow($tvShowTitle,$page = 1){
		return $this->_call('search/tv', 'query='. urlencode($tvShowTitle).'&page='. $page, '&language='. $this->getLang());
	}
}
?>