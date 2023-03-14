<?php
/**
* プラグインの有効化チェック
*
* @param string $path	プラグインのパス
* @return bool
*/
function is_active_plugin($path){
	$active_plugins = get_option('active_plugins');
	if(is_array($active_plugins)) {
		foreach($active_plugins as $value){
			if( $value == $path) return true;
		}
	}
	return false;
}

/**
 * nonceとリファラのチェック
 *
 * @param array $post 呼び出し元の$_POST
 * @param string $action_name アクションキー
 * @param string $nonce_name nonceキー
 * @return void
 */
function check_nonce($post, $action_name, $nonce_name)
{
	// nonceが不一致の場合はfalseを返却
	if (
		!isset($post[$nonce_name])
		|| !isset($post['_wp_http_referer'])
		|| !wp_verify_nonce($post[$nonce_name], $action_name)
		|| !strstr($_SERVER['HTTP_REFERER'], $post['_wp_http_referer'])
	) {

		return false;
	}
	return true;
}

/**
 * htmlspecialcharsの糖衣
 *
 * @param string $str 任意の文字列
 * @return string
 */
function hs($str)
{
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8', false);
}

/**
 * htmlspecialcharsの糖衣
 *
 * @param string $id 投稿ID
 * @return string $ids コールバック。初回呼び出しは空配列を入れる
 */
function get_the_parents_title_array($id, $ids) {
	$p = get_post($id);
	if ($p->post_parent > 0) {
		$ids = get_the_parents_title_array($p->post_parent, $ids);
	}
	$ids[] = $id;

	return $ids;
}
