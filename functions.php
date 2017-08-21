<?php 


namespace Spnzr;

function get_first_term($post_id = false, $taxonomy = 'category')
{
    if ($post_id == false) {
        $post_id = get_the_ID();
    }
    $terms = get_the_terms($post_id, $taxonomy);
    return esc_attr($terms[0]->name);
}


function the_first_term($post_id = false, $taxonomy = 'category')
{
    if ($post_id == false) {
        $post_id = get_the_ID();
    }
    $terms = get_the_terms($post_id, $taxonomy);
    if($terms){
      echo esc_attr($terms[0]->name);
    }
}

function the_first_term_link($post_id = false, $taxonomy = 'category')
{
    if ($post_id == false) {
        $post_id = get_the_ID();
    }
    $terms = get_the_terms($post_id, $taxonomy);
    $term = $terms[0];
    if ($term->parent != 0) {
        echo '<a href="' . esc_url(get_term_link($term->term_id)). '" class="link-category" title="' . esc_attr($term->name) . '" ' . '>' . esc_attr($term->name) .'</a> ';
    }
}
/**
 * Renders a really basic nav for WordPress pages
 *
 * @param  $theme_location string
 * @return name string
 *
 */
function get_nav_name($theme_location)
{
    $theme_locations = get_nav_menu_locations();
    $menu_obj = get_term($theme_locations[ $theme_location ], 'nav_menu');
    if (is_string($menu_obj->name)) {
        return $menu_obj->name;
    } else {
        return false;
    }
}
/**
 * Renders a really basic nav for WordPress pages
 *
 * @param  $parent_id int
 * @return echos html
 *
 */
function page_nav($parent_id = 0)
{
/*  post has parents */
  // if( is_page() && $post->post_parent > 0 ) {
  //   $parent_id = $post->post_parent;
  // } else {

  // }

    $children = get_children(array(
      'post_parent' => $parent_id,
      'post_type'   => 'any',
      'numberposts' => -1,
      'post_status' => 'published',
      'orderby'     => 'post_title',
      'order'       => 'ASC'
    ));
    echo "<nav class='pages-nav'>";
    foreach ($children as $child) {
        echo "<a href='". get_permalink($child->ID) . "'>" . get_the_title($child->ID) . "</a>";
    }
    echo "</nav>";
}




/**
 * Gets a number of terms and displays them as options
 * @param  CMB2_Field $field 
 * @return array An array of options that matches the CMB2 options array
 * https://github.com/WebDevStudios/CMB2/wiki/Tips-&-Tricks#a-dropdown-for-taxonomy-terms-which-does-not-set-the-term-on-the-post
 */
function cmb2_get_term_options( $field ) {
  $args = $field->args( 'get_terms_args' );
  $args = is_array( $args ) ? $args : array();

  $args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

  $taxonomy = $args['taxonomy'];

  $terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
    ? get_terms( $args )
    : get_terms( $taxonomy, $args );

  // Initate an empty array
  $term_options = array();
  if ( ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
      $term_options[ $term->term_id ] = $term->name;
    }
  }

  return $term_options;
}

