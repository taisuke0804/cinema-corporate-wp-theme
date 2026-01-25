<?php
/**
 * Cinema-Corporate theme functions
 */

// テーマ固有の機能を有効化
function cinema_corporate_setup() {
  add_theme_support('title-tag'); // <title> タグが自動的に <head> タグ内に挿入される
  add_theme_support('post-thumbnails'); // アイキャッチ画像を有効化
  add_theme_support('html5', [ // HTML5に準拠した形で出力されるようになる
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ]);
}
// テーマが読み込まれた直後に実行
add_action('after_setup_theme', 'cinema_corporate_setup');

function cinema_corporate_assets() {
  // CSS / JSの読み込み
  wp_enqueue_style(
    'cinema-corporate-style',
    get_stylesheet_uri(),
    [],
    '1.0'
  );
}
add_action('wp_enqueue_scripts', 'cinema_corporate_assets');

// カスタム投稿タイプの実装
function cinema_corporate_register_service() {
  register_post_type('service', [
    'label' => 'サービス',
    'public' => true,
    'has_archive' => true,
    'menu_position' => 5,
    'supports' => ['title', 'editor', 'thumbnail'], // 投稿できる項目
  ]);
}
add_action('init', 'cinema_corporate_register_service');

// パンくずリスト関数
function cinema_corporate_breadcrumb() {
  echo '<nav class="breadcrumb">';
  echo '<a href="' . home_url('/') . '">Home</a>';

  // Service 一覧ページ
  if (is_post_type_archive('service')) {
    echo ' &gt; Service';
  }

  // Service 詳細ページ
  if (is_singular('service')) {
    echo ' &gt; <a href="' . get_post_type_archive_link('service') . '">Service</a>';
    echo ' &gt; ' . get_the_title();
  }

  echo '</nav>';
}

// グローバルナビ
function cinema_corporate_register_menus() {
  register_nav_menus([
    'global' => 'グローバルナビ',
    'footer' => 'フッターメニュー',
  ]);
}
add_action('after_setup_theme', 'cinema_corporate_register_menus');

// フッターウィジェット
function cinema_corporate_register_sidebars() {
  register_sidebar([
    'name'          => 'フッター（左）',
    'id'            => 'footer-1',
    'description'   => 'フッター左カラム',
    'before_widget' => '<div class="footer-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-title">',
    'after_title'   => '</h3>',
  ]);

  register_sidebar([
    'name'          => 'フッター（中央）',
    'id'            => 'footer-2',
    'description'   => 'フッター中央カラム',
    'before_widget' => '<div class="footer-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-title">',
    'after_title'   => '</h3>',
  ]);

  register_sidebar([
    'name'          => 'フッター（右）',
    'id'            => 'footer-3',
    'description'   => 'フッター右カラム',
    'before_widget' => '<div class="footer-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-title">',
    'after_title'   => '</h3>',
  ]);
}
add_action('widgets_init', 'cinema_corporate_register_sidebars');
