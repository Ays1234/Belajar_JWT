<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use File;

class BankController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('api:auth', ['except' => ['add_bank', 'update_bank', 'delete_bank']]);
    }

    // public function index(){
    //     $data = Bank::all();
    // }
    public function add_bank(Request $request)
    {
        // return $request->icon;
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'acronym' => 'required',
            'code' => 'required',
            'icon' => 'required|file|mimes:png,jpg',
            'status' => 'required',
            'createby' => 'required',
            'updateby' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages());

            return response()->json(
                [
                    'status' => false,
                    'error' => false,
                    'message' => 'Error',
                    'data' => null,
                ],
                200,
            );
        }

        if ($request->file('icon')) {
            $path = $request->file('icon')->store('icon');
        }
        $bank = Bank::create([
            'name' => request('name'),
            'acronym' => request('acronym'),
            'code' => request('code'),
            'icon' => $path,
            'status' => request('status'),
            'createby' => request('createby'),
            'updateby' => request('updateby'),
        ]);
        if ($bank) {
            return response()->json(
                [
                    'status' => true,
                    'error' => false,
                    'message' => 'success',
                    'data' => $bank,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'error' => false,
                    'message' => 'Error',
                    'data' => null,
                ],
                200,
            );
        }
    }

    public function update_bank(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'acronym' => 'required',
            'code' => 'required',
            'icon' => 'file|mimes:png,jpg',
            'status' => 'required',
            'createby' => 'required',
            'updateby' => 'required',
        ]);
        if ($validator->fails()) {
            // return response()->json($validator->messages());

            return response()->json(
                [
                    'status' => false,
                    'error' => false,
                    'message' => 'Error',
                    'data' => null,
                ],
                200,
            );
        }
        $updatebank = Bank::find($id);
        if ($request->file('icon')) {
            if ($request->icon) {
                Storage::delete($updatebank->icon);
            }
            $path = $request->file('icon')->store('icon');
        }

        $bank = $updatebank->update([
            'name' => request('name'),
            'acronym' => request('acronym'),
            'code' => request('code'),
            'icon' => $path,
            'status' => request('status'),
            'createby' => request('createby'),
            'updateby' => request('updateby'),
        ]);
        $bank = $updatebank->update([
            'name' => request('name'),
            'acronym' => request('acronym'),
            'code' => request('code'),
            'icon' => $path,
            'status' => request('status'),
            'createby' => request('createby'),
            'updateby' => request('updateby'),
        ]);

        if ($bank) {
            // return response()->json(['message' => 'Pendaftaran']);

            return response()->json(
                [
                    'status' => true,
                    'error' => false,
                    'message' => 'success',
                    'data' => $bank,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'error' => false,
                    'message' => 'Error',
                    'data' => null,
                ],
                200,
            );
        }
    }

    public function delete_bank(Request $request, $id)
    {

        $deletebank = Bank::find($id);
            if ($deletebank->icon) {
                Storage::delete($deletebank->icon);
            }
        $bank = $deletebank->delete();

        if ($bank) {
            // return response()->json(['message' => 'Pendaftaran']);

            return response()->json(
                [
                    'status' => true,
                    'error' => false,
                    'message' => 'success',
                    'data' => $bank,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'error' => false,
                    'message' => 'Error',
                    'data' => null,
                ],
                200,
            );
        }
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>
                $this->guard()
                    ->factory()
                    ->getTTL() * 60,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
}
