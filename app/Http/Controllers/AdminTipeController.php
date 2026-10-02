<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tipe;
use DB;
use Auth;

class AdminTipeController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data = DB::table('tipe')
        ->orderBy('tipe', 'asc')
        ->get();
        
        // dd($data);
        return view('admin.tipe.read')->with(['data' => $data]);
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        // echo "add_tipe";
        return view('admin.tipe.create');
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $tipe_sales = $request->tipe_sales;
        $margin = $request->margin;
        
        $data = DB::table('tipe')
        ->where('tipe', $tipe_sales)
        ->first();
        
        if ($data) {
            return redirect()->route('admin.create_tipe')->with(['warning' => 'Data Tipe Sales Sudah Ada']);
        }else{
            $tipe = new Tipe;
            $tipe->tipe = $tipe_sales;
            $tipe->margin = $margin;
            $tipe->save();
            
            return redirect()->route('admin.tipe')->with(['success' => 'Data Tipe Sales Berhasil Ditambahkan']);
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
        $data = DB::table('tipe')
        ->where('id_tipe', $id)
        ->first();
        
        return view('admin.tipe.edit')->with(['data' => $data]);
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
        $id_tipe = $request->id_tipe;
        $tipe_sales = $request->tipe_sales;
        $margin = $request->margin;
        
        $data = DB::table('tipe')
        ->where('tipe', $tipe_sales)
        ->first();
        
        if ($data) {
            return redirect()->route('admin.edit_tipe', $id_tipe)->with(['warning' => 'Tipe Sudah Digunakan']);
        }else{
            DB::table('tipe')->where('id_tipe', $id_tipe)->update(['tipe' => $tipe_sales, 'margin' => $margin ]);
            return redirect()->route('admin.tipe')->with(['success' => 'Data Tipe Sales Berhasil Diupdate']);
        }	
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {
        DB::table('tipe')->where('id_tipe', $id)->delete();
        return redirect()->route('admin.tipe')->with(['success' => 'Data Tipe Sales Berhasil Dihapus']);
    }
}
