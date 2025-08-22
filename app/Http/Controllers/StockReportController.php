<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;

use App\Models\ProductSerial;
use Illuminate\Support\Facades\Auth;

class StockReportController extends Controller
{
    public function index(){

        $stores = Store::where('subscriber_id', Auth::user()->subscriber_id)->get();
        return view('report/stock-report', ['stores' => $stores]);
    }

    public function inventoryStockData(Request $request){

        $data = Product::join('inventories', 'products.id', 'inventories.productId')
                ->where('products.subscriber_id', Auth::user()->subscriber_id)
                ->get();

        return response()->json([
            'data' => $data,
            'message' => 'Success'
        ]);
    }

    public function getSerial($id){

        $inventory = Inventory::find($id);

        $serial = ProductSerial::join('products', 'products.id', 'product_serials.productId')->where([
            ['product_serials.productId', $inventory->productId],
            ['product_serials.variantId', $inventory->variant_id],
            ['product_serials.storeId', 0],
            ['product_serials.saleId', 0],
            ['product_serials.subscriber_id', Auth::user()->subscriber_id],
        ])
        ->select('product_serials.productName','products.type', 'product_serials.variantName', 'product_serials.serialNumber')->get();

        return response()->json([
            'data' => $serial,
            'message' => 'Success'
        ]);
    }
}
