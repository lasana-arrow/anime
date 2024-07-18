<?php
/**
 * Шаблон - личная страница контрибутора в каталоге аниме
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
$image_url = wp_get_attachment_image_url( $image_id, 'full' );

echo '<div class="anime">';
echo '<header class="page-header alignwide">';
if ((isset($image_url))&&($image_url!=""))
{
echo '<div class="row"><div class="col-md-3">';
echo '<img src="'. $image_url .'" alt="';
single_term_title();
echo '"  style="max-width: 100%;" />';
echo '</div><div class="col-md-9">';
echo '<h1>';
single_term_title();
echo '</h1>';
echo $description;
$socials =get_term_meta( $term_id, 'socials', true );
if ($socials!="") echo '<a href="'.$socials.'"><i class="fa fa-link"></i></a>';
	
echo '</div></div>';
	}
else {
	echo '<h1>';
single_term_title();
echo '</h1>';
echo $description;
$socials =get_term_meta( $term_id, 'socials', true );
if ($socials!="") echo '<div><a href="'.$socials.'" target="_new" nofollow><i class="fa fa-link"></i></a></div>';

}

$animes = get_posts( array(
	'tax_query' => array(
		array(
			'taxonomy' => 'anime_contributer',
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
	{echo '<div><h4>'.sizeof($animes).'</h4></div>';
		echo '</header>';
		
		echo '<div class="container">';
	 //   echo '<div class="row"><h3>Участие:</h3></div>';
	  	foreach ($animes as $anime)
		{   
			echo '<div>'; 
			echo '<b><a href="'.get_page_link($anime).'">'.$anime->post_title.'</a></b>: ';
			$n=$anime->_all_contributers;
			for ($i=0; $i<$n; $i++)
			  {
				$cont=get_post_meta($anime->ID, '_anime_contributer_'.$i, true);
				$cont=(int)$cont;
				if ($cont==$term_id)
				{ $role_id=get_post_meta($anime->ID, '_anime_role_'.$i, true);
				  $role=get_term($role_id, 'anime_role'); 	
	      //        echo '<span class="block-term"><a href="'. get_term_link( $role->term_id, $role->taxonomy).'">'.$role->name.'</a>';
				  echo $role->name;
				  if ($i<$n-1) echo '<span style="padding: 0 5px 0 5px;"><i class="fa-solid fa-paw"></i></span>  ';
				  echo '</span>';
				}
			}
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
