<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class Purchasing_C extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function poToMonth($po_no) {
        $month = $po_no[4].$po_no[5];

        return intval($month);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = DB::table('purchasing')
       ->select('purchasing.*', 'order.*', 'supplier.*', 'style.*', 'inventory.*', 'order.id as order_id', 'order.code as order_code', 'supplier.id as supplier_id', 'supplier.name as supplier_name', 'style.name as style_name', 'inventory.id as inventory_id')
       ->leftJoin('order', 'purchasing.id_order', '=', 'order.id')
       ->leftJoin('supplier', 'purchasing.id_supplier', '=', 'supplier.id')
       ->leftJoin('style', 'purchasing.id_style', '=', 'style.id')
       ->leftJoin('inventory', 'purchasing.id_inventory', '=', 'inventory.id')
       ->get()
       ;

       foreach ($data as $key => $value) {
           $month = date("M", mktime(0, 0, 0, $value->month, 10));
            $value->month = $month;
       }

      return view('admin/purchasing/index', compact('data'));
    }

    public function index_old()
    {
       $data = DB::table('purchasing')
       ->select('purchasing.*', 'order.code as order_code', 'supplier.name as supplier_name')
       ->leftJoin('order', 'purchasing.id_order', '=', 'order.id')
       ->leftJoin('supplier', 'purchasing.id_supplier', '=', 'supplier.id')
       ->paginate(10)
       ;

       foreach ($data as $key => $value) {
           $month = date("M", mktime(0, 0, 0, $value->month, 10));
            $value->month = $month;
       }

       // var_dump($data); exit;
        return view('admin/purchasing/index', compact('data'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = DB::table('order')->orderBy('code', 'ASC')->get();
        $style = DB::table('style')->orderBy('name', 'ASC')->get();
        $supplier = DB::table('supplier')->orderBy('name', 'ASC')->get();

        return view('admin/purchasing/create', compact('order', 'style', 'supplier'));
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
            'date'    =>  'required',
            'po_no'    =>  'required',
            'id_order'    =>  'required',
            'id_style'    =>  'required',
            'id_supplier'    =>  'required',
            'material_name'    =>  'required',
            'description'    =>  'required',
            'payment_terms'    =>  'required',
            'material_name'    =>  'required',
        ]);

        $data_inventory = array(
            'type'    =>  $request->type,
            'material_name' => $request->material_name,
            'code' =>  $request->code,
            'quantity' =>  $request->quantity,
            'specs' =>  $request->specs,
            'unit' =>  $request->unit,
            'color' =>  $request->color,
            'awb' =>  $request->awb,
            'origin' =>  $request->origin,
            'purchase_arrival_status' => $request->arrival_status
        );
        $id_inventory = DB::table('inventory')->insertGetId($data_inventory);
       
        $purchaseMonth = $this->poToMonth($request->po_no);
        $date = date("Y-m-d", strtotime($request->date));
        DB::table('purchasing')->insert(
            [
                'date'    =>  $date,
                'month'    =>  $purchaseMonth,
                'po_no'    =>  $request->po_no,
                'id_order'    =>  $request->id_order,
                'id_style'    =>  $request->id_style,
                'id_supplier'    =>  $request->id_supplier,
                'id_inventory' => $id_inventory,
                'description'    =>  $request->description,
                'payment_terms'    =>  $request->payment_terms,
                'status'    =>  $request->status
            ]
        );
            
        return redirect()->route('purchasing.index')->with('success', 'Data Added successfully.');
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
        $order = DB::table('order')->orderBy('code', 'ASC')->get();
        $style = DB::table('style')->orderBy('name', 'ASC')->get();
        $supplier = DB::table('supplier')->orderBy('name', 'ASC')->get();

       $data = DB::table('purchasing')
       ->select('purchasing.*', 'inventory.*', 'order.id as order_id', 'supplier.id as supplier_id', 'purchasing.id as purchasing_id', 'inventory.id as inventory_id')
       ->leftJoin('order', 'purchasing.id_order', '=', 'order.id')
       ->leftJoin('supplier', 'purchasing.id_supplier', '=', 'supplier.id')
       ->leftJoin('style', 'purchasing.id_style', '=', 'style.id')
       ->leftJoin('inventory', 'purchasing.id_inventory', '=', 'inventory.id')
       ->where('purchasing.id', '=', $id)
       ->first()
       ;

       $date = date("m/d/Y", strtotime( $data->date ) );
       $data->date = $date;

       foreach ($order as $key => $value) {
           $checked = 'false';
           if ($value->id == $data->id_order ) {
               $checked = 'true';
           }
           $value->checked = $checked;
       }

      foreach ($style as $key => $value) {
           $checked = 'false';
           if ($value->id == $data->id_style ) {
               $checked = 'true';
           }
           $value->checked = $checked;
       }

      foreach ($supplier as $key => $value) {
           $checked = 'false';
           if ($value->id == $data->id_supplier ) {
               $checked = 'true';
           }
           $value->checked = $checked;
       }

       // var_dump($data);
       // exit;
       return view('admin/purchasing/edit', compact('data', 'order', 'style', 'supplier'));
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
            'date'    =>  'required',
            'po_no'    =>  'required',
            'id_order'    =>  'required',
            'id_style'    =>  'required',
            'id_supplier'    =>  'required',
            'description'    =>  'required',
            'payment_terms'    =>  'required',
            'material_name'    =>  'required',
        ]);

        $data_inventory = array(
            'type'    =>  $request->type,
            'material_name' => $request->material_name,
            'code' =>  $request->code,
            'quantity' =>  $request->quantity,
            'specs' =>  $request->specs,
            'unit' =>  $request->unit,
            'color' =>  $request->color,
            'awb' =>  $request->awb,
            'origin' =>  $request->origin,
            'purchase_arrival_status' => $request->arrival_status
        );
        DB::table('inventory')->where('id', '=', $request->id_inventory)->update($data_inventory);
       
        $purchaseMonth = $this->poToMonth($request->po_no);
        $date = date("Y-m-d", strtotime($request->date));
        DB::table('purchasing')->where('id', '=', $id)->update(
            [
                'date'    =>  $date,
                'month'    =>  $purchaseMonth,
                'po_no'    =>  $request->po_no,
                'id_order'    =>  $request->id_order,
                'id_style'    =>  $request->id_style,
                'id_supplier'    =>  $request->id_supplier,
                'id_inventory' => $request->id_inventory,
                'description'    =>  $request->description,
                'payment_terms'    =>  $request->payment_terms,
                'status'    =>  $request->status
            ]
        );
            
        return redirect()->route('purchasing.index')->with('success', 'Data Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('purchasing')->where('id', '=', $id)->delete();
       return redirect()->route('purchasing.index')->with('success', 'Data Deleted Successfully.');
    }


    public function search(Request $request)
    {
      $word = $request->word;
      $data = DB::table('purchasing')
        ->select('purchasing.*', 'order.*', 'supplier.*', 'style.*', 'inventory.*', 'order.code as order_code', 'supplier.name as supplier_name')
        ->leftJoin('order', 'purchasing.id_order', '=', 'order.id')
        ->leftJoin('supplier', 'purchasing.id_supplier', '=', 'supplier.id')
        ->leftJoin('style', 'purchasing.id_style', '=', 'style.id')
        ->leftJoin('inventory', 'purchasing.id_inventory', '=', 'inventory.id')
        
        ->where('purchasing.po_no', 'LIKE', '%'.$word.'%' )
        ->orWhere('purchasing.description', 'LIKE', '%'.$word.'%' )
        ->orWhere('purchasing.payment_terms', 'LIKE', '%'.$word.'%' )
        ->orWhere('purchasing.status', 'LIKE', '%'.$word.'%' )

        ->orWhere('order.code', 'LIKE', '%'.$word.'%' )
        ->orWhere('supplier.name', 'LIKE', '%'.$word.'%' )
        ->orWhere('style.name', 'LIKE', '%'.$word.'%' )

        ->orWhere('inventory.material_name', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.type', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.code', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.quantity', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.specs', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.unit', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.color', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.awb', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.origin', 'LIKE', '%'.$word.'%' )
        ->get();
        return view('admin/purchasing/index', compact('data', 'word'));
    }

    public function search_old(Request $request)
    {
      $word = $request->word;
      $data = DB::table('purchasing')
        ->select('purchasing.*', 'order.*', 'supplier.*', 'style.*', 'inventory.*', 'order.code as order_code', 'supplier.name as supplier_name')
        ->leftJoin('order', 'purchasing.id_order', '=', 'order.id')
        ->leftJoin('supplier', 'purchasing.id_supplier', '=', 'supplier.id')
        ->leftJoin('style', 'purchasing.id_style', '=', 'style.id')
        ->leftJoin('inventory', 'purchasing.id_inventory', '=', 'inventory.id')
        
        ->where('purchasing.po_no', 'LIKE', '%'.$word.'%' )
        ->orWhere('purchasing.description', 'LIKE', '%'.$word.'%' )
        ->orWhere('purchasing.payment_terms', 'LIKE', '%'.$word.'%' )
        ->orWhere('purchasing.status', 'LIKE', '%'.$word.'%' )

        ->orWhere('order.code', 'LIKE', '%'.$word.'%' )
        ->orWhere('supplier.name', 'LIKE', '%'.$word.'%' )
        ->orWhere('style.name', 'LIKE', '%'.$word.'%' )

        ->orWhere('inventory.material_name', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.type', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.code', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.quantity', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.specs', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.unit', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.color', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.awb', 'LIKE', '%'.$word.'%' )
        ->orWhere('inventory.origin', 'LIKE', '%'.$word.'%' )
        ->paginate(10);
        return view('admin/purchasing/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

}
