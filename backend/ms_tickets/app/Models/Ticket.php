<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $table = "tickets";

    protected $fillable = [
        "titulo",
        "descripcion",
        "estado",
        "gestor_id",
        "admin_id"
    ];

    public function actividades() {
        return $this->hasMany(TicketActividad::class, "ticket_id");
    }
}
