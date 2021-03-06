<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\BarType;
use App\Form\CommentType;
use App\Repository\BarRepository;
use App\Repository\CommentRepository;
use App\Service\Slugify;
use DateTime;
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
        /** @var UserInterface $user */
        $user = $this->getUser();
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
     * @Route("/{bar}", name="bar_show", methods={"GET", "POST"})
     * @ParamConverter("bar", options={"mapping": {"bar": "slug"}})
     */
    public function show(Bar $bar, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Comment $comment */
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDatetime(new DateTime());
            $comment->setUser($this->getUser());
            $comment->setBar($bar);
            $entityManager->persist($comment);
            
            $entityManager->flush();
            return $this->redirectToRoute('bar_show', ['bar' => $bar->getSlug()], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('bar/show.html.twig', [
            'bar' => $bar,
            'form' => $form,
            'comment' => $bar->getComments()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bar_edit", methods={"GET", "POST"})
     * @ParamConverter("id", options={"mapping": {"bar": "id"}})
     */
    public function edit(Request $request, Bar $bar, EntityManagerInterface $entityManager, Slugify $slugify): Response
    {
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bar);
            $bar->setSlug($slugify->generate($bar->getName()));
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
