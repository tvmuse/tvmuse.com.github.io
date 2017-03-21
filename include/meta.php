<?php
function oc_title() {
    global $config, $do;
    if ( isset($do) ) {
        if ( isset($_GET['q']) ) {
	    $title = 'Search movies '.$_GET['q']. ' | ' . $config->meta_title;
        }else{
            $title = ucwords( htmlspecialchars( $do ) ). ' | ' . $config->meta_title;
        }
    }else{
	$title	= $config->meta_title;
    }
    return $title;			
}
function oc_description() {
    global $config, $do;
    if ( isset($do) ) {
        if ( isset($_GET['q']) ) {
	    $title = 'Search results for '.$_GET['q']. ' movies and tv | ' . $config->meta_description;
        }else{
            $title = ucwords( htmlspecialchars( $do ) ). ' - ' . $config->meta_description;
        }
    }else{
	$title	= $config->meta_description;
    }
    return $title;			
}
function oc_keywords() {
    global $config, $do;
    if ( isset($do) ) {
        if ( isset($_GET['q']) ) {
	    $title = strtolower( $_GET['q']). ',' . $config->meta_keywords;
        }else{
            $title = strtolower( htmlspecialchars( $do ) ). ',' . $config->meta_keywords;
        }
    }else{
	$title	= $config->meta_keywords;
    }
    return $title;			
}
function seo_movie( $id, $query ) {
        global $config,$homeurl,$_ocim;
        if ( $config->seo == 'true' ):
                if ( sanitize_title_with_dashes($query) != ""): $title = sanitize_title_with_dashes($query);else: $title = $query;endif;
                return $homeurl . '/'.$config->url_movie.'/'.$id.'/'.$title.'.html'; 
        else:
                return $homeurl . '/movie.php?id='.$id;
        endif;
}
function seo_tv( $id, $query ) {
        global $config,$homeurl,$_ocim;
        if ( $config->seo == 'true' ):
                if ( sanitize_title_with_dashes($query) != ""): $title = sanitize_title_with_dashes($query);else: $title = $query;endif;
                return $homeurl . '/'.$config->url_tv.'/'.$id.'/'.$title.'.html'; 
        else:
                return $homeurl . '/tv.php?id='.$id;
        endif;
}
?>