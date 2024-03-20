<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Roles extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_roles',
    ];
}
//isikan kode berikut
try {
    //cek apakah request berisi nama_role atau tidak
    $validator = Validator::make($request->all(), [
        'nama_role' => 'required|string|max:255|unique:roles',
    ]);

    //kalau tidak akan mengembalikan error
    if ($validator->fails()) {
        return response()->json($validator->errors());
    }

    //kalau ya maka akan membuat roles baru
    $data = Roles::create([
        'nama_role' => $request->nama_role,
    ]);

    //data akan di kirimkan dalam bentuk response list
    $response = [
        'success' => true,
        'data' => $data,
        'message' => 'Data berhasil di simpan',
    ];

    //jika berhasil maka akan mengirimkan status code 200
    return response()->json($response, 200);
} catch (Exception $th) {
    $response = [
        'success' => false,
        'message' => $th,
    ];
    //jika error maka akan mengirimkan status code 500
    return response()->json($response, 500);
}
