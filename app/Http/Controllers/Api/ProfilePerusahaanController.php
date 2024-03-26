<?php

namespace App\Http\Controllers\Api;

use App\Models\ProfilePerusahaan;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilePerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = ProfilePerusahaan::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data tersedia',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => $th,
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //cek apakah request berisi nama_role atau tidak
            $validator = Validator::make($request->all(), [
                'nama_perusahaan' => 'required',
                'deskripsi' => 'required',
                'lokasi' => 'required',
                'jam_masuk' => 'required',
                'jam_pulang' => 'required',
            ]);

            //kalau tidak akan mengembalikan error
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            //kalau ya maka akan membuat roles baru
            $data = ProfilePerusahaan::create([
                'nama_perusahaan' => $request->nama_perusahaan,
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'image' => $request->image,
            ]);

            //data akan di kirimkan dalam bentuk response list
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Profil Perusahaan berhasil disimpan',
            ];

            //jika berhasil maka akan mengirimkan status code 200
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Gagal Menyimpan Data',
            ];
            //jika error maka akan mengirimkan status code 500
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = ProfilePerusahaan::find($id);
            if ($data == null){
                $response = [
                    'success' => false,
                    'message' => 'Perusahaan Tidak Ditemukan',
                ];
                return response()->json($response, 500);
            }
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Selamat Datang, PT Contoh',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Perusahaan Tidak Ditemukan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_perusahaan' => 'required',
                'deskripsi' => 'required',
                'lokasi' => 'required',
                'jam_masuk' => 'required',
                'jam_pulang' => 'required',
                            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $data = ProfilePerusahaan::find($id);
            $data->nama_perusahaan = $request->nama_perusahaan;
            $data->deskripsi = $request->deskripsi;
            $data->lokasi = $request->lokasi;
            $data->jam_masuk = $request->jam_masuk;
            $data->jam_pulang = $request->jam_pulang;
            $data->save();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data Perusahaan berhasil diubah',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data Perusahaan tidak Ditemukan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $save = ProfilePerusahaan::find($id);
            if ($save == null) {
                return response()->json(['success' => false, 'message' => 'Periksa kembali data yang akan di hapus'], 404);
            }
            $save->delete();
            $response = [
                'success' => true,
                'message' => 'Sukses menghapus data',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => $th,
            ];
            return response()->json($response, 500);
        }
    }
}
