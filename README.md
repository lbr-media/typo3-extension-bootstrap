# typo3 extension: bootstrap

Typo3 template extension with Twitter Bootstrap 5 package.

Provides page templates and many content elements modified or build for Bootstrap 5.  
The basis of the content elements is fluid_styled_content (many are copied from this extension).

## Content elements

| Title | Description | 
| - | - |
| Accordion | Bootstrap styled Accordion component |
| Carousel | Bootstrap styled Carousel component with images. |
| Media grid | Images and videos in an adjustable grid system. Masonry is also provided. |
| Tabulator | Bootstrap styled Tabulator component |
| Text + Image | A content element to create fast a grid with one image and text. Positions, space and alignment is adjustable |
| Text & Media (float) | A text which floats a media grid. Full adjustable grid and floating settings. Some presets are available to the editor. |
| Text & Media (grid) | A text columns and a media grid columne. Full adjustable grid settings. Some presets are available to the editor. |
| Two columns text | Create fast two columns text. |
| Bullets | A list with some Bootstrap-features. |
| Div | Just a line. |
| Header | Just a header. All headers of all content elements have extra fields to adjust the needs. |
| Table | Adjustable with alle the Bootstrap classes. |
| Uploads | Realized with Bootstrap card component. |
| HTML | fluid_styled_content |
| List/Plugin | fluid_styled_content |
| Menu* | fluid_styled_content |
| Shortcut | fluid_styled_content |
| Text | fluid_styled_content |


## Install

There is a basic package at https://github.com/lbr-media/typo3-bootstrap-base which also loads a distribution extension. Maybe use it to get an example page with content or follow these steps to get a fresh and empty installation:

### 1. Install typo3 as usual with composer.

Use `composer create-project "typo3/cms-base-distribution:^11.5" my-new-project` or check the composer helper at https://get.typo3.org/misc/composer/helper.

After the backend is running you maybe have to setup the sites configuration.

### 2. Install this package.

`composer require lbr-media/typo3-extension-bootstrap`

### 3. Run the command to copy some assets to fileadmin.

`php vendor/bin/typo3 bootstrap:updatefileadmin`

### 4. Clear the cache 

Clear the cache in Install-Tool or with `php vendor/bin/typo3 cache:flush`.

### 5. Go to the backend, create a new template and include static files from extension

Include the following static templates:
* General (bootstrap)
* Content elements (bootstrap)
* Additional Styles (bootstrap)

Remove the default TypoScript config in setup field.

Now you should be able to call the frontend of the page.