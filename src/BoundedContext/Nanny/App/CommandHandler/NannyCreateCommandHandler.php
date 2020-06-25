<?php

namespace App\BoundedContext\Nanny\App\CommandHandler;

use App\BoundedContext\Nanny\App\Command\NannyCreateCommand;
use App\BoundedContext\Nanny\Domain\Model\Nanny;
use App\BoundedContext\Nanny\Domain\RepositoryInterface\NannyRepositoryInterface;
use Ramsey\Uuid\Uuid;

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

    public function __construct(NannyRepositoryInterface $nannyRepository)
    {
        $this->repository = $nannyRepository;
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
            $command->getPassword('password'),
            $command->getDateRecording('dateRecording'),
        );

        $this->repository->save($nanny);

        return $nanny;
    }
}
