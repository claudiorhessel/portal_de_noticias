<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Api\SettingsRequest;
use App\Http\Resources\Api\SettingsResource;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $settings = Settings::query();

            $settings = $settings->paginate();

            return response()->json([
                'status' => true,
                'data' => $settings
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
    public function store(SettingsRequest $request): JsonResponse
    {
        try {
            if($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $hash = uniqid(date('His'));
                $fileExtension = $request->file('logo')->extension();
                $filePath = $request
                                ->file("logo")
                                ->storeAs("public", $hash . "." . $fileExtension);

                if ($filePath) {
                    $logoPath = "/storage/" . $hash . "." . $fileExtension;

                    $settingsDataToSave['portal_name'] = $request->portal_name;
                    $settingsDataToSave['logo'] = $logoPath;
                    $settingsDataToSave['email'] = $request->email;

                    $settings = Settings::create($settingsDataToSave);
                }
            }

            if ($settings) {
                $settingsResource = SettingsResource::make($settings);

                return response()->json([
                    'status' => true,
                    'message' => 'Settings successfully created',
                    'data' => $settingsResource
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => [$filePath, $settings]
            ], 500);
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

            $settings = Settings::find($id);

            if(!$settings) {
                return response()->json([
                    'status' => false,
                    'message' => 'Settings not found'
                ], 404);
            }
            $settingsResource = SettingsResource::make($settings);

            return response()->json([
                'status' => true,
                'data' => $settingsResource
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
    public function update(SettingsRequest $request, $id): JsonResponse
    {
        try {
            if(!is_numeric($id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'id must by a number'
                ], 401);
            }

            $settings = Settings::find($id);

            if(!$settings) {
                return response()->json([
                    'status' => false,
                    'message' => 'Settings not found'
                ], 404);
            }

            $settings->fill($request->all());
            $settings->save();

            $settingsResource = SettingsResource::make($settings);
            return response()->json([
                'status' => true,
                'message' => 'Settings successfully updated',
                'data' => $settingsResource
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

            $settings = Settings::find($id);

            if(!$settings) {
                return response()->json([
                    'status' => false,
                    'message' => 'Settings not found'
                ], 404);
            }

            $settings->delete();

            return response()->json([
                'status' => true,
                'message' => 'Settings successfully deleted'
            ], 200);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }
}
