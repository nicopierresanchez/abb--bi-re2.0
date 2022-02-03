<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("{bar}/carte", name="bar_product_", methods={"GET"})
 * @ParamConverter("bar", options={"mapping": {"bar": "slug"}})
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * 
     */
    public function index(ProductRepository $productRepository, Bar $bar): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy(['bar' => $bar]),
            'bar' => $bar
        ]);
    }

    /**
     * @Route("/product/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, Slugify $slugify, EntityManagerInterface $entityManager, Bar $bar): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $product->setBar($bar);
            $product->setSlug($slugify->generate($product->getName()));
            $entityManager->flush();
            return $this->redirectToRoute('bar_product_index', ['bar' => $bar->getslug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form
        ]);
    }

    /**
     * @Route("/product/{id}", name="show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Bar $bar, Slugify $slugify, Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setSlug($slugify->generate($product->getName()));
            $entityManager->flush();

            return $this->redirectToRoute('bar_product_index', ['bar' => $bar->getslug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
            'bar' => $bar->getSlug()
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager, Bar $bar): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bar_product_index', ['bar' => $bar->getslug()], Response::HTTP_SEE_OTHER);
    }
}
