<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Entity\User;
use App\Form\ClientBarType;
use App\Repository\BarRepository;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerer")
 * 
 */
class ClientBarController extends AbstractController
{
    /**
     * @Route("/all/{id}", name="client_bar_index", methods={"GET"})
     * @ParamConverter("user", options={"mapping": {"id": "id"}})
     * 
     */
    public function index(BarRepository $barRepository): Response
    {
        /** @var UserInterface $user */
        $user = $this->getUser();
        return $this->render('client_bar/index.html.twig', [
            'bars' => $barRepository->findBy(['user' => $user->getId()]),

        ]);
    }

    /**
     * @Route("/new", name="client_bar_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Slugify $slugify): Response
    {
        /**@var User $user */
        $user = $this->getUser();
        $bar = new Bar();
        $form = $this->createForm(ClientBarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bar->setUser($user);
            $bar->setSlug($slugify->generate($bar->getName()));
            $entityManager->persist($bar);
            $entityManager->flush();

            return $this->redirectToRoute('client_bar_index', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_bar/new.html.twig', [
            'bar' => $bar,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_bar_show", methods={"GET"})
     */
    public function show(Bar $bar): Response
    {
        return $this->render('client_bar/show.html.twig', [
            'bar' => $bar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_bar_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bar $bar, EntityManagerInterface $entityManager): Response
    {
        /**@var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ClientBarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('client_bar_index',  ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_bar/edit.html.twig', [
            'bar' => $bar,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_bar_delete", methods={"POST"})
     */
    public function delete(Request $request, Bar $bar, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bar->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_bar_index', [], Response::HTTP_SEE_OTHER);
    }
}
