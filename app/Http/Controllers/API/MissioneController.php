<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Missione;

class MissioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return Missione::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'Direction' => 'required|string|max:191',
            'Departement' => 'required|string|max:191',
            'Demandeeffectueepar' => 'required|string|max:191',
            'Compteanalytique' => 'required|string|max:191',
            'Datedemande' => 'required|string|max:191',
            'Destinataire' => 'required|string|max:191',
            'Periodedelamissionde' => 'required|string|max:191',
            'Au' => 'required|string|max:191',
            'Nombredejours' => 'required|string|max:191',
            'Objetdelamission' => 'required|string|max:191',
            'Lieudelamission' => 'required|string|max:191',
            'Pays' => 'required|string|max:191',
            'Cadredelamission' => 'required|string|max:191',
            'Nomsmissionaires' => 'required|string|max:191',
            'Situationvisa' => 'required|string|max:191',
            'Dateexpirationdespasseports' => 'required|string|max:191',
            'Objectifsdelamission' => 'required|string|max:191'

        ]);


        return Missione::Create([
            'Direction' => $request['Direction'],
            'Departement' => $request['Departement'],
            'Demandeeffectueepar' => $request['Demandeeffectueepar'],
            'Compteanalytique' => $request['Compteanalytique'],
            'Datedemande' => $request['Datedemande'],
            'Destinataire' => $request['Destinataire'],
            'Periodedelamissionde' => $request['Periodedelamissionde'],
            'Au' => $request['Au'],
            'Nombredejours' => $request['Nombredejours'],
            'Objetdelamission' => $request['Objetdelamission'],
            'Lieudelamission' => $request['Lieudelamission'],
            'Pays' => $request['Pays'],
            'Cadredelamission' => $request['Cadredelamission'],
            'Informationcomplementaire' => $request['Informationcomplementaire'],
            'Nomsmissionaires' => $request['Nomsmissionaires'],
            'Situationvisa' => $request['Situationvisa'],
            'Informationcomplementairevisa' => $request['Informationcomplementairevisa'],
            'Dateexpirationdespasseports' => $request['Dateexpirationdespasseports'],
            'Objectifsdelamission' => $request['Objectifsdelamission'],
            'Opportunitemission' => $request['Opportunitemission'],
             ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        

        $missione->get();
        return ['message'  => 'Mission showé' ]; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $missione = Missione::findOrFail($id);
        $this->validate($request,[
            'Direction' => 'string|max:191',
            'Departement' => 'required|string|max:191',
            'Demandeeffectueepar' => 'required|string|max:191',
            'Compteanalytique' => 'required|string|max:191',
            'Datedemande' => 'required|string|max:191',
            'Destinataire' => 'required|string|max:191',
            'Periodedelamissionde' => 'required|string|max:191',
            'Au' => 'required|string|max:191',
            'Nombredejours' => 'required|integer|max:191',
            'Objetdelamission' => 'required|string|max:191',
            'Lieudelamission' => 'required|string|max:191',
            'Pays' => 'required|string|max:191',
            'Cadredelamission' => 'required|string|max:191',
            'Informationcomplementaire' => 'required|string|max:191',
            'Nomsmissionaires' => 'required|string|max:191',
            'Situationvisa' => 'required|string|max:191',
            'Informationcomplementairevisa' => 'required|string|max:191',
            'Dateexpirationdespasseports' => 'required|string|max:191',
            'Objectifsdelamission' => 'required|string|max:191',
            'Opportunitemission' => 'required|string|max:191'

        ]);

        $missione->update($request->all());
        return ['message' => 'Updated the user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $missione = Missione::findOrFail($id);
        // supprimer l'utilisateur
        $missione->delete();
        return ['message'  => 'Mission supprimée' ]; 
    }


 public function search(){

    if ($search = \Request::get('q')) {
        $missiones = Missione::where(function($query) use ($search){
            $query->where('direction','LIKE',"$search")
            ->orWhere('Departement','LIKE',"$search")
            ->orWhere('Demandeeffectueepar','LIKE',"$search")
            ->orWhere('Compteanalytique','LIKE',"$search")
            ->orWhere('Datedemande','LIKE',"$search")
            ->orWhere('Destinataire','LIKE',"$search")
            ->orWhere('Periodedelamissionde','LIKE',"$search")
            ->orWhere('Au','LIKE',"$search")
            ->orWhere('Nombredejours','LIKE',"$search")
            ->orWhere('Objetdelamission','LIKE',"$search")
            ->orWhere('Lieudelamission','LIKE',"$search")
            ->orWhere('Pays','LIKE',"$search")
            ->orWhere('Cadredelamission','LIKE',"$search")
            ->orWhere('Informationcomplementaire','LIKE',"$search")
            ->orWhere('Nomsmissionaires','LIKE',"$search")
            ->orWhere('Situationvisa','LIKE',"$search")
            ->orWhere('Informationcomplementairevisa','LIKE',"$search")
            ->orWhere('Dateexpirationdespasseports','LIKE',"$search")
            ->orWhere('Objectifsdelamission','LIKE',"$search")
            ->orWhere('Opportunitemission','LIKE',"$search");

        })->paginate(20);
    }else{
        $missiones = Missione::paginate(5);
    }
    return $missiones;
} 
} 