<?php
class CustomPost
{
  /**
   * 一覧用WP_Query
   *
   * @param
   * @return WP_Query
   */
  public function get_archive_query()
  {
    $args = [
      'posts_per_page' => -1,
      'post_type' => 'custom-post',
      'order' => 'ASC',
      'orderby' => 'menu_order',
      'post_status' => 'publish',
    ];

    return new WP_Query($args);
  }

  /**
   * 一覧用の投稿テンプレート
   *
   * @param number $id	//投稿id
   * @return null
   */
  public function echo_archive_template($id)
  {
    $d = $this->get_data($id);
    /*
     * 一覧用パーツのhtml出力など
     */
  }

  /**
   * カスタムフィールドの呼び出し・整形
   *
   * @param number $id	//投稿id
   * @return array $data
   */
  public function get_data($id)
  {
    $mh = new MetaHelper;
    $data = [
      'title' => get_the_title($id),
      'date' => get_the_date('Y.m.d'),
      'terms' => $mh->get_term_list($id, 'custom-post_cat'),
      'link' => get_the_permalink($id),
    ];

    return $data;
  }
}
