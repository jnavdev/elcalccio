<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Album\AddPhotosRequest;
use App\Http\Requests\Backend\Album\StoreRequest;
use App\Http\Requests\Backend\Album\UpdateRequest;
use Intervention\Image\Facades\Image as ImageIntervention;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Album::select('id', 'title', 'description', 'date', 'is_active');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('title', 'like', "%" . $request->get('search')['value'] . "%")
                            ->orWhere('description', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('albums.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";

                    $deleteButton = "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Desactivar'><i class='fas fa-close'></i> Desactivar</button>";

                    if (!$row->is_active) {
                        $deleteButton = "<button class='btn btn-sm btn-success btn-delete' data-id='{$row->id}' title='Activar'><i class='fas fa-check'></i> Activar</button>";
                    }

                    $buttons .= $deleteButton;

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.albums.index');
    }

    public function create()
    {
        return view('backend.sections.albums.create');
    }

    public function store(StoreRequest $request)
    {
        $album = Album::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'description' => $request->get('description'),
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d'),
            'is_active' => $request->get('is_active')
        ]);

        foreach ($request->file('photos') as $image) {
            $thumbnailImage = ImageIntervention::make($image)->orientate();
            $thumbnailPath = public_path() . '/uploads/albums/';
            $imageName = time() . $image->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath . $imageName, 60);

            Photo::create([
                'name' => "uploads/albums/{$imageName}",
                'album_id' => $album->id
            ]);
        }

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('albums.index');
    }

    public function show($id)
    {
        $album = Album::with('photos')->find($id);
        $photos = $album->photos->map(function ($photo) {
            $photo->name = asset($photo->name);

            return $photo;
        });

        return [
            'title' => $album->title,
            'description' => $album->description,
            'date' => $album->date->format('d-m-Y'),
            'photos' => $photos
        ];
    }

    public function edit($id)
    {
        $album = Album::with('photos')->find($id);

        return view('backend.sections.albums.edit', compact('album'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $album = Album::find($id);

        $album->update([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'description' => $request->get('description'),
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d'),
            'is_active' => $request->get('is_active')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('albums.index');
    }

    public function destroy($id)
    {
        $album = Album::find($id);

        if ($album->is_active) {
            $album->update([
                'is_active' => false
            ]);
        } else {
            $album->update([
                'is_active' => true
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('albums.index');
    }

    public function addPhotos(AddPhotosRequest $request, $id)
    {
        foreach ($request->file('photos') as $image) {
            $thumbnailImage = ImageIntervention::make($image)->orientate();
            $thumbnailPath = public_path() . '/uploads/albums/';
            $imageName = time() . $image->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath . $imageName, 60);

            Photo::create([
                'name' => "uploads/albums/{$imageName}",
                'album_id' => $id
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('albums.index');
    }

    public function deletePhoto($id)
    {
        Photo::destroy($id);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return back();
    }
}
