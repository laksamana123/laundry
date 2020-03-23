<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaksi;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function show(Request $req){
        if(Auth::user()->level == "petugas"){
            $transaksi = DB::table('transaksi')->join('pelanggan','pelanggan.id','=','transaksi.id_pelanggan')
            ->where('transaksi.tgl_transaksi','>=',$req->tgl_transaksi)
            ->where('transaksi.tgl_selesai','<=',$req->tgl_selesai)
            ->get();
            
            if($transaksi->count() > 0){

            $data_transaksi = array();
            foreach ($transaksi as $tr){
                
                $grand = DB::table('detail_transaksi')->where('id_transaksi','=',$tr->id)
                ->groupBy('id_transaksi')
                ->select(DB::raw('sum(subtotal) as grandtotal'))
                ->first();
                
                $detail = DB::table('detail_transaksi')->join('jenis_cuci','detail_transaksi.id_jenis','=','jenis_cuci.id')
                ->where('id_transaksi','=',$tr->id)
                ->get();
                

                $data [] = array(
                    'tgl' => $tr->tgl_transaksi,
                    'nama pelanggan' => $tr->nama_pelanggan,
                    'alamat' => $tr->alamat,
                    'telp' => $tr->telp,
                    'tgl_jadi' => $tr->tgl_selesai,
                    'grand total' => $grand, 
                    'detail' => $detail
                
                );
                
            }
            return response()->json(compact('data'));
        
    }else{
            $status = 'tidak ada transaksi antara tanggal '.$req->tgl_transaksi.' sampai dengan tanggal '.$req->tgl_selesai;
            return response()->json(compact('status'));
    }
        }else{
            return Response()->json('Anda Bukan Petugas');
        }
        
}

    public function insert(Request $req){
        if(Auth::user()->level == 'petugas'){
        
        $validator = Validator::make($req->all(),
        [
            'id_pelanggan'=>'required',
            'id_petugas'=>'required',
            'tgl_transaksi'=>'required',
            'tgl_selesai'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = transaksi::create([
            'id_pelanggan'=>$req->id_pelanggan,
            'id_petugas'=>$req->id_petugas,
            'tgl_transaksi'=>$req->tgl_transaksi,
            'tgl_selesai'=>$req->tgl_selesai
            
        ]);
        if($simpan){
            return Response()->json('Data Transaksi berhasil ditambahkan');
        }else{
            return Response()->json('Data Transaksi gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan Petugas');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'petugas'){

        $validator = Validator::make($req->all(),
        [
            'id_pelanggan'=>'required',
            'id_petugas'=>'required',
            'tgl_transaksi'=>'required',
            'tgl_selesai'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = transaksi::where('id', $id)->update([
            'id_pelanggan'=>$req->id_pelanggan,
            'id_petugas'=>$req->id_petugas,
            'tgl_transaksi'=>$req->tgl_transaksi,
            'tgl_selesai'=>$req->tgl_selesai
        ]);
        if($ubah){
            return Response()->json('Data Transaksi berhasil diubah');
        }else{
            return Response()->json('Data Transaksi gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan Petugas');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = transaksi::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Transaksi berhasil dihapus');
        }else{
            return Response()->json('Data Transaksi gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan Admin');
    }
    }

    
}

