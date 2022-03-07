/**
 * @package typo3-extension-bootstrap - Typo3 template extension with Twitter Bootstrap 5 package.
 * @version v1.0.13
 * @author Marcel <mb@lbrmedia.de>
 * @date Mon, 07 Mar 2022 10:32:08 GMT
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */
var grids=document.querySelectorAll("[data-bs-masonry]");grids.forEach((function(r){var a=r.getAttribute("data-bs-masonry"),t={percentPosition:!0};a.trim()&&(t=JSON.parse(a)),imagesLoaded(r,(function(){new Masonry(r,t)}))}));