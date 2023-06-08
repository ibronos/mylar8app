<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Role_Access;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class Role_C extends Controller
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
        $data = Role::latest()->paginate(10);
        return view('admin/role/index', compact('data'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/role/create');
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
            'slug'    =>  'required',
        ]);

        $role = array(
            'name' => $request->name,
            'slug'    => strtolower($request->slug),
        );
        DB::table('role')->insert($role);

        // $user = isset($request->user) ? 'y' : 'n';
        // $inventory = isset($request->inventory) ? 'y' : 'n';
        // $production = isset($request->production) ? 'y' : 'n';

        // $id_role = DB::table('role')->insertGetId($role);
        // $role_access = array(
        //     'id_role' => $id_role,
        //     'user' => $user,
        //     'inventory' => $inventory,
        //     'production' => $production
        //  );
        // Role_Access::create($role_access);

        return redirect()->route('role.index')->with('success', 'Data Added successfully.');
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
        // $data = DB::table('role')
        //         ->leftJoin('role_access', 'role.id', '=', 'role_access.id_role')
        //         ->select('role.id AS id', 'role.name AS name', 'role_access.user AS user', 'role_access.inventory as inventory', 'role_access.production As production')
        //         ->where('role.id', '=', $id)
        //         ->first()
        //         ;
        $data = DB::table('role')->where('role.id', '=', $id)->first();
        return view('admin/role/edit', compact('data'));
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
         // return $request->all();
        $request->validate([
            'name'    =>  'required',
            'slug'    =>  'required',
        ]);

        $role = array(
            'name' => $request->name,
            'slug'    => strtolower($request->slug),
        );
        Role::whereId($id)->update($role);

        // $user = isset($request->user) ? 'y' : 'n';
        // $inventory = isset($request->inventory) ? 'y' : 'n';
        // $production = isset($request->production) ? 'y' : 'n';
        // $role_access = array(
        //     'id_role' => $id,
        //     'user' => $user,
        //     'inventory' => $inventory,
        //     'production' => $production
        //  );
        // Role_Access::where('id_role', $id)->update($role_access);
       
        return redirect()->route('role.index')->with('success', 'Data is successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Role::findOrFail($id);
        $data->delete();

        return redirect()->route('role.index')->with('success', 'Data is successfully deleted');
    }
}
