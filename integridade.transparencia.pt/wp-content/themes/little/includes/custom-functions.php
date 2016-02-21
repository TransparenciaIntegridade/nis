<?php

add_theme_support( 'automatic-feed-links' );
add_editor_style();
add_theme_support( 
    'post-formats', 
    array(
        'aside',
        'gallery',
        'image',
        'link',
        'quote',
        'video',
        'audio'
    ) 
);

//add_custom_image_header();

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 600;

/*-----------------------------------------------------------------------------------*/
/*	Custom Menus
/*-----------------------------------------------------------------------------------*/
function register_main_menus() {
	register_nav_menus(
		array(
			'primary-nav' => __( 'Primary Nav','junkie' ),
			'secondary-nav' => __( 'Secondary Nav','junkie' ),
		)
	);
}

if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );



/*-----------------------------------------------------------------------------------*/
/*	Register and deregister Scripts files	
/*-----------------------------------------------------------------------------------*/
if(!is_admin()) {
	add_action( 'wp_print_scripts', 'my_deregister_scripts', 100 );
}

function my_deregister_scripts() {
		wp_deregister_script( 'jquery' );
		wp_enqueue_script('jquery', get_template_directory_uri().'/includes/js/jquery.js', false, '1.6.4');
		wp_enqueue_script('jquery-ui', get_template_directory_uri().'/includes/js/jquery-ui-1.8.5.custom.min.js', false, '1.8.5');
		wp_enqueue_script('jquery-imagesloaded', get_bloginfo('template_url').'/includes/js/jquery.imagesloaded.min.js', false, '1.0');	
		wp_enqueue_script('jquery-custom', get_template_directory_uri().'/includes/js/custom.js', false, '1.4.2');					
		wp_enqueue_script('jquery-jplayer', get_bloginfo('template_url').'/includes/js/jquery.jplayer.min.js', false, '1.0');
		wp_enqueue_script('jquery-flexslider', get_bloginfo('template_url').'/includes/js/jquery.flexslider-min.js', false, '1.0');
		wp_enqueue_script('jquery-superfish', get_template_directory_uri().'/includes/js/superfish.js', false, '1.4.2');		
		wp_enqueue_script('jquery-tipsy', get_bloginfo('template_url').'/includes/js/jquery.tipsy.js', false, '1.0');
		
		if(is_single() && (get_option('little_enable_share_buttons') =='on')) { 
			wp_enqueue_script('twitter-button', 'http://platform.twitter.com/widgets.js', false, '1.0');
			wp_enqueue_script('gpone-button', 'https://apis.google.com/js/plusone.js', false, '1.0');
		}


		if ( is_singular() && get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' );
}


if ( !function_exists( 'junkie_enqueue_admin_scripts' ) ) {
    function junkie_enqueue_admin_scripts() {
        wp_register_script( 'junkie-admin', get_template_directory_uri() . '/includes/js/jquery.custom.admin.js', 'jquery' );
        wp_enqueue_script( 'junkie-admin' );
    }
}
add_action( 'admin_enqueue_scripts', 'junkie_enqueue_admin_scripts' );


/*-----------------------------------------------------------------------------------*/
/*	Remove Image Caption from Index/Archive/Search Page
/*-----------------------------------------------------------------------------------*/
if (is_home() || is_archive() || is_search() ) {
	add_filter('img_caption_shortcode', create_function('$a, $b, $c','return $c;'), 10, 3);
} 

/*-----------------------------------------------------------------------------------*/
/*	Pagination
/*-----------------------------------------------------------------------------------*/
function junkie_pagination($prev = '&laquo;', $next = '&raquo;') {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'prev_text' => __($prev),
        'next_text' => __($next),
        'type' => 'plain'
);
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

    echo paginate_links( $pagination );
};

/*-----------------------------------------------------------------------------------*/
/*	Exclude Pages from Search Results
/*-----------------------------------------------------------------------------------*/
function junkie_exclude_pages($query) {
        if ($query->is_search) {
        $query->set('post_type', 'post');
                                }
        return $query;
}
add_filter('pre_get_posts','junkie_exclude_pages');

