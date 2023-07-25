<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\WayApp\Auth\RegisterRequest;
use App\Http\Requests\WayApp\Auth\UpdateUser;
use App\Http\Services\ClienteService;
use App\Models\Control;
use App\Models\Role;
use App\Models\TipoAutorizacion;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function __construct(private ClienteService $_clientes)
    {
    }
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|max:255',
            'password' => 'required'
        ]);

        $login = $request->only('email', 'password');

        if (!Auth::attempt($login)) {
            return response(['message' => 'Invalid login credential!!'], 401);
        }
        /**
         * @var User $user
         */
        $user = Auth::user();
        $token = $user->createToken($user->username);


        return response([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'token' => $token->accessToken,
            'token_expires_at' => $token->token->expires_at,
        ], 200);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'allDevice' => 'required'
        ]);

        /**
         * @var user $user
         */
        $user = Auth::user();
        if ($request->allDevice) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });
            return response(['message' => 'Logged out from all device !!'], 200);
        }

        $userToken = $user->token();
        $userToken->delete();
        return response(['message' => 'Logged Successful !!'], 200);
    }
    public function saveToken(Request $request)
    {
        User::where('id', Auth::user()->id)->update(['device_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $newUserName =  str_replace(" ", "_", $data["names"]) . time();
        $codclienteRequest = $this->_clientes->SearchClientByPersonID(
            id_type: $data["IdType"],
            person_id: $data["personId"]
        );
        $codClienteJson = $codclienteRequest->json();
        if ($codclienteRequest->failed())
            return response()->json($codClienteJson, $codclienteRequest->status());

        $dataForUser =  [
            "name" => $newUserName,
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
            "codigo_cliente" => $codClienteJson["codigo_cliente"],
            "names" => $data["names"],
            "surnames" => $data["surnames"],
            "id_type" => $data["IdType"],
            "person_id" => $data["personId"],
            // "codciud" => $data["city"],
            // "address" => $data["address"],
            // "phoneNumber" => $data["phone_number"],
        ];
        $createdUser = User::create(
            $dataForUser
        );
        return response()->json(["message" => "Has creado tu cuenta con éxito"]);
    }


    public function editUser(UpdateUser $request)
    {
        $data = $request->validated();
        $renameMap = [
            "userId" => "id",
            "IdType" => "id_type",
            "personId" => "person_id",
            "city" => "codciud",
            "address" => "address",
            "phoneNumber" => "phone_number",
            "email" => "email",
            "password" => "password",
            "status" => "status"
        ];

        $array = array_combine(array_map(function ($el) use ($renameMap) {
            return $renameMap[$el];
        }, array_keys($data)), array_values($data));

        DB::table("users")->where("id", $array["id"])->update($array);

        return response()->json(["message" => "Has actualizado tu usuario con éxito."]);
    }
}
