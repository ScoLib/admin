<?php


namespace Sco\Admin\Component\Concerns;


trait HasPermission
{
    public function getObservableMethods()
    {
        return [
            'view', 'create', 'edit',
            'delete', 'destroy', 'restore',
        ];
    }

    
}
