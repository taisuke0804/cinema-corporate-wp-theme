<?php
/**
 * 404 Template
 */
get_header();
?>

<main id="main" class="site-main">
  <section class="error-404 not-found">
    <div class="container">
      <header class="page-header">
        <h1 class="page-title">ページが見つかりませんでした</h1>
      </header>

      <div class="page-content">
        <p>お探しのページは削除されたか、URLが変更された可能性があります。</p>

        <div class="error-actions">
          <p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
              トップページへ戻る
            </a>
          </p>
        </div>

        <div class="error-search">
          <h2 class="screen-reader-text">サイト内検索</h2>
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
