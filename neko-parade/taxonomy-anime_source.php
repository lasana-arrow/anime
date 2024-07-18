<?php
/**
 * Шаблон - личная страница источника в каталоге аниме
 *
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */

get_header();

$description = get_the_archive_description();
$queried_object = get_queried_object();
$term_id = $queried_object->term_id;
$image_id = get_term_meta( $term_id, '_thumbnail_id', 1 );

echo '<h1>';
single_term_title();
echo '</h1>';
echo $description;
$socials =get_term_meta( $term_id, 'socials', true );
if ($socials!="") echo '<div><a href="'.$socials.'" target="_new" nofollow><i class="fa fa-link"></i></a></div>';

$animes = get_posts( array(
	'tax_query' => array(
		array(
			'taxonomy' => 'anime_source',
			'field'    => 'id',
			'terms'    => $term_id,
			'orderby'  => 'post_title',
			
		)
	),
	'post_type' => 'anime',
	'posts_per_page' => -1,
	'orderby'  => 'post_title',
	'order' => 'ASC'
	) );
	if ($animes)
	{echo '<div><h4> Является источником для '.sizeof($animes).' аниме.</h4></div>';
		echo '</header>';
		
		echo '<div class="container">';
	    echo '<div class="row"><h3>Взята информация для:</h3></div>';
	  	foreach ($animes as $anime)
		{   
			echo '<div>'; 
			echo '<b><a href="'.get_page_link($anime).'">'.$anime->post_title.'</a></b> ';			
			echo '</div>';
					   
		}
	 echo '</div></div>';
	}
	else echo '</header><div><h4>Пока нет проектов</h4></div>';

echo '</div>';		
wp_reset_postdata();
wp_footer(); 
echo '</div>';
get_footer();
