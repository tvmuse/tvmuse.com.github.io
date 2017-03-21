<?php
include('config.php');
$Movie = $tmdb->getPopularMovies();
$TV = $tmdb->getOnTheAirTVShows();
header("Content-Type: text/xml;charset=iso-8859-1");
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

echo '<url><loc>'.$_ocim->home_url().'/</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
echo '<url><loc>http://'.$hostname.'/playing</loc><lastmod>'.date('Y-m-d', strtotime(date("r")) ).'</lastmod><changefreq>Monthly</changefreq><priority>0.8</priority></url>';
echo '<url><loc>http://'.$hostname.'/toprated</loc><lastmod>'.date('Y-m-d', strtotime(date("r")) ).'</lastmod><changefreq>Monthly</changefreq><priority>0.8</priority></url>';
echo '<url><loc>http://'.$hostname.'/upcoming</loc><lastmod>'.date('Y-m-d', strtotime(date("r")) ).'</lastmod><changefreq>Monthly</changefreq><priority>0.8</priority></url>';
echo '<url><loc>http://'.$hostname.'/airing</loc><lastmod>'.date('Y-m-d', strtotime(date("r")) ).'</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
echo '<url><loc>http://'.$hostname.'/ontheair</loc><lastmod>'.date('Y-m-d', strtotime(date("r")) ).'</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
echo '<url><loc>http://'.$hostname.'/popular</loc><lastmod>'.date('Y-m-d', strtotime(date("r")) ).'</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';

        if ($Movie['results'] != null) {
        foreach($Movie['results'] as $row) {
                echo '<url><loc>'.seo_movie($row['id'],$row['original_title']).'</loc><lastmod>'.date('Y-m-d', strtotime('r')).'</lastmod><changefreq>Monthly</changefreq><priority>0.8</priority></url>';
        }
        }
        if ($TV['results'] != null) {
        foreach($TV['results'] as $rows) {
                echo '<url><loc>'.seo_tv($rows['id'],$rows['original_name']).'</loc><lastmod>'.date('Y-m-d', strtotime('r')).'</lastmod><changefreq>Monthly</changefreq><priority>0.8</priority></url>';
        }
        }
echo "</urlset>";
?>