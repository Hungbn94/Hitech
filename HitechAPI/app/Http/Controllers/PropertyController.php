<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\products;
use App\properties;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $property = properties::orderBy('properties.PropertiesID')->paginate(15);
        if ($property->count() > 0)
        {
            return response()->json($property, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetPropertyByID($PropertiesID)
    {
        $property = properties::where('PropertiesID', $PropertiesID)->paginate(15);
        
        if ($property->count() > 0)
        {
            return response()->json($property, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetPropertyByProductID($ProductID)
    {
        $property = properties::where('ProductID', $ProductID)->get();
        if ($property->count() > 0)
        {
            return response()->json($property, 200);
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
        $property = properties::create($request->all());
        return response()->json($property, 201);
    }

    public function update(Request $request, $customerID)
    {
        $property = properties::where('PropertiesID', $customerID)->get();
        if ($property->count() > 0)
        {
            $property->update($request->all());
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
        $property = properties::where('PropertiesID', $customerID)->get();
        if ($property->count() > 0)
        {
            $property->delete();
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
