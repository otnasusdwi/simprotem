<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;
use DB;
use Auth;

class AdminPelangganController extends Controller
{
   public function index()
	{
		$data = DB::table('pelanggan')
		->orderBy('created_at', 'desc')
		->get();
		
		return view('admin.pelanggan.list')->with(['data' => $data]);
	}

	public function create()
	{
		return view('admin.pelanggan.create');
	}

	public function store(Request $request)
	{
		$name = $request->name;
		
		$data = DB::table('pelanggan')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.create_pelanggan')->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			$pelanggan = new Pelanggan;
			$pelanggan->name = $name;
			$pelanggan->save();
			
			return redirect()->route('admin.pelanggan')->with(['success' => 'Data pelanggan Berhasil Ditambahkan']);
		}	
	}

	public function edit($id)
	{
		$data = DB::table('pelanggan')
		->where('id', $id)
		->first();
		
		return view('admin.pelanggan.edit')->with(['data' => $data]);
	}

	public function update(Request $request)
	{
		$id = $request->id;
		$name = $request->name;
		
		$data = DB::table('pelanggan')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.edit_pelanggan', $id)->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			DB::table('pelanggan')->where('id', $id)->update(['name' => $name]);		
			return redirect()->route('admin.pelanggan')->with(['success' => 'Data pelanggan Berhasil Diupdate']);
		}	
	}

	public function delete($id)
	{
		$data = DB::table('pelanggan')
		->where('id', $id)
		->first();
		
		DB::table('pelanggan')->where('id', $id)->delete();

		return redirect()->route('admin.pelanggan')->with(['success' => 'Data pelanggan Berhasil Dihapus']);
	}
}
