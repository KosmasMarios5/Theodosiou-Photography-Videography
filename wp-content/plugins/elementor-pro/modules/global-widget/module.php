<?php

namespace ElementorPro\Modules\GlobalWidget;

use Elementor\Core\Documents_Manager;
use Elementor\Element_Base;
use Elementor\TemplateLibrary\Source_Local;
use ElementorPro\Base\Module_Base;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {

	const TEMPLATE_TYPE = 'widget';

	const WIDGET_TYPE_META_KEY = '_elementor_template_widget_type';

	const INCLUDED_POSTS_LIST_META_KEY = '_elementor_global_widget_included_posts';

	public function __construct() {
		parent::__construct();

		$this->add_hooks();
	}

	public function get_widgets() {
		return [
			'Global_Widget',
		];
	}

	public function get_name() {
		return 'global-widget';
	}

	public function add_templates_localize_data( $settings ) {
		$elementor = Plugin::elementor();

		$templates_manager = $elementor->templates_manager;

		$widgets_types = $elementor->widgets_manager->get_widget_types();

		$widget_templates = array_filter( $templates_manager->get_source( 'local' )->get_items( [ 'type' => self::TEMPLATE_TYPE ] ), function( $template ) use ( $widgets_types ) {
			if ( empty( $template['widgetType'] ) || empty( $widgets_types[ $template['widgetType'] ] ) ) {
				return false;
			}

			// Open the stack in order to include the widget controls in initial editor config
			$widgets_types[ $template['widgetType'] ]->get_stack( false );

			return true;
		} );

		$widget_templates_content = [];

		foreach ( $widget_templates as $widget_template ) {
			$widget_templates_content[ $widget_template['template_id'] ] = [
				'elType' => 'widget',
				'title' => $widget_template['title'],
				'widgetType' => $widget_template['widgetType'],
			];
		}

		$settings = array_replace_recursive( $settings, [
			'widget_templates' => $widget_templates_content,
			'i18n' => [
				'unlink' => __( 'Unlink', 'elementor-pro' ),
				'cancel' => __( 'Cancel', 'elementor-pro' ),
				'unlink_widget' => __( 'Unlink Widget', 'elementor-pro' ),
				'global' => __( 'Global', 'elementor-pro' ),
				'dialog_confirm_unlink' => __( 'This will make the widget stop being global. It\'ll be reverted into being just a regular widget.', 'elementor-pro' ),
				'global_widget_save_title' => __( 'Save your widget as a global widget', 'elementor-pro' ),
				'global_widget_save_description' => __( 'You\'ll be able to add this global widget to multiple areas on your site, and edit it from one single place.', 'elementor-pro' ),
				'linked_to_global' => __( 'Linked to Global', 'elementor-pro' ),
			],
		] );

		return $settings;
	}

	public function set_template_widget_type_meta( $post_id, $template_data ) {
		if ( self::TEMPLATE_TYPE === $template_data['type'] ) {
			update_post_meta( $post_id, self::WIDGET_TYPE_META_KEY, $template_data['content'][0]['widgetType'] );
		}
	}

	public function on_template_update( $template_id, $template_data ) {
		if ( self::TEMPLATE_TYPE !== $template_data['type'] ) {
			return;
		}

		$this->delete_included_posts_css( $template_id );
	}

	public function filter_template_data( $data ) {
		if ( self::TEMPLATE_TYPE === $data['type'] ) {
			$data['widgetType'] = get_post_meta( $data['template_id'], self::WIDGET_TYPE_META_KEY, true );
		}

		return $data;
	}

	public function get_element_child_type( Element_Base $default_child_type, array $element_data ) {
		if ( isset( $element_data['templateID'] ) ) {
			$template_post = get_post( $element_data['templateID'] );

			if ( ! $template_post || 'trash' === $template_post->post_status ) {
				return false;
			}
		}

		return $default_child_type;
	}

	public function is_post_type_support_elementor( $is_supported, $post_id, $post_type ) {
		if ( ! $is_supported || Source_Local::CPT !== $post_type ) {
			return $is_supported;
		}

		$is_widget_template = $this->is_widget_template( $post_id );

		// FIX ME: Change `get_current_screen()` condition to better way.
		if ( $is_widget_template && function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();

			if ( ! empty( $screen->id ) && in_array( $screen->id, [ 'elementor_library', 'edit-elementor_library' ] ) ) {
				$is_supported = false;
			}
		}

		return $is_supported;
	}

	public function is_template_supports_export( $default_value, $template_id ) {
		return $default_value && ! $this->is_widget_template( $template_id );
	}

	/**
	 * TODO: Remove. On Elementor 2.3.3 it's handled by the Documents Manager.
	 *
	 * Remove user edit capabilities.
	 *
	 * Filters the user capabilities to disable editing in admin.
	 *
	 * @param array $allcaps An array of all the user's capabilities.
	 * @param array $caps    Actual capabilities for meta capability.
	 * @param array $args    Optional parameters passed to has_cap(), typically object ID.
	 *
	 * @return array
	 */
	public function remove_user_edit_cap( $allcaps, $caps, $args ) {
		$capability = $args[0];

		if ( empty( $args[2] ) ) {
			return $allcaps;
		}

		global $pagenow;

		if ( ! in_array( $pagenow, [ 'post.php', 'edit.php' ], true ) ) {
			return $allcaps;
		}

		$post_id = $args[2];

		if ( 'edit_post' !== $capability ) {
			return $allcaps;
		}

		$post = get_post( $post_id );

		if ( ! $post ) {
			return $allcaps;
		}

		if ( Source_Local::CPT !== $post->post_type ) {
			return $allcaps;
		}

		if ( ! $this->is_widget_template( $post_id ) ) {
			return $allcaps;
		}

		$allcaps[ $caps[0] ] = false;

		return $allcaps;
	}

	public function is_widget_template( $template_id ) {
		$template_type = Source_Local::get_template_type( $template_id );

		return self::TEMPLATE_TYPE === $template_type;
	}

	public function set_global_widget_included_posts_list( $post_id, $editor_data ) {
		$global_widget_ids = [];

		Plugin::elementor()->db->iterate_data( $editor_data, function( $element_data ) use ( &$global_widget_ids ) {
			if ( isset( $element_data['templateID'] ) ) {
				$global_widget_ids[] = $element_data['templateID'];
			}
		} );

		foreach ( $global_widget_ids as $widget_id ) {
			$included_posts = get_post_meta( $widget_id, self::INCLUDED_POSTS_LIST_META_KEY, true );

			if ( ! is_array( $included_posts ) ) {
				$included_posts = [];
			}

			$included_posts[ $post_id ] = true;

			update_post_meta( $widget_id, self::INCLUDED_POSTS_LIST_META_KEY, $included_posts );
		}
	}

	private function delete_included_posts_css( $template_id ) {
		$including_post_ids = (array) get_post_meta( $template_id, self::INCLUDED_POSTS_LIST_META_KEY, true );

		if ( empty( $including_post_ids ) ) {
			return;
		}

		foreach ( array_keys( $including_post_ids ) as $post_id ) {
			delete_post_meta( $post_id, '_elementor_css' );
		}
	}

	/**
	 * @param Documents_Manager $documents_manager
	 */
	public function register_documents( $documents_manager ) {
		$documents_manager->register_document_type( self::TEMPLATE_TYPE, Documents\Widget::get_class_full_name() );
	}

	public function on_elementor_editor_init() {
		Plugin::elementor()->common->add_template( __DIR__ . '/views/panel-template.php' );
	}

	private function add_hooks() {
		add_action( 'elementor/documents/register', [ $this, 'register_documents' ] );
		add_action( 'elementor/template-library/after_save_template', [ $this, 'set_template_widget_type_meta' ], 10, 2 );
		add_action( 'elementor/template-library/after_update_template', [ $this, 'on_template_update' ], 10, 2 );
		add_action( 'elementor/editor/init', [ $this, 'on_elementor_editor_init' ] );
		add_action( 'elementor/editor/after_save', [ $this, 'set_global_widget_included_posts_list' ], 10, 2 );

		add_filter( 'elementor_pro/editor/localize_settings', [ $this, 'add_templates_localize_data' ] );
		add_filter( 'elementor/template-library/get_template', [ $this, 'filter_template_data' ] );
		add_filter( 'elementor/element/get_child_type', [ $this, 'get_element_child_type' ], 10, 2 );
		add_filter( 'elementor/utils/is_post_support', [ $this, 'is_post_type_support_elementor' ], 10, 3 );
		add_filter( 'user_has_cap', [ $this, 'remove_user_edit_cap' ], 10, 3 );

		add_filter( 'elementor/template_library/is_template_supports_export', [ $this, 'is_template_supports_export' ], 10, 2 );
	}
}
