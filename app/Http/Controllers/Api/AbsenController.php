<?php

namespace App\Http\Controllers\Api;

use App\Models\Absen;
use App\Http\Controllers\Controller;
use App\Models\ProfilePerusahaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Absen::all();
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
                'users_id' => 'required',
                'lokasi_user' => 'required',
                'waktu_absen_masuk' => 'required',
                'tanggal_hari_ini' => 'required',
                'status' => 'required',
            ]);

            // cek apakah sudah absen masuk/belum
            $data = Absen::where('tanggal_hari_ini', $request-> tanggal_hari_ini)
            ->where('users_id',  $request-> users_id)
            ->first();
            if ($data != null){
                $response = [
                    'success' => false,
                    'message' => 'Anda Sudah Absen Masuk',
                ];
                return response()->json($response, 500);
            }

            $profile = ProfilePerusahaan::find(1);
            $profilee = strtotime($profile -> jam_masuk);
            $profileee = strtotime($request-> waktu_absen_masuk) ;
            $peraturan = date("H:i:s", $profilee);
            $pegawai_absen = date("H:i:s", $profileee);
            if  ($peraturan >= $pegawai_absen){
                $status = "Tepat Waktu";
            }else {
                $status = "Terlambat";
            }

            //kalau ya maka akan membuat roles baru
            $data = Absen::create([
                'users_id' => $request->users_id,
                'lokasi_user' => $request->lokasi_user,
                'waktu_absen_masuk' => $request->waktu_absen_masuk,
                'tanggal_hari_ini' => $request->tanggal_hari_ini,
                'status' => $request->status,
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
            $data = Absen::where('id', $id)->first(); //find($id);
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
                //'users_id' => 'required',
                //'lokasi_user' => 'required',
                //'waktu_absen_masuk' => 'required',
                'waktu_absen_pulang' => 'required',
                'tanggal_hari_ini' => 'required',
                            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $data = Absen::find($id);
            //Cek apakah data ada atau tidak
            if ($data == null){
                $response = [
                    'success' => false,
                    'message' => 'Data Tidak Ditemukan',
                ];
                return response()->json($response, 500);
            }
            //Cek sudah absen pulang atau belum
            if ($data -> waktu_absen_pulang != null || $data -> tanggal_hari_ini != $request ->tanggal_hari_ini){
                $response = [
                    'success' => false,
                    'message' => 'Anda Sudah Absen Pulang Atau Tanggal Hari ini Tidak Sesuai Dengan Tanggal Absen ',
                ];
                return response()->json($response, 500);
            }
            //$data->users_id = $request->users_id;
            //$data->lokasi_user = $request->lokasi_user;
            //$data->waktu_absen_masuk = $request->waktu_absen_masuk;
            $data->waktu_absen_pulang = $request->waktu_absen_pulang;
            //$data->tanggal_hari_ini = $request->tanggal_hari_ini;
            $data->save();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data Absen berhasil diubah',
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
            $save = Absen::find($id);
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
