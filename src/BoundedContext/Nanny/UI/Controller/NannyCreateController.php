<?php

namespace App\BoundedContext\Nanny\UI\Controller;

use App\BoundedContext\Nanny\App\Command\NannyCreateCommand;
use DateTime;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @SWG\Swagger(
 *         basePath="/attache-nounou/nanny/create",
 *         host="localhost:80",
 *         schemes={"http"},
 *         produces={"application/json"},
 *         consumes={"application/json"},
 * @SWG\Info(
 *             title="Attache-Nounou",
 *             description="",
 *             version="1.0",
 *             termsOfService="terms",
 * @SWG\Contact(name="a.sparesotto@icloud.com"),
 * @SWG\License(name="proprietary")
 *         ),
 * )
 */

/**
 * Class nannyShowController
 *
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class NannyCreateController extends AbstractController
{

    /**
     * @param \Symfony\Component\Messenger\MessageBusInterface          $commandBus
     * @param \Symfony\Component\HttpFoundation\Request                 $request
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function indexAction(MessageBusInterface $commandBus, Request $request, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $command = new NannyCreateCommand(
            Uuid::uuid4(),
            $data['lastname'],
            $data['firstname'],
            $data['birthday'] ? new DateTime($data['birthday']) : null,
            $data['adresse'],
            $data['postalCode'],
            $data['city'],
            $data['phoneNumber'],
            $data['function'],
            $data['email'],
            $data['password'],
            new DateTime()
        );

        $errors = $validator->validate($command);
        if (count($errors) > 0) {
            $errorsString = $errors;
            return new JsonResponse($errorsString);
        }

        $envelope = $commandBus->dispatch($command);
        $envelope->last(HandledStamp::class);

        return new JsonResponse();
    }
}
