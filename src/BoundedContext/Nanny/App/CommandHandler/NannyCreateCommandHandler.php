<?php

namespace App\BoundedContext\Nanny\App\CommandHandler;

use App\BoundedContext\Nanny\App\Command\NannyCreateCommand;
use App\BoundedContext\Nanny\Domain\Model\Nanny;
use App\BoundedContext\Nanny\Domain\RepositoryInterface\NannyRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Class NannyCreateCommandHandler
 *
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class NannyCreateCommandHandler
{
    /**
     * @var NannyRepositoryInterface
     */
    private $repository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * NannyCreateCommandHandler constructor.
     * @param NannyRepositoryInterface $nannyRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(NannyRepositoryInterface $nannyRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->repository = $nannyRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param  NannyCreateCommand $command
     * @return mixed
     */
    public function __invoke(NannyCreateCommand $command)
    {
        $nanny = new Nanny(
            Uuid::uuid4()->toString(),
            $command->getLastName('lastname'),
            $command->getFirstName('firstname'),
            $command->getBirthday('birthday') ? $command->getBirthday('birthday'):null,
            $command->getAdresse('adresse') ? $command->getAdresse('adresse'):null,
            $command->getPostalCode('postalCode')  ? $command->getPostalCode('postalCode'):null,
            $command->getCity('city') ? $command->getCity('city'):null,
            $command->getPhoneNumber('phoneNumber') ? $command->getPhoneNumber('phoneNumber'):null,
            $command->getFunction('function') ? $command->getFunction('function'):null,
            $command->getEmail('email'),
            $this->passwordEncoder->encodePassword($command->getPassword('password'), null),
            $command->getDateRecording('dateRecording'),
        );

        $this->repository->save($nanny);

        return $nanny;
    }
}
