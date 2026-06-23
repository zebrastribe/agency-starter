<?php
/**
 * Primary navigation — hierarchical menus, mega panels, mobile accordion.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var string Meta key for optional mega-menu column heading override. */
const AGENCY_NAV_COLUMN_HEADING = '_agency_nav_column_heading';

/** @var string Meta key for mega-menu footer links (Label|URL per line). */
const AGENCY_NAV_MEGA_FOOTER = '_agency_nav_mega_footer';

/**
 * Fetch menu items for the primary location.
 *
 * @return array<int, WP_Post>
 */
function agency_starter_get_primary_menu_items() {
	$locations = get_nav_menu_locations();
	$menu_id   = isset( $locations['primary'] ) ? (int) $locations['primary'] : 0;

	if ( ! $menu_id ) {
		return array();
	}

	$items = wp_get_nav_menu_items( $menu_id );

	return is_array( $items ) ? $items : array();
}

/**
 * Build a nested tree from flat menu items.
 *
 * @param array<int, WP_Post> $items Menu items.
 * @return array<int, WP_Post>
 */
function agency_starter_nav_build_tree( array $items ) {
	$indexed = array();

	foreach ( $items as $item ) {
		$item->children = array();
		$indexed[ $item->ID ] = $item;
	}

	$tree = array();
	foreach ( $items as $item ) {
		$parent_id = (int) $item->menu_item_parent;
		if ( $parent_id && isset( $indexed[ $parent_id ] ) ) {
			$indexed[ $parent_id ]->children[] = $item;
		} else {
			$tree[] = $item;
		}
	}

	return $tree;
}

/**
 * Whether a menu item should use the wide mega panel layout.
 *
 * @param WP_Post $item Menu item.
 * @return bool
 */
