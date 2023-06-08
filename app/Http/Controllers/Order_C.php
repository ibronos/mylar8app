<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class Order_C extends Controller
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
        $data = Order::latest()->paginate(10);
        foreach ($data as $key ) {
            $style_exist = $this->check_style($key->id);
            $key->style_exist = $style_exist;
        }
        
        return view( 'admin/order/index', compact('data') )
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    function check_style($id) {
        $style_exist = true;
        $data_style = DB::table('order')
        ->select('style.id as id_style')
        ->leftJoin('order_list_style', 'order.id', '=', 'order_list_style.id_order')
        ->leftJoin('style', 'style.id', '=', 'order_list_style.id_style')
        ->where('order.id', '=', $id)
        ->where('id_style', '!=', null)
        ->get()
        ;
        if ( count($data_style) == 0 ) {
            $style_exist = false;
        }
        return $style_exist;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $style = DB::table('style')->orderBy('id', 'DESC')->get();
        return view( 'admin/order/create', compact('style'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // var_dump($request->all()); exit;
        $request->validate([
            'code'    =>  'required',
        ]);

        $data_order = array(
            'code' => $request->code,
         );

        $order_id = DB::table('order')->insertGetId($data_order);
        if ( isset($request->style) && !empty($request->style) ) {
            foreach ($request->style as $key => $value) {
                $id_ols = DB::table('order_list_style')->insertGetId(
                    [
                        'id_order' => $order_id,
                        'id_style' => $value
                    ]
                );
                DB::table('report_notes')->insert(
                    [
                        'id_order_list_style' => $id_ols,
                        'note' => null
                    ]
                );
            }
        }

        return redirect()->route('order.index')->with('success', 'Data Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('order')
        ->where('id', '=', $id)
        ->first()
        ;

       $data_style = DB::table('order')
        ->select('order.id as id_order', 'style.id as id_style', 'order_list_style.id as id_ols', 'order.*', 'style.*')
        ->leftJoin('order_list_style', 'order.id', '=', 'order_list_style.id_order')
        ->leftJoin('style', 'style.id', '=', 'order_list_style.id_style')
        ->where('order.id', '=', $id)
        ->get()
        ;

        foreach ($data_style as $key => $value) {
            $id_ols = $value->id_ols;
            $sizerun = DB::table('style_size_run')
            ->select('style_size_run.id as id_sizerun', 'report.id as id_report', 'style_size_run.*', 'report.*')
            ->leftJoin('report', 'report.id_style_sizerun', '=', 'style_size_run.id')
            ->where('style_size_run.id_order_list_style', '=', $id_ols)
            ->get()
            ;
            $value->sizerun = $sizerun;
        }
        
        return view('admin/order/show', compact('data', 'data_style') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('order')
        ->where('id', '=', $id)
        ->first()
        ;
        $style = DB::table('style')->orderBy('name', 'asc')->get();
        $order_list_style = DB::table('order_list_style')->where('id_order', '=', $id)->get();
        $array_ols = array();
        foreach ($order_list_style as $key => $value) {
            $array_ols[] = $value->id_style;
        }
        foreach ($style as $key => $value) {         
            $checked = in_array($value->id, $array_ols) ? 'y' : 'n';
            $value->checked = $checked;
        }

        return view('admin/order/edit', compact('data', 'style'));
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
            'code'    =>  'required'
        ]);

        $data = array(
            'code' => $request->code
        );
        Order::where('id', $id)->update($data);

        $obj_id_style = DB::table('order_list_style')->select('id_style')->where('id_order', '=', $id)->get();
        $arr_id_style = array();
        foreach ($obj_id_style as $key => $value) {
          $arr_id_style[] = $value->id_style;
        }

        if ( isset($request->style) && !empty($request->style) ) {

            foreach ($request->style as $key => $value) {
                if ( in_array($value, $arr_id_style) == false ) {
                    DB::table('order_list_style')->insert(
                        [
                            'id_order' => $id,
                            'id_style' => $value
                        ]
                    );
                }
            }

            foreach ($arr_id_style as $key => $value) {
                if ( in_array($value, $request->style) == false ) {               
                    DB::table('order_list_style')
                     ->where( 'id_order', '=', $id  )
                     ->where( 'id_style', '=', $value )
                     ->delete();
                }
            }
        }

        return redirect()->route('order.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Order::findOrFail($id);
        $data->delete();

        return redirect()->route('order.index')->with('success', 'Data is successfully deleted');
    }

    public function search(Request $request)
    {
      $word = $request->word;
      $data = DB::table('order')
        ->where('code', 'LIKE', '%'.$word.'%' )
        ->paginate(10);
        return view('admin/order/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }


    
    public function edit_style($id)
    {
       $data = DB::table('order_list_style')
        ->select('order.id as id_order', 'style.id as id_style', 'order_list_style.id as id_ols', 'order.*', 'style.*')
        ->leftJoin('order', 'order.id', '=', 'order_list_style.id_order')
        ->leftJoin('style', 'style.id', '=', 'order_list_style.id_style')
        ->where('order_list_style.id', '=', $id)
        ->first()
        ;

        $data_size_run = DB::table('order_list_style')
        ->select(
            'order.id as id_order', 
            'style.id as id_style', 
            'order_list_style.id as id_ols', 
            'style_size_run.id as id_size_run',
            'order.*', 
            'style.*', 
            'style_size_run.*'
        )
        ->leftJoin('order', 'order.id', '=', 'order_list_style.id_order')
        ->leftJoin('style', 'style.id', '=', 'order_list_style.id_style')
        ->leftJoin('style_size_run', 'style_size_run.id_order_list_style', '=', 'order_list_style.id')
        ->where('style_size_run.id_order_list_style', '=', $id)
        ->get()
        ;

       return view( 'admin/order/edit_style', compact('data', 'data_size_run') );
    }



    public function update_style(Request $request, $id)
    {
        // var_dump($request->all()); exit;
        if ( $request->sizequan ) { 
               foreach ($request->sizequan as $key => $value) {
                    if ( isset($value['id']) ) {
                       DB::table('style_size_run')
                       ->where('id', $value['id'] )
                       ->update(
                            [
                                'id_order_list_style' => $request->id_order_list_style ,
                                'size' => $value['size'], 
                                'quantity' => $value['quantity']
                            ]
                        );
                    }
                    else {
                        $idSizeRun = DB::table('style_size_run')->insertGetId(
                            [
                                'id_order_list_style' => $request->id_order_list_style ,
                                'size' => $value['size'], 
                                'quantity' => $value['quantity']
                            ]
                        );
                        DB::table('report')->insert(
                            [
                                'id_style_sizerun' => $idSizeRun
                            ]
                        );
                    }
                }
        }
        if ( $request->deleted_sizequan  ) {
           foreach ($request->deleted_sizequan as $key => $value) {
               DB::table('style_size_run')->where('id', '=',$value)->delete();
               DB::table('report')->where('id_style_sizerun', '=',$value)->delete();
           }
        }
        return redirect()->route('order.show', $request->id_order)->with('success', 'Data is successfully updated');
    }


}
