<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\products;
use App\properties;
use App\customers;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $p = products::query()->with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode');
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
        $product = products::with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode')
                            ->where('ProductID', $ProductID)->get();
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
        $product = products::with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode')
                            ->where('ProductCode', $ProductCode)->get();
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
        $product = products::with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode')
                            ->where('CustomerId', $CustomerId)->orderBy('products.Active','desc')->orderBy('ProductID')->paginate(15);

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
        $product = products::with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode')
                            ->where('customers.CustomerCode', $CustomerCode)->orderBy('products.Active','desc')->orderBy('ProductID')->paginate(15);
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
        $product = products::with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode')
                            ->where('ProductName', $ProductName)->orderBy('products.Active','desc')->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

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
        $product = products::with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode')
                            ->where('ContractNumber', $ContractNumber)->orderBy('products.Active','desc')->orderBy('CustomerID')->orderBy('ProductID')->paginate(15);

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
        $product = products::with(['properties','customers'])->join('customers','products.CustomerID','customers.CustomerID')->select('products.*', 'customers.CustomerCode as CustomerCode')
                            ->whereHas('properties', function ($query) use ($PropertiesName) {
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
            $customerID = customers::where('CustomerCode', $request->CustomerCode)->value('CustomerID');
            $product = new products;
            $input = $request->all();
            $product->fill($input);
            $product->CustomerID = $customerID;
            $product->save();
            foreach ($request['properties'] as $property)
            {
                $temp = new properties;
                $temp->fill($property);
                $temp->ProductID = $product->ProductID;
                $temp->save();
            }
            DB::commit();
            $product = products::with(['properties','customers'])->find($product->ProductID);
            return response()->json($product, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th, 404);
        }
    }

    public function update(Request $request, $ProductID)
    {
        DB::beginTransaction();
        try {
            $product = products::with(['properties','customers'])->find($ProductID);
            if ($product->count() > 0)
            {
                $customerID = customers::where('CustomerCode', $request->CustomerCode)->value('CustomerID');
                if (is_null($customerID))
                {
                    return response()->json([
                        'data' => 'CustomerCode not found'
                    ], 404);
                }
                $input = $request->all();
                $product->fill($input);
                $product->CustomerID = $customerID;
                $product->save();

                foreach ($request['properties'] as $property)
                {
                    $temp = properties::find($property['PropertiesID']);
                    if (is_null($temp))
                    {
                        $temp = new properties;
                    }
                    $temp->fill($property);
                    $temp->ProductID = $product->ProductID;
                    $temp->save();
                }
                DB::commit();
                $product = products::with(['properties','customers'])->find($ProductID);
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
            return response()->json($th, 404);
        }
    }

    public function delete($ProductID)
    {
        DB::beginTransaction();
        try {
            $product = products::with('properties')->find($ProductID);
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
            return response()->json($th, 404);
        }
    }
}
