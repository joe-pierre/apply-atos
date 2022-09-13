<?php

namespace App\DataFixtures;

use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $p1 = new Position;
        $p1->setName('UI Designer');
        $manager->persist($p1);
        
        $p2 = new Position;
        $p2->setName('Software Engineer');
        $manager->persist($p2);
        
        $p3 = new Position();
        $p3->setName('Front end Developer');
        $manager->persist($p3);
        
        $p4 = new Position;
        $p4->setName('Back end Developer');
        $manager->persist($p4);

        $p4 = new Position;
        $p4->setName('Scrum Master');
        $manager->persist($p4);

        $p5 = new Position;
        $p5->setName('PHP Developer');
        $manager->persist($p5);

        $p6 = new Position;
        $p6->setName('JAVA Developer');
        $manager->persist($p6);
        

        $manager->flush();
    }
}
