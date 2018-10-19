<?php

namespace NZTA\Gallery\Test;

use SilverStripe\Dev\SapphireTest;
use NZTA\Gallery\Extensions\GalleryExtension;
use Page;
use NZTA\Gallery\Model\GalleryItem;

class GalleryExtensionTest extends SapphireTest
{
    /**
     * @var boolean
     */
    protected $usesDatabase = true;

    /**
     * @var array
     */
    protected $requiredExtensions = [
        Page::class => [
            GalleryExtension::class
        ]
    ];

    public function testGetGalleryData()
    {
        $page = new Page();
        $page->Title = 'Gallery Test Page';
        $page->write();

        $result = json_decode($page->getGalleryData());

        // ensure data is a json array
        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));

        $page->IsActive = true;

        $result = json_decode($page->getGalleryData());

        // ensure we still have no data since have no gallery items yet
        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));

        // attach gallery item to the page
        $item = new GalleryItem();
        $item->Caption = 'Test Image';
        $item->write();

        $page->GalleryItems()->add($item);

        $result = json_decode($page->getGalleryData());

        // assert we have data now
        $this->assertEquals(1, count($result));

        // check the expected data exists for each item
        foreach ($result as $obj) {
            $this->assertTrue(isset($obj->id));
            $this->assertTrue(isset($obj->caption));
            $this->assertTrue(isset($obj->thumbnail));
            $this->assertTrue(isset($obj->url));
        }
    }
}
