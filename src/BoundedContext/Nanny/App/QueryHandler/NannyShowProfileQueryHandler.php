<?php

namespace App\BoundedContext\Nanny\App\QueryHandler;

use App\BoundedContext\Nanny\App\Query\NannyShowProfileQuery;
use App\BoundedContext\Nanny\Infra\Repository\NannyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class NannyShowProfileQueryHandler
 *
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class NannyShowProfileQueryHandler implements MessageHandlerInterface
{
    /**
     * @var NannyRepository
     */
    private $nanny;

    /**
     * NannyShowQueryHandler constructor.
     *
     * @param NannyRepository $nannyRepository
     */
    public function __construct(NannyRepository $nannyRepository)
    {
        $this->nanny = $nannyRepository;
    }

    /**
     * @param \App\BoundedContext\Nanny\App\Query\NannyShowProfileQuery $query
     *
     * @return array
     */
    public function __invoke(NannyShowProfileQuery $query)
    {
        return $this->nanny->findAll();
    }
}
