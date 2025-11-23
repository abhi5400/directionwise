<?php
/**
 * Tour Model Tests
 * Basic unit tests for TourModel
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/config.php';
require_once __DIR__ . '/../../php/models/TourModel.php';

class TourModelTest extends TestCase
{
    private $tourModel;
    private $testDataFile;

    protected function setUp(): void
    {
        $this->tourModel = new TourModel();
        $this->testDataFile = DATA_PATH . '/tours.json';
        
        // Backup original file if exists
        if (file_exists($this->testDataFile)) {
            copy($this->testDataFile, $this->testDataFile . '.backup');
        }
    }

    protected function tearDown(): void
    {
        // Restore original file
        if (file_exists($this->testDataFile . '.backup')) {
            copy($this->testDataFile . '.backup', $this->testDataFile);
            unlink($this->testDataFile . '.backup');
        }
    }

    public function testGetAllReturnsArray()
    {
        $tours = $this->tourModel->getAll();
        $this->assertIsArray($tours);
    }

    public function testGetByIdReturnsTour()
    {
        $tours = $this->tourModel->getAll();
        if (!empty($tours)) {
            $firstTour = $tours[0];
            $tour = $this->tourModel->getById($firstTour['id']);
            $this->assertNotNull($tour);
            $this->assertEquals($firstTour['id'], $tour['id']);
        }
    }

    public function testGetByIdReturnsNullForInvalidId()
    {
        $tour = $this->tourModel->getById(99999);
        $this->assertNull($tour);
    }
}

