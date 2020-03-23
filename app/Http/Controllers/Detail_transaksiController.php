<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\detail_transaksi;
use App\jenis_cuci;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class Detail_transaksiController extends Controller
{
    public function show()
    {
        if(Auth::user()->level == 'petugas'){
            $dt_detail=detail_transaksi::get();
            return Response()->json($dt_detail);
        }else{
            return Response()->json('Anda Bukan petugas');
        }
    }

    public function insert(Request $req){
        if(Auth::user()->level == 'petugas'){
        
        $validator = Validator::make($req->all(),
        [
            'id_transaksi'=>'required',
            'id_jenis'=>'required',
            'qty'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $harga = jenis_cuci::where('id',$req->id_jenis)->first();
        $subtotal = $harga->harga_perkilo * $req->qty;

        $simpan = detail_transaksi::create([
            'id_transaksi'=> $req->id_transaksi,
            'id_jenis'=> $req->id_jenis,
            'subtotal'=> $subtotal,
            'qty'=> $req->qty
            
        ]);
        if($simpan){
            return Response()->json('Data Detail berhasil ditambahkan');
        }else{
            return Response()->json('Data Detail gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan petugas');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'petugas'){

        $validator = Validator::make($req->all(),
        [
            'id_transaksi'=>'required',
            'id_jenis'=>'required',
            'qty'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $harga = jenis_cuci::where('id',$req->id_jenis)->first();
        $subtotal = $harga->harga_perkilo * $req->qty;

        $ubah = detail_transaksi::where('id', $id)->update([
            'id_transaksi'=> $req->id_transaksi,
            'id_jenis'=> $req->id_jenis,
            'subtotal'=> $subtotal,
            'qty'=> $req->qty
        ]);
        if($ubah){
            return Response()->json('Data Detail Transaksi berhasil diubah');
        }else{
            return Response()->json('Data Detail Transaksi gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan petugas');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'petugas'){

        $hapus = detail_transaksi::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Detail Transaksi berhasil dihapus');
        }else{
            return Response()->json('Data Detail Transaksi gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan petugas');
    }
    }

}
