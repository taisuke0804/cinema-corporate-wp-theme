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

// meta description の動的出力
function cinema_meta_description() {
    if (is_front_page()) {
        echo '<meta name="description" content="中小企業向けコーポレートサイトを想定したWordPressオリジナルテーマです。">';
    } elseif (is_singular()) {
        global $post;
        // wp_strip_all_tags 文字列からHTMLタグを取り除く
        $excerpt = wp_strip_all_tags(get_the_excerpt($post));
        echo '<meta name="description" content="' . esc_attr($excerpt) . '">';
    }
}
add_action('wp_head', 'cinema_meta_description');

// OGP（SNS共有対策）
function cinema_ogp_tags() {
  if (is_singular()) {
      global $post;

      // image（アイキャッチ優先、なければデフォルト画像）
      $image = get_the_post_thumbnail_url($post, 'full');
      if (!$image) {
          $image = get_template_directory_uri() . '/assets/images/ogp-default.jpg';
      }

      echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">';
      echo '<meta property="og:description" content="' . esc_attr(get_the_excerpt()) . '">';
      echo '<meta property="og:image" content="' . esc_url($image) . '">';
      echo '<meta property="og:type" content="article">';
      echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">';
  }
}
add_action('wp_head', 'cinema_ogp_tags');

// canonical（正規URL）
function cinema_canonical_tag() {
  // 個別ページ（投稿 / 固定 / カスタム投稿）で canonical を出す
  if (is_singular()) {
    echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    return;
  }

  // トップページにも canonical を出す（任意だが推奨）
  if (is_front_page()) {
    echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '">' . "\n";
  }
}
add_action('wp_head', 'cinema_canonical_tag', 5);

// noindex 制御（検索エンジン除外）
function cinema_noindex_control() {
  // noindex → インデックスしない nofollow → リンク評価も渡さない
  // サンクスページ（例）
  if (is_page('thanks')) {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    return;
  }

  // 検索結果ページは基本 noindex 推奨
  if (is_search()) {
    echo '<meta name="robots" content="noindex, follow">' . "\n";
    return;
  }

  // 404ページはインデックス不要
  if (is_404()) {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    return;
  }
}
add_action('wp_head', 'cinema_noindex_control', 5);
