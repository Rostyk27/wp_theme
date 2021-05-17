<?php if( @!WP_DEBUG) {	ob_start('ob_html_compress'); } ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php wpa_title(); ?></title>
        <meta name="MobileOptimized" content="width"/>
        <meta name="HandheldFriendly" content="True"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="format-detection" content="telephone=no">
        <meta name="theme-color" content="#1c2c39">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,500&display=swap"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,500&display=swap" media="print" onload="this.media='all'"/>
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?> data-a="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
        <div id="main">
            <header>
                <div class="container flex">
                    <a href="<?php echo esc_url( site_url() ); ?>" class="logo">
                        <img src="<?php echo esc_url( theme( 'images/logo.svg' ) ); ?>" alt="logo">
                    </a>

                    <figure class="search_toggle i_search" data-fancybox data-src="#search_field"></figure>

                    <a class="nav_icon" href="javascript:;" aria-label="hamburger"><i></i><i></i><i></i></a>

                    <nav id="menu" class="flex__rwd">
		                <?php wp_nav_menu(
			                array(
				                'container'      => false,
				                'items_wrap'     => '<ul class="flex__rwd">%3$s</ul>',
				                'theme_location' => 'main_menu'
			                )
		                ); ?>
                    </nav>
                </div>
            </header>

            <div id="search_field">
                <div class="container"><?php get_search_form(); ?></div>
            </div>