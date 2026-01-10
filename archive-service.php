<?php get_header(); ?>

<main class="service-archive">

  <?php cinema_corporate_breadcrumb(); ?>
  
  <header class="archive-header">
    <h1>Service</h1>
    <p>提供しているサービス一覧</p>
  </header>

  <?php if (have_posts()) : ?>
    <ul class="service-archive-list">

      <?php while (have_posts()) : the_post(); ?>
        <li class="service-archive-item">
          <h2>
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </h2>

          <div class="service-excerpt">
            <?php the_excerpt(); ?>
          </div>
        </li>
      <?php endwhile; ?>

    </ul>
  <?php else : ?>
    <p>サービスは準備中です。</p>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
