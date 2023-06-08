<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class Inventory_C extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Inventory::latest()->where('purchase_arrival_status', '!=', 'n')->get();
        return view( 'admin/inventory/index', compact('data') );
    }

    public function index_old()
    {
        $data = Inventory::latest()->where('purchase_arrival_status', '!=', 'n')->paginate(10);
        return view( 'admin/inventory/index', compact('data') )
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/inventory/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'    =>  'required',
            'material_name'    =>  'required',
            'code'    =>  'required',
            'quantity'    =>  'required',
            'unit'    =>  'required',
            'color'    =>  'required'
        ]);

        $data = array(
            'type'    =>  $request->type,
            'material_name' => $request->material_name,
            'code' =>  $request->code,
            'quantity' =>  $request->quantity,
            'specs' =>  $request->specs,
            'unit' =>  $request->unit,
            'color' =>  $request->color,
            'awb' =>  $request->awb,
            'origin' =>  $request->origin
        );

        Inventory::create($data);

        return redirect()->route('inventory.index')->with('success', 'Data Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Inventory::where('id', '=', $id)->first();
        return view( 'admin/inventory/edit', compact('data') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type'    =>  'required',
            'material_name'    =>  'required',
            'code'    =>  'required',
            'quantity'    =>  'required',
            'unit'    =>  'required',
            'color'    =>  'required'
        ]);

        // var_dump($request); exit;

        $data = array(
            'type'    =>  $request->type,
            'material_name' => $request->material_name,
            'code' =>  $request->code,
            'quantity' =>  $request->quantity,
            'specs' =>  $request->specs,
            'unit' =>  $request->unit,
            'color' =>  $request->color,
            'awb' =>  $request->awb,
            'origin' =>  $request->origin
        );

        Inventory::where('id', $id)->update($data);;

        return redirect()->route('inventory.index')->with('success', 'Data Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Inventory::findOrFail($id);
        $data->delete();

        return redirect()->route('inventory.index')->with('success', 'Data is successfully deleted');
    }

    public function search(Request $request)
    {
      $word = $request->word;
      $data = DB::table('inventory')
        ->where('material_name', 'LIKE', '%'.$word.'%' )
        ->orWhere('type', 'LIKE', '%'.$word.'%' )
        ->orWhere('code', 'LIKE', '%'.$word.'%' )
        ->orWhere('quantity', 'LIKE', '%'.$word.'%' )
        ->orWhere('specs', 'LIKE', '%'.$word.'%' )
        ->orWhere('unit', 'LIKE', '%'.$word.'%' )
        ->orWhere('color', 'LIKE', '%'.$word.'%' )
        ->orWhere('awb', 'LIKE', '%'.$word.'%' )
        ->orWhere('origin', 'LIKE', '%'.$word.'%' )
        ->get();
        return view('admin/inventory/index', compact('data', 'word'));
    }

    public function search_old(Request $request)
    {
      $word = $request->word;
      $data = DB::table('inventory')
        ->where('material_name', 'LIKE', '%'.$word.'%' )
        ->orWhere('type', 'LIKE', '%'.$word.'%' )
        ->orWhere('code', 'LIKE', '%'.$word.'%' )
        ->orWhere('quantity', 'LIKE', '%'.$word.'%' )
        ->orWhere('specs', 'LIKE', '%'.$word.'%' )
        ->orWhere('unit', 'LIKE', '%'.$word.'%' )
        ->orWhere('color', 'LIKE', '%'.$word.'%' )
        ->orWhere('awb', 'LIKE', '%'.$word.'%' )
        ->orWhere('origin', 'LIKE', '%'.$word.'%' )
        ->paginate(10);
        return view('admin/inventory/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

}
