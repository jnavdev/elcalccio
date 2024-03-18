<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\Facades\Image as ImageIntervention;
use App\Http\Requests\Backend\Product\UpdateRequest;
use App\Http\Requests\Backend\Product\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Models\ProductInventory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select(
                'products.id',
                'products.image',
                'products.title',
                'product_categories.name as product_category_name',
                'product_inventory.cost_price as cost_price',
                'product_inventory.sale_price as sale_price',
                'products.stock',
                'products.is_active'
            )
                ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
                ->join('product_inventory', function ($query) {
                    $query->on('product_inventory.product_id', '=', 'products.id')
                        ->whereRaw('product_inventory.id IN (select MAX(pi.id) from product_inventory as pi join products as p on p.id = pi.product_id group by p.id)');
                });

            return datatables()->of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->get('search')['value']) {
                        // global search
                        $query->where('products.title', 'like', "%" . $request->get('search')['value'] . "%");
                    }
                })
                ->editColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="70" height="70">';
                })
                ->editColumn('cost_price', function ($row) {
                    return '<span class="badge badge-pill badge-primary">$' . chileanPeso($row->productInventory->cost_price) . '</span>';
                })
                ->editColumn('sale_price', function ($row) {
                    return '<span class="badge badge-pill badge-primary">$' . chileanPeso($row->productInventory->sale_price) . '</span>';
                })
                ->editColumn('is_active', function ($row) {
                    $span = ($row->is_active) ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';

                    return $span;
                })
                ->addColumn('action', function ($row) {
                    $delete = [
                        'buttonClass' => ($row->is_active) ? 'btn-danger' : 'btn-success',
                        'buttonIcon' => ($row->is_active) ? 'fas fa-close' : 'fas fa-check',
                        'buttonText' => ($row->is_active) ? 'Desactivar' : 'Reactivar'
                    ];

                    $buttons = "<button class='btn btn-sm btn-info btn-detail' data-id='{$row->id}' title='Detalle'><i class='fas fa-eye'></i></button> ";
                    $buttons .= "<a class='btn btn-sm btn-primary' title='Editar' href='" . route('products.edit', $row->id) . "'><i class='fas fa-pencil'></i></a> ";
                    $buttons .= "<button class='btn btn-sm " . $delete['buttonClass'] . " btn-delete' data-id='{$row->id}' title='Cambia estado'><i class='" . $delete['buttonIcon'] . "'></i> " . $delete['buttonText'] . "</button>";

                    return $buttons;
                })
                ->rawColumns(['image', 'cost_price', 'sale_price', 'is_active', 'action'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('backend.sections.products.index');
    }

    public function create()
    {
        $productCategories = ProductCategory::select('name', 'id')->get();

        return view('backend.sections.products.create', compact('productCategories'));
    }

    public function store(StoreRequest $request)
    {
        $product = Product::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'description' => $request->get('description'),
            'stock' => $request->get('stock'),
            'product_category_id' => $request->get('product_category_id')
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $thumbnailImage = ImageIntervention::make($image)->orientate();
            $thumbnailPath = public_path() . '/uploads/products/';
            $imageName = time() . $image->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath . $imageName, 60);

            $product->update([
                'image' => "uploads/products/{$imageName}"
            ]);
        }

        ProductInventory::create([
            'cost_price' => str_replace('.', '', $request->get('cost_price')),
            'sale_price' => str_replace('.', '', $request->get('sale_price')),
            'product_id' => $product->id
        ]);

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('products.index');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $productCategories = ProductCategory::select('name', 'id')->get();

        return view('backend.sections.products.edit', compact('product', 'productCategories'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $product = Product::with('productInventory')->find($id);
        $product->update([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'description' => $request->get('description'),
            'stock' => $request->get('stock'),
            'product_category_id' => $request->get('product_category_id')
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $thumbnailImage = ImageIntervention::make($image)->orientate();
            $thumbnailPath = public_path() . '/uploads/products/';
            $imageName = time() . $image->getClientOriginalName();
            $thumbnailImage->save($thumbnailPath . $imageName, 60);

            $product->update([
                'image' => "uploads/products/{$imageName}"
            ]);
        }

        $costPrice = str_replace('.', '', $request->get('cost_price'));
        $salePrice = str_replace('.', '', $request->get('sale_price'));

        if ($product->productInventory->cost_price != $costPrice || $product->productInventory->sale_price != $salePrice) {
            ProductInventory::create([
                'cost_price' => $costPrice,
                'sale_price' => $salePrice,
                'product_id' => $product->id
            ]);
        }

        flasher(Lang::get('messages.crud.updated'), 'success');
        return to_route('products.index');
    }

    public function show($id)
    {
        $queryProduct = Product::with('productCategory', 'productInventory')->find($id);

        $product = [
            'image' => asset($queryProduct->image),
            'title' => $queryProduct->title,
            'description' => $queryProduct->description,
            'stock' => $queryProduct->stock,
            'category' => $queryProduct->productCategory->name,
            'cost_price' => '$' . chileanPeso($queryProduct->productInventory->cost_price),
            'sale_price' => '$' . chileanPeso($queryProduct->productInventory->sale_price)
        ];

        return $product;
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->update([
            'is_active' => ($product->is_active) ? false : true
        ]);

        flasher(Lang::get('messages.crud.deleted'), 'success');
        return to_route('products.index');
    }
}
