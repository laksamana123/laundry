<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pelanggan;
use Auth;
use Illuminate\Support\Facades\Validator;


class PelangganController extends Controller
{
    public function show()
    {
        if(Auth::user()->level == 'admin'){
            $dt_jc=pelanggan::get();
            return Response()->json($dt_jc);
        }else{
            return Response()->json('Anda Bukan admin');
        }
    }

    public function insert(Request $req){
        if(Auth::user()->level == 'admin'){
        
        $validator = Validator::make($req->all(),
        [
            'nama_pelanggan'=>'required',
            'alamat'=>'required',
            'telp'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = pelanggan::create([
            'nama_pelanggan'=>$req->nama_pelanggan,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp
            
        ]);
        if($simpan){
            return Response()->json('Data Pelanggan berhasil ditambahkan');
        }else{
            return Response()->json('Data Pelanggan gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'admin'){

        $validator = Validator::make($req->all(),
        [
            'nama_pelanggan'=>'required',
            'alamat'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = pelanggan::where('id', $id)->update([
            'nama_pelanggan'=>$req->nama_pelanggan,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp
            
            
        ]);
        if($ubah){
            return Response()->json('Data Pelanggan berhasil diubah');
        }else{
            return Response()->json('Data Pelanggan gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = pelanggan::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Pelanggan berhasil dihapus');
        }else{
            return Response()->json('Data Pelanggan gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}