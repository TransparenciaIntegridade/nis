<?php

/**
 * Create the Post meta boxes
 */
    
add_action('add_meta_boxes', 'junkie_metabox_posts');
function junkie_metabox_posts(){
	    
	/* Create a gallery metabox -----------------------------------------------------*/
    $meta_box = array(
		'id' => 'junkie-metabox-post-gallery',
		'title' =>  __('Gallery Settings', 'junkie'),
		'description' => __('Set up your gallery.', 'junkie'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
					'name' => __('Gallery Layout', 'junkie'),
					'desc' => __('Should the gallery images be stacked or in a slideshow?', 'junkie'),
					'id' => '_junkie_gallery_layout',
					'type' => 'select',
					'std' => '',
					'options' => array( 
						'slideshow' => __('Slideshow', 'junkie'),
						'stacked' => __('Stacked', 'junkie')						
					)
				),
			array(
					'name' =>  __('Upload Images', 'junkie'),
					'desc' => __('Click to upload images.', 'junkie'),
					'id' => '_junkie_gallery_upload',
					'type' => 'images',
                    'std' => __('Upload Images', 'junkie')
				)
		)
	);
    junkie_add_meta_box( $meta_box );

    /* Create a quote metabox -----------------------------------------------------*/
    $meta_box = array(
		'id' => 'junkie-metabox-post-quote',
		'title' =>  __('Quote Settings', 'junkie'),
		'description' => __('Input your quote.', 'junkie'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
					'name' =>  __('The Quote', 'junkie'),
					'desc' => __('Input your quote.', 'junkie'),
					'id' => '_junkie_quote_quote',
					'type' => 'textarea',
                    'std' => ''
				)
		)
	);
    junkie_add_meta_box( $meta_box );
	
	/* Create a link metabox ----------------------------------------------------*/
	$meta_box = array(
		'id' => 'junkie-metabox-post-link',
		'title' =>  __('Link Settings', 'junkie'),
		'description' => __('Input your link', 'junkie'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
					'name' =>  __('The Link', 'junkie'),
					'desc' => __('Input your link. e.g., http://www.theme-junkie.com', 'junkie'),
					'id' => '_junkie_link_url',
					'type' => 'text',
					'std' => ''
				)
		)
	);
    junkie_add_meta_box( $meta_box );
    
    /* Create a video metabox -------------------------------------------------------*/
    $meta_box = array(
		'id' => 'junkie-metabox-post-video',
		'title' => __('Video Settings', 'junkie'),
		'description' => __('These settings enable you to embed videos into your posts.', 'junkie'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('Video Height', 'junkie'),
					'desc' => __('The video height (e.g. 350).', 'junkie'),
					'id' => '_junkie_video_height',
					'type' => 'text',
					'std' => '350'
				),
			array( 
					'name' => __('M4V File URL', 'junkie'),
					'desc' => __('The URL to the .m4v video file', 'junkie'),
					'id' => '_junkie_video_m4v',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('OGV File URL', 'junkie'),
					'desc' => __('The URL to the .ogv video file', 'junkie'),
					'id' => '_junkie_video_ogv',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Poster Image', 'junkie'),
					'desc' => __('The preview image.', 'junkie'),
					'id' => '_junkie_video_poster_url',
					'type' => 'file',
					'std' => ''
				),
			array(
					'name' => __('Embedded Code', 'junkie'),
					'desc' => __('If you are using something other than self hosted video such as Youtube or Vimeo, paste the embed code here. Width is best at 600px with any height.<br><br> This field will override the above.', 'junkie'),
					'id' => '_junkie_video_embed_code',
					'type' => 'textarea',
					'std' => ''
				)
		)
	);
	junkie_add_meta_box( $meta_box );
	
	/* Create an audio metabox ------------------------------------------------------*/
	$meta_box = array(
		'id' => 'junkie-metabox-post-audio',
		'title' =>  __('Audio Settings', 'junkie'),
		'description' => __('These settings enable you to embed audio into your posts.', 'junkie'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('MP3 File URL', 'junkie'),
					'desc' => __('The URL to the .mp3 audio file', 'junkie'),
					'id' => '_junkie_audio_mp3',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('OGA File URL', 'junkie'),
					'desc' => __('The URL to the .oga, .ogg audio file', 'junkie'),
					'id' => '_junkie_audio_ogg',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Audio Poster Image', 'junkie'),
					'desc' => __('The preview image for this audio track', 'junkie'),
					'id' => '_junkie_audio_poster_url',
					'type' => 'file',
					'std' => ''
				),
			array( 
					'name' => __('Audio Poster Image Height', 'junkie'),
					'desc' => __('The height of the poster image', 'junkie'),
					'id' => '_junkie_audio_height',
					'type' => 'text',
					'std' => ''
				)
		)
	);
	junkie_add_meta_box( $meta_box );
}