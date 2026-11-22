<?php
/** Site content controls without requiring an external custom-field plugin. */
defined( 'ABSPATH' ) || exit;

function northline_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'northline_home_section', array(
		'title'       => __( 'Northline — Homepage', 'northline' ),
		'priority'    => 31,
		'description' => __( 'Edit the editorial hero and studio contact details.', 'northline' ),
	) );
	$controls = array(
		'northline_eyebrow' => array( 'label' => __( 'Hero eyebrow', 'northline' ), 'default' => 'Architecture & Spatial Design', 'type' => 'text' ),
		'northline_title'   => array( 'label' => __( 'Hero headline', 'northline' ), 'default' => 'Places with purpose. Spaces with soul.', 'type' => 'text' ),
		'northline_intro'   => array( 'label' => __( 'Hero description', 'northline' ), 'default' => 'Thoughtfully designed environments where material, light and human experience come together.', 'type' => 'textarea' ),
		'northline_email'   => array( 'label' => __( 'Contact email', 'northline' ), 'default' => 'hello@example.com', 'type' => 'email' ),
	);
	foreach ( $controls as $id => $control ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $control['default'],
			'sanitize_callback' => 'email' === $control['type'] ? 'sanitize_email' : ( 'textarea' === $control['type'] ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $control['label'],
			'section' => 'northline_home_section',
			'type'    => $control['type'],
		) );
	}
}
add_action( 'customize_register', 'northline_customize_register' );
