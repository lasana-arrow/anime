<?php
/**
 * Шаблон для вывода всех котиков по участию в кадре
 * acting_in_shot
 *
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */

get_header();


$queried_object = get_queried_object();
$term_id = $queried_object->term_id;

echo do_shortcode('[showtaxonomy type="catblock" tax="acting_in_shot" term_id="'.$term_id.'"]');		

wp_footer(); 
echo '</div>';
get_footer();
