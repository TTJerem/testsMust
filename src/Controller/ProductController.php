<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\AnnotationsasRest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\AcceptHeader;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Entity\Product;

class ProductController extends FOSRestController
{
    /**
     *.Get a single product by id
     * @Get("/products/{productId}", name="product_get")
     */
    public function getAction(int $productId)
    {
        //Get one product in repos with the request parameter
        $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findById($productId);
        //If founded, serialized as json an return
        if($product) {
            $data = $this->get('serializer')->serialize($product, 'json');
            //Return response
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        } else {
            //Not founder, return 404
            return new Response("Not found, Try again !", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     *.Get all products
     * @Get("/products", name="product_list")
     */
    public function listAction()
    {
        //Get all products with repo
        $products = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();
        //Selialized as json return even if empty
        $data = $this->get('serializer')->serialize($products, 'json');
        //Return response
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     *.Create a product
     * @Post("/products", name="product_create")
     */
    public function createAction(Request $request)
    {
        $product = new Product();

        // Je n'ai pas réussi à réaliser un traitement propre des paramètres par header
        // Je n'ai pas voulu utiliser les paramètres par URL car je trouve la pratique dangereuse.
        // J'aurai pu essayer de recevoir du json comportant les infos du produit mais je pense que les passages des paramètres par header est normalement le plus propre.
        // Je manque de connaissances sur les nouvelles versions de composants d'où mon blocage sur la manière la plus propre de réaliser le traitement
        // J'ai réalisé un code non propre qui permet de continuer mais qui est très mal géré
        foreach (getallheaders() as $name => $value) {
            switch ($name) {
                case 'name':
                    $product->setName($value);
                    break;
                case 'description':
                    $product->setDescription($value);
                    break;
                case 'url':
                    $product->setUrl($value);
                    break;
                case 'active':
                    $product->setActive($value);
                    break;
                /*case 'brand':
                    $product->brand = $value;
                    break;
                case 'categories':
                    $product->categories = $value;
                    break;*/
                default:
                    //Not a valid parameter
                    break;
            }
        }

        //Persist in repository
        $productIdSaved = $this->getDoctrine()
        ->getRepository(Product::class)
        ->saveProduct($product);

        $productSaved = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findById($productIdSaved);

        //Selialized as json return even if empty
        $data = $this->get('serializer')->serialize($productSaved, 'json');
        //Return response
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }

    /**
     *.Delete a product
     * @Delete("/products/{productId}", name="product_deletion")
     */
    /*public function deleteAction(int $productId)
    {
        $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findById($productId);

        //If founded, removed
        if($product)
        {
            $this->getDoctrine()
            ->getRepository(Product::class)
            ->deleteProduct($product);

            return new Response('Product deleted', Response::HTTP_OK);
        }
        else
        {
            return new Response('Product not found', Response::HTTP_NOT_FOUND);
        }
    }*/

    /**
     *.Update a product
     * @Put("/products/{id}", name="product_update")
     */
    /*public function updateAction()
    {

    }*/
}
