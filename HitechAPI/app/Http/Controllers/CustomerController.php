<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\customers;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customer = customers::orderBy('customers.CustomerCode')->paginate(15);
        if ($customer->count() > 0)
        {
            return response()->json($customer, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetCustomerByID($CustomerID)
    {
        $customer = customers::where('CustomerID', $CustomerID)->get();
        if ($customer->count() > 0)
        {
            return response()->json($customer, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetCustomerByCode($CustomerCode)
    {
        $customer = customers::where('CustomerCode', $CustomerCode)->get();
        if ($customer->count() > 0)
        {
            return response()->json($customer, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetCustomerByCompanyName($CompanyName)
    {
        $CompanyName = '%' . $CompanyName . '%';
        $customer = customers::where('CompanyName','like', $CompanyName)->get();
        if ($customer->count() > 0)
        {
            return response()->json($customer, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetCustomerByContactName($ContactName)
    {
        $ContactName = '%' . $ContactName . '%';
        $customer = customers::where('ContactName','like', $ContactName)->get();
        if ($customer->count() > 0)
        {
            return response()->json($customer, 200);
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
        $faker = \Faker\Factory::create();
        DB::beginTransaction();
        try {
            $customer = new customers;
            while (true)
            {
                $temp = $faker->regexify('HITECH[0-9]{10}');
                $_customer = customers::where('CustomerCode', $temp)->get();
                if ($_customer->count() === 0)
                {
                    $customer->fill($request->all());
                    $customer->CustomerCode = $temp;
                    $customer->save();
                    DB::commit();
                    return response()->json($customer, 201);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => 'Resource not insert', 404]);
        }
        
    }

    public function update(Request $request, $customerID)
    {
        DB::beginTransaction();
        try {
            $customer = customers::findOrFail($customerID);
            if ($customer->count() > 0)
            {
                $input = $request->all();
                $customer->fill($input)->save();
                DB::commit();
                return response()->json($customer, 200);
            }
            else
            {
                return response()->json([
                    'data' => 'Resource not found'
                ], 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => 'Resource not update', 404]);
        }
    }

    public function delete($customerID)
    {
        DB::beginTransaction();
        try {
            $customer = customers::find($customerID);
            if ($customer->count() > 0)
            {
                $customer->delete();
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
            return response()->json(['data' => 'Resource not delete', 404]);
        }
    }
}
