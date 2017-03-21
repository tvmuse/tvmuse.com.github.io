<?php require_once('include/movies.php');?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Watch <?php echo $row['title'];?> | <?php echo $config->title;?></title>
	<meta name="description" content="<?php echo $_ocim->short($row['overview']);?>">
	<meta name="keywords" content="<?php echo $row['title'];?>,<?php echo $keywords;?>">

	<link rel="icon" type="image/png" href="/favicon.png">

        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

	<link href="/include/css/dashicons.css" rel="stylesheet" type="text/css">
	<link href="/include/css/mov.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $homeurl;?>/templates/v3/style.css" rel="stylesheet" type="text/css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js" type="text/javascript"></script>
	<script src="/include/js/css3-mediaqueries.js" type="text/javascript"></script>

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> 
		<script src="https://oss.maxcdn.com/respond/1.3/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="navbar navbar-inverse navbar-static-top">
        <div class="container">
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo $_ocim->home_url();?>/"><?php echo $config->title;?></a>
                </div><!-- navbar-header -->
                <div class="navbar-collapse collapse" id="searchbar">
                        <ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<i class="fa fa-film"></i> Movie <span class="caret"></span>
						</a>
                                                <ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo $_ocim->home_url();?>/"><i class="fa fa-home"></i> Home</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/playing"><i class="fa fa-dot-circle-o"></i> Now Playing</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/toprated"><i class="fa fa-list-alt"></i> Top Rated</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/upcoming"><i class="fa fa-star-half-o"></i> Upcoming</a></li>
                                                </ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<i class="fa fa-file-video-o"></i> TV Show<span class="caret"></span>
						</a>
                                                <ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo $_ocim->home_url();?>/airing"><i class="fa fa-dot-circle-o"></i> TV shows Airing</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/ontheair"><i class="fa fa-list-alt"></i> On the Air</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/popular"><i class="fa fa-star-half-o"></i> Popular TV Series</a></li>
                                                </ul>
					</li>
                                <li>&nbsp;</li>
                        </ul>
                        <form class="navbar-form" method="get" action="/">
                                <div class="form-group" style="display:inline;">
                                        <div class="input-group" style="display:table;">
                                                <input name="do" type="hidden" value="search">
                                                <input class="form-control search-form" name="q" placeholder="Type Movie title here?" autocomplete="off" autofocus="autofocus" type="text">
                                                <span class="input-group-btn" style="width:1%;cursor: pointer;"><button type="submit" class="btn btn-primary"> Search</button></span>
                                        </div>
                                </div>
                        </form>
                </div><!-- nav-collapse -->
        </div><!-- container -->
</div>
<div class="row">
    <center>
    <div class="col-md-5 item">
        <div id="google_translate_element"></div>
        <script type="text/javascript">
            function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </div>
    </center>  
