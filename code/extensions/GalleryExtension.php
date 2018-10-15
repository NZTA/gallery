<?php

class GalleryExtension extends DataExtension
{

    /**
     * Defines the character limit that the thumbnail captions are set to.
     *
     * @var integer
     */
    private static $thumbnail_caption_length = 35;

    /**
     * @var array
     */
    private static $db = [
        'GalleryHeading' => 'Varchar(255)',
        'IsActive'       => 'Boolean'
    ];

    /**
     * @var array
     */
    private static $has_many = [
        'GalleryItems' => 'GalleryItem'
    ];

    /**
     * Defines the PageTypes that can have a Gallery, note these can be defined
     * in the configurations/yml file
     *
     * @var array
     */
    private static $pages_allowed_gallery = [];

    /**
     * @param  FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $allowedPages = Config::inst()->get('GalleryExtension', 'pages_allowed_gallery');

        if (count($allowedPages) == 0 || in_array($this->owner->ClassName, $allowedPages)) {
            $fields->addFieldsToTab(
                'Root.Gallery',
                [
                    CheckboxField::create('IsActive', 'Include Gallery')
                        ->setDescription('Ensure to tick this box if you wish to include a Gallery'),
                    TextField::create('GalleryHeading', 'Gallery Heading')
                        ->setDescription('This is the heading displayed above the list of Gallery Items'),
                    GridField::create(
                        'GalleryItems',
                        'Gallery Items',
                        $this->owner->GalleryItems()->sort('SortOrder'),
                        GridFieldConfig_RecordEditor::create()
                            ->addComponent(new GridFieldSortableRows('SortOrder'))
                    )
                    ->setDescription('This is the list of Gallery Items to be displayed on the page')
                ]
            );
        }
    }

    /**
     * Helper to get all the gallery data as JSON so a front end JS application
     * can generate the gallery with a lightbox feature.
     *
     * @return string
     */
    public function getGalleryData()
    {
        $data = [];

        if (!$this->owner->IsActive) {
            return json_encode($data);
        }

        $items = $this->owner->GalleryItems();

        if ($items->count() == 0) {
            return json_encode($data);
        }

        foreach ($items as $item) {
            $hasImage = ($item->ImageID != 0 && $item->Image()->exists());

            if ($hasImage) {
                $captionLength = Config::inst()->get('GalleryExtension', 'thumbnail_caption_length');

                $data[] = [
                    'id' => $item->ID,
                    'caption' => $item->Caption
                        ? $item->Caption
                        : $item->Image()->Title,
                    'thumbnail' => $item->Image()->CroppedImage(480, 375)->AbsoluteLink(),
                    'thumbnailCaption' => $item->Caption
                        ? $item->dbObject('Caption')->LimitCharacters($captionLength)
                        : $item->Image()->dbObject('Title')->LimitCharacters($captionLength),
                    'url' => $item->Image()->AbsoluteLink()
                ];
            }
        }

        return json_encode($data);
    }
}
