<?php $share_title = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8'); ?>

<li><a class="i_fcbk" href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;quote=<?php echo esc_html( $share_title ); ?>"
       title="Share at Facebook" target="_blank" rel="noopener"></a></li>
<li><a class="i_twtr" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&amp;text=<?php echo esc_html( $share_title ); ?>"
       title="Tweet It" target="_blank" rel="noopener"></a></li>
<li><a class="i_lnkdn" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>"
       title="Share at LinkedIn" target="_blank" rel="noopener"></a></li>
<li><a class="i_whtsp" href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>"
       data-action="share/whatsapp/share" target="_blank" rel="noopener" title="Share at WhatsApp"></a></li>
<li><a class="i_envelope_o" href="mailto:?subject=<?php echo esc_html( $share_title ); ?>&amp;body=<?php the_permalink(); ?>"
       title="Send via email"></a></li>