<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biodatas = Biodata::all();
        foreach($biodatas as $biodata){
            $biodata->foto = url('storage/'.$biodata->foto);
        }
        return response([
            'status' => true,
            'message' => "List Data Biodata",
            'data' => $biodatas
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
            'hobi' => 'required|string',
            'foto' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }

        if(request()->file('foto')){
            $thumbnailUrl = request()->file('foto')->store('images/biodatas');
        } else {
            $thumbnailUrl = null;
        }

        $attr = $request->all();
        $attr['foto'] = $thumbnailUrl;
        $biodata = Biodata::create($attr);
        return response([
            'status' => true,
            'message' => "Data Biodata Berhasil Ditambahkan",
            'data' => $biodata
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $biodata = Biodata::find($id);
        $biodata->foto = url('storage/'.$biodata->foto);
        return response([
            'status' => true,
            'message' => "Detail Data Biodata",
            'data' => $biodata
        ], 200);
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
        $biodata = Biodata::find($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
            'hobi' => 'required|string',
            'foto' => 'required|image'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }

        if(request()->file('foto')){
            \Storage::delete($biodata->foto);
            $thumbnailUrl = request()->file('foto')->store('images/biodatas');
        } else {
            $thumbnailUrl = request()->file('foto')->store('images/biodatas');
        }

        $biodata->nama = $request->nama;
        $biodata->no_hp = $request->no_hp;
        $biodata->alamat = $request->alamat;
        $biodata->hobi = $request->hobi;
        $biodata->foto = $thumbnailUrl;
        $biodata->save();
        return response([
            'status' => true,
            'message' => "Data Biodata Berhasil Diubah",
            'data' => $biodata
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $biodata = Biodata::find($id);
        \Storage::delete($biodata->foto);
        $biodata->delete();
        return response([
            'status' => true,
            'message' => "Data Biodata Berhasil Dihapus"
        ], 200);
    }
}
