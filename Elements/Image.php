<?php foreach( $bgallery_images as $gallery_img_id ): 
    $image_src_id = wp_get_attachment_image_src( $gallery_img_id, 'full', false );
    $image_caption = wp_get_attachment_caption($gallery_img_id);
    ?>

    <div class="bGallery-item gallery-item">
        <a class="gallery " href="<?php echo esc_url( $image_src_id[0] ); ?>">
            <div class="imgArea">
                <img src="<?php echo esc_url( $image_src_id[0] ); ?>">
            </div>
        </a>
        <?php if( isset($image_caption) && !empty($image_caption)): ?>
            <h2 class="bGallery_title"><?php echo esc_attr($image_caption); ?></h2>
        <?php endif; ?>
    </div>

<?php endforeach; ?>