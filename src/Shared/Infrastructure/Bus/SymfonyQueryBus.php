<?php
/**
 *
 * @copyright 2020 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Bus\QueryBusInterface;
use App\Shared\Application\Query\QueryInterface;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyQueryBus implements QueryBusInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $queryBus;

    /**
     * SymfonyQueryBus constructor.
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @param QueryInterface $query
     * @return mixed
     * @throws Exception
     */
    public function query(QueryInterface $query)
    {
        $envelope = $this->queryBus->dispatch($query);
        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }
}
