<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class Style_C extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data_modal($id) {
       $data_image = DB::table('style')
       ->leftJoin('style_image', 'style_image.id_style', '=', 'style.id')
       ->where('style.id', '=', $id)
       ->where('style_image.image', '!=', 'noimage.png')
       ->get();


       $component = DB::table('style_component')
       ->select('style_component.*', 'style_component.id as component_id')
       ->where('style_component.id_style', '=', $id)
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

       $data_modal = (object) [ 'data_image' => $data_image, 'component' => $component ];
        return $data_modal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = DB::table('style')->orderBy('id', 'DESC')->get();
       foreach ($data as $key => $value) {
            $data_modal = $this->data_modal($value->id);
            $value->modal_image = $data_modal->data_image;
            $value->modal_component = $data_modal->component;
       }

       return view( 'admin/style/index', compact('data') );
    }

    public function index_old()
    {
       $data = DB::table('style')->latest()->paginate(10);
       foreach ($data as $key => $value) {
            $data_modal = $this->data_modal($value->id);
            $value->modal_image = $data_modal->data_image;
            $value->modal_component = $data_modal->component;
       }

       return view( 'admin/style/index', compact('data') )->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventory = DB::table('inventory')->get();
        return view( 'admin/style/create', compact('inventory') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // print_r( $request->all() ); 
        // foreach ($request->all() as $key => $value) {
        //     var_dump($value);
        // }
        // exit;
        $request->validate([
            'name'    =>  'required',
            'image1'         =>  'image|max:10240',
            'image2'         =>  'image|max:10240'
        ]);
        $data = array(
            'name' => $request->name
         );
        $id_style = DB::table('style')->insertGetId($data);

        if ( $request->component ) {
           foreach ($request->component as $key => $value) {
                $id_component = DB::table('style_component')->insertGetId([
                    'id_style' => $id_style,
                    'name' => $value['name']
                ]);
                if ( $value['material'] ) {
                    foreach ( $value['material'] as $k_mat => $v_mat ) {
                       $usage = $v_mat['mat_calc'] * 12 /100;
                       DB::table('style_component_material')->insert(
                            [
                                'id_style_component' => $id_component,
                                'name' => $v_mat['mat_name'],
                                'calculation' => $v_mat['mat_calc'],
                                'usage' => $usage
                            ]
                        );
                    }
                }
            }
        }

        if ( $request->file('image1') ) {
            $image1 = $request->file('image1');
            $new_name1 = rand() . '_id_style_'. $id_style . '_' . $image1->getClientOriginalName();
            Storage::disk('public')->putFileAs('images', $image1, $new_name1);
            DB::table('style_image')->insert(
                [
                    'id_style' => $id_style,
                    'image' => $new_name1
                ]
            );
        } else {
            DB::table('style_image')->insert(
                [
                    'id_style' => $id_style,
                    'image' => 'noimage.png'
                ]
            );
        }

        if ( $request->file('image2') ) {
            $image2 = $request->file('image2');
            $new_name2 = rand() . '_id_style_'. $id_style . '_' . $image2->getClientOriginalName();
            Storage::disk('public')->putFileAs('images', $image2, $new_name2);
            DB::table('style_image')->insert(
                [
                    'id_style' => $id_style,
                    'image' => $new_name2
                ]
            );
        } else {
            DB::table('style_image')->insert(
                [
                    'id_style' => $id_style,
                    'image' => 'noimage.png'
                ]
            );
        }

       return redirect()->route('style.index')->with('success', 'Data Added successfully.');
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

       return view( 'admin/style/show', compact('data', 'data_size_run', 'total_quantity', 'component', 'data_image') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $data = DB::table('style')->where('id', '=', $id)->first();
       $data_image = DB::table('style_image')->where('id_style', '=', $id)->get();
       $component = DB::table('style_component')
       ->where('style_component.id_style', '=', $id)
       ->get();
       $data_component = [];
       foreach ($component as $key => $value) {
           $data_component[$value->id]['id'] = $value->id;
           $data_component[$value->id]['name'] = $value->name;
           $component_material = DB::table('style_component_material')->where('id_style_component', '=', $value->id)->get();
           foreach ($component_material as $kmat => $vmat) {
              $data_component[$value->id]['material'][$vmat->id]['id_mat'] = $vmat->id;
              $data_component[$value->id]['material'][$vmat->id]['name_mat'] = $vmat->name;
              $data_component[$value->id]['material'][$vmat->id]['calculation_mat'] = $vmat->calculation;
           }
       }
       return view( 'admin/style/edit', compact('data', 'data_image', 'data_component') );
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
            'image1'         =>  'image|max:10240',
            'image2'         =>  'image|max:10240'
        ]);

        DB::table('style')->where('id', '=', $id)->update(['name' => $request->name]);

        if ( $request->image1 ) {
            if ( $request->id_image1 ) {
                $image1 = $request->file('image1');
                $new_name1 = rand() . '_id_style_'. $request->id_order_style . '_' . $image1->getClientOriginalName();
                Storage::disk('public')->putFileAs('images', $image1, $new_name1);
                DB::table('style_image')->where('id', '=', $request->id_image1)->update(
                    [
                        'image' => $new_name1
                    ]
                );
            }
        }

       if ( $request->image2 ) {
            if ( $request->id_image2 ) {
                $image2 = $request->file('image2');
                $new_name2 = rand() . '_id_style_'. $request->id_order_style . '_' . $image2->getClientOriginalName();
                Storage::disk('public')->putFileAs('images', $image2, $new_name2);
                DB::table('style_image')->where('id', '=', $request->id_image2)->update(
                    [
                        'image' => $new_name2
                    ]
                );
            }
        }

        if ( $request->component ) {

               foreach ($request->component as $key => $value) {

                     if ( isset( $value['id'] ) ) { 
                        DB::table('style_component')->where('id', '=', $value['id'])->update(['name' => $value['name']]);
                        if ( isset($value['material']) ) {
                            foreach ( $value['material'] as $k_mat => $v_mat ) {
                               if ( isset($v_mat['mat_id']) ) {
                                    if ( isset($v_mat['mat_name']) && isset($v_mat['mat_calc']) ) {
                                        $usage = $v_mat['mat_calc'] * 12 / 100;
                                        DB::table('style_component_material')->where('id', '=', $v_mat['mat_id'])->update(
                                        [
                                            'id_style_component' => $value['id'],
                                            'name' => $v_mat['mat_name'],
                                            'calculation' => $v_mat['mat_calc'],
                                            'usage' => $usage
                                        ]);
                                    }
                                    else {
                                         DB::table('style_component_material')->where('id', '=', $v_mat['mat_id'])->delete();
                                    }

                               }
                               else {
                                   $usage = $v_mat['mat_calc'] * 12 / 100;
                                   DB::table('style_component_material')->insert(
                                        [
                                            'id_style_component' => $value['id'],
                                            'name' => $v_mat['mat_name'],
                                            'calculation' => $v_mat['mat_calc'],
                                            'usage' => $usage
                                        ]
                                    );
                                }


                            }
                        }
                     }

                     else {
                        if ( isset($value['name']) ) {
                            $id_component = DB::table('style_component')->insertGetId([
                                'id_style' => $id,
                                'name' => $value['name']
                            ]);
                            if ( isset($value['material']) ) {
                                foreach ( $value['material'] as $k_mat => $v_mat ) {
                                   $usage = $v_mat['mat_calc'] * 12 / 100;
                                   DB::table('style_component_material')->insert(
                                        [
                                            'id_style_component' => $id_component,
                                            'name' => $v_mat['mat_name'],
                                            'calculation' => $v_mat['mat_calc'],
                                            'usage' => $usage
                                        ]
                                    );
                                }
                            }
                        }

                     }

                }


               if ( isset($request->component['deleted_component']) ) {
                    foreach ($request->component['deleted_component'] as $key => $value) {
                        DB::table('style_component')->where('id', '=', $value)->delete();
                        DB::table('style_component_material')->where('id_style_component', '=', $value)->delete();
                    } 
               }
        }


        return redirect()->route('style.index')->with('success', 'Data Updated Successfully.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('style')->where('id', '=', $id)->delete();

        return redirect()->route('style.index')->with('success', 'Data is successfully deleted');
    }



    public function search_old(Request $request)
    {
      $word = $request->word;
      $data = DB::table('style')
        ->where('name', 'LIKE', '%'.$word.'%' )
        ->paginate(10);
      
      foreach ($data as $key => $value) {
            $data_modal = $this->data_modal($value->id);
            $value->modal_image = $data_modal->data_image;
            $value->modal_component = $data_modal->component;
      }

      return view('admin/style/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    

    public function search(Request $request)
    {
      $word = $request->word;
      $data = DB::table('style')
        ->where('name', 'LIKE', '%'.$word.'%' )
        ->get();

      foreach ($data as $key => $value) {
              $data_modal = $this->data_modal($value->id);
              $value->modal_image = $data_modal->data_image;
              $value->modal_component = $data_modal->component;
       }

      return view('admin/style/index', compact('data', 'word'));
    }


}
