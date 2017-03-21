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

    if ( isset($_GET['id']) ) {

        if (file_exists( TOPPATH . '/templates/'.$config->templates.'/play.php' )) {
            require_once( TOPPATH . '/templates/'.$config->templates.'/play.php' );
            exit;
        }

    } else {
        require_once( TOPPATH . '/404.php' );
        exit;
    }
?>