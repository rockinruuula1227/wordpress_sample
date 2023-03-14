<?php
class FormHelper
{
  private $post;
  private $error;

  function __construct($p, $e)
  {
    $this->post = $p;
    $this->error = $e;
  }

  public function input_text($key, $ph = '', $auto_complete = '', $class_name = '')
  {?>
    <input type="text" class="c-input -text<?= $class_name !== '' ? ' ' . $class_name : '' ?><?= $this->cl($key) ?>" id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->v($key) ?>" placeholder="<?= $ph ?>" <?= $auto_complete !== '' ? 'autocomplete="' . $auto_complete . '"' : '' ?>>
    <?= $this->e($key) ?>
  <?php
  }

  public function input_email($key, $ph = '', $class_name = '')
  {?>
    <input type="email" class="c-input -email<?= $class_name !== '' ? ' ' . $class_name : '' ?><?= $this->cl($key) ?>" id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->v($key) ?>" placeholder="<?= $ph ?>" inputmode="url" autocomplete="email">
    <?= $this->e($key) ?>
  <?php
  }

  public function input_tel($key, $ph = '', $class_name = '')
  {?>
    <input type="tel" class="c-input -tel<?= $class_name !== '' ? ' ' . $class_name : '' ?><?= $this->cl($key) ?>" id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->v($key) ?>" placeholder="<?= $ph ?>" maxlength="13" minlength="10" autocomplete="tel">
    <?= $this->e($key) ?>
  <?php
  }

  public function input_postalcode($key, $ph = '', $class_name = '')
  {?>
    <input type="text" class="c-input -postal<?= $class_name !== '' ? ' ' . $class_name : '' ?><?= $this->cl($key) ?>" id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->v($key) ?>" placeholder="<?= $ph ?>" maxlength="8" minlength="7" autocomplete="postal-code" inputmode="tel">
    <?= $this->e($key) ?>
  <?php
  }

  public function input_textarea($key, $ph = '', $class_name = '')
  {?>
    <textarea class="c-input -textarea<?= $class_name !== '' ? ' ' . $class_name : '' ?><?= $this->cl($key) ?>" id="<?= $key ?>" name="<?= $key ?>" placeholder="<?= $ph ?>" rows="3"><?= $this->v($key) ?></textarea>
    <?= $this->e($key) ?>
  <?php
  }

  public function input_radio($key, $define, $default = '', $class_name = '')
  {?>
    <div class="c-input -radio<?= $this->cl($key) ?>">
      <?php foreach ($define as $i => $value) : ?>
        <?php
        $checked = '';
        if ($this->v($key) === '' && $default === '' && $i === 0) $checked = 'checked';
        if ($this->v($key) === '' && str_replace('¥', '', $value) === $default) $checked = 'checked';
        if ($this->v($key) !== '' && str_replace('¥', '', $value) === $this->v($key)) $checked = 'checked';
        ?>
        <label><input type="radio" name="<?= $key ?>" class="<?= $class_name !== '' ? $class_name : '' ?>" value="<?= str_replace('¥', '', $value) ?>" <?= $checked ?>><?= str_replace('¥', '<br class="c-onry -pc">', $value) ?></label>
      <?php endforeach; ?>
    </div>
    <?= $this->e($key) ?>
  <?php
  }

  public function input_select($key, $define, $ph = '', $auto_complete, $class_name = '')
  {?>
    <div class="c-input -select<?= $this->cl($key) ?>">
      <select id="<?= $key ?>" name="<?= $key ?>" class="<?= $class_name !== '' ? $class_name : '' ?>" <?= $auto_complete !== '' ? 'autocomplete="' . $auto_complete . '"' : '' ?>>
        <?= $ph !== '' ? '<option value="">' . $ph . '</option>' : '' ?>
        <?php foreach ($define as $value) : ?>
          <?php
          $selected = '';
          if ($this->v($key) !== '' && $value === $this->v($key)) $selected = 'selected';
          ?>
          <option value="<?= str_replace('¥', '', $value) ?>" <?= $selected ?>><?= str_replace('¥', '', $value) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?= $this->e($key) ?>
  <?php
  }

  public function input_select_id($key, $define, $ph = '', $auto_complete, $class_name = '')
  {?>
    <div class="c-input -select<?= $this->cl($key) ?>">
      <select id="<?= $key ?>" name="<?= $key ?>" class="<?= $class_name !== '' ? $class_name : '' ?>" <?= $auto_complete !== '' ? 'autocomplete="' . $auto_complete . '"' : '' ?>>
        <?= $ph !== '' ? '<option value="">' . $ph . '</option>' : '' ?>
        <?php foreach ($define as $i => $value) : ?>
          <?php
          $selected = '';
          if ($this->v($key) !== '' && strval($i + 1) === $this->v($key)) $selected = 'selected';
          ?>
          <option value="<?= $i + 1 ?>" <?= $selected ?>><?= str_replace('¥', '', $value) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?= $this->e($key) ?>
  <?php
  }

  // エラー時のcssクラス
  public function cl($key)
  {
    if (!isset($this->error[$key])) {
      return '';
    } elseif ($this->error[$key] === '') {
      return '';
    }

    return ' -error';
  }

  // value表示
  public function v($key)
  {
    if (!isset($this->post[$key])) {
      return '';
    }

    return $this->post[$key];
  }

  public function vid($key, $define)
  {
    if (!isset($this->post[$key])) {
      return '';
    }
    if (!isset($define[$this->post[$key] - 1])) {
      return '';
    }

    return $define[$this->post[$key] - 1];
  }

  // checked表示
  public function c($key, $check, $default = '')
  {
    if (!isset($this->post[$key])) {
      return $default;
    } elseif ($this->post[$key] !== strval($check)) {
      return '';
    }

    return 'checked';
  }

  // checked表示
  public function cc($key, $check, $default = '')
  {
    if (!isset($this->post[$key])) {
      return $default;
    } elseif (count($this->post[$key]) <= 0) {
      return $default;
    } elseif (!in_array(strval($check), $this->post[$key])) {
      return '';
    }

    return 'checked';
  }

  // エラー表示
  public function e($key)
  {
    if (!isset($this->error[$key])) {
      return '';
    } elseif ($this->error[$key] === '') {
      return '';
    }

    return '<p class="c-input-error">' . $this->error[$key] . '</p>';
  }
}