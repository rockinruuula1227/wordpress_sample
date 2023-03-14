<?php
$func_mwf = new func_SCF;

class func_SCF
{
	/*
	入力例はREADME_func.smart-custom-fields.mdを確認してください
	*/
	private $scf_settings = array(
		/*
		'sch_prd_1' => array(
			'show' => array(
				'post' //カスタム投稿のslug
			),
			'title' => 'メタボックスのタイトル1',
			'groups' => array(
				'groups1'
			)
		),
		'sch_prd_2' => array(
			'show' => array(
				'post' //カスタム投稿のslug
			),
			'title' => 'メタボックスのタイトル2',
			'groups' => array(
				'groups2',
				'groups3'
			)
		),*/
		'added_options' => [
			'show' => [
				'added_options'
			],
			'title' => '',
			'groups' => [
				'added_option'
			]
		]
	);

	private $scf_groups = array(
		/*		'group1' => array(
			'repeat' => false,
			'values' => array(
				array(
					'name' => 'meta_slug',
					'label' => 'ラベル名',
					'type' => 'text',
				),
				array(
					'name' => 'meta_slug2',
					'label' => 'ラベル名2',
					'type' => 'text',
				),
			)
		),
		'group2' => array(
			'repeat' => false,
			'values' => array(
				array(
					'name' => 'meta_slug3',
					'label' => 'ラベル名3',
					'type' => 'text',
				),
			)
		),
		'group3' => array(
			'repeat' => false,
			'values' => array(
				array(
					'name' => 'meta_slug4',
					'label' => 'ラベル名4',
					'type' => 'text',
				),
			)
		),*/
		'added_option' => [
			'repeat' => false,
			'values' => [
				[
					'name' => 'added_option1',
					'label' => '追加のカスタムフィールド',
					'type' => 'text',
					'notes' => '設定についてはREADME_func.smart-custom-fields.mdを参照してください',
				],
			]
		]
	);

	public function __construct()
	{
		if (!is_active_plugin('smart-custom-fields/smart-custom-fields.php')) {
			return false;
		}

		add_filter('smart-cf-register-fields', array($this, 'new_scf_extension'), 10, 4);
		add_action('save_post', array($this, 'save_scf_extension'));

		return true;
	}

	/**
	 * カスタムフィールドの表示
	 *
	 * @param array $settings MW_WP_Form_Setting オブジェクトの配列
	 * @param string $type 投稿タイプ or ロール
	 * @param int $id 投稿ID or ユーザーID
	 * @param string $meta_type post | user
	 * @return array
	 */
	public function new_scf_extension($settings, $type, $id, $meta_type)
	{
		foreach ($this->scf_settings as $scf_id => $scf) {
			if (!isset($scf['show'])) {
				continue;
			}
			if (!isset($scf['title'])) {
				continue;
			}
			if (!isset($scf['groups'])) {
				continue;
			}

			// 表示条件
			if (!in_array($type, $scf['show'])) {
				continue;
			}

			// SCF::add_setting( 'ユニークなID', 'メタボックスのタイトル' );
			$Setting = SCF::add_setting($scf_id, $scf['title']);

			// $Setting->add_group( 'ユニークなID', 繰り返し可能か, カスタムフィールドの配列 );
			foreach ($scf['groups'] as $group) {
				if (!isset($this->scf_groups[$group])) {
					continue;
				}
				if (!isset($this->scf_groups[$group]['repeat'])) {
					continue;
				}
				if (!isset($this->scf_groups[$group]['values'])) {
					continue;
				}
				$Setting->add_group($group, $this->scf_groups[$group]['repeat'], $this->scf_groups[$group]['values']);
			}

			$settings[] = $Setting;
		}

		return $settings;
	}

	/**
	 * カスタムフィールドのDBへの保存
	 *
	 * @return void
	 */
	public function save_scf_extension()
	{
		foreach ($this->scf_settings as $scf_id => $scf) {
			if (!isset($scf['show'])) {
				continue;
			}
			if (!isset($scf['title'])) {
				continue;
			}
			if (!isset($scf['groups'])) {
				continue;
			}

			//フィールドの設定
			$save_setting = array();
			foreach ($scf['groups'] as $group) {
				if (!isset($this->scf_groups[$group])) {
					continue;
				}
				if (!isset($this->scf_groups[$group]['repeat'])) {
					continue;
				}
				if (!isset($this->scf_groups[$group]['values'])) {
					continue;
				}

				$save_setting[] = array(
					'group-name' => $group,
					'fields' => array_map(array($this, 'lf2crlf'), $this->scf_groups[$group]['values']),
					'repeat' => $this->scf_groups[$group]['repeat']
				);
			}

			//表示するページの設定
			$save_condition = $scf['show'];

			//CF保存用の投稿がない場合はinsertする
			$get_arg = array(
				'post_type' => 'scf-extension',
				'title' => $scf_id
			);
			$scf_posts = get_posts($get_arg);
			if (isset($scf_posts[0]) && isset($scf_posts[0]->ID)) {
				$insert_id = $scf_posts[0]->ID;
			} else {
				$insert_arg = array(
					'post_type' => 'scf-extension',
					'post_title' => $scf_id,
					'post_name' => $scf_id,
					'post_content' => '',
					'post_status' => 'publish'
				);
				$insert_id = wp_insert_post($insert_arg, true);
			}

			//設定データの保存
			delete_post_meta($insert_id, 'smart-cf-setting');
			delete_post_meta($insert_id, 'smart-cf-condition-post-ids');
			delete_post_meta($insert_id, 'smart-cf-condition');
			add_post_meta($insert_id, 'smart-cf-setting', $save_setting);
			add_post_meta($insert_id, 'smart-cf-condition-post-ids', null);
			add_post_meta($insert_id, 'smart-cf-condition', $save_condition);
		}
	}

	private function lf2crlf($array)
	{
		if (isset($array['choices'])) :
			$array['choices'] = preg_replace("/\n/", "\r\n", $array['choices']);
		endif;

		return $array;
	}
}
