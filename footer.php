<footer class="site-footer" role="contentinfo">
  <div class="footer-inner">
    <div class="footer-grid">

      <section class="footer-block" aria-label="フッター（左）">
        <?php if (is_active_sidebar('footer-1')) : ?>
          <?php dynamic_sidebar('footer-1'); ?>
        <?php endif; ?>
      </section>

      <section class="footer-block" aria-label="フッター（中央）">
        <?php if (is_active_sidebar('footer-2')) : ?>
          <?php dynamic_sidebar('footer-2'); ?>
        <?php endif; ?>
      </section>

      <section class="footer-block" aria-label="フッター（右）">
        <?php if (is_active_sidebar('footer-3')) : ?>
          <?php dynamic_sidebar('footer-3'); ?>
        <?php endif; ?>
      </section>

    </div>

    <div class="footer-bottom">
      <p class="footer-copyright">
        &copy; <?php echo esc_html(date('Y')); ?>
        <?php echo esc_html(get_bloginfo('name')); ?>
        <?php echo esc_html(get_theme_mod('cinema_corporate_footer_copyright', 'All Rights Reserved.')); ?>
      </p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
