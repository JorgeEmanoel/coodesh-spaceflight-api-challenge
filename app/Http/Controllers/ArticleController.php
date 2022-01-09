<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

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
            'articles' => $articles->items(),
            'pages' => ceil($articles->total() / $per_page),
        ]);
    }
}
