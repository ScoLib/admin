<?php


namespace Sco\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Manager extends Authenticatable
{
    use EntrustUserTrait;
}
