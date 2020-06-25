<?php

namespace App\BoundedContext\Nanny\Domain\RepositoryInterface;

use App\BoundedContext\Nanny\Domain\Model\Nanny;

/**
 * Class NannyRepositoryInterface
 *
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
interface NannyRepositoryInterface
{
    /**
     * @param Nanny $nanny
     */
    public function save(Nanny $nanny): void;
}
