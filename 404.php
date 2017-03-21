<?php 
require_once( dirname(__FILE__) . '/config.php' );
include_once( TOPPATH . '/templates/'.$config->templates.'/header.php' );
?>
<div class="col-md-12">
        <div class="row">

                <div style="padding-left:2em; padding-right:2em; " class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="alert alert-danger">
                                <h1>Oops ... </h1>
                                <p>
                                        Maybe connections is lost or movies aren't exist.
                                </p>
                        </div>
                </div>

        </div>

</div>
<?php include_once(TOPPATH . '/templates/'.$config->templates.'/footer.php');?>