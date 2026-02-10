/**
 * File sooda-toc.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
function sooda_smooth_scroll_and_highlight() {
    const tocLinks = document.querySelectorAll('.sooda-toc a');
    const tocSections = Array.from(tocLinks).map(link => document.getElementById(link.getAttribute('href').substring(1)));

    // Smooth Scroll
    tocLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 20,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Highlight Active Heading
    document.addEventListener('scroll', function () {
        let fromTop = window.scrollY + 20; // Ajustar este offset para mayor precisión
        let activeFound = false;

        tocSections.forEach(function (section, index) {
            let parentLi = tocLinks[index].parentElement;
            let nextSection = tocSections[index + 1];

            if (section.offsetTop <= fromTop && (!nextSection || nextSection.offsetTop > fromTop)) {
                parentLi.classList.add('active');
                activeFound = true;
            } else {
                parentLi.classList.remove('active');
            }
        });

        // Si no hay ningún elemento activo, activa el primero
        if (!activeFound && tocLinks.length > 0) {
            tocLinks[0].parentElement.classList.add('active');
        }
    });

    // Marcar el primer elemento como activo al cargar la página
    if (tocLinks.length > 0) {
        tocLinks[0].parentElement.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', sooda_smooth_scroll_and_highlight);