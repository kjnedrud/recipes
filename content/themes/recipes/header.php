<?php
/**
 * Header
 */
?><!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php wp_title('-', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<!-- <link rel="shortcut icon" type="image/png" href="<?php //echo img_url('favicon.png'); ?>"> -->
	<?php wp_head(); ?>
</head>

<body>

<header class="header-main">
	<div class="wrap">
		<div class="f-left">
			<a href="<?php echo site_url('/'); ?>" class="site-title"><?php bloginfo('name'); ?></a>
			<br><span class="site-description"><?php bloginfo('description'); ?></span>
		</div>
		<div class="f-right">
			<?php get_search_form(); ?>
		</div>
	</div>
</header>
