<?php

// src/DataFixtures/HomepageFixtures.php

namespace App\DataFixtures;

use App\Entity\Homepage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HomepageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $Homepage = new Homepage();

        $Homepage->setPhotoTopLeft('/assets/images/image3.jpeg');
        $Homepage->setPhotoMiddle('/assets/images/image1.jpg');
        $Homepage->setPhotoBottom('/assets/images/image2.jpg');

        $Homepage->setTitle('Emmanuel Godard');
        $Homepage->setSubtitle('Photographe Passionné');

        $Homepage->setPfp('/assets/images/godard.jpg');
        $Homepage->setDescriptionTitle('Emmanuel Godard');
        $Homepage->setDescriptionText('Artiste français, je suis né en 1975 à Dieppe en Normandie. Je suis un passionné d’images et des émotions. Et j’ai cette capacité à sublimer l’instant par ma sensibilité au monde qui m’entoure. La simplicité et la pureté de mes photographies vous plongera dans mon univers parfois irréel et poétique. Bienvenue dans mon monde.');

        $Homepage->setContactDescription("Tell me about your story, your passion, your love. And I'll be happy to get back to you and talk about our common project. Let's connect here.");
        $Homepage->setContactNumber('+33 6 45 48 58 15');
        $Homepage->setContactLocation('13 rue de Victor Hugo, Paris, France');
        $Homepage->setContactEmail('emmanuel.godard83@orange.fr');

        $Homepage->setContactPhotoTopRight('/assets/images/image3.jpeg');
        $Homepage->setContactPhotoBottomRight('/assets/images/image1.jpg');
        $Homepage->setContactPhotoBottomLeft('/assets/images/image2.jpg');

        $manager->persist($Homepage);
        $manager->flush();
    }
}
