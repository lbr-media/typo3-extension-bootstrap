# typo3 extension: bootstrap

Typo3 template extension with Twitter Bootstrap 5 package.

Provides page templates and many content elements modified or build for Bootstrap 5.  
The basis of the content elements is fluid_styled_content (many are copied from this extension).

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

## Content elements

### All content elements

All content elements have extra or modified fields.

#### Fields
* _Frame class_  
Here you'll find the Bootstrap container* classes.
* _Inner frame class_  
Like the frame class but will create an inner div when a value is selected.
* _Additional styles_  
Many styles are selectable for a content element. Use this to configure modifications like indents, etc.
In TypoScript several styles can be configured.  
You'll find them with the key `plugin.tx_bootstrap.settings.form.element.AdditionalStyles`.  
Each variant may have these properties:
    * `label`
    * `outerWrap`
    * `innerWrap`
    * `additionalClass`
    * `additionalAttributes` (key value pairs)
    * `additionalOuterClass`
    * `additionalOuterAttributes` (key value pairs)
* _Color_
* _Background color_
* _Space before_
* _Space after_

The defaults of `space_before_class` and `space_after_class` will be replaced with Bootstrap space classes.  
You'll find them with the keys `plugin.tx_bootstrap.settings.form.element.SpaceBeforeClassReplacements` and `plugin.tx_bootstrap.settings.form.element.SpaceAfterClassReplacements`. So you don't need extra classes for the space between content elements.


---

### All headers

All headers of all content elements have extra or modified fields.

#### Fields
* _Header_
* _Header layout_ aka _Type_.  
The tag that will be generated (`h1` to `h5`).
* _Layout_  
The basic css-class that will be used for the tag.
The default Bootstrap classes from `display-1` to `display-6`, `h1` to `h6` and `lead`.  
* _Variant_ or _Predefined header_
Only one variant is selectable. Use this to produce some variants of headers.
In TypoScript several variants can be configured. You'll find them with the key `plugin.tx_bootstrap.settings.form.element.PredefinedHeader`.  
Each variant may have these properties:
    * `label`
    * `outerWrap`
    * `innerWrap`
    * `additionalClass`
* _Color_
* _Position_ (`start`, `center`, `right`)
* _Date_
* _Additional styles_  
Many styles are selectable for a headline. Use this to configure modifications like uppercase, no space below, etc.
In TypoScript several styles can be configured.  
You'll find them with the key `plugin.tx_bootstrap.settings.form.element.AdditionalHeaderStyles`.  
Each variant may have these properties:
    * `label`
    * `outerWrap`
    * `innerWrap`
    * `additionalClass`
* _Icon_
* _Link_
* _Subheader_

---


### Accordion
Bootstrap styled Accordion component

One accordion content element has one or many accordion items.  
Each accordion item may have one or many `Text & media (grid)` content elements.  

#### Settings for all items:
* _Keep items open on opening other items_

#### Settings each item:
* _Opened on load_

---

### Carousel
Bootstrap styled Carousel component with images.

#### Settings:
* _Animation_ (`slide` or `fade`)
* _Autoplay_
* _Color scheme_ (`light`, `dark`)
* _Show controls_
* _Show indicators_
* _Interval_

#### Image properties:
* _Header_
* _Title_
* _Alternative_
* _Description_
* _Link_
* _Link text_
* _Crop_ (each device from xs to xxl)

---

### Cards
Bootstrap styled Cards component in a grid system.

#### Settings:
* _Presets_
* Grid:
    * _Cols_ (each device from xs to xxl)
    * _Gutter space x_ (each device from xs to xxl)
    * _Gutter space y_ (each device from xs to xxl)
    * _Align x_ (each device from xs to xxl)
    * _Align y_ (each device from xs to xxl)
* Cards:
    * _Image position_ (`above`, `below`, `start`, `end`)
    * _Background color_
    * _Text color_
    * _Border color_
    * _Button color/style_
* _Image optimizing_ (produced percentual window width from xs to xxl)


#### Card-item properties:
* _Header_
* _Title_
* _Image_
* _Text_
* _Link_
* _Link text_
* _Footer_

