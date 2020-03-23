<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\jenis_cuci;
use Auth;
use Illuminate\Support\Facades\Validator;


class Jenis_cuciController extends Controller
{
    public function show()
    {
        if(Auth::user()->level == 'admin'){
            $dt_jc=jenis_cuci::get();
            return Response()->json($dt_jc);
        }else{
            return Response()->json('Anda Bukan admin');
        }
    }

    public function insert(Request $req){
        if(Auth::user()->level == 'admin'){
        
        $validator = Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga_perkilo'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = jenis_cuci::create([
            'nama_jenis'=>$req->nama_jenis,
            'harga_perkilo'=>$req->harga_perkilo
            
        ]);
        if($simpan){
            return Response()->json('Data jenis cuci berhasil ditambahkan');
        }else{
            return Response()->json('Data jenis cuci gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'admin'){

        $validator = Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga_perkilo'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = jenis_cuci::where('id', $id)->update([
            'nama_jenis'=>$req->nama_jenis,
            'harga_perkilo'=>$req->harga_perkilo
        ]);
        if($ubah){
            return Response()->json('Data jenis cuci berhasil diubah');
        }else{
            return Response()->json('Data jenis cuci gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = jenis_cuci::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data jenis cuci berhasil dihapus');
        }else{
            return Response()->json('Data jenis cuci gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}