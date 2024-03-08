<?php

// src/DataFixtures/CategoryFixtures.php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpClient\HttpClient;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class CategoryFixtures extends Fixture
{
    private const ALBUM_NAMES = [
        'Mariages',
        'Portraits',
        'Paysages',
    ];

    private UploaderHelper $uploaderHelper;

    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    public function load(ObjectManager $manager)
    {
        $httpClient = HttpClient::create();

        foreach (self::ALBUM_NAMES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
