</div>
<footer>
    <div class="container">
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
<?php if( defined('WP_DEBUG') && true !== WP_DEBUG) {
	ob_end_flush();
} ?>