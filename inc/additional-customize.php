<?php 
//
/*-------------------------------------------------------------------------------*/
/*   Additional Features
/*-------------------------------------------------------------------------------*/

// Hide & Disabled View, Quick Edit and Preview Button 
function bgallery_remove_row_actions($idtions)
{
    global $post;
    if ($post->post_type == 'bgallery') {
        unset($idtions['view']);
        unset($idtions['inline hide-if-no-js']);
    }
    return $idtions;
}

if (is_admin()) {
    add_filter('post_row_actions', 'bgallery_remove_row_actions', 10, 2);
}

// HIDE everything in PUBLISH metabox except Move to Trash & PUBLISH button
function bgallery_hide_publishing_actions()
{
    $my_post_type = 'bgallery';
    global $post;
    if ($post->post_type == $my_post_type) {
        echo '
            <style type="text/css">
                #misc-publishing-actions,
                #minor-publishing-actions{
                    display:none;
                }
            </style>
        ';
    }
}
add_action('admin_head-post.php', 'bgallery_hide_publishing_actions');
add_action('admin_head-post-new.php', 'bgallery_hide_publishing_actions');

/*-------------------------------------------------------------------------------*/
// Remove post update massage and link 
/*-------------------------------------------------------------------------------*/

function bgallery_updated_messages($messages)
{
    $messages['bgallery'][1] = __('bGallery updated ', 'bgallery');
    return $messages;
}
add_filter('post_updated_messages', 'bgallery_updated_messages');

/*-------------------------------------------------------------------------------*/
/* Change publish button to save.
/*-------------------------------------------------------------------------------*/
add_filter('gettext', 'bgallery_change_publish_button', 10, 2);
function bgallery_change_publish_button($translation, $text)
{
    if ('bgallery' == get_post_type())
        if ($text == 'Publish')
            return 'Save';

    return $translation;
}

/*-------------------------------------------------------------------------------*/
/* Footer Review Request .
/*-------------------------------------------------------------------------------*/

add_filter('admin_footer_text', 'bgallery_admin_footer');
function bgallery_admin_footer($text)
{
    if ('bgallery' == get_post_type()) {
        $url = 'https://wordpress.org/plugins/bgallery/reviews/?filter=5#new-post';
        $text = sprintf(__('If you like <strong> bGallery </strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'bgallery'), $url);
    }
    return $text;
}

/*-------------------------------------------------------------------------------*/
/* Shortcode Generator area  .
/*-------------------------------------------------------------------------------*/

add_action('edit_form_after_title', 'bgallery_shortcode_area');
function bgallery_shortcode_area()
{
    global $post;
    if ($post->post_type == 'bgallery') : ?>

        <div class="bgal_shortcode_gen">
            <label for="bgallery_shortcode"><?php esc_html_e('Copy this shortcode and paste it into your post, page, text widget content  or custom-template.php', 'bgallery') ?>:</label>

            <?php 
            $html = null;
            $html .= '<span><input type="text" onfocus="this.select();" readonly="readonly" value="[bGallery id=&quot;'. $post->ID .'&quot;]"></span>';
            
            $html .= '<span>
            <input type="text" onfocus="this.select();" readonly="readonly" value="&#60;&#63;php echo do_shortcode( &#39;[bGallery id=&quot;'. $post->ID .'&quot;]&#39; ); &#63;&#62;" class="large-text code tlp-code-sc">
            </span>';
            echo $html;
            ?>

        </div>
<?php endif; }


// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
add_filter('manage_shortcode-generator_posts_columns', 'bgallery_columns_head_only', 10);
add_action('manage_shortcode-generator_posts_custom_column', 'bgallery_columns_content_only', 10, 2);


// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
    function bgallery_columns_head_only($defaults) {
        unset($defaults['date']);
        $defaults['directors_name'] = 'ShortCode';
        $defaults['date'] = 'Date';
        return $defaults;
    }

    function bgallery_columns_content_only($column_name, $post_ID) {
        if ($column_name == 'directors_name') {
            echo '<div class="bgallery_front_shortcode"><input onfocus="this.select();" style="text-align: center; border: none; outline: none; background-color: #1e8cbe; color: #fff; padding: 4px 10px; border-radius: 3px;" value="[bgallery  id='."'".$post_ID."'".']" ></div>';
    }
}