<?php
// category filters
$cat_terms = get_terms(array(
	'taxonomy'   => 'category',
	'hide_empty' => true,
	'orderby'    => 'id'
));

if ( !empty( $cat_terms ) && ! is_wp_error( $cat_terms ) ) : ?>
	<div class="posts__filtering">
		<div class="posts__filters mob_hide">
			<a href="*" class="is_filtered">All</a>
			<?php foreach($cat_terms as $cat_term) : ?>
				<a href="#<?php echo wp_kses_post($cat_term->slug); ?>"><?php echo esc_html($cat_term->name); ?></a>
			<?php endforeach; ?>
		</div>

		<div class="mob_show">
			<select class="posts__dropdown">
				<option value="*">All</option>
				<?php foreach ($cat_terms as $cat_term) : ?>
					<option value="#<?php echo wp_kses_post($cat_term->slug); ?>"><?php echo esc_html($cat_term->name); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<?php echo wp_kses(get_loader(), $GLOBALS['allowed_loader']); ?>
	</div>
<?php endif; ?>