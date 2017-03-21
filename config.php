<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('include/tmdb-api.php');
require_once('include/formatting.php');
require_once('include/function.php');
require_once('include/meta.php');

define('TOPPATH', $_SERVER['DOCUMENT_ROOT'] );
define('VERSION', '1.11' );

    /*
    |--------------------------------------------------------------------------
    | DO NOT MODIFY OPTIONS BELOW. UNTIL YOU KNOW WHAT ARE YOU DOING.
    |--------------------------------------------------------------------------
    */

    $_ocim   = new _Ocim;
    $config  = new stdClass();
    $config->prefix = 'ocim_';

    /*
    |--------------------------------------------------------------------------
    | Meta Seo Header
    |--------------------------------------------------------------------------
    */

    $config->title            = 'Movie And Series DB'; //Logo Title
    $config->meta_title       = 'Watch Full Movies & TV Shows Online Free'; //Meta Home Title
    $config->meta_description = 'Watch Full Movies & TV Shows full hd online for free';
    $config->meta_keywords    = 'watch Full movie online,watch movie online, watch full movie,tv series, watch movie free, tv show';
    $config->meta_playing     = 'Now Playing | Watch Movies and TV Shows Online for Free'; //Meta playing Title
    $config->meta_toprated    = 'Toprated Movies | Watch Movies and TV Shows Online for Free'; //Meta toprated Title
    $config->meta_upcoming    = 'Upcoming Movies | Watch Movies and TV Shows Online for Free'; //Meta upcoming Title
    /*
    |--------------------------------------------------------------------------
    | Permalink
    |--------------------------------------------------------------------------
    */

    $config->seo              = 'true'; // true or false
    $config->url_movie        = 'movie'; // true or false
    $config->url_tv           = 'tv'; // true or false

    /*
    |--------------------------------------------------------------------------
    | Other
    |--------------------------------------------------------------------------
    */
    $config->templates        = 'v3'; 
    $config->email            = 'bosdollar@outlook.com';
    $config->dmca             = ''; 
    /*
    |--------------------------------------------------------------------------
    | API TMDB
    |--------------------------------------------------------------------------
    | $config->tmdbapi = array(
    |	    "api 1",
    |	    "api 2",
    |	    ); 
    | Tutorial https://www.youtube.com/watch?v=82FsjMmP9R4
    */

    $config->tmdbapi = array(
            "892b7c8469f251441be840cf2aeb9d74"
    ); 

    $apikey      = $config->tmdbapi[mt_rand(0, count($config->tmdbapi) - 1)];
    $language    = 'en';
    $tmdb        = new TMDB($apikey, $language, true);

    if($config->dmca != null){
            if($_ocim->strposa($_ocim->canonical(), preg_split('/\n|\r\n?/',$config->dmca) )) :
                    header("Location: /");
            endif;
    }