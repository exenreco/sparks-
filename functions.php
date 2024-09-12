<?php

## This script uses strict types
declare(strict_types=1);

## This script uses namespace
namespace SparksPlus;

# If an absolute path to was not uses to access this script prevents
# this script from executing
\defined('ABSPATH') or die('Unauthorized access are not allowed!');

## checks if wp error class exists
if( ! \class_exists('\WP_Error') ) { return; }

## checks if theme can get template directory
if ( ! \function_exists('\get_template_directory') ) { return; }

## includes wp required scripts wp_error class
use WP_Error as WP_Error;

## Checks if theme root directory path
if( ! \defined('__ROOT__') ):
  ## defines theme root directory path
  \define( '__ROOT__', \trailingslashit( \get_template_directory() ) );
endif;

## Checks if theme assets path is defined
if( ! \defined('__CORE__') ):
  ## defines assets path core
  \define( '__CORE__', \trailingslashit(__ROOT__ . 'core') );
endif;



if( \class_exists('Walker_Nav_Menu') ):

  ## Include Sparks+ Extend WP Walker Nav Class
  require_once( __CORE__ . 'walker-nav.php' );

  if( \function_exists('wp_nav_menu') ):

    ## Add Spark plus walker nav features
    \wp_nav_menu( array(
      'theme_location' => 'primary', // Or any registered location
      'menu_class'     => 'primary-menu',
      'walker'         => new walkerNav(), // Use your custom walker
    ) );

  endif;

endif;


if( \function_exists('add_action') ):

  ## Include Sparks+ Nav Image & Descriptions
  require_once( __CORE__ . 'actions.php' );

  ##
  \add_action( 'wp_nav_menu_item_custom_fields', 'SparksPlus\navItemImage', 10, 4 );

  ##
  \add_action( 'wp_update_nav_menu_item', 'SparksPlus\navItemImageSave', 10, 2 );
endif;


register_nav_menus(['primary-menu', 'footer-menu']);


if( \function_exists('\add_theme_support') ):

  ## Add theme supports block styles
  \add_theme_support('wp-block-styles');

  ## Add theme supports starter content
  \add_theme_support('starter-content');

  ## Add theme supports dark editor
  \add_theme_support('dark-editor-style');

endif;