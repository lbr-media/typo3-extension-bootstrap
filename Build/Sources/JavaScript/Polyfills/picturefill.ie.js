
/**
 * Check for IE browser (10, 11) and add picturefill
 */
!function (d) {
    if (/MSIE \d|Trident.*rv:/.test(window.navigator.userAgent)) {
        /**
         * Creates the element for picturefill. 
         * Must be loaded before picturefill!
         */
        d.createElement('picture');

        /**
         * Add picturefill script to header
         */
        let s = d.createElement('script')
        s.src = 'fileadmin/bootstrap/assets/js/picturefill.min.js'
        d.head.appendChild(s);
    }
}(document)