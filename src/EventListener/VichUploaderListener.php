<?php


namespace App\EventListener;

use Cocur\Slugify\Slugify;
use Symfony\Component\Filesystem\Filesystem;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Mapping\PropertyMapping;

class VichUploaderListener
{
    private string $uploadDestinationAlbum;
    private string $uploadDestinationCategory;

    public function __construct(string $uploadDestinationAlbum, string $uploadDestinationCategory)
    {
        $this->uploadDestinationAlbum = $uploadDestinationAlbum;
        $this->uploadDestinationCategory = $uploadDestinationCategory;
    }

    public function onVichUploaderPreUpload(Event $event)
    {
        $object = $event->getObject();
        $mapping = $event->getMapping();

        // Assuming that the entity is an instance of Photo and has a method getAlbum() and getCategory()
        if ($object instanceof \App\Entity\Photo) {
            $uploadMapping = $object->getAlbum() ? 'album' : 'category';

            $uploadDir = $uploadMapping === 'album' ? $this->uploadDestinationAlbum : $this->uploadDestinationCategory;

            // Vérifiez si le dossier de l'album existe, sinon le créez
            if($object->getAlbum()){
                $slugify = new Slugify();
                $slugify->addRule("-", "_");
                $albumName = strtoupper($slugify->slugify($object->getAlbum()->getUniqId()));
                $filesystem = new Filesystem();
                if (!$filesystem->exists($uploadDir. '/'. $albumName)) {
                    $filesystem->mkdir($uploadDir. '/'. $albumName);
                }
                $uploadDir = $uploadDir . '/' . $albumName;


                $mappingConfig = [
                    "uri_prefix" => "/private/album/photos",
                    'upload_destination' => $uploadDir,
                    "namer" => [
                        "service" => "App\Naming\PhotoSlugNamer.photos_categories",
                        "options" => []
                    ],
                    "directory_namer" => [
                        "service" => null,
                        "options" => null
                    ],
                    "delete_on_remove" => true,
                    "delete_on_update" => true,
                    "inject_on_load" => false,
                    "db_driver" => "orm",
                ];

                // Utilisez le tableau dans la méthode setMapping
                $mapping->setMapping($mappingConfig);

            }else{
                $slugify = new Slugify();
                $slugify->addRule("-", "_");
                $categoryName = strtoupper($slugify->slugify($object->getCategory()->getUniqId()));
                $filesystem = new Filesystem();
                if (!$filesystem->exists($uploadDir . '/' . $categoryName)) {
                    $filesystem->mkdir($uploadDir . '/' . $categoryName);
                }
                $uploadDir = $uploadDir . '/' . $categoryName;

                $mappingConfig = [
                    "uri_prefix" => "/categorie/photos",
                    'upload_destination' => $uploadDir,
                    "namer" => [
                        "service" => "App\Naming\PhotoSlugNamer.photos_categories",
                        "options" => []
                    ],
                    "directory_namer" => [
                        "service" => null,
                        "options" => null
                    ],
                    "delete_on_remove" => true,
                    "delete_on_update" => true,
                    "inject_on_load" => false,
                    "db_driver" => "orm",
                ];

                // Utilisez le tableau dans la méthode setMapping
                $mapping->setMapping($mappingConfig);
            }

            // Créez un tableau avec la clé 'upload_destination'
            
        }
        // dd($object, $mapping);
    }
}