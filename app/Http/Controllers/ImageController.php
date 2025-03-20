<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public function ImageUpload(ImageUploadRequest $request): \Illuminate\Http\JsonResponse
    {
        $imageManager= new ImageManager(Driver::class);
        $imageFile=$request->file("image");
        $user_id=$request->query( 'user_id');
        $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
        $destinationPath = public_path('public');

        $mainImage = $imageManager->read($imageFile);
        $mainImage->resize(1920, 1920)->save($destinationPath . $fileName);
        $imageUrl=asset("public".$fileName);
        $imageUp=new Image();
        $imageUp->user_id=$user_id;
        $imageUp->url=$imageUrl;
        $imageUp->save();
        return response()->json([
            'success' => true,
            'message' => 'Ảnh đã upload thành công!',
            'image_url' => $imageUrl,
        ]);
    }
}
