<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Harga;
use DB;
use Auth;

class AdminSettingController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data = DB::table('harga')
        ->join('tipe', 'harga.id_tipe', '=', 'tipe.id_tipe')
        ->select('harga.*', 'tipe.tipe')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.setting.read')->with(['data' => $data]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $data = DB::table('tipe')
        ->orderBy('tipe', 'asc')
        ->get();

        return view('admin.setting.create')->with(['data' => $data]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $nominal = $request->nominal;
        $id_tipe = $request->tipe;
        $harga_kulakan = $request->harga_kulakan;
        $berat = $request->berat;

        $data = DB::table('harga')
        ->where('id_tipe', $id_tipe)
        ->where('harga', $nominal)
        ->first();

        if ($data) {
            return redirect()->route('admin.create_harga')->with(['warning' => 'Harga Sudah Ada']);
        }else{
            $harga = new Harga;
            $harga->harga = $nominal;
            $harga->harga_kulakan = $harga_kulakan;
            $harga->berat = $berat;
            $harga->id_tipe = $id_tipe;
            $harga->save();

            return redirect()->route('admin.setting')->with(['success' => 'Data Harga Berhasil Ditambahkan']);
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
    public function edit($id)
    {
        $data = DB::table('harga')
        ->where('id_harga', $id)
        ->first();

        $tipe = DB::table('tipe')
        ->orderBy('tipe', 'asc')
        ->get();

        // dd($data);

        return view('admin.setting.edit_harga')->with(['data' => $data, 'tipe' => $tipe]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        $id_harga = $request->id;
        $harga = $request->nominal;
        $id_tipe = $request->tipe;
        $berat = $request->berat;
        $harga_kulakan = $request->harga_kulakan;

        DB::table('harga')->where('id_harga', $id_harga)->update(['harga' => $harga,'harga_kulakan' => $harga_kulakan, 'berat' => $berat,'id_tipe' => $id_tipe ]);
        return redirect()->route('admin.setting')->with(['success' => 'Data Harga Berhasil Diupdate']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {
        DB::table('harga')->where('id_harga', $id)->delete();
        return redirect()->route('admin.setting')->with(['success' => 'Data Harga Berhasil Dihapus']);
    }
}
