<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?= get_template_directory_uri() ?>/assets/img/common/favicon.ico">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<?php
	wp_enqueue_style('wp_styles', get_template_directory_uri() . '/admin/wp-style.css');
	//	wp_enqueue_style( 'css_styles', get_template_directory_uri() . '/assets/css/styles.css');
	?>
	<?php wp_head(); ?>
</head>

<body>