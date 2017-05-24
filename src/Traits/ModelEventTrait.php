<?php


namespace Sco\Admin\Traits;


trait ModelEventTrait
{
    public function bootModelEventTrait()
    {
        $this->events = [
            'created'  => \Sco\ActionLog\Events\ModelWasCreated::class,
            'updated'  => \Sco\ActionLog\Events\ModelWasUpdated::class,
            'deleted'  => \Sco\ActionLog\Events\ModelWasDeleted::class,
        ];
    }
}
