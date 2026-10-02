<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use DB;


class AdminUserController extends Controller
{
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function sales()
	{
		$data = DB::table('users')
		->join('tipe', 'users.tipe', '=', 'tipe.id_tipe')
		->select('users.*', 'tipe.tipe')
		->orderBy('created_at', 'desc')
		->get();
		
		return view('admin.user.sales')->with(['data' => $data]);
	}
	
	public function admin()
	{
		
		$data = DB::table('users')
		->orderBy('created_at', 'desc')
		->where('role', 'admin')
		->get();
		
		return view('admin.user.admin')->with(['data' => $data]);
	}
	
	
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function createsales()
	{
		$data = DB::table('tipe')
		->orderBy('tipe', 'asc')
		->get();
		
		return view('admin.user.create_sales')->with(['data' => $data]);
	}
	
	public function createadmin()
	{
		return view('admin.user.create_admin');
	}
	
	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function storesales(Request $request)
	{
		$request->merge(['username' => Str::lower(trim((string) $request->username))]);
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/', 'unique:users,username'],
			'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
			'tipe' => ['required', 'exists:tipe,id_tipe'],
		]);

		$sales = new User;
		$sales->name = $validated['name'];
		$sales->username = $validated['username'];
		$sales->password = Hash::make($validated['password']);
		$sales->tipe = $validated['tipe'];
		$sales->role = 'sales';
		$sales->save();

		return redirect()->route('admin.sales')->with(['success' => 'Data Sales Berhasil Ditambahkan']);
	}
	
	public function storeadmin(Request $request)
	{
		$request->merge(['username' => Str::lower(trim((string) $request->username))]);
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/', 'unique:users,username'],
			'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
			'level' => ['required', Rule::in(['1', '2', '3'])],
		]);

		$admin = new User;
		$admin->name = $validated['name'];
		$admin->username = $validated['username'];
		$admin->password = Hash::make($validated['password']);
		$admin->role = 'admin';
		$admin->level = $validated['level'];
		$admin->save();

		return redirect()->route('admin.admin')->with(['success' => 'Data Admin Berhasil Ditambahkan']);
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
	public function editsales($id)
	{
		$data = DB::table('users')
		->where('id', $id)
		->first();
		
		$tipe = DB::table('tipe')
		->orderBy('tipe', 'asc')
		->get();

		
		return view('admin.user.edit_sales')->with(['data' => $data, 'tipe' => $tipe]);
	}
	
	public function editadmin($id)
	{
		$data = DB::table('users')
		->where('id', $id)
		->first();

		
		// dd($data);
		
		return view('admin.user.edit_admin')->with(['data' => $data]);
	}
	
	public function resetpassword($id)
	{
		$data = DB::table('users')
		->where('id', $id)
		->first();
		
		return view('admin.user.reset_password')->with(['data' => $data]);
	}
	
	public function updatepassword(Request $request)
	{
		$validated = $request->validate([
			'id' => ['required', 'integer', 'exists:users,id'],
			'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
		]);
		$id = $validated['id'];
		$password = Hash::make($validated['password']);

		User::where('id', $id)->update(['password' => $password]);

		$data = User::where('id', $id)->first();
		if ($data->role == 'sales') {
			return redirect()->route('admin.sales')->with(['success' => 'Password Berhasil Diupdate']);
		}else{
			return redirect()->route('admin.admin')->with(['success' => 'Password Berhasil Diupdate']);
		}
	}
	
	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function updatesales(Request $request)
	{
		$request->merge(['username' => Str::lower(trim((string) $request->username))]);
		$validated = $request->validate([
			'id' => ['required', 'integer', 'exists:users,id'],
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/', Rule::unique('users', 'username')->ignore($request->id)],
			'tipe' => ['required', 'exists:tipe,id_tipe'],
			'piutang' => ['required', 'numeric', 'min:0'],
		]);

		User::where('id', $validated['id'])->update([
			'name' => $validated['name'],
			'username' => $validated['username'],
			'tipe' => $validated['tipe'],
			'piutang' => $validated['piutang'],
		]);

			return redirect()->route('admin.sales')->with(['success' => 'Data Sales Berhasil Diupdate']);
		// dd($id);

		
		
		
		// $data = DB::table('users')
		// ->where('name', $name)
		// ->first();
		
		// if ($data) {
		// 	return redirect()->route('admin.edit_sales', $id)->with(['warning' => 'Nama Sudah Digunakan']);
		// }else{
		// 	DB::table('users')->where('id', $id)->update([
		// 		'name' => $name, 
		// 		'tipe' => $tipe, 
		// 		'piutang' => $piutang
		// 	]);
		// 	return redirect()->route('admin.sales')->with(['success' => 'Data Sales Berhasil Diupdate']);
		// }	
	}
	
	public function updateadmin(Request $request)
	{
		$request->merge(['username' => Str::lower(trim((string) $request->username))]);
		$validated = $request->validate([
			'id' => ['required', 'integer', 'exists:users,id'],
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/', Rule::unique('users', 'username')->ignore($request->id)],
			'level' => ['required', Rule::in(['1', '2', '3'])],
		]);

		DB::table('users')->where('id', $validated['id'])->update([
			'name' => $validated['name'],
			'username' => $validated['username'],
			'level' => $validated['level'],
		]);
		return redirect()->route('admin.admin')->with(['success' => 'Data Admin Berhasil Diupdate']);
		
	}
	
	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function delete($id)
	{
		$data = DB::table('users')
		->where('id', $id)
		->first();
		
		DB::table('users')->where('id', $id)->delete();
		
		if ($data->role == 'sales') {
			return redirect()->route('admin.sales')->with(['success' => 'Data Sales Berhasil Dihapus']);
		}else{
			return redirect()->route('admin.admin')->with(['success' => 'Data Admin Berhasil Dihapus']);
		}
	}
}
