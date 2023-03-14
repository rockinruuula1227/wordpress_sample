<?php
#使いかた
wp-sampleテーマのfunctionsディレクトリに
func.smart-custom-fieldsをコピーしてください。

$scf_settingsと$scf_groupsを下記にしたがって入力すると、
管理画面にカスタムフィールドが表示されるようになります。


#func.smart-custom-fields.phpの入力例
##メタボックスのセッティング
```php
  private $scf_settings = array(
    'scf_setting_1' => array( //メタボックスのID（一意）
      'show' => array( //表示するカスタム投稿・オプションページなど
        'products' //カスタム投稿タイプなどのスラッグ
      ),
      'title' => '分類A', //メタボックスのタイトル
      'groups' => array( //登録するグループの配列
        'group1',
        'group2'
      )
    ),
    'scf_setting_2' => array(
      'show' => array(
        'products'
      ),
      'title' => '分類B',
      'groups' => array(
        'group3'
      )
    ),
  );
```

##グループのセッティング
```php
  private $scf_groups = array(
    'group1' => array( //グループのID（一意）
      'repeat' => true, //繰り替えしフィールドか
      'values' => array(
        /* SCFのフィールドセッティング用配列（下記参照） */,
        /* SCFのフィールドセッティング用配列（下記参照） */
      )
    ),
    'group2' => array(
      'repeat' => false,
      'values' => array(
        /* SCFのフィールドセッティング用配列（下記参照） */
      )
    )
  );
```

##SCFのフィールドセッティング用配列
基本の構造は以下の通りです。
管理画面で設定できる値を記入してください。

```php
  $arg = array(
    'name'  => 'field_slug', //フィールドのスラッグ（一意）
    'label' => 'テストフィールド', //フィールド名
    'type'  => 'text', //フィールドの種類
  );
```

###基本フィールド
####真偽値
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'boolean',
    'default'     => 0,
    'instruction' => '',
    'notes'       => '',
    'true_label'  => __( 'Yes', 'smart-custom-fields' ),
    'false_label' => __( 'No', 'smart-custom-fields' ),
  );
```

####メッセージ
```php
  $arg = array(
    'name'    => 'field_slug',
    'label'   => 'テストフィールド',
    'type'    => 'message',
    'default' => '',
    'notes'   => '',
  );
```

####テキスト
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'text',
    'default'     => '',
    'instruction' => '',
    'notes'       => '',
  );
```

####テキストエリア
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'textarea',
    'rows'        => 5,
    'default'     => '',
    'instruction' => '',
    'notes'       => '',
  );
```

###選択フィールド
####チェックボックス
```php
  $arg = array(
    'name'            => 'field_slug',
    'label'           => 'テストフィールド',
    'type'            => 'check',
    'choices'         => '',
    'check_direction' => 'horizontal', // or vertical
    'default'         => '',
    'instruction'     => '',
    'notes'           => '',
  );
```

####ラジオボタン
```php
  $arg = array(
    'name'            => 'field_slug',
    'label'           => 'テストフィールド',
    'type'            => 'radio',
    'choices'         => '',
    'radio_direction' => 'horizontal', // or vertical
    'default'         => '',
    'instruction'     => '',
    'notes'           => '',
  );
```

####セレクトボックス
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'select',
    'choices'     => '',
    'default'     => '',
    'instruction' => '',
    'notes'       => '',
  );
```

###コンテンツフィールド
####ファイル
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'file',
    'instruction' => '',
    'notes'       => '',
  );
```

####画像
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'image',
    'instruction' => '',
    'notes'       => '',
    'size'        => 'full',
  );
```

####WYSIWYG
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'wysiwyg',
    'default'     => '',
    'instruction' => '',
    'notes'       => '',
  );
```

###その他のフィールド
####カラーピッカー
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'colorpicker',
    'default'     => '',
    'instruction' => '',
    'notes'       => '',
  );
```

####日付ピッカー
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'datepicker',
    'date_format' => '',
    'max_date'    => '',
    'min_date'    => '',
    'default'     => '',
    'instruction' => '',
    'notes'       => '',
  );
```

####時刻付き日付ピッカー
```php
  $arg = array(
    'name'        => 'field_slug',
    'label'       => 'テストフィールド',
    'type'        => 'datetime-picker',
    'date_format' => '',
    'max_date'    => '',
    'min_date'    => '',
    'time_24hr'   => '',
    'default'     => '',
    'instruction' => '',
    'notes'       => '',
  );
```

####関連する投稿
```php
  $arg = array(
    'name'            => 'field_slug',
    'label'           => 'テストフィールド',
    'type'            => 'related-posts',
    'post-type'   => '',
    'limit'       => 0,
    'instruction' => '',
    'notes'       => '',
  );
```

####関連するターム
```php
  $arg = array(
    'name'            => 'field_slug',
    'label'           => 'テストフィールド',
    'type'            => 'related-terms',
    'taxonomy'    => '',
    'limit'       => 0,
    'instruction' => '',
    'notes'       => '',
  );
```
