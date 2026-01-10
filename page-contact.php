<?php
/**
 * Contact Page Template
 *
 * @package YourThemeName
 */

get_header();
?>

<main id="primary" class="site-main contact-page">
  <div class="container">
    <header class="page-header">
      <h1 class="page-title">
        <?php the_title(); ?>
      </h1>
    </header>

    <div class="page-content">
      <?php
      while (have_posts()) :
        the_post();
        the_content();
      endwhile;
      ?>
    </div>
  </div>
</main>

<?php
get_footer();
