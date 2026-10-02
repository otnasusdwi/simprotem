<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tipe;
use DB;
use Auth;


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
		$name = $request->name;
		$password = $request->password;
		$tipe = $request->tipe;
		
		$data = DB::table('users')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.create_sales')->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			$sales = new User;
			$sales->name = $name;
			$sales->password = Hash::make($password);
			$sales->tipe = $tipe;
			$sales->role = 'sales';
			$sales->save();
			
			return redirect()->route('admin.sales')->with(['success' => 'Data Sales Berhasil Ditambahkan']);
		}	
	}
	
	public function storeadmin(Request $request)
	{
		$name = $request->name;
		$password = $request->password;
		$level = $request->level;
		
		$data = DB::table('users')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.create_admin')->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			$sales = new User;
			$sales->name = $name;
			$sales->password = Hash::make($password);
			$sales->role = 'admin';
			$sales->level = $level;
			$sales->save();
			
			return redirect()->route('admin.admin')->with(['success' => 'Data Admin Berhasil Ditambahkan']);
		}	
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
		$id = $request->id;
		$password = Hash::make($request->password);

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
		$id = $request->id;
		$name = $request->name;
		$tipe = $request->tipe;
		$piutang = $request->piutang;

		$user = User::where('id', $id)->first();
		
		if ($name == $user->name) {
			User::where('id', $id)->update([
				'tipe' => $tipe,
				'piutang' => $piutang
			]);

			return redirect()->route('admin.sales')->with(['success' => 'Data Sales Berhasil Diupdate']);
		}else{
			$cek = User::where('name', $name)->first();
			if ($cek) {
				return redirect()->route('admin.sales')->with(['warning' => 'Name Sales Sudah Ada']);
			}else{
				User::where('id', $id)->update([
					'name' => $name,
					'tipe' => $tipe,
					'piutang' => $piutang
				]);
				return redirect()->route('admin.sales')->with(['success' => 'Data Sales Berhasil Diupdate']);
			}
		}
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
		$id = $request->id;
		$name = $request->name;
		$level = $request->level;

		// dd($level);
		
		DB::table('users')->where('id', $id)->update(['name' => $name, 'level' => $level]);
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
