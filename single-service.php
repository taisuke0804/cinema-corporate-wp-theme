<?php get_header(); ?>

<main class="service-single">

  <?php cinema_corporate_breadcrumb(); ?>
  
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

      <article class="service-detail">
        <h1><?php the_title(); ?></h1>

        <div class="service-content">
          <?php the_content(); ?>
        </div>
      </article>

    <?php endwhile; ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
