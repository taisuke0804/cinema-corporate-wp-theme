<?php get_header(); ?>

<main id="primary" class="site-page sitemap-page">
  <div class="site-page-container">

    <header class="site-page-header">
      <h1 class="site-page-title"><?php the_title(); ?></h1>
    </header>

    <div class="site-page-content sitemap-content">

      <!-- 主要ページ -->
      <section class="sitemap-section">
        <h2>主要ページ</h2>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a></li>
          <li>
            <a href="<?php echo esc_url(get_post_type_archive_link('service')); ?>">
              サービス一覧
            </a>
          </li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
        </ul>
      </section>

      <!-- サポート -->
      <section class="sitemap-section">
        <h2>サポート</h2>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">プライバシーポリシー</a></li>
          <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>">サイトマップ</a></li>
        </ul>
      </section>

    </div>

  </div>
</main>

<?php get_footer(); ?>
