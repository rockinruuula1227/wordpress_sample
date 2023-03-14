<?php
/*
archive_pagination()
	通常のループでのアーカイブのページネーション呼びだし

query_pagination($the_query)
	WP Query使用時のアーカイブのページネーション呼びだし
	$the_query =  WP Query

single_pagination()
	投稿のページネーション呼びだし
*/

function query_pagination($the_query) {
	archive_pagination_original($the_query);
}

function archive_pagination() {
	global $wp_query;
	archive_pagination_original($wp_query);
}

function archive_pagination_original($the_query) {
	$big = 999999999; // need an unlikely integer
	$translated = __( 'Page', 'mytextdomain' ); // Supply translatable string
	$args = array(
		'base' => str_replace( 'page/'.$big.'/', '?paged=%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $the_query->max_num_pages,
		'prev_next' => false,
		'mid_size' => 5,
		'type' => 'list',
		'before_page_number' => ''
	);
	echo '<div class="pagination">'."\n";
	echo paginate_links($args)."\n";
	echo '</div>'."\n";
}

function single_pagination($taxonomy) {
		$is_taxonomy = false;
		if($taxonomy != '') $is_taxonomy = true;

		echo '<ul class="article__pagination">'."\n";
		echo previous_post_link('<li class="prev">%link</li>','&lt;&lt; 前のページ',$is_taxonomy,'',$taxonomy);
		echo next_post_link('<li class="next">%link</li>','次のページ &gt;&gt;',$is_taxonomy,'',$taxonomy);
		echo '</ul>'."\n";
}

function my_disable_redirect_canonical( $redirect_url ) {
    if ( is_page('news') || is_archive()){
      $subject = $redirect_url;
  		$pattern = '/\/page\//'; // URLに「/page/」があるかチェック
  		preg_match($pattern, $subject, $matches);

  		if ($matches){
  		//リクエストURLに「/page/」があれば、リダイレクトしない。
  		$redirect_url = false;
  		return $redirect_url;
  		}
    }
}
add_filter('redirect_canonical','my_disable_redirect_canonical');
