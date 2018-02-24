</div>
<footer>
    <div class="container flex">
	    <div class="copy">© <?php bloginfo(); ?> <?php echo date( 'Y' ) ?></div>
	    <a href="#" class="dev" target="_blank" rel="noopener noreferrer">Developed by</a>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
<?php if( @!WP_DEBUG) {	ob_end_flush(); } ?>
