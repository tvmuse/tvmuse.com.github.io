<?php
$_id = explode('-',$id);

if ( $id ){
        $row = $tmdb->getTVShow($_id[0]);

        //echo '<pre>'; print_r( $row ); echo '</pre>';

        if ($_id[2] != null){

                $row3 = $tmdb->getTVSeason($_id[0], '/season/' . $_id[1] . '/episode/'. $_id[2]);

                        //echo '<pre>'; print_r( $row3 ); echo '</pre>';

                if ($row3[overview]!=null) {
                        $overview = $row3[overview];
                } else {
                        $overview = $row[overview];
                }

                if ($row[images]['backdrops']!=null) {
                        shuffle($row[images]['backdrops']);
                        foreach($row[images]['backdrops'] as $result) {
                                $images = 'http://image.tmdb.org/t/p/w1920' . $result['file_path'];
                        }
                } elseif ($row[images]['posters']!=null){
                        shuffle($row[images]['posters']);
                        foreach($row[images]['posters'] as $result) {
                                $images = 'http://image.tmdb.org/t/p/w1920' . $result['file_path'];
                        }
                } else {
                        $images = '/include/images/no-backdrop.png';
                }
                if (is_array($row3['credits'][cast])){
                        $casts = array();
                        foreach($row3['credits'][cast] as $result) {
                                $casts[] = '<span itemprop="actor" itemscope itemtype="http://schema.org/Person"><span itemprop="name">' . $result['name'] . ' (' . $result['character'] . ')</span></span>, ';             
                        }
                        $cast = implode( ", ",$casts );
                }
                //if (is_array($row3['guest_stars'])){
                        //$guest = array();
                        //foreach($row3['guest_stars'] as $result) {
                                //$guest[] = '<span itemprop="actor" itemscope itemtype="http://schema.org/Person"><span itemprop="name">' . $result['name'] . ' (' . $result['character'] . ')</span></span>';             
                        //}
                        //$guest_stars = implode( ", ",$guest );
                //}
                if($row3['vote_average'] > 0) {
	                $index_rating =  $row3['vote_average'];
	                $empty_rating =  11 - $index_rating;
                } else {
	                $index_rating =  0;
	                $empty_rating = 10;
                }
                $vote_average = $row3['vote_average'];
                $vote_count   = $row3['vote_count'];
        }elseif ($_id[1] != null){

                $row2 = $tmdb->getTVSeason($_id[0], '/season/'.$_id[1]);

                       //echo '<pre>'; print_r( $row2 ); echo '</pre>';

                $overview = $row['overview'];
                $episodec = count($row2['episodes']);

                if (is_array($row['credits'][cast])) {
                        $casts = array();
                        foreach($row['credits'][cast] as $result) {
                                $casts[] = '<span itemprop="actor" itemscope itemtype="http://schema.org/Person"><span itemprop="name">' . $result['name'] . ' (' . $result['character'] . ')</span></span>';             
                        }
                        $cast = implode( ", ",$casts );
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
        }else{
                $overview = $row['overview'];

                if (is_array($row['credits'][cast])) {
                        $casts = array();
                        foreach($row['credits'][cast] as $result) {
                                $casts[] = '<span itemprop="actor" itemscope itemtype="http://schema.org/Person"><span itemprop="name">' . $result['name'] . ' (' . $result['character'] . ')</span></span>';             
                        }
                        $cast = implode( ", ",$casts );
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

        }
        if ($row[images]['backdrops']!=null) {
                shuffle($row[images]['backdrops']);
                foreach($row[images]['backdrops'] as $result) {
                        $images = 'http://image.tmdb.org/t/p/w1920' . $result['file_path'];
                }
        } elseif ($row[images]['posters']!=null) {
                shuffle($row[images]['posters']);
                foreach($row[images]['posters'] as $result) {
                        $images = 'http://image.tmdb.org/t/p/w1920' . $result['file_path'];
                }
        } else {
                $images = '/include/images/no-backdrop.png';
        }

        if ($row['poster_path']!=null){
                $images_small = 'http://image.tmdb.org/t/p/w185' . $row['poster_path'];
        } elseif ($row['backdrop_path']!=null){
                $images_small = 'http://image.tmdb.org/t/p/w185' . $row['backdrop_path'];
        } else {
                $images_small = '/include/images/no-poster-w185.jpg';
        }
        if ($row['seasons']!=null) { 
                foreach($row['seasons'] as $result) {
                         if( $result['season_number'] == 0 ) {
                                continue;
                         }
                         $season_list .= '<li><a href="/tv/play.php?id='.$row['id'].'-'.$result['season_number'].'">Season '.$result['season_number'].'</a>  - <small>'.date('F d, Y', strtotime($result['air_date'])).'</small></li>';
                }
        }
        if ($row['seasons']!=null) { 
                foreach($row['seasons'] as $result) {
                         if( $result['season_number'] == 0 ) {
                                continue;
                         }
                         $season_desc .= '<li><a href="/desc/play.php?id='.$row['id'].'-'.$result['season_number'].'">Season '.$result['season_number'].'</a> (<small>'.$result['episode_count'].' episode</small>) - <small>'.date('F d, Y', strtotime($result['air_date'])).'</small></li>';
                }
        }
        if (is_array($row['genres'])) {
                $genres  = array();foreach($row['genres'] as $result) : $genres[] = $result['name'];endforeach;
                $genre = implode(", ",$genres);
        }
        if (is_array($row['keywords'][results])){
                $keyword = array();foreach($row['keywords'][results] as $result) : $keyword[] = $result['name'];endforeach;
                $keywords = implode(", ",$keyword);
        }

        if ($_id[2] != null):
                $movie_title = ' Season '.$row3['season_number'].' Episode '.$row3['episode_number'].' : '. $row3['name'];
                $desc_title = ' Season '.$row3['season_number'].' Episode '.$row3['episode_number'];
        elseif($_id[1] != null):
                $movie_title = ' '.$row2['name'];
                $desc_title = ' '.$row2['name'];
        endif;

        if ($row['episode_run_time'][0]!=null)
        {
                $hours = floor( $row['episode_run_time'][0] / 60);
                $minutes = ( $row['episode_run_time'][0] % 60);
                $runtime = '0'.$hours.':'.$minutes.':26';
        }else{
                $runtime = '00:45:02';
        }

}
?>