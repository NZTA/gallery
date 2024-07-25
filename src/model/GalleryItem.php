<?php

namespace NZTA\Gallery\Model;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use Page;

/**
 * A GalleryItem consists an image with an attached caption that can
 * be used to create a Gallery of GalleryItems.
 */
class GalleryItem extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Gallery item';

    /**
     * @var string
     */
    private static $plural_name = 'Gallery items';

    /**
     * @var string
     */
    private static $table_name = 'GalleryItem';


    /**
     * @var array
     */
    private static $db = [
        'Caption'   => 'Varchar(255)',
        'SortOrder' => 'Int'
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Image' => Image::class,
        'Page'  => Page::class
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Image',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
        'Caption'            => 'Image Title/Caption'
    ];

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder ASC';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = new FieldList();

        $fields->push(
            UploadField::create('Image', 'Image')
                ->setDescription('The image for the gallery item')
        );
        $fields->push(
            TextField::create('Caption', 'Caption')
                ->setDescription(
                    "(Optional) A short description of the image's content, limited to 35 characters.
                    If not supplied, the image's title will be used"
                )
                ->setAttribute(
                    'maxlength',
                    35
                )
        );

        return $fields;
    }
}
