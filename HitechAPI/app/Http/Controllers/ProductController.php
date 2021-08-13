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
        $p = products::query()->with(['properties','customers']);
        if ($request->has('ProductCode'))
        {
            $p->where('ProductCode',$request->get('ProductCode'));
        }

        if ($request->has('CustomerID'))
        {
            $p->where('CustomerID',$request->get('CustomerID'));
        }

        if ($request->has('ContractNumber'))
        {
            $p->where('ContractNumber',$request->get('ContractNumber'));
        }

        if ($request->has('ProductName'))
        {
            $p->where('ProductName','like','%'.$request->get('ProductName').'%');
        }

        if ($request->has('ExternalForm'))
        {
            $p->where('ExternalForm',$request->get('ExternalForm'));
        }

        if ($request->has('PropertiesName'))
        {
            $p->whereHas('properties', function ($query) use ($request) {
                $query->where('PropertiesName', 'like', '%'.$request->get('PropertiesName').'%');
            });
        }

        $product = $p->orderBy('products.Active','desc')->orderBy('products.CustomerID')->orderBy('products.ProductID')->paginate(15);
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
        $product = products::with(['properties','customers'])->where('ProductID', $ProductID)->get();
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
        $product = products::with(['properties','customers'])->where('ProductCode', $ProductCode)->get();
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
        $product = products::with(['properties','customers'])->where('CustomerId', $CustomerId)->orderBy('products.Active','desc')->orderBy('ProductID')->paginate(15);

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
                                                                ->orderBy('products.Active','desc')->orderBy('ProductID')->paginate(15);
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
        $product = products::with(['properties','customers'])->where('ProductName', $ProductName)->orderBy('products.Active','desc')->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

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
        $product = products::with(['properties','customers'])->where('ContractNumber', $ContractNumber)->orderBy('products.Active','desc')->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

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
        $product = products::with(['properties','customers'])->whereHas('properties', function ($query) use ($PropertiesName) {
                                                        $query->where('PropertiesName', 'like', '%'.$PropertiesName.'%');
                                                    })
                                                    ->orderBy('products.Active','desc')->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

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
        DB::beginTransaction();
        try {
            $product = products::create($request->all());
            foreach ($request['properties'] as $property)
            {
                $temp = new properties;
                $temp->fill($property);
                $temp->ProductID = $product->ProductID;
                $temp->save();
            }
            DB::commit();
            return response()->json($product, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => 'Resource not insert'], 404);
        }
    }

    public function update(Request $request, $ProductID)
    {
        DB::beginTransaction();
        try {
            $product = products::findOrFail($ProductID);
            if ($product->count() > 0)
            {
                $input = $request->all();
                $product->fill($input)->save();
                foreach ($request['properties'] as $property)
                {
                    $temp = properties::findOrFail($property['PropertiesID']);
                    $temp->fill($property);
                    $temp->ProductID = $product->ProductID;
                    $temp->save();
                }
                DB::commit();
                $product = products::with('properties')->findOrFail($ProductID);
                return response()->json($product, 200);
            }
            else
            {
                return response()->json([
                    'data' => 'Resource not found'
                ], 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => 'Resource not update'], 404);
        }
    }

    public function delete($ProductID)
    {
        DB::beginTransaction();
        try {
            $product = products::with('properties')->findOrFail($ProductID);
            if ($product->count() > 0)
            {
                products::destroy($ProductID);
                DB::commit();
                return response()->json('Delete succcess',204);
            }
            else
            {
                return response()->json([
                    'data' => 'Resource not found'
                ], 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => 'Resource not delete'], 404);
        }
    }
}
