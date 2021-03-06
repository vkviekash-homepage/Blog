<?php
namespace ElementsKit_Lite;

defined( 'ABSPATH' ) || exit;


/**
 * ElementsKit - the God class.
 * Initiate all necessary classes, hooks, configs.
 *
 * @since 1.0.0
 */
class Plugin{


	/**
	 * The plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
    public static $instance = null;

    /**
     * Construct the plugin object.
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {

        // Enqueue frontend scripts.
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_frontend'] );

        // Enqueue admin scripts.
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_admin'] );

        // Enqueue inline scripts
        Core\Build_Inline_Scripts::instance();

        // Register plugin settings pages
        Libs\Framework\Attr::instance();

        // Register default widgets
        Core\Build_Widgets::instance();

        // Register default modules
        Core\Build_Modules::instance();

        // Register ElementsKit supported widgets to Elementor from 3rd party plugins.
        add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widgets'], 1050);

        // Register wpml compability module
        Compatibility\Wpml\Init::instance();
        Compatibility\Conflicts\Init::instance();
        
        // Register data migration class
         Compatibility\Data_Migration\Translate_File::instance()->init();
         Libs\Xs_Migration\Initiator::instance()->init();

        add_action('wp_head', [$this, 'add_meta_for_search_excluded']);

        // Add banner class
        add_action('admin_notices', function(){
            include \ElementsKit::lib_dir() . 'banner/init.php';
            // \WpMet_Banner::run();
        });

        // Adding pro lebel
        if(\ElementsKit_Lite::package_type() == 'free'){
            new Libs\Pro_Label\Init();
        }
    }

    /**
     * Enqueue scripts
     *
     * Enqueue js and css to frontend.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue_frontend(){
        wp_enqueue_style( 'elementskit-font-css-admin', \ElementsKit_Lite::module_url() . 'controls/assets/css/ekiticons.css', \ElementsKit_Lite::version() );
        wp_enqueue_script( 'elementskit-framework-js-frontend', \ElementsKit_Lite::lib_url() . 'framework/assets/js/frontend-script.js', ['jquery'], \ElementsKit_Lite::version(), true );
    }

    /**
     * Enqueue scripts
     *
     * Enqueue js and css to admin.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue_admin(){
        $screen = get_current_screen();
        
        if(!in_array($screen->id, ['nav-menus', 'toplevel_page_elementskit', 'edit-elementskit_template', 'elementskit_page_elementskit-license'])){
            return;
        }

        wp_register_style( 'fontawesome', \ElementsKit_Lite::widget_url() . 'init/assets/css/font-awesome.min.css', \ElementsKit_Lite::version() );
        wp_register_style( 'elementskit-font-css-admin', \ElementsKit_Lite::module_url() . 'controls/assets/css/ekiticons.css', \ElementsKit_Lite::version() );
        wp_register_style( 'elementskit-lib-css-admin', \ElementsKit_Lite::lib_url() . 'framework/assets/css/framework.css', \ElementsKit_Lite::version() );
        wp_register_style( 'elementskit-init-css-admin', \ElementsKit_Lite::lib_url() . 'framework/assets/css/admin-style.css', \ElementsKit_Lite::version() );
        wp_register_style( 'elementskit-init-css-admin-ems', \ElementsKit_Lite::lib_url() . 'framework/assets/css/admin-style-ems-dev.css', \ElementsKit_Lite::version() );

        wp_enqueue_style( 'fontawesome' );
        wp_enqueue_style( 'elementskit-font-css-admin' );
        wp_enqueue_style( 'elementskit-lib-css-admin' );
        wp_enqueue_style( 'elementskit-lib-css-admin' );
        wp_enqueue_style( 'elementskit-init-css-admin' );
        wp_enqueue_style( 'elementskit-init-css-admin-ems' );

        wp_enqueue_script( 'ekit-admin-core', \ElementsKit_Lite::lib_url() . 'framework/assets/js/ekit-admin-core.js', ['jquery'], \ElementsKit_Lite::version(), true );

        $data['rest_url'] = get_rest_url();
	    $data['nonce']    = wp_create_nonce('wp_rest');

	    wp_localize_script('ekit-admin-core', 'rest_config', $data);
    }

    /**
     * Control registrar.
     *
     * Register the custom controls for Elementor
     * using `elementskit/widgets/widgets_registered` action.
     *
     * @since 1.0.0
     * @access public
     */
    public function register_control($widgets_manager){
        do_action('elementskit/widgets/widgets_registered', $widgets_manager);
    }


    /**
     * Widget registrar.
     *
     * Retrieve all the registered widgets
     * using `elementor/widgets/widgets_registered` action.
     *
     * @since 1.0.0
     * @access public
     */
    public function register_widgets($widgets_manager){
        do_action('elementskit/widgets/widgets_registered', $widgets_manager);
    }

    /**
     * Excluding ElementsKit template and megamenu content from search engine.
     * See - https://wordpress.org/support/topic/google-is-indexing-elementskit-content-as-separate-pages/
     *
     * @since 1.4.5
     * @access public
     */
	public function add_meta_for_search_excluded(){
        if ( in_array(get_post_type(), 
                ['elementskit_widget', 'elementskit_template', 'elementskit_content'])
            ){
			echo '<meta name="robots" content="noindex,nofollow" />', "\n";
		}
	}

    /**
     * Autoloader.
     *
     * ElementsKit autoloader loads all the classes needed to run the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private static function registrar_autoloader() {
        require_once \ElementsKit_Lite::plugin_dir() . '/autoloader.php';
        Autoloader::run();
    }

    /**
     * Instance.
     *
     * Ensures only one instance of the plugin class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            // Call the method for ElementsKit lite autoloader.
            self::registrar_autoloader();

            do_action( 'elementskit_lite/before_loaded' );

            // Fire when ElementsKit instance.
            self::$instance = new self();

            do_action( 'elementskit/loaded' ); // legacy support
            do_action( 'elementskit_lite/after_loaded' );
        }

        return self::$instance;
    }
}

// Run the instance.
Plugin::instance();
