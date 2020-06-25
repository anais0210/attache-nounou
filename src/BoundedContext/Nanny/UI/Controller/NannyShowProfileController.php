<?php

namespace App\BoundedContext\Nanny\UI\Controller;

use App\BoundedContext\Nanny\App\Query\NannyShowProfileQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp as HandledStampAlias;

/**
 * Class NannyShowProfileController
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class NannyShowProfileController extends AbstractController
{
    /**
     * @param \Symfony\Component\Messenger\MessageBusInterface $queryBus
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction(MessageBusInterface $queryBus)
    {
        $envelope = $queryBus->dispatch(new NannyShowProfileQuery());
        $handledStamp = $envelope->last(HandledStampAlias::class);
        $nannys = $handledStamp->getResult();

        $formattedNannys = [];
        foreach ($nannys as $nanny) {
            $formattedNotes[] = [
                'id' => $nanny->getId(),
                'name' => $nanny->getName(),
            ];
        }
        return new JsonResponse($formattedNannys);
    }
}
