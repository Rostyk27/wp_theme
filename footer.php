</div>
<footer>
    <div class="container flex">
	    <div class="copy">© Project Name <?php echo date( 'Y' ) ?> | All rights reserved</div>
	    <a href="#" class="dev" target="_blank" rel="noopener noreferrer">Developed in Lviv</a>
    </div>
</footer>
<a href="#modal">Call modal!</a>
<div class="remodal" data-remodal-id="modal">
	<span data-remodal-action="close" class="remodal-close"></span>
	<h2>Remodal Example</h2>
	<button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
	<button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>
<?php wp_footer(); ?>
</body>
</html>
<?php if( @!WP_DEBUG) {	ob_end_flush(); } ?>
