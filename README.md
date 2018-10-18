# Gallery

Provides the ability add a Gallery to any number of page types to provide a gallery of images with captions

## Requirements
SilverStripe 4.x

## Version info
The master branch of this module is currently aiming for SilverStripe 4.x compatibility

* [SilverStripe 3.0+ compatible version](https://github.com/NZTA/gallery/tree/1.0.0)

## Features

* Able to create a set of GalleryItems that each consist of an image and a caption
* Define which PageTypes these GalleryItems should be added to through extensions configurations
* When a galleryitem is clicked on, a lightbox popup shows with carousel functionality

## Installation

    composer require nzta/gallery

### Installing assets

You will need to require in the `Requirements::javascript('nzta/gallery: js/gallery.js')` in order to display the gallery out of the box and 
have the lightbox functionality.

There is also a `Requirements::css('nzta/gallery: css/main.css)` file that can be used to display basic styles for the `CarouselModal`.

### Setting up templates

Once you have the assets being pulled in, you will need to add the gallery to the template, e.g. `<% include Gallery %>`

You will also need the `__galleryData` available globally for the JS to work. You can add the following to your `<head>`:

```
<script>
    window.__galleryData = {
      items: {$GalleryData}
    }
</script>
```

### Adding the extensions

Now you can add the `GalleryExtension` to any page type you want to provide a gallery to, e.g.

```
Page:
  extensions:
    - NZTA\Gallery\Extensions\GalleryExtension
```

This will provide the CMS fields to add gallery images to the page.
