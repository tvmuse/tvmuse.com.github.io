<?php 
if ( $id ):
$row = $tmdb->getMovie($id);

$url = $_ocim->get_contents('http://www.omdbapi.com/?i='.$row['imdb_id'].'&plot=full&r=json');
$omdbapi = @json_decode($url, true); //This will convert it to an array

//echo '<pre>'; print_r( $row ); echo '</pre>';

if (is_array($row['production_countries']))
{
        $countrys = array();foreach($row['production_countries'] as $result) : $countrys[] = $result['name'];endforeach;
        $country = implode( ", ",$countrys );
}

if (is_array($row['spoken_languages']))
{
        $language = array();foreach($row['spoken_languages'] as $result) : $language[] = $result['name'];endforeach;
        $languages = implode(", ",$language);
}

if (is_array($row['credits'][cast]))
{       
        $ic = 0;$casts = array();foreach($row['credits'][cast] as $result) :$casts[] = $result['name'];if ($i++ == 5) break;endforeach;
        $cast = implode(", ",$casts);
}
if (is_array($row['keywords']['keywords'])) {

        $keyword = array();foreach($row['keywords']['keywords'] as $result) : $keyword[] = $result['name'];endforeach;
        $keywords = implode(", ",$keyword);
}
if (is_array($row['genres'])){
        $genres  = array();foreach($row['genres'] as $result) : $genres[] = $result['name'];endforeach;
        $genre = implode(", ",$genres);
}

if ($row[images]['backdrops']!=null) {
        shuffle($row[images]['backdrops']);
        foreach($row[images]['backdrops'] as $result) {
                $images = 'http://image.tmdb.org/t/p/w1920' . $result['file_path'];
        }
} else {
        $images = '/include/images/no-backdrop.png';
}

if ($row['poster_path']!=null)
{
        $images_small = 'http://image.tmdb.org/t/p/w185' . $row['poster_path'];
} elseif ($row['backdrop_path']!=null){
        $images_small = 'http://image.tmdb.org/t/p/w185' . $row['backdrop_path'];
} else {
        $images_small = '/include/images/no-poster-w185.jpg';
}

if ($row['poster_path']!=null)
{
        $hours = floor( $row['runtime'] / 60);
        $minutes = ( $row['runtime'] % 60);
        $runtime = '0'.$hours.':'.$minutes.':36';
}else{
        $runtime = '01:42:36';
}
if($row['vote_average'] > 0) {
	$index_rating =  $row['vote_average'];
	$empty_rating =  11 - $index_rating;
} else {
	$index_rating =  0;
	$empty_rating = 10;
}
$vote_average = $row['vote_average'];
$vote_count   = $row['vote_count'];
endif;
?>