</div> 		
<div class="container box-container">
	<div class="row">
		<div class="col-md-12 col-xs-12">
        		<div id="player">
                    <?php if( !empty( $row['trailers']['youtube'][0]['source'] ) ) {?>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo $row['trailers']['youtube'][0]['source'];?>?rel=0" width="600" height="315" frameborder="0" allowfullscreen=""></iframe>
                	</div>
                    <?php }else{ ?>

                                <?php } ?>
        		</div>

            <div class="row" style="margin-top:25px;">
                <center>
                    <div class="available-formats-img-mobile"><img src="http://tvmuze.biz/img/download/available-formats-img.png" class="img-responsive"> </div>
                </center>
            </div>
            <div class="row" style="margin-top:25px;">
                <div> <center> <h4 class="modal-title" id="myModalLabel"><b>Please Click Button Here to Watch <?php echo $row['title'];?> Full Movie Streaming</b></center></div>
                    <center> 
                        <tr>
                            <td class="text-center"><div class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-watch"> <i class="fa fa-cloud-download"></i> Download</div> <a class="btn btn-danger btn-lg" target="" href="<?php echo $_ocim->home_url();?>/register.php"><i class="fa fa-youtube-play"></i> Watch Now </a></td>
                        </tr>
                    </center>
            </div>
			<div class="row" style="margin-top:25px;">
                    <center><div class="pw-widget pw-counter-vertical">         
                    <a class="pw-button-facebook pw-look-native"></a>           
                    <a class="pw-button-twitter pw-look-native"></a>             
                    <a class="pw-button-post-share"></a>        
                    </div>
                    <script src="http://i.po.st/static/v3/post-widget.js#publisherKey=ef9n2ohq0tuspgqbi51n&retina=true" type="text/javascript"></script></center>
                        <div class="col-sm-3 col-xs-12">                       
                           <img src="<?php echo $images_small;?>" alt="<?php echo $row['original_title'];?>" class="img-responsive thumbnail" style="margin:0 auto;">
                                                         
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <table class="table table-striped">
                                                    <tbody>
                                <tr><th width="150">Title</th><td>:</td><td><?php echo $row['title'];?></td></tr>
                                <tr><th>Release</th><td>:</td><td> <?php echo $row['release_date'];?></td></tr>
                                <tr><th>Runtime</th><td>:</td><td> <?php echo $row['runtime'];?> min.</td></tr>
                                <tr><th>Genre</th><td>:</td><td> <?php echo $genre;?></td></tr>
                                <tr><th>Stars</th><td>:</td><td> <?php echo $cast;?></td></tr>
                                <tr><th>Overview</th><td>:</td><td> <?php echo $row['overview'];?></td></tr>
                                        </tbody>
                            </table>
                        </div>
            <div class="col-md-12">
                <div class="rating">
                    <h2 class="visible-xs">LEAVE COMMENTS</h2>
                    <h2 class="hidden-xs">LEAVE COMMENTS</h2>
                </div>
                <div class="row">
                  <div class="col-md-12 stars"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-7 col-sm-7 col-xs-7 rating-info">
                    <td class="text-center"><div class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-watch"> </i>Login Here</div></td>
                  </div>
                </div>
            </div><!-- col-md-12 -->    
            <div class="col-md-12">
                <div class="comments">
                  <ul>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Mr. Ganteng</div>
                      <div class="date"><i class="fa fa-clock-o"></i>60 minutes ago</div>
                      <div class="text">Great, since I signed up the video goes smoothly. audio 10 and video 10, Thanks Bro.</div>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Movie Pilot</div>
                      <div class="date"><i class="fa fa-clock-o"></i>1 hour ago</div>
                      <div class="text">The quality of the film was excellent with the free account, but I love the movie!</div>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Mrs. Janda</div>
                      <div class="date"><i class="fa fa-clock-o"></i>11 hour ago</div>
                      <div class="text">As always thank you, you guys are the best and the movie was great, perfect!</div>
                      <ul>
                        <li class="panel">
                          <div class="author"><i class="fa fa-user"></i>Miss. Bencong</div>
                          <div class="date"><i class="fa fa-clock-o"></i>6 hour ago</div>
                          <div class="text">Bhoooo .. I do not like it at all</div>
                        </li>
                        <li class="panel">
                          <div class="author"><i class="fa fa-user"></i>Cowok Manja</div>
                          <div class="date"><i class="fa fa-clock-o"></i>4 hour ago</div>
                          <div class="text">I don't think the same, although this is not my favorite movie</div>
                        </li>
                      </ul>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Alexa</div>
                      <div class="date">1 days ago</div>
                      <div class="text">Wow!!!</div>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Dobleh</div>
                      <div class="date"><i class="fa fa-clock-o"></i>1 days ago</div>
                      <div class="text">I honestly have no idea why people hate this movie so much. It is not exceptional, but it was okay. Great Quality btw...</div>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Steve</div>
                      <div class="date"><i class="fa fa-clock-o"></i>2 days ago</div>
                      <div class="text">How do I watch it ?????</div>
                      <ul>
                        <li class="panel">
                          <div class="author"><i class="fa fa-user"></i>Wewe Gombel</div>
                          <div class="date"><i class="fa fa-clock-o"></i>1 days ago</div>
                          <div class="text">did u ever read the instructions ???</div>
                        </li>
                      </ul>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Patrizia</div>
                      <div class="date"><i class="fa fa-clock-o"></i>2 days ago</div>
                      <div class="text">It is great for the first two thirds but then things get a little lengthy. But it has a great ending!</div>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Kutu Kupret</div>
                      <div class="date">3 days ago</div>
                      <div class="text">That is great to finally see on the big screen. I don't want to spoil anything in particular but this is a film that everyone should give a chance</div>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Sir Jakcson</div>
                      <div class="date"><i class="fa fa-clock-o"></i>4 days ago</div>
                      <div class="text">The characters are great, they're interesting, they're funny, they will make you laugh. Trust me, at a point this movie will hit you where you live.</div>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Shanti</div>
                      <div class="date"><i class="fa fa-clock-o"></i>6 days ago</div>
                      <div class="text">Yeah! Apple TV rules!</div>
                      <ul>
                        <li class="panel">
                          <div class="author"><i class="fa fa-user"></i>Khardasian</div>
                          <div class="date"><i class="fa fa-clock-o"></i>4 days ago</div>
                          <div class="text">this was really the best movie i've ever seen!</div>
                        </li>
                      </ul>
                    </li>
                    <li class="panel">
                      <div class="author"><i class="fa fa-user"></i>Emak</div>
                      <div class="date"><i class="fa fa-clock-o"></i>7 days ago</div>
                      <div class="text">This is a movie which you dare not miss, because if you miss this one you are never going to see another. Be prepared for one last lovely beautiful and thrilling ride ahead of you, that's well worth your time and memories.</div>
                    </li>
                  </ul>
                </div>
            </div><!-- col-md-12 -->
            <div class="col-md-12">
                   <ul> <div class="text">This filename has been transmitted via an external affiliate, we can therefore furnish no guarantee for the existence of this file on our servers.
                    <br>© 2005 - 2016</div></ul>
            </div><!-- col-md-12 -->
      </div>
    </div>
  </div>
