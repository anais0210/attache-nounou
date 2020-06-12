<?php

namespace App\DataFixtures;

use App\Entity\Nanny;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

/**
 * Class NannyFixtures
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class NannyFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $nanny = new Nanny();
            $nanny->setEmail($faker->email);
            $nanny->setPassword($faker->password);
            $manager->persist($nanny);

        $manager->flush();
    }
}
}
