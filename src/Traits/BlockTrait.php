<?php
/**
 * Block trait.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.3.0
 */

namespace SuperAdventCalendar\Traits;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Block trait.
 *
 * @since 1.3.0
 */
trait BlockTrait
{
	/**
	 * Get a block's default attributes.
	 *
	 * @since 1.3.0
	 */
	public function get_block_default_attributes( $block_name ) {
		$block_registry = \WP_Block_Type_Registry::get_instance();
		$block_type     = $block_registry->get_registered( $block_name );
		if ($block_type && isset( $block_type->attributes )) {
			return array_map(
				function ($attribute ) {
					return isset( $attribute['default'] ) ? $attribute['default'] : null;
				},
				$block_type->attributes
			);
		}
		return array();
	}

	/**
	 * Merge the content attributes with default attributes.
	 *
	 * @since 1.3.0
	 */
	public function parse_blocks_with_defaults( $content ) {
		$blocks = parse_blocks( $content );
		foreach ($blocks as &$block) {
			if (isset( $block['blockName'] )) {
				$default_attributes = $this->get_block_default_attributes( $block['blockName'] );
				$block['attrs']     = array_merge( $default_attributes, $block['attrs'] ?? array() );
			}
		}
		return $blocks;
	}
}
