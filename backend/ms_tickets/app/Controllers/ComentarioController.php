<?php
namespace App\Controllers;

use App\Models\TicketActividad;

class ComentarioController {

    public function comentar($request, $response)
    {
        $d = $request->getParsedBody();

        $actividad = TicketActividad::create([
            "ticket_id" => $d["ticket_id"],
            "user_id"   => $d["user_id"],
            "mensaje"   => $d["mensaje"]
        ]);

        $response->getBody()->write(json_encode($actividad));
        return $response;
    }

    public function historial($request, $response)
    {
        $ticket_id = $request->getQueryParams()["ticket_id"];
        $actividades = TicketActividad::where("ticket_id", $ticket_id)->get();

        $response->getBody()->write(json_encode($actividades));
        return $response;
    }
}
