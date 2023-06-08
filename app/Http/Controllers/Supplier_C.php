<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Supplier;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class Supplier_C extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = DB::table('supplier')
                ->leftJoin('item', 'item.id', '=', 'supplier.id_item')
                ->select('supplier.*', 'item.name AS item_name', 'item.id AS item_id')
                ->orderBy('id', 'DESC')
                ->get()
                ;
        return view('admin/supplier/index', compact('data'));
    }

    public function index_old()
    {
       $data = DB::table('supplier')
                ->leftJoin('item', 'item.id', '=', 'supplier.id_item')
                ->select('supplier.*', 'item.name AS item_name', 'item.id AS item_id')
                ->paginate(10)
                ;
        return view('admin/supplier/index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = Item::All();
        return view('admin/supplier/create', compact('item'));
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
            'name'    =>  'required',
            'id_item' => 'required'
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'id_item' => $request->id_item,
            'address' => $request->address,
            'contact_name' => $request->contact_name,
            'telephone' => $request->telephone,
            'bank_name' => strtoupper($request->bank_name),
            'bank_account_name' => $request->bank_account_name,
            'bank_number' => $request->bank_number
         );
        supplier::create($data);

        return redirect()->route('supplier.index')->with('success', 'Data Added successfully.');
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
        $data = DB::table('supplier')->where('id', '=', $id)->first();
        $item = DB::table('item')->get();
        return view('admin/supplier/edit', compact('data', 'item'));
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
            'name'    =>  'required',
            'id_item' => 'required'
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'id_item' => $request->id_item,
            'address' => $request->address,
            'contact_name' => $request->contact_name,
            'telephone' => $request->telephone,
            'bank_name' => strtoupper($request->bank_name),
            'bank_account_name' => $request->bank_account_name,
            'bank_number' => $request->bank_number
         );

        Supplier::where('id', $id)->update($data);
        return redirect()->route('supplier.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Supplier::findOrFail($id);
        $data->delete();

        return redirect()->route('supplier.index')->with('success', 'Data is successfully deleted');
    }


    public function search_old(Request $request)
    {
      $word = $request->word;
      $data = DB::table('supplier')
        ->select('supplier.*', 'item.name AS item_name', 'item.id AS item_id')
        ->leftJoin('item', 'item.id', '=', 'supplier.id_item')
        ->where('supplier.name', 'LIKE', '%'.$word.'%' )
        ->orWhere('item.name', 'LIKE', '%'.$word.'%' )
        ->orWhere('supplier.email', 'LIKE', '%'.$word.'%' )
        ->orWhere('supplier.email', 'LIKE', '%'.$word.'%' )
        ->paginate(10);
        return view('admin/supplier/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function search(Request $request)
    {
      $word = $request->word;
      $data = DB::table('supplier')
        ->select('supplier.*', 'item.name AS item_name', 'item.id AS item_id')
        ->leftJoin('item', 'item.id', '=', 'supplier.id_item')
        ->where('supplier.name', 'LIKE', '%'.$word.'%' )
        ->orWhere('item.name', 'LIKE', '%'.$word.'%' )
        ->orWhere('supplier.email', 'LIKE', '%'.$word.'%' )
        ->orWhere('supplier.email', 'LIKE', '%'.$word.'%' )
        ->get();
        return view('admin/supplier/index', compact('data', 'word'));
    }

}
