<?php
/**
 * Шаблон для вывода всех котиков по формату
 * format
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */


get_header();

$queried_object = get_queried_object();
$term_id = $queried_object->term_id;

echo do_shortcode('[showtaxonomy type="catblock" tax="format" term_id="'.$term_id.'"]');		

wp_footer(); 
echo '</div>';
get_footer();

