<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use stdClass;

class ProductController extends Controller
{
    public function getAll() {
        return response()->json(Products::all(), 200);
    }

    public function getById($id) {
        $selectedProduct = Products::find($id);
        if ($selectedProduct) {
            return response()->json($selectedProduct, 200);
        } else {
            $response = new stdClass();
            $response->message = 'Data not found';

            return response()->json($response, 400);
        }
    }

    public function create(Request $request) {
        $requestData = $request->all();

        $customthumb = request()->file('image');
            $filenamethumb = preg_replace(
                '/\s+/',
                '',
                pathinfo($customthumb->getClientOriginalName(), PATHINFO_FILENAME) .
                random_int(0, 100) .
                '.' .
                $customthumb->getClientOriginalExtension()
            );
        $customthumb->move(public_path() . '/images', $filenamethumb);
        $requestData['image'] = 'images/' . $filenamethumb;

        $createdProduct = Products::create($requestData);
        return response()->json($createdProduct, 201);
    }

    public function update(Request $request, $id) {
        $selectedProduct = Products::find($id);
        $selectedProduct->update($request->all());

        return response()->json($selectedProduct, 200);
    }

    public function delete($id) {
        $selectedProduct = Products::find($id);
        if ($selectedProduct) {
            $selectedProduct->delete();

            return response()->json(null, 200);
        } else {
            $response = new stdClass();
            $response->message = 'Data not found';

            return response()->json($response, 400);
        }
    }
}
