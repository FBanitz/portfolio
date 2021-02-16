<?php

namespace App\DataFixtures;


use Faker;
use App\Entity\Projets;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $projet = new Projets();
            $projet->setNom($faker->name('male'));
            $projet->setDescription($faker->text(255));
            $projet->setImg('projet' . $i . '.png');
            $projet->setLien($faker->text(10) . '.com');
            $manager->persist($projet);
        }

        $manager->flush(); // met à jour en bdd
    }
}
