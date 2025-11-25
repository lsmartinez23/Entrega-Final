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
            return $this->responseError("Token no enviado", 401);
        }

        $existe = AuthToken::where("token", $token)->first();

        if (!$existe) {
            return $this->responseError("Token inválido", 403);
        }

        return $handler->handle($request);
    }

    private function responseError($msg, $code)
    {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode(["error" => $msg]));
        return $response->withStatus($code)->withHeader("Content-Type", "application/json");
    }
}
