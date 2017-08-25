<?php

namespace Sco\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Exceptions\InvalidArgumentException;
use Sco\Admin\Form\Elements\File;

class UploadController extends Controller
{
    public function formElement(Request $request, ComponentInterface $component, $field, $id = null)
    {
        $file = $request->file($field);
        if (is_null($file) || !($file instanceof UploadedFile)) {
            throw new InvalidArgumentException('must upload file');
        }

        if (is_null($id)) {
            $form = $component->fireCreate();
        } else {
            $form = $component->fireEdit($id);
        }

        $element = $form->getElement($field);
        if (!($element instanceof File)) {
            throw new InvalidArgumentException(
                sprintf(
                    '[%s] element must be instanced of "Sco\Admin\Form\Elements\File".',
                    $field
                )
            );
        }

        $data = $element->saveFile($file);
        return response()->json($data);
    }
}
