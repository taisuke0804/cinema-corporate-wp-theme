<?php get_header(); ?>

<main class="service-archive" id="main">

  <?php cinema_corporate_breadcrumb(); ?>

  <header class="archive-header">
    <h1>Service</h1>
    <p>提供しているサービス一覧</p>
  </header>

  <?php if (have_posts()) : ?>
    <ul class="service-list service-archive-list">
      <?php while (have_posts()) : the_post(); ?>
        <li class="service-item service-archive-item">
          <h2>
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </h2>

          <div class="service-content service-excerpt">
            <?php the_excerpt(); ?>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>

    <nav class="archive-pagination" aria-label="サービス一覧のページネーション">
      <?php
      echo paginate_links([
        'mid_size'  => 1,
        'prev_text' => '前へ',
        'next_text' => '次へ',
      ]);
      ?>
    </nav>
  <?php else : ?>
    <p class="service-empty-message">サービスは準備中です。</p>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
