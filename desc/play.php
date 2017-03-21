<?php 
require_once('../config.php');
require_once('../include/tvseries.php');
$longurl= $_ocim->home_url() .'/?do=play&id='. $id ;
$short = seo_tv($id,$row['original_name']);
function bit_ly_short_url($url, $format='txt') {
    $login = "o_3nqe3sh4ro";
    $appkey = "R_a15223858a23436693210040241ab712";
    $bitly_api = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$bitly_api);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $row['original_name'];?><?php echo $desc_title;?></title>
	<meta name="description" content="<?php echo $_ocim->short($row['overview']);?>">
	<meta name="keywords" content="<?php echo $keywords;?>">

	<link rel="icon" type="image/png" href="/favicon.png">

        <link href="https://fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		
	<link href="/include/css/mov.css" rel="stylesheet" type="text/css">
	<link href="/include/css/style.css" rel="stylesheet" type="text/css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js" type="text/javascript"></script>
	<script src="/include/js/css3-mediaqueries.js" type="text/javascript"></script>

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> 
		<script src="https://oss.maxcdn.com/respond/1.3/respond.min.js"></script>
	<![endif]-->

    <script type="text/javascript">
        function selectText(obj) {      // adapted from Denis Sadowski (via StackOverflow.com)
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(obj);
                range.select();
            }
            else if (window.getSelection) {
                var range = document.createRange();
                range.selectNode(obj);
                window.getSelection().addRange(range);
            }
        }
    </script>
</head>
<body>
	<nav class="navbar navbar-custom navbar-static-top" role="navigation">
		<div class="row">
                    <div class="col-md-5 item">
                    <div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                </div>
                </div>
                </div>  
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle navbar-default" data-toggle="collapse" data-target="#togglenav">
					<span class="sr-only"></span>
					<i class="fa fa-align-justify"></i>
				</button>
				<a class="navbar-brand" href="<?php echo $_ocim->home_url();?>/"><i class="fa fa-film"></i> <?php echo $config->title;?></a>
			</div>
			<div class="collapse navbar-collapse" id="togglenav">
				<form class="navbar-form navbar-left hidden-sm" role="search" action="/desc/search.php" method="GET">
					<div class="form-group">
						<input type="text" name="q" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
				</form>
					
				<ul class="nav navbar-nav navbar-left navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<i class="fa fa-film"></i> Movie <span class="caret"></span>
						</a>
                                                <ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo $_ocim->home_url();?>/desc/"><i class="fa fa-home"></i> Home</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/desc/playing"><i class="fa fa-dot-circle-o"></i> Now Playing</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/desc/toprated"><i class="fa fa-list-alt"></i> Top Rated</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/desc/upcoming"><i class="fa fa-star-half-o"></i> Upcoming</a></li>
                                                </ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<i class="fa fa-file-video-o"></i> TV Show<span class="caret"></span>
						</a>
                                                <ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo $_ocim->home_url();?>/desc/tv"><i class="fa fa-home"></i> Home</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/desc/airing"><i class="fa fa-dot-circle-o"></i> TV shows Airing</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/desc/ontheair"><i class="fa fa-list-alt"></i> On the Air</a></li>
							<li><a href="<?php echo $_ocim->home_url();?>/desc/popular"><i class="fa fa-star-half-o"></i> Popular TV Series</a></li>
                                                </ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>		
		
	<div class="container box-container">

		<div class="row">

		<div class="col-md-12">

			<div class="choice-menu">
				<a class="btn btn-success" href="/desc">Movies</a>
				<a class="btn btn-danger" href="../desc/tv">TV Shows</a>
				<a class="btn btn-primary active" href="./">Description</a>
			</div>
			<h1 class="text-center media-heading"><?php echo $row['name'];?><?php echo $desc_title;?></h1>
			<div class="row" style="margin-top:25px;">
			<div class="col-md-12">
			        <div class="row">
				<div class="col-sm-4 col-xs-12">
					<img src="<?php echo $images_small;?>" alt="<?php echo $row['original_name'];?><?php echo $desc_title;?>" class="img-responsive thumbnail" style="margin:0 auto;">
                                        <div class="text-center">
                                                <label>Ambil Gambar Besar Disini</label>
                                                <textarea class="form-control"><?php echo $images;?></textarea>
                                                <label>Ambil Gambar Kecil Disini</label>
                                                <textarea class="form-control"><?php echo $images_small;?></textarea>
                                        </div>
					<table class="table table-striped">
						<thead><caption class="text-center">Seasons List</caption></thead>
                                                <tbody>	
							<tr>
								<td><ul><?php echo $season_desc;?></li></ul></td>
							</tr>
 			                        </tbody>
					</table>
				</div>
				<div class="col-sm-8 col-xs-12">
				<table class="table table-striped">
                       <tbody>
							<tr><th>URL TV:</th><td>:</td><td> <?php echo $short;?></td></tr>
							<tr><th>Short Link:</th><td>:</td><td> <?php echo bit_ly_short_url($longurl) ?></td></tr>
 			          	</tbody>
 			          	<table class="table table-striped">
						<thead><caption class="text-center">Pilih Judul Yutub</caption></thead>
                                                <tbody>	
							<tr>
								<td><?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?><br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?><br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> Full<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> Full Episode<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Episode<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> FuLL EPisode'''<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> FuLL EPisode'''<br>
								<?php echo $row['name'];?> season <?php echo $row3['season_number'];?> episode <?php echo $row3['episode_number'];?> full episodes<br>
								<?php echo $row['name'];?> season <?php echo $row3['season_number'];?>, episode <?php echo $row3['episode_number'];?> full episodes<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> full Episode long<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> full Episode long<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> Full Episodes Free Online<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Episodes Free Online<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> Full Episode Online FREE DOWNLOAD<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Episode Online FREE DOWNLOAD<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> Full Stream<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Stream<br>
								<?php echo $row['name'];?> season <?php echo $row3['season_number'];?> episode <?php echo $row3['episode_number'];?> full hd<br>
								<?php echo $row['name'];?> season <?php echo $row3['season_number'];?>, episode <?php echo $row3['episode_number'];?> full hd<br>
								<?php echo $row['name'];?> season <?php echo $row3['season_number'];?> episode <?php echo $row3['episode_number'];?> full movie english<br>
								<?php echo $row['name'];?> season <?php echo $row3['season_number'];?>, episode <?php echo $row3['episode_number'];?> full movie english<br>
								watch <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> Full online<br>
								watch <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full online<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['episode_number'];?> "<?php echo $row3['name'];?>" Full TV Streaming Online<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> "<?php echo $row3['name'];?>" Full TV Streaming Online<br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?> Episode <?php echo $row3['name'];?><br>
								<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['name'];?><br></td>
							</tr>
 			                        </tbody>
					</table>
				<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Youtube Satu</caption></thead>
                            <tbody>	
							<tr>
							<td onclick="selectText(this);">» P_L_A_Y~N_O_W_:][[ <?php echo bit_ly_short_url($longurl) ?> ]] <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Episode<br>
