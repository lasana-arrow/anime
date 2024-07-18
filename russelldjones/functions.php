<?php
/* Корректируем привязки аниме к блокам       28
 * Таксономии аниме                           64
 * Таксономии котоблоков                      336
 * Аниме                                      606 
 * Котоблок                                   637
 * Допполя таксономии контрибутера            725
 * Допполя таксономии источника               774
 * Метабоксы к аниме                          783
 * Метабоксы к котоблокам                     1036
 * Колонка Аниме в админке                    1147
 * Добавление картинок к таксономиям          1222 
 * Шорткод showcatblock                       1251  
 * Шорткод howmanyanime                       1517 
 * Шорткод howmanyblocks                      1572 
 * Шаблон вывода по годам                     1588 
 * Шорткод showtaxonomy                       1650
 * Шорткод showanime                          1882 
 * Шорткод showcontributor                    1952 
 * Шорткод showsource                         1999
 * Форматирование описаний для таксономий     2042 
 * Шорткод animesearch                        2113 
 * Шорткод complexsearch                      2160 
 * Функция has_cats                           2327
 *           
 * */
add_filter( 'allow_dev_auto_core_updates', '__return_false' );
require_once __DIR__ . '/WP_Term_Image.php'; // Наши картинки для таксономий


// Корректируем привязки аниме к блокам 
/*
 $args=array('post_type'=>'catblock',
	         'posts_per_page'=>-1);
 $allposts=get_posts($args);
 if ($allposts)
 {
	 foreach ($allposts as $block)
	 {
	 $anime_id=get_post_meta($block->ID, '_anime_id', true);
	 $anime=get_post($anime_id); 	 
     update_post_meta($block->ID, '_anime_title', $anime->post_title); 
	 update_post_meta($block->ID, '_anime_name', $anime->post_name); 
	 update_post_meta($block->ID, '_anime_year', $anime->_year);
	 }
 }
*/

// Добавляет ссылку на страницу всех настроек в пункт меню админки "Настройки"
add_action('admin_menu', 'all_settings_link');
function all_settings_link(){
	add_options_page( __('All Settings'), __('All Settings'), 'manage_options', 'options.php?foo' );
}

add_action( 'wp_enqueue_scripts', 'true_child_styles' ); 
function true_child_styles() { 
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array(), null  );
    }

add_action( 'admin_enqueue_scripts', function(){
	wp_enqueue_script( 'anime-admin', get_stylesheet_directory_uri() .'/js/anime-admin.js' );
  	wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/style.css', array(), null  );
}, 99 );

add_theme_support( 'post-thumbnails', array( 'post', 'catblock' ) );


add_action( 'init', 'create_anime_taxonomies');	
// anime_source, anime_contributor, anime_role, director, studio, anime_original, anime_original_author, anime_tax, anime_tag

