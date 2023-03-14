<?php
if (have_posts()) :
  get_header(); ?>
  <div class="content-wrapper">
    <main class="main">

      <div class="content-wrap">
        <?php
        while (have_posts()) : the_post();
          $id = $post->ID;

        ?>

        <?php
        endwhile;
        ?>
      </div>

      <?php archive_pagination(); ?>

    </main>
  </div>
<?php
  get_footer();
endif;
wp_reset_postdata();
