<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function roles(Request $request)
    {
        $validator = Validator::Make($request->all(), [
            'name_roles' => 'required|string|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $roles = Roles::create([
            'name_roles' => $request->name_roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roles $roles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roles $roles)
    {
        //
    }
}