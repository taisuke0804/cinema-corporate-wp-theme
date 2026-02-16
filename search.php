<?php
get_header();
?>

<main id="main" class="site-main">
  <section class="search-results">
    <div class="container">

      <header class="page-header">
        <h1 class="page-title">
          <!-- esc_html() でエスケープ処理 -->
          「<?php echo esc_html(get_search_query()); ?>」の検索結果
        </h1>

        <p class="page-subtitle">
          <?php echo esc_html($wp_query->found_posts); //投稿件数を取得 ?>件見つかりました
        </p>

        <div class="search-refine">
          <?php get_search_form(); ?>
        </div>
      </header>

      <div class="page-content">
        <?php if (have_posts()) : ?>
          <ul class="search-results__list">
            <?php while (have_posts()) : the_post(); ?>
              <li class="search-results__item">
                <article <?php post_class('search-result'); ?>>

                  <h2 class="search-result__title">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_title(); ?>
                    </a>
                  </h2>

                  <div class="search-result__meta">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                      <?php echo esc_html(get_the_date()); ?>
                    </time>
                    <span class="search-result__type">
                      <?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name ?? ''); ?>
                    </span>
                  </div>

                  <div class="search-result__excerpt">
                    <?php the_excerpt(); ?>
                  </div>

                </article>
              </li>
            <?php endwhile; ?>
          </ul>

          <nav class="pagination" aria-label="ページネーション">
            <?php
            the_posts_pagination([
              'mid_size'  => 1,
              'prev_text' => '前へ',
              'next_text' => '次へ',
            ]);
            ?>
          </nav>

        <?php else : ?>
          <div class="search-no-results">
            <h2>一致するページが見つかりませんでした</h2>
            <p>別のキーワードで検索するか、トップページから探してみてください。</p>

            <p class="back-home">
              <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
                トップページへ戻る
              </a>
            </p>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </section>
</main>

<?php
get_footer();
