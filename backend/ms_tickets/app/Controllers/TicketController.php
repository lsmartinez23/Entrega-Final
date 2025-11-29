<?php
namespace App\Controllers;

use App\Models\Ticket;
use App\Models\TicketActividad;

class TicketController {


    public function crear($request, $response)
    {
        $d = $request->getParsedBody();

        $ticket = Ticket::create([
            "titulo"     => $d["titulo"],
            "descripcion" => $d["descripcion"],
            "gestor_id"   => $d["gestor_id"],
            "estado"      => "abierto"
        ]);

        TicketActividad::create([
            "ticket_id" => $ticket->id,
            "user_id"   => $d["gestor_id"],
            "mensaje"   => "Ticket creado"
        ]);

        $response->getBody()->write(json_encode($ticket));
        return $response;
    }


    public function misTickets($request, $response)
    {
        $gestor_id = $request->getQueryParams()["gestor_id"];
        $tickets = Ticket::where("gestor_id", $gestor_id)->get();

        $response->getBody()->write(json_encode($tickets));
        return $response;
    }

    public function listarTodos($request, $response)
    {
        $tickets = Ticket::all();
        $response->getBody()->write(json_encode($tickets));
        return $response;
    }


    public function cambiarEstado($request, $response)
    {
        $d = $request->getParsedBody();
        $ticket = Ticket::find($d["ticket_id"]);

        if (!$ticket) {
            return $response->withStatus(404);
        }

        $ticket->estado = $d["estado"];
        $ticket->save();

        TicketActividad::create([
            "ticket_id" => $ticket->id,
            "user_id"   => $d["admin_id"],
            "mensaje"   => "Estado cambiado a {$d['estado']}"
        ]);

        $response->getBody()->write(json_encode(["msg" => "Estado actualizado"]));
        return $response;
    }


    public function asignar($request, $response)
    {
        $d = $request->getParsedBody();
        $ticket = Ticket::find($d["ticket_id"]);

        $ticket->admin_id = $d["admin_id"];
        $ticket->save();

        TicketActividad::create([
            "ticket_id" => $ticket->id,
            "user_id"   => $d["admin_id"],
            "mensaje"   => "Ticket asignado a administrador"
        ]);

        $response->getBody()->write(json_encode(["msg" => "Ticket asignado"]));
        return $response;
    }
}
