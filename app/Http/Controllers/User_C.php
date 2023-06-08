<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Role_Access;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use File;
use Storage;
use Illuminate\Http\UploadedFile;
use DB;

class User_C extends Controller
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
        $data = DB::table('users')
                ->leftJoin('role', 'role.slug', '=', 'users.role')
                ->select('users.id AS id', 'users.email AS email', 'role.name AS role_name', 'users.name as name')
                ->where('users.role', '!=', 'superadmin')
                ->paginate(10);
        return view('admin/user/index', compact('data'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = DB::table('role')->where('role.slug', '!=', 'superadmin')->get();
        // var_dump($role); exit;
        return view( 'admin/user/create', ['role' => $role] ) ;
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
        $user = DB::table('users')->where('id', '=', $id)->first();
        $role = DB::table('role')->where('role.slug', '!=', 'superadmin')->get();
        return view('admin/user/edit', compact('user', 'role'));
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
            'role' => 'required',
            'email' => 'required'
        ]);

        $data = array(
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email
        );
        // User::where('id', $id)->update($data);
        DB::table('users')
              ->where('id', '=', $id)
              ->update($data);
       
        return redirect()->route('user.index')->with('success', 'Data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->route('user.index')->with('success', 'Data is successfully deleted');
    }

    public function search(Request $request) {
      $word = $request->word;

      $data = DB::table('users')
        ->leftJoin('role', 'role.slug', '=', 'users.role')
        ->select('users.id AS id', 'users.email AS email', 'role.name AS role_name', 'users.name as name')
        ->where('users.id', 'LIKE', '%'.$word.'%' )
        ->orWhere('users.name', 'LIKE', '%'.$word.'%' )
        ->orWhere('users.email', 'LIKE', '%'.$word.'%' )
        ->orWhere('role.name', 'LIKE', '%'.$word.'%' )
        ->paginate(10);
        // var_dump($data); exit;
        return view('admin/user/index', compact('data', 'word'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function user_profile($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        $role = DB::table('role')->get();
        return view('admin/user/user_profile', compact('user', 'role'));
    }

    public function admin_edit_pass($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        return view('admin/user/admin_edit_pass', compact('user'));
    }

    public function admin_update_pass(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:8',
            'new_confirm_password' => 'same:new_password',
        ]);
   
        User::find($id)->update(['password'=> Hash::make($request->new_password)]);
       
        return redirect()->route('user.edit', $id)->with('success', 'Password is successfully updated');
    }

    public function update_password(Request $request, $id)
    {
        // var_dump($request->all()); exit;
        $request->validate([
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:8',
            'new_confirm_password' => 'same:new_password',
        ]);
   
        User::find($id)->update(['password'=> Hash::make($request->new_password)]);
       
        return redirect()->route('user.user_profile', $id)->with('success', 'Password is successfully updated');
    }

}
