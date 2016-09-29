</div>
<footer>
    <div class="container flex">
        <?php echo (get_field('copy', 'option') ? '<div class="copy">' . get_field('copy', 'option') . '</div>' : ''); ?>
        <?php echo (get_field('dev', 'option') ? '<div class="dev">' . get_field('dev', 'option') . '</div>' : ''); ?>
    </div>
</footer>
<a href="#modal">Call modal!</a>
<div class="remodal" data-remodal-id="modal">
	<span data-remodal-action="close" class="remodal-close"></span>
	<h2>Remodal</h2>
	<h3>Example</h3>
	<button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
	<button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>
<?php wp_footer(); ?>
</body>
</html>
<?php if( defined('WP_DEBUG') && true !== WP_DEBUG) {
	ob_end_flush();
} ?>
