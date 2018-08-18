<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\ImageRequest;
use App\Models\Image;
use App\Transformers\ImageTransformer;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $handler, Image $image)
    {
        $user = $this->user();

        $size = $request->type == 'avatar' ? 316 : 1024 ;
        $result = $handler->save($request->image, str_plural($request->type), $user->id.'_avatar', $size);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();

        return $this->response->item($image, new ImageTransformer())->setStatusCode(201);
    }
}
