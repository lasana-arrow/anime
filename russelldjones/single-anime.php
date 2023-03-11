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
echo '<div class="anime">';
while ( have_posts() ) :
	the_post();

$smallpic=get_the_post_thumbnail_url($post->ID,'medium');

echo '<div class="container"><div class="row anime-header">';
echo '<h1>'.$post->post_title.'</h1>';
echo '<h3>'.$post->_second_name.'<br>'.$post->_russian_name.'</h2>';
echo '<div><h4><a href="';
echo get_site_url();
echo '?year='.$post->_year.'">'.$post->_year.'</a></h4></div>';
//print_r($post);
$anime_type = get_post_meta($post->ID, '_anime_type', true);
if ((isset($anime_type))&&($anime_type>0))
{$br = get_term($anime_type, 'anime_type');
 $anime_type_name = $br->name;
}
if (isset ($anime_type_name))
echo '<div><h4><a href="'. get_term_link( $br->term_id, $br->taxonomy ) .'"> '.$anime_type_name.'</a></h4></div>';

if (($anime_type>=157)&&($anime_type<=159))
{$series = $post->_series;
if(!isset($series)) $series='0';
echo '<div><b>Серий:</b> '.$series.'</div>';
}


// 6. Режиссёр (таксономия  director)                    

            $formats=get_the_terms($post->id, 'director');
            if( is_array( $formats ) ){
			echo '<div><b>Режиссёр:</b>';	
	        foreach( $formats as $format ){
	    	echo '<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px; padding-right: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            }
             echo '</div>'; 
// 7. Студия (таксономия studio)  
            $formats=get_the_terms($post->id, 'studio');
            if( is_array( $formats ) ){
			echo '<div><b>Студия:</b>';	
	        foreach( $formats as $format ){
	    	echo '<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px; padding-right: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            }
             echo '</div>'; 

// 8. Оригинал (таксономия anime_original)  

  $formats=get_the_terms($post->id, 'anime_original');
            if( is_array( $formats ) ){
			echo '<div><b>Cнято по:</b>';	
	        foreach( $formats as $format ){
	    	echo '<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px; padding-right: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            }
             echo '</div>'; 


// 9. Автор оригинала (таксономия anime_original_author)
  $formats=get_the_terms($post->id, 'anime_original_author');
            if( is_array( $formats ) ){
			echo '<div><b>Авторство:</b>';	
	        foreach( $formats as $format ){
	    	echo '<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px; padding-right: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            }
             echo '</div>'; 

// 10. Категория (таксономия anime_tax)
  $formats=get_the_terms($post->id, 'anime_tax');
            if( is_array( $formats ) ){
			echo '<div><b>Время:</b>';	
	        foreach( $formats as $format ){
	    	echo '<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px; padding-right: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            }
             echo '</div>';  

// 11. Тэг (таксономия anime_tag)
   $formats=get_the_terms($post->id, 'anime_tag');
            if( is_array( $formats ) ){
			echo '<div><b>Важное:</b>';	
	        foreach( $formats as $format ){
	    	echo '<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px; padding-right: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            }
             echo '</div>';  

echo '</div></div>';

echo '<div class="container anime"><div class="row">';

echo do_shortcode('[showcatblock anime="'.$post->ID.'"]');
echo '</div>';		
echo '<div class="row"><h4> Составители и редакторы</h4></div>';
echo '<div class="row">';

$chnum = get_post_meta($post->ID, '_all_contributers', true);
$chnum=(int)$chnum;	
	
if ((isset($chnum))&&($chnum>0))
{
	$persons=get_the_terms($post->ID, 'anime_contributer');
	if( is_array( $persons ) ){				
	        foreach( $persons as $person )
			{ 
			 echo '<div>';	
			 $socials=get_term_meta( $person->term_id, 'socials', true );
			 echo '<b><a href="'. get_term_link( $person->term_id, $person->taxonomy ).'">'.$person->name.'</a></b>';
			  if ($socials!='')	
			 echo '<span class="block-term"><a href="'.$socials.'"><i class="fa fa-link"></i></a></span>';	
			  echo ':';	
			 for ($i=0; $i<$chnum; $i++)
			  {
				$cont=get_post_meta($post->ID, '_anime_contributer_'.$i, true);
				$cont=(int)$cont;
				if ($cont==$person->term_id)
				{ $role_id=get_post_meta($post->ID, '_anime_role_'.$i, true);
				  $role=get_term($role_id, 'anime_role'); 	
	              echo '<span class="block-term"><a href="'. get_term_link( $role->term_id, $role->taxonomy ) .'">'.$role->name.'</a>';
				  if ($i<$chnum-1) echo '<span style="padding: 0 5px 0 5px;"><i class="fa-solid fa-paw"></i></span>';
				  echo '</span>';
				}
			}
				echo '</div>';
			}
}
echo '</div>'; 
}
endwhile; // End of the loop.
echo '</div>';

get_footer();
wp_reset_postdata();