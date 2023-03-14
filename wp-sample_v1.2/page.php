<?php
if (have_posts()) :
  while (have_posts()) : the_post();
    $id = $post->ID;
    $site_uri = preg_replace(array("/^\//", "/\/$/"), array("", ""), str_replace($_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"], "", home_url()));
    $post_uri = preg_replace(array("/^\//", "/\/$/"), array("", ""), str_replace($site_uri, "", $_SERVER["REDIRECT_URL"]));

    $file_url1 = get_template_directory() . '/pages/' . $post_uri . '.php';
    $file_url2 = get_template_directory() . '/pages/' . $post_uri . '/index.php';

    if (get_the_content() === '' && file_exists($file_url1)) :
      get_template_part('pages/' . $post_uri);
    elseif (get_the_content() === '' && file_exists($file_url2)) :
      get_template_part('pages/' . $post_uri . '/index');
    else :
      get_header();
?>
      <div class="content-wrapper">
        <main class="main">

          <div class="content-wrap">
            <h3><?= get_the_title(); ?></h3>

            <section class="editor-content">
              <?php the_content(); ?>
            </section>

          </div>
        </main>
      </div>
<?php
      get_footer();
    endif;
  endwhile;
endif;
wp_reset_postdata();
