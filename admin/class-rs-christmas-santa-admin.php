<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://therssoftware.com
 * @since      1.0.0
 *
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/admin
 * @author     khorshed Alam <robelsust@gmail.com>
 */
class Rs_Christmas_Santa_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	/**
     * This is setting section fields
     *
     * @since    1.0.0
     * @access   public
     * @var      array
     */
  
    public $santaSettings = array();
    public $santaSections = array();
    public $santaFields = array();
    public $musicSettings = array();
    public $musicSections = array();
    public $musicFields = array();
    public $countDownSettings = array();
    public $countDownSections = array();
    public $countDownFields = array();
    public $scheduleSettings = array();
    public $scheduleSections = array();
    public $scheduleFields = array(); 


    /**
     * Create theme and menu page.
     *
     * @since    1.0.0
     * @param      None.
     */

    public function rs_christmas_santa() { 

        add_menu_page(
            'Rs Christmas Santa',                    // The value used to populate the browser's title bar when the menu page is active
            __('Rs Christmas Santa','rs-christmas-santa'),                    // The text of the menu in the administrator's sidebar
            'administrator',                    // What roles are able to access the menu
            'rs-christmas-santa',               // The ID used to bind submenu items to this menu
            array($this,'rs_christmas_santa_theme_display') ,   // The callback function used to render this menu
            'dashicons-buddicons-groups',
            80
        );
    }

    /**
     * Display nav bar.
     *
     * @since    1.0.0
     * @param      string.
     */
    public function rs_christmas_santa_theme_display($active_tab = '')
    {
        ?>
        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">
            <div id="icon-themes" class="icon32"></div>
            <h2 style="color:#226c5e; font-weight: bold;">Rs Christmas <span style="color:#bc1d2b"> Santa </span></h2>
            <?php settings_errors(); ?>

            <?php
            $rs_christmas_santa_tabs = [
                
                'rs_santa_pop_up' => __("Santa Pop-Up", "rs-christmas-santa"),
                'rs_music' => __("Music", "rs-christmas-santa"),
                'rs_count_down' => __("Count Down", "rs-christmas-santa"),
                'rs_christmas_santa_schedule' => __("Christmas Schedule", "rs-christmas-santa"),
            ];

         

            
          
            $active_tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'rs_santa_pop_up';


            ?>

          
            <h2 class="nav-tab-wrapper">
                <?php foreach ($rs_christmas_santa_tabs as $rs_christmas_santa_tab => $rs_christmas_santa_label): ?>
                    <a href="<?php echo esc_url(add_query_arg('tab', esc_attr($rs_christmas_santa_tab), admin_url('admin.php?page=rs-christmas-santa'))); ?>" class="nav-tab <?php echo $active_tab == $rs_christmas_santa_tab ? 'nav-tab-active' : ''; ?>">
                        <?php echo esc_html($rs_christmas_santa_label); ?>
                    </a>
                <?php endforeach; ?>
            </h2>
            <form method="post" action="options.php">
                <div class="ss_col">
                    <div class="ss_left_col">
                        <?php
                        $settings_groups = [
                             
                            'rs_santa_pop_up' => 'rs_christmas_santa_options_group',
                            'rs_music' => 'rs_christmas_santa_music_options_group',
                            'rs_count_down' => 'rs_christmas_santa_countdown_options_group',
                            'rs_christmas_santa_schedule' => 'rs_christmas_santa_schedule_options_group',
                        ];

                        $sections = [
                            
                            'rs_santa_pop_up' => 'rs_christmas_santa_pop_up_option',
                            'rs_music' => 'rs_christmas_santa_music_option',
                            'rs_count_down' => 'rs_christmas_santa_count_down_option',
                            'rs_christmas_santa_schedule' => 'rs_christmas_santa_schedule_option',
                        ];

                        settings_fields($settings_groups[$active_tab]);
                        do_settings_sections($sections[$active_tab]);
                        submit_button();
                        ?>
                    </div>
                    <div class="ss_right_col">
                        <div class="ss_right_content">
                            <div class="logo_top"><img src="<?php echo esc_url(plugins_url('logo.png', __FILE__)); ?>"></div>
                            <div class="ss_extracontent">
                                <h3>Need Help?</h3>
                                <a class="underline" target="_blank" href="#">Support forum</a><br>
                                <a class="underline" target="_blank" href="#">Contact us for customization</a><br>
                                <a class="underline" target="_blank" href="#">WordPress Plugins by Rssoftware</a><br>
                                <a class="underline" target="_blank" href="#">WordPress Themes by Rssoftware</a><br>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.wrap -->
        <?php
    }


    // end sandbox_theme_display
  

    /**
     * Create option  settings for pop up.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_santa_settings() {
        $settings = [
            'rs_christmas_santa_pop_up_type',
            'rs_christmas_santa_pop_up_position',
            'rs_christmas_santa_awesome_santa',
            'rs_christmas_santa_awesome_santa_flying',
            'rs_christmas_santa_awesome_santa_flying_type',
            'rs_christmas_santa_awesome_santa_show_on_page',
        ];

        $args = array_map(function($option_name) {
            return [
                'option_group' => 'rs_christmas_santa_options_group',
                'option_name' => $option_name,
            ];
        }, $settings);

        $this->rs_christmas_santa_settings($args);
    }

    /**
     * Create option  section for pop up.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_santa_sections(){
        $args = array(
            array(
                'id' => 'rs_christmas_santa_index',
                'page' => 'rs_christmas_santa_pop_up_option'
            )
        );
        $this->rs_christmas_santa_sections( $args );
    }
    /**
     * Create option  fields for pop up.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_santa_fields() {
        $fields = [
            'rs_christmas_santa_awesome_santa',
            'rs_christmas_santa_awesome_santa_flying',
            'rs_christmas_santa_awesome_santa_flying_type',
            'rs_christmas_santa_awesome_santa_show_on_page',
            'rs_christmas_santa_pop_up_type',
            'rs_christmas_santa_pop_up_position',
        ];

        $args = array_map(function($id) {
            return [
                'id' => $id,
                'title' => '',
                'callback' => [ $this, $id ],
                'page' => 'rs_christmas_santa_pop_up_option',
                'section' => 'rs_christmas_santa_index',
                'args' => [
                    'label_for' => $id,
                    'class' => 'example-class'
                ]
            ];
        }, $fields);

        $this->rs_christmas_santa_fields($args);
    }

    /**
     * Create option  settings for music.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_music_settings() {
        $optionNames = [
            'rs_christmas_santa_music_item',
            'rs_christmas_santa_music_activation',
            'rs_music_show_on_page',
        ];

        $args = array_map(function($name) {
            return [
                'option_group' => 'rs_christmas_santa_music_options_group',
                'option_name' => $name,
            ];
        }, $optionNames);

        $this->rs_christmas_santa_music_settings($args);
    }

    /**
     * Create option  section for music.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_music_sections(){
        $args = array(
            array(
                'id' => 'rs_christmas_santa_music_index',
                'page' => 'rs_christmas_santa_music_option'
            )
        );
        $this->rs_christmas_santa_music_sections( $args );
    }
    /**
     * Create option  fields for music.
     *
     * @since    1.0.0
     * @param      none.
     */
     function rs_christmas_santa_set_music_fields() {
        $fields = [
            'rs_christmas_santa_music_activation',
            'rs_christmas_santa_music_item',
            'rs_music_show_on_page',
        ];

        $args = array_map(function($field) {
            return [
                'id' => $field,
                'title' => '',
                'callback' => [$this, $field],
                'page' => 'rs_christmas_santa_music_option',
                'section' => 'rs_christmas_santa_music_index',
                'args' => [
                    'label_for' => $field,
                    'class' => 'example-class',
                ],
            ];
        }, $fields);

        $this->rs_christmas_santa_music_fields($args);
    }

    /**
     * Create option  settings for countdown.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_countdown_settings() {
        $settings = [
            'rs_christmas_santa_countdown_active',
            'rs_christmas_santa_countdown_after_text',
            'rs_christmas_santa_countdown_before_text',
            'rs_christmas_santa_countdown_type',
        ];

        $args = array_map(function($setting) {
            return [
                'option_group' => 'rs_christmas_santa_countdown_options_group',
                'option_name' => $setting,
            ];
        }, $settings);

        $this->rs_christmas_santa_countdown_settings($args);
    } 
    /**
     * Create option  section for countdown.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_countdown_sections(){
        $args = array(
            array(
                'id' => 'rs_christmas_santa_count_down_index',
                'page' => 'rs_christmas_santa_count_down_option'
            )
        );
        $this->rs_christmas_santa_countdown_sections( $args );
    }
    /**
     * Create option  fields for countdown.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_countdown_fields() {
        $fields = [
            'rs_christmas_santa_countdown_active',
            'rs_christmas_santa_countdown_after_text',
            'rs_christmas_santa_countdown_before_text',
            'rs_christmas_santa_countdown_type',
        ];

        $args = array_map(function($field) {
            return [
                'id' => $field,
                'title' => '',
                'callback' => [$this, $field],
                'page' => 'rs_christmas_santa_count_down_option',
                'section' => 'rs_christmas_santa_count_down_index',
                'args' => [
                    'label_for' => $field,
                    'class' => 'example-class'
                ]
            ];
        }, $fields);

        $this->rs_christmas_santa_countdown_fields($args);
    }

    /**
     * Create option  settings for schedule.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_schedule_settings(){
        $args = array(
            array(
                'option_group' => 'rs_christmas_santa_schedule_options_group',
                'option_name' => 'rs_christmas_santa_schedule_active'
            ),array(
                'option_group' => 'rs_christmas_santa_schedule_options_group',
                'option_name' => 'rs_christmas_santa_schedule_before_date'
            )
        );
        $this->rs_christmas_santa_schedule_settings( $args );
    }
    /**
     * Create option  section for schedule.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_schedule_sections(){
        $args = array(
            array(
                'id' => 'rs_christmas_santa_schedule_index',
                'page' => 'rs_christmas_santa_schedule_option'
            )
        );
        $this->rs_christmas_santa_schedule_sections( $args );
    }
    /**
     * Create option  fields for schedule.
     *
     * @since    1.0.0
     * @param      none.
     */
    function rs_christmas_santa_set_schedule_fields() {
        $fields = [
            'rs_christmas_santa_schedule_active',
            'rs_christmas_santa_schedule_before_date',
        ];

        $args = array_map(function($field) {
            return [
                'id' => $field,
                'title' => '',
                'callback' => [$this, $field],
                'page' => 'rs_christmas_santa_schedule_option',
                'section' => 'rs_christmas_santa_schedule_index',
                'args' => [
                    'label_for' => $field,
                    'class' => 'example-class'
                ]
            ];
        }, $fields);

        $this->rs_christmas_santa_schedule_fields($args);
    }
 


    //      reserved setting array of santa.
    //
    //      @since    1.0.0
    //      @param      array.
    public function rs_christmas_santa_settings( array $santaSettings )
    {
        $this->santaSettings = $santaSettings;
        return $this;
    }
    //      reserved section array of santa.
    //
    //      @since    1.0.0
    //      @param      array.
    public function rs_christmas_santa_sections( array $santaSections )
    {
        $this->santaSections = $santaSections;
        return $this;
    }

    //      reserved fields array of santa.
    //
    //      @since    1.0.0
    //      @param      array.
    public function rs_christmas_santa_fields( array $santaFields )
    {
        $this->santaFields = $santaFields;
        return $this;
    }

    //      reserved setting array of music.
    //
    //      @since    1.0.0
    //      @param      array.
    public function rs_christmas_santa_music_settings( array $musicSettings )
    {
        $this->musicSettings = $musicSettings;
        return $this;
    }
    //      reserved section array of music.
    //
    //      @since    1.0.0
    //      @param      array.
    public function rs_christmas_santa_music_sections( array $musicSections )
    {
        $this->musicSections = $musicSections;
        return $this;
    }
    //      reserved fields array of music.
    //
    //      @since    1.0.0
    //      @param      array.
    public function rs_christmas_santa_music_Fields( array $musicFields )
    {
        $this->musicFields = $musicFields;
        return $this;
    }

    //    /**
    //     * reserved settings array of count down setting.
    //     *
    //     * @since    1.0.0
    //     * @param      array.
    //     */
    public function rs_christmas_santa_countdown_settings(array $countDownSettings)
    {
        $this->countDownSettings = $countDownSettings;
        return $this;
    }

    //    /**
    //     * reserved section array of count down section.
    //     *
    //     * @since    1.0.0
    //     * @param      array.
    //     */
    public function rs_christmas_santa_countdown_sections(array $countDownSections)
    {
        $this->countDownSections = $countDownSections;
        return $this;
    }

    //    /**
    //     * reserved fields array of count down fields.
    //     *
    //     * @since    1.0.0
    //     * @param      array.
    //     */
    public function rs_christmas_santa_countdown_fields(array $countDownFields)
    {
        $this->countDownFields = $countDownFields;
        return $this;
    }
    //    /**
    //     * reserved settings array of schedule setting.
    //     *
    //     * @since    1.0.0
    //     * @param      array.
    //     */
    public function rs_christmas_santa_schedule_settings(array $scheduleSettings)
    {
        $this->scheduleSettings = $scheduleSettings;
        return $this;
    }

    //    /**
    //     * reserved section array of schedule section.
    //     *
    //     * @since    1.0.0
    //     * @param      array.
    //     */
    public function rs_christmas_santa_schedule_sections(array $scheduleSections)
    {
        $this->scheduleSections = $scheduleSections;
        return $this;
    }

    //    /**
    //     * reserved fields array of schedule fields.
    //     *
    //     * @since    1.0.0
    //     * @param      array.
    //     */
    public function rs_christmas_santa_schedule_fields(array $scheduleFields)
    {
        $this->scheduleFields = $scheduleFields;
        return $this;
    }
    //      register all custom settings sections and fields.
    //
    //      @since    1.0.0
    //      @param      none.
    public function rs_christmas_santa_register_custom_fields() {
        // Set settings, sections, and fields
        $this->rs_christmas_santa_set_settings_sections_fields([
            
            'santa' => ['rs_christmas_santa_set_santa_settings', 'rs_christmas_santa_set_santa_sections', 'rs_christmas_santa_set_santa_fields'],
            'music' => ['rs_christmas_santa_set_music_settings', 'rs_christmas_santa_set_music_sections', 'rs_christmas_santa_set_music_fields'],
            'countDown' => ['rs_christmas_santa_set_countdown_settings', 'rs_christmas_santa_set_countdown_sections', 'rs_christmas_santa_set_countdown_fields'],
            'schedule' => ['rs_christmas_santa_set_schedule_settings', 'rs_christmas_santa_set_schedule_sections', 'rs_christmas_santa_set_schedule_fields'],
        ]);

        // Register settings
       
        $this->rs_christmas_santa_register_settings($this->santaSettings);
        $this->rs_christmas_santa_register_settings($this->musicSettings);
        $this->rs_christmas_santa_register_settings($this->countDownSettings);
        $this->rs_christmas_santa_register_settings($this->scheduleSettings);

        // Add sections
       
        $this->rs_christmas_santa_add_sections($this->santaSections);
        $this->rs_christmas_santa_add_sections($this->musicSections);
        $this->rs_christmas_santa_add_sections($this->countDownSections);
        $this->rs_christmas_santa_add_sections($this->scheduleSections);

        // Add fields
        
        $this->rs_christmas_santa_add_fields($this->santaFields);
        $this->rs_christmas_santa_add_fields($this->musicFields);
        $this->rs_christmas_santa_add_fields($this->countDownFields);
        $this->rs_christmas_santa_add_fields($this->scheduleFields);
    }

    private function rs_christmas_santa_set_settings_sections_fields($sections) {
        foreach ($sections as $prefix => $methods) {
            foreach ($methods as $method) {
                $this->{$method}();
                $this->{$prefix . 'Settings'} = isset($this->{$prefix . 'Settings'}) ? $this->{$prefix . 'Settings'} : [];
                $this->{$prefix . 'Sections'} = isset($this->{$prefix . 'Sections'}) ? $this->{$prefix . 'Sections'} : [];
                $this->{$prefix . 'Fields'} = isset($this->{$prefix . 'Fields'}) ? $this->{$prefix . 'Fields'} : [];
            }
        }
    }

    private function rs_christmas_santa_register_settings($settings) {
        foreach ($settings as $setting) {
            register_setting($setting["option_group"], $setting["option_name"], $setting["callback"] ?? '');
        }
    }

    private function rs_christmas_santa_add_sections($sections) {
        foreach ($sections as $section) {
            if (!array_key_exists('title', $section)) $section['title'] = '';
            add_settings_section($section["id"], $section["title"], $section["callback"] ?? '', $section["page"]);
        }
    }

    private function rs_christmas_santa_add_fields($fields) {
        foreach ($fields as $field) {
            add_settings_field($field["id"], $field["title"], $field["callback"] ?? '', $field["page"], $field["section"], $field["args"] ?? '');
        }
    }
     
 
 
    //      call back of pop_up_type.
    //
    //      @since    1.0.0
    //      @param      none
    public function rs_christmas_santa_pop_up_type(){
        $value = esc_attr(get_option( 'rs_christmas_santa_pop_up_type' ));
        $path = dirname(__FILE__);
        $path= str_replace("admin","public",$path).'/images/pop-up';
        $url =  plugin_dir_url(__FILE__);
        $url= str_replace("admin","public",$url).'/images/pop-up';
        $images = scandir($path);
        $j =1;
        echo '<div style="display:block">';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("Pop up type", "rs-christmas-santa").' :</h3>';
        echo '</div>';
        echo '<div class="c-value" id="rs_popup-display-chirsmas">';
        for ($i = 0;$i<count($images);$i++) {
            if ($images[$i] != '.' && $images[$i] != '..') {
                echo "<div class=\"rs_popup-display\"><div><label><input type=\"radio\" class=\"regular-text\" name=\"rs_christmas_santa_pop_up_type\" value=\"".esc_attr($images[$i])."\" ".($value == $images[$i] ? "checked" : "")."><span>".esc_html__("Pop Up", "rs-christmas-santa"). " ".esc_html($j)."</span></label></div><div class=\"text-center\"><img class=\"pop-image\" src=\"".esc_url($url."/".esc_attr($images[$i]))."\"></div></div>";
                $j++;
            }
        }
        echo '</div>';
        echo '</div>';
    }
    //      call back of awesome_santa_flying.
    //
    //      @since    1.0.0
    //      @param      none
    public function rs_christmas_santa_awesome_santa_flying(){
        $value = esc_attr( get_option( 'rs_christmas_santa_awesome_santa_flying' ) );
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("Santa flying", "rs-christmas-santa").' :</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo "<input type=\"checkbox\" name=\"rs_christmas_santa_awesome_santa_flying\" value=\"1\" ".($value == 1? "checked" : "").">";
        echo '</div>';
        echo '</div>';

    }

    //      call back of awesome_santa_flying.
    //
    //      @since   1.0.0
    //      @param   none

    public function rs_christmas_santa_awesome_santa_flying_type()
    {
        $value = esc_attr(get_option('rs_christmas_santa_awesome_santa_flying_type'));

        $options = [
            'Attention Seekers' => [
                'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat'
            ],
            'Bouncing Entrances' => [
                'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp'
            ],
            'Bouncing Exits' => [
                'bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp'
            ],
            'Fading Entrances' => [
                'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig'
            ],
            'Fading Exits' => [
                'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig'
            ],
            'Flippers' => [
                'flip', 'flipInX', 'flipInY', 'flipOutX', 'flipOutY'
            ],
            'Lightspeed' => [
                'lightSpeedIn', 'lightSpeedOut'
            ],
            'Rotating Entrances' => [
                'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight'
            ],
            'Rotating Exits' => [
                'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight'
            ],
            'Sliding Entrances' => [
                'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight'
            ],
            'Sliding Exits' => [
                'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight'
            ],
            'Zoom Entrances' => [
                'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp'
            ],
            'Zoom Exits' => [
                'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp'
            ],
            'Specials' => [
                'hinge', 'jackInTheBox', 'rollIn', 'rollOut'
            ]
        ];

        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>' . esc_html__("Santa flying type", "rs-christmas-santa") . ' :</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo '<select class="fall-input" name="rs_christmas_santa_awesome_santa_flying_type">';

        // Escape the selected value and output it
        echo '<option value="' . esc_attr($value) . '" ' . selected($value, true, false) . '>' . esc_html($value) . '</option>';

        // Loop through options and escape each label and option
        foreach ($options as $label => $group) {
            echo '<optgroup label="' . esc_attr($label) . '">';
            foreach ($group as $option) {
                echo '<option value="' . esc_attr($option) . '" ' . selected($value, $option, false) . '>' . esc_html($option) . '</option>';
            }
            echo '</optgroup>';
        }

        echo '</select>';
        echo '</div>';
        echo '</div>';
    }


    //      call back of awesome_santa_show_on_page.
    //
    //      @since    1.0.0
    //      @param      none
    public function rs_christmas_santa_awesome_santa_show_on_page(){
        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages = get_pages($args);
        $values = get_option( 'rs_christmas_santa_awesome_santa_show_on_page' );
        echo '<div class="d-block">';
        echo '<div class="c-label">';
        echo '<label for="number" class="fall-label" ">'.esc_html__("Santa Show on page", "rs-christmas-santa").' :</label>';
        echo '</div>';
        echo '<div class="c-value">';
        echo '<ul>';
        foreach ($pages as $page) {
            if ($values != '') {
                $checked = "";
                if(in_array($page->ID,$values)){
                    $checked = "checked";
                }
                echo "<li><input type=\"checkbox\" id=\"number\" ".esc_attr($checked)." name=\"rs_christmas_santa_awesome_santa_show_on_page[]\" value=".esc_attr($page->ID).">".esc_attr($page->post_name)."</li>";
            }else {
                echo "<li><input type=\"checkbox\" id=\"number\"  name=\"rs_christmas_santa_awesome_santa_show_on_page[]\" value=\"".esc_attr($page->ID)."\">".esc_attr($page->post_name)."</li>";
            }
        }
        echo '</ul>';
        echo '</div>';
    }
    //      call back of pop_up_position.
    //
    //      @since    1.0.0
    //      @param      none
    public function rs_christmas_santa_pop_up_position(){
        $value = esc_attr( get_option( 'rs_christmas_santa_pop_up_position' ) );
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("Pop up position", "rs-christmas-santa").':</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo "<label><input type=\"radio\" name=\"rs_christmas_santa_pop_up_position\" value=\"1\" ".($value == 1? "checked" : "").">".esc_html__("Bottom right corner", "rs-christmas-santa"). " </label>";
        echo "<label><input type=\"radio\" name=\"rs_christmas_santa_pop_up_position\" value=\"2\" ".($value == 2? "checked" : "").">".esc_html__("Bottom left corner", "rs-christmas-santa"). " </label>";
        echo '</div>';
        echo '</div>';
    }
    //      call back of awesome_santa.
    //
    //      @since    1.0.0
    //      @param      none
    public function rs_christmas_santa_awesome_santa(){
        $value = esc_attr( get_option( 'rs_christmas_santa_awesome_santa' ) );
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("Santa pop up", "rs-christmas-santa").' :</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo "<input type=\"checkbox\" name=\"rs_christmas_santa_awesome_santa\" value=\"1\" ".($value == 1? "checked" : "").">";
        echo '</div>';
        echo '</div>';
    }
    //      call back of music_activation.
    //
    //      @since    1.0.0
    //      @param      none
    public function rs_christmas_santa_music_activation(){

        $value = esc_attr(get_option( 'rs_christmas_santa_music_activation' ));
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3> '.esc_html__("Active music", "rs-christmas-santa").':</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo "<input type=\"checkbox\" name=\"rs_christmas_santa_music_activation\" value=\"1\" ".($value == 1? "checked" :"").">";
        echo '</div>';
        echo '</div>';
    }
    //      call back of music_show_on_page.
    //
    //      @since    1.0.0
    //      @param      none
    public function rs_music_show_on_page(){
        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages = get_pages($args);
        $values = get_option( 'rs_music_show_on_page' );
        echo '<div class="d-block">';
        echo '<div class="c-label">';
        echo '<label for="number" class="fall-label" ">'.esc_html__("Music show on page", "rs-christmas-santa").' :</label>';
        echo '</div>';
        echo '<div class="c-value">';
        echo '<ul>';
        foreach ($pages as $page) {
            if ($values != '') {
                $checked = "";
                if(in_array($page->ID,$values)){
                    $checked = "checked";
                }
                echo "<li><input type=\"checkbox\" id=\"number\" ".esc_attr($checked)." name=\"rs_music_show_on_page[]\" value=".esc_attr($page->ID).">".esc_attr($page->post_name)."</li>";
            }else {
                echo "<li><input type=\"checkbox\" id=\"number\"  name=\"rs_music_show_on_page[]\" value=".esc_attr($page->ID).">".esc_attr($page->post_name)."</li>";
            }
        }
        echo '</ul>';
        echo '</div>';
    }
    //      call back of music_item.
    //
    //      @since    1.0.0
    //      @param      none

 
 
   public function rs_christmas_santa_music_item()
    {
        // Retrieve the current selected value from the options table
        $value = esc_attr(get_option('rs_christmas_santa_music_item'));

        // Get the uploads directory path and URL
        $upload_dir = wp_upload_dir();
        $path = trailingslashit($upload_dir['basedir']) . 'rs-christmas-santa'; 
        $pathurl = trailingslashit($upload_dir['baseurl']) . 'rs-christmas-santa';
       
        // Check for music files in the uploads directory
        if (file_exists($path)) {
            $music_new = scandir($path);
            $music_not_valid = ['.', '..'];
            $music = array_diff($music_new, $music_not_valid);
        } else {
            $music = [];
        }

        // Generate a unique nonce for security
        $nonce = wp_create_nonce('rs_christmas_santa_music_download_nonce');

        // Check if no music files exist, and enqueue the script for downloading them
        if (count($music) <= 0) {
            // Enqueue the script
            wp_enqueue_script('rs-music-script', plugin_dir_url(__FILE__) . 'js/rs-christmas-music-script.js', array(), '1.0.0', true);

            // Localize the script with the AJAX URL and nonce
            wp_localize_script('rs-music-script', 'rsMusicParams', array(
                'ajaxUrl' => esc_url(admin_url('admin-ajax.php?action=rs_christmas_santa_music_download&nonce=' . $nonce)),
                'loadingImage' => esc_url($pathurl . '/images/loading.gif') // Use the uploads directory URL for images
            ));

            // Display a loading message while the music files are being downloaded
            echo '<div id="loading-message" style="display: none;">
                <img src="' . esc_url(plugins_url() . '/rs-christmas-santa/public/images/loading.gif') . '" alt="Loading"/>
                <h3>' . esc_html__('Downloading music files, please wait...', 'rs-christmas-santa') . '</h3>
                </div>';
        }

        // Generate the HTML for the music item dropdown
        echo '<div>';
        echo '<div class="c-label">';
        echo '<label class="fall-label">' . esc_html__("Music item", "rs-christmas-santa") . ':</label>';
        echo '</div>';
        echo '<div class="c-value">';
        echo '<select class="fall-input" name="rs_christmas_santa_music_item">';

        foreach ($music as $vrs) {
            echo '<option value="' . esc_attr($vrs) . '" ' . selected($value, $vrs, false) . '>' . esc_html($vrs) . '</option>';
        }

        echo '</select>';
        echo '</div>';
        echo '</div>';
    }




    //      call back of christmas_countdown_active.
    //
    //      @since    1.0.0
    //      @param      none.
    public function rs_christmas_santa_countdown_active(){
        $value = esc_attr(get_option( 'rs_christmas_santa_countdown_active' ));
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("Countdown active", "rs-christmas-santa").':</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo "<input type=\"checkbox\" name=\"rs_christmas_santa_countdown_active\" value=\"1\" ".($value == 1? "checked" : "").">";
        echo '</div>';
        echo '</div>';
    }
    //      call back of christmas_countdown_after_text.
    //
    //      @since    1.0.0
    //      @param      none.
    public function rs_christmas_santa_countdown_after_text(){
        $value = esc_attr(get_option( 'rs_christmas_santa_countdown_after_text' ));
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("After text", "rs-christmas-santa").':</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo "<input type=\"text\" class=\"fall-input\" name=\"rs_christmas_santa_countdown_after_text\" value=".esc_attr($value).">";
        echo '</div>';
        echo '</div>';
    }
    //      call back of christmas_countdown_before_text.
    //
    //      @since    1.0.0
    //      @param      none.
    public function rs_christmas_santa_countdown_before_text(){
        $value = esc_attr(get_option( 'rs_christmas_santa_countdown_before_text' ));
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("Before text", "rs-christmas-santa").':</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo "<input type=\"text\" class=\"fall-input\" name=\"rs_christmas_santa_countdown_before_text\" value=".esc_attr($value).">";
        echo '</div>';
        echo '</div>';
    }
    //      call back of christmas_countdown_type.
    //
    //      @since    1.0.0
    //      @param      none.
    public function rs_christmas_santa_countdown_type(){
        $value = esc_attr(get_option( 'rs_christmas_santa_countdown_type' ));
        $path = dirname(__FILE__);
        $path= str_replace("admin","public",$path).'/images/count-down';
        $url =  plugin_dir_url(__FILE__);
        $url= str_replace("admin","public",$url).'/images/count-down';
        $images = scandir($path);
        $j =1;
        echo '<div style="display:block">';
        echo '<div class="c-label">';
        echo '<h3>'.esc_html__("Count down type", "rs-christmas-santa").' :</h3>';
        echo '</div>';
        echo '<div class="c-value" id="rs_christmas_santa_countdown_type">';
        for ($i = 0;$i<count($images);$i++) {
            if ($images[$i] != '.' && $images[$i] != '..') {
                echo "<div class=\"rs_popup-display\"><div> <label><input type=\"radio\" class=\"regular-text\" name=\"rs_christmas_santa_countdown_type\" value=".esc_attr($images[$i])." ".($value == $images[$i] ? "checked" : "")."><span>".esc_html__("Pop Up", "rs-christmas-santa"). " ".esc_attr($j)."<span></label></div><div class=\"text-center\"><img class=\"pop-image\" src=\"".esc_url($url)."/".esc_attr($images[$i])."\"></div></div>";
                $j++;
            }
        }
        echo '</div>';
        echo '</div>';
        echo '<div class="c-label update_level">';
        echo "<h3>".esc_html__("To show countdown shortcode", "rs-christmas-santa"). "  :   [rs_christmas_santa_count_down] </h3>"; 
        echo '</div>';
        echo '<div class="c-label update_level">'; 
        echo "<h3>".esc_html__("To show countdown php shortcode", "rs-christmas-santa"). "  :  echo do_shortcode( '[rs_christmas_santa_count_down]' );  </h3>";
        echo '</div>';
        
    }
    /**
     * Create option  section for schedule active.
     *
     * @since    1.0.0
     * @param      none.
     */
    public function rs_christmas_santa_schedule_active(){
        $value = esc_attr(get_option( 'rs_christmas_santa_schedule_active' ));
        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3> '.esc_html__("Schedule active", "rs-christmas-santa").':</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo '<input type="checkbox" name="rs_christmas_santa_schedule_active" value="1" '.($value == 1? 'checked' : '').'>';
        echo '</div>';
        echo '</div>';
    }
    /**
     * Create option  section for schedule before date.
     *
     * @since    1.0.0
     * @param      none.
     */
	public function rs_christmas_santa_schedule_before_date()
    {
        $value = esc_attr(get_option('rs_christmas_santa_schedule_before_date'));
        $time_units = array(
            'hour' => 23,
            'day' => 30
        );

        echo '<div>';
        echo '<div class="c-label">';
        echo '<h3>' . esc_html__("Before days", "rs-christmas-santa") . ' :</h3>';
        echo '</div>';
        echo '<div class="c-value">';
        echo '<select class="fall-input" name="rs_christmas_santa_schedule_before_date">';

        foreach ($time_units as $unit => $max) {
            for ($i = 1; $i <= $max; $i++) {
                $label = $i . ' ' . $unit . ($i > 1 ? 's' : '');
                echo '<option value="' . esc_attr($label) . '" ' . selected($value, $label, false) . '>' . esc_html($label) . '</option>';
            }
        }

        echo '</select>';
        echo '</div>';
        echo '</div>';
    }


	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rs-christmas-santa-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rs-christmas-santa-admin.js', array( 'jquery' ), $this->version, false );

	}

}
