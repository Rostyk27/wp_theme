<?php
/**
 * Block Name: Accordion
 *
 * This is the template that displays the accordion block.
 */

// set a preview for a block
if( !empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url(theme('tpl-parts/blocks/images/accordion-placeholder.png')); ?>" alt="preview">
    </figure>
<?php return; endif;

// get fields
$accordion = get_field( 'accordion' );
if ( $accordion ) :
?>
    <div class="block__accordion">
        <?php foreach ( $accordion as $row ) : ?>
            <div class="block__accordion_row">
                <h3 class="acc_title" tabindex="0" aria-expanded="false"
                    aria-label="<?php echo esc_html( $row['title'] ); ?>">
                    <?php echo esc_html( $row['title'] ); ?>
                    <figure class="circle_arrow is_down"></figure>
                </h3>
                <div class="content" aria-hidden="true">
                    <?php echo wp_kses_post( $row['content'] ); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>