<?php
$func_pt = new func_postType;
class func_postType
{
  private $pages = array(
    /* 入力例
    array(
      'post_type' => array(
        'slug' => 'products', //カスタム投稿のスラッグ
        'thumbnail-field'=>'thumbnail', //管理画面一覧で表示する画像 thumbnail もしくは カスタムフィールドのキー
        'args'=> array( //カスタム投稿タイプの設定args
          /*
           * 参考： https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_post_type
           * デフォルト：
           * 'public' => true,
           * 'exclude_from_search' => false,
           * 'show_ui' => true,
           * 'show_menu_ui' => true,
           * 'hierarchical' => false,
           * 'has_archive' => true,
           *
          'label' => '製品情報', //カスタム投稿名
          'supports' => array(
            //editorとtitleはデフォルトでtrue
            //thumbnailはthumbnail-fieldがthumbnailのときデフォルトでtrue
            //page-attributesはhierarchicalがtrueのときデフォルトでtrue
            'post-formats'
          ),
          'show_in_rest' => true, // ブロックエディタで使用するか
          //'rewrite' => array('slug' => 'med/products')
        ),
      ),
      'taxonomies' => array(
        array(
          'slug' =>'products-cat', //タクソノミーのスラッグ
          'args' => array( //カスタム投稿タイプの設定args
            /*
             * 参考： https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_taxonomy
             * デフォルト：
             * 'hierarchical' => true, //falseの場合はタグになる
             * 'show_ui' => true,
             * 'show_admin_column' => true,
             * 'update_count_callback' => '_update_post_term_count',
             * 'sort' => true
             *
            'show_in_rest' => true, // ブロックエディタで使用するか
            'label' =>'製品情報カテゴリ'
          )
        )
      )
    ),*/
    [
      'post_type' => [
        'slug' => 'custom-post',
        'args' => [
          'label' => '追加の投稿タイプ',
          'supports' => [
            'editor'
          ],
          'show_in_rest' => true,
        ]
      ],
      'taxonomies' => [
        [
          'slug' => 'custom-post_cat',
          'args' => [
            'label' => '追加の投稿タイプカテゴリ'
          ]
        ]
      ]
    ]
  );

  public function __construct()
  {
    add_action('init', array($this, 'new_post_type'), 1);
  }

  public function new_post_type()
  {
    foreach ($this->pages as $page) {
      if (!isset($page['post_type'])) continue;
      if (!isset($page['post_type']['args'])) continue;
      $args = $page['post_type']['args'];

      //slugは必須
      if (!isset($page['post_type']['slug']) || $page['post_type']['slug'] === '') continue;
      $ptype = $page['post_type']['slug'];

      //labelを設定していない場合はslugと同じ
      if (!isset($args['label']) || $args['label'] === '') $args['label'] = $ptype;

      //rewriteが設定されている場合はlabelではなくlabelsを設定
      if (isset($args['rewrite'])) {
        $label = $args['label'];
        unset($args['label']);
        $args['labels'] = array(
          'name' => __($label),
        );
      }

      /*
       * デフォルト設定
       */
      //デフォルトがfalse
      $def_false = array('exclude_from_search', 'hierarchical');
      foreach ($def_false as $key => $val) {
        if (!isset($args[$val]) || $args[$val] !== true) {
          $args[$val] = false;
        }
      }

      //デフォルトがtrue
      $def_true = array('public', 'show_ui', 'show_menu_ui', 'has_archive');
      foreach ($def_true as $key => $val) {
        if (!isset($args[$val]) || $args[$val] !== false) {
          $args[$val] = true;
        }
      }

      /*
       * supports
       */
      //titleはデフォルトでtrue
      $supports = array('title');
      //thumbnailはthumbnail-fieldがthumbnailのときデフォルトでtrue
      if (isset($page['post_type']['thumbnail-field']) && $page['post_type']['thumbnail-field'] === 'thumbnail') {
        $supports[] = 'thumbnail';
      }
      //page-attributesはhierarchicalがtrueのときデフォルトでtrue
      if (isset($args['hierarchical']) && $args['hierarchical'] === true) {
        $supports[] = 'page-attributes';
      }
      //あとはsupportsに設定されているものをつっこむ
      if (isset($args['supports'])) {
        foreach ($args['supports'] as $support) {
          $supports[] = $support;
        }
      }
      $args['supports'] = $supports;

      /*
       * カスタム投稿タイプ設定
       */
      register_post_type($ptype, $args);

      foreach ($page['taxonomies'] as $taxonomy) {
        if (!isset($taxonomy['args'])) continue;
        $taxargs = $taxonomy['args'];

        //slugは必須
        if (!isset($taxonomy['slug']) || $taxonomy['slug'] === '') continue;
        $taxtype = $taxonomy['slug'];

        //labelを設定していない場合はslugと同じ
        if (!isset($taxargs['label']) || $taxargs['label'] === '') $taxargs['label'] = $taxtype;

        /*
         * デフォルト設定
         */
        //デフォルトがtrue
        $def_true = array('hierarchical', 'show_ui', 'show_admin_column', 'sort');
        foreach ($def_true as $key => $val) {
          if (!isset($taxargs[$val]) || $taxargs[$val] !== false) {
            $taxargs[$val] = true;
          }
        }

        if (!isset($taxargs['update_count_callback'])) {
          $taxargs['update_count_callback'] = '_update_post_term_count';
        }

        /*
         * カスタムタクソノミー設定
         */
        register_taxonomy($taxtype, $ptype, $taxargs);
      }

      /*
       * 一覧でのサムネイル表示
       */
      add_filter('manage_' . $ptype . '_posts_columns', array($this, 'add_custom_column'));
      add_action('manage_' . $ptype . '_posts_custom_column', array($this, 'add_custom_column_id'), 10, 2);
    }
  }

