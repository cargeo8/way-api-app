<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\WayApp\Auth\RegisterRequest;
use App\Http\Requests\WayApp\Auth\UpdateUser;
use App\Http\Services\ClienteService;
use App\Http\Services\CuentasService;
use App\Models\Control;
use App\Models\Role;
use App\Models\TipoAutorizacion;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{
    public function __construct(
        private ClienteService $_clientes,
        private CuentasService $_cuentas
    ) {}
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
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $newUserName =  str_replace(" ", "_", $data["names"]) . time();
            $data["personId"] = str_replace("-", "", $data["personId"]);

            if (User::where("email", $data["email"])->exists())
                return response()->json([
                    "message" => "Ya existe un usuario registrado con el mismo correo"
                ], 400);
            if (User::where("person_id", $data["personId"])->exists())
                return response()->json([
                    "message" => "Ya existe un usuario registrado con el mismo documento"
                ], 400);

            $codclienteRequest = $this->_clientes->SearchClientByPersonID(
                id_type: $data["IdType"],
                person_id: $data["personId"]
            );

            $codClienteJson = $codclienteRequest->json();

            if ($codclienteRequest->failed())
                return response()->json($codClienteJson, $codclienteRequest->status());

            if (User::where("codigo_cliente", $codClienteJson["codigo_cliente"])->exists())
                return response()->json([
                    "message" => "Ya existe un usuario registrado con el mismo cliente"
                ], 400);

            $cuentas = collect($this->_cuentas->GetCuentasByPersonId(
                person_id: $data["personId"],
                id_type: $data["IdType"]
            )->json());

            $cuentaSelected = $cuentas->where("factura", $data["invoice"])
                ->where("feccto", $data["invoiceDate"])->first();

            if (!$cuentaSelected)
                return response()->json([
                    "message" => "No se encontró la cuenta con la factura y fecha proporcionadas"
                ], 400);





            if ($codclienteRequest->failed())
                return response()->json($codClienteJson, $codclienteRequest->status());
            // $factura = $cuentas->orderBy("id", "desc")->first();




            $dataForUser =  [
                "name" => $newUserName,
                "email" => $data["email"],
                "password" => Hash::make($data["password"]),
                "codigo_cliente" => $codClienteJson["codigo_cliente"],
                "names" => $data["names"],
                "surnames" => $data["surnames"],
                "id_type" => $data["IdType"],
                "person_id" => $data["personId"],
            ];
            $createdUser = User::create(
                $dataForUser
            );

            try {
                $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
                $dataMail = [
                    "registrationCode" => $code
                ];
                $correo_origen = "sistemas@portalagenciasway.com";
                $correo_vista = "emails.registerCode";
                $correo_subject = "Bienvenido a la aplicación de Agencias Way El Salvador";
                $direccionCorreo = $data["email"];
                $correo_origen_name = "Equipo de Agencias Way El Salvador";
                $con_copia = [];
                Mail::send($correo_vista, $dataMail, function ($message) use ($correo_subject, $con_copia, $direccionCorreo, $correo_origen, $correo_origen_name) {
                    $message->to($direccionCorreo, $direccionCorreo)
                        ->cc($con_copia)
                        ->from($correo_origen, $correo_origen_name)
                        ->subject($correo_subject);
                });
                $createdUser->verification_code = $code;
                $createdUser->save();
            } catch (\Throwable $th) {
                return response()->json([
                    "message" => "Error al enviar el correo de verificación",
                    "error" => $th->getMessage()
                ], 500);
            }
            DB::commit();
            return response()->json(["message" => "Has creado tu cuenta con éxito", "id" => $createdUser->id]);
        } catch (Exception $th) {
            return response()->json([
                "message" => "Error al crear el usuario",
                "error" => $th->getMessage()
            ], 500);
        }
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

    public function resendVerificationCode(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'El usuario ya está verificado'], 400);
        }

        // Generar nuevo código de verificación
        $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $user->verification_code = $code;
        $user->save();

        // Enviar correo con el nuevo código
        $data = [
            "registrationCode" => $code
        ];
        $correo_origen = "sistemas@portalagenciasway.com";
        $correo_vista = "emails.registerCode";
        $correo_subject = "Código de verificación - Agencias Way El Salvador";
        $direccionCorreo = $user->email;
        $correo_origen_name = "Equipo de Agencias Way El Salvador";
        $con_copia = [];

        try {
            Mail::send($correo_vista, compact('data'), function ($message) use ($correo_subject, $con_copia, $direccionCorreo, $correo_origen, $correo_origen_name) {
                $message->to($direccionCorreo, $direccionCorreo)
                    ->cc($con_copia)
                    ->from($correo_origen, $correo_origen_name)
                    ->subject($correo_subject);
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => 'No se pudo enviar el correo de verificación'], 500);
        }

        return response()->json(['message' => 'Código de verificación reenviado correctamente', "id" => $user->id]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'verification_code' => 'required|string|max:6'
        ]);

        $user = User::find($request->user_id);

        if ($user->verification_code !== $request->verification_code) {
            return response()->json(['message' => 'Código de verificación incorrecto'], 400);
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();
        return response()->json(['message' => 'Usuario verificado correctamente']);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            "currentPassword" => "required|string",
            "newPassword" => "required|string",
        ]);
        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['message' => 'La contraseña actual proporcionada es incorrecta'], 400);
        }
        if ($request->currentPassword === $request->newPassword) {
            return response()->json(['message' => 'La nueva contraseña no puede ser igual a la actual'], 400);
        }
        $user->password = Hash::make($request->newPassword);
        $user->save();
        // Revocar todos los tokens del usuario
        $user->tokens()->each(function ($token) {
            $token->revoke();
        });

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }

    public function recoverAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe, NO notificar si no existe para evitar revelar información
        if ($user) {
            // Generar nuevo código de verificación
            $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            $user->recovery_code = $code;
            $user->save();

            $data = [
                "registrationCode" => $code
            ];
            $correo_origen = "sistemas@portalagenciasway.com";
            $correo_vista = "emails.recoveryCode";
            $correo_subject = "Código de verificación - Agencias Way El Salvador";
            $direccionCorreo = $user->email;
            $correo_origen_name = "Equipo de Agencias Way El Salvador";
            $con_copia = [];

            try {
                Mail::send($correo_vista, $data, function ($message) use ($correo_subject, $con_copia, $direccionCorreo, $correo_origen, $correo_origen_name) {
                    $message->to($direccionCorreo, $direccionCorreo)
                        ->cc($con_copia)
                        ->from($correo_origen, $correo_origen_name)
                        ->subject($correo_subject);
                });
            } catch (\Throwable $th) {
                // return response()->json(['message' => 'No se pudo enviar el correo de verificación'], 500);
            }
        }
        return response()->json(['message' => 'Se ha enviado un código de recuperación']);
    }

    public function validateRecoveryCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'recovery_code' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe, el mensaje de error es el mismo para evitar revelar información
        if (!$user) {
            return response()->json(['message' => 'Código de recuperación incorrecto'], 404);
        }

        if ($user->recovery_code !== $request->recovery_code) {
            return response()->json(['message' => 'Código de recuperación incorrecto'], 404);
        }


        return response()->json(['message' => 'Código de recuperación válido']);
    }

    public function ChangePassworForRecoveryCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'recovery_code' => 'required|string',
            'newPassword' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe, el mensaje de error es el mismo para evitar revelar información
        if (!$user) {
            return response()->json(['message' => 'Código de recuperación incorrecto'], 404);
        }

        if ($user->recovery_code !== $request->recovery_code) {
            return response()->json(['message' => 'Código de recuperación incorrecto'], 404);
        }

        $user->password = Hash::make($request->newPassword);
        $user->recovery_code = null;
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }
}
