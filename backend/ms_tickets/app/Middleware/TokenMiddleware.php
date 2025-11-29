<?php
namespace App\Middleware;

use App\Models\AuthToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TokenMiddleware {

    public function __invoke(ServerRequestInterface $request, $handler): ResponseInterface
    {
        $token = $request->getHeaderLine("token");

        if (!$token) {
            return $this->error("Token no enviado", 401);
        }


        $existe = \App\Models\AuthToken::where("token", $token)->first();

        if (!$existe) {
            return $this->error("Token inválido", 403);
        }

        return $handler->handle($request);
    }

    private function error($msg, $status)
    {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode(["error" => $msg]));
        return $response->withHeader("Content-Type", "application/json")
                        ->withStatus($status);
    }
}
