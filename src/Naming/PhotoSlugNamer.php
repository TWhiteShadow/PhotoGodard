<?php

namespace App\Naming;

use App\Entity\Photo;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Util\Transliterator;
use Cocur\Slugify\Slugify;

/**
 * This namer uses a slug to keep the original name when possible,
 * including the album name in the filename.
 *
 * @author Massimiliano Arione <garakkio@gmail.com>
 */
final class PhotoSlugNamer implements NamerInterface
{
    public function __construct(
        private readonly Transliterator $transliterator,
        // private readonly object $service,
        // private readonly string $method,
        // private readonly string $albumProperty
    ) {
    }

    public function name(object $object, PropertyMapping $mapping): string
    {
        $slugify = new Slugify();
        $slugify->addRule("-", "_");
        // Get the album name from the object
        $albumName = $slugify->slugify(strtolower($this->getAlbumName($object)), "_");

        $file = $mapping->getFile($object);
        $originalName = $file->getClientOriginalName();
        $extension = \strtolower(\pathinfo($originalName, \PATHINFO_EXTENSION));
        $basename =  $slugify->slugify(\substr(\pathinfo($originalName, \PATHINFO_FILENAME), 0, 240), "_");
        $basename = \strtolower($this->transliterator->transliterate($basename));
        $num = 1;
        // Combine album name, file name, and extension
        $slug = \sprintf('%s_%s.%s', $albumName === null ? $basename : $albumName, $num, $extension);

        // Check for uniqueness
        return $slug;
    }

    /**
     * Get the album name from the object.
     * You may need to adjust this method based on your object structure.
     */
    private function getAlbumName(Photo $object): ?string
    {
        // Assuming the album name is a property on the object
        // Adjust this based on your actual object structure
        if ($object->getAlbum() !== null) {
            return $object->getAlbum()->getName();
        }
        return null;
    }
}
