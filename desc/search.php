<?php include('header.php');?>
        <div class="col-md-12">
                <?php
                if ( empty( $page ) ) {
                        $page = 1;
                }
                if ( empty( $q ) ) {
                        $q = '';
                }?>
                <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#movietab">Movies</a></li>
                        <li><a data-toggle="tab" href="#tvtab">TV Show</a></li>
                </ul>
                <div class="tab-content">
                        <div id="movietab" class="tab-pane active">
                        <div class="panel-body row">
                        <?php
			$Movie = $tmdb->searchMovie($q,$page);
			//echo '<pre>'; print_r( $Movie ); echo '</pre>';
                  	if ($Movie['results'] != null) {
                                $i = 0;
                      		foreach($Movie['results'] as $row) {
                                        if ($row[poster_path]!=null) {
                                           	$image = '//i1.wp.com/image.tmdb.org/t/p/w300'.$row['poster_path'].'?resize=300,450';
                                        }elseif ($row[backdrop_path]!=null) {
                                        	$image = '//i1.wp.com/image.tmdb.org/t/p/w300'.$row['backdrop_path'].'?resize=300,450';
                                       	}else{
                                           	$image = '//i1.wp.com/'.$_ocim->get_domain($_ocim->home_url()).'/include/images/no-poster-w185.jpg?resize=300,450';
                                        }	
                                        if ($row[original_title]!=null) {
                                           	$original_title = $row['original_title'];
                                        } else {
                                        	$original_title = $row['title'];
                                       	}
                                        ?>			
				        <div class="col-md-2 col-sm-4 col-xs-6">
					        <div class="movie-list text-center" data-toggle="tooltip" data-placement="top" title="<?php echo $original_title;?>">
						        <a href="<?php echo $_ocim->home_url();?>/desc/watch.php?id=<?php echo $row['id'];?>">
							        <div class="thumbnail">
                                                                        <img src="<?php echo $image;?>" alt="<?php echo $original_title;?>" class="img-responsive">
                                                                </div>
							        <div class="movie-list-title nowrap"><?php echo $original_title;?></div>
                                                        </a>
                                                        <div class="label label-info"><?php echo $row['vote_average'];?>/10 by <?php echo $row['vote_count'];?> user</div>
					        </div>
				        </div>
				        <?php 
                                        if ($i++ == 17) break;
                                }   
                        }
                        ?>
                        <div class="clearfix"></div>
                        <nav class="text-center">
                        <?php 
                        if ($Movie['total_results'] > 17) :
                                require_once('../include/CSSPagination.class.php');
                                if ($Movie['total_results'] > 1000) :
                                        $totalResults = 1000;
                                else:
                                        $totalResults = $Movie['total_results'];
                                endif;                                $limit  = 20; 
                                $link   = '/desc/search.php?q='.$_GET['q'];
                                $pagination = new CSSPagination($totalResults, $limit, $link); // create instance object
                                $pagination->setPage($_GET[page]); // dont change it
                                echo $pagination->showPage();
                        endif;
                        ?>
                        </nav>
		        </div>
		        </div>

                        <div id="tvtab" class="tab-pane">
                        <div class="panel-body row">
                        <?php
			$TVShow = $tmdb->searchTVShow($q,$page);
			//echo '<pre>'; print_r( $TVShow ); echo '</pre>';
                  	if ($TVShow['results'] != null) {
                                $i = 0;
                      		foreach($TVShow['results'] as $row) {
                                        if ($row[poster_path]!=null) {
                                           	$image = '//i1.wp.com/image.tmdb.org/t/p/w300'.$row['poster_path'].'?resize=300,450';
                                        }elseif ($row[backdrop_path]!=null) {
                                        	$image = '//i1.wp.com/image.tmdb.org/t/p/w300'.$row['backdrop_path'].'?resize=300,450';
                                       	}else{
                                           	$image = '//i1.wp.com/'.$_ocim->get_domain($_ocim->home_url()).'/include/images/no-poster-w185.jpg?resize=300,450';
                                        }	
                                        if ($row[original_name]!=null) {
                                           	$original_name = $row['original_name'];
                                        } else {
                                        	$original_name = $row['name'];
                                       	}
                                        ?>			
				        <div class="col-md-2 col-sm-4 col-xs-6">
					        <div class="movie-list text-center" data-toggle="tooltip" data-placement="top" title="<?php echo $original_name;?>">
						        <a href="<?php echo $_ocim->home_url();?>/desc/play.php?id=<?php echo $row['id'];?>">
							        <div class="thumbnail">
                                                                        <img src="<?php echo $image;?>" alt="<?php echo $original_name;?>" class="img-responsive">
                                                                </div>
							        <div class="movie-list-title nowrap"><?php echo $original_name;?></div>
                                                        </a>
                                                        <div class="label label-info"><?php echo $row['vote_average'];?>/10 by <?php echo $row['vote_count'];?> user</div>
					        </div>
				        </div>
				        <?php 
                                        if ($i++ == 17) break;
                                }   
                        }
                        ?>
                        <div class="clearfix"></div>
                        <nav class="text-center">
                        <?php
                        if ($TVShow['total_results'] > 19) :
                                require_once('../include/CSSPagination.class.php');
                                if ($TVShow['total_results'] > 1000) :
                                        $totalResults = 1000;
                                else:
                                        $totalResults = $TVShow['total_results'];
                                endif;                                $limit  = 20; 
                                $link   = '/desc/search.php?q='.$_GET['q'];
                                $pagination = new CSSPagination($totalResults, $limit, $link); // create instance object
                                $pagination->setPage($_GET[page]); // dont change it
                                echo $pagination->showPage();
                        endif;
                        ?>
                        </nav>
		        </div>
		        </div>

                </div>

        </div>
<?php include('footer.php');?>