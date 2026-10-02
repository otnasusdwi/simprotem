<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;
use DB;
use Auth;

class AdminKaryawanController extends Controller
{
	public function index()
	{
		$data = DB::table('karyawan')
		->orderBy('created_at', 'desc')
		->get();
		
		return view('admin.karyawan.list')->with(['data' => $data]);
	}

	public function create()
	{
		return view('admin.karyawan.create');
	}

	public function store(Request $request)
	{
		$name = $request->name;
		
		$data = DB::table('karyawan')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.create_karyawan')->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			$karyawan = new Karyawan;
			$karyawan->name = $name;
			$karyawan->save();
			
			return redirect()->route('admin.karyawan')->with(['success' => 'Data Karyawan Berhasil Ditambahkan']);
		}	
	}

	public function edit($id)
	{
		$data = DB::table('karyawan')
		->where('id', $id)
		->first();
		
		return view('admin.karyawan.edit')->with(['data' => $data]);
	}

	public function update(Request $request)
	{
		$id = $request->id;
		$name = $request->name;
		
		$data = DB::table('karyawan')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.edit_karyawan', $id)->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			DB::table('karyawan')->where('id', $id)->update(['name' => $name]);		
			return redirect()->route('admin.karyawan')->with(['success' => 'Data Karyawan Berhasil Diupdate']);
		}	
	}

	public function delete($id)
	{
		$data = DB::table('karyawan')
		->where('id', $id)
		->first();
		
		DB::table('karyawan')->where('id', $id)->delete();

		return redirect()->route('admin.karyawan')->with(['success' => 'Data Karyawan Berhasil Dihapus']);
	}
}
