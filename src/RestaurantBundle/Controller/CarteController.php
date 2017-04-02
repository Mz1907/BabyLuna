<?php

namespace RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CarteController extends controller {
    /*
     * Affiche la carte du restaurant. Une carte contient des produits. 
     * En récupérant tout les produits je récupère les catégories et images qui leur sont associées
     */
    public function showCarteAction() {
        //Récupération des catégories available
        $repoProductCategories = $this->getDoctrine()
                        ->getManager()->getRepository('RestaurantBundle:ProductCategory');
        
        // @categoriesAvailable: un tableau d'objets
        $categoriesAvailable = $repoProductCategories->getAllCategoriesAvailable();
        
        if(null == $categoriesAvailable)
        {
            throw $this->createNotFoundException("Carte indisponible pour le moment. Veuillez nous excuser. (c1)");
        }
        
        $sortedCategories = $this->sortMenuCategoriesAction($categoriesAvailable);

        return $this->render('RestaurantBundle:Front/Carte:carte.html.twig', [
                    'categoriesAvailable' => $sortedCategories
        ]);
    }

    /*
     * Trie le tableau contenant la liste des menus. Afin de commencer par les entrées 
     * et de terminer par les thés .
     * 
     * @array: $categoriesAvailable
     * @return array
     */
    public function sortMenuCategoriesAction(array $categoriesAvailable) {
        $sortedCategories = [];

        foreach ($categoriesAvailable as $catObj) {
            switch (strtolower($catObj->getName())) {
                case 'les entrées':
                    $sortedCategories[0] = $catObj;
                    break;
                case 'les salades':
                    $sortedCategories[1] = $catObj;
                    break;
                case 'les pâtes':
                    $sortedCategories[2] = $catObj;
                    break;
                case 'les viandes':
                    $sortedCategories[3] = $catObj;
                    break;
                case 'les poissons':
                    $sortedCategories[4] = $catObj;
                    break;
                case 'les desserts':
                    $sortedCategories[5] = $catObj;
                    break;
                case 'les boissons':
                    $sortedCategories[6] = $catObj;
                    break;
                case 'les apéritifs':
                    $sortedCategories[7] = $catObj;
                    break;
                case 'les bières':
                    $sortedCategories[8] = $catObj;
                    break;
                case 'les bios':
                    $sortedCategories[9] = $catObj;
                    break;
                case 'cafés nespresso':
                    $sortedCategories[10] = $catObj;
                    break;
                case 'nos thés':
                    $sortedCategories[11] = $catObj;
                    break;
            }
        }

        ksort($sortedCategories);

        return $sortedCategories;
    }

}
