// external: imagesloaded.pkgd.min.js + masonry.pkgd.min.js
const grids = document.querySelectorAll('[data-bs-masonry]');
grids.forEach((grid) => {
    const attr = grid.getAttribute('data-bs-masonry');
    let settings = {
        percentPosition: true
    };
    if (attr.trim()) {
        settings = JSON.parse(attr);
    }
    imagesLoaded(grid, function () {
        new Masonry(grid, settings);
    });
});
