<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\Api\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::all();

            return response()->json([
                'status' => true,
                'data' => $categories
            ], 201);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $categories = Category::create($request->all());

            $categoriesResource = CategoryResource::make($categories);

            return response()->json([
                'status' => true,
                'message' => 'Category successfully created',
                'data' => $categoriesResource
            ], 201);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $categories = Category::find($id);

            if(!$categories) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found'
                ], 404);
            }
            $categoriesResource = CategoryResource::make($categories);

            return response()->json([
                'status' => true,
                'data' => $categoriesResource
            ], 200);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $categories = Category::find($id);

            if(!$categories) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $categories->fill($request->all());
            $categories->save();

            $categoriesResource = CategoryResource::make($categories);
            return response()->json([
                'status' => true,
                'message' => 'Category successfully updated',
                'data' => $categoriesResource
            ], 200);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'data' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $categories = Category::find($id);

            if(!$categories) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $categories->delete();

            return response()->json([
                'status' => true,
                'message' => 'Category successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }
}
