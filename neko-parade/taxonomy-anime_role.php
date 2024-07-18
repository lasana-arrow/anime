<?php
/**
 * Шаблон для вывода типов вкладов контрибуторов (например: описания. тексты, переводы и т.д.)
 *
 *
 * @package WordPress
 * @subpackage Russel D Jones
 */

get_header();

$description = get_the_archive_description();
$queried_object = get_queried_object();
$term_id = $queried_object->term_id;


echo '<div class="anime">';
echo '<header class="page-header alignwide">';
echo '<h1>';
single_term_title();
echo '</h1>';
echo $description;

echo '</header>';
$animes = get_posts( array(
	'tax_query' => array(
		array(
			'taxonomy' => 'anime_role',
			'field'    => 'id',
			'terms'    => $term_id,
			'orderby'  => 'title'
		)
	),
	'post_type' => 'anime',
	'posts_per_page' => -1,
	) );
	if ($animes)
	{   echo '<div class="container"><div class="row">';
	    echo '<h3>Кто занимался этим в следующих аниме:</h3></div>';
	  	foreach ($animes as $anime)
		{   
			echo '<div>'; 
			echo '<b><a href="'.get_page_link($anime).'">'.$anime->post_title.'</a></b>:';
			$n=$anime->_all_contributers;
			for ($i=0; $i<$n; $i++)
			  {
				$cont=get_post_meta($anime->ID, '_anime_role_'.$i, true);
				$cont=(int)$cont;
				if ($cont==$term_id)
				{ $role_id=get_post_meta($anime->ID, '_anime_contributer_'.$i, true);
				  $role=get_term($role_id, 'anime_contributer'); 	
	              echo '<span class="block-term"><a href="'. get_term_link( $role->term_id, $role->taxonomy).'">'.$role->name.'</a>';
				  if ($i<$n-1) echo ',';
				  echo '</span>';
				}
			}
			echo '</div>';	
			
		   
		}
	 echo '</div></div>';
	}
	else echo '<h4>Тут нет ничего.</h4>';

echo '</div>';		

wp_reset_postdata();
wp_footer(); 
echo '</div>';
get_footer();