<br>
<br>
<br>
<br>
#<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?><br>
What to Expect When You're Expecting __undefined__<br>
<br>
<br>
Stars    : </b><?php echo $cast;?><br>
Release  : </b><?php echo $row['release_date'];?><br>
<br>
<br>
*****Subscribe to the ABS-CBN Star Cinema channel! - *****<br>
<br>
For the latest movie, news, trailers & exclusive interviews visit our official website www.starcinema.com.ph<br>
<br>
Please Subscribe<br>
Facebook: https://www.facebook.com/StarCinema<br>
Twitter: https://twitter.com/starcinema<br>
Instagram: http://instagram.com/starcinema<br>
<br>
<br>
? MY DESCRIPTION/INFORMATION<br>
========================================<br>
<br>
This IS A such Great Movie. Love it so much.<br>
NO COPYRIGHT INTENDED.<br>
<br>
========================================­­­¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬=======================­=­=­=¬=¬=¬=¬=¬=¬=¬=¬=<br>
							</tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Yutub Dua</caption></thead>
                            <tbody>	
							<tr>
							<td onclick="selectText(this);">Just clik <?php echo bit_ly_short_url($longurl) ?> TO PLAY <br>
 <br>
 <br>
 <br>
Download and Subscribe to Our Newsletter: <?php echo bit_ly_short_url($longurl) ?>  <br>
 <br>
Twitter: https://twitter.com/thewrap <br>
Instagram: https://instagram.com/thewrap/ <br>
Find us at www.TheWrap.com <br>
Like MTV: https://www.facebook.com/MTV <br>
Follow MTV: https://twitter.com/MTV <br>

KOMA<?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?>Full "Episode<br>

							</tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Yutub Tiga</caption></thead>
                            <tbody>	
							<tr>
							<td onclick="selectText(this);">? Watch or Download ? : <?php echo bit_ly_short_url($longurl) ?> +<br>
<br>
Subscribe to Our Newsletter: <?php echo bit_ly_short_url($longurl) ?><br>
<br>
Twitter: https://twitter.com/thewrap<br>
Instagram: https://instagram.com/thewrap/<br>
Find us at www.TheWrap.com<br>
Like MTV: https://www.facebook.com/MTV<br>
Follow MTV: https://twitter.com/MTV<br>
<br>
+-+-+-+-+ THANK YOU +-+-+-+-+ UnIqUE +-+-+-+-+<br>
<br>
							</tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Yutub Empat</caption></thead>
                            <tbody>	
							<tr>
							<td onclick="selectText(this);">visit Here »»» <?php echo bit_ly_short_url($longurl) ?> ««« <br>
