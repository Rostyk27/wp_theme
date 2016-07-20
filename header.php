<?php if( defined('WP_DEBUG') && true !== WP_DEBUG) {
	ob_start('ob_html_compress');
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php wpa_title(); ?></title>
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="True"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimal-ui, minimum-scale=1.0, maximum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<link rel="shortcut icon" href="<?php echo theme('images/favicon.ico'); ?>" type="image/x-icon" sizes="16x16"/>
<?php wp_head(); ?>
<style>body{opacity:0}</style>
</head>
<body <?php body_class(); ?> data-hash="<?php wpa_fontbase64(true); ?>" data-a="<?php echo admin_url('admin-ajax.php'); ?>" >
<div id="main">
    <header>
        <div class="container">
            <a class="logo" href="<?php echo site_url(); ?>">
                <img src="<?php echo theme('images/logo.png'); ?>" alt="logo">
            </a>
            <button id="menuopen"></button>
            <nav id="menu">
                <?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul id="%1$s">%3$s</ul>', 'theme_location'  => 'main_menu')); ?>
            </nav>
        </div>
    </header>