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

// パンくずデータを配列で返す
function cinema_corporate_get_breadcrumb_items(): array {
  $items = [];

  // 1. Home
  $items[] = [
    'name' => 'Home',
    'url'  => home_url('/'),
  ];

  /**
   * Service 一覧（アーカイブ）
   * Home > Service
   */
  if (is_post_type_archive('service')) {
    $items[] = [
      'name' => 'Service',
      'url'  => '', // 現在地なのでリンク不要（表示側で判定）
    ];

    // 現状は Service のみ対応。対象外は Home のみ返す。
    return $items;
  }

  /**
   * Service 詳細（シングル）
   * Home > Service（アーカイブリンク） > タイトル
   */
  if (is_singular('service')) {
    $items[] = [
      'name' => 'Service',
      'url'  => get_post_type_archive_link('service'),
    ];

    $items[] = [
      'name' => get_the_title(),
      'url'  => '', // 現在地
    ];

    return $items;
  }

  // 固定ページ
  if (is_page()) {
    $items[] = [
      'name' => get_the_title(),
      'url'  => '',
    ];

    return $items;
  }

  return $items;
}

// パンくず表示（配列から描画）
function cinema_corporate_breadcrumb(): void {
  $items = cinema_corporate_get_breadcrumb_items();

  // Home しかない場合
  if (count($items) <= 1) {
    return;
  }

  echo '<nav class="breadcrumb" aria-label="breadcrumb">';
  echo '<ol class="breadcrumb-list">';

  $last_index = count($items) - 1;

  foreach ($items as $index => $item) {
    $name = isset($item['name']) ? esc_html($item['name']) : '';
    $url  = isset($item['url']) ? esc_url($item['url']) : '';
    $is_current = ($index === $last_index || empty($url));

    $item_class = 'breadcrumb-item';
    if ($is_current) {
      $item_class .= ' is-current';
    }

    echo '<li class="' . esc_attr($item_class) . '">';

    if ($is_current) {
      echo '<span class="breadcrumb-current" aria-current="page">' . $name . '</span>';
    } else {
      echo '<a class="breadcrumb-link" href="' . $url . '">' . $name . '</a>';
    }

    echo '</li>';
  }

  echo '</ol>';
  echo '</nav>';
}

/**
 * パンくず配列を BreadcrumbList 用の構造化データ配列に変換する
 */
function cinema_corporate_get_breadcrumb_schema_data(): array {
  $items = cinema_corporate_get_breadcrumb_items();

  // Homeしかない場合は構造化データを作らない
  if (count($items) <= 1) {
    return [];
  }

  $item_list_elements = [];

  foreach ($items as $index => $item) {
    $list_item = [
      '@type'    => 'ListItem',
      'position' => $index + 1,
      'name'     => $item['name'],
    ];

    // URLがある場合のみ item を付与
    if (!empty($item['url'])) {
      $list_item['item'] = $item['url'];
    }

    $item_list_elements[] = $list_item;
  }

  return [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => $item_list_elements,
  ];
}

/**
 * パンくずの構造化データを JSON-LD 文字列で返す
 */
function cinema_corporate_get_breadcrumb_schema_json(): string {
  $schema_data = cinema_corporate_get_breadcrumb_schema_data();

  if (empty($schema_data)) {
    return '';
  }

  return wp_json_encode(
    $schema_data,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
  );
}

/**
 * パンくずの構造化データ(JSON-LD)を head 内に出力する
 */
function cinema_corporate_output_breadcrumb_schema(): void {
  // 現段階では Service 一覧 / Service 詳細のみ出力
  if (!is_post_type_archive('service') && !is_singular('service') && !is_page()) {
    return;
  }

  $schema_json = cinema_corporate_get_breadcrumb_schema_json();

  if (empty($schema_json)) {
    return;
  }

  echo '<script type="application/ld+json">' . "\n";
  echo $schema_json . "\n";
  echo '</script>' . "\n";
}
add_action('wp_head', 'cinema_corporate_output_breadcrumb_schema');

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

// canonical（トップページのみ補完）
function cinema_front_canonical_tag() {
  if (is_front_page()) {
    echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '">' . "\n";
  }
}
add_action('wp_head', 'cinema_front_canonical_tag', 5);


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
