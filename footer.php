</div>
<footer>
    <div class="container flex">
	    <div class="copy">© <?php bloginfo(); ?> <?php echo esc_html(date( 'Y' )); ?></div>
	    <a href="#" class="dev" target="_blank" rel="noopener noreferrer">Developed by</a>
	    <?php /*echo wp_kses_post(so_me()); */?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
<?php if( @!WP_DEBUG) {	ob_end_flush(); } ?>
