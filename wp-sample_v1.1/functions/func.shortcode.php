<?php
$func_sc= new func_shortcode;
class func_shortcode{
  public function __construct(){
    //home_url()を呼び出す
    add_shortcode('home_url', 'Include_homelink');

    //get_template_directory_uri()を呼び出す
    add_shortcode('temp_uri', 'Include_templink');
  }

  public function Include_homelink($params = array()) {
    extract(shortcode_atts(array(
    ), $params));

    return home_url();
  }

  public function Include_templink($params = array()) {
    extract(shortcode_atts(array(
    ), $params));

    return get_template_directory_uri();
  }
}
?>
