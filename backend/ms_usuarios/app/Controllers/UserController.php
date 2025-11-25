<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\AuthToken;

class UserController {

    public function registrar($request, $response)
    {
        $data = $request->getParsedBody();

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => $data["password"],
            "role" => "gestor"
        ]);

        $response->getBody()->write(json_encode($user));
        return $response;
    }

    public function login($request, $response)
    {
        $data = $request->getParsedBody();

        $user = User::where("email", $data["email"])
                    ->where("password", $data["password"])
                    ->first();

        if (!$user) {
            return $response->withStatus(401)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode(["error" => "Credenciales incorrectas"]));
        }

        $token = bin2hex(random_bytes(20));

        AuthToken::updateOrCreate(
            ["user_id" => $user->id],
            ["token" => $token]
        );

        $response->getBody()->write(json_encode([
            "token" => $token,
            "role" => $user->role
        ]));
        return $response;
    }

    public function logout($request, $response)
    {
        $token = $request->getHeaderLine("token");
        AuthToken::where("token", $token)->delete();

        $response->getBody()->write(json_encode(["msg" => "Sesión cerrada"]));
        return $response;
    }

    public function listar($request, $response)
    {
        $usuarios = User::all();
        $response->getBody()->write(json_encode($usuarios));
        return $response;
    }


    public function cambiarRol($request, $response)
    {
        $d = $request->getParsedBody();

        $user = User::find($d["user_id"]);
        $user->role = $d["nuevo_rol"];
        $user->save();

        $response->getBody()->write(json_encode(["msg" => "Rol actualizado"]));
        return $response;
    }
}
