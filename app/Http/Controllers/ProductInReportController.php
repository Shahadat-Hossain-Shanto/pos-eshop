<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

use App\Models\ProductInHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
// use DB;

class ProductInReportController extends Controller
{
    public function index()
    {

        $stores = Store::where('subscriber_id', Auth::user()->subscriber_id)->get();
        return view('report/product-in-report', ['stores' => $stores]);
    }

    public function onLoad(Request $request)
    {

        $authId = Auth::user()->subscriber_id;

        $data = DB::table("product_in_histories")
            ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
            // ->whereBetween('created_at', [$from, $to])
            ->where('subscriber_id', $authId)
            ->groupBy("product_name", "store_name", "product", "store", "variant_name")
            ->orderBy("store_name", "desc")
            ->orderBy("product_name", "desc")
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'No data!',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => $data
            ]);
        }
    }

    public function reports(Request $request)
    {

        // Log::info($request->startdate);
        // Log::info($request->enddate);
        // Log::info($request->store);

        $authId = Auth::user()->subscriber_id;
        $from = date($request->startdate);
        $to = date($request->enddate);

        if ($request->filled('startdate') && $request->filled('enddate') && ($request->input('store') == 'all_store')) {

            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                // ->whereBetween('created_at', [$from, $to])
                ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->where('subscriber_id', $authId)
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('startdate') && $request->filled('enddate') && ($request->input('store') == 'warehouse')) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->where([
                    ['subscriber_id', $authId],
                    ['store', '=', 0],
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->input('startdate') == NULL && $request->input('enddate') == NULL && ($request->input('store') == 'all_store')) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                // ->whereBetween('created_at', [$from, $to])
                ->where('subscriber_id', $authId)
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->input('startdate') == NULL && $request->input('enddate') == NULL && ($request->input('store') == 'warehouse')) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                // ->whereBetween('created_at', [$from, $to])
                ->where([
                    ['subscriber_id', $authId],
                    ['store', '=', 0],
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('startdate') && ($request->input('store') == 'warehouse') && ($request->input('enddate') == NULL)) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereDate('created_at', '=', $from)
                ->where([
                    ['subscriber_id', $authId],
                    ['store', '=', 0],
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('enddate') && ($request->input('store') == 'warehouse') && ($request->input('startdate') == NULL)) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereDate('created_at', '=', $to)
                ->where([
                    ['subscriber_id', $authId],
                    ['store', '=', 0],
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('startdate') && ($request->input('store') == 'all_store') && ($request->input('enddate') == NULL)) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereDate('created_at', '=', $from)
                ->where('subscriber_id',  $authId)
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('enddate') && ($request->input('store') == 'all_store') && ($request->input('startdate') == NULL)) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereDate('created_at', '=', $to)
                ->where('subscriber_id',  $authId)
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('store') && $request->filled('enddate') && $request->filled('startdate')) {

            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->where([
                    ['store', '=', $request->store],
                    ['subscriber_id', '=', $authId]
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            Log::info($data);

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('store') && $request->filled('startdate') && ($request->input('enddate') == NULL)) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereDate('created_at', '=', $from)
                ->where([
                    ['store', '=', $request->store],
                    ['subscriber_id', '=', $authId]
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('store') && $request->filled('enddate') && ($request->input('startdate') == NULL)) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                ->whereDate('created_at', '=', $to)
                ->where([
                    ['store', '=', $request->store],
                    ['subscriber_id', '=', $authId]
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        } elseif ($request->filled('store') && ($request->input('enddate') == NULL) && ($request->input('startdate') == NULL)) {
            $data = DB::table("product_in_histories")
                ->select(DB::raw("SUM(quantity) as qty"), "product_name", "store_name", "product", "store", "variant_name", "variant_id")
                // ->whereDate('created_at', '=', $to)
                ->where([
                    ['store', '=', $request->store],
                    ['subscriber_id', '=', $authId]
                ])
                ->groupBy("product_name", "store_name", "product", "store", "variant_name")
                ->orderBy("store_name", "desc")
                ->orderBy("product_name", "desc")
                ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'No data!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'data' => $data
                ]);
            }
        }


        // Log::info($data);


    }
}
