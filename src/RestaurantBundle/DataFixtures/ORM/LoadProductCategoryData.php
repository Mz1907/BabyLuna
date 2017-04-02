<?php
namespace RestaurantBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RestaurantBundle\Entity\ProductCategory;

class LoadProductCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $prodCat = new ProductCategory();
        $prodCat->setName('pizzas');

        $manager->persist($prodCat);
        $manager->flush();
    }
}