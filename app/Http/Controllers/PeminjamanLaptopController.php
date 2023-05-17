<?php

namespace App\Http\Controllers;

use App\Models\peminjamanLaptop;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class PeminjamanLaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search_nama;

        $limit = $request->limit;

        $peminjamanLaptop = peminjamanLaptop::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();

        if ($peminjamanLaptop) {
            return ApiFormatter::createApi(200, 'success', $peminjamanLaptop);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // validasi data
        $request->validate([
            'nis' => 'required|numeric',
            'nama' => 'required|min:3',
            'rombel' => 'required',
            'rayon' => 'required',
        ]);

        //ngirim data atau tambah data
        $peminjamanLaptop = peminjamanLaptop::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ]);

        // cari data baru yang berhasil di simpan, cari berdasarkan id lewat data id dari $student yang diatas
        $hasilTambahData = peminjamanLaptop::where('id', $peminjamanLaptop->id)->first();
        if ($hasilTambahData) {
            return ApiFormatter::createAPI(200, 'success', $hasilTambahData);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
        }catch (Exception $error) {
            // munculin deskripsi error yang bakal tampil di property data json nya
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Display the specified resource.
     */
    public function show(peminjamanLaptop $peminjamanLaptop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(peminjamanLaptop $peminjamanLaptop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nis' => 'required|numeric',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);
            // ambil data yang akan di ubah
            $peminjamanLaptop = peminjamanLaptop::find($id);
            // update data yang telah diambil diatas
            $peminjamanLaptop->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);
            // cari data yang berhasil diubah tadi, cari berdasarkan id dari $student yang ngambil data di awal
            $updatedpeminjamanLaptop= peminjamanLaptop::where('id', $peminjamanLaptop->id)->first();

            if ($updatedpeminjamanLaptop) {
                return ApiFormatter::createAPI(200, 'success', $peminjamanLaptop);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            // jika di baris kode try ada trouble, error dimunculkan dengan desc error nya dengan status code 400
            return ApiFormatter::createAPI(400, 'failed', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $peminjamanLaptop = peminjamanLaptop::findOrFail($id);
            $proses = $peminjamanLaptop->delete();

            if ($proses) {
                return ApiFormatter::createAPI(200, 'succes delete data!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI( 400, 'failed', $error);
        }
    }

    public function trash()
    {
        try {
            // ambil data yanag sudah dihapus sementara
            $peminjamanLaptop = peminjamanLaptop::onlyTrashed()->get();
            if ($peminjamanLaptop) {
                // kalau data berhasil terambil, tampilkan status 200 dengan $peminjamans
                return ApiFormatter::createAPI(200, 'success', $peminjamanLaptop);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            // kalau ada error try, catch akan menampilkan desc error nya
            return ApiFormatter::createAPI(400, 'error', $error->getMessage);
        }
    }
    public function restore($id)
    {
        try {
            // ambil data yang akan di batal hapus, diambil berdasarkan id dari route nya
            $peminjamanLaptop = peminjamanLaptop::onlyTrashed()->where('id', $id);
            // kembalikan data
            $peminjamanLaptop->restore();
            // ambil kembali data yang sudah di restore
            $dataKembali = peminjamanLaptop::where('id', $id)->first();
            if ($dataKembali) {
                // jika seluruh proses nya dapat dijalankan, data yang sudah dikembalikan dan diambil tadi ditampilkan pada response 200
                return ApiFormatter::createAPI(200, 'success', $dataKembali);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage);
        } 
    }
    public function permanentDelete($id)
    {
        try {
            // ambil data yang akan dihapus
            $peminjamanLaptop= peminjamanLaptop::onlyTrashed()->where('id', $id);
            // hapus permanen data yang diambil
            $proses = $peminjamanLaptop->forceDelete();
            if ($proses) {
                return ApiFormatter::createAPI(200, 'success', 'Berhasil hapus permanen!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        }   catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }       
}
