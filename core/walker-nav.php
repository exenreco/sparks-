<?php

## This script uses strict types
declare(strict_types=1);

## This script uses namespace
namespace SparksPlus;

## When wp walker nav not found return
if( ! \class_exists('Walker_Nav_Menu') ):
  return false;
endif;

## Pull wordPress walker nav class in our project
use Walker_Nav_Menu as Walker_Nav_Menu;

class walkerNav extends Walker_Nav_Menu {

  function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 )
  {
    $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

    // Ensure $args is an object, not an array
    $args = (object) $args;

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
        if ( ! empty( $value ) ) {
            $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
            $attributes .= ' ' . $attr . '="' . $value . '"';
        }
    }

    // Get the image URL and description from the menu item's metadata
    $image_url = get_post_meta( $item->ID, '_menu_item_image', true );
    $description = ! empty( $item->description ) ? $item->description : '';

    // Build the item output
    $item_output = $args->before; // Ensure this works with object
    if ( ! empty( $image_url ) ) {
        $item_output .= '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $item->title ) . '">';
    }
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . $item->title . $args->link_after;
    $item_output .= '</a>';
    if ( ! empty( $description ) ) {
        $item_output .= '<p class="menu-item-description">' . esc_html( $description ) . '</p>';
    }
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}