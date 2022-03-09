/**
 * @package typo3-extension-bootstrap - Typo3 template extension with Twitter Bootstrap 5 package.
 * @version 1.0.15
 * @author Marcel <mb@lbrmedia.de>
 * @date Wed, 09 Mar 2022 09:17:33 GMT
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */
var grids=document.querySelectorAll("[data-bs-masonry]");grids.forEach((function(r){var a=r.getAttribute("data-bs-masonry"),t={percentPosition:!0};a.trim()&&(t=JSON.parse(a)),imagesLoaded(r,(function(){new Masonry(r,t)}))}));