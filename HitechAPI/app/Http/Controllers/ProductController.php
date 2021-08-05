<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\products;
use App\properties;
use App\customers;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $product = products::with('properties')
                        ->orderBy('products.CustomerID')->orderBy('products.ProductID')->paginate(15);
        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }
 
    public function GetProductByID($ProductID)
    {
        $product = products::with('properties')->where('ProductID', $ProductID)->get();
        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetProductByCode($ProductCode)
    {
        $product = products::with('properties')->where('ProductCode', $ProductCode)->get();
        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetProductByCustomerId($CustomerId,Request $request)
    {
        $product = products::with('properties')->where('CustomerId', $CustomerId)->orderBy('ProductID')->paginate(15);

        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetProductByCustomerCode($CustomerCode,Request $request)
    {
        $product = products::with(['properties','customers'])->whereHas('customers', function ($query) use ($CustomerCode) {
                                                                    $query->where('CustomerCode', '=', $CustomerCode);
                                                                })
                            ->orderBy('ProductID')->paginate(15);
        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetProductByName($ProductName,Request $request)
    {
        $product = products::with('properties')->where('ProductName', $ProductName)->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetProductByContractNumber($ContractNumber,Request $request)
    {
        $product = products::with('properties')->where('ContractNumber', $ContractNumber)->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetProductsByPropertiesName($PropertiesName,Request $request)
    {
        $product = products::with('properties')->whereHas('properties', function ($query) use ($PropertiesName) {
                                                        $query->where('PropertiesName', '=', $PropertiesName);
                                                    })
                                ->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

        if ($product->count() > 0)
        {
            return response()->json($product, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $product = products::with('properties')->create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $ProductID)
    {
        $product = products::with('properties')->where('ProductID', $ProductID)->get();
        if ($product->count() > 0)
        {
            $product->update($request->all());
            return response()->json($null, 204);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function delete($ProductID)
    {
        $product = products::where('ProductID', $ProductID)->get();
        if ($product->count() > 0)
        {
            $product->delete();
            return response()->json($null, 204);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
        
    }
}
