<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    protected $default_per_page = 10;

    public function index(Request $request)
    {
        $this->validate($request, [
            'page' => 'numeric|min:1',
            'per_page' => 'numeric|min:1',
        ]);

        $per_page = $request->per_page ?? $this->default_per_page;

        $articles = Article::query()
            ->paginate(
                $per_page,
                ['*'],
                'page',
                $request->page
            );

        return response([
            'articles' => ArticleResource::collection($articles->items()),
            'pages' => ceil($articles->total() / $per_page),
        ]);
    }

    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response([], Response::HTTP_NOT_FOUND);
        }

        return response(new ArticleResource($article));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'url' => 'required|string|url',
            'imageUrl' => 'required|url',
            'newsSite' => 'required|string',
            'summary' => 'required|string',
            'events' => 'array',
            'launches' => 'array',
        ]);

        if ($request->events) {
            foreach ($request->events as $event) {
                $validator = Validator::make((array) $event, [
                    'id' => 'required|string',
                    'provider' => 'required|string',
                ]);

                if ($validator->fails()) {
                    return response(
                        null,
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
                }
            }
        }

        if ($request->launches) {
            foreach ($request->launches as $launch) {
                $validator = Validator::make((array) $launch, [
                    'id' => 'required|string',
                    'provider' => 'required|string',
                ]);

                if ($validator->fails()) {
                    return response(
                        null,
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
                }
            }
        }

        $article = Article::create($request->all());

        return response(
            new ArticleResource($article),
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response([], Response::HTTP_NOT_FOUND);
        }

        $this->validate($request, [
            'title' => 'string',
            'url' => 'url',
            'imageUrl' => 'url',
            'newsSite' => 'string',
            'summary' => 'string',
            'events' => 'array',
            'launches' => 'array',
        ]);

        if ($request->events) {
            foreach ($request->events as $event) {
                $validator = Validator::make((array) $event, [
                    'id' => 'required|string',
                    'provider' => 'required|string',
                ]);

                if ($validator->fails()) {
                    return response(
                        null,
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
                }
            }
        }

        if ($request->launches) {
            foreach ($request->launches as $launch) {
                $validator = Validator::make((array) $launch, [
                    'id' => 'required|string',
                    'provider' => 'required|string',
                ]);

                if ($validator->fails()) {
                    return response(
                        null,
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
                }
            }
        }

        $article->update($request->all());

        return response(new ArticleResource($article));
    }
}
