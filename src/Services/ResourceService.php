<?php

/**
 * Register resource service.
 *
 * @package Super_Advent_Calendar
 * @author  Verdant Studio
 * @since   1.0.0
 */
namespace SuperAdventCalendar\Services;

/**
 * Exit when accessed directly.
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
use DateTime;
use DateTimeZone;
use SuperAdventCalendar\Interfaces\Services\ResourceServiceInterface;
/**
 * Register resource service.
 *
 * @since 1.0.0
 */
class ResourceService extends Service implements ResourceServiceInterface {
    /**
     * @inheritDoc
     */
    public function register() {
        add_action( 'init', array($this, 'register_block_scripts') );
    }

    /**
     * Determine if the day can be accessed.
     *
     * @since 1.0.0
     * @return boolean;
     */
    public function day_can_be_accessed( $attributes ) {
        $wp_timezone = new DateTimeZone(wp_timezone_string());
        $current_datetime = new DateTime(current_time( 'mysql' ), $wp_timezone);
        $schedule_start = ( !empty( $attributes['scheduleStart'] ) ? DateTime::createFromFormat( 'Y-m-d\\TH:i:s', $attributes['scheduleStart'], $wp_timezone ) : null );
        $schedule_end = ( !empty( $attributes['scheduleEnd'] ) ? DateTime::createFromFormat( 'Y-m-d\\TH:i:s', $attributes['scheduleEnd'], $wp_timezone ) : null );
        // Check if scheduleStart or scheduleEnd has an invalid format.
        if ( false === $schedule_start || false === $schedule_end ) {
            return false;
            // Invalid date format
        }
        // Handle case where both scheduleStart and scheduleEnd are set.
        if ( $schedule_start && $schedule_end ) {
            if ( $schedule_start >= $schedule_end ) {
                return false;
                // Invalid range: start cannot be after or equal to end.
            }
            return $current_datetime >= $schedule_start && $current_datetime <= $schedule_end;
        }
        // Handle case where only scheduleStart is set (allow access from start time onward).
        if ( $schedule_start ) {
            return $current_datetime >= $schedule_start;
        }
        // Handle case where only scheduleEnd is set (allow access up to end time).
        if ( $schedule_end ) {
            return $current_datetime <= $schedule_end;
        }
        // If neither scheduleStart nor scheduleEnd is set, default to allowing access.
        return true;
    }

    /**
     * Get the modal markup.
     *
     * @since 1.1.0
     *
     * @return string
     */
    public function get_modal_markup( $block_attributes ) : string {
        $attrs = $block_attributes;
        $block_style_modal = '';
        if ( 'content-type-text' !== $attrs['contentType'] || !$attrs['showInModal'] ) {
            return '';
        }
        // Add modal text color if attribute is set.
        if ( !empty( $attrs['modalTextColor'] ) ) {
            $block_style_modal .= 'color: ' . esc_attr( $attrs['modalTextColor'] ) . ';';
        }
        // Add modal background color if attribute is set.
        if ( !empty( $attrs['modalBackgroundColor'] ) ) {
            $block_style_modal .= 'background-color: ' . esc_attr( $attrs['modalBackgroundColor'] ) . ';';
        }
        return '<div class="superac-dialog-container" aria-hidden="true">
			<div class="superac-dialog-overlay" data-a11y-dialog-hide></div>
			<div class="superac-dialog-content" role="document"  style="' . esc_attr( $block_style_modal ) . '">
				<div class="superac-dialog-top-bar">
					<button class="superac-dialog-button" type="button" data-a11y-dialog-hide aria-label="Close dialog" style="' . esc_attr( $block_style_modal ) . '">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
					</button>
				</div>
				<h1 class="superac-dialog-title"></h1>
				<div class="superac-dialog-body"></div>
			</div>
		</div>';
    }

