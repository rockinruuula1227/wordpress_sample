<?php get_header(); ?>
<div class="content-wrapper">
  <main class="main in-404">

    <section class="content-wrap">
      <h4>お探しのページは見つかりませんでした</h4>

      <div>
        <p>移動もしくは削除されたためアクセスできないか、アドレスが間違っている可能性があります。<br>
          お手数ですが、以下の「ホーム」ボタンよりお探しください。</p>
      </div>

      <a href="<?= home_url() ?>">ホーム</a>
    </section>

  </main>
</div>

<?php get_footer(); ?>