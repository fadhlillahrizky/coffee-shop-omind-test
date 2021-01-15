<?php

namespace App\Http\Controllers;

use App\Entities\ResponseEntities;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JWTAuth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductController extends Controller
{
    public static function addProduct(Request $request)
    {

        $file = $request->file('image');
        $fileInfo = self::uploading($file);
        $payload = $request->input();
        $payload['image'] = $fileInfo['url'] ?? null;
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->is_admin === 1) {
            return Product::addProduct($payload);
        }
        return self::cannotAccess();
    }

    public static function editProduct(Request $request, $productId)
    {
        $file = $request->file('image');
        $fileInfo = self::uploading($file);
        $payload = $request->input();
        $payload['image'] = $fileInfo['url'] ?? null;
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->is_admin === 1) {
            return Product::editProduct($payload, $productId);
        }
        return self::cannotAccess();
    }

    public static function getProductList(Request $request)
    {
        return Product::getProductList($request->query());
    }

    public static function getProduct(Request $request, $productId)
    {
        return Product::getProduct($productId);
    }

    public static function deleteProduct(Request $request, $productId)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->is_admin === 1) {
            return Product::deleteProduct($productId);
        }
        return self::cannotAccess();
    }

    private static function cannotAccess()
    {
        $response = new ResponseEntities();

        $response->message = 'Cannot access';
        return $response;
    }

    protected static function uploading(UploadedFile $file)
    {

        $storage = Storage::disk('public');

        $filename = str_replace(' ','-', $file->getClientOriginalName());

        $path = date('Y/m/d/') . $filename;

        $isUploadSuccess = $storage->put($path, file_get_contents($file));

        if ($isUploadSuccess) {
            return [
                'url' => $storage->url($path),
                'name' => $filename,
                'size' => $file->getSize()
            ];
        }

        return [];
    }
}