function create_anime_taxonomies(){	
    // Источник иноформации
	register_taxonomy( 'anime_source', [ 'anime' ], [
		'label'                 => '', 
		'labels'                => [
			'name'              => __( 'Источники', 'anime' ),
			'singular_name'     => __( 'Источник', 'anime' ),
			'search_items'      => __( 'Искать', 'anime' ),
			'all_items'         => __( 'Все', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить источник', 'anime' ),
			'new_item_name'     => __( 'Название', 'anime' ),
			'menu_name'         => __( 'Источник', 'anime' ),
		],
		'description'           => 'Источник, из которого была взята информация об аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'anime_source', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => false, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
	
    // Контрибьюторы
	register_taxonomy( 'anime_contributer', [ 'anime' ], [
		'label'                 => '', 
		'labels'                => [
			'name'              => __( 'Контрибьюторы', 'anime' ),
			'singular_name'     => __( 'Контрибьютор', 'anime' ),
			'search_items'      => __( 'Искать', 'anime' ),
			'all_items'         => __( 'Все', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить контрибьютора', 'anime' ),
			'new_item_name'     => __( 'Название', 'anime' ),
			'menu_name'         => __( 'Контрибьютор', 'anime' ),
			
		],
		'description'           => 'Люди, которые привнесли вклад в работу', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'anime_contributer', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => false, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
		'show_in_quick_edit'    => true,
		'sort'                  => true,
	
	] );
	
	// Вид участия
	register_taxonomy( 'anime_role', [ 'anime' ], [
		'label'                 => '', 
		'labels'                => [
			'name'              => __( 'Участия', 'anime' ),
			'singular_name'     => __( 'Участие', 'anime' ),
			'search_items'      => __( 'Искать', 'anime' ),
			'all_items'         => __( 'Все', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить участие', 'anime' ),
			'new_item_name'     => __( 'Название', 'anime' ),
			'menu_name'         => __( 'Участие', 'anime' ),
		],
		'description'           => 'Таксономия, связанная с таксономией контрибьюторов. Роли при участии в работе.', // описание таксономии
		'public'                => true,
	    'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'anime_role', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => false, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
	
	// Тип: ONA, OVA, TV, клип, реклама и т.д.
	register_taxonomy( 'anime_type', [ 'anime' ], [
		'label'                 => '', 
		'labels'                => [
			'name'              => __( 'Тип аниме', 'anime' ),
			'singular_name'     => __( 'Тип аниме', 'anime' ),
			'search_items'      => __( 'Искать тип', 'anime' ),
			'all_items'         => __( 'Все типы', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить новый тип', 'anime' ),
			'new_item_name'     => __( 'Название', 'anime' ),
			'menu_name'         => __( 'Типы аниме', 'anime' ),
		],
		'description'           => 'Тип: ONA, OVA, TV, музыкальный клип, реклама и т.д.', // описание таксономии
		'public'                => true,
	    'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'anime_type', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => false, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
   //Режиссёры аниме director
	register_taxonomy( 'director', [ 'anime' ],[
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Режиссёры аниме', 'anime' ),
			'singular_name'     => __( 'Режиссёр аниме', 'anime' ),
			'search_items'      => __( 'Искать режиссёра', 'anime' ),
			'all_items'         => __( 'Все режиссёры', 'anime' ),
			'view_item '        => __( 'Просмотреть режиссёра', 'anime' ),
			'edit_item'         => __( 'Редактировать информацию о режиссёре', 'anime' ),
			'update_item'       => __( 'Обновить информацию о режиссёре', 'anime' ),
			'add_new_item'      => __( 'Добавить нового режиссёра', 'anime' ),
			'new_item_name'     => __( 'Имя режиссёра', 'anime' ),
			'menu_name'         => __( 'Режиссёры аниме', 'anime' ),
		],
		'description'           => 'Режиссёры аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'director', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

    //Студия аниме studio
	register_taxonomy( 'studio', [ 'anime' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Студии', 'anime' ),
			'singular_name'     => __( 'Студия', 'anime' ),
			'search_items'      => __( 'Искать студию', 'anime' ),
			'all_items'         => __( 'Все студии', 'anime' ),
			'view_item '        => __( 'Просмотреть студию', 'anime' ),
			'edit_item'         => __( 'Редактировать информацию о студии', 'anime' ),
			'update_item'       => __( 'Обновить информацию о студии', 'anime' ),
			'add_new_item'      => __( 'Добавить новую студию', 'anime' ),
			'new_item_name'     => __( 'Название студии', 'anime' ),
			'menu_name'         => __( 'Студии аниме', 'anime' ),
		],
		'description'           => 'Студии аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => false, // равен аргументу show_ui
		'hierarchical'          => true,
		'rewrite'               => true,
		'query_var'             => 'studio', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

    //Оригинал, по которому было снято аниме anime_original
	register_taxonomy( 'anime_original', [ 'anime' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Оригиналы аниме', 'anime' ),
			'singular_name'     => __( 'Оригинал', 'anime' ),
			'search_items'      => __( 'Искать', 'anime' ),
			'all_items'         => __( 'Все записи', 'anime' ),
			'view_item '        => __( 'Просмотреть запись', 'anime' ),
			'edit_item'         => __( 'Редактировать информацию', 'anime' ),
			'update_item'       => __( 'Обновить информацию', 'anime' ),
			'add_new_item'      => __( 'Добавить новый оригинал', 'anime' ),
			'new_item_name'     => __( 'Название', 'anime' ),
			'menu_name'         => __( 'Оригиналы аниме', 'anime' ),
		],
		'description'           => 'Литературный (или какой другой) оригинал, по которму было снято аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => false, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'anime_original', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
  
  //Автор оригинала, по которому было снято аниме anime_original_author
 	register_taxonomy( 'anime_original_author', [ 'anime' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Авторы оригиналов аниме', 'anime' ),
			'singular_name'     => __( 'Автор', 'anime' ),
			'search_items'      => __( 'Искать автора', 'anime' ),
			'all_items'         => __( 'Все авторы', 'anime' ),
			'view_item '        => __( 'Просмотреть автора', 'anime' ),
			'edit_item'         => __( 'Редактировать информацию об авторе', 'anime' ),
			'update_item'       => __( 'Обновить информацию об авторе', 'anime' ),
			'add_new_item'      => __( 'Добавить нового автора', 'anime' ),
			'new_item_name'     => __( 'Имя автора', 'anime' ),
			'menu_name'         => __( 'Авторы оригиналов аниме', 'anime' ),
		],
		'description'           => 'Авторы литературных (или каких других) оригиналов, по которым было снято аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => false, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'anime_original_author', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
 
   // Дополнительные категории аниме anime_tax
	register_taxonomy( 'anime_tax', [ 'anime' ], [
		'label'                 => '', 
		'labels'                => [
			'name'              => __( 'Время аниме', 'anime' ),
			'singular_name'     => __( 'Время аниме', 'anime' ),
			'search_items'      => __( 'Искать время', 'anime' ),
			'all_items'         => __( 'Все времена', 'anime' ),
			'view_item '        => __( 'Просмотреть карточку времени', 'anime' ),
			'parent_item'       => __( 'Родительская карточка времени', 'anime' ),
			'parent_item_colon' => __( 'Родительская карточка времени', 'anime' ),
			'edit_item'         => __( 'Редактировать  карточку времени', 'anime' ),
			'update_item'       => __( 'Обновить  карточку времени', 'anime' ),
			'add_new_item'      => __( 'Добавить новое время', 'anime' ),
			'new_item_name'     => __( 'Название новое время', 'anime' ),
			'menu_name'         => __( 'Время', 'anime' ),
		],
		'description'           => 'Это дополнительные категории ко всем тем, что уже есть', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => true,
		'rewrite'               => true,
		'query_var'             => 'anime_tax', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => false, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

    // Дополнительные тэги аниме  anime_tag
	register_taxonomy( 'anime_tag', [ 'anime' ], [
		'label'                 => '', 
		'labels'                => [
			'name'              => __( 'Важное', 'anime' ),
			'singular_name'     => __( 'Важное', 'anime' ),
			'search_items'      => __( 'Искать', 'anime' ),
			'all_items'         => __( 'Все', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'parent_item'       => __( 'Родительский', 'anime' ),
			'parent_item_colon' => __( 'Родительский', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить', 'anime' ),
			'new_item_name'     => __( 'Название', 'anime' ),
			'menu_name'         => __( 'Важное', 'anime' ),
		],
		'description'           => 'Это дополнительные тэги ко всем тем, что уже есть', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => true,
		'rewrite'               => true,
		'query_var'             => 'anime_tag', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
}


// Таксономии для кошачьего каталога. 
// В других базах использоватьcя не будут

add_action( 'init', 'create_catblock_taxonomies',0 );
// format, supernaturality, acting_in_story, acting_in_shot, position_in_shot, color, quantum

function create_catblock_taxonomies()
{
    //Форматы кота в аниме format
	register_taxonomy( 'format', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Форматы кота в аниме', 'anime' ),
			'singular_name'     => __( 'Формат кота в аниме', 'anime' ),
			'search_items'      => __( 'Искать Формат', 'anime' ),
			'all_items'         => __( 'Все Форматы', 'anime' ),
			'view_item '        => __( 'Просмотреть Формат', 'anime' ),
			'edit_item'         => __( 'Редактировать Формат', 'anime' ),
			'update_item'       => __( 'Обновить Формат', 'anime' ),
			'add_new_item'      => __( 'Добавить новый Формат', 'anime' ),
			'new_item_name'     => __( 'Формат', 'anime' ),
			'menu_name'         => __( 'Формат', 'anime' ),
		],
		'description'           => 'Форматы кота в аниме', // описание таксономии
		'public'                => true,
	    'hierarchical'          => false,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_tags_meta_box', 
		'show_admin_column'     => true, 
	
	] );
 //Форматы кота в аниме format
	/*register_taxonomy( 'block_anime', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Аниме', 'anime' ),
			'singular_name'     => __( 'Аниме', 'anime' ),
			'search_items'      => __( 'Аниме', 'anime' ),
			'all_items'         => __( 'Аниме', 'anime' ),
			'view_item '        => __( 'Аниме', 'anime' ),
			'edit_item'         => __( 'Аниме', 'anime' ),
			'update_item'       => __( 'Аниме', 'anime' ),
			'add_new_item'      => __( 'Аниме', 'anime' ),
			'new_item_name'     => __( 'Аниме', 'anime' ),
			'menu_name'         => __( 'Аниме', 'anime' ),
		],
		'description'           => 'Форматы кота в аниме', // описание таксономии
		'public'                => false,
	    'hierarchical'          => false,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_tags_meta_box', 
		'show_admin_column'     => true, 
	
	] );*/

    //Сверхъестественность кота в аниме supernaturality
	register_taxonomy( 'supernaturality',[ 'catblock' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Сверхъестественности кота в аниме', 'anime' ),
			'singular_name'     => __( 'Сверхъестественность кота в аниме', 'anime' ),
			'search_items'      => __( 'Искать сверхъестественность', 'anime' ),
			'all_items'         => __( 'Все сверхъестественности', 'anime' ),
			'view_item '        => __( 'Просмотреть сверхъестественность', 'anime' ),
			'edit_item'         => __( 'Редактировать сверхъестественность', 'anime' ),
			'update_item'       => __( 'Обновить сверхъестественность', 'anime' ),
			'add_new_item'      => __( 'Добавить новую сверхъестественность', 'anime' ),
			'new_item_name'     => __( 'Сверхъестественность', 'anime' ),
			'menu_name'         => __( 'Сверхъестественность', 'anime' ),
		],
		'description'           => 'Сверхъестественности кота в аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'supernaturality', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_tags_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

//Участие кота в сюжете аниме acting_in_story

	register_taxonomy( 'acting_in_story', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Участие в сюжете', 'anime' ),
			'singular_name'     => __( 'Участие в сюжете', 'anime' ),
			'search_items'      => __( 'Искать участие', 'anime' ),
			'all_items'         => __( 'Все участия', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить новое', 'anime' ),
			'new_item_name'     => __( 'Участие в сюжете', 'anime' ),
			'menu_name'         => __( 'Участие в сюжете', 'anime' ),
		],
		'description'           => 'Участие кота в сюжете аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'acting_in_story', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

    //Участие кота в кадре аниме acting_in_shot
	register_taxonomy( 'acting_in_shot', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Действие в кадре', 'anime' ),
			'singular_name'     => __( 'Действие в кадре', 'anime' ),
			'search_items'      => __( 'Искать участие', 'anime' ),
			'all_items'         => __( 'Все участия', 'anime' ),
			'view_item '        => __( 'Просмотреть действие в кадре', 'anime' ),
			'edit_item'         => __( 'Редактировать действие в кадре', 'anime' ),
			'update_item'       => __( 'Обновить действие в кадре', 'anime' ),
			'add_new_item'      => __( 'Добавить новое действие в кадре', 'anime' ),
			'new_item_name'     => __( 'Действие в кадре', 'anime' ),
			'menu_name'         => __( 'Действие в кадре', 'anime' ),
		],
		'description'           => 'Участие кота в кадре аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'acting_in_shot', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

     //Местоположение кота в кадре аниме position_in_shot
	 register_taxonomy( 'position_in_shot', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Местоположение на кадре', 'anime' ),
			'singular_name'     => __( 'Местоположение на кадре', 'anime' ),
			'search_items'      => __( 'Искать местоположение', 'anime' ),
			'all_items'         => __( 'Все местоположения', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить', 'anime' ),
			'new_item_name'     => __( 'Местоположение на кадре', 'anime' ),
			'menu_name'         => __( 'Местоположение на кадре', 'anime' ),
		],
		'description'           => 'Местоположение кота в кадре аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'position_in_shot', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_tags_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

    //Цвет кота в аниме color
	register_taxonomy( 'color', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Цвет и/или порода', 'anime' ),
			'singular_name'     => __( 'Цвет и/или порода', 'anime' ),
			'search_items'      => __( 'Искать цвет', 'anime' ),
			'all_items'         => __( 'Все цвета', 'anime' ),
			'view_item '        => __( 'Просмотреть цвет', 'anime' ),
			'edit_item'         => __( 'Редактировать цвет', 'anime' ),
			'update_item'       => __( 'Обновить цвет', 'anime' ),
			'add_new_item'      => __( 'Добавить новый цвет и/или породу', 'anime' ),
			'new_item_name'     => __( 'Цвет/порода', 'anime' ),
			'menu_name'         => __( 'Цвет/порода', 'anime' ),
		],
		'description'           => 'Цвет и порода кота в аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'color', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );

   
     //порода кота в аниме breed
  	register_taxonomy( 'quantum', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Количество', 'anime' ),
			'singular_name'     => __( 'Количество', 'anime' ),
			'search_items'      => __( 'Количество', 'anime' ),
			'all_items'         => __( 'Все количества', 'anime' ),
			'view_item '        => __( 'Просмотреть', 'anime' ),
			'edit_item'         => __( 'Редактировать', 'anime' ),
			'update_item'       => __( 'Обновить', 'anime' ),
			'add_new_item'      => __( 'Добавить', 'anime' ),
			'new_item_name'     => __( 'Количество', 'anime' ),
			'menu_name'         => __( 'Количество', 'anime' ),
		],
		'description'           => 'Количество котов в аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'quantum', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
	 //Имя кота в аниме catname
	register_taxonomy( 'catname', ['catblock'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => __( 'Кошачье имя', 'anime' ),
			'singular_name'     => __( 'Кошачье имя', 'anime' ),
			'search_items'      => __( 'Искать кошачье имя', 'anime' ),
			'all_items'         => __( 'Все кошачьи имя', 'anime' ),
			'view_item '        => __( 'Просмотреть кошачье имя', 'anime' ),
			'edit_item'         => __( 'Редактировать кошачье имя', 'anime' ),
			'update_item'       => __( 'Обновить кошачье имя', 'anime' ),
			'add_new_item'      => __( 'Добавить новое кошачье имя', 'anime' ),
			'new_item_name'     => __( 'Кошачье имя', 'anime' ),
			'menu_name'         => __( 'Кошачье имя', 'anime' ),
		],
		'description'           => 'Кошачье имя в аниме', // описание таксономии
		'public'                => true,
	    'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'hierarchical'          => false,
		'rewrite'               => true,
		'query_var'             => 'catname', // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => 'post_categories_meta_box', 
		'show_admin_column'     => true, 
		'show_in_rest'          => true, 
		'rest_base'             => null, 
	] );
}


/* Тип записей "аниме"  anime */
function create_anime_posttype() {
    $labels = array(
        'name' => __( 'Аниме', 'anime' ),
        'singular_name' => __( 'Аниме', 'anime' ),
        'menu_name' => __( 'Аниме', 'anime' ),
        'all_items' => __( 'Все аниме', 'anime' ),
        'view_item' => __( 'Просмотр карточки аниме', 'anime' ),
        'add_new_item' => __( 'Добавить аниме', 'anime' ),
        'add_new' => __( 'Добавить аниме', 'anime' ),
        'edit_item' => __( 'Редактировать карточку аниме', 'anime' ),
        'update_item' => __( 'Обновить карточку аниме', 'anime' ),
        'search_items' => __( 'Искать аниме', 'anime' ),
        'not_found' => __( 'Не найдено', 'anime' ),
        'not_found_in_trash' => __( 'Не найдено в корзине', 'anime' ),
    );

    $args = array(
        'label' => __( 'Аниме', 'anime' ),
        'description' => __( 'Каталог аниме', 'anime' ),
        'labels' => $labels,
        'supports' => array('title'),
        'taxonomies' => array('anime_type', 'director', 'studio', 'anime_original', 'anime_original_author', 'anime_contributer', 'anime_role' ),
        'hierarchical' => false,
        'public' => true,
		'menu_position' => 21,		 
		'menu_icon' =>get_stylesheet_directory_uri().'/img/anime_menu.png',
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type( 'anime', $args );
}
add_action( 'init', 'create_anime_posttype');

/* Тип записей "блок, в котором встречается кошка в аниме"  catblock */
function create_catblock_posttype() {
    $labels = array(
        'name' => __( 'Блок', 'catblock' ),
        'singular_name' => __( 'Блок', 'catblock' ),
        'menu_name' => __( 'Блок', 'catblock' ),
        'all_items' => __( 'Все блоки', 'catblock' ),
        'view_item' => __( 'Просмотр карточки блока', 'catblock' ),
        'add_new_item' => __( 'Добавить блок', 'catblock' ),
        'add_new' => __( 'Добавить блок', 'catblock' ),
        'edit_item' => __( 'Редактировать карточку блока', 'catblock' ),
        'update_item' => __( 'Обновить карточку блока', 'catblock' ),
        'search_items' => __( 'Искать блок', 'catblock' ),
        'not_found' => __( 'Не найдено', 'catblock' ),
        'not_found_in_trash' => __( 'Не найдено в корзине', 'catblock' ),
    );

    $args = array(
        'label' => __( 'блок', 'catblock' ),
        'description' => __( 'Блоки с описанием фрагментов, в которых встречаются кошки в аниме', 'catblock' ),
        'labels' => $labels,
        'supports' => array( 'title', 'editor', 'thumbnail'),
        'taxonomies' => array('format','supernaturality', 'acting_in_story', 'acting_in_shot', 'position_in_shot', 'color', 'breed', 'catname','quantum'),
        'hierarchical' => false,
        'public' => true,
		'menu_position' => 22,
		'menu_icon' =>get_stylesheet_directory_uri().'/img/neko.png',      
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type( 'catblock', $args );

}
add_action( 'init', 'create_catblock_posttype', 0 );


// Дополнительное поле "Ссыль" для контрибутеров
// страница добавления категории
function taxonomy_add_new_meta_field() {
	// это добавит мета-поле на страницу добавления категории
	?>
	<div class="form-field">
		<label for="socials"><?php _e( 'Ссыль' ); ?></label>
		<input type="text" name="socials" id="socials" value="">
		<p class="description"><?php _e( 'Ссылка на сайт или, например, жж' ); ?></p>
	</div>
<?php
}
add_action( 'anime_contributer_add_form_fields', 'taxonomy_add_new_meta_field', 10, 2 );

add_action( 'anime_contributer_edit_form_fields', 'add_social_links' );
function add_social_links( $term ) {
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Ссыль' ); ?></label></th>
		<td>
			<input type="text" name="socials" value="<?php esc_attr_e( get_term_meta( $term->term_id, 'socials', true ) ) ?>">
		</td>
	</tr>
	<?php
}

// Сохраним значение произвольно поля
add_action( 'edited_anime_contributer', 'save_social_links' );
add_action( 'created_anime_contributer', 'save_social_links' );

function save_social_links( $term_id ) {

	if ( ! isset( $_POST['socials'] ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_term', $term_id ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_{$term_id}" ) && ! wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' ) ) {
		return;
	}

	update_term_meta( $term_id, 'socials', wp_unslash( $_POST['socials'] ) );

	return $term_id;
}
	
// Дополнительное поле "ссыль" для источников	

add_action( 'anime_source_add_form_fields', 'taxonomy_add_new_meta_field', 10, 2 );
add_action( 'anime_source_edit_form_fields', 'add_social_links' );

// Сохраним значение произвольно поля
add_action( 'edited_anime_source', 'save_social_links' );
add_action( 'created_anime_source', 'save_social_links' );
	

// Добавляем метабоксы к аниме
// 
// ИНФОРМАЦИЯ ОБ АНИМЕ
// 
// 1. Второе название                                   second_name
// 2. Название по-русски                                russian_name   
// 3. Год выхода                                        year 
// 4. Тип (таксономия anime_type)                       anime_type  - перенесли в таксономии
// 5. Серии                                             series включается только если  тип = ONA(157), OVA(158) и TV(159)
// 6. Режиссёр (таксономия  director)                    
// 7. Студия (таксономия studio)                        
// 8. Оригинал (таксономия anime_original)        
// 9. Автор оригинала (таксономия anime_original_author)
// 10. Категория (таксономия anime_tax)
// 11. Тэг (таксономия anime_tag)
// 12. Составители и редакторы:
// anime_contributer_1 - anime_role_1
// anime_contributer_2 - anime_role_2
// ...
// anime_contributer_n - anime_role_n
// n берётся из all_contributers
// 13. Источник. Он без ролей, просто списком

add_action('add_meta_boxes', 'anime_info_metabox_init'); 
add_action('save_post', 'anime_info_metabox_save'); 

function anime_info_metabox_init() { 
add_meta_box('info_metabox', 'Информация об аниме', 'anime_info_metabox_showup', 'anime', 'advanced', 'default'); 
} 

function anime_info_metabox_showup($post, $box) { 
echo '<div class="adminka">';
echo '<div class="container adminka">';	
	
// 1. Второе название	
$second_name = get_post_meta($post->ID, '_second_name', true);
if(!isset($second_name)) $second_name='';
echo '<div class="row adminka"><div class="col-md-2 name">Второе название: </div><div class="col-md-8"><input type="text" name="second_name" value="'. esc_attr($second_name) . '" size="80"/></div></div>';

// 2. Русское название
$russian_name = get_post_meta($post->ID, '_russian_name', true);
if(!isset($russian_name)) $russian_name='';
echo '<div class="row"><div class="col-md-2 name">Русское название: </div><div class="col-md-8"><input type="text" name="russian_name" value="'. esc_attr($russian_name) . '" size="80"/></div></div>';

	
// 3. Год
$year = get_post_meta($post->ID, '_year', true);
if(!isset($year)) $year='';
echo '<div class="row adminka"><div class="col-md-2 name">Год выпуска: </div><div class="col-md-8"><input type="text" name="year" value="'. esc_attr($year) . '"/></div></div>';

// 4. Тип
$anime_type = get_post_meta($post->ID, '_anime_type', true);
if ((isset($anime_type))&&($anime_type>0))
{$br = get_term($anime_type, 'anime_type');
 $anime_type_name = $br->name;
}
 else
 {$anime_type=0;
  $anime_type_name='Выберите тип из списка';}

$alltypes=get_terms('anime_type','orderby=name&hide_empty=0');	
	
$series = get_post_meta($post->ID, '_series', true);
if(!isset($series)) $series='0';

wp_nonce_field('anime_info_action', 'anime_info_nonce');

	
// Вывод типов 
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	{ echo '<div class="row adminka"><div class="col-md-2 name">Тип аниме: </div><div class="col-md-10">';	
      echo '<select name="anime_type"><option value="'.$anime_type.'">'.$anime_type_name.'</option>';
		foreach ($alltypes as $atype)
		{
			echo '<option value="'.$atype->term_id.'">'.$atype->name.'</option>';
		}
		echo '</select>';
	} else
		echo '<h4>Нужно создать типы аниме в меню слева. Сохраните аниме, создайте их и возвращайтесь, пожалуйста.</h4>';
	  echo '</div></div>'; 	

// 5. Серии
if (($anime_type>=157)&&($anime_type<=159))
echo '<div class="row adminka"><div class="col-md-2 name">Серий: </div><div class="col-md-10"><input type="text" name="series" value="'.esc_attr($series).'"/></div></div>';
	
echo '</div>';	
	 echo "</div>";
}

function anime_info_metabox_save($postID) { 

if ((!isset($_POST['second_name']))&&(!isset($_POST['russian_name']))&&(!isset($_POST['year']))&&(!isset($_POST['duration']))&&(!isset($_POST['series']))) 
return; 
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
return; 
if (wp_is_post_revision($postID)) 
return; 
	
check_admin_referer('anime_info_action', 'anime_info_nonce'); 

if (isset($_POST['second_name']))
    {  
     $data = sanitize_text_field($_POST['second_name']); 
	 if ($data!="")
     update_post_meta($postID, '_second_name', $data); 
     }
if (isset($_POST['russian_name']))
    {  
     $data = sanitize_text_field($_POST['russian_name']);
	 if ($data!="")
     update_post_meta($postID, '_russian_name', $data); 
     }
	 
if (isset($_POST['year']))
    {  
     $data = (int)$_POST['year'];
     update_post_meta($postID, '_year', $data); 	
     }
	 
if (isset($_POST['anime_type']))
    {  
     $data = (int)$_POST['anime_type'];	
     update_post_meta($postID, '_anime_type', $data); 	
	 wp_set_object_terms($postID,$data,'anime_type',true); 
	    
     }
if (isset($_POST['series']))
    {  
     $data = (int)$_POST['series'];
     update_post_meta($postID, '_series', $data); 	
     }	
}

// 12. Метабокс "Составители и редакторы" (выпадающий список таксономий anime_contributer + anime_role) 
// anime_contributer_1 - anime_role_1
// anime_contributer_2 - anime_role_2
// ...
// anime_contributer_n - anime_role_n
// n берётся из all_contributers

add_action('add_meta_boxes', 'contributers_init'); 
add_action('save_post', 'contributers_save'); 

function contributers_init() {
add_meta_box('contributers', 'Составители и редакторы', 'contributers_showup', 'anime', 'advanced', 'default');
}

function contributers_showup($post, $box) {
	
$chnum = get_post_meta($post->ID, '_all_contributers', true);
$chnum=(int)$chnum;	
	
$people=array();
if ((isset($chnum))&&($chnum>0))
{
	for ($i=0; $i<$chnum; $i++)
	{
	 $people[$i]['id'] = get_post_meta($post->ID, '_anime_contributer_'.$i, true);
	 $person=get_term($people[$i]['id'], 'anime_contributer');
	 $people[$i]['name']=$person->name;
	 $people[$i]['role_id']= get_post_meta($post->ID, '_anime_role_'.$i, true);	
	 $role=get_term($people[$i]['role_id'], 'anime_role'); 	
	 $people[$i]['role']=$role->name;	
	}
}
	else
	{
	 $people[0]['id']=0;
	 $people[0]['name']='Выберите человека из списка';
	 $people[0]['role_id']=0;
	 $people[0]['role']='Выберите роль из списка';	
	}

wp_nonce_field('contributers_action', 'contributers_nonce');	
	
$people_cats=get_terms('anime_contributer','orderby=name&hide_empty=0');
$role_cats=get_terms('anime_role','orderby=name&hide_empty=0');

	
echo '<div class="container">';
echo '<div class="row"><b>Укажите тех, кто работал над описанием этого аниме. <br>Если их пока нет в списке - сохраните аниме, создайте участника в разделе слева и возвращайтесь сюда.</b></div>';	

echo '<input type="hidden" name="deleted_contributers" id="deleted_contributers" value="0">';
	
		
 if ((isset($chnum))&&($chnum>0))
 {  echo '<input type="hidden" name="all_contributers" id="all_contributers" value="'.$chnum.'">';

	 // Если есть уже люди
     if (($people_cats)&&($role_cats))
	    { // Если в списке есть хоть один
		 for ($i=0; $i<$chnum; $i++)
		 {
		  echo '<div class="row" id="div_contributer_'.$i.'">';
          echo '<div class="col-md-1">Участник:</div><div class="col-md-3"> <select class="contributer" name="anime_contributer_'.$i.'"  id="anime_contributer_'.$i.'">';
		  echo '<option id="first_value_'.$i.'" value="'.$people[$i]['id'].'">'.$people[$i]['name'].'</option>';
 
			 foreach($people_cats as $cat)
			 { echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';}
		 echo '</select>';
		 echo '</div>';
		 echo '<div class="col-md-1">Роль:</div><div class="col-md-3"> <select class="role" name="anime_role_'.$i.'"  id="anime_role_'.$i.'">';
		  echo '<option id="first_role_'.$i.'" value="'.$people[$i]['role_id'].'">'.$people[$i]['role'].'</option>';
 
			 foreach($role_cats as $cat)
			 { echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';}
		 echo '</select>';	 
		 echo '</div>';	 
	     echo '<div class="col-md-2"><a style="color: #a50007" id="delete_button_'.$i.'" onClick="JavaScript: deleteRace('.$i.')"><i class="fas fa-times"></i></a> Удалить участие</div>';	 
         echo '</div>';	 
		 }
 } // Если есть уже заполненные участники	  
	 else
	 {
		echo '<h4>Нет либо участников, либо их ролей. Соханите аниме, заведите нужно количесвто имён и ролей в менб слева и возвращайтесь!</h4>'; 
	 }
echo '</div>';	
}
	else
	{ 
		echo '<input type="hidden" name="all_contributers" id="all_contributers" value="1">';
		if (($people_cats)&&($role_cats))
     	{
		  echo '<div class="row adminka" id="div_contributer_0">';
          echo '<div class="col-md-1 name">Участник:</div><div class="col-md-3"> <select class="contributer" name="anime_contributer_0"  id="anime_contributer_0">';
		  echo '<option id="first_value_0" value="'.$people[0]['id'].'">'.$people[0]['name'].'</option>';
 
			 foreach($people_cats as $cat)
			 { echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';}
		 echo '</select>';
		 echo '</div>';
		 echo '<div class="col-md-1 name">Роль:</div><div class="col-md-3"> <select class="role" name="anime_role_0"  id="anime_role_0">';
		  echo '<option id="first_role_0" value="'.$people[0]['role_id'].'">'.$people[0]['role'].'</option>';
 
			 foreach($role_cats as $cat)
			 { echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';}
		 echo '</select>';	 
		 echo '</div>';	 
	     echo '<div class="col-md-1"><a style="color: #a50007" id="delete_button_0" onClick="JavaScript: deleteRace(0)"><i class="fas fa-times"></i></a> Удалить участие</div>';	 
         echo '</div>';	 
	       }

	   else
	   {
		   	echo '<h4>Нет либо участников, либо их ролей. Соханите аниме, заведите нужно количесвто имён и ролей в меню слева и возвращайтесь!</h4>'; 
	
	   }
	}
	
	// Добавить ещё строку
	
	echo '<div class="row adminka"><div class="col-md-12" id="add_race"><a style="color: #008005" onClick="JavaScript: addRace();"><i class="fas fa-plus"></i></a> Ещё участник</div>';
  echo "</div>";
}
function contributers_save($postID) {
if (isset ($_POST['all_contributers']))
{
$races=(int)$_POST['all_contributers'];	

if (($races==0)||(($races==1)&&(($_POST['anime_contributer_0']=="0")||($_POST['anime_role_0']=="0"))))
{
 update_post_meta($postID, '_all_contributers', 0);	
 return;
}
}
else return;
	
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
return;
	
if (wp_is_post_revision($postID))
return;
	
check_admin_referer('contributers_action', 'contributers_nonce');

$all_num = (int)$_POST['all_contributers'];
update_post_meta($postID, '_all_contributers', $all_num);

if ((isset($_POST['deleted_contributers']))&&($_POST['deleted_contributers']>0))
{
	wp_delete_object_term_relationships ($postID, 'anime_contributer');
	wp_delete_object_term_relationships ($postID, 'anime_role');
}
	
  for ($i=0; $i<$all_num; $i++)
	{
	  if ((isset($_POST['anime_contributer_'.$i]))&&(isset($_POST['anime_role_'.$i])))
	   {
         update_post_meta($postID, '_anime_contributer_'.$i, $_POST['anime_contributer_'.$i]);
		 update_post_meta($postID, '_anime_role_'.$i, $_POST['anime_role_'.$i]);
		 wp_set_object_terms($postID,(int)$_POST['anime_contributer_'.$i],'anime_contributer',true); 
	     wp_set_object_terms($postID,(int)$_POST['anime_role_'.$i],'anime_role',true); 	     
	    }
	  }	
	
}

/* Метабоксы к блокам (все таксономии вынесены на правую панель, здесь осталось только 
 * "Имя" - НОВОЕ!!!
 * "В каком аниме встречается"
 * "ID блока"
 *  */


/* В каком аниме встречается */
add_action('add_meta_boxes', 'catblock_metabox_init'); 
add_action('save_post', 'catblock_metabox_save'); 


function catblock_metabox_init() { 
add_meta_box('catblock_metabox', 'В каком аниме встречается', 'catblock_metabox_showup', 'catblock', 'advanced', 'default'); 
} 

function catblock_metabox_showup($post, $box) { 
	
wp_nonce_field('catblock_action', 'catblock_nonce');

$anime_num = get_post_meta($post->ID, '_anime_id', true);

if((!isset($anime_num))||($animme_num===0)) 
{ $anime_num='0';
  $anime_title='Выберите аниме';
}
	else{
		 $animepost = get_post($anime_num);
         $anime_title = $animepost->post_title;
	}
$alt_query=new WP_Query;
	
$titles = $alt_query->query( array(	
	'post_type' => 'anime',
	'orderby' => array('name' => 'ASC'),
	'posts_per_page' => -1,
) );

//var_dump($alt_query->request);
echo '<div class="container">';	
echo '<h4>Выберите, пожалуйста, аниме, в котором встречается эта кошка. Если этого аниме ещё нет в списке, то нужно будет вначале создать его в разделе "Аниме", а затем вернуться сюда и выбрать его из списка.</h4>';	
echo '<div class="row"><div class="col-md-2 name">Аниме:</div><div class="col-md-4"> <select name="anime_id">'; 
echo '<option value="'.$anime_num.'">'.$anime_title.'</option>';
	
	foreach( $titles as $atitle ){		
		echo '<option value="'.$atitle->ID.'" >'.$atitle->post_title.'</option>';
}
	echo '</select></div></div></div>';
	wp_reset_query(); 
}

function catblock_metabox_save($postID) { 

if (!isset($_POST['anime_id']))
return; 
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
return; 
if (wp_is_post_revision($postID)) 
return; 
	
check_admin_referer('catblock_action', 'catblock_nonce');
	 
$data = (int)$_POST['anime_id'];
	 if ($data!=0)
	 {
	// Присобачим к блоку год и название из аниме, чтобы по нему можно было искать и сортировать
	 $anime=get_post($data); 	 
     update_post_meta($postID, '_anime_id', $data); 
     update_post_meta($postID, '_anime_title', $anime->post_title); 
	 update_post_meta($postID, '_anime_name', $anime->post_name); 
	 update_post_meta($postID, '_anime_year', $anime->_year);		 
	 }
	
}

add_action('add_meta_boxes', 'catblock_indexbox_init'); 
add_action('save_post', 'catblock_indexbox_save'); 

function catblock_indexbox_init() { 
add_meta_box('catblock_indexbox', 'Индекс блока YYYY-MM-XXXXXX-NN', 'catblock_indexbox_showup', 'catblock', 'advanced', 'default'); 
} 

function catblock_indexbox_showup($post, $box) { 
	
wp_nonce_field('indexbox_action', 'indexbox_nonce');

$index = get_post_meta($post->ID, '_block_id', true);
echo '<div class="container">';	
echo '<h4>Укажите, пожалуйста, ID в формате YYYY MM XXXXXX NN без пробелов</h4>';	
echo '<div class="row"><div class="col-md-2 name">ID:</div><div class="col-md-4"> <input type="text" name="block_id" value="'.$index.'"></div></div></div>'; 
}

function catblock_indexbox_save($postID) { 

if (!isset($_POST['block_id']))
return; 
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
return; 
if (wp_is_post_revision($postID)) 
return; 
	
check_admin_referer('indexbox_action', 'indexbox_nonce');
	 
$data = (int)$_POST['block_id'];
	 if ($data!=0)
	 {
	  update_post_meta($postID, '_block_id', $data); 
     }
	
}

// Вставляем колонку АНИМЕ к блоку
// add_filter( 'manage_edit-{ТИП ПОСТА}_columns', 'true_add_post_columns', 25 );
add_filter( 'manage_edit-catblock_columns', 'true_add_post_columns', 25 ); // для обычных записей
 
function true_add_post_columns( $my_columns ){ 
	array_splice($my_columns, 9);
	$my_columns=array_slice($my_columns,0,2,true)+array('anime'=>'Аниме')+array_slice($my_columns,2,NULL, true);
    return $my_columns; 
}
 

add_action( 'manage_posts_custom_column', 'add_anime_columns', 25 ); 
function add_anime_columns( $column ) {
 
	switch ( $column ) {
		case 'anime': {
			$anime_id = get_post_meta( get_the_ID(), '_anime_id', true );
			$animepost = get_post($anime_id);
		    echo '<a href="'.get_site_url().'/wp-admin/edit.php?post_type=catblock&anime_name='.$anime_id.'">'.$animepost->post_title.'</a>';			
			break;
		}
	} 
}

// добавляем возможность сортировать колонку
add_filter( 'manage_edit-catblock_sortable_columns', 'add_views_sortable_column' );
function add_views_sortable_column( $sortable_columns ){
	$sortable_columns['anime'] = [ 'anime-name', true ]; 
											   // false = asc (по умолчанию)
											   // true  = desc

	return $sortable_columns;
}

// Пишем обработчик сортировщика

add_action( 'pre_get_posts', 'true_orderby_anime' );
 
function true_orderby_anime( $query ) {
	if( ! is_admin() ) { return; }
 
	$orderby = $query->get( 'orderby');
 	if( $orderby == 'anime-name') { 
		$query->set( 'meta_key', '_anime_name' );  
		$query->set( 'orderby', 'meta_value' ); 
	}
	wp_reset_query(); 
} 


/* Фильтр постов по аниме */

add_action( 'pre_get_posts', 'add_event_anime_handler' );

function add_event_anime_handler( $query ) {

	$cs = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if( ! is_admin() || empty( $cs->post_type ) || $cs->post_type != 'catblock' || !isset($_GET['anime_name'])){
		return;
	}

	if( isset($_GET['anime_name'])&&($_GET['anime_name'] != -1 )){
		$selected_id = @ $_GET['anime_name'];
		$query->set( 'meta_query', [ 
			[ 
				'key' => '_anime_id', 
				'value' => $selected_id 
			] 
		] );
	}
	 wp_reset_query();
	  
}


// Добавление картинок к таксономиям
add_action('admin_init', 'add_images_to_taxonomies'); 
function add_images_to_taxonomies()
{
	\Vrabec\WP_Term_Image::init( [
		'taxonomies' => [ 'format', 'anime_tag', 'supernaturality', 'acting_in_story', 'acting_in_shot', 'position_in_shot', 'color', 'quantum','catname'],
	] );
}


// Создаём шорткод [showcatblock id='0/номер блока'
//                                anime='id аниме'
//                                show_anime=1/0 (показывать или не показывать аниме)
//                                show_name=1/0  (показывать или не показывать название блока)
//                                show_attrib=1/0 (показывать или не показывать аттрибуты)
//                                perrow= сколько в ряд
//                                paginate=1/0 (разбивать на страницы или нет)
//                                perpage=сколько на страницу
//                                sortby= по чему сортировать
//                                feature='format,
//                                         supernaturality, 
//                                         acting_in_story, 
//                                         acting_in_shot, 
//                                         position_in_shot, 
//                                         color, 
//                                         quantum,
//                                         catname'                                        
//                                value='номер в выбранной категории'
//                               

function create_catblock_shortcode($args)
{
	$params=shortcode_atts(
	                   array(
						   'id'=>'0',
						   'anime'=>'0',
						   'show_anime'=>'0',
						   'show_name'=>'1',
						   'perpage'=>'-1',
						   'show_attrib'=>'0',
						   'sortby'=>'meta_value',
						   'feature'=>'',
                           'value'=>'0',
						   'perrow'=>'1',
						  
						), $args);
	$params['id']=(int)$params['id'];
	$params['show_anime']=(int)$params['show_anime'];
	$params['perpage']=(int)$params['perpage'];	
	$params['show_name']=(int)$params['show_name'];
	$params['show_attrib']=(int)$params['show_attrib'];
	$params['perrow']=(int)$params['perrow'];
	$params['anime']=(int)$params['anime'];
	$params['value']=(int)$params['value'];
	

	// Это будет переменная, в которую мы будем записывать вывод на экран и которую будем возвращать
	$text_to_return='';


    //Это если вывести определённый блок 
	if ($params['id']!=0)
	{   $args=array(
	       'post_type'=>'catblock',
	       'include'=>$params['id']);
		    $allposts=get_posts($args);
	}
	else
{
     // Это если вывести подборку блоков
	$args=array(
		'post_type'=>'catblock',
		'posts_per_page'=>$params['perpage'],
		'orderby'     => $params['sortby'],
		'meta_key'    => '_block_id', 
	    'order'       => 'DESC'
		); 
   
	//Если указана характеристика feature='name'
	if ($params['feature']!='')
	{
		  $args['tax_query'] = array(
		             array(
			         'taxonomy' => $params['feature'],
			         'field'    => 'id',
		             'terms'    => $params['value'],
		                 )
	                   ); 
	  }
	
	if ($params['anime']!=0)
	{   
		$args['meta_query']=array(
		            array(
					'key'=>'_anime_id',
					'value'=>$params['anime']
					));
	}        
	
   $allposts=get_posts($args);

}

		if ($allposts)
		{   
          
			if ($params['id']!=0) 
            {
				
            //Вывод блока с номером id
            foreach( $allposts as $block )
			{
            $text_to_return.='<div class="container"><div class="row">';	
            $smallpic=get_the_post_thumbnail_url($block,'medium');
			$text_to_return.='<div class="col-md-4 block-medium-image">';		
			$text_to_return.='<a href="'.get_permalink($block).'"><img src="'.$smallpic.'"></a></div>';
            if ($params['show_name']!=0) $text_to_return.='<div class="col-md-8"><h2><a href="'.get_permalink($block).'">'.$block->post_title.'</a></h2>';
        	
			if (($params['anime']==0)||(params['anime']==1))
                {
                 $anime_id=$block->_anime_id;
                 $anime_post=get_post($anime_id);
                 $text_to_return.='<div class="block-anime-name"><h5><a href="'.get_permalink($anime_post).'">'.$anime_post->post_title.' ('.$anime_post->_year.')</a></h5></div>';
                 }
			$output =  apply_filters( 'the_content', $block->post_content ); 	
            $text_to_return.='<div class="block-content">'.$output.'</div>';
				
//                                         format,
//                                         supernaturality, 
//                                         acting_in_story, 
//                                         acting_in_shot, 
//                                         position_in_shot, 
//                                         color, 
//                                         quantum,
//                                         catname'  

             if ($params['show_attrib']!=0)
		 {		 
           
		    // Формат
            $formats=get_the_terms($block->ID, 'format');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Формат:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
			$text_to_return.='</div>';}
            			
		    // Сверъестественность 
			$formats=get_the_terms($block->ID, 'supernaturality');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Сверхъестественность:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            $text_to_return.='</div>';}
				 
            // Участие в сюжете 
			$formats=get_the_terms($block->ID, 'acting_in_story');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Участие в сюжете:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }
            $text_to_return.='</div>'; }

			// Действие в кадре 
			$formats=get_the_terms($block->ID, 'acting_in_shot');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Действие в кадре:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }            
            $text_to_return.='</div>';}
				
	        // Положение в кадре 
			$formats=get_the_terms($block->ID, 'position_in_shot');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Положение в кадре:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }            
            $text_to_return.='</div>';}	
			
			// Цвет/порода 
			$formats=get_the_terms($block->ID, 'color');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Цвет/порода:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }            
            $text_to_return.='</div>';}	
			
			// Количество 
			$formats=get_the_terms($block->ID, 'quantum');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Количество:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }            
            $text_to_return.='</div>';}	
				 
				// Кошачьи имена 
			$formats=get_the_terms($block->ID, 'catname');
            if( is_array( $formats ) ){
			$text_to_return.='<div><b>Зовут:</b>';	
	        foreach( $formats as $format ){
	    	$text_to_return.='<span class="block-term"><a href="'. get_term_link( $format->term_id, $format->taxonomy ) .'">'. $format->name .'</a></span><span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span>';
	           }            
            $text_to_return.='</div>';}		 
				 
	     	 } // if params['show_attribs'!=0]
				
			$text_to_return.='</div></div></div>';
				}  // foreach
               }  //Вывод блока с номером id

			else 
            {
                // По номеру аниме или все подряд
                // Вывод нескольких блоков
            if ($params['perrow']>1)
			{ //если несколько в ряд
			  switch ($params['perrow']) {
				  case 2:
					  $colmd='col-md-6';
					  break;
			      case 3:
					  $colmd='col-md-4';
					  break;
			      case 4:
					  $colmd='col-md-3';
					  break;
				  case 5:
				  case 6:
					  $params['perrow']=6;
					  $colmd='col-md-2';
					  break;
				  default:
					  $params['perrow']=1;
					  $colmd='col-md-12';			  
					}
				// В этом случае выводим блоки плиточкой
				
			  $text_to_return.='<div class="container anime"><div class="row">';	
			  $i=0;	 
				foreach($allposts as $block )
			     { $i++;
				   if (($i>$params['perrow'])&&($i%$params['perrow']==1))
				       { $text_to_return.='<div class="row">';}
				   $smallpic=get_the_post_thumbnail_url($block,'medium');
			       $text_to_return.='<div class="'.$colmd.'"><div class="block-medium-image">';		
			       $text_to_return.='<a href="'.get_permalink($block).'"><img src="'.$smallpic.'"></a></div>';
				    if ($params['show_name']!=0) $text_to_return.='<h4><a href="'.get_permalink($block).'">'.$block->post_title.'</a></h4>';
			       if ($params['show_anime']!=0)
                   {
                    $anime_post=get_post($block->_anime_id);
                    $text_to_return.='<div style="display: block; height: 80px;"><h5><a href="'.get_permalink($anime_post).'">'.$anime_post->post_title.' ('.$anime_post->_year.')</a></h5></div>';                 }
				  $text_to_return.='</div>';
				   if ($i%$params['perrow']==0) {$text_to_return.='</div>';}
				   }
			}
			else 
			{
			foreach($allposts as $block )
			{
            $text_to_return.='<div class="container anime"><div class="row">';	
            $smallpic=get_the_post_thumbnail_url($block,'medium');
			$text_to_return.='<div class="col-md-4 block-medium-image">';		
			$text_to_return.='<a href="'.get_permalink($block).'"><img src="'.$smallpic.'"></a></div>';
            $text_to_return.='<div class="col-md-8"><h2><a href="'.get_permalink($block).'">'.$block->post_title.'</a></h2>';
			$output =  apply_filters( 'the_content', $block->post_content ); 
			
        	if ($params['show_anime']!=0)
                {
                 $anime_post=get_post($block->_anime_id);
                 $text_to_return.='<div><h5><a href="'.get_permalink($anime_post).'">'.$anime_post->post_title.' ('.$anime_post->_year.')</a></h5></div>';                 }
		   $text_to_return.='<div>'.$output.'</div>';
			
			$text_to_return.='</div></div></div>';	
			} // foreach
			} // если по одному в ряд
			if ($params['paginate']!=0) $text_to_return.='<div><b>страницы</b></div>'.paginate_links( [
	                                 'base'    => user_trailingslashit( wp_normalize_path( get_permalink() .'/%#%/' ) ),
	                                 'current' => max( 1, get_query_var( 'page' ) ),
                                     'total'   => $allposts->max_num_pages ] );	
			} // по номеру аниме или все подряд
	  
		}	// if ($allposts)
	    wp_reset_query(); 
		return $text_to_return;
	}

add_shortcode('showcatblock', 'create_catblock_shortcode');

//Создаём шорткод [howmanyanime title="Заголовок"
//                              from ='yyyy-mm-dd'
//                              to='yyyy-mm-dd'
//                              month='mm'
//                              year='yyyy'
//                              ]
//  то есть можно вывести:
//  [howmanyanime] - напишет Аниме отсмотрено: 544
//  или
//  [howmanyanime month='4']   
//  или
//  [howmanyanime month='12' year='2022']                         
//Создаём шорткод [howmanyblocks]
function create_howmanyanime_shortcode($args)
{  
	$title=$args['title'];
	$month=(int)$args['month'];
	if ($args['year']!='') $year=(int)$args['year'];
	else {
		$today = getdate();
		$year=$today['year'];}
	if (!$title) $title='Аниме отсмотрено';
	 if($month!=0)
	 {$params = array(
	'post_type'   => 'anime', 
	'year'  => $year,
	'monthnum' => $month,	 
	'posts_per_page' => -1, 		 
	'orderby' =>'date',	
	'order' =>'DESC'	 
					
	
  ); 
	  $query = new WP_Query($params);
	  $text_to_return.='<div class="date-anime">';
       while($query->have_posts()) {
	    $query->the_post();
	    $text_to_return.='<a href="' . get_permalink() . '">' . get_the_title() . '</a> ';
		$post_id = get_the_ID(); 
		$catnum=has_cats($post_id);
        if ($catnum!=0)
        $text_to_return.='<span class="hascats" style="display: inline-block; margin-right: 5px;">(<i class="fa-solid fa-cat"></i>'.$catnum.')</span>'; 
 		else  $text_to_return.='(котиков нет)';
		 $text_to_return.='<span style="display: inline-block; margin-left: 5px; margin-right: 5px;"></span></span>';
          }
      
		$text_to_return.='</div>';
        wp_reset_postdata();}
	else
	{
	$my_posts = get_posts( array(
	'post_type'   => 'anime',
	'posts_per_page' => -1,
	'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
     ) );
		$nekoanime=0;
		foreach ($my_posts as $mypost)
			if (has_cats($mypost->ID)!=0)
				$nekonanime++;
     $text_to_return='<div class="allanime"><h4>'.$title.': '.$nekonanime.'</h4></div>';
	 wp_reset_query(); 
	}
	 return $text_to_return;
}


function create_howmanyblocks_shortcode($args)
{   $title=$args['title'];
	if (!$title) $title='Котиков поймано';
	
	$my_posts = get_posts( array(
	'post_type'   => 'catblock',
	'posts_per_page' => -1,
	'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
     ) );
     $text_to_return='<div class="allanime"><h4>'.$title.': '.sizeof($my_posts).'</h4></div>';
	 wp_reset_query(); 
	 return $text_to_return;
}
add_shortcode('howmanyanime', 'create_howmanyanime_shortcode');
add_shortcode('howmanyblocks', 'create_howmanyblocks_shortcode');

// Поскольку год у нас НЕ таксономия, то сделаем шаблон для вывода блоков по году через GET запрос
// 
add_action('init','sort_by_year');
function sort_by_year()
{
	if (isset($_GET['year']))
	{	
$year=$_GET['year'];	  
get_header();

echo '<div class="anime">';
echo '<header class="page-header alignwide">';
echo '<h1>'.$year.'</h1>';
echo '<p style="display: block; height: 20px;"></p>';
$animes = get_posts( array(
      	'meta_query' => array(
		         array(
		         	'key' => '_year',
                    'value' => $year, 			
                		)
                        	),
            	'post_type' => 'anime',
	            'posts_per_page' => -1,
            	'orderby' => 'title',
            	'order' => 'ASC',
           	) );


if ($animes)
{   echo '<div id="opener" onClick="JavaScript: document.getElementById(\'animelist\').style.display=\'block\';document.getElementById(\'opener\').style.display=\'none\';document.getElementById(\'closer\').style.display=\'block\';"><b><u>Открыть список аниме</u></b></div>
          <div id="closer" style="display: none" onClick="JavaScript: document.getElementById(\'animelist\').style.display=\'none\';document.getElementById(\'opener\').style.display=\'block\';document.getElementById(\'closer\').style.display=\'none\';"><b><u>Свернуть список аниме</u></b></div>
		  <div id="animelist" style="display: none;">'; 
	foreach ($animes as $title)
		echo '<h5><a href="#'.$title->post_name.'">'.$title->post_title.'</a></h5>';
    echo '</div>';
}
echo '</header>';
echo '<div>';
	if ($animes)
	{   echo '<div class="container">';
	    foreach ($animes as $anime)
		{   
			echo '<div id="'.$anime->post_name.'">';
			echo do_shortcode('[showcatblock id=0 anime="'.$anime->ID.'" show_anime=1]');	
			echo '</div>';
		   
		}
	 echo '</div></div>';
	}
	else echo '<h4>Тут ничего нет</h4>';

echo '</div>';		

wp_reset_postdata();
wp_footer(); 
echo '</div>';
get_footer();
	     exit;
	   }

}

// Создаём шорткод [showtaxonomy type=anime/catblock
//                               tax=director, studio, anime_original, anime_original_author, anime_tax, anime_tag,
//                                   format, supernaturality, acting_in_story, acting_in_shot, position_in_shot, 
//                                   color, quantum, catname
//                               term_id 
//                               

function create_taxonomy_shortcode($args)
{
	$params=shortcode_atts(
	                   array(
						   'type'=>'catblock',
						   'tax'=>'format',
						   'term_id'=>'0',
						), $args);
	$params['term_id']=(int)$params['term_id'];
	// Это будет переменная, в которую мы будем записывать вывод на экран и которую будем возвращать
	$text_to_return='';
	if ($params['type']=='anime')
	{
		// для анимешных таксономий
		// Шапка
		
		 $term=get_term($params['term_id'], $params['tax']);
		 $termtitle=$term->name;
		 $desc=$term->description;
		 $image_id = get_term_meta($params['term_id'], '_thumbnail_id', 1 );
         $image_url = wp_get_attachment_image_url( $image_id, 'full' );
		 $text_to_return.='<div class="anime">';
         $text_to_return.='<header class="page-header alignwide">';
         if ((isset($image_url))&&($image_url!=""))
           {
             $text_to_return.='<div class="row"><div class="col-md-3">';
             $text_to_return.='<img src="'. $image_url .'" alt="'.$termtitle.'"  style="max-width: 100%;" />';
             $text_to_return.='</div><div class="col-md-9"> <h1>'.$termtitle.'</h1>';
             $text_to_return.='<p>'.$desc.'</p>';
             $text_to_return.='</div></div>';
	           }
           else {
             	$text_to_return.='<h1>'.$termtitle.'</h1><p>'.$desc.'</p>';
                }
		
		 wp_reset_postdata();

         $text_to_return.='<p style="display: block; height: 20px;"></p>';
         $animes = get_posts( array(
	              'tax_query' => array(
	                	array(
	         		'taxonomy' => $params['tax'],
	        		'field'    => 'id',
	        		'terms'    => $params['term_id'],
			           		)
	                                 ),
	             'post_type' => 'anime',
	             'posts_per_page' => -1,
                 'orderby' => 'meta_value',
                 'meta_key'=>'_year',
                 'order' => 'DESC',
	            ) );
             // Раскрывающийся список аниме
              if ($animes)
            {
 $text_to_return.='<div id="opener" onClick="JavaScript:      document.getElementById(\'animelist\').style.display=\'block\';document.getElementById(\'opener\').style.display=\'none\';document.getElementById(\'closer\').style.display=\'block\';"><b><u>Открыть список аниме</u></b></div><div id="closer" style="display: none" onClick="JavaScript: document.getElementById(\'animelist\').style.display=\'none\';document.getElementById(\'opener\').style.display=\'block\';document.getElementById(\'closer\').style.display=\'none\';"><b><u>Свернуть список аниме</u></b></div>
		  <div id="animelist" style="display: none;">'; 	
	
	foreach ($animes as $title)
		 $text_to_return.='<h5><a href="#'.$title->post_name.'">'.$title->post_title.'('.$title->_year.')</a></h5>';
		 $text_to_return.='</div>';
          }
         $text_to_return.='</header>';
      // Вывод блоков
		if ($animes)
	    {
		$text_to_return.='<div class="container"><div class="row">';
	   	foreach ($animes as $anime)
		{   
			$text_to_return.='<div id="'.$anime->post_name.'">';
			$text_to_return.=do_shortcode('[showcatblock id=0 anime="'.$anime->ID.'" show_anime=1]');	
			$text_to_return.='</div>';
		   
		}
	  $text_to_return.='</div></div>';
	    }
	  else $text_to_return.='<h4>Тут нет ничего.</h4>';
      $text_to_return.='</div>';	
	}
    elseif ($params['type']=='catblock')
	{
		// для блоковых таксономий
		// Шапка	
		 
		 $term=get_term($params['term_id'], $params['tax']);
		 $termtitle=$term->name;
		 $desc=$term->description;
		 $image_id = get_term_meta($params['term_id'], '_thumbnail_id', 1 );
         $image_url = wp_get_attachment_image_url( $image_id, 'full' );
		 $text_to_return.='<div class="anime">';
         $text_to_return.='<header class="page-header alignwide">';
         if ((isset($image_url))&&($image_url!=""))
           {
             $text_to_return.='<div class="row"><div class="col-md-3">';
             $text_to_return.='<img src="'. $image_url .'" alt="'.$termtitle.'"  style="max-width: 100%;" />';
             $text_to_return.='</div><div class="col-md-9"> <h1>'.$termtitle.'</h1>';
             $text_to_return.='<p>'.$desc.'</p>';
             $text_to_return.='</div></div>';
	           }
           else {
             	$text_to_return.='<h1>'.$termtitle.'</h1><p>'.$desc.'</p>';
                }
		
		 wp_reset_postdata();
		// Блоки
		$blocks = get_posts( array(
	    'tax_query' => array(
		    array(
			   'taxonomy' => $params['tax'],
			   'field'    => 'id',
			   'terms'    => $params['term_id'],
			   )),
               'post_type' => 'catblock',
	           'posts_per_page' => -1,
			   'orderby'     => 'meta_value',
	           'meta_key'    => '_block_id', 
	           'order'       => 'DESC'
	          ) );
	          if ($blocks)
	       {   
			   // Список аниме
			  // $text_to_return.='список аниме';
			   $anime_array=array();
			   $anime_info=array();	
			 //  $text_to_return.='<!----АНИМЕХИ!\n';
		       foreach ($blocks as $catblock)
			   {  //$text_to_return.=$catblock->_anime_title.'/'.$catblock->_anime_name.'('.$catblock->_anime_year.')'; 
				if (!in_array($catblock->_anime_id, $anime_array))
				{
				  $anime_array[]=$catblock->_anime_id;
				  $blocks_array[]=$catblock->ID;				           	
				  $anime_info[]=array(
					         'anime_title'=>$catblock->_anime_title,
					         'anime_name'=>$catblock->_anime_name,
				             'anime_year'=>$catblock->_anime_year );
				}
			   }
			//	$text_to_return.='----------->';  
			   $text_to_return.='<div>';				
               $text_to_return.='<div id="opener" onClick="JavaScript:document.getElementById(\'animelist\').style.display=\'block\';document.getElementById(\'opener\').style.display=\'none\';document.getElementById(\'closer\').style.display=\'block\';"><b><u>Открыть список аниме</u></b></div><div id="closer" style="display: none" onClick="JavaScript:document.getElementById(\'animelist\').style.display=\'none\';document.getElementById(\'opener\').style.display=\'block\';document.getElementById(\'closer\').style.display=\'none\';"><b><u>Свернуть список аниме</u></b></div>
		  <div id="animelist" style="display: none;">';   
				  foreach ($anime_info as $anime)
					  $text_to_return.='<h5><a href="#'.$anime['anime_name'].'" >'.$anime['anime_title'].' ('.$anime['anime_year'].') </a></h5>';
				  $text_to_return.='</div>';					  
               $text_to_return.='</header>';			  
				  
			   $text_to_return.='<div class="container"><div class="row">';
	      	   foreach ($blocks as $catblock)
		        {  
				  if (in_array($catblock->ID, $blocks_array))
				  $text_to_return.='<a name="'.$catblock->_anime_name.'"></a>';	  
			      $text_to_return.=do_shortcode('[showcatblock id="'.$catblock->ID.'" ]');		
		   		       }
	           $text_to_return.= '</div></div>';
	       }
	       else $text_to_return.='<h4>Тут нет ничего</h4>';
           $text_to_return.= '</div>';		
           wp_reset_postdata();
	     }	
		return $text_to_return;
	}
add_shortcode('showtaxonomy', 'create_taxonomy_shortcode');

// Создаём шорткод [showanime per_page=-1
//                            year=0
//                            show_years=true/false
//                            show_alphabet=true/false] 
// 
//       

function create_showanime_shortcode($args)
{
	$params=shortcode_atts(
	                   array(
						   'per_page'=>-1,
						   'year'=>0,
						   'show_years'=>true,
						   'show_alphabet'=>true
						), $args);
	$params['per_page']=(int)$params['per_page'];
	$params['year']=(int)$params['year'];
    $params['show_years']=$params['show_years'];
    $params['show_alphabet']=$params['show_alphabet'];
        
	
    // Это будет переменная, в которую мы будем записывать вывод на экран и которую будем возвращать
	$text_to_return='';
	
	if ($params['year']==0)
	{ // а у нас пока других вариантов и не будет :D 
	 $animes = get_posts( array(
	             'post_type' => 'anime',
	             'posts_per_page' => $params['per_page'],
                 'orderby' => 'meta_value',
                 'meta_key'=>'_year',
                 'order' => 'ASC',
	            ) );
		if ($animes)
		{ 
			wp_reset_postdata();
			 $animes = get_posts( array(
	             'post_type' => 'anime',
	             'posts_per_page' => $params['per_page'],
                 'orderby' => 'title',
                 'order' => 'ASC',
	            ) );
			if ($params['show_alphabet']==true)
			{ //Вывод алфавита
				$letters=array();
				foreach ($animes as $anime)
			{  $catnum=has_cats($anime->ID);
				if(($catnum>0)&&(!in_array(mb_substr($anime->post_title, 0, 1),$letters)))
					$letters[]=mb_substr($anime->post_title, 0, 1);
					
				}
				$text_to_return.='<div style="margin: 0 20px; padding-bottom: 20px; text-align: center;">';
				foreach ($letters as $ltr)
					if ($ltr!='<')
				   $text_to_return.='<span class="alphabet"><a href="#'.$ltr.'">'.$ltr.'</a></span><i class="fa-solid fa-paw"></i>';	            $text_to_return.='</div>';
			}
			 // Если нужно вывести года
         if ($params['show_years']==true)
          {
			$years=array();
			$first_anime=array();
			 
			foreach ($animes as $anime)
			{
				if (!in_array($anime->_year, $years))
				{
					$years[]=$anime->_year;
					$first_anime[]=$anime->ID;
				}
			}
			$text_to_return.='<div>';
			sort ($years); 
			foreach ($years as $year)
			{
	$text_to_return.='<a href="'.get_site_url().'?year='.$year.'">'.$year.'</a> <span style="padding-left: 5px;"><i class="fa-solid fa-paw"></i></span> ';
			}
			$text_to_return.='</div>';
			$text_to_return.='<div style="display: block; height: 20px; border-bottom: 1px solid #000"></div>';
            }
			
	   // Выводим сами аниме
	   $curletter='';
	   $text_to_return.='<div>';
	   		
			foreach ($animes as $anime)
			{     $catnum=has_cats($anime->ID);
			      if ($curletter!=mb_strtoupper(mb_substr($anime->post_title, 0, 1, 'utf-8')))
				  {   $curletter=mb_strtoupper(mb_substr($anime->post_title, 0, 1, 'utf-8')); 
					  $text_to_return.='</div><div id="'.$curletter.'">';
				  }
                  $text_to_return.='<p style="margin: 5px 0;"><a href="'.get_permalink($anime).'">'.$anime->post_title.'</a>';
			  if ($catnum!=0)
                  $text_to_return.='<span class="hascats">(<i class="fa-solid fa-cat" style="display: inline-block; margin-right: 4px;"></i>'.$catnum.')</span>'; 
 			  else  $text_to_return.='(котиков нет)';
			  $text_to_return.='</p>';
			    
			}
			$text_to_return.='</div>';
		}
		
		
	}
return $text_to_return;
}

add_shortcode('showanime', 'create_showanime_shortcode');

// Создаём шорткод [showcontibutor id=0 
//                                 shownums='true'/'false'] 
//
// 
//       

function create_showcontibutor_shortcode($args)
{
	$params=shortcode_atts(
	                   array(
						   'id'=>0,
						   'shownums'=>'true'
						), $args);
	
	$params['id']=(int)$params['id'];
	$params['shownums']=$params['shownums'];
	$text_to_return='<div class="source">';
	if ($params['id']==0)
	{
		// а у нас других и нету :D
        $people_cats=get_terms('anime_contributer','orderby=name&hide_empty=0');
		if ($people_cats)
		{
		foreach ($people_cats as $otaku)	
		{
		$text_to_return.='<div class="otaku"><a href="'. get_term_link($otaku->term_id, $otaku->taxonomy).'">'.$otaku->name.'</a> ';	
		//$socials=get_term_meta($otaku->term_id, 'socials', true );		
       // if ($socials!='') $text_to_return.='<a href="'.$socials.'"><i class="fa fa-link"></i></a>';
		if ($params['shownums']=='true')
			{	
		     $text_to_return.=': ';
		     $animes = get_posts( array(
     	     'tax_query' => array(
		        array(
			  'taxonomy' => 'anime_contributer',
			  'field'    => 'id',
			  'terms'    => $otaku->term_id,			
		       )
	           ),
	        'post_type' => 'anime',
	         'posts_per_page' => -1,
	           ) );
	    if ($animes)
		{$allblocks_num=sizeof($animes);		
		$text_to_return.=''.$allblocks_num.'';	
		}
		}
			$text_to_return.='</div>';
				}	
		
	}
	$text_to_return.='</div>';
	}
	return $text_to_return;
}

add_shortcode('showcontibutor', 'create_showcontibutor_shortcode');

// Создаём шорткод [showsource id=0 ] 
// 
//       

function create_showsource_shortcode($args)
{
	$params=shortcode_atts(
	                   array(
						   'id'=>0,
						), $args);
	
	$params['id']=(int)$params['id'];
	$text_to_return='<div class="source">';
	if ($params['id']==0)
	{
	// а у нас других и нету :D
     $sources=get_terms('anime_source','orderby=name&hide_empty=0');
	 if ($sources)
	 {
	  foreach ($sources as $source)	
	{
	$text_to_return.='<span class="otaku"><a href="'. get_term_link($source->term_id, $source->taxonomy).'">'.$source->name.'</a> ';	$text_to_return.='</span><span style="padding: 0 5px 0 5px;"><i class="fa-solid fa-paw"></i></span>';
				}			
	}
	$text_to_return.='</div>';
	}
	return $text_to_return;
}

add_shortcode('showsource', 'create_showsource_shortcode');


/** ВЫВОДИМ ТЕКСТОВЫЙ РЕДАКТОР в редактировать категории **/
function html_category_description($container = ''){
$content = is_object($container) && isset($container->description) ? html_entity_decode($container->description) : '';
$editor_id = 'tag_description';
$settings = 'description';
?>
<tr class="form-field">
<th scope="row" valign="top"><label for="description">Описание</label></th>
<td><?php wp_editor($content, $editor_id, array(
'textarea_name' => $settings,
'wpautop'       => 0,	
'editor_css' => '<style>.html-active .wp-editor-area{border:0;}</style>',
)); ?><br />
<span class="description">Должно выводиться в отформатированном виде</span></td>
</tr>
<?php
}

remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );
add_filter( 'term_description', 'wpautop' );

/** редактор в полях - убираем старое поле редактирования **/
function remove_prev_category_description(){
global $mk_description;
if ( $mk_description->id == 'edit-category' or 'edit-tag' ){
?>
<script type="text/javascript">
jQuery(function($) {
$('textarea#description').closest('tr.form-field').remove();
});
</script>
<?php
}
}

add_action('admin_head', 'remove_prev_category_description');          
   
//add_filter('anime_tag_edit_form_fields', 'html_category_description'); 
//add_filter('anime_tax_edit_form_fields', 'html_category_description'); 
//add_filter('director_edit_form_fields', 'html_category_description'); 
//add_filter('anime_original_edit_form_fields', 'html_category_description'); 
//add_filter('anime_original_author_edit_form_fields', 'html_category_description');
//add_filter('anime_contributer_edit_form_fields', 'html_category_description');
//add_filter('anime_role_edit_form_fields', 'html_category_description'); 
//add_filter('anime_type_edit_form_fields', 'html_category_description'); 
//add_filter('studio_edit_form_fields', 'html_category_description');

//add_filter('color_edit_form_fields', 'html_category_description');
//add_filter('format_edit_form_fields', 'html_category_description');
//add_filter('position_in_shot_edit_form_fields', 'html_category_description');
//add_filter('supernaturality_edit_form_fields', 'html_category_description');
//add_filter('acting_in_shot_edit_form_fields', 'html_category_description'); 
//add_filter('acting_in_story_edit_form_fields', 'html_category_description'); 
//add_filter('catname_edit_form_fields', 'html_category_description'); 

/* Plugin Name: TinyMCE break instead of paragraph */
function mytheme_tinymce_settings( $tinymce_init_settings ) {
    $tinymce_init_settings['forced_root_block'] = false;
    return $tinymce_init_settings;
}
add_filter( 'tiny_mce_before_init', 'mytheme_tinymce_settings' );

remove_filter ( 'the_content', 'wpautop' );
add_filter ( 'the_content', 'add_newlines_to_post_content' );
function add_newlines_to_post_content( $content ) {
    return nl2br( $content );
}


// Создаём шорткод [animesearch per_page=-1
//                            year=0] 
// 
//       

function create_animesearch_shortcode()
{
$text_to_return='<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >';	
$text_to_return.='<span class="animesearch-label"><label for="s">Искать в названиях аниме:</label></span>';
$text_to_return.='<input type="text" value="" name="s" id="s" class="animesearch-field"/>';
$text_to_return.='<input type="hidden" value="anime" name="post_type" />';	
$text_to_return.='<input type="submit" id="searchsubmit" value="Искать"  class="animesearch-button"/>';
$text_to_return.='</form>';	
return $text_to_return;
}

add_shortcode('animesearch', 'create_animesearch_shortcode');

add_filter( 'posts_clauses', 'km_metadata_search' );

# Добавляем поиск по метаполям в базовый поиск WordPress
function km_metadata_search( $clauses ){
	global $wpdb;

	if( ! is_search() || ! is_main_query() || !isset($_GET['post_type']))
		return $clauses;

	$clauses['join'] .= " LEFT JOIN $wpdb->postmeta kmpm ON (ID = kmpm.post_id)";

	$clauses['where'] = preg_replace(
		"/OR +\( *$wpdb->posts.post_content +LIKE +('[^']+')/",
		"OR (kmpm.meta_value LIKE $1) $0",
		$clauses['where']
	);

	// если нужно искать в указанном метаполе
	//$clauses['where'] .= $wpdb->prepare(' AND kmpm.meta_key = %s', 'my_meta_key' );

	$clauses['distinct'] = 'DISTINCT';

	// дебаг итогового запроса
	0 && add_filter( 'posts_request', function( $sql ){   die( $sql );  } );

	return $clauses;
}


function create_complexsearch_shortcode()
{
$form = '<form role="search" method="get" class="complexsearch" id="searchform" action="' . home_url( '/' ) . '" >';

	// Формат кота
	$alltypes=get_terms('format');
	$form.= '<div class="section"><div class="row"><div class="col-md-3"><label for="format">Формат кота</label>
		                  <select name="format" id="format">';
	if (isset($_GET['format']))
	{
	   $char_term = get_term($_GET['format'], 'format');
       $form.= '<option value="'.$_GET['format'].'">'.$char_term ->name.'</option>';
	   $form.= '<option value="">Сбросить</option>';	
	}
	else
		$form.= '<option value=""> Выберите формат кота</option>';
	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();
	
	//Сверхъестественность
	$alltypes=get_terms('supernaturality');
	$form.= '<div class="col-md-3"><label for="supernaturality">Сверхъестественность</label>
		                  <select name="supernaturality" id="supernaturality">';
	if (isset($_GET['supernaturality']))
	{
	   $char_term = get_term($_GET['supernaturality'], 'supernaturality');
       $form.= '<option value="'.$_GET['supernaturality'].'">'.$char_term ->name.'</option>';
	   $form.= '<option value="">Сбросить</option>';	
	}
	else
		$form.= '<option value=""> Выберите сверхъестественность</option>';
	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();

	
	//Участие в сюжете
	$alltypes=get_terms('acting_in_story');
	$form.= '<div class="col-md-3"><label for="acting_in_story">Участие в сюжете</label>
		                  <select name="acting_in_story" id="acting_in_story">';
	if (isset($_GET['acting_in_story']))
	{
	   $char_term = get_term($_GET['acting_in_story'], 'acting_in_story');
       $form.= '<option value="'.$_GET['acting_in_story'].'">'.$char_term ->name.'</option>';
	   $form.= '<option value="">Сбросить</option>';		
	}
	else
		$form.= '<option value="">Выберите участие в сюжете</option>';	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();
	
	//Действие в кадре 
	$alltypes=get_terms('acting_in_shot');
	$form.= '<div class="col-md-3"><label for="acting_in_shot">Действие в кадре</label>
		                  <select name="acting_in_shot" id="acting_in_shot">';
	if (isset($_GET['acting_in_shot']))
	{
	   $char_term = get_term($_GET['acting_in_shot'], 'acting_in_shot');
       $form.= '<option value="'.$_GET['acting_in_shot'].'">'.$char_term ->name.'</option>';
	   $form.= '<option value="">Сбросить</option>';		
	}
	else
		$form.= '<option value="">Выберите действие в кадре</option>';	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();

    //Положение в кадре 
	$alltypes=get_terms('position_in_shot');
	$form.= '<div class="col-md-3"><label for="position_in_shot">Положение в кадре</label>
		                  <select name="position_in_shot" id="position_in_shot">';
	if (isset($_GET['position_in_shot']))
	{
	   $char_term = get_term($_GET['position_in_shot'], 'position_in_shot');
       $form.= '<option value="'.$_GET['position_in_shot'].'">'.$char_term ->name.'</option>';
	   $form.= '<option value="">Сбросить</option>';		
	}
	else
		$form.= '<option value="">Выберите положение в кадре</option>';	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();
	
	//Цвет/порода
	$alltypes=get_terms('color');
	$form.= '<div class="col-md-3"><label for="color">Цвет/порода</label>
		     <select name="color" id="color">';
	if (isset($_GET['color']))
	{
	   $char_term = get_term($_GET['color'], 'color');
       $form.= '<option value="'.$_GET['color'].'">'.$char_term ->name.'</option>';
       $form.= '<option value="">Сбросить</option>';		
	}
	else
		$form.= '<option value="">Выберите цвет/породу</option>';	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();
	
	//Колличество
	$alltypes=get_terms('quantum');
	$form.= '<div class="col-md-3"><label for="quantum">Количество кошек в кадре</label>
		     <select name="quantum" id="quantum">';
	if (isset($_GET['quantum']))
	{
	   $char_term = get_term($_GET['quantum'], 'quantum');
       $form.= '<option value="'.$_GET['quantum'].'">'.$char_term ->name.'</option>';
	   $form.= '<option value="">Сбросить</option>';	
	}
	else
		$form.= '<option value="">Выберите количество</option>';	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();
	
	//Кошачье имя
	$alltypes=get_terms('catname');
	$form.= '<div class="col-md-3"><label for="catname">Кошачье имя</label>
		     <select name="catname" id="catname">';
	if (isset($_GET['catname']))
	{
	   $char_term = get_term($_GET['catname'], 'catname');
       $form.= '<option value="'.$_GET['catname'].'">'.$char_term ->name.'</option>';
	   $form.= '<option value="">Сбросить</option>';	
	}
	else
		$form.= '<option value="">Выберите кошачье имя</option>';	
	if ((isset ($alltypes))&&(sizeof($alltypes)>0))
	foreach	($alltypes as $catblock)
	{$form.='<option value="'.$catblock->term_id.'">'.$catblock->name.'</option>'; 
	}
	$form.='</select></div>';
	wp_reset_query();
	
	$form.='<input type="hidden" id="s" name="s" value="" />';
	$form.='</div></div><input type="submit" id="searchsubmit" value="Искать" />
            </form>';
	return $form;	
}
add_shortcode('complexsearch', 'create_complexsearch_shortcode');

function has_cats($id)
{   $catnum=0;
	$args=array(
		'post_type'=>'catblock',
		'posts_per_page'=>'-1',
		'orderby'     => 'meta_value',
		'meta_key'    => '_block_id', 
	    'order'       => 'DESC'
		); 
   $args['meta_query']=array(
		            array(
					'key'=>'_anime_id',
					'value'=>$id
					));
  $allposts=get_posts($args);
  if ($allposts)
     $catnum=sizeof($allposts);
  
	return $catnum;
}
	
?>