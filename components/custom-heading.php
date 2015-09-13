<?php
/**
 * MIGHTYminnow Components
 *
 * Component: Custom Heading
 *
 * @package mm-components
 * @since   1.0.0
 */

class MM_Custom_Heading_Widget extends WP_Widget {

	function mm_custom_heading_widget() {
		// Instantiate the parent object
		parent::__construct( false, 'MM Custom Heading' );
	}

	function widget( $args, $instance ) {
		// Widget output

		extract( $args );
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );
		$heading_text = $instance['heading_text'];
		$heading_level = $instance['heading_level'];
		$margin_bottom = $instance['margin_bottom'];
		$font_size = $instance['font_size'];
		$text_transform = $instance['text_transform'];

			$styles = array();

			$styles[] = 'margin-bottom: ' . (int)$margin_bottom . 'px;';
			$styles[] = 'font-size:' . (int)$font_size . 'px;';
			$styles[] = 'text-transform:' . $text_transform;

			$styles = implode( ' ', $styles );
			$style = ( '' !== $styles ) ? 'style="' . $styles . '"' : '';
		
		
		$options = get_option( 'mm_custom_heading_widget');
			
				$output = printf( '<%s %s>%s</%s>',
			    $heading_level,
			    $style,
			    $heading_text,
			    $heading_level 
		    );

			return $output;
		

	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['heading_text'] = strip_tags($new_instance['heading_text']);
		$instance['heading_level'] = strip_tags($new_instance['heading_level']);
		$instance['margin_bottom'] = strip_tags($new_instance['margin_bottom']);
		$instance['font_size'] = strip_tags($new_instance['font_size']);
		$instance['text_transform'] = strip_tags($new_instance['text_transform']);

		return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form

		$title = esc_attr( $instance['title'] );
		$heading_text = esc_attr( $instance['heading_text'] );
		$heading_level = esc_attr( $instance['heading_level'] );
		$margin_bottom = esc_attr( $instance['margin_bottom'] );
		$font_size = esc_attr( $instance['font_size'] );
		$text_transform = esc_attr( $instance['text_transform'] );
		
		$options = get_option( 'mm_custom_heading_widget') ;

	?>
		<p>
			<label>Heading Text</label>
			<input class="heading-text" name="<?php echo $this->get_field_name('heading_text'); ?>" type="text" value="<?php echo $heading_text;?>" />
		</p>

		<p>
			<label>Heading Level</label>
				<select name="<?php echo $this->get_field_name('heading_level'); ?>" value = "" >
				  	<option name="<?php echo $this->get_field_name('heading_level'); ?>" value="h1" <?php if($heading_level== "h1") echo "selected"; ?>>h1</option>
				  	<option name="<?php echo $this->get_field_name('heading_level'); ?>" value="h2" <?php if($heading_level== "h2") echo "selected"; ?>>h2</option>
				  	<option name="<?php echo $this->get_field_name('heading_level'); ?>" value="h3" <?php if($heading_level== "h3") echo "selected"; ?>>h3</option>
				  	<option name="<?php echo $this->get_field_name('heading_level'); ?>" value="h4" <?php if($heading_level== "h4") echo "selected"; ?>>h4</option>
				  	<option name="<?php echo $this->get_field_name('heading_level'); ?>" value="h5" <?php if($heading_level== "h5") echo "selected"; ?>>h5</option>
				  	<option name="<?php echo $this->get_field_name('heading_level'); ?>" value="h6" <?php if($heading_level== "h6") echo "selected"; ?>>h6</option>
				</select>

		</p>

		<p>
			<label>Margin Bottom</label>
			<input name="<?php echo $this->get_field_name('margin_bottom'); ?>" type="text" size="2" value="<?php echo $margin_bottom;?>" /><span>px</span>

		</p>

		<p>
			<label>Font Size</label>
			<input name="<?php echo $this->get_field_name('font_size'); ?>" type="text" size="2" value="<?php echo $font_size;?>" /><span>px</span>

		</p>

		<p>
			<label>Text Transform</label>
			<select name="<?php echo $this->get_field_name('text_transform'); ?>" value = "" >
			  	<option name="<?php echo $this->get_field_name('text_transform'); ?>" value="none" <?php if($text_transform== "none") echo "selected"; ?>>none</option>
			  	<option name="<?php echo $this->get_field_name('text_transform'); ?>" value="Uppercase" <?php if($text_transform== "Uppercase") echo "selected"; ?>>Uppercase</option>
			</select>
		</p>
	
	<?php

	}
}

function mm_custom_heading_register_widgets() {
	register_widget( 'mm_custom_heading_widget' );
}

add_action( 'widgets_init', 'mm_custom_heading_register_widgets' );



add_shortcode( 'mm_custom_heading', 'mm_custom_heading_shortcode' );
/**
 * Output Custom Heading.
 *
 * @since  1.0.0
 *
 * @param   array  $atts  Shortcode attributes.
 *
 * @return  string        Shortcode output.
 */
