<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ProductCategory\UpdateRequest;
use App\Http\Requests\Backend\ProductCategory\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::select('id', 'name');

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('name', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->addColumn('action', function ($row) {
                    $buttons = "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('product_categories.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm btn-danger btn-delete' data-id='{$row->id}' title='Eliminar'><i class='fas fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.product-categories.index');
    }

    public function create()
    {
        return view('backend.sections.product-categories.create');
    }

    public function store(StoreRequest $request)
    {
        ProductCategory::create([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name'))
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('product_categories.index');
    }

    public function edit($id)
    {
        $productCategory = ProductCategory::find($id);

        return view('backend.sections.product-categories.edit', compact('productCategory'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $productCategory = ProductCategory::find($id);
        $productCategory->update([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name'))
        ]);

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('product_categories.index');
    }

    public function destroy($id)
    {
        $productCategory = ProductCategory::find($id);
        $productCategory->delete();

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('product_categories.index');
    }
}
