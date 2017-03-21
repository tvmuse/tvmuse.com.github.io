<?php include('header.php');?>
        <div class="col-md-12">
                <div class="row">
                        <?php
                  	if ( empty( $page ) ) {
                        	$page = 1;
                        }
			$Movie = $tmdb->getPopularMovies($page);
                  	if ($Movie['results'] != null) {
                                $i = 0;
                      		foreach($Movie['results'] as $row) {

                                        if ($row[poster_path]!=null) {
                                           	$image = '//i1.wp.com/image.tmdb.org/t/p/w300'.$row[poster_path].'?resize=300,450';
                                        }elseif ($row[backdrop_path]!=null) {
                                        	$image = '//i1.wp.com/image.tmdb.org/t/p/w300'.$row[backdrop_path].'?resize=300,450';
                                       	}else{
                                           	$image = '//i1.wp.com/'.$_ocim->get_domain($_ocim->home_url()).'/include/images/no-poster-w185.jpg?resize=300,450';
                                        }	
                                ?>			
				<div class="col-md-2 col-sm-4 col-xs-6">
					<div class="movie-list text-center" data-toggle="tooltip" data-placement="top" title="<?php echo $row['original_title'];?>">
						<a href="<?php echo $_ocim->home_url();?>/desc/watch.php?id=<?php echo $row['id'];?>">
							<div class="thumbnail"><img src="<?php echo $image;?>" alt="<?php echo $row['original_title'];?>" class="img-responsive"></div>

							<div class="movie-list-title nowrap"><?php echo $row['original_title'];?></div>
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
                        if ($Movie['total_results'] > 19) :
                                require_once('../include/CSSPagination.class.php');
                                if ($Movie['total_results'] > 1000) :
                                        $totalResults = 1000;
                                else:
                                        $totalResults = $Movie['total_results'];
                                endif;
                                $limit  = 20; 
                                $link   = "/desc/";
                                $pagination = new CSSPagination($totalResults, $limit, $link, '?'); // create instance object
                                $pagination->setPage($_GET[page]); // dont change it
                                echo $pagination->showPage();
                        endif;
                        ?>
                        </nav>

		</div>
	</div>
<?php include('footer.php');?>