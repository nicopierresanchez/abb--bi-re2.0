<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    const PRODUCT = [
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            1,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            2,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            2,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            3,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            1,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            2,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            3,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            4,
        ],
        [
            'biere blonde 25cl',
            'Une bière blonde est une bière désignée ainsi de par sa couleur.,
            Il est souvent fait une confusion entre le terme bière blonde qui désigne plutôt la couleur de la bière et les types de bières à proprement parler qui servent quant à eux à différencier plutôt le procédé de fabrication, de brassage ou le type de fermentation. ',
            7.60,
            2,
        ],

    ];

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {


        $slugify = new Slugify();


        foreach (self::PRODUCT as $key => $data) {
            $product = new Product();
            $product->setName($data[0]);
            $product->setDescription($data[1]);
            $product->setPrice($data[2]);
            $product->setBar($this->getReference('bar_' . $data[3]));
            $product->setSlug($slugify->generate($product->getName()));
            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [BarFixtures::class];
    }
}
