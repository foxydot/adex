<?php
if (!class_exists('MSDEventShortcodes')) {
    class MSDEventShortcodes {
        //Properties
        var $cpt = 'event';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDEventShortcodes(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            add_shortcode('upcoming_events', array(&$this,'event_display'));
        }
        
        function event_display($atts){
            switch($atts['display']){
                case 'upcoming':
                    return $this->upcoming_events($atts);
                    break;
            }
        }
        
        function upcoming_events($atts){
            global $date_info,$location_info;
            extract( shortcode_atts( array(
                'months' => '3',
                'number_posts' => -1
            ), $atts ) );
            $args = array(
                'posts_per_page' => $number_posts,
                'post_type' => $this->cpt,
                'meta_query' => array(
                    array(
                        'key' => '_date_event_datestamp',
                        'value' => time()-86400,
                        'compare' => '>'
                    ),
                    array(
                        'key' => '_date_event_datestamp',
                        'value' => mktime(0, 0, 0, date("m")+$months, date("d"), date("Y")),
                        'compare' => '<'
                    )
                )
            );
            $events = get_posts($args);
            $i = 0;
            foreach($events AS $up){
                $date_info->the_meta($up->ID);
                $location_info->the_meta($up->ID);
                $events[$i]->event_date = $date_info->get_the_value('event_datestamp');
                $events[$i]->venue = $location_info->get_the_value('venue');
                $events[$i]->address = $location_info->get_the_value('address');
                $i++;
            }
            usort($events,array(&$this,'sort_by_event_date'));
            $ret = '<div class="msdlab_upcoming_events">';
            if ( !empty( $events ) ):
            $ret .= '
            <ul class="msd_upcoming_event_list ui-listview" data-role="listview" data-filter="true">
                <li class="list_row_header row-fluid">
                    <div class="event-type span4">Event Type</div>            
                    <div class="event-date span2">Date</div>
                    <div class="event-location span2">Location</div>
                    <div class="event-seeker span2">Candidate</div>
                    <div class="event-employer span2">Employer</div>
               </li>';
            foreach ( $events as $event ):
            $allmeta = $event->event_type.' '.$event->event_category.' '.$event->event_location.' '.$event->event_location.' '.$event->address[0]['city'].' '.$event->address[0]['state'].' '.$event->address[0]['zip'].' '.date( "m-d-Y", $event->event_date).' '.date( "F", $event->event_date );
            $candidate_link = $event->address[0]['access_url']!=''?$event->address[0]['access_url']:get_post_permalink($event->ID).'#tab_job-seeker';
            $candidate_target = $event->address[0]['access_url']!=''?'_blank':'_self';
            $ret .= '
            <li class="list_row row-fluid" id="targeted_event_'.$event->ID.'"  href="'.get_post_permalink($event->ID).'"  data-filtertext="'.$allmeta.'">
                <div class="event-type span4">'.$event->event_category.'</div>            
                <div class="event-date span2">'.date( "m-d-Y", $event->event_date ).'</div>
                <div class="event-location span2">'.$event->event_location.'</div>
                <div class="event-seeker span2"><a href="'.$candidate_link.'" target="'.$candidate_target.'">Candidate </a></div>
                <div class="event-employer span2"><a href="'.get_post_permalink($event->ID).'#tab_employer-registration-information">Employer</a></div>
           </li>';
            endforeach;
                $ret .= '
                </ul>';
            else:
                $ret .= '<p>No Upcoming Events</p>';
            endif;
            $ret .= '</div>';
            return $ret;
        }
        
        function sort_by_event_date( $a, $b ) {
            return $a->event_date == $b->event_date ? 0 : ( $a->event_date > $b->event_date ) ? 1 : -1;
        }
    }
}