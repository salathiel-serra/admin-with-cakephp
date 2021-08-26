<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Upload behavior
 */
class UploadBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function singleUpload(array $file, $path)
    {
        return $this->upload($file, $path);
    }

    public function upload($file, $path)
    {
        extract($file);
        
        if (move_uploaded_file($tmp_name, $path.$name)) { 
            return $name;
        } else {
            return false;
        } 
    }

    public function slug($name)
    {
        $formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        $name = strtr(utf8_decode($name), utf8_decode($formato['a']), $formato['b']);
        $name = str_replace(' ', '-', $name);

        $name = str_replace(['-----', '----', '---', '--'], '-', $name);

        return strtolower($name);
    }
}
