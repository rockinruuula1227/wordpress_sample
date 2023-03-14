<?php
$ptype = get_post_type();

if($ptype === 'post'):
  if (have_posts()):
    get_template_part('parts-loop/post');
    get_header();?>
      <div class="content-wrapper">
      <main class="main">

      <div class="content-wrap">
      <?php
      while (have_posts() ):the_post();
        $id = $post->ID;

        echo '
        <section class="news-box">
        <h4><span class="news-date">'.get_the_time('Y.m.d', $id).'</span></h4>
        <p class="news-text"><a href="'.get_the_permalink().'">'.get_the_title().'</a></p>
        </section>
        ';
      endwhile;
      ?>
      </div>

      <?php archive_pagination();?>

      </main>
      </div>
    <?php
    get_footer();
  endif;
  wp_reset_postdata();
else:
endif;
