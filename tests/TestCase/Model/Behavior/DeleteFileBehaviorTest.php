<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\DeleteFileBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\DeleteFileBehavior Test Case
 */
class DeleteFileBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\DeleteFileBehavior
     */
    public $DeleteFile;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->DeleteFile = new DeleteFileBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeleteFile);

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
