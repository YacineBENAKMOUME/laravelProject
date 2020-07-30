<?php
namespace App;

use App\Notifications\DemandeTraitement;
use Illuminate\Database\Eloquent\Model;
use ilIlluminate\Support\facades\Notification;
use Illuminate\Notifications\Notifiable;



class Missione extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Direction', 'Departement', 'Demandeeffectueepar', 'Compteanalytique', 'Datedemande', 'Destinataire', 'Periodedelamissionde', 'Au', 'Nombredejours', 'Objetdelamission', 'Lieudelamission', 'Pays', 'Cadredelamission', 'Informationcomplementaire', 'Nomsmissionaires', 'Situationvisa', 'Informationcomplementairevisa', 'Dateexpirationdespasseports', 'Objectifsdelamission', 'Opportunitemission'
    ];

    public static function boot()
    { 
       parent::boot();
       static::Created(function($model){ 

        $user = User::find(2);
        $user->notify(new DemandeTraitement($model)); 

       }); 
    } 

}