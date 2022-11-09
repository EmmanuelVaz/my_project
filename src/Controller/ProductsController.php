<?php 
namespace App\Controller;

use App\Entity\Products;
use App\Form\AddProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig');
    }

    #[Route('/{slug}', name: 'details')]
    public function details(Products $product): Response
    {
        return $this->render('products/details.html.twig', compact('product'));
    }



    #[Route('/ajout_produit', name: 'add_products')]
    public function add_products(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Products();
        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
        }

        return $this->render('products/add.html.twig', [
            'addProductsForm' => $form->createView(),
        ]);
    }
}
?>