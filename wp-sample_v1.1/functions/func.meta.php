<?php
$func_meta= new func_meta;
class func_meta{
	private	$meta = array(
		'default' => '',
		'front-page' => '',
		'archive' => array(
			'post' => '',
			'products' => '',
		),
		'singular' => array(
			'post' => '',
			'products' => '',
			'company' => '',
			'about' => '',
			'accessmap' => '',
			'form' => '',
			'policy' => '',
			'sitemap' => ''
		),
		'taxonomy' => array(
			'category' => ''
		)
	);

	private $keywords = '';

	public function echo_meta(){
		echo $this->get_description();
		echo $this->get_keywords();
	}

	private function get_description(){
		global $post;
		$ptype = $post->post_type;
		$pname = $post->post_name;

		$data = $this->meta;

		$d = $data['default'];
		if(is_front_page()): //フロントページの場合
		  $d = $data['front-page'];
		elseif(is_singular()): //単一ページの場合
		  if($ptype === 'products'):
				//製品の詳細ページ
		    $terms = get_the_terms($post->ID, 'products-category');
		    $term = '';
		    if(isset($terms[0]) && isset($terms[0]->name)):
		      $term = $terms[0]->name.' ';
		    endif;
				$title = $term.get_the_title();
				$d = str_replace('$title$', $title, $data['singular']['products']);
		  elseif($ptype === 'post'):
				//投稿の詳細ページ
				$d = isset($data['singular'][$ptype]) ? $data['singular'][$ptype] : $data['default'];
			else:
				//その他固定ページ投稿などの詳細ページ
		    $d = isset($data['singular'][$pname]) ? $data['singular'][$pname] : $data['default'];
		  endif;
		elseif(is_post_type_archive() ): //アーカイブページの場合
			$d = isset($data['archive'][$ptype]) ? $data['archive'][$ptype] : $data['default'];
		elseif(is_tax()): //タクソノミーアーカイブの場合
			$tax = get_query_var('taxonomy');
			$terms = get_the_terms($post->ID, $tax);
			$term = '';
			if(isset($terms[0]) && isset($terms[0]->name)):
				$term = str_replace('$', '', $terms[0]->name).' ';
			endif;
			$d = isset($data['taxonomy'][$tax]) ? str_replace('$term$', $term, $data['taxonomy'][$tax]) : $data['default'];
		elseif(is_search()): //検索結果ページの場合
		elseif(is_404()): //404ページの場合
		endif;

		echo '<meta name="description" content="'.$d.'" />';
	}

	private function get_keywords(){
		$k = $this->$keywords;
		echo '<meta name="keywords" content="'.$k.'" />';
	}
}