    /**
     * Render the advent calendar day block because we need interactivity.
     *
     * @since 1.0.0
     *
     * @return string;
     */
    public function render_advent_calendar_day_block( $block_attributes ) : string {
        $attrs = $block_attributes;
        $can_access = $this->day_can_be_accessed( $attrs );
        $can_access_attribute = ( $can_access ? 'data-access="true"' : 'data-access="false"' );
        $post_id_attribute = 'data-post-id=' . esc_attr( get_the_ID() ) . '';
        // Only use the attributes we need as a data attribute.
        $filtered_block_attributes = array_filter( $block_attributes, function ( $key ) {
            return in_array( $key, array('blockId', 'contentType', 'showInModal'), true );
        }, ARRAY_FILTER_USE_KEY );
        $animation_classes = array(
            'none' => 'superac-day--animation-none',
            'flip' => 'superac-day--animation-flip',
        );
        // Encode the attributes as a JSON string using wp_json_encode.
        $data_attributes = wp_json_encode( $filtered_block_attributes );
        // Determine the animation class based on the animation attribute value.
        $animation_class = '';
        if ( isset( $attrs['animation'] ) && isset( $animation_classes[$attrs['animation']] ) ) {
            $animation_class = $animation_classes[$attrs['animation']];
        } else {
            $animation_class = $animation_classes['none'];
        }
        $block_style_front = '';
        $block_style_back = '';
        // Add front text color if attribute is set.
        if ( !empty( $block_attributes['frontTextColor'] ) ) {
            $block_style_front .= 'color: ' . esc_attr( $block_attributes['frontTextColor'] ) . ';';
        }
        // Add front background color if attribute is set.
        if ( !empty( $block_attributes['frontBackgroundColor'] ) ) {
            $block_style_front .= 'background-color: ' . esc_attr( $block_attributes['frontBackgroundColor'] ) . ';';
        }
        // Add back text color if attribute is set.
        if ( !empty( $block_attributes['backTextColor'] ) ) {
            $block_style_back .= 'color: ' . esc_attr( $block_attributes['backTextColor'] ) . ';';
        }
        // Add back background color if attribute is set.
        if ( !empty( $block_attributes['backBackgroundColor'] ) ) {
            $block_style_back .= 'background-color: ' . esc_attr( $block_attributes['backBackgroundColor'] ) . ';';
        }
        // Get the block wrapper attributes for the front and back cards.
        $front_card_attributes = get_block_wrapper_attributes( array(
            'class' => 'superac-card superac-card--front',
            'style' => $block_style_front,
        ) );
        $back_card_attributes = get_block_wrapper_attributes( array(
            'class' => 'superac-card superac-card--back',
            'style' => $block_style_back,
        ) );
        // Construct the day output.
        $output = '';
        if ( 'content-type-link' === $attrs['contentType'] ) {
            $output .= '<a href="#" class="superac-day ' . esc_attr( $animation_class ) . '" data-attributes=' . esc_attr( $data_attributes ) . ' ' . esc_attr( $post_id_attribute ) . ' ' . esc_attr( $can_access_attribute ) . '>';
        } else {
            $output .= '<div class="superac-day ' . esc_attr( $animation_class ) . '" data-attributes=' . esc_attr( $data_attributes ) . ' ' . esc_attr( $post_id_attribute ) . ' ' . esc_attr( $can_access_attribute ) . '>';
        }
        $output .= '
			<div ' . $front_card_attributes . '>
				<div class="superac-card-title">
					' . esc_html( $attrs['frontTitle'] ) . '
				</div>
			</div>
			<div ' . $back_card_attributes . '>
				<div class="superac-card-title"></div>';
        // Only show the content in the back of the card when not in a modal.
        if ( !$attrs['showInModal'] && 'content-type-text' === $attrs['contentType'] ) {
            $output .= '<div class="superac-card-content"></div>';
        } else {
            switch ( $attrs['contentType'] ) {
                case 'content-type-text':
                    $output .= '<div class="superac-card-content">' . esc_html__( 'Opens in a modal', 'super-advent-calendar' ) . '</div>';
                    break;
                case 'content-type-link':
                    $output .= '<div class="superac-card-content">' . esc_html__( 'Opens a link', 'super-advent-calendar' ) . '</div>';
                    break;
                default:
                    break;
            }
        }
        $output .= '</div>';
        // Close either the <div> or <a> tag.
        $output .= ( 'content-type-link' === $attrs['contentType'] ? '</a>' : '</div>' );
        $output .= $this->get_modal_markup( $attrs ) . '';
        return $output;
    }

    /**
     * Register blocks.
     *
     * @since 1.0.0
     *
     * @return void;
     */
    public function register_block_scripts() {
        // Block editor is not available.
        if ( !function_exists( 'register_block_type' ) ) {
            return;
        }
        register_block_type( SUPER_ADVENT_CALENDAR_DIR_PATH . 'dist/blocks/advent-calendar/block.json' );
        register_block_type( SUPER_ADVENT_CALENDAR_DIR_PATH . 'dist/blocks/advent-calendar-day/block.json', array(
            'render_callback' => array($this, 'render_advent_calendar_day_block'),
        ) );
        // Pass the vsSacSettings variable to super-advent-calendar block in the editor and view script.
        $localize = array(
            'isPremium' => vs_sac_fs()->can_use_premium_code(),
            'nonce'     => wp_create_nonce( 'wp_rest' ),
        );
        wp_localize_script( 'super-advent-calendar-advent-calendar-editor-script', 'vsSacSettings', $localize );
        wp_localize_script( 'super-advent-calendar-advent-calendar-day-view-script', 'vsSacSettings', $localize );
    }

}
