<?php

/**
 * Добавляем h3 для названия продуктов
 */
add_action('ocean_before_archive_product_title_inner', function(){
    echo '<h3>';
});
add_action('ocean_after_archive_product_title_inner', function(){
    echo '</h3>';
});

/**
 * Отключаем jQuery Migrate
 * @see https://wpcraft.ru/2019/otklyuchaem-soobshhenie-jqmigrate-migrate-is-installed-version-1-4-1/
 */
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});

/**
 * Remove header from blank page
 */
add_action('wp', function(){
  if(is_page_template('page-blank.php')){
    remove_action( 'ocean_page_header', 'oceanwp_page_header_template' );

    remove_action( 'ocean_before_primary', 'oceanwp_display_sidebar' );
    remove_action( 'ocean_after_primary', 'oceanwp_display_sidebar' );

  }
}, 30);

/**
 * Отключаем подзаголовок для страницы каталога
 */
add_filter('ocean_post_subheading', function($subheading){

    if(is_post_type_archive('product')){
        $subheading = '';
    }

    return $subheading;
});

/**
 * Подменяем заголовок для страницы каталога
 */
add_filter('ocean_title', function($title){

    if(is_post_type_archive('product')){
        $title = 'Каталог';
    }

    return $title;
});

/**
 * Подключение стиля родительской темы
 */
add_action( 'wp_enqueue_scripts', function(){
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'wpcraft-child', get_stylesheet_uri() );
} );

add_filter('body_class', function($classes){
  if(is_page_template('page-blank.php')){
    $classes[] = 'content-full-width';
  }
  return $classes;
});
