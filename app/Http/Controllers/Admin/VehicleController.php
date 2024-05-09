<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicles = Vehicle::paginate(10);
        $search = $request->search;
        if(isset($search))
        {
            $vehicles = Vehicle::where('make', 'LIKE', '%'.$search.'%')
            ->orWhere('model', 'LIKE', '%'.$search.'%')
            ->orWhere('regnum', 'LIKE', '%'.$search.'%')
            ->paginate(10);
        }

        return view('admin.vehicles', [
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'regnum' => ['required', 'regex:/^[A-Z]{3}-\d{4}$/'],
                'make' => ['required', 'string'],
                'model' => ['required', 'string'],
                'class' => ['required', 'integer', 'min:1', 'max:5'],
                'picture' => ['required', 'file', 'mimes:png,jpeg,jpg']
            ]);

            $file = $request->file('picture');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $request->picture->move(public_path('images/vehicles'), $filename);

            $vehicle = new Vehicle();
            $vehicle->regnum = $request->regnum;
            $vehicle->make = $request->make;
            $vehicle->model = $request->model;
            $vehicle->class = $request->class;
            $vehicle->picture = $filename;
            $vehicle->save();

            return redirect()->back()->with('success', 'Vehicle added successfully');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'regnum' => ['required', 'regex:/^(Z\d{3}|(ZD|ZL|ZR)\d{2}) [A-Z]{2,3}$/'],
                'make' => ['required', 'string'],
                'model' => ['required', 'string'],
                'class' => ['required', 'integer', 'min:0', 'max:5'],
                //'picture' => ['requred', 'file', 'mimes:png,jpeg,jpg']
            ]);

            $filename = '';
            if(isset($request->picture))
            {
                $file = $request->file('picture');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $request->picture->move(public_path('vehicles'), $filename);
            }

            $vehicle = Vehicle::find($id);
            $vehicle->regnum = $request->regnum;
            $vehicle->make = $request->make;
            $vehicle->model = $request->model;
            $vehicle->class = $request->class;
            if(isset($request->picture))
            {
                $vehicle->picture = $filename;
            }
            $vehicle->save();

            return redirect()->back()->with('success', 'Vehicle updated successfully');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $vehicle = Vehicle::find($id);
            $vehicle->delete();

            return redirect()->back()->with('success', 'Vehicle deleted successfully');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
