<?php
if ( !empty( $args ) ) $part_args = $args;
$tax   = $part_args['tax'];
$label = $part_args['label'];

// term_query
$cat_terms = get_terms(array(
	'taxonomy'   => $tax,
	'hide_empty' => true,
	'orderby'    => 'id'
));

if ( !empty( $cat_terms ) && ! is_wp_error( $cat_terms ) ) : ?>
    <div class="posts__filter_item">
        <ul class="posts__filters_desktop filters__taxonomy mob_hide">
            <li><a href="javascript:;" data-id="*" class="is_filtered"><?php echo $label; ?></a></li>
			<?php foreach( $cat_terms as $cat_term ) : ?>
                <li><a href="javascript:;" data-id="<?php echo $cat_term->term_id; ?>"><?php echo esc_html( $cat_term->name ); ?></a></li>
			<?php endforeach; ?>
        </ul>

        <div class="mob_show">
            <select id="select__<?php echo $tax; ?>" class="posts__dropdown dropdown__taxonomy">
                <option value="*" data-name="<?php echo $tax; ?>"><?php echo $label; ?></option>
				<?php foreach ( $cat_terms as $cat_term ) : ?>
                    <option value="<?php echo $cat_term->term_id; ?>"
                            data-name="<?php echo $tax; ?>"><?php echo esc_html( $cat_term->name ); ?></option>
				<?php endforeach; ?>
            </select>
        </div>

		<?php echo wp_kses(get_loader(), $GLOBALS['allowed_loader']); ?>
    </div>
<?php endif; ?>