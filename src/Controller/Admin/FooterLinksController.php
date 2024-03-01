<?php

namespace App\Controller\Admin;

use App\Entity\FooterLinks;
use App\Form\FooterLinksType;
use App\Repository\FooterLinksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/footer/links')]
class FooterLinksController extends AbstractController
{
    #[Route('/', name: 'app_admin_footer_links_index', methods: ['GET'])]
    public function index(FooterLinksRepository $footerLinksRepository): Response
    {
        return $this->render('admin/footer_links/index.html.twig', [
            'footer_links' => $footerLinksRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_footer_links_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $footerLink = new FooterLinks();
        $form = $this->createForm(FooterLinksType::class, $footerLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($footerLink);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_footer_links_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/footer_links/new.html.twig', [
            'footer_link' => $footerLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_footer_links_show', methods: ['GET'])]
    public function show(FooterLinks $footerLink): Response
    {
        return $this->render('admin/footer_links/show.html.twig', [
            'footer_link' => $footerLink,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_footer_links_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FooterLinks $footerLink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FooterLinksType::class, $footerLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_footer_links_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/footer_links/edit.html.twig', [
            'footer_link' => $footerLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_footer_links_delete', methods: ['POST'])]
    public function delete(Request $request, FooterLinks $footerLink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$footerLink->getId(), $request->request->get('_token'))) {
            $entityManager->remove($footerLink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_footer_links_index', [], Response::HTTP_SEE_OTHER);
    }
}
