<?php
/**
 * Шаблон для вывода блоков из аниме одной доп таксономии
 * anime_tax
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */

get_header();

$queried_object = get_queried_object();
$term_id = $queried_object->term_id;

echo do_shortcode('[showtaxonomy type="anime" tax="anime_tax" term_id="'.$term_id.'"]');		

wp_footer(); 
echo '</div>';
get_footer();