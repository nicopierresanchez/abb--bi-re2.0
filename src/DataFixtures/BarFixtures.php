<?php

namespace App\DataFixtures;

use App\Entity\Bar;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BarFixtures extends Fixture implements DependentFixtureInterface
{
    const BARS = [
        [
            'Smoking barrel',
            'https://media-cdn.tripadvisor.com/media/photo-s/0e/59/c0/57/all-credits-for-this.jpg',
            'fumoir a viande',
            '4 avenue de la soif',
            661548782,
            3
        ],
        [
            'The Hopscotch Pub & Brewery',
            'https://hopscotchpub.com/wp-content/uploads/2017/09/IMG_8189_petite.jpg',
            'Pub',
            ' 3 Rue Baour Lormian, 31000 Toulouse',
            951623643,
            4
        ], [
            'The Thirsty Monk Pub',
            'https://media-cdn.tripadvisor.com/media/photo-s/08/77/9a/33/our-stage-area.jpg',
            'Pub',
            '33 All. Jean Jaurès, 31000 Toulouse',
            581342815,
            6
        ], [
            'La Cale Sèche',
            'https://cdt31.media.tourinsoft.eu/upload/Cale-Seche.jpg?width=780&height=560&crop=1',
            'Bar',
            '41 Rue Léon Gambetta, 31000 Toulouse',
            null,
            5
        ], [
            'Fat Cat',
            'https://s3-eu-west-1.amazonaws.com/privateaser-media/etab_photos/3032/450x300/262321.jpg',
            'Bar à cocktails',
            '4 Rue Charles de Rémusat, 31000 Toulouse',
            null,
            4
        ], [
            'Délirium Café Toulouse',
            'https://static.actu.fr/uploads/2017/12/deliirum-960x640.jpg',
            'Bar',
            '54 All. Jean Jaurès, 31000 Toulouse',
            967297996,
            3
        ], [
            'The Botanist Pub',
            'https://media-cdn.tripadvisor.com/media/photo-s/1b/ea/69/8f/we-love-live-music-at.jpg',
            'Bar',
            '33 Bd Maréchal Leclerc, 31000 Toulouse',
            534308234,
            2
        ], [
            'The London Town',
            'https://cdt31.media.tourinsoft.eu/upload/LONDON-INTERweb-2.jpg',
            'Bar',
            '14 Rue des Prêtres, Rue des Pretres, 31000 Toulouse',
            562265310,
            1
        ],

    ];

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {


        $slugify = new Slugify();

        foreach (self::BARS as $key => $data) {
            $bar = new Bar();
            $bar->setName($data[0]);
            $bar->setImage($data[1]);
            $bar->setType($data[2]);
            $bar->setAddress($data[3]);
            $bar->setSlug($slugify->generate($bar->getName()));
            $bar->setPhone($data[4]);
            $bar->setUser($this->getReference('user_'.$data[5]));

            $manager->persist($bar);
            $this->addReference('bar_' . $key, $bar);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
