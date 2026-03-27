<?php get_header(); ?>

<main class="service-single" id="main">

  <?php cinema_corporate_breadcrumb(); ?>

  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

      <article class="service-detail">
        <header class="service-detail-header">
          <h1><?php the_title(); ?></h1>
        </header>

        <div class="service-detail-content">
          <?php the_content(); ?>
        </div>
      </article>

    <?php endwhile; ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
