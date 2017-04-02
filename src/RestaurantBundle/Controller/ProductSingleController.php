<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RestaurantBundle\Entity\Product;
use RestaurantBundle\Entity\ProductCategory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * Description of ProductSingle
 *
 * @author zmmai
 */
class ProductSingleController extends Controller {
    
    public function showProductSingleAction(Product $product)
    {
        $repoProduct = $this->getDoctrine()->getManager()->getRepository('RestaurantBundle:Product');
        $productSingle = $repoProduct->getOneProductById($product->getId());
        
        if(null == $productSingle)
        {
            throw $this->createNotFoundException("Le produit demandé n'existe pas ou n'est pas disponible. Veuillez nous excuser. (p1)");
        }
        
        $this->generateUrl('restaurant_product_single', array('slug' => $product->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL);
        
        return $this->render('RestaurantBundle:Front/Product:productSingle.html.twig', 
                [
                    'productSingle' => $productSingle
                ]);
    }
}