Subscribe to the HBO :<br>
my fanspage   :  http://Facebook.com/HBO <br>
<br>
<?php echo $row['overview'];?>... <br>
<br>
Connect with HBO Online <br>
Find HBO on Facebook: http://Facebook.com/HBO <br>
Follow @HBO on Twitter: http://Twitter.com/HBO <br>
Find HBO on Youtube: http://Youtube.com/HBO <br>
Find HBO Official Site: http://HBO.com <br>
Find HBO Connect: http://Connect.hbo.com <br>
Find HBO GO: http://HBOGO.com <br>
Find HBO on Instagram: http://Instagram.com/hbo <br>
Find HBO on Foursquare: http://Foursquare.com/hbo <br>
<br>
Check out other HBO Channels <br>
HBO: http://www.youtube.com/hbo <br>
Game of Thrones: http://www.youtube.com/GameofThrones <br>
True Blood: http://www.youtube.com/trueblood <br>
HBO Sports: http://www.youtube.com/HBOsports <br>
Real Time with Bill Maher: http://www.youtube.com/RealTime <br>
HBO Documentary Films: http://www.youtube.com/HBODocs <br>
Cinemax: http://www.youtube.com/Cinemax <br>
HBO Latino: http://www.youtube.com/HBOLatino<br>
							</tbody>
							</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Nyepam FB & Situs</caption></thead>
						<tbody>	
							<tr>
						<td onclick="selectText(this);">Oh, my God.... TOOK ME HOURS TO FIND, FINALLY GOT THE LINK, <br>
☛ <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Streaming<br>
<b>Playnow ➡ </b><?php echo bit_ly_short_url($longurl) ?><br>
							<b>Air Date  : </b><?php echo $row3['air_date'];?><br>
																<b>Runtime  : </b><?php echo $row['episode_run_time'];?><br>
																<b>Genre    : </b><?php echo $genre;?><br>
																<b>Stars    : </b><?php echo $cast;?><br>
																<b>Overview : </b><?php echo $row['overview'];?><br>
															✂UNCUT Don’t miss this, enjoy it now<br>
Thank you very much<br>
Good Episode be Happy enjoy to Watch...<br></td>
							</tr>
 			            </tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Nyepam Posting pakai akun kesatu (Pancingan)</caption></thead>
						<tbody>	
							<tr>
						<td onclick="selectText(this);">help me guys, where can I download and watch <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Streaming ?<br></td>
							</tr>
 			            </tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Nyepam komen pakai akun kedua (jawab dengan nyepam)</caption></thead>
						<tbody>	
							<tr>
						<td onclick="selectText(this);">Sure, visit here to watch and download <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Episode Streaming ☛ <?php echo bit_ly_short_url($longurl) ?><br></td>
							</tr>
 			            </tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Nyepam komen pakai akun ketiga (jawab dengan nyepam)</caption></thead>
						<tbody>	
							<tr>
						<td onclick="selectText(this);">To watch and download <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> Full Episode click here please ☛ <?php echo bit_ly_short_url($longurl) ?><br></td>
							</tr>
 			            </tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Nyepam Inbok Pancingan (inbok manual, masukan nama yg diinbok di FULLNAME)</caption></thead>
						<tbody>	
							<tr>
						<td onclick="selectText(this);"><b>Hi [fullname]</b>, <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?>, Air date at </b><?php echo $row3['air_date'];?>, tell me if you want to watch it online streaming, and I will tell you how to watch ;) <br></td>
							</tr>
 			            </tbody>
					</table>
					<table class="table table-striped">
						<thead><caption class="text-center">Deskripsi Nyepam Inbok Balesan</caption></thead>
						<tbody>	
							<tr>
						<td onclick="selectText(this);">ah ok, Please request the ticket of <?php echo $row['name'];?> Season <?php echo $row3['season_number'];?>, Episode <?php echo $row3['episode_number'];?> here >> <?php echo bit_ly_short_url($longurl) ?><br></td>
							</tr>
 			            </tbody>
					</table>
				</div>
			</div>
			</div>
		</div>

        	<?php if (!$_id[2] AND $row2 != null ):?>
		<div class="col-md-12">
		<h3 class="text-center">Episodes List</h3>
			<?php
                  	if ($row2['episodes']!=null) {
                      		foreach( $row2['episodes'] as $episodes) {

                                        if ($episodes['still_path']!=null) {
                                           	$still_path = 'http://image.tmdb.org/t/p/w185'.$episodes['still_path'];
                                       	}else{
                                           	$still_path = '/include/images/no-backdrop.png';
                                        }	
                        	?>
				<div class="col-md-4 col-sm-6 col-xs-12 media">
						<h4 class="media-heading" style="font-size: 14px;font-weight: 700;"><a href="<?php echo $_ocim->home_url();?>/desc/play.php?id=<?php echo $id;?>-<?php echo $episodes['episode_number'];?>" title="<?php echo $episodes['name'];?>">Episode <?php echo $episodes['episode_number'];?> : <?php echo $episodes['name'];?></a></h4>
						<div style="font-size:12px;"><?php echo date('d F Y', strtotime($episodes['air_date']));?></div>
				</div>
				<?php 
                                }   
                        }
                        ?>
		</div>
        	<?php endif;?>
		</div>
	</div>
<?php include('footer.php');?>