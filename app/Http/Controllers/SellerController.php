<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerAccess;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Seller::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'cnpj' => 'required|unique:sellers,cnpj|min:14|max:18',
            'email' => 'required|unique:sellers,email|min:6|max:45',
            'password' => 'required|min:6|max:25',
            'termsCheck' => 'boolean'
        ]);
        
        $seller = Seller::create([  
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'termsCheck' => $request->termsCheck,
            // not requireds
            'fantasia' => $request->fantasia,
            'nome' => $request->nome,
            'abertura' => $request->abertura,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'municipio' => $request->municipio,
            'uf' => $request->uf,
            'cep' => $request->cep,
            'status' => $request->status,
            'situacao' => $request->situacao,
            'porte' => $request->porte,
            'capital_social' => $request->capital_social,
            'telefone' => $request->telefone,
            'alias' => $request->alias,
        ]);

        $token = auth('sellers')->login($seller);

        return $this->respondWithToken($token);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPub($id)
    {
        return Seller::findOrFail($id);
    }
    
    public function showSellerByAlias($store)
    {
        return Seller::where('alias', $store)->first();
    }
    
    
    public function show()
    {
        // return Seller::findOrFail($id);
        try {
            $seller = auth('sellers')->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
        }

        return response()->json(compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $seller = auth('sellers')->userOrFail();
        // $seller->update($request->all());

        // return response()->json(compact('seller'));

        // $validator = Validator::make($request->all(), [
        //     'logo' => 'image:jpeg,png,jpg,gif,svg|max:2048'
        //  ]);

         $data = [];

         $sobrescrever = auth('sellers')->userOrFail();
 
          if ($request->logo != $sobrescrever->logo) {
             $uploadFolder = 'logos';
             $image = $request->file('logo');
             $logo_path = $image->store($uploadFolder, 'public');
 
             if($sobrescrever->logo) {
                 Storage::delete($sobrescrever->logo);
             }
 
             $data += [
                 'logo' => $logo_path,
                ];
            }
            
            $data += [
            'fantasia' => $request->fantasia,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'municipio' => $request->municipio,
            'uf' => $request->uf,
            'cep' => $request->cep,
            'telefone' => $request->telefone,
            'telefone2' => $request->telefone2,

            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'cpf' => $request->cpf,
            'cel' => $request->cel,
            'bankName' => $request->bankName,
            'bankType' => $request->bankType,
            'bankAg' => $request->bankAg,
            'bankAccount' => $request->bankAccount,
        ];

        // dd($data);

        // $prod = auth('sellers')->id();
        $seller = auth('sellers')->userOrFail();
        $seller->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = auth('sellers')->userOrFail();
        $seller->delete();
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        
        $credentials = $request->only(['email', 'password']);
        
        if (!$token = auth('sellers')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // return $this->respondWithToken($token);
        $user = auth('sellers')->user($token);
        
        return response()->json(compact('token', 'user'));
    }

    public function logout(Request $request) 
    {
        auth('sellers')->logout();
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
            'id_user' => auth('sellers')->user()->id,
            'm_name' => gethostname(),
            'os' => php_uname(),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('sellers')->factory()->getTTL() * 60,
            'role' => 'seller'
        ]);
    }

    public function verifyAccess(Request $request) 
    {
        SellerAccess::create($request->all());
    }
    
}
