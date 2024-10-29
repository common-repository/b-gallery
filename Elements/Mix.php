<?php foreach( $bgallery_mix_content as $bgallery_mix_single_content ): ?>
    <?php if($bgallery_mix_single_content['media_type'] === 'image_type') : ?>

        <div class="bGallery-item gallery-item">
            <a class="gallery" href="<?php echo esc_url( $bgallery_mix_single_content['bgallery_mix_content_images']['url'] ); ?>">
            <div class="imgArea">
                <img src="<?php echo esc_url( $bgallery_mix_single_content['bgallery_mix_content_images']['url'] ); ?>">
            </div>
            </a>
            <?php if( isset($bgallery_mix_single_content['gallery_image_title']) && !empty($bgallery_mix_single_content['gallery_image_title'])): ?>
                    <h2 class="bGallery_title"><?php echo esc_attr($bgallery_mix_single_content['gallery_image_title']); ?></h2>
                <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if($bgallery_mix_single_content['media_type'] === 'video_type') : ?>
         <?php if($bgallery_mix_single_content['mix_gallery_vid_type'] === 'link') : ?>
            <div class="vGallery-item gallery-item">
                <a class="vGallery gallery" data-flashy-type="video" href="<?php echo esc_url($bgallery_mix_single_content['mix_gallery_vid']); ?>">
                    <div class="imgArea">
                        <img src="<?php echo esc_url($bgallery_mix_single_content['video_thumb']['url']); ?>">
                    </div>
                    <div class="vOverlay"><span class="plyr_btn"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M23 12l-22 12v-24l22 12zm-21 10.315l18.912-10.315-18.912-10.315v20.63z"/></svg></span></div>
                </a>

                <?php if( isset($bgallery_mix_single_content['gallery_vid_title']) && !empty($bgallery_mix_single_content['gallery_vid_title'])): ?>
                    <h2 class="bGallery_title"><?php echo esc_attr($bgallery_mix_single_content['gallery_vid_title']); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if( $bgallery_mix_single_content['mix_gallery_vid_type'] === 'upload') : ?>
            <div class="vGallery-item gallery-item">
                <a class="vGallery gallery" data-flashy-type="inline" href="#video-<?php echo esc_attr($bgallery_mix_single_content['mix_gallery_html5_vid']['id']); ?>">
                    <div class="imgArea">
                        <img src="<?php echo esc_url($bgallery_mix_single_content['video_thumb']['url']); ?>">
                    </div>
                    <div class="vOverlay"><span class="plyr_btn"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M23 12l-22 12v-24l22 12zm-21 10.315l18.912-10.315-18.912-10.315v20.63z"/></svg></span></div>
                </a>

                <div id="video-<?php echo esc_attr($bgallery_mix_single_content['mix_gallery_html5_vid']['id']); ?>" style="display:none">
                    <div class="inline">
                    <video width="100%" height="auto" controls>
                        <source src="<?php echo esc_url($bgallery_mix_single_content['mix_gallery_html5_vid']['url']); ?>" >
                    </video> 
                    </div>
                </div>
                <?php if( isset($bgallery_mix_single_content['gallery_vid_title']) && !empty($bgallery_mix_single_content['gallery_vid_title'])): ?>
                    <h2 class="bGallery_title"><?php echo esc_attr($bgallery_mix_single_content['gallery_vid_title']); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; 
    
endforeach;
?>