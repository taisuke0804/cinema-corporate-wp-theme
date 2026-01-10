<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
  <div class="header-inner">
    <h1 class="site-title">
      <a href="<?php echo home_url('/'); ?>">
        <?php bloginfo('name'); ?>
      </a>
    </h1>

    <nav class="global-nav">
      <?php
      wp_nav_menu([
        'theme_location' => 'global',
        'container' => false,
        'menu_class' => 'global-nav-list',
      ]);
      ?>
    </nav>
  </div>
</header>