/*-----------------------------------------------------------------------------------*/
/*	Get Limit Excerpt
/*-----------------------------------------------------------------------------------*/
function junkie_content_limit($max_char, $more_link_text = '', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "";
      echo $content;
      echo "...";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "";
        echo $content;
        echo "...";
   }
   else {
      echo "";
      echo $content;
   }
}

/*-----------------------------------------------------------------------------------*/
/*	Comment Styling
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'junkie_comment' ) ) {
	function junkie_comment($comment, $args, $depth) {
	
	    $isByAuthor = false;
	
	    if($comment->comment_author_email == get_the_author_meta('email')) {
	        $isByAuthor = true;
	    }
	
        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(($isByAuthor ? 'author-comment' : '')); ?> id="li-comment-<?php comment_ID() ?>">

            <div id="comment-<?php comment_ID(); ?>">
                <div class="line"></div>
                
                <?php echo get_avatar($comment,$size='36'); ?>
                
                <div class="comment-author vcard">
                    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>', 'junkie'), get_comment_author_link()) ?>
                </div>

                <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'junkie'),'  ','') ?> / <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>

                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'junkie') ?></em>
                    <br />
                <?php endif; ?>

                <div class="comment-body">
                    <?php comment_text() ?>
                </div>

            </div>
	<?php
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Seperated Pings Styling
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'junkie_list_pings' ) ) {
	function junkie_list_pings($comment, $args, $depth) {
	    $GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
		<?php 
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Twitter Widget
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'junkie_twitter_script') ) {
	function junkie_twitter_script($unique_id,$username,$limit) {
	?>
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	
	    function twitterCallback2(twitters) {
	    
	      var statusHTML = [];
	      for (var i=0; i<twitters.length; i++){
	        var username = twitters[i].user.screen_name;
	        var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
	          return '<a href="'+url+'">'+url+'</a>';
	        }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
	          return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
	        });
	        statusHTML.push( '<li><span class="content">'+status+'</span> <a style="font-size:85%" class="time" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>' );
	      }
	      document.getElementById( 'twitter_update_list_<?php echo $unique_id; ?>').innerHTML = statusHTML.join( '' );
	    }
	    
	    function relative_time(time_value) {
	      var values = time_value.split( " " );
	      time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	      var parsed_date = Date.parse(time_value);
	      var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	      var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	      delta = delta + (relative_to.getTimezoneOffset() * 60);
	    
	      if (delta < 60) {
	        return 'less than a minute ago';
	      } else if(delta < 120) {
	        return 'about a minute ago';
	      } else if(delta < (60*60)) {
	        return (parseInt(delta / 60)).toString() + ' minutes ago';
	      } else if(delta < (120*60)) {
	        return 'about an hour ago';
	      } else if(delta < (24*60*60)) {
	        return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
	      } else if(delta < (48*60*60)) {
	        return '1 day ago';
	      } else {
	        return (parseInt(delta / 86400)).toString() + ' days ago';
	      }
	    }
	//-->!]]>
	</script>
	<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/<?php echo $username; ?>.json?callback=twitterCallback2&amp;count=<?php echo $limit; ?>&amp;include_rts=t"></script>
	<?php
	}
}

function junkie_save_tweet_link($id) {
	$url = sprintf('%s?p=%s', home_url().'/', $id);

	add_post_meta($id, 'tweet_trim_url_2', $url);
	
	return $url;
}

function junkie_the_tweet_link() {
	if (!$url = get_post_meta(get_the_ID(), 'tweet_trim_url_2', true)) {
	  $url = junkie_save_tweet_link(get_the_ID());
	}
	
	if ($old_url = get_post_meta(get_the_ID(), 'tweet_trim_url', true)) {
	  delete_post_meta(get_the_ID(), 'tweet_trim_url');
	}
	
	$output_url = sprintf(
	  'http://twitter.com/home?status=%s%s%s',
	  urlencode(get_the_title()),
	  urlencode(' - '),
	  $url
	);
	$output_url = str_replace('+','%20',$output_url);
	return $output_url;
}

/*-----------------------------------------------------------------------------------*/
/*	Turn a category ID to a Name
/*-----------------------------------------------------------------------------------*/
function cat_id_to_name($id) {
	foreach((array)(get_categories()) as $category) {
    	if ($id == $category->cat_ID) { return $category->cat_name; break; }
	}
}



