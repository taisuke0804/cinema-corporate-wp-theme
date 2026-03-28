<?php get_header(); ?>

<main id="primary" class="site-page">
  <div class="site-page-container">

    <header class="site-page-header">
      <h1 class="site-page-title"><?php the_title(); ?></h1>
    </header>

    <div class="site-page-content">
      <?php
      while (have_posts()) :
        the_post();
        the_content();
      endwhile;
      ?>
    </div>

  </div>
</main>

<?php get_footer(); ?>
