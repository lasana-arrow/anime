<?php
/**
 * Шаблон для вывода блоков по автору оригинала
 * anime_original_author
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */

get_header();

$queried_object = get_queried_object();
$term_id = $queried_object->term_id;

echo do_shortcode('[showtaxonomy type="anime" tax="anime_original_author" term_id="'.$term_id.'"]');		

wp_footer(); 
echo '</div>';
get_footer();