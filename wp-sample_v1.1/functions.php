<?php
$wp_functions = new WPfunctions;
class WPfunctions{
  private $includes = array(//インクルードするファイルの追記はこちら
    '/functions',
    '/templates',
  );

  function __construct(){
    //関連ファイルのインクルード
    $this->load_theme_functions($this->includes);

    /*
    * スタイルの設定
    */
    //エディターのスタイル
    add_editor_style(get_template_directory_uri() .'/admin/editor-style.css');
    //エディター直前にクラスを追加
    add_filter('tiny_mce_before_init', array($this, 'custom_editor_settings'));
    //管理画面の追加スタイル
    add_action('admin_enqueue_scripts', array($this, 'add_admin_style'));

    /*
    * サムネイルの設定
    */
    //サムネイルをサポートする
    add_action( 'after_setup_theme', array($this, 'custom_theme_setup'));
    //生成するサムネイルのサイズを設定
    $this->add_thumbnail_sizes();

    /*
    * 管理画面のメニュー設定
    */
    // 投稿画面から不要な機能を削除
    add_action( 'init', array($this, 'remove_post_supports'));
    // Authorアーカイブページを無効化
    add_action( 'template_redirect', array($this, 'theme_slug_redirect_author_archive'));
    //管理画面から不要メニューを取り除く
    add_action('admin_menu', array($this, 'remove_menus'));

    /*
    * 自動改行を有効にしないページの設定
    */
    add_action('wp_head', array($this, 'remove_wpautop'));
  }

  /*
  * スタイルの設定
  */
  //エディターのスタイル
  private function load_theme_functions(array $includes){
    $theme_path = get_template_directory();
    foreach($includes as $include){
      foreach(glob($theme_path.$include.'/*.php') as $file){
        require_once( $file );
      }
    }
  }

  //エディター直前にクラスを追加
  public function custom_editor_settings( $initArray ){
    $initArray['body_class'] = 'editor-area';
    return $initArray;
  }

  //管理画面の追加スタイル
  public function add_admin_style() {
    wp_enqueue_style( 'my_admin_css', get_template_directory_uri() . '/admin/admin-style.css');
  }

  /*
  * サムネイルの設定
  */
  //サムネイルをサポートする
  public function custom_theme_setup() {
    add_theme_support( 'post-thumbnails' );
  }

  //生成するサムネイルのサイズを設定
  public function add_thumbnail_sizes() {
    if ( function_exists( 'add_theme_support' ) ) {
      add_theme_support( 'post-thumbnails' );
      set_post_thumbnail_size( 150, 150 ); // 初期設定の投稿サムネイル値
    }

    if ( function_exists( 'add_image_size' ) ) {
      add_image_size( 'image_440x330', 440, 330 );
      add_image_size( 'image_250x188', 250, 188 );
      add_image_size( 'image_120x90', 120, 90 );
      add_image_size( 'image_182x182', 182, 182 );
      add_image_size( 'image_560x540', 560, 540 );
      add_image_size( 'image_298x298', 298, 298 );
      add_image_size( 'image_visual', 1000, 9999 );
    }
  }

  // 投稿画面から不要な機能を削除
  public function remove_post_supports() {
  //	remove_post_type_support( 'post', 'title' ); // タイトル
  //	remove_post_type_support( 'post', 'editor' ); // 本文欄
  //	remove_post_type_support( 'post', 'author' ); // 作成者
  	remove_post_type_support( 'post', 'thumbnail' ); // アイキャッチ
  	remove_post_type_support( 'post', 'excerpt' ); // 抜粋
  	remove_post_type_support( 'post', 'trackbacks' ); // トラックバック
  //	remove_post_type_support( 'post', 'custom-fields' ); // カスタムフィールド
  	remove_post_type_support( 'post', 'comments' ); // コメント
  	remove_post_type_support( 'post', 'revisions' ); // リビジョン
  //	remove_post_type_support( 'post', 'page-attributes' ); // ページ属性
  //	remove_post_type_support( 'post', 'post-formats' ); // 投稿フォーマット

  //	unregister_taxonomy_for_object_type( 'category', 'post' ); // カテゴリ
  	unregister_taxonomy_for_object_type( 'post_tag', 'post' ); // タグ
  }

  // Authorアーカイブページを無効化
  public function theme_slug_redirect_author_archive() {
      if (is_author() ) {
          wp_redirect( home_url());
          exit;
      }
  }

  //管理画面から不要メニューを取り除く
  public function remove_menus () {
      global $menu;
      //unset($menu[2]);  // ダッシュボード
      //unset($menu[4]);  // メニューの線1
      //unset($menu[5]);  // 投稿
      //unset($menu[10]); // メディア
      //unset($menu[15]); // リンク
      //unset($menu[20]); // ページ
      unset($menu[25]); // コメント
      //unset($menu[59]); // メニューの線2
      //unset($menu[60]); // テーマ
      //unset($menu[65]); // プラグイン
      //unset($menu[70]); // プロフィール
      //unset($menu[75]); // ツール
      //unset($menu[80]); // 設定
      //unset($menu[90]); // メニューの線3
  }

  public function remove_wpautop(){
    //固定ページは自動改行を有効にしない
    if (is_page()){
      // 本文
      remove_filter('the_content', 'wpautop');
      // 抜粋
      remove_filter('the_excerpt', 'wpautop');
    }
  }
}
