<?php

namespace App\DataFixtures;

use App\BoundedContext\Nanny\Domain\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class NannyFixtures
 *
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class NannyFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * NannyFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Persistence\ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $nanny = new Model\Nanny(
                Uuid::uuid4(),
                $faker->lastName,
                $faker->firstName,
                $faker->dateTime,
                $faker->address,
                $faker->postcode,
                $faker->city,
                $faker->phoneNumber,
                $faker->jobTitle,
                $faker->email,
                $faker->password,
                $faker->dateTime
            );
            $nanny->setUuid($faker->uuid);
            $nanny->setLastName($faker->lastName);
            $nanny->setFirstName($faker->firstName);
            $nanny->setBirthday($faker->dateTime($max = 'now', $timezone = null));
            $nanny->setAdresse($faker->streetAddress);
            $nanny->setPostalCode($faker->postcode);
            $nanny->setCity($faker->city);
            $nanny->setPhoneNumber($faker->phoneNumber);
            $nanny->setFunction($faker->jobTitle);
            $nanny->setEmail($faker->email);
            $nanny->setPassword($this->passwordEncoder->encodePassword($nanny, $faker->password));
            $manager->persist($nanny);
            $nanny->setDateRecording($faker->dateTime($max = 'now', $timezone = null));
        }

        $manager->flush();
    }
}
