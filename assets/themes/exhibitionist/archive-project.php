<?php
//remove_action('genesis_loop','genesis_do_loop');
//add_action('genesis_loop', 'msdlab_portfolio_loop');
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
add_action( 'genesis_before_loop', 'msdlab_do_cpt_archive_title_description' );
add_action('wp_enqueue_scripts', 'msdlab_portfolio_add_scripts_and_styles');
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


function msdlab_portfolio_add_scripts_and_styles() {
    global $is_IE;
    if(!is_admin()){
        wp_enqueue_style('portfolio',get_stylesheet_directory_uri().'/lib/css/portfolio.css');
        wp_enqueue_style('adexfont',get_stylesheet_directory_uri().'/lib/css/custom-font.css');
        wp_enqueue_script('isotope',get_stylesheet_directory_uri().'/lib/js/isotope.pkgd.js',array('jquery'));
    }
}

function msdlab_portfolio_footer_scripts(){
    global $project_slugs;
    $slugs = implode(' ',$project_slugs);
    print '<script type="text/javascript">
        jQuery(window).load(function() {
            var hashID = window.location.hash.substring(1);
            var selector;
            if(hashID.length > 0){
                selector = "." + hashID;
                jQuery("#filters a[href=\"#" + hashID + "\"]").addClass("active");
            } else {
                selector = ".project";
            }
            var quantity = 8;
            jQuery("#portfolio-projects").isotope({
              itemSelector : ".type-project, .more-projects",
              layoutMode: "fitRows",
              filter: selector + ":lt(" + quantity + "), .more-projects",
            }); 
            
            // filter items when filter link is clicked
            jQuery("#filters a").click(function(){
              jQuery("#filters a").removeClass("active");
              jQuery(this).addClass("active");
              selector = jQuery(this).attr("data-filter");
              jQuery("#portfolio-projects").isotope({
                  filter: selector + ":lt(" + quantity + "), .more-projects",
                }); 
              return false;
            });
            jQuery("#more-projects").click(function(){
                  quantity = quantity + 9;
                  console.log("$(selector).length: " + jQuery(selector).length + "| quantity: " + quantity);
                  jQuery("#portfolio-projects").isotope({
                      filter: selector + ":lt(" + quantity + "), .more-projects",
                    }); 
                if(jQuery(selector).length < quantity){
                    jQuery("#more-projects").hide();
                }
            });
            jQuery( window ).scroll(function() {
                jQuery("#portfolio-projects").isotope();
            });
        });
    jQuery(document).ready(function($) {
            jQuery("article").mouseenter(function(){
                var bkg = $(this).find(".image-widget-background");
                $(this).find(".fuzzybubble").blurjs({
                radius: 10,
                source: bkg, 
                });
            });
        });
    </script>';
}

function msdlab_project_filter(){
    global $project_slugs;
   $terms = get_terms('project_type',array('orderby'=>'slug','order'=>'ASC','hide_empty'=>false));
   foreach($terms AS $term){
       $filters[] = '<a href="#'.$term->slug.'" data-filter=".'.$term->slug.'" class="filter filter-'.$term->slug.'"><i class="fa-3x adex-'.$term->slug.'"></i>'.$term->name.'</a>';
       $project_slugs[] = $term->slug;
   }
   $menu = '<div id="filters" class="wrap">'.implode(' ', $filters).'</div>';
   print $menu;
}


function msdlab_project_open_portfolio(){
    print '<div id="portfolio-projects" class="wrap">';
}
function msdlab_project_close_portfolio(){
    print '<article id="more-projects" class="more-projects">
    <div style="height: 370px;width:370px;background:url('.get_stylesheet_directory_uri().'/lib/img/plus.png'.') no-repeat center center #D5D5D5;">
        <div style="position: absolute;bottom:10px;right:20px">+ Load More</div>
    </div>
    </article>';
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
    if(get_the_content()){
        echo apply_filters( 'genesis_post_permalink', sprintf( '<p class="entry-permalink"><a href="%s" rel="bookmark">%s</a></p>', esc_url( $permalink ), __('View More') ) );
    }
}
?>