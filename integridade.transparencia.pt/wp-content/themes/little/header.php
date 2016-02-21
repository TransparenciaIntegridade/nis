<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes( 'xhtml' ); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php tj_custom_titles(); ?></title>
<?php tj_custom_description(); ?>
<?php tj_custom_keywords(); ?>
<?php tj_custom_canonical(); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/colors/<?php echo get_option('little_theme_stylesheet');?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/media-queries.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/custom.css" />
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>	
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<header id="header" class="clearfix">

		<div class="container clearfix">

			<?php if (get_option('little_text_logo_enable') == 'on') { ?>
				<div id="text-logo">
					<h1 id="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?>.</a></h1>
					<p id="site-desc"><?php bloginfo('description'); ?></p>
				</div><!-- #text-logo -->
			<?php } else { ?>
				<a href="<?php bloginfo('url'); ?>"><?php $logo = (get_option('little_logo') <> '') ? get_option('little_logo') : get_bloginfo('template_directory').'/images/logo.png'; ?><img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>" id="logo"/></a>
			<?php }?>

			

			<div class="clearfix"></div>
			
			<nav id="primary-nav">

                <?php 
                	$menuClass = 'nav';
	                $menuID = 'primary-navigation';
	                $primaryNav = '';
	                if (function_exists('wp_nav_menu')) {
	                    $primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-nav', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
                }; ?>
                
                <span class="header-search">
                    <i class="icon-search"> <span><?php _e('Search', 'junkie') ?></span></i>
                    <i class="icon-remove"> <span><?php _e('Search', 'junkie') ?></span></i>
                </span><!-- .header-search -->
                
                <?php if ($primaryNav == '') { ?>
                    <ul id="<?php echo $menuID; ?>" class="<?php echo $menuClass; ?>">
                        <?php if (get_option('little_home_link') == 'on') { ?>
                                <li class="nav-home <?php if(!is_page()) echo('first');?>"><a href="<?php echo home_url(); ?>"><?php _e('Home', 'junkie') ?></a></li>
                        <?php } ?>                        
                        <?php show_page_menu($menuClass,false,false); ?>
                    </ul>
                    
                <span class="header-search">
                    <i class="icon-search"> <span><?php _e('Search', 'junkie') ?></span></i>
                    <i class="icon-remove"> <span><?php _e('Search', 'junkie') ?></span></i>
                </span><!-- .header-search -->
                
                <?php } else echo($primaryNav); ?>
                
                <?php get_search_form(); ?>

                <a class="button-menu" id="toggle" href="#"></a>

            </nav><!-- #primary-nav -->

		</div><!-- .container -->
	
	</header><!-- #header -->

	<div class="container clearfix">
	
	<?php if(get_option('little_content_ad_enable') == 'on') { ?>
	<div class="content-ad">
		<?php echo get_option('little_content_ad_code'); ?>
	</div><!-- .content-ad -->
	<?php } ?>