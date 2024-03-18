<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\Backend\Video\StoreRequest;
use App\Http\Requests\Backend\Video\UpdateRequest;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Video::select('id', 'order', 'title', 'date', 'url', 'is_active', 'for_school');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('title', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->editColumn('for_school', function ($row) {
                    return ($row->for_school) ? 'Si' : 'No';
                })
                ->addColumn('thumbnail', function ($row) {
                    return "<img class='img-responsive' style='width: 1oopx; height: 70px;' alt='" . $row->title . "' src='" . $this->getYoutubeThumbnail($row->url) . "'>";
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' href='" . route('videos.edit', $row->id) . "' title='Editar'><i class='fas fa-pencil'></i></a> ";

                    $deleteButton = "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Desactivar'><i class='fas fa-close'></i> Desactivar</button>";

                    if (!$row->is_active) {
                        $deleteButton = "<button class='btn btn-sm btn-success btn-delete' data-id='{$row->id}' title='Activar'><i class='fas fa-check'></i> Activar</button>";
                    }

                    $buttons .= $deleteButton;

                    return $buttons;
                })
                ->rawColumns(['thumbnail', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.videos.index');
    }

    public function create()
    {
        $lastVideo = Video::where('is_active', true)->orderBy('order', 'DESC')->first();
        $order = ($lastVideo) ? $lastVideo->order + 1 : 0;

        return view('backend.sections.videos.create', compact('order'));
    }

    public function store(StoreRequest $request)
    {
        Video::create([
            'title' => $request->get('title'),
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d'),
            'url' => $request->get('url'),
            'is_active' => $request->get('is_active'),
            'order' => $request->get('order'),
            'for_school' => $request->get('for_school')
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('videos.index');
    }

    public function show($id)
    {
        $video = Video::find($id);

        return [
            'title' => $video->title,
            'date' => $video->date->format('d-m-Y'),
            'for_school' => ($video->for_school) ? 'Si' : 'No',
            'order' => $video->order,
            'iframe' => '<iframe src="https://www.youtube.com/embed/' . getVideoIdYoutube($video->url) . '" style="top: 0; left: 0; width: 100%; height: 400px;" allowfullscreen></iframe>'
        ];
    }

    public function edit($id)
    {
        $video = Video::find($id);

        return view('backend.sections.videos.edit', compact('video'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $video = Video::find($id);

        $video->update([
            'title' => $request->get('title'),
            'date' => Carbon::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d'),
            'url' => $request->get('url'),
            'is_active' => $request->get('is_active'),
            'order' => $request->get('order'),
            'for_school' => $request->get('for_school')
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('videos.index');
    }

    public function destroy($id)
    {
        $video = Video::find($id);

        if ($video->is_active) {
            $video->update([
                'is_active' => false
            ]);
        } else {
            $video->update([
                'is_active' => true
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('videos.index');
    }

    private function getYoutubeThumbnail($url)
    {
        $videoId = explode("?v=", $url);
        $videoId = $videoId[1];

        return "https://img.youtube.com/vi/" . $videoId . "/sddefault.jpg";
    }
}
