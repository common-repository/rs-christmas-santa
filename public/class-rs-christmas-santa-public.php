<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://therssoftware.com
 * @since      1.0.0
 *
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/public
 * @author     khorshed Alam <robelsust@gmail.com>
 */
class Rs_Christmas_Santa_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
     * Show audio music on front-end. rs_christmas_santa
     * @since    1.0.0
     * @access   public
     */
    public function rs_christmas_santa_show_audio() {
        $christmas_schedule_before_date = esc_attr(get_option('rs_christmas_santa_schedule_before_date'));
        $christmas_schedule_active = esc_attr(get_option('rs_christmas_santa_schedule_active'));
        
        if ($christmas_schedule_active == 1) {
            $schedule_time = explode(" ", $christmas_schedule_before_date);
            $schedule_time_first_index = $schedule_time[0];
            $schedule_time_last_index = $schedule_time[1];
            $now_date = time();
            $year = gmdate('Y');
            
            if ($schedule_time_last_index == 'day') {
                $christmas_date = strtotime($year . '-12-25');
                $upcoming_christmas_date = $christmas_date - $now_date;
                $schedule_date = round($schedule_time_first_index * (60 * 60 * 24));
                if ($upcoming_christmas_date <= $schedule_date) {
                    $this->rs_christmas_santa_music_activities();
                }
            } else {
                $christmas_date = strtotime($year . '-12-25 00:00:00');
                $upcoming_christmas_date = $christmas_date - $now_date;
                $schedule_date = round($schedule_time_first_index * (60 * 60));
                if ($upcoming_christmas_date <= $schedule_date) {
                    $this->rs_christmas_santa_music_activities();
                }
            }
        } else {
            $this->rs_christmas_santa_music_activities();
        }
    }

    /**
     * Show audio music on front-end.
     * @since    1.0.0
     * @access   public
     */
    public function rs_christmas_santa_music_activities() {
        $music_activation = esc_attr(get_option('rs_christmas_santa_music_activation'));
        $music_item = esc_attr(get_option('rs_christmas_santa_music_item'));
        $music_show_on_page = (get_option('rs_music_show_on_page'));
        $page_id = $this->wp_get_inspect_page_id();

        // Check if music is activated and should be shown on this page
        if ($music_activation == 1 && (empty($music_show_on_page) || in_array($page_id, $music_show_on_page))) {
            $audio_close = '';
            $class_audio = 'rs_audio';
            $audio_controls = 'rs_audio-controls';
            $pop_up_position = esc_attr(get_option('rs_christmas_santa_pop_up_position'));

            // Set the position for the close button
            $audio_close = ($pop_up_position == 1) ? 'rs_audio-close-left' : 'rs_audio-close-right';

            // Use the uploads directory for the audio file
            $upload_dir = wp_upload_dir();
            $audio_url = trailingslashit($upload_dir['baseurl']) . 'rs-christmas-santa';
            $image_url = plugin_dir_url(__FILE__) . 'images';
           
            // Close button image URL
            $btnUrl = trailingslashit($image_url) . 'close-btn/x_button.png';
 
            // Output the HTML for the audio player
            echo '<div id="rs_audio_div" class="' . esc_attr($class_audio) . '">';
            echo '<div id="rs_audio_close" class="' . esc_attr($audio_close) . '">';
            echo '<img src="' . esc_url($btnUrl) . '" alt="Close">';
            echo '</div>';
            echo '<audio id="mytrack" class="' . esc_attr($audio_controls) . '" onloadeddata="myOnLoadedData()">';
            echo '<source src="' . esc_url($audio_url) . '/' . esc_attr($music_item) . '" type="audio/mp3">';
            echo '</audio>';
            echo '
                <nav class="rs_audio-nav">
                    <div id="rs_defaultBar">
                        <div id="rs_progressBar"></div>
                    </div>
                    <div id="rs_buttons">
                        <button type="button" id="rs_playButton"></button>
                        <span id="rs_currentTime">0:00</span> / <span id="rs_fullDuration">0:00</span>
                    </div>
                </nav>';
            echo '</div>';

            // Enqueue the music control script
            $this->enqueue_music_script($image_url);
        }
    }


    public function enqueue_music_script($audio_url) {
        // Make sure jQuery is enqueued if your JavaScript relies on it
        wp_enqueue_script('jquery');

        // Enqueue your audio script with a version based on file modification time
        $script_path = plugin_dir_path(__FILE__) . 'js/rs_audio_script.js';
        $script_version = file_exists($script_path) ? filemtime($script_path) : null;

        wp_enqueue_script('rs_audio_script', plugin_dir_url(__FILE__) . 'js/rs_audio_script.js', array('jquery'), $script_version, true);

        // Add inline script for setting the templateUrl variable
        $inline_script = 'var templateUrl = "' . esc_url($audio_url) . '";';
        wp_add_inline_script('rs_audio_script', $inline_script);
    }



    /**
     * Get current page.
     * Return the current page id.
     * @since    1.0.0
     * @access   public
     */
    public function wp_get_inspect_page_id() {
        $page_id = get_queried_object_id();
        return $page_id;
    }
    /**
     * short code count down action hook register.
     * @since    1.0.0
     * @access   public
     */
    public function rs_christmas_santa_count_down_action(){
        add_shortcode( 'rs_christmas_santa_count_down',array($this,'rs_christmas_santa_count_down') );
    }
    /**
     * Show count down on front-end short code.
     * @since    1.0.0
     * @access   public
     */
    public function rs_christmas_santa_count_down($atts,$content=null){
        ob_start();
        $christmas_countdown_active = esc_attr( get_option( 'rs_christmas_santa_countdown_active' ) );
        $christmas_countdown_after_text = esc_attr( get_option( 'rs_christmas_santa_countdown_after_text' ) );
        $christmas_countdown_before_text = esc_attr( get_option( 'rs_christmas_santa_countdown_before_text' ) );
        $christmas_countdown_type = esc_attr( get_option( 'rs_christmas_santa_countdown_type' ) );
        $url =  plugin_dir_url(__FILE__).'images/count-down';
        $now_date = time(); // or your date as well
        $year = gmdate('Y');
        $christmas_date = strtotime($year.'-12-25');
        $date_diff = $christmas_date - $now_date ;
        $upcoming_date = round($date_diff / (60 * 60 * 24));
        if ($christmas_countdown_active == 1) {
            echo '
                    <div class="rs_count-down-main"> 
                    <div class="rs_cr-count-down"> 
                    <img src="'.esc_url($url).'/'.esc_attr($christmas_countdown_type).'">
                    <div class="rs_cr-count-down-content"> 
                    <p>'.esc_attr($christmas_countdown_before_text).'
                    <strong style="color: #e12e20;font-size: 30px;padding: 25px 0px;line-height: 27px;">'.esc_attr($upcoming_date).' Days</strong>
                    '.esc_attr($christmas_countdown_after_text).'</p>
                    </div>
                    </div>    
                    </div>
                    ';
        }
        return ob_get_clean();
    }
    /**
     * Show pop-up santa design on front-end.
     * @since    1.0.0
     * @access   public
     */
    public function rs_christmas_santa_show_pop_up(){
        $christmas_schedule_before_date = esc_attr(get_option( 'rs_christmas_santa_schedule_before_date' ));
        $christmas_schedule_active = esc_attr(get_option( 'rs_christmas_santa_schedule_active' ));
        if ($christmas_schedule_active == 1) {
            $schedule_time = (explode(" ",$christmas_schedule_before_date));
            $schedule_time_first_index = $schedule_time[0];
            $schedule_time_last_index = $schedule_time[1];
            $now_date = time();
            $year = gmdate('Y');
            if ($schedule_time_last_index == 'day') {
                $christmas_date = strtotime($year.'-12-25');
                $upcoming_christmas_date = $christmas_date - $now_date ;
                $upcoming_date = round($schedule_time_first_index  *(60 * 60 * 24));
                if ($upcoming_christmas_date <= $upcoming_date) {
                    $this->rs_christmas_santa_activities();
                }
            }else {
                $christmas_date = strtotime($year.'-12-25 00:00:00');
                $upcoming_christmas_date = $christmas_date - $now_date;
                $upcoming_date = round($schedule_time_first_index  *(60 * 60));
                if ($upcoming_christmas_date <= $upcoming_date) {
                    $this->rs_christmas_santa_activities();
                }
            }
        }else {
            $this->rs_christmas_santa_activities();
        }
    }
    /**
     * Show pop-up santa design on front-end.
     * @since    1.0.0
     * @access   public
     */
    public function rs_christmas_santa_activities(){
       
        $awesome_santa = esc_attr( get_option( 'rs_christmas_santa_awesome_santa' ) );
        $awesome_santa_flying = esc_attr( get_option( 'rs_christmas_santa_awesome_santa_flying' ) );
        $awesome_santa_flying_type = esc_attr( get_option( 'rs_christmas_santa_awesome_santa_flying_type' ) );
        $awesome_santa_show_on_page = ( get_option( 'rs_christmas_santa_awesome_santa_show_on_page' ) );
        $page_id = $this->wp_get_inspect_page_id();
        if ($awesome_santa == 1) {
            $url =  plugin_dir_url(__FILE__).'images/pop-up';
            $btnUrl = str_replace("pop-up", "", esc_url($url) ).'close-btn';
            $music_activation = esc_attr(get_option( 'rs_christmas_santa_music_activation' ));
            $bottom='';
            $pop_up_class_right = 'rs_pop-up-class-right';

            $pop_up_class_left = 'rs_pop-up-class-left';
            $pop_up_type = esc_attr(get_option( 'rs_christmas_santa_pop_up_type' ));
            $pop_up_position = esc_attr( get_option( 'rs_christmas_santa_pop_up_position' ) );
            
            if ($awesome_santa_show_on_page == '') {
                if ($awesome_santa_flying == 1) {
                    echo "<div id=\"rs_pop_up\" class=\"rs_flying-santa animated ".esc_attr($awesome_santa_flying_type)."\">";
                    echo '<div  id="rs_pop_up_close" class="rs_pop-up-close">';
                    echo "<img src=\"".esc_url($btnUrl)."/x_button.png\">";
                    echo '</div>';
                    echo "<img class=\"rs_pop-up-img\" src=\"".esc_url($url)."/".esc_attr($pop_up_type)."\">";
                    echo '</div>';
                }else {
                    if ($music_activation == 1 ) {
                        $bottom = 'rs_pop-up-bottom-m-music';
                    }else {
                        $bottom = 'rs_pop-up-bottom-m';
                    }
                    if ($pop_up_position == 1) {
                        echo "<div id=\"rs_pop_up\" class=\"".esc_attr($pop_up_class_right)." ".esc_attr($bottom)."\">";
                        echo '<div  id="rs_pop_up_close" class="rs_pop-up-close" style="">';
                        echo "<img src=\"".esc_url($btnUrl)."/x_button.png\">";
                        echo '</div>';
                        echo "<img class=\"rs_pop-up-img\"  src=\"".esc_url($url)."/".esc_attr($pop_up_type)."\">";
                        echo '</div>';
                    }else {
                        echo "<div id=\"rs_pop_up\" class=\"".esc_attr($pop_up_class_left)." ".esc_attr($bottom)."\">";
                        echo '<div  id="rs_pop_up_close" class="rs_pop-up-close" style="">';
                        echo "<img src=\"".esc_url($btnUrl)."/x_button.png\">";
                        echo '</div>';
                        echo "<img class=\"rs_pop-up-img\"  src=\"".esc_url($url)."/".esc_attr($pop_up_type)."\">";
                        echo '</div>';
                    }
                }
            }else {
                if(in_array($page_id,$awesome_santa_show_on_page)) {
                    if ($awesome_santa_flying == 1) {
                        echo "<div id=\"rs_pop_up\" class=\"rs_flying-santa animated ".esc_attr($awesome_santa_flying_type)."\">";
                        echo '<div  id="rs_pop_up_close" class="rs_pop-up-close">';
                        echo "<img src=\"".esc_url($btnUrl)."/x_button.png\">";
                        echo '</div>';
                        echo "<img class=\"rs_pop-up-img\" src=\"".esc_url($url)."/".esc_attr($pop_up_type)."\">";
                        echo '</div>';
                    }else {
                        if ($music_activation == 1 ) {
                            $bottom = 'rs_pop-up-bottom-m-music';
                        }else {
                            $bottom = 'rs_pop-up-bottom-m';
                        }
                        if ($pop_up_position == 1) {
                            echo "<div id=\"rs_pop_up\" class=\"".esc_attr($pop_up_class_right)." ".esc_attr($bottom)."\">";
                            echo '<div  id="rs_pop_up_close" class="rs_pop-up-close" style="">';
                            echo "<img src=\"".esc_url($btnUrl)."/x_button.png\">";
                            echo '</div>';
                            echo "<img class=\"rs_pop-up-img\" src=\"".esc_url($url)."/".esc_attr($pop_up_type)."\">";
                            echo '</div>';
                        }else {
                            echo "<div id=\"rs_pop_up\" class=\"".esc_attr($pop_up_class_left)." ".esc_attr($bottom)."\" >";
                            echo '<div  id="rs_pop_up_close" class="rs_pop-up-close" style="">';
                            echo "<img src=\"".esc_url($btnUrl)."/x_button.png\">";
                            echo '</div>';
                            echo "<img class=\"rs_pop-up-img\"  src=\"".esc_url($url)."/".esc_attr($pop_up_type)."\">";
                            echo '</div>';
                        }
                    }
                }
            }
        }
    }
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rs_Christmas_Santa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rs_Christmas_Santa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( !is_admin() ) {
            // Check if it's the front end
            if (is_front_page() || is_page()) {
                // Enqueue animate.min.css only on specific pages or posts
                wp_enqueue_style( $this->plugin_name . 'animate.min', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

                // Enqueue rs-christmas-santa-public.css only on specific pages or posts
                wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rs-christmas-santa-public.css', array(), $this->version, 'all' );
            }
        }

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() { 
		if ( !is_admin() ) {
            // Check if it's the front end
             if (is_front_page() || is_page()) {
                // Enqueue audio.js only on specific pages or posts
                wp_enqueue_script($this->plugin_name . 'audio-js', plugin_dir_url(__FILE__) . 'js/audio.js', array('jquery'), $this->version, true);

                // Enqueue rs-christmas-santa-public.js only on specific pages or posts
                wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/rs-christmas-santa-public.js', array('jquery'), $this->version, true);
            }
        }

	}

    function rs_add_async_attribute( $tag, $handle ) { 

        if ($this->plugin_name.'audio-js' === $handle ) {
            return str_replace( '<script ', '<script async ', $tag );
        }
        if ( $this->plugin_name === $handle ) {
            return str_replace( '<script ', '<script async ', $tag );
        }

       return $tag;
    } 

}
