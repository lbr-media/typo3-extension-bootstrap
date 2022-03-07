/**
 * Check for IE browser (10, 11) and add promise support
 */
!function (w, d) {
    if (!w.Promise) {
        let a = d.createElement('script');
        a.src = 'https://unpkg.com/es6-promise@3.2.1/dist/es6-promise.min.js';
        d.head.appendChild(a);
    }
    if (!w.fetch) {
        let b = d.createElement('script');
        b.src = 'https://unpkg.com/whatwg-fetch@1.0.0/fetch.js';
        d.head.appendChild(b);
    }
}(window, document)