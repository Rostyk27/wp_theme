<?php
if ( !empty( $args ) ) $part_args = $args;
?>

<section class="top_panel top_panel__default">
	<div class="container<?php echo $part_args['container_class'] ? ' ' . $part_args['container_class'] : ''; ?>">
		<h1><?php echo $part_args['title'] ? : get_the_title( get_the_ID() ); ?></h1>
	</div>
</section>