---

### Media grid
Images and videos in an adjustable grid system. Masonry is also provided.

#### Settings:
* _Presets_
* Use _masonry grid_
* Grid:
    * _Cols_ (each device from xs to xxl)
    * _Gutter space x_ (each device from xs to xxl)
    * _Gutter space y_ (each device from xs to xxl)
    * _Align x_ (each device from xs to xxl)
    * _Align y_ (each device from xs to xxl)
* _Image optimizing_ (produced percentual window width from xs to xxl)

---

### Tabulator
Bootstrap styled Tabulator component

One tabulator content element has one or many tabulator items.  
Each tabulator item may have one or many `Text & media (grid)` content elements.  

#### Settings for all items:
* _Layout_ (`default`, `pills horizontal`, `pills vertical`)
* _Navigation alignment_ (only on horizontal)
    * `start`
    * `center`
    * `end`
    * `nav fill`
    * `nav justified`

#### Settings each item:
* _active_  
Only one can be active. The first found with active state is used. If no one is active, the first item is marked as active.

---

### Text + Image
A content element to create fast a grid with one image and text. Positions, space and alignment is adjustable

# Settings:
* _Presets_
* _Order_ (`first image` or `first text`)
* _Image alignment_ (`top` or `bottom`)
* _Text alignment_ (`top` or `bottom`)
* _Header position_ (`above all`, `above text` or `above image`)
* _Space between_ text and image (each device from xs to xxl)
---

### Text & Media (float)
A text which floats a media grid. Full adjustable grid and floating settings. Some presets are available to the editor.

#### Settings:
* _Presets_
* _Header position_ (`above all` or `above text`)
* Media area:
    * _Position_ (`centered above text`, `left` or `right`; each device from xs to xxl)
    * _Width_ (each device from xs to xxl)
    * _Space x_ (each device from xs to xxl)
    * _Space y_ (each device from xs to xxl)
* _Use masonry grid_
* Grid for the media items:
    * _Cols_ (each device from xs to xxl)
    * _Gutter space x_ (each device from xs to xxl)
    * _Gutter space y_ (each device from xs to xxl)
    * _Align x_ (each device from xs to xxl)
    * _Align y_ (each device from xs to xxl)
* _Image optimizing_ (produced percentual window width from xs to xxl)

---

### Text & Media (grid)
A text column and a media grid column. The most flexible content element.

#### Settings:
* _Presets_
* _Default order_ of text- and media-area (`first image` or `first text`)
* _Order per each device_ from xs to xxl
* _Header position_ (`above all`, `above text` or `above media area`)
* Grid for the text- and media-columns:
    * _Cols text-column_ (each device from xs to xxl)
    * _Cols media-column_ (each device from xs to xxl)
    * _Gutter space x_ (each device from xs to xxl)
    * _Gutter space y_ (each device from xs to xxl)
    * _Align x_ (each device from xs to xxl)
    * _Align y_ (each device from xs to xxl)
* Text-column:
    * _Align self_ (each device from xs to xxl)
    * _Inner space_ (each device from xs to xl)
* Media-column:
    * _Use masonry grid_
    * _Align self_ (each device from xs to xxl)
    * _Inner space_ (each device from xs to xl)
* Grid for the media items:
    * _Cols_ (each device from xs to xxl)
    * _Gutter space x_ (each device from xs to xxl)
    * _Gutter space y_ (each device from xs to xxl)
    * _Align x_ (each device from xs to xxl)
    * _Align y_ (each device from xs to xxl)
* _Image optimizing_ (produced percentual window width from xs to xxl)

---

### Two columns text
Create fast two columns text.

---

### Bullets
A list in Bootstrap-style.

#### Settings (like Typo3):
* `unordered`
* `ordered`
* `definition list`

---

### Div
Just a line.

---

### Header
Just a header.

---

### Table
Adjustable with all the Bootstrap table classes.

---

### Uploads
Realized with Bootstrap card component.  
The default Typo3-fields are available.

---

### Copied `fluid_styled_content` content elements
* HTML
* List/Plugin
* Menu*
* Shortcut
* Text

---
