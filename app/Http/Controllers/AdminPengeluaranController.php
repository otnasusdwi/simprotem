<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengeluaran;
use DB;
use Auth;

class AdminPengeluaranController extends Controller
{
	public function index()
	{
		$data = DB::table('pengeluaran')
		->orderBy('created_at', 'desc')
		->get();
		
		return view('admin.pengeluaran.list')->with(['data' => $data]);
	}

	public function create()
	{
		return view('admin.pengeluaran.create');
	}

	public function store(Request $request)
	{
		$name = $request->name;

		// dd($name);
		
		$data = DB::table('pengeluaran')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.create_pengeluaran')->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			$pengeluaran = new Pengeluaran;
			$pengeluaran->name = $name;
			$pengeluaran->save();
			
			return redirect()->route('admin.pengeluaran')->with(['success' => 'Data pengeluaran Berhasil Ditambahkan']);
		}	
	}

	public function edit($id)
	{
		$data = DB::table('pengeluaran')
		->where('id', $id)
		->first();
		
		return view('admin.pengeluaran.edit')->with(['data' => $data]);
	}

	public function update(Request $request)
	{
		$id = $request->id;
		$name = $request->name;
		
		$data = DB::table('pengeluaran')
		->where('name', $name)
		->first();
		
		if ($data) {
			return redirect()->route('admin.edit_pengeluaran', $id)->with(['warning' => 'Nama Sudah Digunakan']);
		}else{
			DB::table('pengeluaran')->where('id', $id)->update(['name' => $name]);		
			return redirect()->route('admin.pengeluaran')->with(['success' => 'Data pengeluaran Berhasil Diupdate']);
		}	
	}

	public function delete($id)
	{
		$data = DB::table('pengeluaran')
		->where('id', $id)
		->first();
		
		DB::table('pengeluaran')->where('id', $id)->delete();

		return redirect()->route('admin.pengeluaran')->with(['success' => 'Data pengeluaran Berhasil Dihapus']);
	}
}
