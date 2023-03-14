<?php
$func_mwf= new func_MWF;
class func_MWF{
	private $valis = array(
		/*1085 => array( //フォームID
			array(
				'name' => 'name-1', //項目名
				'validation' => 'noEmpty',	//バリデーションキー
				'settings' => array( 'message' => '文面' ) //エラー文
			),
		),*/
	);

	private $include_files = array(
		'class.exmail.php'
	);

	public function __construct(){
		if(!is_active_plugin('mw-wp-form/mw-wp-form.php')){
			return false;
		}

		//インクルード設定
		$include_path = '/functions/classes/mw-wp-form/';
		$theme_path = get_template_directory();
		foreach ($this->include_files as $include_file) {
			require_once($theme_path.$include_path.$include_file);
		}

		//バリデーション追加設定
		foreach ($this->valis as $key => $val) {
			if (!isset($val[0])) continue;

			add_filter('mwform_validation_mw-wp-form-'.$key, array($this, 'extend_validations'), 10, 3);
		}

		//バリデーションルール追加設定
		//メールのバリデーションを追加
		add_filter('mwform_validation_rules', array($this, 'extend_validation_rule_exmail'));
	}

	// 【MW MW Form】エラーメッセージをカスタマイズ
	public function extend_validations( $Validation, $data, $Data ) {
		//読み込まれてる固定ページのデータ呼びだし
		global $post;

		//本文のショートコードからフォームのIDを割り出す
    $pattern = '/[\s\S]*\[mwform_formkey key="(\d+)"\][\s\S]*/';
    $replacement = '$1';
    $id = preg_replace($pattern, $replacement, $post->post_content);

		if(!isset($this->valis[$id] )) return $Validation;

		foreach ($this->valis[$id] as $key => $v) {
			if(!isset($v['name'])) continue;
			if(!isset($v['validation'])) continue;
			if(!isset($v['settings'])) continue;

			$Validation->set_rule($v['name'], $v['validation'], $v['settings']);
		}
		return $Validation;
	}

	/* MW WP Form 自作バリデーション */
	//メールアドレス（精密）
	public function extend_validation_rule_exmail( $validation_rules ) {
		if ( ! class_exists("MW_WP_Form_Validation_Rule_Mail_Extended") ) {
			return $validation_rules;
		}
		$instance = new MW_WP_Form_Validation_Rule_Mail_Extended();
		$validation_rules[$instance->getName()] = $instance;
		return $validation_rules;
	}
}
