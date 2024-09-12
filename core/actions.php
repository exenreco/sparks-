<?php

## This script uses strict types
declare(strict_types=1);

## This script uses namespace
namespace SparksPlus;

// Add a custom image field in the menu editor
function navItemImage( $item_id, $item, $depth, $args )
{
  $image_url  = get_post_meta( $item_id, '_menu_item_image', true );

  $markup     = "<p class='description description-wide'>";
  $markup     .= "<label for='edit-menu-item-image-$item_id'>";
  $markup     .= _e( 'Image URL' );
  $markup     .= '<br>';
  $markup     .= "<input type='text' id='edit-menu-item-image-$item_id' class='widefat' name='menu-item-image[$item_id]' value='" . esc_attr( $image_url ) . "'>";
  $markup     .= '</label>';
  $markup     .= '</p>';

  echo $markup;
}

// Save the image field data
function navItemImageSave( $menu_id, $menu_item_db_id )
{
  if ( isset( $_POST['menu-item-image'][$menu_item_db_id] ) )
  {
      $image_url = sanitize_text_field( $_POST['menu-item-image'][$menu_item_db_id] );
      update_post_meta( $menu_item_db_id, '_menu_item_image', $image_url );
  } else {
      delete_post_meta( $menu_item_db_id, '_menu_item_image' );
  }
}