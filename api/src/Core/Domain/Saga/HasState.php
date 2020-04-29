<?php
declare(strict_types=1);

namespace App\Core\Domain\Saga;

use Symfony\Component\Workflow\StateMachine;

trait HasState
{
    private StateMachine $workflow;
    private string $state;

    public function getState() : string
    {
        return $this->state;
    }

    public function setState(string $state, $context = []): void
    {
        $this->state = $state;
    }
}