/*-----------------------------------------------------------------------------------*/
/*  Output gallery slideshow 
/*
/*  @param int $postid the post id
/*  @param int/string $imagesize the image size 
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'junkie_gallery' ) ) {
    function junkie_gallery($postid, $imagesize, $slideshow = false, $thumbs = false) { 
        global $is_iphone;

        // if is_iphone do not display thumbs, save data :)
        $thumbs = ( $is_iphone ) ? false : $thumbs;

        if( $slideshow ) {
        ?>
            <script type="text/javascript">
        		jQuery(document).ready(function($){
        			$("#slider-<?php echo $postid; ?>").imagesLoaded( function() {
                        $("#slider-<?php echo $postid; ?>").flexslider({
        				    slideshow: false,
                            controlNav: false,
                            prevText: "<?php echo '&#8250;'; ?>",
                            nextText: "<?php echo '&#8249;'; ?>",
                            namespace: 'junkie-',
                            smoothHeight: true,
                            <?php if( $thumbs && !$is_iphone ) { ?>
                                controlNav: true,
                                manualControls: '#junkie-thumbs-nav-<?php echo $postid; ?> li',
                            <?php } ?>
                            start: function(slider) {
                                slider.container.click(function(e) {
                                    if( !slider.animating ) {
                                        slider.flexAnimate( slider.getTarget('next') );
                                    }
                                });
                            }
                        });
        			});
        		});
        	</script>
        <?php }

        $class = ( $slideshow ) ? ' class="flexslider"' : ' class="stacked"';
    
        // get all of the attachments for the post
        $args = array(
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_type' => 'attachment',
            'post_parent' => $postid,
            'post_mime_type' => 'image',
            'post_status' => null,
            'numberposts' => -1
        );
        $attachments = get_posts($args);
        if( !empty($attachments) ) {
            echo "<!-- BEGIN #slider-$postid -->\n<div id='slider-$postid'$class>";
            echo '<ul class="slides">';

            foreach( $attachments as $attachment ) {
                $src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
                $caption = $attachment->post_excerpt;
                $caption = ($caption) ? "<div class='slide-caption'>$caption</div>" : '';
                $alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
                echo "<li><div>$caption<img height='$src[2]' width='$src[1]' src='$src[0]' alt='$alt' /></div></li>";
            }

            echo '</ul>';
            echo "<!-- END #slider-$postid -->\n</div>";

            if( $thumbs ) {
                // add pagination
                echo '<ul id="junkie-thumbs-nav-' . $postid . '" class="junkie-thumbs-nav">';
                foreach( $attachments as $attachment ) {
                    $src = wp_get_attachment_image_src( $attachment->ID, 'portfolio-thumb');
                    echo "<li><img height='$src[2]' width='$src[1]' src='$src[0]' /><span class='preview-icon'></span></li>";
                }
                echo '</ul>';
            }
        }
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Output Audio
/* 
/*  @param int $postid the post id
/*  @param int $width the width of the audio player
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'junkie_audio' ) ) {
    function junkie_audio($postid, $width = 560, $height = 300) {
	
    	$mp3 = get_post_meta($postid, '_junkie_audio_mp3', TRUE);
    	$ogg = get_post_meta($postid, '_junkie_audio_ogg', TRUE);
    	$poster = get_post_meta($postid, '_junkie_audio_poster_url', TRUE);
    	$height = get_post_meta($postid, '_junkie_audio_height', TRUE);	
    ?>
    		<script type="text/javascript">
		
    			jQuery(document).ready(function($){
	
    				if( $().jPlayer ) {
    					$("#jquery-jplayer-audio-<?php echo $postid; ?>").jPlayer({
    						ready: function () {
    							$(this).jPlayer("setMedia", {
    							    <?php if($poster != '') : ?>
    							    poster: "<?php echo $poster; ?>",
    							    <?php endif; ?>
    							    <?php if($mp3 != '') : ?>
    								mp3: "<?php echo $mp3; ?>",
    								<?php endif; ?>
    								<?php if($ogg != '') : ?>
    								oga: "<?php echo $ogg; ?>",
    								<?php endif; ?>
    								end: ""
    							});
    						},
    						<?php if( !empty($poster) ) { ?>
    						size: {
            				    width: "<?php echo $width; ?>px",
            				    height: "<?php echo $height . 'px'; ?>"
            				},
            				<?php } ?>
    						swfPath: "<?php echo get_template_directory_uri(); ?>/js",
    						cssSelectorAncestor: "#jp-audio-interface-<?php echo $postid; ?>",
    						supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3<?php endif; ?>"
    					});
					
    				}
    			});
    		</script>
		
    	    <div id="jp-container-<?php echo $postid; ?>" class="jp-audio">
                <div class="jp-type-single">
                    <div id="jquery-jplayer-audio-<?php echo $postid; ?>" class="jp-jplayer" data-orig-width="<?php echo $width; ?>" data-orig-height="<?php echo $height; ?>"></div>
	                    <div class="jp-gui">                    
		                    <div id="jp-audio-interface-<?php echo $postid; ?>" class="jp-interface">
		                        <ul class="jp-controls">
		                            <li><a href="#" class="jp-play" tabindex="1" title="play">play</a></li>
		                            <li><a href="#" class="jp-pause" tabindex="1" title="pause">pause</a></li>
		                            <li><a href="#" class="jp-mute" tabindex="1" title="mute">mute</a></li>
		                            <li><a href="#" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
		                        </ul>
		                        <div class="jp-progress">
		                            <div class="jp-seek-bar">
		                                <div class="jp-play-bar"></div>
		                            </div>
		                        </div>
		                        <div class="jp-volume-bar">
		                            <div class="jp-volume-bar-value"></div>
		                        </div>
		                    </div>
	                    </div>
	                </div>
	          </div>
    	<?php 
    }
}


/*-----------------------------------------------------------------------------------*/
/*  Output video
/*
/*  @param int $postid the post id
/*  @param int $width the width of the video player
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'junkie_video' ) ) {
    function junkie_video($postid, $width = 560, $height = 300) {
	
    	$height = get_post_meta($postid, '_junkie_video_height', true);
    	$m4v = get_post_meta($postid, '_junkie_video_m4v', true);
    	$ogv = get_post_meta($postid, '_junkie_video_ogv', true);
    	$poster = get_post_meta($postid, '_junkie_video_poster_url', true);
	
    ?>
    <script type="text/javascript">
    	jQuery(document).ready(function($){
		
    		if( $().jPlayer ) {
    			$("#jquery-jplayer-video-<?php echo $postid; ?>").jPlayer({
    				ready: function () {
    					$(this).jPlayer("setMedia", {
    						<?php if($m4v != '') : ?>
    						m4v: "<?php echo $m4v; ?>",
    						<?php endif; ?>
    						<?php if($ogv != '') : ?>
    						ogv: "<?php echo $ogv; ?>",
    						<?php endif; ?>
    						<?php if ($poster != '') : ?>
    						poster: "<?php echo $poster; ?>"
    						<?php endif; ?>
    					});
    				},
    				size: {
                        cssClass: "jp-video-normal",
    				    width: "<?php echo $width ?>px",
    				    height: "<?php echo $height . 'px'; ?>"
    				},
    				swfPath: "<?php echo get_template_directory_uri(); ?>/js",
    				cssSelectorAncestor: "#jp-video-container-<?php echo $postid; ?>",
    				supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv<?php endif; ?>"
    			});

                $('#jquery-jplayer-video-<?php echo $postid; ?>').bind($.jPlayer.event.playing, function(event) {
                    $(this).add('#jp-video-interface-<?php echo $postid; ?>').hover( function() {
                        $('#jp-video-interface-<?php echo $postid; ?>').stop().animate({ opacity: 1 }, 400);
                    }, function() {
                        $('#jp-video-interface-<?php echo $postid; ?>').stop().animate({ opacity: 0 }, 400);
                    });
                });
                
                $('#jquery-jplayer-video-<?php echo $postid; ?>').bind($.jPlayer.event.pause, function(event) {
                    $('#jquery-jplayer-video-<?php echo $postid; ?>').add('#jp-video-interface-<?php echo $postid; ?>').unbind('hover');
                    $('#jp-video-interface-<?php echo $postid; ?>').stop().animate({ opacity: 1 }, 400);
                });
    		}
    	});
    </script>

    <div id="jp-video-container-<?php echo $postid; ?>" class="jp-video jp-video-normal">
        <div class="jp-type-single">
            <div id="jquery-jplayer-video-<?php echo $postid; ?>" class="jp-jplayer" data-orig-width="<?php echo $width; ?>" data-orig-height="<?php echo $height; ?>"></div>
            <div class="jp-gui">
            <div id="jp-video-interface-<?php echo $postid; ?>" class="jp-interface">
                <ul class="jp-controls">
                    <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                    <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                </ul>
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <?php }
}


/*-----------------------------------------------------------------------------------*/
/*	Twitter Widget
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'tj_twitter_script') ) {
	function tj_twitter_script($unique_id,$username,$limit) {
	?>
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	
	    function twitterCallback2(twitters) {
	    
	      var statusHTML = [];
	      for (var i=0; i<twitters.length; i++){
	        var username = twitters[i].user.screen_name;
	        var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
	          return '<a href="'+url+'">'+url+'</a>';
	        }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
	          return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
	        });
	        statusHTML.push( '<li><span class="content">'+status+'</span> <a style="font-size:85%" class="time" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>' );
	      }
	      document.getElementById( 'twitter_update_list_<?php echo $unique_id; ?>').innerHTML = statusHTML.join( '' );
	    }
	    
	    function relative_time(time_value) {
	      var values = time_value.split( " " );
	      time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	      var parsed_date = Date.parse(time_value);
	      var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	      var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	      delta = delta + (relative_to.getTimezoneOffset() * 60);
	    
	      if (delta < 60) {
	        return 'less than a minute ago';
	      } else if(delta < 120) {
	        return 'about a minute ago';
	      } else if(delta < (60*60)) {
	        return (parseInt(delta / 60)).toString() + ' minutes ago';
	      } else if(delta < (120*60)) {
	        return 'about an hour ago';
	      } else if(delta < (24*60*60)) {
	        return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
	      } else if(delta < (48*60*60)) {
	        return '1 day ago';
	      } else {
	        return (parseInt(delta / 86400)).toString() + ' days ago';
	      }
	    }
	//-->!]]>
	</script>
	<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/<?php echo $username; ?>.json?callback=twitterCallback2&amp;count=<?php echo $limit; ?>&amp;include_rts=t"></script>
	<?php
	}
}

function tj_save_tweet_link($id) {
	$url = sprintf('%s?p=%s', home_url().'/', $id);

	add_post_meta($id, 'tweet_trim_url_2', $url);
	
	return $url;
}

function tj_the_tweet_link() {
	if (!$url = get_post_meta(get_the_ID(), 'tweet_trim_url_2', true)) {
	  $url = tj_save_tweet_link(get_the_ID());
	}
	
	if ($old_url = get_post_meta(get_the_ID(), 'tweet_trim_url', true)) {
	  delete_post_meta(get_the_ID(), 'tweet_trim_url');
	}
	
	$output_url = sprintf(
	  'http://twitter.com/home?status=%s%s%s',
	  urlencode(get_the_title()),
	  urlencode(' - '),
	  $url
	);
	$output_url = str_replace('+','%20',$output_url);
	return $output_url;
}


?>