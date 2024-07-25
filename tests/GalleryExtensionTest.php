<?php

namespace NZTA\Gallery\Test;

use NZTA\Gallery\Extensions\GalleryExtension;
use NZTA\Gallery\Model\GalleryItem;
use NZTA\Gallery\Test\Fixture\GalleryTestPage;
use SilverStripe\Assets\Dev\TestAssetStore;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\SapphireTest;

class GalleryExtensionTest extends SapphireTest
{
    protected static $fixture_file = './Fixture/GalleryExtensionTest.yml';

    protected $usesDatabase = true;

    protected static $extra_dataobjects = [GalleryTestPage::class];

    protected static $required_extensions = [
        GalleryTestPage::class => [GalleryExtension::class],
    ];

    public function setUp(): void
    {
        parent::setUp();
        TestAssetStore::activate('galleryAssets');
        $image = $this->objFromFixture(Image::class, 'image');
        $sourcePath = __DIR__ . '/Fixture/assets/' . $image->Name;
        $image->setFromLocalFile($sourcePath, $image->Filename);
        $image->publishSingle();
    }

    protected function tearDown(): void
    {
        TestAssetStore::reset();
        parent::tearDown();
    }

    public function testGalleryDataIsJson()
    {
        $page = $this->objFromFixture(GalleryTestPage::class, 'noItems');
        $result = json_decode($page->getGalleryData());
        $this->assertTrue(is_array($result));
    }

    public function testOnlyItemsWithImagesAreIncluded()
    {
        $page = $this->objFromFixture(GalleryTestPage::class, 'noImages');
        $result = json_decode($page->getGalleryData());
        $this->assertEmpty($result);
    }

    public function testInactivePagesHaveNoItems()
    {
        $page = $this->objFromFixture(GalleryTestPage::class, 'inactive');
        $result = json_decode($page->getGalleryData());
        $this->assertEmpty($result);
    }

    public function testGetGalleryData()
    {
        $page = $this->objFromFixture(GalleryTestPage::class, 'mix');
        $result = json_decode($page->getGalleryData());
        $this->assertCount(1, $result, 'json has the wrong count');

        // check the expected data exists for each item
        $obj = $result[0];
        $this->assertTrue(isset($obj->id), 'ID should be set');
        $this->assertTrue(isset($obj->caption), 'Caption should be set');
        $this->assertTrue(isset($obj->thumbnail), 'Thumbnail should exist');
        $this->assertTrue(isset($obj->url), 'URL should exist');
    }
}