  public function add_custom_column($defaults)
  {
    $url = $_SERVER['REQUEST_URI'];
    foreach ($this->pages as $page) {
      if (!isset($page['post_type']['slug']) || $page['post_type']['slug'] === '') continue;
      $ptype = $page['post_type']['slug'];

      if (!strstr($url, 'edit.php') || !(preg_match("/post_type=$ptype$/", $url) > 0)) continue;
      //管理画面かつptypeの時

      if (!isset($page['post_type']['thumbnail-field'])) continue;
      //thumbnail-fieldが存在する
      $thumb_field = $page['post_type']['thumbnail-field'];

      if ($thumb_field === 'thumbnail') :
        $defaults['thumbnail'] = 'サムネイル';
      else :
        $defaults[$thumb_field] = 'サムネイル';
      endif;
    }
    return $defaults;
  }

  public function add_custom_column_id($column_name, $id)
  {
    $url = $_SERVER['REQUEST_URI'];
    foreach ($this->pages as $page) {
      if (!isset($page['post_type']['slug']) || $page['post_type']['slug'] === '') continue;
      $ptype = $page['post_type']['slug'];

      if (!strstr($url, 'edit.php') || !strstr($url, 'post_type=' . $ptype)) continue;
      //管理画面かつptypeの時

      if (!isset($page['post_type']['thumbnail-field'])) continue;
      //thumbnail-fieldが存在する
      $thumb_field = $page['post_type']['thumbnail-field'];

      if ($column_name === 'thumbnail') :
        $thumb = get_the_post_thumbnail($id, array(100, 100), 'thumbnail');
        echo ($thumb && $thumb !== '') ? $thumb : '—';
      elseif ($column_name === $thumb_field) :
        $thumb_ids = get_post_meta($id, $thumb_field);

        if ($thumb_ids === NULL) {
          echo '—';
          continue;
        }
        if (!isset($thumb_ids[0])) {
          echo '—';
          continue;
        }
        if ($thumb_ids[0] === '') {
          echo '—';
          continue;
        }

        $lzb = function_exists('get_lzb_meta') ? get_lzb_meta($thumb_field, $id) : null;
        $thumb =  wp_get_attachment_image(isset($lzb['id']) ? $lzb['id'] : $thumb_ids[0], array(100, 100), 'thumbnail');

        echo ($thumb && $thumb !== '') ? $thumb : '—';
      endif;
    }
  }
}
