<?php

namespace App\Naming;

use App\Entity\Photo;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Util\Transliterator;
use Cocur\Slugify\Slugify;
use Symfony\Component\Filesystem\Filesystem;

final class PhotoSlugNamer implements NamerInterface
{
    public function __construct(
        private readonly Transliterator $transliterator,
        private readonly string $uploadDestinationAlbum,
        private readonly string $uploadDestinationCategory,
    ) {
    }

    public function name(object $object, PropertyMapping $mapping): string
    {
        $slugify = new Slugify();
        $slugify->addRule("-", "_");

        // Get the album name from the object
        $albumName = strtoupper($slugify->slugify(strtoupper($this->getAlbumUniqId($object)), "_"));

        // Initialize $category to an empty string
        $category = '';


        $file = $mapping->getFile($object);
        $originalName = $file->getClientOriginalName();
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $basename = $slugify->slugify(substr(pathinfo($originalName, PATHINFO_FILENAME), 0, 240), "_");
        $basename = strtolower($this->transliterator->transliterate($basename));

        if($albumName !== "" && $albumName !== null){  // La photo a un album associé
           
            // Check the files in the album directory
            $albumDir = $this->uploadDestinationAlbum . '/' . $albumName;
            $filesystem = new Filesystem();

            if ($filesystem->exists($albumDir)) {
                $files = scandir($albumDir);
                $existingNums = [];

                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..'
                    ) {
                        // Ajout pour déboguer
                        echo 'File in album directory: ' . $file . PHP_EOL;

                        if (preg_match('/^' . $albumName . '_/', $file)) {
                            $existingString = pathinfo($file, PATHINFO_FILENAME);
                            $arrayString = explode("_", $existingString);
                            $existingNums[] = end($arrayString);
                        }
                    }
                }

                $num = sprintf('%05d', $existingNums ? max($existingNums) + 1 : 1);

            } else {
                // Le dossier n'existe pas, donc le numéro est 00001
                $num = '00001';
            }
    
        }
        elseif($albumName === "" || $albumName === null){
        
            // If $albumName is null, set $category based on the category name
            $category = strtoupper($slugify->slugify(strtoupper($this->getCategoryName($object)), "_"));

            $categoryDir = $this->uploadDestinationCategory . '/' . $category;
            $filesystem = new Filesystem();

            if ($filesystem->exists($categoryDir)) {
                $files = scandir($categoryDir);
                $existingNums = [];

                foreach ($files as $file) {
                    if (
                        $file !== '.' && $file !== '..'
                    ) {
                        // Ajout pour déboguer
                        echo 'File in category directory: ' . $file . PHP_EOL;

                        if (preg_match('/^' . $albumName . '_/', $file)) {
                            $existingString = pathinfo($file, PATHINFO_FILENAME);
                            $arrayString = explode("_", $existingString);
                            $existingNums[] = end($arrayString);
                        }
                    }
                }

                $num = uniqid();
            } else {
                // Le dossier n'existe pas, donc le numéro est 00001
                $num = uniqid();
            }
        }

        
        
        
        $name = $albumName === "" || $albumName === null ? $category . "_" . $basename : $albumName;
        // Combine name, num and extension
        $slug = sprintf('%s_%s.%s', $name, $num, $extension);

        return $slug;
    }

    private function getAlbumName(Photo $object): ?string
    {
        if ($object->getAlbum() !== null) {
            return $object->getAlbum()->getName();
        }
        return null;
    }

    private function getAlbumUniqId(Photo $object): ?string
    {
        if ($object->getAlbum() !== null) {
            return $object->getAlbum()->getUniqId();
        }
        return null;
    }

    private function getCategoryName(Photo $object): ?string
    {
        if ($object->getCategory() !== null) {
            return $object->getCategory()->getName();
        }
        return null;
    }
}
