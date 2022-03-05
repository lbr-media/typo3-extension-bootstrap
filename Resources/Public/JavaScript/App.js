/**
 * Package: typo3-extension-bootstrap - Version 1.0.13
 * Typo3 template extension with Twitter Bootstrap 5 package.
 * Author: Marcel <mb@lbrmedia.de>
 * Build date: 2022-03-05 10:58:30
 * Copyright (c) 2022 LBRmedia
 * Released under the GPL-2.0-or-later license
 * https://github.com/lbr-media/typo3-extension-bootstrap
 */

const grids=document.querySelectorAll("[data-bs-masonry]");grids.forEach((t=>{const e=t.getAttribute("data-bs-masonry");let o={percentPosition:!0};e.trim()&&(o=JSON.parse(e)),imagesLoaded(t,(function(){new Masonry(t,o)}))}));