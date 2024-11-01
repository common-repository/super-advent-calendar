<?php
/**
 * Api controller.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.3.0
 */

namespace SuperAdventCalendar\Controllers;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

use SuperAdventCalendar\Interfaces\Controllers\ApiControllerInterface;
use SuperAdventCalendar\Traits\BlockTrait;

/**
 * Api controller.
 *
 * @since 1.3.0
 */
class ApiController extends \WP_REST_Controller implements ApiControllerInterface
{
	use BlockTrait;

	/**
	 * Namespace to prefix REST calls.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	public $context = 'superac/';

	/**
	 * The current version of the REST calls.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	public $version = 'v1';

	/**
	 * Initialize events.
	 *
	 * @since 1.3.0
	 *
	 * @return void
	 */
	public function register()
	{
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register api routes.
	 *
	 * @since 1.3.0
	 *
	 * @return void
	 */
	public function register_routes()
	{
		$context = $this->context . $this->version;

		register_rest_route(
			$context,
			'/block-attributes/(?P<post_id>\d+)/(?P<block_id>[\w\d-]+)',
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_day_block_settings' ),
					'permission_callback' => array( $this, 'get_options_permission' ),
				),
			)
		);
	}

	/**
	 * Verify can access day.
	 *
	 * @since 1.3.0
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function get_day_block_settings( $request )
	{
		$block_id = $request->get_param( 'block_id' );
		$post_id  = $request->get_param( 'post_id' );

		// Query database for block attributes.
		$blocks           = parse_blocks( get_post_field( 'post_content', $post_id ) );
		$block_attributes = array();

		foreach ($blocks as $block) {
			if (isset( $block['blockName'] ) && 'super-advent-calendar/advent-calendar' === $block['blockName'] ) {
				if (isset( $block['innerBlocks'] )) {
					foreach ($block['innerBlocks'] as $inner) {
						// Ensure blockName is a valid string (sanitize as needed)
						$block_name         = sanitize_text_field( $inner['blockName'] );
						$default_attributes = $this->get_block_default_attributes( $block_name );

						// Ensure 'attrs' exists and is an array, and sanitize all elements
						$inner_attrs = isset( $inner['attrs'] ) && is_array( $inner['attrs'] ) ? $inner['attrs'] : array();
						$inner_attrs = array_map( 'sanitize_text_field', $inner_attrs );

						// Merge default attributes with sanitized inner attributes
						$inner['attrs'] = array_merge( $default_attributes, $inner_attrs );

						// Sanitize blockId and check if it matches the given $block_id
						if (isset( $inner['attrs']['blockId'] ) && sanitize_text_field( $inner['attrs']['blockId'] ) === $block_id) {
							$back_content = $inner['attrs']['backContent'] ?? '';

							// Sanitize and process the backContent attribute.
							$sanitized_back_content = wp_kses_post( $back_content );

							// Process shortcodes.
							$inner['attrs']['backContent'] = do_shortcode( $sanitized_back_content );

							// Set the block attributes safely.
							$block_attributes = $inner['attrs'];
						}
					}
				}
			}
		}

		if (empty( $block_attributes )) {
			return new \WP_Error( 'no_attributes', 'No attributes found', array( 'status' => 404 ) );
		}

		return rest_ensure_response( $block_attributes );
	}

	/**
	 * Check if user may access the endpoints.
	 *
	 * @since 1.3.0
	 *
	 * @return \WP_Error|bool
	 */
	public function get_options_permission( \WP_REST_Request $request )
	{
		$nonce = $request->get_header( 'X-WP-Nonce' );

		if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new \WP_Error( 'rest_forbidden', esc_html__( 'You do not have permission to access this api.', 'super-advent-calendar' ), array( 'status' => 401 ) );
		}

		return true;
	}
}
