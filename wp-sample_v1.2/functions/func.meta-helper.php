<?php
class MetaHelper
{
  private $no_image = '/assets/img/common/img_no-image.jpg'; // no-image画像

  public function get_thumbnail($id)
  {
    $thumb = get_the_post_thumbnail_url($id, 'full');
    return $thumb && $thumb !== '' ? $thumb : $this->no_image;
  }

  public function get_array($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);

    return isset($args) ? $args : [];
  }

  public function get_number_array($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);
    $d = [];

    if (isset($args)) {
      foreach ($args as $key => $value) {
        $d[$key] = intval($value);
      }

      return $d;
    }

    return [];
  }

  public function get_content_array($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);
    $d = [];

    if (isset($args)) {
      foreach ($args as $key => $value) {
        $d[$key] = apply_filters('the_content', $value);
      }

      return $d;
    }

    return [];
  }

  public function get_image_array($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);
    $d = [];

    if (isset($args)) {
      foreach ($args as $key => $value) {
        $d[$key] = (wp_get_attachment_url($value, 'original')) ? wp_get_attachment_url($value, 'original') : '';
      }

      return $d;
    }

    return [];
  }

  public function get_string($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);

    return isset($args[0]) ? $args[0] : '';
  }

  public function get_brstring($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);

    return isset($args[0]) ? nl2br($args[0]) : '';
  }

  public function get_number($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);

    return isset($args[0]) ? intval($args[0]) : 0;
  }

  public function get_content($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);

    return isset($args[0]) ? apply_filters('the_content', $args[0]) : '';
  }

  public function get_image($id, $metakey)
  {
    $args = get_post_meta($id, $metakey);

    if (isset($args[0])) {
      $thumb = get_the_post_thumbnail_url($id, 'full');
      return $thumb && $thumb !== '' ? $thumb : $this->no_image;
    }

    return '';
  }

  public function get_term_list($id, $term_slug)
  {
    $terms = get_the_terms($id, $term_slug);
    return isset($terms[0]) ? $terms : [];
  }

  public function get_term_string($id, $metakey)
  {
    $args = get_term_meta($id, $metakey);

    return isset($args[0]) ? $args[0] : '';
  }

  public function get_term_image($id, $metakey)
  {
    $args = get_term_meta($id, $metakey);

    if (isset($args[0])) {
      $thumb = wp_get_attachment_url($args[0], 'original');
      return $thumb && $thumb !== '' ? $thumb : $this->no_image;
    }

    return $this->no_image;
  }

  public function get_option($d, $key)
  {
    return isset($d[$key][0]) ? $d[$key][0] : '';
  }

  public function get_option_br($d, $key)
  {
    return isset($d[$key][0]) ? nl2br($d[$key][0]) : '';
  }

  public function get_option_image($d, $key)
  {
    if (isset($d[$key][0])) {
      $thumb = wp_get_attachment_url($d[$key][0], 'original');
      return $thumb && $thumb !== '' ? $thumb : $this->no_image;
    }

    return '';
  }

  public function get_option_num($d, $key)
  {
    return isset($d[$key][0]) ? $d[$key][0] : 0;
  }

  public function get_option_number_array($d, $key)
  {
    $newd = [];

    if (isset($d[$key])) {
      foreach ($d[$key] as $key => $value) {
        $newd[$key] = intval($value);
      }

      return $newd;
    }

    return [];
  }

  public function get_post($post, $key)
  {
    return isset($post[$key]) ? $post[$key] : '';
  }

  public function get_post_num($post, $key)
  {
    return isset($post[$key]) ? $post[$key] : 0;
  }
}
