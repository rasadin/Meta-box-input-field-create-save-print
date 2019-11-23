while ( have_posts() ) :
?> <button><?php $my_meta2 = get_post_meta(get_the_ID(), 'eb_pdf_link_title', true ); ?> <a href="<?php printf( $my_meta2 );?>"> PDF LINK DOWNLOAD </a> </button> <?php
endwhile; // End of the loop.


//single.php er loop er vithor print korte hbe
//eb_pdf_link_title eyta meta box er id nah. eyta holo input field er name. 
// https://rudrastyh.com/wordpress/meta-boxes.html
//https://nicola.blog/2017/03/01/post-meta-get-value/
