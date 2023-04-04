<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Requests\Api\NewsRequest;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $request->query->add([
                "like_title" => $request->search,
                "like_category" => $request->search
            ]);
        }

        $newsController = new NewsController;
        $newsData = $newsController->index($request);

        $settingsController = new SettingsController;
        $settingsData = $settingsController->index();

        $data = [
            "origin" => "index",
            "news" => $newsData->getData()->data,
            "settings" => $settingsData->getData()->data,
            "search" => $request->search,
            "redirectTo" => "/portal"
        ];

        return view('portal.portal', $data);
    }

    public function store(NewsRequest $request)
    {
        $newsController = new NewsController;
        $newsData = $newsController->store($request);

        if($newsData->getData()->status) {
            return redirect()
                ->route("portal.index")
                ->with("success", "Notícia criada com sucesso!");
        }

        return redirect()
            ->back()
            ->with("error", $newsData->getData()->message);
    }

    public function update(Request $request)
    {
        $newsRequest = new NewsRequest($request->toArray());

        $newsController = new NewsController;
        $newsData = $newsController->update($newsRequest, $request->id);

        if ($newsData->getData()->status) {
            return redirect()
                ->route('news.show', [$request->id])
                ->with('success',"Notícia atualizada com sucesso!");
        }

        return redirect()
            ->back()
            ->with('info',"Erro ao atualizar notícia!");
    }

    public function show(string $id)
    {
        $newsController = new NewsController;
        $newsData = $newsController->show($id);

        $data = [
            "search" => "",
            "origin" => "show",
            "news" => $newsData->getData()->data
        ];

        return view('portal.portal', $data);
    }

    public function delete(string $id)
    {
        $newsController = new NewsController;
        $newsController->destroy($id);

        return redirect()
            ->route('portal.index')
            ->with('success',"Notícia deletada com sucesso!");
    }

    public function edit(string $id)
    {
        $newsController = new NewsController;
        $newsData = $newsController->show($id);

        $categoryController = new CategoryController;
        $categoriesData = $categoryController->index();

        $data = [
            "errors" => null,
            "search" => "",
            "origin" => "edit",
            "news" => $newsData->getData()->data,
            "categories" => $categoriesData->getData()->data
        ];

        return view('portal.portal', $data);
    }

    public function insert()
    {
        $categoryController = new CategoryController;
        $categoriesData = $categoryController->index();

        $authorController = new AuthorController;
        $authorsData = $authorController->index();

        $data = [
            "errors" => null,
            "search" => "",
            "origin" => "insert",
            "news" => "",
            "categories" => $categoriesData->getData()->data,
            "authors" => $authorsData->getData()->data
        ];

        return view('portal.portal', $data);
    }
}
