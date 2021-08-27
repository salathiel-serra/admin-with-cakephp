<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * ResizeUpload behavior
 */
class ResizeUploadBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function uploadResizedImage(array $file, $path, $width, $height)
    {
        $this->createDestiny($path);
        $this->checkImageExtension($file, $path, $width, $height);
        // return $this->upload($file, $path);
        return true;
    }

    // protected function upload($file, $path)
    // {
    //     extract($file);
        
    //     if (move_uploaded_file($tmp_name, $path.$name)) { 
    //         return $name;
    //     } else {
    //         return false;
    //     } 
    // }

    public function slugUploadResizedImage($name)
    {
        $formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        $name = strtr(utf8_decode($name), utf8_decode($formato['a']), $formato['b']);
        $name = str_replace(' ', '-', $name);

        $name = str_replace(['-----', '----', '---', '--'], '-', $name);

        return strtolower($name);
    }

    protected function createDestiny($path)
    {
        $destiny = new Folder($path);

        if (is_null($destiny->path)) {
            $destiny->create($path);
        }
    }


    protected function checkImageExtension($file, $path, $width, $height)
    {
        extract($file);
        switch ($type) {
            case 'image/jpeg';
            case 'image/pjpeg';
                $image = imagecreatefromjpeg($tmp_name);
                $resizedImage = $this->resizedImage($image, $width, $height);
                imagejpeg($resizedImage, $path . $name);
                break;

            case 'image/png':
            case 'image/x-png':
                $image = imagecreatefrompng($tmp_name);
                $resizedImage = $this->resizedImage($image, $width, $height);
                imagepng($resizedImage, $path . $name);
                break;
            
            default:
                # code...
                break;
        }
    }

    protected function resizedImage($image, $width, $height)
    {
        // obtendo dimensões orinais da imagem selecionada
        $original_width  = imagesx($image);
        $original_height = imagesy($image);

        // criando imagem com o dimensionamento desejado
        $resizedImage = imagecreatetruecolor($width, $height);

        // substituindo a imagem criada acima pela selecionada pelo usuário com dimensionamento
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $original_width, $original_height);

        return $resizedImage;
    }
}

