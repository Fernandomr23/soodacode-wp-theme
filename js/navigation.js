/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const toggleMenu = document.querySelector('.toggle-menu');
	const openMenuIcon = document.querySelector('.open-menu');
	const closeMenuIcon = document.querySelector('.close-menu');
	const nav = document.querySelector('.main-navigation');

	toggleMenu.addEventListener('click', function() {
		nav.classList.toggle('active');
		openMenuIcon.style.display = openMenuIcon.style.display === 'none' ? 'block' : 'none';
		closeMenuIcon.style.display = closeMenuIcon.style.display === 'none' ? 'block' : 'none';
	});

}() );
