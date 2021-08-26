<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ResizeUploadBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ResizeUploadBehavior Test Case
 */
class ResizeUploadBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ResizeUploadBehavior
     */
    public $ResizeUpload;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ResizeUpload = new ResizeUploadBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResizeUpload);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
