<?php

defined( 'ABSPATH' ) or exit( 'Permission Denied' );

if ( ! class_exists( 'BaPSSC' ) ) {
	final class BaPSSC {
		/**
		 * A dummy magic method to prevent BaPSSC from being loaded more than once.
		 * @since BaPSSC (1.0.0)
		 */
		private function __construct() { }

		/**
		 * A dummy magic method to prevent BaPSSC from being cloned.
		 * @since BaPSSC (1.0.0)
		 */
		public function __clone() { _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'BaPSSC' ), '1.7' ); }

		/**
		 * A dummy magic method to prevent BaPSSC from being unserialized.
		 * @since BaPSSC (1.0.0)
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'BaPSSC' ), '1.7' ); }

		/**
		 * Magic method to prevent notices and errors from invalid method calls.
		 * @since BaPSSC (1.0.0)
		 */
		public function __call( $name = '', $args = array() ) { unset( $name, $args ); return null; }

		/**
		 * Main plugin constructor
		 * @return object instance
		 * @since  BaPSSC (1.0.0)
		 */
		public static function instance() {
			static $instance = null;

			// Only run these methods if they haven't been run previously
			if ( null === $instance ) {
				$instance = new BaPSSC;
				$instance->init();
			}

			// Always return the instance
			return $instance;
		}

		/**
		 * Initialize the plugin
		 * @return void
		 * @since  BaPSSC (1.0.0)
		 */
		public function init() {
			require_once 'functions.php';

			add_action( 'post_submitbox_misc_actions', array( $this, 'admin_edit_shares' ) );
		}

		public function admin_edit_shares() {
			if ( empty( $_GET['post'] ) )
				return;
				
			if ('publish' === get_post_status( get_the_ID())) {
			?>
			<div class="misc-pub-section curshares misc-pub-curshares">
				<span id="timesshared">
					<span class="dashicons dashicons-share" style="color: #888;"></span> <?php _e( 'Total Shares', 'goodlife' ); ?>: <b><?php echo pssc_all( $_GET['post'] ); ?></b>
				</span>
			</div>
			<?php
			}
		}
	}
	/**
	 * Main function responsible for returning the instance
	 * @return BaPSSC
	 */
	function ba_pssc() {
		return BaPSSC::instance();
	}

	//Enjoy!
	$GLOBALS['ba_pssc'] = ba_pssc();
}