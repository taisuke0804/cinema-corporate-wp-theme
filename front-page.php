<?php get_header(); ?>

<main class="front-page" id="main">
  <section class="hero">
    <h1>Cinema-Corporate</h1>
    <p>映像 × テクノロジーで価値を創造する</p>
  </section>

  <section class="about">
    <h2>About</h2>
    <p>
      Cinema-Corporateは、中小企業向けに
      映像とWeb技術を融合したソリューションを提供します。
    </p>
  </section>

  <section class="service">
    <h2>Service</h2>

    <?php
    $service_query = new WP_Query([
      'post_type'      => 'service',
      'posts_per_page' => 3,
    ]);
    ?>

    <?php if ($service_query->have_posts()) : ?>
      <ul class="service-list">
        <?php while ($service_query->have_posts()) : $service_query->the_post(); ?>
          <li class="service-item">
            <h3>
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h3>
            <div class="service-content">
              <?php the_excerpt(); ?>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>

      <div class="service-more">
        <a
          class="service-more-link"
          href="<?php echo esc_url(get_post_type_archive_link('service')); ?>"
        >
          Service一覧を見る
        </a>
      </div>
      
    <?php else : ?>
      <p>サービス情報は準備中です。</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
  </section>

</main>

<?php get_footer(); ?>
