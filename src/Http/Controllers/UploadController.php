<?php

namespace Sco\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use InvalidArgumentException;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Exceptions\AuthenticationException;
use Sco\Admin\Form\Elements\File;

class UploadController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param string $field
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Sco\Admin\Exceptions\AuthenticationException
     */
    public function formElement(
        Request $request,
        ComponentInterface $component,
        $field,
        $id = null
    ) {
        if ((is_null($id) && ! $component->isCreate()) || ($id && ! $component->isEdit())) {
            throw new AuthenticationException();
        }

        if (! $request->hasFile($field)) {
            throw new InvalidArgumentException('Not found upload file');
        }

        $file = $request->file($field);
        if (is_null($file) || ! ($file instanceof UploadedFile)) {
            throw new InvalidArgumentException('Must be upload file');
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
                    '[%s] element must be instanced of "%s".',
                    $field,
                    File::class
                )
            );
        }

        $data = $element->saveFile($file);

        return response()->json($data);
    }
}
