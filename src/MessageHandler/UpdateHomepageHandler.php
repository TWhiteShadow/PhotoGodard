<?php

namespace App\MessageHandler;

use App\Message\UpdateHomepage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PropertyAccess\PropertyAccess;

#[AsMessageHandler]
class UpdateHomepageHandler
{
    private $entityManager;
    private $uploadedFiles;
    private $homepage;
    private $defaultHomepage;
    private $imageFilesName;
    private $parameterBag;
    private $propertyAccessor;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag)
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function __invoke(UpdateHomepage $command): void
    {
        $this->homepage = $command->getHomepage();

        $this->defaultHomepage = $command->getDefaultHomepage();
        $this->uploadedFiles = $command->getImageFiles();
        $this->entityManager->persist($this->homepage);
        $this->imageFilesName = ['PhotoTopLeft', 'PhotoMiddle', 'PhotoBottom', 'Pfp', 'ContactPhotoTopRight', 'ContactPhotoBottomRight', 'ContactPhotoBottomLeft'];
        if (!empty($this->uploadedFiles)) {
            $this->replacePreviousPhoto();
        }

        foreach ($this->imageFilesName as $fileName) {
            $this->propertyAccessor->setValue($this->homepage, $fileName, $this->propertyAccessor->getValue($this->defaultHomepage, $fileName));
        }

        // for ($i = 0; $i < count($this->imageFilesName); ++$i) {
        //     $setter = 'set'.ucfirst($this->imageFilesName[$i]);
        //     $getter = 'get'.ucfirst($this->imageFilesName[$i]);
        //     $this->homepage->$setter($this->defaultHomepage->$getter());
        // }
        $this->entityManager->persist($this->homepage);

        $this->entityManager->flush();
    }

    private function replacePreviousPhoto(): void
    {
        foreach ($this->uploadedFiles as $fieldName => $uploadedFile) {
            /** @var UploadedFile $uploadedFile */
            if (!($uploadedFile instanceof UploadedFile)) {
                continue;
            }
            // Check if the uploaded file is not empty
            if (empty($uploadedFile->getClientOriginalName())) {
                continue;
            }

            $destination = $this->parameterBag->get('kernel.project_dir').'/public/assets/images/homepage/';
            // Generate unique filename
            $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

            // Move the file to the directory where images are stored
            $uploadedFile->move(
                $destination,
                $newFilename
            );

            // Delete previous image, if it exists
            // $getterMethod = 'get'.ucfirst($fieldName);
            $previousImagePath = $this->propertyAccessor->getValue($this->defaultHomepage, $fieldName);
            // var_dump($this->getParameter('kernel.project_dir'). '/public'. $previousImagePath);die;
            if ($previousImagePath && file_exists($this->parameterBag->get('kernel.project_dir').'/public'.$previousImagePath)) {
                unlink($this->parameterBag->get('kernel.project_dir').'/public'.$previousImagePath);
            }

            // Mettre à jour the entity with the new image path
            // $setterMethod = 'set'.ucfirst($fieldName);
            // $this->homepage->$setterMethod('/assets/images/'.$newFilename);

            $this->propertyAccessor->setValue($this->homepage, $fieldName, '/assets/images/homepage/'.$newFilename);

            array_splice($this->imageFilesName, array_search(ucfirst($fieldName), $this->imageFilesName), 1);
        }
    }
}
