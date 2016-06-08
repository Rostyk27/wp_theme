</div>
<footer>
    <div class="container flex">
        <?php if($copy = get_field('copy', 'option')) echo '<div class="copy">' . $copy . '</div>'; ?>
        <?php if($dev = get_field('dev', 'option')) echo '<div class="dev">' . $dev . '</div>'; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
<?php if( defined('WP_DEBUG') && true !== WP_DEBUG) {
	ob_end_flush();
} ?>
