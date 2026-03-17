<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); // body直後にフックを提供 ?>

<!-- スキップリンク -->
<a class="skip-link screen-reader-text" href="#main">本文へスキップ</a>

<header class="site-header">
  <div class="header-inner">

    <div class="site-branding">
      <p class="site-title">
        <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="ホームへ">
          <?php bloginfo('name'); ?>
        </a>
      </p>
    </div>

    <nav class="global-nav" aria-label="グローバルナビゲーション">
      <?php
      wp_nav_menu([
        'theme_location' => 'global',
        'container'      => false,
        'menu_class'     => 'global-nav-list',
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>
  </div>
</header>
