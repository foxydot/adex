<?php
//remove_action('genesis_loop','genesis_do_loop');
//add_action('genesis_loop', 'msdlab_portfolio_loop');
add_action('genesis_before_loop','msdlab_alter_loop_params');
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
add_action( 'genesis_before_loop', 'msdlab_do_cpt_archive_title_description' );
add_action('wp_enqueue_scripts', 'msdlab_portfolio_add_scripts');
remove_all_actions('genesis_entry_header');
add_action('genesis_entry_header','msdlab_project_open_entry');
remove_all_actions('genesis_entry_content');
add_action('genesis_entry_content','genesis_do_post_title');
add_action('genesis_entry_content','msdlab_do_project_header');
add_action('genesis_entry_content','msdlab_do_post_permalink');
remove_all_actions('genesis_entry_footer');
add_action('genesis_entry_footer','msdlab_project_close_entry');
//remove_all_actions('genesis_loop');


add_action('genesis_before_while','msdlab_project_filter');
add_action('genesis_before_while','msdlab_project_open_portfolio');
add_action('genesis_after_endwhile','msdlab_project_close_portfolio');

//remove_action('genesis_entry_header','msdlab_project_header_info');
add_filter('genesis_attr_entry','msdlab_portfolio_wrapper');

add_action('wp_footer','msdlab_portfolio_footer_scripts');
    global $wp_filter;
    //ts_var( $wp_filter['genesis_entry_content'] );
    
//add_action('genesis_loop','msdlab_portfolio_loop');
genesis();

function msdlab_alter_loop_params(){
    global $query_string;
    query_posts($query_string . "&orderby=rand");
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

function msdlab_portfolio_wrapper($attributes){
    global $post;
    $terms = wp_get_post_terms($post->ID,'project_type');
    $project_types = '';
    if(count($terms)>0){
        foreach($terms AS $term){
            $project_types[] = $term->slug;
        }
        $project_types = implode(' ', $project_types);
    }
    $attributes['class'] .= ' '.$post->post_name.' '.$project_types;
    $attributes['href'] = get_post_permalink($post->ID);
    return $attributes;
}


function msdlab_portfolio_add_scripts() {
    global $is_IE;
    if(!is_admin()){
        wp_enqueue_script('isotope',get_stylesheet_directory_uri().'/lib/js/isotope.pkgd.js',array('jquery'));
    }
}

function msdlab_portfolio_footer_scripts(){
    print '<script type="text/javascript">
        jQuery(window).load(function() {
            jQuery("#portfolio-projects").isotope({
              itemSelector : ".type-project",
              layoutMode: "fitRows",
            }); 
            
            // filter items when filter link is clicked
            jQuery("#filters a").click(function(){
              jQuery("#filters a").removeClass("active");
              jQuery(this).addClass("active");
              var selector = jQuery(this).attr("data-filter");
              jQuery("#portfolio-projects").isotope({
                  itemSelector : ".type-project",
                  layoutMode : "fitRows",
                  filter: selector
                }); 
              return false;
            });   
            jQuery( window ).scroll(function() {
                jQuery("#portfolio-projects").isotope();
            });
        });
    jQuery(document).ready(function($) {
            jQuery("article").mouseenter(function(){
                var bkg = $(this).find(".image-widget-background");
                $(this).find(".fuzzybubble").blurjs({
                radius: 20,
                source: bkg, 
                });
            });
        });
    </script>';
}

function msdlab_project_filter(){
   $terms = get_terms('project_type',array('orderby'=>'slug','order'=>'ASC','hide_empty'=>false));
   foreach($terms AS $term){
       $filters[] = '<a href="#" data-filter=".'.$term->slug.'" class="filter filter-'.$term->slug.'"><i class="fa fa-3x fa-calendar"></i>'.$term->name.'</a>';
   }
   $menu = '<div id="filters" class="wrap">'.implode(' ', $filters).'</div>';
   print $menu;
}


function msdlab_project_open_portfolio(){
    print '<div id="portfolio-projects" class="wrap">';
}
function msdlab_project_close_portfolio(){
    print '</div>';
}

function msdlab_project_open_entry(){
    global $post;
    print '<div class="image-widget-background '.$post->post_name.'" style="background-image: url('.msdlab_get_thumbnail_url($post->ID,'project-thumbnail').')">
    <div class="fuzzybubble">';
}
function msdlab_project_close_entry(){
    print '</div>
    </div>';
}
function msdlab_do_post_permalink() {

    //* Don't show on singular views, or if the entry has a title
    if ( is_singular() )
        return;

    $permalink = get_permalink();

    echo apply_filters( 'genesis_post_permalink', sprintf( '<p class="entry-permalink"><a href="%s" rel="bookmark">%s</a></p>', esc_url( $permalink ), __('View More') ) );

}
?>