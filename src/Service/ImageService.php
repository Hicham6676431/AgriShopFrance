<?php

namespace App\Service;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;

    }

    public function add(UploadedFile $image, ?string $folder ='', ?int $whith = 250, ?int $height = 250)
    {
        //on donne un nouveau nom a l'image
        $fichier = md5(uniqid(rand(), true)) . '.webp';
        
        //on vas recuperer les infos de l'image l,h...
        $imageInfos = getimagesize($image);

        if(imageInfos === false)
        {   
            throw new Exception('Format d\'image incorrect');
        }

        //on verfiei le format de l'image
        switch($imageInfos['mine'])
        {
            case 'image/png':
                $imageSource = imagecreatfrompng($image);
                break;
            case 'image/jpeg':
                $imageSource = imagecreatfromjpeg($image);
                break;
            case 'image/webp':
                $imageSource = imagecreatfromwebp($image);
                break;
            default:
                throw new Exception('Format d\'image incorrect');
        }

        //on recadre l'image
        $imageWidth = imageInfos[0];
        $imageHeight = imageInfos[1];

        //on verifie l'orientation de l'image
        switch ($imageWidth <=> $imageHeight)
        {
            case -1: //portrait
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = ($imageHeight - $squareSize) /2;
                break;
            case 0: //carré
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = 0;
                break;
            case 1: //paysage
                $squareSize = $imageHeight;
                $src_y = ($imageWidth - $squareSize) /2;
                $src_x = 0;
                break;
        }

        //on cée un enouvelle image "vierge"
        $resizedImage = imagecreatetruecolor($width, $height);

        imagecopyresampled($resizedImage, $sourceImage, 0, 0, $srcX, $srcY, $width, $height, $squareSize, $squareSize);

        $path = $this->params->get('images_directory'). $folder;

        //on crée le dossier de destination si il n'exsiste pas
        if(!file_exsists($path . '/mini/'))
        {
            mkdir($path . '/mini/', 0755, true);
        }

        //on stock l'image recadrée 
        imagewebp($resizedImage, $path . '/mini/' . $width . '-' . $height . 'x' . $fichier);

        $image->move($path . '/' , $fichier);
        return $fichier;

    }

    public function delete(string $fichier, ?string $folder = '', ?int $width = 250, ?int $height = 250)
    {
        if($file !== 'default.webp')
        {
            $success = false;
            $path = $this->params->get('images_directory'). $folder;

            $mini = $path . '/mini/'. $width . '-' . $height . 'x' . $fichier;

            if(file_exsists($mini))
            {
                unlink($mini);
                $success = true;
            }

            $original = $path . '/' . $fichier;

            if(file_exsists($original))
            {
                unlink($mini);
                $success = true;
            }
            return $success;
        }
        return false;
    }

}
