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
* _`Frame class`_ (select)  
Here you'll find the Bootstrap container* classes like `container-xl` or `container-float`.
* _`Inner frame class`_ (select)  
Like the frame class but will create an inner div around the content when a value is selected.  
Example:
``` TypoScript
TCEFORM.tt_content.tx_bootstrap_inner_frame_class.addItems {
    my-inner-frame-class = My Label
}
```
* _`Additional styles`_ (select multiple)  
Many styles are selectable for a content element.  
Use this to configure modifications like indents, etc.  
In TypoScript several styles can be configured.  
You'll find them with the key `plugin.tx_bootstrap.settings.form.element.AdditionalStyles`.  
Each variant has these properties:
    * `label` (string; required)
    * `value` (int; required; used for reference)
    * `outerWrap` (string)
    * `innerWrap` (string)
    * `additionalClass` (string)
    * `additionalAttributes` (array; key value pairs)
    * `additionalOuterClass` (string)
    * `additionalOuterAttributes` (array; key value pairs)

Example:
``` TypoScript
plugin.tx_bootstrap.settings.form.element.AdditionalStyles {
    10 {
        label = Indent left
        value = 10
        innerWrap = <div class="indent-left-inner">|</div>
        additionalClass = indent-left
        additionalAttributes {
            data-render = indent-left
        }
    }
}
```
* _`Color`_ (select; one of the text-{color} classes)
* _`Background color`_ (select; one of the bg-{color} classes)
* _`Space before`_ (select; one of the space_before_class')
* _`Space after`_ (select; one of the space_after_class')

The defaults of `space_before_class` and `space_after_class` will be replaced with Bootstrap space classes. So you don't need extra classes for the space between content elements.

Adjust to your needs:
``` TypoScript
plugin.tx_bootstrap.settings.form.element {
    SpaceBeforeClassReplacements {
        extra-small = mt-3
        small = mt-4
        medium = mt-5
        large = mt-6
        extra-large = mt-7
    }

    SpaceAfterClassReplacements {
        extra-small = mb-3
        small = mb-4
        medium = mb-5
        large = mb-6
        extra-large = mb-7
    }
}
```

---

### All headers

All headers of all content elements have extra or modified fields.

#### Fields
* _`Header`_ (multiline string)
* _`Header layout`_ aka _`Type`_ (select)  
The tag that will be generated (`h1` to `h5`).
* _`Layout`_ (select)  
The basic css-class that will be used for the tag.
The default Bootstrap classes from `display-1` to `display-6`, `h1` to `h6` and `lead`.
* _`Variant`_ or _`Predefined header`_ (select)  
Only one variant is selectable. Use this to produce some variants of headers.  
In TypoScript several variants can be configured.  
You'll find them with the key `plugin.tx_bootstrap.settings.form.element.PredefinedHeader`.  
Each variant may have these properties:
    * `label` (string; required)
    * `value` (int; required; used for reference)
    * `outerWrap` (string)
    * `innerWrap` (string)
    * `additionalClass` (string)

Example:
``` TypoScript
plugin.tx_bootstrap.settings.form.element.PredefinedHeader {
    10 {
        label = My fancy headline
        value = 10
        outerWrap = <div class="h-fancy border bg-dark text-light rounded">|</div>
        innerWrap = <span class="h-fancy-inner">|</span>
        additionalClass = mb-0
    }
}
```
* _`Color`_ (select; one of the text-{color} classes)
* _`Position`_ (select; either `start`, `center` or `right`)
* _`Date`_ (Date)
* _`Additional styles`_ (select multiple)  
Many styles are selectable for a headline. Use this to configure modifications like uppercase, no space below, etc.
In TypoScript several styles can be configured.  
You'll find them with the key `plugin.tx_bootstrap.settings.form.element.AdditionalHeaderStyles`.  
Each variant may have these properties:
    * `label` (string; required)
    * `value` (int; required; used for reference)
    * `outerWrap` (string)
    * `innerWrap` (string)
    * `additionalClass` (string)

Example:
``` TypoScript
plugin.tx_bootstrap.settings.form.element.AdditionalHeaderStyles {
    10 {
        label = VERSAL
        value = 10
        additionalClass = text-uppercase
    }
    20 {
        label = italic
        value = 20
        innerWrap = <em>|</em>
    }
    30 {
        label = -line-through-
        value = 30
        innerWrap = <del>|</del>
    }
}
```
* _`Icon`_ (FAL)
* _`Link`_ (TypoLink)
* _`Subheader`_ (string)

---


### Accordion
Bootstrap styled Accordion component.  
CType: `bootstrap_accordion`

One accordion content element has one or many accordion items.  
Each accordion item may have one or many `Text & media (grid)` content elements.

#### Settings for all items:
* _`Keep items open on opening other items`_ (boolean)

#### Settings each item:
* _`Opened on load`_ (boolean)

---

### Carousel
Bootstrap styled Carousel component with images.  
CType: `bootstrap_carousel`

#### Settings:
* _`Animation`_ (select; either `slide` or `fade`)
* _`Autoplay`_ (boolean)
* _`Color scheme`_ (select; either `light`, `dark`)
* _`Show controls`_ (boolean)
* _`Show indicators`_ (boolean)
* _`Interval`_ (int; required; milliseconds)

#### Image properties:
* _`Header`_ (string)
* _`Title`_ (string)
* _`Alternative`_ (string)
* _`Description`_ (multiline string)
* _`Link`_ (TypoLink)
* _`Link text`_ (string)
* _`Crop`_ (each device from xs to xxl)

---

### Cards
Bootstrap styled Cards component in a grid system.  
CType: `bootstrap_cards`

#### Settings:
* _`Presets`_ (select multiple)  
In TypoScript `tt_content.bootstrap_cards.flexform_presets` one or more settings could be grouped and labeled for selection.
* Grid:
    * _`Cols`_ (select; each device from xs to xxl; col* classes)
    * _`Gutter space x`_ (select; each device from xs to xxl; g-* classes)
    * _`Gutter space y`_ (select; each device from xs to xxl; g-* classes)
    * _`Align x`_ (select; each device from xs to xxl; alignment classes)
    * _`Align y`_ (select; each device from xs to xxl; alignment classes)
* Cards:
    * _`Image position`_ (select; one of `above`, `below`, `start`, `end`)
    * _`Background color`_ (select; one of the bg-{color} classes)
    * _`Text color`_ (select; one of the text-{color} classes)
    * _`Border color`_ (select; one of the border-{color} classes)
    * _`Button color/style`_ (select; one of the btn-{color} and btn-outline-{color} classes)
* _`Image optimizing`_ (produced percentual window width from xs to xxl)


#### Card-item properties:
* _`Header`_ (string)
* _`Title`_ (string)
* _`Image`_ (FAL)
* _`Text`_ (multiline string, RTE)
* _`Link`_ (TypoLink)
* _`Link text`_ (string)
* _`Footer`_ (string)

---

### Media grid
Images and videos in an adjustable grid system. Masonry is also provided.  
CType: `bootstrap_mediagrid`

#### Settings:
* _`Presets`_ (select multiple)  
In TypoScript `tt_content.bootstrap_mediagrid.flexform_presets` one or more settings could be grouped and labeled for selection.
* Use _`masonry grid`_ (boolean)
* Grid:
    * _`Cols`_ (select; each device from xs to xxl; col* classes)
    * _`Gutter space x`_ (select; each device from xs to xxl; g-* classes)
    * _`Gutter space y`_ (select; each device from xs to xxl; g-* classes)
    * _`Align x`_ (select; each device from xs to xxl; alignment classes)
    * _`Align y`_ (select; each device from xs to xxl; alignment classes)
* _`Image optimizing`_ (produced percentual window width from xs to xxl)

---

### Tabulator
Bootstrap styled Tabulator component.  
CType: `bootstrap_tabs`

One tabulator content element has one or many tabulator items.  
Each tabulator item may have one or many `Text & media (grid)` content elements.  

#### Settings for all items:
* _`Layout`_ (select; either `default`, `pills horizontal` or `pills vertical`)
* _`Navigation alignment`_ (select; only on horizontal; one of `start`, `center`, `end`, `nav fill`, `nav justified`)

#### Settings each item:
* _`active`_ (boolean)  
Only one can be active. The first found with active state is used. If no one is active, the first item is marked as active.

---

### Text + Image
A content element to create fast a grid with one image and text. Positions, space and alignment is adjustable.  
CType: `bootstrap_textimage`

#### Settings:
* _`Presets`_ (select multiple)  
In TypoScript `tt_content.bootstrap_textimage.flexform_presets` one or more settings could be grouped and labeled for selection.
* _`Order`_ (select; either `first image` or `first text`)
* _`Image alignment`_ (select; either `top` or `bottom`)
* _`Text alignment`_ (select; either `top` or `bottom`)
* _`Header position`_ (select; either `above all`, `above text` or `above image`)
* _`Space between`_ text and image (select; each device from xs to xxl; g-* classes)
---

### Text & Media (float)
A text which floats a media grid. Full adjustable grid and floating settings. Some presets are available to the editor.  
CType: `bootstrap_textmediafloat`

#### Settings:
* _`Presets`_ (select multiple)  
In TypoScript `tt_content.bootstrap_textmediafloat.flexform_presets` one or more settings could be grouped and labeled for selection.
* _`Header position`_ (`above all` or `above text`)
* Media area:
    * _`Position`_ (select; each device from xs to xxl; either `centered above text`, `left` or `right`)
    * _`Width`_ (select; each device from xs to xxl; additional float classes)
    * _`Space x`_ (select; each device from xs to xxl; space classes)
    * _`Space y`_ (select; each device from xs to xxl; space classes)
* Use _`masonry grid`_
* Grid for the media items:
    * _`Cols`_ (select; each device from xs to xxl; col* classes)
    * _`Gutter space x`_ (select; each device from xs to xxl; g-* classes)
    * _`Gutter space y`_ (select; each device from xs to xxl; g-* classes)
    * _`Align x`_ (select; each device from xs to xxl; alignment classes)
    * _`Align y`_ (select; each device from xs to xxl; alignment classes)
* _`Image optimizing`_ (produced percentual window width from xs to xxl)

---

### Text & Media (grid)
A text column and a media grid column. The most flexible content element.  
CType: `bootstrap_textmediagrid`

#### Settings:
* _`Presets`_ (select multiple)  
In TypoScript `tt_content.bootstrap_textmediagrid.flexform_presets` one or more settings could be grouped and labeled for selection.
* _`Default order`_ of text- and media-area (select; either `first image` or `first text`)
* _`Order per each device`_ (select; each device from xs to xxl; either `first image` or `first text`)
* _`Header position`_ (select; either `above all`, `above text` or `above media area`)
* Grid for the text- and media-columns:
    * _`Cols text-column`_ (select; each device from xs to xxl; col* classes)
    * _`Cols media-column`_ (select; each device from xs to xxl; col* classes)
    * _`Gutter space x`_ (select; each device from xs to xxl; g-* classes)
    * _`Gutter space y`_ (select; each device from xs to xxl; g-* classes)
    * _`Align x`_ (select; each device from xs to xxl; alignment classes)
    * _`Align y`_ (select; each device from xs to xxl; alignment classes)
* Text-column:
    * _`Align self`_ (select; each device from xs to xxl; alignment classes)
    * _`Inner space`_ (select; each device from xs to xxl; space classes)
* Media-column:
    * Use _`masonry grid`_
    * _`Align self`_ (select; each device from xs to xxl; alignment classes)
    * _`Inner space`_ (select; each device from xs to xxl; space classes)
* Grid for the media items:
    * _`Cols`_ (select; each device from xs to xxl; col* classes)
    * _`Gutter space x`_ (select; each device from xs to xxl; g-* classes)
    * _`Gutter space y`_ (select; each device from xs to xxl; g-* classes)
    * _`Align x`_ (select; each device from xs to xxl; alignment classes)
    * _`Align y`_ (select; each device from xs to xxl; alignment classes)
* _`Image optimizing`_ (produced percentual window width from xs to xxl)

---

### Two columns text
Create fast two columns text.  
CType: `bootstrap_twocolumnstext`

---

### Bullets
A list in Bootstrap-style.  
CType: `bullets`

#### Settings (like Typo3):
* `unordered list`
* `ordered list`
* `definition list`

---

### Div
Just a line.  
CType: `div`

---

### Header
Just a header.  
CType: `header`

---

### Table
Adjustable with all the Bootstrap table classes.  
CType: `table`

---

### Uploads
Realized with Bootstrap card component.  
The default Typo3-fields are available.  
CType: `uploads`

---

### Copied `fluid_styled_content` content elements
* HTML  
CType: `html`
* List/Plugin  
CType: `list`
* Menu*  
CTypes: 
    * `menu_abstract`
    * `menu_categorized_content`
    * `menu_categorized_pages`
    * `menu_pages`
    * `menu_recently_updated`
    * `menu_related_pages`
    * `menu_section`
    * `menu_section_pages`
    * `menu_sitemap`
    * `menu_sitemap_pages`
    * `menu_subpages`
* Shortcut  
CType: `shortcut`
* Text  
CType: `text`

---
