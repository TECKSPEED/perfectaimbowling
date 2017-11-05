<?php
function perfectaim_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'Perfect Aim Bowling Settings' , array(
        'title'       => __( 'Perfect Aim Bowling Settings', 'Perfect Aim Bowling' ),
        'priority'    => 30,
        'description' => 'Change various settings for the Perfect Aim Bowling theme',
    ) );


    $wp_customize->add_setting( 'billing-address' );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'billing-address', array(
        'label'    => __( 'Billing Address', 'perfectaim_customize_register' ),
        'section'  => 'Perfect Aim Bowling Settings',
        'settings' => 'billing-address',
        'type'     => 'textarea',
    ) ) );
}
add_action( 'customize_register', 'perfectaim_customize_register' );
?>
