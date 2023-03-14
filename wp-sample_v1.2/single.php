<?php
if (have_posts()) :
  get_header();

  while (have_posts()) : the_post();
    $id = $post->ID;
?>
    <div class="content-wrapper">
      <main class="main">

        <div class="content-wrap">
          <p class="news-date"><?= get_the_time('Y.m.d', $id); ?></p>
          <h3><?= get_the_title(); ?></h3>

          <section class="editor-content">
            <?php the_content(); ?>
          </section>

        </div>
      </main>
    </div>
<?php
  endwhile;
  get_footer();
endif;
wp_reset_postdata();
