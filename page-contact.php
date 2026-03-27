<?php
/**
 * Contact Page Template
 *
 * @package YourThemeName
 */

get_header();
?>

<main id="primary" class="contact-page">
  <div class="contact-page-container">

    <header class="page-header contact-page-header">
      <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="contact-content">
      <?php
      while (have_posts()) :
        the_post();
        the_content(); // ← ここに Contact Form 7 のショートコード
      endwhile;
      ?>
    </div>

  </div>
</main>

<?php get_footer(); ?>
