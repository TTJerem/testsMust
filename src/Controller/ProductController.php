<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\AnnotationsasRest;
use App\Entity\Product;

class ProductController extends FOSRestController
{
    /**
     *.Get a single product by id
     * @Route("/products/{id}", name="product_get")
     * @Method({"GET"})
     */
    public function getAction(int $id)
    {
        //Get one product in repos with the request parameter
        $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findById($id);

        if($product) {
            $data = $this->get('serializer')->serialize($product, 'json');

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        } else {
            return new Response("Not found, Try again !", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     *.Get all products
     * @Route("/products", name="product_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        //Get all products with repo
        $products = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();
        $data = $this->get('serializer')->serialize($products, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     *.Create a product
     * @Route("/products", name="product_create")
     * @Method({"POST"})
     */
    /*public function createAction(Request $request)
    {
        $data = $request->getContent();
        $article = $this->get('serializer')->deserialize($data, 'App\Entity\Product', 'json');

        //Persist in repository

        return new Response('', Response::HTTP_CREATED);
    }*/

    /**
     *.Delete a product
     * @Route("/products/{id}", name="product_get")
     * @Method({"DELETE"})
     */
    /*public function deleteAction()
    {
        //Get one product in repose
        $product = null;
        $data = $this->get('serializer')->serialize($product, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }*/

    /**
     *.Update a product
     * @Route("/products/{id}", name="product_get")
     * @Method({"PUT"})
     */
    /*public function updateAction()
    {
        //Update an existing product
        $product = null;
        $data = $this->get('serializer')->serialize($product, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }*/
}
