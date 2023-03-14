<?php
$func_title= new func_title;
class func_title{
	private $site_name = '';
	private $page_name = array(
		'default' => '',
		'front-page' => '',
		'archive' => array(
		),
		'singular' => array(
			'policy' => '',
			'sitemap' => ''
		),
		'taxonomy' => array( //$term$を使うとタームにリプレイスされます。
			'category' => ''
		)
	);

	public function __construct(){
		add_theme_support( 'title-tag' );
		add_filter( 'pre_get_document_title', array($this, 'get_title'));
	}

	public function get_title($title){
		global $post;
		$ptype = $post->post_type;
		$pname = $post->post_name;

		$s = $this->site_name;
		$p = $this->page_name;

		$t = $p['default'];
	  if(is_front_page()): //フロントページの場合
	    $t = $p['front-page'];
	  elseif(is_singular()): //単一ページの場合
			if($ptype === 'products'):
				//製品の詳細ページ
				$terms = get_the_terms($post->ID, 'products-category');
				$term = '';
				if(isset($terms[0]) && isset($terms[0]->name)):
					$term = $terms[0]->name.' ';
				endif;
				$t = $term.get_the_title();
			elseif($ptype === 'post'):
				//投稿の詳細ページ
				$t = isset($p['singular'][$ptype]) ? $p['singular'][$ptype] : get_the_title();
			else:
				//その他固定ページ投稿などの詳細ページ
				$t = isset($p['singular'][$pname]) ? $p['singular'][$pname] : get_the_title();
			endif;
		elseif(is_post_type_archive() ): //アーカイブページの場合
			$ptype = $post->post_type;
			$t = isset($data['archive'][$ptype]) ? $data['archive'][$ptype] : post_type_archive_title('',false);
		elseif(is_tax()): //タクソノミーアーカイブの場合
			$tax = get_query_var('taxonomy');
			$terms = get_the_terms($post->ID, $tax);
			$term = '';
			if(isset($terms[0]) && isset($terms[0]->name)):
				$term = $terms[0]->name.' ';
			endif;
			$t = isset($data['taxonomy'][$tax]) ? str_replace('$term$', $term, $data['taxonomy'][$tax]) : single_term_title('', false );
	  elseif(is_search()): //検索結果ページの場合
	    $t = $title;
	  elseif(is_404()): //404ページの場合
	    $t = '404 PAGE NOT FOUND';
	  endif;
		$title = $t.'｜'.$s;

	  return $title;
	}
}