</div>
<!-- Movie information Modal -->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Trailer <?php echo $row['title'];?></h4>
      </div>
      <div class="modal-body">
        <div class="hide"><iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo $row['trailers']['youtube'][0]['source'];?>?rel=0&amp;modestbranding=1&amp;autoplay=0&amp;autohide=0&amp;showinfo=1&amp;controls=0" onload="this.scrolling='no';this.allowfullscreen='true';" style="overflow:hidden;border:0;" scrolling="no"></iframe></div> 
        <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo $row['trailers']['youtube'][0]['source'];?>?rel=0&amp;modestbranding=1&amp;autoplay=0&amp;autohide=1&amp;showinfo=1&amp;controls=0"></iframe>
      </div>
      </div>
    </div>
    </div>
</div>
<div class="modal fade" id="modal-watch" tabindex="-1" role="dialog" aria-labelledby="modal-watch" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content clearfix">
                <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Please Sign Up To Watch <?php echo $row['title'];?> Full Movie Streaming</h4>
                </div>
                <div class="modal-body clearfix">
                        <div class="row">
                                <div class="col-md-6" id="login">
                                        <img class="img-responsive" src="<?php echo $images;?>">
                                        <hr>
                                        <h5>Member Login</h5>
                                        <div class="form-group">
                                                <input type="text" class="form-control input-sm" id="userid" placeholder="username">
	                                </div>
                                        <div class="form-group">
                                                <input type="password" class="form-control input-sm" id="password" placeholder="password">
                                        </div>
                                        <div class="form-group">
                                                <span class="onload label label-info" style="display: none;">Please wait...</span>
                                                <span class="onerror label label-warning" style="display: none;">Wrong Username or Password</span>
                                        </div>
                                        <input type="submit" id="submov" class="btn btn-success" value="Log me in">
                                </div>
		
                                <div class="col-md-6">
                                <ul class="list-group">
						                      <li class="list-group-item">
							                     <h4 class="list-group-item-heading">High Quality Movies</h4>
							                     <p class="list-group-item-text">All of the Movies are available in the superior HD Quality or even higher!</p>
						                      </li>
						                      <li class="list-group-item">
						                      	<h4 class="list-group-item-heading">Watch Without Limits</h4>
						                      	<p class="list-group-item-text">You will get access to all of your favourite the Movies without any limits.</p>
						                      </li>
						                      <li class="list-group-item">
						                      	<h4 class="list-group-item-heading">100% Free Advertising</h4>
						                      	<p class="list-group-item-text">Your account will always be free from all kinds of advertising.</p>
						                      </li>
						                      <li class="list-group-item">
						                      	<h4 class="list-group-item-heading">Watch anytime, anywhere</h4>
						                      	<p class="list-group-item-text">It works on your TV, PC, or MAC!</p>
						                      </li>							
					                     </ul>
                                </div>
                        </div>
                </div>
                <div class="modal-footer bg-info">
                        <a class="btn btn-danger" href="/signup.php">Sign Up For Free</a>
                </div>
        </div>
</div>

<?php include('footer.php');?>