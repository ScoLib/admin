<?php


namespace Sco\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class AdminUser extends Model
{
    use EntrustUserTrait;
}
