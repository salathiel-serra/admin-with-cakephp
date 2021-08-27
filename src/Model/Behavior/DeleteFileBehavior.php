<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * DeleteFile behavior
 */
class DeleteFileBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function deleteDirectory($path)
    {
        $directory = new Folder($path);
        if ($directory->delete($path)) {
            return true;
        }

        return false;
    }

    public function deleteFile($path, $oldImage, $newImage = NULL)
    {
        if (!is_null($oldImage) AND ($oldImage !== $newImage)) {
            $file = new File($path.$oldImage);
            $file->delete($path.$oldImage);
        }
    }
}
