<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action( 'generate_before_content' );
		?>

		<header class="entry-header">
			<?php
			/**
			 * generate_before_entry_title hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_entry_title' );

			if ( generate_show_title() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			}

			/**
			 * generate_after_entry_title hook.
			 *
			 * @since 0.1
			 *
			 * @hooked generate_post_meta - 10
			 */
			do_action( 'generate_after_entry_title' );
			?>
		</header><!-- .entry-header -->

		<?php
		/**
		 * generate_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_post_image - 10
		 */
		do_action( 'generate_after_entry_header' );
		?>

		<div class="entry-content" itemprop="text">
			<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

		<div class="entry-content-meta" itemprop="text">

			<?php

				// Render Address
				if ( ! empty( get_field( 'public_display' ) && ! empty( get_field( 'address' ) ) ) ) {

					print '<div id="business_address" class="business-meta">' . "\n";

						print '<h3>' . esc_html__( 'Address:', 'generatepress' ) . '</h3>';

						print '<p><a href="https://www.google.com/maps/place/' . urlencode( esc_html( get_field( 'address' ) ) ) . '">' . esc_html( get_field( 'address' ) ) . '</a></p>';

					print '</div>' . "\n";

				}

				// get contact preferences
				$contact_prefs = get_field('contact_preference');

				// Render contact stuff
				if ( ! empty( $contact_prefs ) ) {

					// make sure prefs is an array
					if ( ! is_array( $contact_prefs ) ) {
						$contact_prefs = [ $contact_prefs ];
					}

					print '<div id="business_contact" class="business-meta">' . "\n";

						print '<h3>' . esc_html__( 'Contact Information', 'generatepress' ) . '</h3>';

						if ( ! empty( get_field( 'phone' ) ) && in_array( 'Phone', $contact_prefs ) ) {
							print '<p id="business_phone">' . esc_html__( 'Phone', 'generatepress' ) . ': ' . esc_html( get_field( 'phone' ) ) . '</p>';
						}

						if ( ! empty( get_field('website') ) && in_array( 'Online', $contact_prefs ) ) {
							print '<p id="business_website">' . esc_html__( 'Website', 'generatepress' ) . ': <a href="' . esc_url( get_field( 'website' ) ) . '">' . esc_url( get_field( 'website' ) ) . '</a></p>';
						}

					print '</div>';

				}

				// go get the the social network links
				$social = explode( "\n", get_field( 'social_media' ) );

				if( ! empty( $social ) && ! empty( $social[0] )) {

					print '<div id="social_links" class="business-meta">' . "\n";

					print '<h3>' . esc_html__( 'Social Links', 'generatepress' ) . '</h3>';

					print '<ul>' . "\n";

					foreach( $social as $url ) {
						print '<li><a href="' . $url . '">' . esc_url( $url ) . '</a></li>' . "\n";
					}

					print '</ul>' . "\n";

					print '</div>';

				}


				if( ! empty( get_field( 'delivery_area' ) ) || ! empty( get_field( 'delivery_alternative' ) ) ) { 

					print '<div id="business_delivery_options" class="business-meta">' . "\n";

					if( ! empty( get_field( 'delivery_area' ) ) ) {
						print '<h3>' . esc_html__( 'Delivery Options', 'generatepress' ) . '</h3>';

						print wpautop( esc_textarea( strip_tags( get_field( 'delivery_area' ) ) ) );
					}

					if( ! empty( get_field( 'delivery_alternative' ) ) ) {
						print '<h3>' . esc_html__( 'Delivery Alternatives', 'generatepress' ) . '</h3>';

						print wpautop( esc_textarea( strip_tags( get_field( 'delivery_alternative' ) ) ) );
					}

					print '</div>';

				}

				$types = get_the_terms( $post->ID , 'smbl_business_type' ); 

				if ( ! empty( $types ) ) {

					print '<p id="type"><span>' . esc_html__( 'Business Type', 'generatepress' ) . ':</span> ';

					$type_output = '';

					foreach ( $types as $type ) {
						$term_link = get_term_link( $type, 'smbl_business_type' );
						if( is_wp_error( $term_link ) )
						continue;
						$type_output .= '<a href="' . $term_link . '">' . $type->name . '</a>, ';
					} 

					print trim( $type_output, ', ' );

					print '</p>';

				}



				$locations = get_the_terms( $post->ID , 'smbl_business_location' ); 

				if ( ! empty( $locations ) ) {

					print '<p id="location"><span>' . esc_html__( 'Location', 'generatepress' ) . ':</span> ';

					$location_output = '';

					foreach ( $locations as $location ) {
						$term_link = get_term_link( $location, 'smbl_business_location' );
						if( is_wp_error( $term_link ) )
						continue;
						$location_output .= '<a href="' . $term_link . '">' . $location->name . '</a>, ';
					} 

					print trim( $location_output, ', ' );;

					print '</p>';

				}


			?>

		</div><!-- .entry-content -->
		<?php
		/**
		 * generate_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_footer_meta - 10
		 */
		do_action( 'generate_after_entry_content' );

		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'generate_after_content' );
		?>
	</div><!-- .inside-article -->
</article><!-- #post-## -->
