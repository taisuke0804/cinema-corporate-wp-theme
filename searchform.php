<?php
/**
 * Search Form Template
 */
?>

<form role="search"
      method="get"
      class="search-form"
      action="<?php echo esc_url(home_url('/')); ?>">

  <label class="search-form__label">
    <span class="screen-reader-text">
      <?php echo esc_html_x('検索:', 'label', 'cinema-corporate'); ?>
    </span>

    <input type="search"
           class="search-form__field"
           placeholder="キーワードを入力"
           value="<?php echo get_search_query(); ?>"
           name="s"
           required />
  </label>

  <button type="submit" class="search-form__submit">
    検索
  </button>

</form>
