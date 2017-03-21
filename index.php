<?php
  /**
   * Index
   *
   * @package Ocim CMS
   * @author ocimscripts.com
   * @copyright 2015
   * @version $Id: index.php
   */
require_once( dirname(__FILE__) . '/config.php' );

    if ( isset($_GET['do']) ) {
        if (file_exists( TOPPATH . '/templates/'.$config->templates.'/'.$_GET['do'].'.php' )) {
            require_once( TOPPATH . '/templates/'.$config->templates.'/'.$_GET['do'].'.php' );
            exit;
        }
    }
    if (file_exists( TOPPATH . '/templates/'.$config->templates.'/index.php' )) {

        require_once( TOPPATH . '/templates/'.$config->templates.'/header.php' );
        require_once( TOPPATH . '/templates/'.$config->templates.'/index.php' );
        require_once( TOPPATH . '/templates/'.$config->templates.'/footer.php' );
        exit;

    } else {
        require_once( TOPPATH . '/404.php' );
        exit;
    }
?>