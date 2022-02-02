<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Form\BarType;
use App\Repository\BarRepository;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/bar")
 */
class BarController extends AbstractController
{
    /**
     * @Route("/", name="bar_index")
     */
    public function index(BarRepository $barRepository): Response
    {
        return $this->render('bar/index.html.twig', [
            'bars' => $barRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bar_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Slugify $slugify, EntityManagerInterface $entityManager): Response
    {
        $bar = new Bar();
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bar);
            $bar->setSlug($slugify->generate($bar->getName()));
            $entityManager->flush();

            return $this->redirectToRoute('bar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bar/new.html.twig', [
            'bar' => $bar,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{bar}", name="bar_show", methods={"GET"})
     * @ParamConverter("bar", options={"mapping": {"bar": "slug"}})
     */
    public function show(Bar $bar): Response
    {
        return $this->render('bar/show.html.twig', [
            'bar' => $bar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bar_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bar $bar, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('bar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bar/edit.html.twig', [
            'bar' => $bar,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="bar_delete", methods={"POST"})
     * @ParamConverter("bar", options={"mapping": {"id": "id"}})
     */
    public function delete(Request $request, Bar $bar, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bar->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bar_index', [], Response::HTTP_SEE_OTHER);
    }
}