function mm_custom_heading_shortcode( $atts, $content = null, $tag ) {

	$atts = mm_shortcode_atts( array(
		'heading'			=> '',
		'font_family'		=> '',
		'font_size'			=> '',
		'margin_bottom'		=> '',
		'color'				=> '',
		'text_transform'	=> '',
		'text_align'		=> '',
		'link'				=> '',
	), $atts );

	$heading = ( '' !== $atts['heading'] ) ? (string)$atts['heading'] : 'h2';
	$font_family = ( '' !== $atts['font_family'] ) ? (string)$atts['font_family'] : '';
	$font_size = ( '' !== $atts['font_size'] ) ? (string)$atts['font_size'] : '';
	$margin_bottom = ( '' !== $atts['margin_bottom'] ) ? $atts['margin_bottom'] : '';
	$color = ( '' !== $atts['color'] ) ? (string)$atts['color'] : '';
	$text_transform = ( '' !== $atts['text_transform'] ) ? (string)$atts['text_transform'] : '';
	$text_align = ( '' !== $atts['text_align'] ) ? (string)$atts['text_align'] : '';
	$link = ( '' !== $atts['link'] ) ? (string)$atts['link'] : '';

	// Clean up content - this is necessary.
	//$content = wpb_js_remove_wpautop( $content, true );

	// Get link array [url, title, target]
	$link_array = vc_build_link( $link );

	// Wrap the heading in a link if one was passed in.
	if ( isset( $link_array['url'] ) && ! empty( $link_array['url'] ) ) {
		$content = '<a href="' . $link_array['url'] . '" title="' . $link_array['title'] . '">' . $content . '</a>';
	}

	// Get Mm classes.
	$mm_classes = str_replace( '_', '-', $tag );
	$mm_classes = apply_filters( 'mm_shortcode_custom_classes', $mm_classes, $tag, $atts );

	// Set up our classes array.
	$classes = array();

	if ( '' !== $font_family ) {
		$classes[] = 'font-family-' . $font_family;
	}
	if ( '' !== $font_family ) {
		$classes[] = 'font-family-' . $font_family;
	}
	if ( '' !== $font_size ) {
		$classes[] = 'font-size-' . $font_size;
	}
	if ( '' !== $color ) {
		$classes[] = 'color-' . $color;
	}
	if ( '' !== $text_transform ) {
		$classes[] = 'text-transform-' . $text_transform;
	}
	if ( '' !== $text_align ) {
		$classes[] = 'text-align-' . $text_align;
	}

	// Build our string of classes.
	$classes = implode( ' ', $classes );

	// Set up our styles array.
	$styles = array();

	if ( '' !== $margin_bottom ) {
		$styles[] = 'margin-bottom: ' . (int)$margin_bottom . 'px;';
	}

	// Build our string of styles.
	$styles = implode( ' ', $styles );
	$style = ( '' !== $styles ) ? 'style="' . $styles . '"' : '';

	$output = sprintf( '<%s class="%s" %s>%s</%s>',
		$heading,
		$mm_classes . ' ' . $classes,
		$style,
		$content,
		$heading
	);

	return $output;
}

add_action( 'vc_before_init', 'mm_vc_custom_heading' );
/**
 * Visual Composer add-on.
 *
 * @since  1.0.0
 */
function mm_vc_custom_heading() {

	vc_map( array(
		'name' => __( 'Custom Heading', 'mm-components' ),
		'base' => 'mm_custom_heading',
		'class' => '',
		'icon' => MM_COMPONENTS_ASSETS_URL . 'component_icon.png',
		'category' => __( 'Content', 'mm-components' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Heading Text', 'mm-components' ),
				'param_name' => 'content',
				'admin_label' => true,
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Heading Level', 'mm-components' ),
				'param_name' => 'heading',
				'std' => 'h2', // Default
				'value' => array(
					__( 'h1', 'mm-components ') => 'h1',
					__( 'h2', 'mm-components ') => 'h2',
					__( 'h3', 'mm-components ') => 'h3',
					__( 'h4', 'mm-components ') => 'h4',
					__( 'h5', 'mm-components ') => 'h5',
					__( 'h6', 'mm-components ') => 'h6',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin Bottom', 'mm-components' ),
				'param_name' => 'margin_bottom',
				'value' => '',
				'description' => __( 'Leave blank for default or use a number value (number of pixels). Example: 16', 'mm-components' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Family', 'mm-components' ),
				'param_name' => 'font_family',
				'value' => array(
					__( 'Default', 'mm-components ') => 'default',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Size', 'mm-components' ),
				'param_name' => 'font_size',
				'value' => array(
					__( 'Default', 'mm-components ') => 'default',
					__( '50px', 'mm-components ') => '50px',
					__( '48px', 'mm-components ') => '48px',
					__( '40px', 'mm-components ') => '40px',
					__( '36px', 'mm-components ') => '36px',
					__( '30px', 'mm-components ') => '30px',
					__( '24px', 'mm-components ') => '24px',
					__( '16px', 'mm-components ') => '16px',
					__( '14px', 'mm-components ') => '14px',
					__( '12px', 'mm-components ') => '12px',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'mm-components' ),
				'param_name' => 'color',
				'value' => array(
					__( 'Default', 'mm-components ') => 'default',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'mm-components' ),
				'param_name' => 'text_transform',
				'value' => array(
					__( 'None', 'mm-components ') => 'none',
					__( 'Uppercase', 'mm-components ') => 'uppercase',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Align', 'mm-components' ),
				'param_name' => 'text_align',
				'value' => array(
					__( 'Default', 'mm-components ') => 'default',
					__( 'Left', 'mm-components ') => 'left',
					__( 'Center', 'mm-components ') => 'center',
					__( 'Right ', 'mm-components ') => 'right',
				),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Heading Link', 'mm-components' ),
				'param_name' => 'link',
				'value' => '',
			),
		),
	) );
}
