<?php
//メソッド内のコメント内はあくまで凡例です
class single {
  /**
   * ループ呼び出し
   *
   * @param void
   * @return void
   */
  public function echo_loops(){
    /*
      $few_arg = array(
        'タイトル'=>array('WP_Query設定用配列'),
        'タイトル'=>array('WP_Query設定用配列'),
        'タイトル'=>array('WP_Query設定用配列')
      );

      foreach ($few_arg as $title => $args) {
        echo '
          <section>
            <h2>'.$title.'</h2>
            '.$this->make_loop_from_query($args).'
          <section>';
      }
    */
  }

  /**
   * ループからhtmlを生成
   *
   * @param array $args	//WP_Queryの設定用配列
   * @return string $string
   */
  public function make_loop_from_query($args){
    /*
      $the_query = new WP_Query( $args );

      $s = '';
    	if ( $the_query->have_posts() ) :
    		while ( $the_query->have_posts() ) : $the_query->the_post();
          $id = $the_query->post->ID;
          $d = $this->get_data($id);

          $blank = $d['url_obj']['is_blank']? ' target="_blank"' : '';
          $s = $s.'
            <article>
              <h3><a href="'.$d['url_obj'].'"'.$blank.'>'.$d['title'].'</a></h3>
              <section>
                <div>'.$d['content'].'</div>
                <p>'.$d['field1'].'</p>
              </section>
            </article>';
        endwhile;
      endif;

      return $s;
    */
  }

  /**
   * カスタムフィールドの呼び出し・整形
   *
   * @param number $id	//投稿id
   * @return array $data
   */
  public function get_data($id){
    /*
      $data = array(
        'title' => '',
        'thumb' => '',
        'content' => '',
        'field1' => '',
        'field2 => array(
          'a' => '',
          'b' => ''
        ),
        'url_obj' => array()
      );

      $data['title'] = get_the_title($id);

      $content = get_the_content($id);
      $data['content'] = apply_filters('the_content', $content);

      $field1 = get_post_meta($id, 'field1');
      $data['field1'] = $field1[0];

      $data['url_obj'] = $this->get_url_obj($id);

      return $data;
    */
  }
}
