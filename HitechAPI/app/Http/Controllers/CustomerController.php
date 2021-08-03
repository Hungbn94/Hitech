<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customers;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->request->get('page') <> '')
        {
            $page = $request->get('page');
            $customer = customers::orderBy('customers.CustomerCode')->skip(($page-1)*15)->take(15)->get();
        }
        else
        {
            $customer = customers::orderBy('customers.CustomerCode')->take(15)->get();
        }
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
        $customer = customers::create($request->all());
        return response()->json($customer, 201);
    }

    public function update(Request $request, $customerID)
    {
        $customer = customers::where('CustomerID', $customerID)->get();
        if ($customer->count() > 0)
        {
            $customer->update($request->all());
            return response()->json($null, 204);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function delete($customerID)
    {
        $customer = customers::where('CustomerID', $customerID)->get();
        if ($customer->count() > 0)
        {
            $customer->delete();
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
