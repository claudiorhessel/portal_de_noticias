<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NewsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Api\NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $news = News::with(['authors', 'categories']);

            if($request->like_title) {
                $news = $news->where('title', 'LIKE', '%'.$request->like_title.'%');
            }

            if($request->like_category) {
                $news = $news->orWhereRelation('categories', 'name', 'LIKE', '%'.$request->like_category.'%');
            }

            if($request->title) {
                $news = $news->where('title', $request->title);
            }

            if($request->category) {
                $news = $news->whereRelation('categories', 'name', $request->category);
            }

            $news = $news->paginate();

            return response()->json([
                'status' => true,
                'data' => $news
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
    public function store(NewsRequest $request): JsonResponse
    {
        try {
            $news = News::create($request->all());

            $newsResource = NewsResource::make($news);

            return response()->json([
                'status' => true,
                'message' => 'News created',
                'data' => $newsResource
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

            $news = News::find($id);

            if(!$news) {
                return response()->json([
                    'status' => false,
                    'message' => 'News not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $news
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
    public function update(NewsRequest $request, $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $news = News::find($id);

            if(!$news) {
                return response()->json([
                    'status' => false,
                    'message' => 'News not found'
                ], 404);
            }

            $news->fill($request->all());
            $news->save();

            $newsResource = NewsResource::make($news);
            return response()->json([
                'status' => true,
                'message' => 'News updated',
                'data' => $newsResource
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

            $news = News::find($id);

            if(!$news) {
                return response()->json([
                    'status' => false,
                    'message' => 'News not found'
                ], 404);
            }

            $news->delete();

            return response()->json([
                'status' => true,
                'message' => 'News successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }
}
