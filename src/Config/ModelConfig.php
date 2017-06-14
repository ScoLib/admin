<?php

namespace Sco\Admin\Config;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class ModelConfig extends Config implements ConfigInterface, Arrayable, Jsonable, JsonSerializable
{

}