function agency_starter_nav_uses_mega_menu( $item ) {
	if ( empty( $item->children ) ) {
		return false;
	}

	if ( in_array( 'mega-menu', (array) $item->classes, true ) || in_array( 'mega', (array) $item->classes, true ) ) {
		return true;
	}

	if ( count( $item->children ) >= 2 ) {
		return true;
	}

	foreach ( $item->children as $child ) {
		if ( ! empty( $child->children ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Whether a menu item is a non-link section heading row.
 *
 * @param WP_Post $item Menu item.
 * @return bool
 */
function agency_starter_nav_item_is_heading( $item ) {
	if ( in_array( 'nav-heading', (array) $item->classes, true ) ) {
		return true;
	}

	$url = (string) $item->url;

	return '#' === $url || '' === $url;
}

/**
 * Optional column heading from admin (empty when not set).
 *
 * @param WP_Post $item Menu item.
 * @return string
 */
function agency_starter_nav_optional_column_heading( $item ) {
	$custom = get_post_meta( $item->ID, AGENCY_NAV_COLUMN_HEADING, true );

	if ( is_string( $custom ) && '' !== trim( $custom ) ) {
		return trim( $custom );
	}

	return '';
}

/**
 * Parse mega-menu footer links from parent item meta.
 *
 * @param WP_Post $item Top-level menu item.
 * @return array<int, array{label: string, url: string}>
 */
function agency_starter_nav_mega_footer_links( $item ) {
	$raw = get_post_meta( $item->ID, AGENCY_NAV_MEGA_FOOTER, true );
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return array();
	}

	$links = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line || str_starts_with( $line, '|' ) ) {
			continue;
		}

		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( count( $parts ) < 2 || '' === $parts[0] || '' === $parts[1] ) {
			continue;
		}

		$links[] = array(
			'label' => $parts[0],
			'url'   => $parts[1],
		);
	}

	return $links;
}

/**
 * Resolve internal paths to full URLs.
 *
 * @param string $href Raw href.
 * @return string
 */
function agency_starter_nav_resolve_url( $href ) {
	if ( $href && str_starts_with( $href, '/' ) ) {
		return home_url( $href );
	}

	return $href;
}

/**
 * Item classes for front-end markup.
 *
 * @param WP_Post $item Menu item.
 * @return array<int, string>
 */
function agency_starter_nav_item_classes( $item ) {
	$classes = array( 'wp-block-navigation-item', 'menu-item', 'menu-item-' . $item->ID );

	if ( ! empty( $item->children ) ) {
		$classes[] = 'menu-item-has-children';
	}

	foreach ( (array) $item->classes as $class ) {
		if ( $class ) {
			$classes[] = sanitize_html_class( $class );
		}
	}

	if ( in_array( 'current-menu-item', (array) $item->classes, true ) || in_array( 'current_page_item', (array) $item->classes, true ) ) {
		$classes[] = 'current-menu-item';
	}

	return $classes;
}

/**
 * Render a single menu link.
 *
 * @param WP_Post $item Menu item.
 * @param string  $link_class Link CSS class.
 * @param bool    $show_description Whether to output description text.
 * @return string
 */
function agency_starter_nav_render_link( $item, $link_class = 'wp-block-navigation-item__content', $show_description = false ) {
	if ( agency_starter_nav_item_is_heading( $item ) ) {
		return sprintf(
			'<span class="agency-nav-heading">%s</span>',
			esc_html( agency_starter_nav_optional_column_heading( $item ) ?: agency_starter_nav_menu_label( (string) $item->title ) )
		);
	}

	$html  = sprintf(
		'<a class="%1$s" href="%2$s">',
		esc_attr( $link_class ),
		esc_url( agency_starter_nav_resolve_url( (string) $item->url ) )
	);
	$html .= sprintf( '<span class="wp-block-navigation-item__label">%s</span>', esc_html( agency_starter_nav_menu_label( (string) $item->title ) ) );

	if ( $show_description && ! empty( $item->description ) ) {
		$html .= sprintf(
			'<span class="agency-nav-link__description">%s</span>',
			esc_html( $item->description )
		);
	}

	$html .= '</a>';

	return $html;
}

/**
 * Render nested links inside a mega-menu group.
 *
 * @param WP_Post $parent Parent menu item.
 * @return string
 */
function agency_starter_nav_render_mega_nested_links( $parent ) {
	if ( empty( $parent->children ) ) {
		return '';
	}

	$html = '<ul class="agency-mega-panel__nested">';

	foreach ( $parent->children as $child ) {
		if ( agency_starter_nav_item_is_heading( $child ) ) {
			$html .= sprintf(
				'<li class="agency-mega-panel__nested-heading"><span>%s</span></li>',
				esc_html( agency_starter_nav_optional_column_heading( $child ) ?: agency_starter_nav_menu_label( (string) $child->title ) )
			);
			continue;
		}

		$html .= '<li class="agency-mega-panel__nested-item">';
		$html .= agency_starter_nav_render_link( $child, 'agency-mega-panel__nested-link', ! empty( $child->description ) );
		$html .= '</li>';
	}

	$html .= '</ul>';

	return $html;
}

/**
 * Render one mega-menu column.
 *
 * @param WP_Post $column Column root item.
 * @return string
 */
function agency_starter_nav_render_mega_column( $column ) {
	$heading      = agency_starter_nav_optional_column_heading( $column );
	$has_children = ! empty( $column->children );

	if ( ! $has_children && agency_starter_nav_item_is_heading( $column ) ) {
		return '';
	}

	$html = '<div class="agency-mega-panel__column">';

	if ( $heading ) {
		$html .= sprintf(
			'<p class="agency-mega-panel__column-heading">%s</p>',
			esc_html( $heading )
		);
	}

	$html .= '<ul class="agency-mega-panel__links">';

	if ( ! $has_children ) {
		$html .= '<li class="agency-mega-panel__link-item">';
		$html .= agency_starter_nav_render_link( $column, 'agency-mega-panel__link', true );
		$html .= '</li></ul></div>';

		return $html;
	}

	$html .= '<li class="agency-mega-panel__group">';
	$html .= '<div class="agency-mega-panel__group-head">';

	if ( agency_starter_nav_item_is_heading( $column ) ) {
		$html .= sprintf(
			'<span class="agency-mega-panel__group-title">%s</span>',
			esc_html( agency_starter_nav_menu_label( (string) $column->title ) )
		);
	} else {
		$html .= agency_starter_nav_render_link( $column, 'agency-mega-panel__link agency-mega-panel__link--parent', ! empty( $column->description ) );
	}

	$html .= '</div>';
	$html .= agency_starter_nav_render_mega_nested_links( $column );
	$html .= '</li></ul></div>';

	return $html;
}

/**
 * Render mega-menu panel for a top-level item.
 *
 * @param WP_Post $item Top-level menu item.
 * @return string
 */
function agency_starter_nav_render_mega_panel( $item ) {
	$footer_links = agency_starter_nav_mega_footer_links( $item );

	$html  = sprintf(
		'<div class="agency-mega-panel" data-mega-panel data-mega-for="%1$d" id="agency-mega-panel-%1$d" role="region" aria-label="%2$s">',
		(int) $item->ID,
		esc_attr( sprintf( agency_starter_t( '%s submenu' ), agency_starter_nav_menu_label( (string) $item->title ) ) )
	);
	$html .= '<div class="agency-mega-panel__surface">';
	$html .= '<div class="agency-mega-panel__inner agency-container">';
	$html .= '<div class="agency-mega-panel__grid">';

	foreach ( $item->children as $column ) {
		$column_html = agency_starter_nav_render_mega_column( $column );
		if ( $column_html ) {
			$html .= $column_html;
		}
	}

	$html .= '</div>';

	$html .= '<div class="agency-mega-panel__footer">';
	if ( ! empty( $footer_links ) ) {
		$html .= '<div class="agency-mega-panel__footer-links">';
		foreach ( $footer_links as $link ) {
			$html .= sprintf(
				'<a class="agency-mega-panel__footer-link" href="%1$s">%2$s</a>',
				esc_url( agency_starter_nav_resolve_url( $link['url'] ) ),
				esc_html( $link['label'] )
			);
		}
		$html .= '</div>';
	}
	$html .= sprintf(
		'<button type="button" class="agency-mega-panel__close" data-mega-close>%1$s <span aria-hidden="true">&times;</span></button>',
		esc_html( agency_starter_t( 'Close' ) )
	);
	$html .= '</div>';

	$html .= '</div></div></div>';

	return $html;
}

/**
 * Render a simple dropdown submenu.
 *
 * @param WP_Post $item Parent menu item.
 * @return string
 */
function agency_starter_nav_render_dropdown_panel( $item ) {
	$html  = sprintf(
		'<div class="agency-nav-dropdown" data-nav-dropdown data-nav-for="%1$d" id="agency-nav-dropdown-%1$d" role="menu">',
		(int) $item->ID
	);
	$html .= '<ul class="agency-nav-dropdown__list">';

	foreach ( $item->children as $child ) {
		$child_classes = agency_starter_nav_item_classes( $child );
		if ( ! empty( $child->children ) ) {
			$child_classes[] = 'agency-nav-dropdown__item--branch';
		}

		$html .= sprintf( '<li class="%s" role="none">', esc_attr( implode( ' ', $child_classes ) ) );
		$html .= agency_starter_nav_render_link( $child, 'agency-nav-dropdown__link', ! empty( $child->description ) );

		if ( ! empty( $child->children ) ) {
			$html .= '<ul class="agency-nav-dropdown__sublist" role="menu">';
			foreach ( $child->children as $grandchild ) {
				$html .= sprintf( '<li class="%s" role="none">', esc_attr( implode( ' ', agency_starter_nav_item_classes( $grandchild ) ) ) );
				$html .= agency_starter_nav_render_link( $grandchild, 'agency-nav-dropdown__link agency-nav-dropdown__link--child', ! empty( $grandchild->description ) );
				$html .= '</li>';
			}
			$html .= '</ul>';
		}

		$html .= '</li>';
	}

	$html .= '</ul></div>';

	return $html;
}

/**
 * Render one desktop top-level navigation item.
 *
 * @param WP_Post $item Menu item.
 * @return string
 */
function agency_starter_nav_render_desktop_item( $item ) {
	$classes = agency_starter_nav_item_classes( $item );

	if ( empty( $item->children ) ) {
		$html  = sprintf( '<li class="%s">', esc_attr( implode( ' ', $classes ) ) );
		$html .= agency_starter_nav_render_link( $item );
		$html .= '</li>';

		return $html;
	}

	$uses_mega = agency_starter_nav_uses_mega_menu( $item );
	if ( $uses_mega ) {
		$classes[] = 'agency-nav-item--mega';
	}

	$panel_id = $uses_mega ? 'agency-mega-panel-' . (int) $item->ID : 'agency-nav-dropdown-' . (int) $item->ID;

	$html  = sprintf( '<li class="%s" data-nav-item="%d">', esc_attr( implode( ' ', $classes ) ), (int) $item->ID );
	$html .= '<div class="agency-nav-item__control">';

	if ( ! agency_starter_nav_item_is_heading( $item ) ) {
		$html .= agency_starter_nav_render_link( $item, 'agency-nav-parent-link wp-block-navigation-item__content' );
	} else {
		$html .= sprintf(
			'<span class="agency-nav-parent-link wp-block-navigation-item__content"><span class="wp-block-navigation-item__label">%s</span></span>',
			esc_html( agency_starter_nav_menu_label( (string) $item->title ) )
		);
	}

	$html .= sprintf(
		'<button type="button" class="agency-nav-trigger" aria-expanded="false" aria-haspopup="true" aria-controls="%1$s" data-nav-trigger><span class="screen-reader-text">%2$s</span><span class="agency-nav-trigger__chevron" aria-hidden="true"></span></button>',
		esc_attr( $panel_id ),
		esc_html( sprintf( agency_starter_t( 'Open %s submenu' ), agency_starter_nav_menu_label( (string) $item->title ) ) )
	);
	$html .= '</div></li>';

	return $html;
}

/**
 * Render one mobile navigation branch.
 *
 * @param WP_Post $item Menu item.
 * @param int     $depth Nesting depth.
 * @return string
 */
function agency_starter_nav_render_mobile_item( $item, $depth = 0 ) {
	if ( empty( $item->children ) ) {
		return sprintf(
			'<li class="mobile-nav-item mobile-nav-item--depth-%1$d"><a class="mobile-nav-link" href="%2$s">%3$s</a></li>',
			(int) $depth,
			esc_url( agency_starter_nav_resolve_url( (string) $item->url ) ),
			esc_html( agency_starter_nav_menu_label( (string) $item->title ) )
		);
	}

	$html  = sprintf( '<li class="mobile-nav-item mobile-nav-item--branch mobile-nav-item--depth-%d">', (int) $depth );
	$html .= '<div class="mobile-nav-branch-row">';
	$html .= sprintf(
		'<a class="mobile-nav-link mobile-nav-link--parent" href="%1$s">%2$s</a>',
		esc_url( agency_starter_nav_resolve_url( (string) $item->url ) ),
		esc_html( agency_starter_nav_menu_label( (string) $item->title ) )
	);
	$html .= sprintf(
		'<button type="button" class="mobile-nav-branch" aria-expanded="false" data-mobile-branch aria-label="%1$s"><span class="mobile-nav-branch__chevron" aria-hidden="true"></span></button>',
		esc_attr( sprintf( agency_starter_t( 'Expand %s' ), agency_starter_nav_menu_label( (string) $item->title ) ) )
	);
	$html .= '</div>';
	$html .= '<ul class="mobile-nav-branch__list" hidden>';

	foreach ( $item->children as $child ) {
		$html .= agency_starter_nav_render_mobile_item( $child, $depth + 1 );
	}

	$html .= '</ul></li>';

	return $html;
}

/**
 * Collect submenu panels for items with children.
 *
 * @param array<int, WP_Post> $tree Menu tree.
 * @return string
 */
function agency_starter_nav_render_submenu_panels( array $tree ) {
	$html = '';

	foreach ( $tree as $item ) {
		if ( empty( $item->children ) ) {
			continue;
		}

		$html .= agency_starter_nav_uses_mega_menu( $item )
			? agency_starter_nav_render_mega_panel( $item )
			: agency_starter_nav_render_dropdown_panel( $item );
	}

	return $html;
}

/**
 * Render primary menu as block-compatible navigation markup.
 *
 * @return string
 */
function agency_starter_get_primary_nav_markup() {
	$items = agency_starter_get_primary_menu_items();

	if ( empty( $items ) ) {
		return agency_starter_fallback_nav_markup();
	}

	$tree = agency_starter_nav_build_tree( $items );

	$html  = '<nav class="primary-nav desktop-nav wp-block-navigation" aria-label="' . agency_starter_esc_attr__( 'Primary' ) . '">';
	$html .= '<ul class="wp-block-navigation__container primary-nav__list">';

	foreach ( $tree as $item ) {
		$html .= agency_starter_nav_render_desktop_item( $item );
	}

	$html .= '</ul>';
	$html .= '<div class="agency-nav-panels" data-nav-panels>';
	$html .= agency_starter_nav_render_submenu_panels( $tree );
	$html .= '</div>';
	$html .= '</nav>';

	return $html;
}

/**
 * Render mobile navigation list markup.
 *
 * @return string
 */
function agency_starter_get_mobile_nav_markup() {
	$items = agency_starter_get_primary_menu_items();

	if ( empty( $items ) ) {
		$links = array(
			array( __( 'Home', 'agency-starter' ), home_url( '/' ) ),
			array( __( 'Employers', 'agency-starter' ), home_url( '/employers/' ) ),
			array( __( 'Candidates', 'agency-starter' ), home_url( '/candidates/' ) ),
			array( __( 'Jobs', 'agency-starter' ), home_url( '/kandidater/it-jobs/' ) ),
			array( __( 'Contact', 'agency-starter' ), home_url( '/contact/' ) ),
		);

		$html = '<ul class="mobile-nav-list">';
		foreach ( $links as $link ) {
			$html .= sprintf(
				'<li class="mobile-nav-item"><a class="mobile-nav-link" href="%1$s">%2$s</a></li>',
				esc_url( $link[1] ),
				esc_html( $link[0] )
			);
		}
		$html .= '</ul>';

		return $html;
	}

	$tree = agency_starter_nav_build_tree( $items );
	$html = '<ul class="mobile-nav-list">';

	foreach ( $tree as $item ) {
		$html .= agency_starter_nav_render_mobile_item( $item );
	}

	$html .= '</ul>';

	return $html;
}

/**
 * Fallback nav when no menu is assigned.
 *
 * @return string
 */
function agency_starter_fallback_nav_markup() {
	$links = array(
		array( __( 'Home', 'agency-starter' ), home_url( '/' ) ),
		array( __( 'Employers', 'agency-starter' ), home_url( '/employers/' ) ),
		array( __( 'Candidates', 'agency-starter' ), home_url( '/candidates/' ) ),
		array( __( 'Jobs', 'agency-starter' ), home_url( '/kandidater/it-jobs/' ) ),
		array( __( 'Contact', 'agency-starter' ), home_url( '/contact/' ) ),
	);

	$html  = '<nav class="primary-nav desktop-nav wp-block-navigation" aria-label="' . agency_starter_esc_attr__( 'Primary' ) . '">';
	$html .= '<ul class="wp-block-navigation__container primary-nav__list">';

	foreach ( $links as $link ) {
		$html .= '<li class="wp-block-navigation-item menu-item">';
		$html .= '<a class="wp-block-navigation-item__content" href="' . esc_url( $link[1] ) . '">';
		$html .= '<span class="wp-block-navigation-item__label">' . esc_html( $link[0] ) . '</span>';
		$html .= '</a></li>';
	}

	$html .= '</ul></nav>';

	return $html;
}

/**
 * Replace static navigation block in header with dynamic primary menu.
 *
 * @param string $block_content Block HTML.
 * @param array  $block         Block data.
 * @return string
 */
function agency_starter_render_primary_navigation( $block_content, $block ) {
	$class = $block['attrs']['className'] ?? '';
	if ( false === strpos( $class, 'primary-nav' ) ) {
		return $block_content;
	}

	return agency_starter_get_primary_nav_markup();
}

add_filter( 'render_block_core/navigation', 'agency_starter_render_primary_navigation', 10, 2 );

/**
 * Mobile nav overlay — rendered in footer so it stays outside the header landmark.
 */
function agency_starter_render_mobile_nav_panel() {
	?>
	<div id="mobile-nav-panel" class="mobile-nav-panel" role="dialog" aria-modal="true" aria-label="<?php echo agency_starter_esc_attr__( 'Mobile navigation' ); ?>" hidden>
		<button type="button" class="mobile-nav-panel__backdrop" aria-label="<?php echo agency_starter_esc_attr__( 'Close menu' ); ?>" tabindex="-1"></button>
		<div class="mobile-nav-panel__drawer">
			<div class="mobile-nav-panel__close">
				<button type="button" class="mobile-nav-close" aria-label="<?php echo agency_starter_esc_attr__( 'Close menu' ); ?>">&#10005;</button>
			</div>
			<div class="mobile-nav-links">
				<?php echo agency_starter_get_mobile_nav_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'agency_starter_render_mobile_nav_panel', 5 );

/**
 * Add mega-menu fields to the menu item editor.
 *
 * @param int     $item_id Menu item ID.
 * @param WP_Post $item    Menu item object.
 * @param int     $depth   Menu item depth.
 * @param array   $args    Walker args.
 * @return void
 */
function agency_starter_nav_menu_item_custom_fields( $item_id, $item, $depth, $args ) {
	unset( $args, $item );
	$column_heading = get_post_meta( $item_id, AGENCY_NAV_COLUMN_HEADING, true );
	$mega_footer    = get_post_meta( $item_id, AGENCY_NAV_MEGA_FOOTER, true );
	?>
	<p class="field-agency-column-heading description description-wide">
		<label for="agency-nav-column-heading-<?php echo esc_attr( (string) $item_id ); ?>">
			<?php esc_html_e( 'Column heading (optional)', 'agency-starter' ); ?><br />
			<input
				type="text"
				id="agency-nav-column-heading-<?php echo esc_attr( (string) $item_id ); ?>"
				class="widefat"
				name="agency_nav_column_heading[<?php echo esc_attr( (string) $item_id ); ?>]"
				value="<?php echo esc_attr( (string) $column_heading ); ?>"
				placeholder="<?php esc_attr_e( 'e.g. BY TEAM', 'agency-starter' ); ?>"
			/>
		</label>
		<span class="description"><?php esc_html_e( 'Optional uppercase section title above a mega-menu column. Leave empty to hide the heading. Use Description (Screen Options) for link subtitles.', 'agency-starter' ); ?></span>
	</p>
	<?php if ( 0 === (int) $depth ) : ?>
		<p class="field-agency-mega-footer description description-wide">
			<label for="agency-nav-mega-footer-<?php echo esc_attr( (string) $item_id ); ?>">
				<?php esc_html_e( 'Mega menu footer links (optional)', 'agency-starter' ); ?><br />
				<textarea
					id="agency-nav-mega-footer-<?php echo esc_attr( (string) $item_id ); ?>"
					class="widefat"
					rows="3"
					name="agency_nav_mega_footer[<?php echo esc_attr( (string) $item_id ); ?>]"
					placeholder="<?php esc_attr_e( "Book a demo|/contact/\nHelp center|/help/", 'agency-starter' ); ?>"
				><?php echo esc_textarea( (string) $mega_footer ); ?></textarea>
			</label>
			<span class="description"><?php esc_html_e( 'Optional. One link per line: Label|URL', 'agency-starter' ); ?></span>
		</p>
	<?php endif; ?>
	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'agency_starter_nav_menu_item_custom_fields', 10, 4 );

/**
 * Persist mega-menu custom fields.
 *
 * @param int $menu_id         Menu ID.
 * @param int $menu_item_db_id Menu item ID.
 * @return void
 */
function agency_starter_save_nav_menu_item_meta( $menu_id, $menu_item_db_id ) {
	unset( $menu_id );

	if ( isset( $_POST['agency_nav_column_heading'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		update_post_meta(
			$menu_item_db_id,
			AGENCY_NAV_COLUMN_HEADING,
			sanitize_text_field( wp_unslash( $_POST['agency_nav_column_heading'][ $menu_item_db_id ] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
		);
	}

	if ( isset( $_POST['agency_nav_mega_footer'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		update_post_meta(
			$menu_item_db_id,
			AGENCY_NAV_MEGA_FOOTER,
			sanitize_textarea_field( wp_unslash( $_POST['agency_nav_mega_footer'][ $menu_item_db_id ] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
		);
	}
}
add_action( 'wp_update_nav_menu_item', 'agency_starter_save_nav_menu_item_meta', 10, 2 );

/**
 * Ensure Description column is available on the Menus screen.
 *
 * @param array<string, string> $columns Menu screen columns.
 * @return array<string, string>
 */
function agency_starter_nav_menu_admin_columns( $columns ) {
	if ( ! isset( $columns['description'] ) ) {
		$columns['description'] = __( 'Description', 'agency-starter' );
	}

	return $columns;
}
add_filter( 'manage_nav-menus_columns', 'agency_starter_nav_menu_admin_columns' );
