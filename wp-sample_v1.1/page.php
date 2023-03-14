<?php
if(have_posts()):
  get_header();

  while(have_posts()):the_post();
    $id = $post->ID;

    $file_url = get_template_directory().'/static/'.$post->post_name.'.php';
    if(file_exists($file_url)):
      get_template_part('static/'.$post->post_name);
    else:?>
      <div class="content-wrapper">
      <main class="main">

      <div class="content-wrap">
      <h3><?=get_the_title();?></h3>

      <section>
      <?php the_content();?>
      </section>

      </div>
      </main>
      </div>
    <?php
    endif;
  endwhile;
  get_footer();
endif;
wp_reset_postdata();
