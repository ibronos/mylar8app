<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;
use Redirect;

class Report_C extends Controller
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
        // $data = Order::latest()->paginate(10);
        // return view( 'admin/report/index', compact('data') )
        // ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $data = DB::table('style')
       ->leftJoin('order_list_style', 'order_list_style.id_style', '=', 'style.id')
       ->where('order_list_style.id', '=', $id)
       ->first();

       $data_image = DB::table('style')
       ->leftJoin('order_list_style', 'order_list_style.id_style', '=', 'style.id')
       ->leftJoin('style_image', 'style_image.id_style', '=', 'style.id')
       ->where('order_list_style.id', '=', $id)
       ->where('style_image.image', '!=', 'noimage.png')
       ->get();

       $data_size_run = DB::table('style_size_run')
       ->select('style_size_run.*', 'report.*')
       ->leftJoin('report','report.id_style_sizerun','=', 'style_size_run.id' )
       ->where('style_size_run.id_order_list_style', '=', $id)
       ->orderBy('size', 'asc')
       ->get();

       $total_quantity = DB::table('style_size_run')
       ->leftJoin('order_list_style', 'order_list_style.id', '=', 'style_size_run.id_order_list_style')
       ->where('order_list_style.id', '=', $id)
       ->first( DB::raw('SUM(style_size_run.quantity) AS total') );

       $component = DB::table('style_component')
       ->select('style_component.*', 'style_component.id as component_id', 'order_list_style.*')
       ->leftJoin('order_list_style', 'order_list_style.id_style', '=', 'style_component.id_style')
       ->where('order_list_style.id', '=', $id)
       ->get();

       foreach ($component as $key => $value) {
          $material = DB::table('style_component_material')
          ->select('name', 'calculation', 'usage')
          ->where('id_style_component', '=', $value->component_id)
          ->get();

          $total_usage = 0;
          foreach ($material as $k_mat => $v_mat) {
            $total_usage = $total_usage + $v_mat->usage;
          }

          $value->material = $material;
          $value->total_usage = $total_usage;
       }

        $notes = DB::table('report_notes')
         ->select('report_notes.*', 'report_notes.id as note_id')
         ->leftJoin('order_list_style', 'order_list_style.id', '=', 'report_notes.id_order_list_style')
         ->where('order_list_style.id', '=', $id)
         ->first();
         
       return view( 'admin/report/show', compact('data', 'data_size_run', 'total_quantity', 'component', 'notes', 'data_image') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
      // $word = $request->word;
      // $data = DB::table('order')
      //   ->where('code', 'LIKE', '%'.$word.'%' )
      //   ->paginate(10);
      //   return view('admin/report/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }



    /**
     * ==================================
     *  STYLE FUNCTION
     * ==================================
     */
    public function list_style($id)
    {
       // $data = DB::table('order')->where('id', '=', $id)->first();
       // $data_style = DB::table('order_style') 
       // ->where('id_order', '=', $id)    
       // ->paginate(10);


       // foreach ($data_style as $key => $value) {
       //    $img = DB::table('order_image') 
       //          ->where('id_order_style', '=', $value->id)    
       //          ->get();
       //    $value->image = $img;
       // }
       // return view( 'admin/report/list_style', compact('data', 'data_style') )->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function show_style($id)
    {
       // $data = DB::table('order_style')->where('id', '=', $id)->first();
       // $data_size_run = DB::table('order_size_run')
       // ->select('order_size_run.*', 'report.*')
       // ->leftJoin('report','report.id_order_sizerun','=', 'order_size_run.id' )
       // ->where('id_order_style', '=', $id)
       // ->orderBy('size', 'asc')
       // ->get();

       // $total_quantity = DB::table('order_size_run')
       // ->where('id_order_style', '=', $id)
       // ->first( DB::raw('SUM(order_size_run.quantity) AS total') );

       // $component = DB::table('order_component')
       // ->where('id_order_style', '=', $id)
       // ->get();
       // return view( 'admin/report/show_style', compact('data', 'data_size_run', 'total_quantity', 'component') );
    }

    public function update_process(Request $request, $id) {
        // var_dump($request->all()); exit;
        $request->validate([
            'id_style_sizerun' => 'required',
            'cutting' => 'required|numeric|min:0|max:'.$request->quantity,
            'stitching' => 'required|numeric|min:0|max:'.$request->quantity,
            'buffing' => 'required|numeric|min:0|max:'.$request->quantity,
            'lasting' => 'required|numeric|min:0|max:'.$request->quantity,
            'finishing' => 'required|numeric|min:0|max:'.$request->quantity,
        ]);

        DB::table('report')
           ->where('id_style_sizerun', $request->id_style_sizerun )
           ->update(
                [
                    'cutting' => $request->cutting,
                    'stitching' => $request->stitching,
                    'buffing' => $request->buffing,
                    'lasting' => $request->lasting,
                    'finishing' => $request->finishing,
                ]
        );
        return Redirect::back()->with('success', 'Data Updated Successfully.');
    }


    public function update_notes(Request $request, $id) {
        // var_dump($request->all()); exit;
        DB::table('report_notes')
           ->where('id', $id )
           ->update(
                [
                    'note' => $request->note,
                ]
        );
        return Redirect::back()->with('success', 'Data Updated Successfully.');
    }


}
