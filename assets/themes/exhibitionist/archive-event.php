<?php
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
add_action( 'genesis_before_loop', 'msdlab_do_cpt_archive_title_description' );
add_filter('genesis_link_post_title','msdlab_event_remove_link');
add_action('genesis_before_while','msdlab_event_open_collapsable');
add_action('genesis_before_entry','msdlab_event_maybe_open_panel');
add_action('genesis_after_entry','msdlab_event_maybe_close_panel');
add_action('genesis_after_endwhile','msdlab_event_close_collapsable');
add_action('genesis_entry_header','genesis_do_post_title'); //move the title out of the content area
add_action('genesis_entry_content','msdlab_event_date_and_location');

function msdlab_event_open_collapsable(){
    global $curmonth,$nextmonth;
    $curmonth = strtotime('first day of this month');
    $nextmonth = strtotime('first day of next month');
    print '<div class="wrap">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
}

function msdlab_event_maybe_open_panel(){
    global $wp_query,$post,$curmonth,$nextmonth;
    $post_meta = get_post_meta($post->ID);
    $datestamp = $post_meta['_event_event_datestamp'][0];
    if($wp_query->current_post == 0 && !is_paged()){
        print msdlab_event_open_panel($curmonth,true);
    }
    if($datestamp > $curmonth && $datestamp < $nextmonth){
        return false;
    } else {
        print '
                </div>
            </div>
        </div>';
        $curmonth = $nextmonth;
        $nextmonth = mktime(0, 0, 0, date("m",$curmonth)+1, date("d",$curmonth), date("Y",$curmonth));
        print msdlab_event_open_panel($curmonth);
    }
}

function msdlab_event_open_panel($curmonth,$active = false){
    $in = $active?' in':'';
    return '<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading'.date('FY', $curmonth).'">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.date('FY', $curmonth).'" aria-expanded="true" aria-controls="collapse'.date('FY', $curmonth).'">
          '.date('F Y', $curmonth).'
        </a>
      </h4>
    </div>
    <div id="collapse'.date('FY', $curmonth).'" class="panel-collapse collapse'.$in.'" role="tabpanel" aria-labelledby="heading'.date('FY', $curmonth).'">
      <div class="panel-body">';
}

function msdlab_event_close_collapsable(){
    print '
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

function msdlab_event_date_and_location(){
    global $post;
    $post_meta = get_post_meta($post->ID);
    $date = date('F d, Y',$post_meta['_event_event_datestamp'][0]);
    $venue = $post_meta['_event_venue'][0];
    print '<div class="event-date">'.$date.'</div><div class="event-venue">'.$venue.'</div>';
}

function msdlab_event_remove_link(){
    return false;
}

genesis();
?>