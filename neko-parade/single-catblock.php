<?php
/**
 * The template for displaying single catblock posts
 *
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();

echo do_shortcode('[showcatblock id="'.$post->ID.'" show_attrib=1]');
			

    endwhile; // End of the loop.

get_footer();
