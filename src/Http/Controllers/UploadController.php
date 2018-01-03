<?php

namespace Sco\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use InvalidArgumentException;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Form\Elements\File;

class UploadController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param string $field
     * @param mixed $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function formElement(
        Request $request,
        ComponentInterface $component,
        $field,
        $id = null
    ) {
        $file = $request->file($field);
        if (is_null($file) || ! ($file instanceof UploadedFile)) {
            throw new InvalidArgumentException('must upload file');
        }

        if (is_null($id)) {
            $form = $component->fireCreate();
        } else {
            $form = $component->fireEdit($id);
        }

        $element = $form->getElement($field);
        if (! ($element instanceof File)) {
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
