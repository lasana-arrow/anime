<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

 /* Сложный поиск */

if ((isset($_GET['format']))||(isset($_GET['supernaturality']))||(isset($_GET['acting_in_story']))||(isset($_GET['acting_in_shot']))||(isset($_GET['position_in_shot']))||(isset($_GET['color']))||(isset($_GET['catname']))||(isset($_GET['quantum']))) 
{
echo do_shortcode ('[complexsearch]');
echo '<h2 style="padding: 20px 0;">Результаты сложного поиска</h2>';
echo '<div style=" padding-bottom: 10px;">Вот ваш запрос:</div>';	
echo '<div syle="padding-bottom: 20px;">';
if ((isset($_GET['format']))&&($_GET['format']!='')) { 
	echo '<div> <b>Формат</b>: ';
	$format=$_GET['format'];
    $char_term = get_term($format, 'format');
	echo $char_term->name;
    echo '</div>';  
    }
if ((isset($_GET['supernaturality']))&&($_GET['supernaturality']!=''))
	{ 
	echo '<div> <b>Сверхъестественное</b>: ';
	$supernaturality=$_GET['supernaturality'];	 $char_term = get_term($supernaturality, 'supernaturality');
	echo $char_term->name;
    echo '</div>';  
    }
		
if ((isset($_GET['acting_in_story']))&&($_GET['acting_in_story']!='')) 
	{ 
	echo '<div> <b>Участие в сюжете</b>: ';
	$acting_in_story=$_GET['acting_in_story'];	 $char_term = get_term($acting_in_story, 'acting_in_story');
	echo $char_term->name;
    echo '</div>';  
    }
	
if ((isset($_GET['acting_in_shot']))&&($_GET['acting_in_shot']!='')) 
	{ 
	echo '<div> <b>Действие в кадре</b>: ';
	$acting_in_shot=$_GET['acting_in_shot'];	 $char_term = get_term($acting_in_shot, 'acting_in_shot');
	echo $char_term->name;
    echo '</div>';  
    }
	
if ((isset($_GET['position_in_shot']))&&($_GET['position_in_shot']!='')) 
	{ 
	echo '<div> <b>Местоположение в кадре</b>: ';
	$position_in_shot=$_GET['position_in_shot'];	 $char_term = get_term($position_in_shot, 'position_in_shot');
	echo $char_term->name;
    echo '</div>';  
    }

if ((isset($_GET['color']))&&($_GET['color']!=''))
	{ 
	echo '<div> <b>Цвет/порода</b>: ';
	$color=$_GET['color'];	 $char_term = get_term($color, 'color');
	echo $char_term->name;
    echo '</div>';  
    }
	
if ((isset($_GET['catname']))&&($_GET['catname']!='')) 
	{ 
	echo '<div> <b>Кошачье имя</b>: ';
	$catname=$_GET['catname'];	 $char_term = get_term($catname, 'catname');
	echo $char_term->name;
    echo '</div>';  
    }
	
	
if ((isset($_GET['quantum']))&&($_GET['quantum']!='')) 
	{ 
	echo '<div> <b>Количество</b>: ';
	$quantum=$_GET['quantum'];	 $char_term = get_term($quantum, 'quantum');
	echo $char_term->name;
    echo '</div>';  
    }

echo '</div>';
$args=array(
	       'post_type'=>'catblock',
	       'posts_per_page'=>-1,
	       'orderby'     => 'meta_value',
		   'meta_key'    => '_block_id', 
	       'order'       => 'DESC'
	       );	

$args['tax_query'] = array('relation'=>'AND');
	
if ((isset($format))&&($format!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'format',
			         'field'    => 'id',
		             'terms'    => $format,
		                 ); 	

if ((isset($supernaturality))&&($supernaturality!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'supernaturality',
			         'field'    => 'id',
		             'terms'    => $supernaturality,
		                 ); 	

if ((isset($acting_in_story))&&($acting_in_story!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'acting_in_story',
			         'field'    => 'id',
		             'terms'    => $acting_in_story,
		                 ); 	

if ((isset($acting_in_shot))&&($acting_in_shot!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'acting_in_shot',
			         'field'    => 'id',
		             'terms'    => $acting_in_shot,
		                 ); 	

if ((isset($position_in_shot))&&($position_in_shot!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'position_in_shot',
			         'field'    => 'id',
		             'terms'    => $position_in_shot,
		                 ); 
	
if ((isset($color))&&($color!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'color',
			         'field'    => 'id',
		             'terms'    => $color,
		                 ); 

if ((isset($catname))&&($catname!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'catname',
			         'field'    => 'id',
		             'terms'    => $catname,
		                 ); 	
	
if ((isset($quantum))&&($quantum!=''))
		$args['tax_query'][] = array(
			         'taxonomy' => 'quantum',
			         'field'    => 'id',
		             'terms'    => $quantum,
		                 ); 
	
$allposts=get_posts($args);
if ($allposts)
{
    echo '<div> Найдено результатов:'.sizeof($allposts).'</div>'; 	
	foreach($allposts as $block )
	echo do_shortcode('[showcatblock id='.$block->ID.' show_anime="1"]');
}
else 
	
{
	echo '<h3 style="padding: 20px 0">К сожалению, ничего не найдено! Попробуйте задать менее жесткие условия!<h3>';
}
}

// Поиск по аниме
// 
elseif (isset($_GET['post_type'])) {
	echo '<h2> Результаты поиска по аниме</h2>';
	echo '<h3>Запрос: '.$_GET['s'].'</h3>';
	  	
 if (have_posts() )	{	
	while ( have_posts()  ) {
	the_post();
	echo ' <div> ';	
	echo '<b> <a href="'.get_permalink($post->ID).'">'. get_the_title() . '/'.$post->_second_name.'/'.$post->_russian_name.'</a> ('.$post->_year.')  </b>';
	echo '</div>';	
     }

 //   wp_reset_postdata(); // ВАЖНО вернуть global $post обратно
	}
	else 
	{echo '<div>К сожалению, мы не нашли ничего по запросу <b><i>'.$_GET['s'].'</i></b> Попробуйте ещё</div>';
	// echo do_shortcode('[animesearch]');
		}
}
         
elseif ( have_posts() ) {
?>	
		<h2>  
			<?php
	  if (isset ($_GET['post_type'])) echo 'Результат поиска по названиям аниме.';
	       else echo 'Результат поиска по описаниям';
			
			?>
		</h2>
	<?php 
    echo '<h3> Запрос: '.$_GET['s'].' </h3>';
?>
	<div class="search-result-count default-max-width">
		<?php
		printf(
			esc_html(
				/* translators: %d: The number of search results. */
				_n(
					'We found %d result for your search.',
					'We found %d results for your search.',
					(int) $wp_query->found_posts,
					'twentytwentyone'
				)
			),
			(int) $wp_query->found_posts
		);
		?>
	</div><!-- .search-result-count -->
	<?php
	// Start the Loop.
	while ( have_posts() ) {
		the_post();

	echo '<div class="container anime"><div class="row">';
    echo do_shortcode('[showcatblock id="'.$post->ID.'" show_anime="1"]');
    echo '</div></div>';	
	} // End the loop.

	// Previous/next page navigation.
	twenty_twenty_one_the_posts_navigation();

	// If no content, include the "No posts found" template.
}
	else {
	
	get_template_part( 'template-parts/content/content-none' );
}

get_footer();
