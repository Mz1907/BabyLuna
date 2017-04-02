<?php
namespace RestaurantBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RestaurantBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName('pizza napolitaine');
        $product->setAvailable(true);

        $manager->persist($product);
        $manager->flush();
    }
}