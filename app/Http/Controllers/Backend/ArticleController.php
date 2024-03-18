<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\Backend\Article\StoreRequest;
use App\Http\Requests\Backend\Article\UpdateRequest;
use Intervention\Image\Facades\Image as ImageIntervention;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Article::select('id', 'title', 'slug', 'content', 'image', 'date');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('title', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->editColumn('image', function ($row) {
                    return "<img src='" . asset($row->image) . "' alt='" . $row->title . "' style='height: 70px'>";
                })
                ->editColumn('content', function ($row) {
                    return Str::limit(strip_tags($row->content), 50);
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('articles.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['image', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.articles.index');
    }

    public function create()
    {
        return view('backend.sections.articles.create');
    }

    public function store(StoreRequest $request)
    {
        // save image
        $image = $request->file('image');
        $thumbnailImage = ImageIntervention::make($image)->orientate();
        $thumbnailPath = public_path() . '/uploads/articles/';
        $imageName = time() . $image->getClientOriginalName();
        $thumbnailImage->save($thumbnailPath . $imageName, 60);

        Article::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'content' => $request->get('content'),
            'image' => "uploads/articles/{$imageName}",
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('articles.index');
    }

    public function edit($id)
    {
        $article = Article::find($id);

        return view('backend.sections.articles.edit', compact('article'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $article = Article::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $thumbnailImage = ImageIntervention::make($image)->orientate();
            $thumbnailPath = public_path() . '/uploads/articles/';
            $imageName = time() . $image->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath . $imageName, 60);

            if (File::exists($article->image)) {
                File::delete($article->image);
            }

            $article->update([
                'image' => "uploads/articles/{$imageName}"
            ]);
        }

        $article->update([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'content' => $request->get('content'),
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('articles.index');
    }

    public function show($id)
    {
        $article = Article::find($id);

        return [
            'title' => $article->title,
            'content' => strip_tags($article->content),
            'image' => asset($article->image),
            'date' => $article->date->format('d-m-Y')
        ];
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('articles.index');
    }
}
