<?php

// src/DataFixtures/AlbumFixtures.php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class AlbumFixtures extends Fixture
{
    private const ALBUM_NAMES = [
        'Mariage',
        'Anniversaire',
        'Bébé',
        'Famille',
        'Voyage',
        'Portrait',
        'Nature',
        'Mode',
        'Sport',
        'Nourriture',
        'Musique',
        'Architecture',
        'Animaux',
    ];

    private UploaderHelper $uploaderHelper;

    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    public function load(ObjectManager $manager)
    {
        $httpClient = HttpClient::create();

        foreach (self::ALBUM_NAMES as $albumName) {
            $album = new Album();
            $album->setName($albumName . ' ' . $this->getRandomName());
            $album->setUniqId();
            $album->setPassword('your_password_here'); // Set your desired password

            $manager->persist($album);
        }

        $manager->flush();
    }

    private function getRandomName(): string
    {
        $names = ['Claudette', 'Pascal', 'Sophie', 'Antoine', 'Emma', 'Lucas', 'Chloé', 'Louis', 'Camille', 'Arthur', 'Manon', 'Hugo', 'Léa'];
        return $names[array_rand($names)];
    }
}
