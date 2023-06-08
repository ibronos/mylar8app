<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class Item_C extends Controller
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
        $data = Item::latest()->paginate(10);
        return view('admin/item/index', compact('data'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/item/create');
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
        ]);

        $data = array(
            'name' => $request->name
        );

        Item::create($data);

        return redirect()->route('item.index')->with('success', 'Data Added successfully.');
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
       $data = DB::table('item')
        ->where('id', '=', $id)
        ->first()
        ;
        return view('admin/item/edit', compact('data'));
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
            'name'    =>  'required'
        ]);

        $data = array(
            'name' => $request->name
        );
        Item::where('id', $id)->update($data);
        return redirect()->route('item.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Item::findOrFail($id);
        $data->delete();

        return redirect()->route('item.index')->with('success', 'Data is successfully deleted');
    }

    public function search(Request $request)
    {
      $word = $request->word;
      $data = DB::table('item')
        ->where('item.name', 'LIKE', '%'.$word.'%' )
        ->paginate(10);
        return view('admin/item/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
