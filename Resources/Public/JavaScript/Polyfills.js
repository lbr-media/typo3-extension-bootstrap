/**
 * @package typo3-extension-bootstrap - Typo3 template extension with Twitter Bootstrap 5 package.
 * @version 1.0.14
 * @author Marcel <mb@lbrmedia.de>
 * @date Mon, 07 Mar 2022 10:37:14 GMT
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */
!function(e){if(/MSIE \d|Trident.*rv:/.test(window.navigator.userAgent)){e.createElement("picture");var t=e.createElement("script");t.src="fileadmin/bootstrap/assets/js/picturefill.min.js",e.head.appendChild(t)}}(document),function(e,t){if(!e.Promise){var r=t.createElement("script");r.src="https://unpkg.com/es6-promise@3.2.1/dist/es6-promise.min.js",t.head.appendChild(r)}if(!e.fetch){var i=t.createElement("script");i.src="https://unpkg.com/whatwg-fetch@1.0.0/fetch.js",t.head.appendChild(i)}}(window,document),window.NodeList&&!NodeList.prototype.forEach&&(NodeList.prototype.forEach=Array.prototype.forEach),Array.prototype.find||Object.defineProperty(Array.prototype,"find",{value:function(e){if(null==this)throw TypeError("'this' is null or not defined");var t=Object(this),r=t.length>>>0;if("function"!=typeof e)throw TypeError("predicate must be a function");for(var i=arguments[1],o=0;o<r;){var n=t[o];if(e.call(i,n,o,t))return n;o++}},configurable:!0,writable:!0});