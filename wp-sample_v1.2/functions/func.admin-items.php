<?php
$func_adminitems = new FuncAdminItems;
class FuncAdminItems
{
  public function __construct()
  {
    if (!is_active_plugin('smart-custom-fields/smart-custom-fields.php')) {
      return false;
    }

    SCF::add_options_page('追加の設定ページ', '追加の設定ページ', 'manage_options', 'added_options');
  }
}
