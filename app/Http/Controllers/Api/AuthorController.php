<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Api\AuthorResource;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $authors = Author::query();

            if($request->like_full_name) {
                $authors = $authors->where('full_name', 'LIKE', '%'.$request->full_name.'%');
            }

            if($request->like_nick_name) {
                $authors = $authors->where('nick_name', 'LIKE', '%'.$request->nick_name.'%');
            }

            if($request->full_name) {
                $authors = $authors->where('full_name', $request->full_name);
            }

            if($request->nick_name) {
                $authors = $authors->where('nick_name', $request->nick_name);
            }

            $authors = $authors->paginate();

            return AuthorResource::collection($authors)
                ->response()
                ->setStatusCode('200');
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
    public function store(AuthorRequest $request)
    {
        try {
            $author = Author::create($request->all());

            return AuthorResource::make([
                'status' => true,
                'data' => $author
            ], 200);
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
    public function show(string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $author = Author::find($id);

            if(!$author) {
                return response()->json([
                    'status' => false,
                    'message' => 'Author not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $author
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
    public function update(AuthorRequest $request, $id): AuthorResource
    {
        try {
            if(!is_numeric($id)) {
                return AuthorResource::make([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $author = Author::find($id);

            if(!$author) {
                return AuthorResource::make([
                    'status' => false,
                    'message' => 'Author not found'
                ], 404);
            }

            $author->fill($request->all());
            $author->save();

            return AuthorResource::make([
                'status' => true,
                'data' => $author
            ], 200);
        } catch (\Throwable $error) {
            return AuthorResource::make([
                'status' => false,
                'data' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $author = Author::find($id);

            if(!$author) {
                return AuthorResource::make([
                    'status' => false,
                    'message' => 'Author not found'
                ], 404);
            }

            $author->delete();

            return AuthorResource::make([
                'status' => true,
                'message' => 'Author successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return AuthorResource::make([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }
}
