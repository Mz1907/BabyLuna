<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RestaurantBundle\Facebook;
use RestaurantBundle\Repository\FacebookEventRepository;

class DefaultController extends Controller {

    public function indexAction() {
        /* récupération des derniers facebookEvents */
        $repoFacebookEvent = $this->getDoctrine()->getManager()->getRepository('RestaurantBundle:FacebookEvent');
        $lastEvents = $repoFacebookEvent->findLast();
        
        $vars['lastEvents'] = $lastEvents;
        return $this->render('RestaurantBundle:Front\Home:index.html.twig', ['vars' => $vars]);
    }

    //Permet de lier un produit à une catégorie dans les fixtures
    public function addCatFixtureAction() {

        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $product = $em->getRepository('RestaurantBundle:Product')->find(1);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id " . 1 . " n'existe pas.");
        }

        // La méthode findAll retourne toutes les catégories de la base de données
        $listCategories = $em->getRepository('RestaurantBundle:ProductCategory')->findAll();

        // On boucle sur les catégories pour les lier à l'annonce
        foreach ($listCategories as $category) {
            $product->addCategory($category);
        }

        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // … reste de la méthode
        return $this->render('AdminBundle:Default:index.html.twig');
    }

}
