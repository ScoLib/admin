<?php

namespace Sco\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sco\Admin\Contracts\ComponentInterface;

class UploadController extends Controller
{
    public function formElement(Request $request, ComponentInterface $component, $field, $id = null)
    {
        if (is_null($id)) {
            $form = $component->fireCreate();
        } else {
            $form = $component->fireEdit($id);
        }

        $element = $form->getElement($field);

        return response()->json(['message' => 'ok', 'id' => time()]);
    }
}
