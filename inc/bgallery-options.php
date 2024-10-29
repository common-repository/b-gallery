<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//
// Metabox of the PAGE
// Set a unique slug-like ID
//
$prefix = '_bGallery_';

//
// Create a metabox
//
CSF::createMetabox( $prefix, array(
  'title'        => 'Gallery Options',
  'post_type'    => 'bgallery',
  'show_restore' => true,
) );

//
// Create a section
//
CSF::createSection( $prefix, array(
  'title'  => 'Gallery Settings',
  'icon'   => 'fas fa-rocket',
  'fields' => array(

    // Fields
    array(
      'id'         => 'bgallery_type',
      'type'       => 'button_set',
      'title'   => __('Gallery Type', 'bgallery'),
      'subtitle'=> __('Choose Gallery Type', 'bgallery'),
      'desc'    => __('Select Gallery, Default "Image Gallery".', 'bgallery'),
      'options'    => array(
        'image'  => 'Image Gallery',
        'video'  => 'Video Gallery',
        'mix'  => 'Mixed Media Gallery',
      ),
      'default'    => 'image'
    ),

    //Mixed content
    array(
      'id'      => 'bgallery_mix_gallery',
      'type'  => 'group',
      'title'   => __('Mixed Gallery', 'bgallery'),
      'button_title' => 'Add New Media',
      'accordion_title_number' => true,
      'accordion_title_auto' => false,
      'accordion_title_prefix' => "Item", 
       'fields'    => array(
        array(
          'id'    => 'media_type',
          'type'  => 'button_set',
          'title'   => __('Media Type', 'bgallery'),
          'options'    => array(
            'image_type'  => 'Image',
            'video_type'  => 'Video'
          ),
          'default' => 'image_type'
        ), 
        // Image Gallery
        array(
          'id'    => 'gallery_image_title',
          'type'  => 'text',
          'title'   => __('Image Title ', 'bgallery'),
          'desc' => __('Leave blank if you don\'t want to use title', 'bgallery'),
          'placeholder' => __('Write Your Image Title Here', 'bgallery'),
          'dependency' => array( 'media_type', '==', 'image_type' ),
        ),
        array(
          'id'      => 'bgallery_mix_content_images',
          'type'    => 'media',
          'title'   => __('Add Image', 'bgallery'),
          'library' => 'image',
          'dependency' => array( 'media_type', '==', 'image_type' ),
        ),
        // Video Gallery 
        array(
          'id'    => 'gallery_vid_title',
          'type'  => 'text',
          'title'   => __('Video Title ', 'bgallery'),
          'desc' => __('Leave blank if you don\'t want to use title', 'bgallery'),
          'placeholder' => __('Write Your Video Title Here', 'bgallery'),
          'dependency' => array( 'media_type', '==', 'video_type' ),
        ),
        array(
          'id'    => 'mix_gallery_vid_type',
          'type'  => 'radio',
          'title'   => __('Video Type', 'bgallery'),
          'desc'    => __('Choose Your Video Type Above the list', 'bgallery'),
          'options'    => array(
            'upload'  => 'Upload',
            'link'  => 'YouTube / Vimeo',
          ),
          'default' => 'upload',
          'dependency' => array( 'media_type', '==', 'video_type' )
        ),
        array(
          'id'    => 'mix_gallery_html5_vid',
          'type'  => 'media',
          'title'   => __('Upload Video test', 'bgallery'),
          'desc'    => __('Upload Your Video here', 'bgallebgallery_imagesry'),
          'library' => 'video',
          'dependency' => array( array('mix_gallery_vid_type', '==', 'upload' ), array( 'media_type', '==', 'video_type' )  ),
        ),
        array(
          'id'    => 'mix_gallery_vid',
          'type'  => 'text',
          'title'   => __('Video Link ', 'bgallery'),
          'desc'    => __('Input Youtube/Vimeo Video link here' , 'bgallery'),
          'placeholder' => __('Paste Video Link Here', 'bgallery'),
          'dependency' => array(array( 'mix_gallery_vid_type', '==', 'link' ), array( 'media_type', '==', 'video_type' )),
        ),
        array(
          'id'    => 'video_thumb',
          'type'  => 'media',
          'title' => 'Video Thumbnail',
          'subtitle'=> __('Upload Your Image for Gallery', 'bgallery'),
          'desc' => __('Use Same Size Image for Better View', 'bgallery'),
          'dependency' => array( 'media_type', '==', 'video_type' )
        ),

      ),
      
      'dependency' => array( 'bgallery_type', '==', 'mix' )
    ),

    // Image Gallery
    array(
      'id'      => 'bgallery_images',
      'type'    => 'gallery',
      'title'   => __('Gallery Image', 'bgallery'),
      'subtitle'=> __('Upload Your Gallery Image', 'bgallery'),
      'desc'    => __('Upload Picture/ Images for Gallery.', 'bgallery'),
      'add_title' => 'Add Gallery Images',
      'fields'    => array(
        array(
          'id'    => 'bGallery_pic',
          'type'  => 'upload',
          'title' => 'Gallery Picture',
        ),
      ),
      'dependency' => array( 'bgallery_type', '==', 'image' ),
    ),
    // Video Gallery
    array(
      'id'      => 'bgallery_video',
      'type'    => 'group',
      'title'   => __('Gallery Videos', 'bgallery'),
      'subtitle'=> __('Your Gallery Videos', 'bgallery'),
      'desc'    => __('Paste Youtube/Vimeo Link or Upload Local Video Files.', 'bgallery'),
      'button_title' => 'Add New Video',
      'fields'    => array(
        array(
          'id'    => 'gallery_vid_title',
          'type'  => 'text',
          'title'   => __('Video Title ', 'bgallery'),
          'desc' => __('Leave blank if you don\'t want to use title', 'bgallery'),
          'placeholder' => __('Write Your Video Title Here', 'bgallery'),
        ),
        array(
          'id'    => 'gallery_vid_type',
          'type'  => 'radio',
          'title'   => __('Video Type', 'bgallery'),
          'desc'    => __('Choose Your Video Type Above the list', 'bgallery'),
          'options'    => array(
            'upload'  => 'Upload',
            'link'  => 'YouTube / Vimeo',
          ),
          'default' => 'upload',
        ),
        array(
          'id'    => 'gallery_html5_vid',
          'type'  => 'media',
          'title'   => __('Upload Video', 'bgallery'),
          'desc'    => __('Upload Your Video here', 'bgallery'),
          'library' => 'video',
          'dependency' => array( 'gallery_vid_type', '==', 'upload' ),
        ),
        array(
          'id'    => 'gallery_vid',
          'type'  => 'text',
          'title'   => __('Video Link ', 'bgallery'),
          'desc'    => __('Input Youtube/Vimeo Video link here', 'bgallery'),
          'placeholder' => __('Paste Video Link Here', 'bgallery'),
          'dependency' => array( 'gallery_vid_type', '==', 'link' ),
        ),
        array(
          'id'    => 'video_thumb',
          'type'  => 'media',
          'title' => 'Video Thumbnail',
          'subtitle'=> __('Upload Your Image for Gallery', 'bgallery'),
          'desc' => __('Use Same Size Image for Better View', 'bgallery'),
        ),
      ),
      'dependency' => array( 'bgallery_type', '==', 'video', 'all' ),
    ),

    array(
      'id'         => 'bgallery_device',
      'type'       => 'button_set',
      'title'   => __('Device', 'bgallery'),
      'options'    => array(
        'desktop'  => 'Desktop',
        'tablet'  => 'Tablet',
        'mobile'  => 'mobile',
      ),
      'default'    => 'desktop',
    ),
    array(
      'id'         => 'bgallery_col',
      'type'       => 'button_set',
      'title'   => __('Column', 'bgallery'),
      'options'    => array(
        '1'  => '1 Col',
        '2'  => '2 Col',
        '3'  => '3 Col',
        '4'  => '4 Col',
        '5'  => '5 Col',
      ),
      'default'    => '4',
      'dependency'=> ['bgallery_device', '==', 'desktop']
    ),
    array(
      'id'         => 'bgallery_col_tablet',
      'type'       => 'button_set',
      'title'   => __('Column ', 'bgallery'),
      'options'    => array(
        '1'  => '1 Col',
        '2'  => '2 Col',
        '3'  => '3 Col',
        '4'  => '4 Col',
        '5'  => '5 Col',
      ),
      'default'    => '2',
      'dependency'=> ['bgallery_device', '==', 'tablet']
    ),
    array(
      'id'         => 'bgallery_col_mobile',
      'type'       => 'button_set',
      'title'   => __('Column', 'bgallery'),
      'options'    => array(
        '1'  => '1 Col',
        '2'  => '2 Col',
        '3'  => '3 Col',
        '4'  => '4 Col',
        '5'  => '5 Col',
      ),
      'default'    => '1',
      'dependency'=> ['bgallery_device', '==', 'mobile']
    ),
    array(
      'id'         => 'bgallery_row_gap',
      'type'       => 'spinner',
      'title'   => __('Row Gap', 'bgallery'),
      'subtitle'=> __('Space between two items', 'bgallery'),
      'desc'    => __('Input Items Gap, Default "5px".', 'bgallery'),
      'default'    => 5,
    ),
    array(
      'id'         => 'bgallery_col_gap',
      'type'       => 'spinner',
      'title'   => __('Column Gap', 'bgallery'),
      'subtitle'=> __('Space between two items', 'bgallery'),
      'desc'    => __('Input Items Gap, Default "5px".', 'bgallery'),
      'default'    => 5,
    ),
  
    array(
      'id'         => 'bgallery_item_limit',
      'type'       => 'spinner',
      'title'   => __('Display Limits', 'bgallery'),
      'subtitle'=> __('Item limits for Primary Gallery Display', 'bgallery'),
      'desc'    => __('Input Here Your Desire Number, Default "12".', 'bgallery'),
      'default'    => 8,
    ),

    array(
      'id'         => 'bgallery_item_load',
      'type'       => 'spinner',
      'title'   => __('Load Items', 'bgallery'),
      'subtitle'=> __('Load Items for Primary Gallery Display', 'bgallery'),
      'desc'    => __('Input Here Your Desire Number, Default "8".', 'bgallery'),
      'default'    => 8,
    ),

    array(
      'id'         => 'bgallery_item_height',
      'type'       => 'spinner',
      'title'   => __('Item Height', 'bgallery'),
      'desc'    => __('Set item height, Default "170px".', 'bgallery'),
      'default'    => 170,
    ),

    // caption 
    array(
      'id'    => 'bgallery_title_typo',
      'type'  => 'typography',
      'subset' => false,
      'text_align' => false,
      'title' => __('Title Typography', 'bgallery'),
      'desc' => __('Set title Typography.', 'bgallery'),
      'default' => array(
        'color'       => '#000',
        'font-family' => 'Open Sans',
        'font-size'   => '16',
        'line-height' => '',
        'unit'        => 'px',
      ),
       
    ),

  // Video Fields
    array(
      'id'         => 'video_hover_color',
      'type'       => 'color',
      'title'   => __('Video Overlay Hover', 'bgallery'),
      'desc'    => __('Choose Video Overlay Hover Background', 'bgallery'),
      'default'    => '#3333337D',
      'dependency' => array( 'bgallery_type', '==', 'video' ),
    ),
    array(
      'id'         => 'video_btn_bg',
      'type'       => 'color',
      'title'      => __('Play Button Background', 'bgallery'),
      'desc'       => __('Choose Playe Button Background Color', 'bgallery'),
      'default'    => '#ff00007D',
      'dependency' => array( 'bgallery_type', '==', 'video' ),
    ),
    array(
      'id'         => 'video_btn_hover',
      'type'       => 'color',
      'title'      => __('Play Button Hover Color', 'bgallery'),
      'desc'       => __('Choose Play Button Hover Color', 'bgallery'),
      'default'    => '#ff0000',
      'dependency' => array( 'bgallery_type', '==', 'video' ),
    ),
    // Load More Button
    array(
      'id'         => 'loadMore_btn_text',
      'type'       => 'text',
      'title'      => __('LoadMore Button Text', 'bgallery'),
      'desc'       => __('Input LoadMore Button Text', 'bgallery'),
      'default'    => 'Load More',
    ),
    array(
      'id'         => 'loadMore_text_color',
      'type'       => 'color',
      'title'      => __('LoadMore Text Color', 'bgallery'),
      'desc'       => __('Choose LoadMore Button Text Color', 'bgallery'),
      'default'    => '#fff',
    ),
    array(
      'id'         => 'loadMore_btn_bg',
      'type'       => 'color',
      'title'      => __('LoadMore Button Background', 'bgallery'),
      'desc'       => __('Choose LoadMore Button Background Color', 'bgallery'),
      'default'    => '#000',
    ),
    array(
      'id'         => 'loadMore_hover_bg',
      'type'       => 'color',
      'title'      => __('LoadMore Hover Background', 'bgallery'),
      'desc'       => __('Choose LoadMore Hover Background Color', 'bgallery'),
      'default'    => '#222',
    ),
  )
) );

