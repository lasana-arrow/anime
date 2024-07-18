<?php
/**
 * Шаблон для вывода всех котиков по цвету
 * color
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */


get_header();

$queried_object = get_queried_object();
$term_id = $queried_object->term_id;

echo do_shortcode('[showtaxonomy type="catblock" tax="color" term_id="'.$term_id.'"]');		

wp_footer(); 
echo '</div>';
get_footer();
