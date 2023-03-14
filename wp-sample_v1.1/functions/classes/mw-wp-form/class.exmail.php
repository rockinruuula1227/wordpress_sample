<?php
class MW_WP_Form_Validation_Rule_Mail_Extended extends MW_WP_Form_Abstract_Validation_Rule{

	/**
	 * Validation rule name
	 * @var string
	 */
	protected $name = 'exmail';

	/**
	* バリデーションチェック
	*
	* @param string $key name属性
	* @param array  $option
	* @return string エラーメッセージ
	*/
	public function rule( $name, array $options = array() ) {
		$value = $this->Data->get( $name );

		if ( MWF_Functions::is_empty( $value ) ) {
			return;
		}

		if ($value === ' ' || preg_match('/^[A-Za-z0-9._+-]+@[A-Za-z0-9_+-]+\.[A-Za-z.]+$/', $value ) ) {
			return;
		}

		$defaults = array(
			'message' => __( 'This is not the format of a mail address.', 'mw-wp-form' )
		);
		$options = array_merge( $defaults, $options );
		return $options['message'];
	}

	public function admin( $key, $value ) {
		?>
		<label><input type="checkbox" <?php checked( $value[ $this->getName() ], 1 ); ?> name="<?php echo MWF_Config::NAME; ?>[validation][<?php echo $key; ?>][<?php echo esc_attr( $this->getName() ); ?>]" value="1" /><?php esc_html_e( 'メールアドレス（より正確）', 'mw-wp-form' ); ?></label>
		<?php
	}
}
