<template>


    <div class="container">
        <!-- premier child -->
        <div class="row justify-content-center" v-if="$gate.isRelex()">
        </div>

        <!-- deuxieme child -->
        <center><div class="col-md-8" v-if="!$gate.isRelex()">
               <not-found></not-found>>
        </div></center>

        <!-- troisieme child -->
       <div class="row mt-5" v-if="$gate.isRelex()" >
          <div class="col-md-12">
            <div class="card">

             <div class="card-header">
                 <h3 class="card-title">Traitement des demandes</h3>
                   <div class="card-tools">  
                       <a class="nav-link" data-toggle="dropdown" href="#"> 
                         <i class="nav-icon fas fa-bell"></i> 
                        <span class="badge badge-warning navbar-badge"></span>
                        </a> 
                        <li class="nav-item dropdown" >
 
                          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span> </span>
                          </div> 
                       </li>         
                   </div>                   
             </div>



              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                 <table class="table table-hover">
                <tbody>
                <tr>
                  <th>ID</th>
                  <th>Effectuée par</th>
                  <th>Destinataire</th>
                  <th>Objet</th>
                  <th>Noms des missionaires</th>
                  <th>Effectuée le</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>

                <tr v-for="Missione in missiones.data" :key="Missione.id">
                    <td>{{Missione.id}}</td>
                    <td>{{Missione.Demandeeffectueepar}}</td>
                    <td>{{Missione.Destinataire}}</td>
                    <td>{{Missione.Objetdelamission}}</td>
                    <td>{{Missione.Nomsmissionaires }}</td>
                    <td>{{Missione.created_at }}</td>

                  <td><span >En cours</span></td>
                    
                      <td>
                       <a href="#" @click="editModal(Missione)">
                         <i class="fa fa-edit blue"></i>
                       </a>     
                      <a href="#" @click="deleteMissione(Missione.id)">
                         <i class="fa fa-trash red"></i>
                      </a>  
                      </td>
                      
                </tr>
                 
              </tbody></table>
            </div>
            <!-- /.box-body -->
            <div class="card-footer">
              <pagination :data="missiones" @pagination-change-page="getResults"></pagination>

              </div>
               

          </div>
          <!-- /.box -->
        </div>
      </div>

        <!-- third child -->
<!-- Modal -->
<div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="AddNew" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editmode" id="AddNewLabel">Récaputilatif de la mission</h5>
        <h5 class="modal-title" v-show="editmode" id="AddNewLabel">Demande de traitement 1/2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form @submit.prevent="editmode ? updateMissione() : createMissione()" style="font-size: 10px;">
      <div class="modal-body">
          <!-- premiere ligne -->
        <div class="form-row">
          <div class="form-group col-md-3">
           <label>Direction</label>
           <input v-model="form.Direction" type="text" name="Direction"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Direction') }" disabled>
           <has-error :form="form" field="Direction"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Département</label>
           <input v-model="form.Departement" type="text" name="Departement"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Departement') }" disabled>
           <has-error :form="form" field="Departement"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Demandes effectuée par</label>
           <input v-model="form.Demandeeffectueepar" type="text" name="Demandeeffectueepar"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Demandeeffectueepar') }" disabled>
           <has-error :form="form" field="Demandeeffectueepar"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Compte analytique</label>
           <input v-model="form.Compteanalytique" type="text" name="Compteanalytique"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Compteanalytique') }" disabled>
           <has-error :form="form" field="Compteanalytique"></has-error>
          </div>
       </div>

       <!-- deuxieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Date demande</label>
           <input v-model="form.Datedemande" type="Date" name="Datedemande"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Datedemande') }" disabled>
           <has-error :form="form" field="Datedemande"></has-error>
          </div>
          <div class="form-group col-md-6">
           <label>Destinataire</label>
           <input v-model="form.Destinataire" type="text" name="Destinataire"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Destinataire') }" disabled>
           <has-error :form="form" field="Destinataire"></has-error>
          </div>
       </div>

       <!-- troisieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
           <label>Période de la mission du</label>
           <input v-model="form.Periodedelamissionde" type="Date" name="Periodedelamissionde"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Periodedelamissionde') }" disabled>
           <has-error :form="form" field="Periodedelamissionde"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Au</label>
           <input v-model="form.Au" type="Date" name="Au"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Au') }" disabled>
           <has-error :form="form" field="Au"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Nombre de jours</label>
           <input v-model="form.Nombredejours" type="number" name="Nombredejours"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Nombredejours') }" disabled>
           <has-error :form="form" field="Nombredejours"></has-error>
          </div>
       </div>

       <!-- quatrieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
           <label>Objet de la mission</label>
           <input v-model="form.Objetdelamission" type="text" name="Objetdelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Objetdelamission') }" disabled>
           <has-error :form="form" field="Objetdelamission"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Lieu de la mission</label>
           <input v-model="form.Lieudelamission" type="text" name="Lieudelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Lieudelamission') }" disabled>
           <has-error :form="form" field="Lieudelamission"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Pays</label>
           <input v-model="form.Pays" type="text" name="Pays"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Pays') }" disabled>
           <has-error :form="form" field="Pays"></has-error>
          </div>
       </div>

       <!-- (5eme) ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Cadre de la mission</label>
           <input v-model="form.Cadredelamission" type="text" name="Cadredelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Cadredelamission') }" disabled>
           <has-error :form="form" field="Cadredelamission"></has-error>
          </div>
          <div class="form-group col-md-6">
           <label>Information complémentaire</label>
           <input v-model="form.Informationcomplementaire" type="text" name="Informationcomplementaire"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Informationcomplementaire') }" disabled>
           <has-error :form="form" field="Informationcomplementaire"></has-error>
          </div>
       </div>

       <!-- 6 ligne -->
        <div class="form-row">
          <div class="form-group col-md-12">
           <label>Noms des missionnaires</label>
           <textarea v-model="form.Nomsmissionaires" type="text" name="Nomsmissionaires"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Nomsmissionaires') }" disabled> </textarea>
           <has-error :form="form" field="Nomsmissionaires"></has-error>
          </div>
       </div>

       <!-- 7 ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
          <label>Situation visa</label>    
      <select name="Situationvisa" v-model="form.Situationvisa" id="Situationvisa" 
        class="form-control" :class="{ 'is-invalid': form.errors.has('Situationvisa') }" disabled>
        <option value="">Choisissez</option>
        <option value="Expire">Expiré</option>
        <option value="Expire">Expiré</option>
        </select>
      <has-error :form="form" field="Situationvisa"></has-error>
    </div>
          <div class="form-group col-md-4">
           <label>Information complémentaire visa</label>
           <input v-model="form.Informationcomplementairevisa" type="text" name="Informationcomplementairevisa"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Informationcomplementairevisa') }" disabled>
           <has-error :form="form" field="Informationcomplementairevisa"></has-error>
          </div>
           <div class="form-group col-md-4">
           <label>Date expiration des passeports</label>
           <input v-model="form.Dateexpirationdespasseports" type="date" name="Dateexpirationdespasseports"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Dateexpirationdespasseports') }" disabled>
           <has-error :form="form" field="Dateexpirationdespasseports"></has-error>
          </div>
       </div>

       <!-- 8eme ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Objectifs de la mission</label>
           <input v-model="form.Objectifsdelamission" type="text" name="Objectifsdelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Objectifsdelamission') }" disabled>
           <has-error :form="form" field="Objectifsdelamission"></has-error>
          </div>
           <div class="form-group col-md-6">
           <label>Opportunité mission</label>
           <input v-model="form.Opportunitemission" type="text" name="Opportunitemission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Opportunitemission') }" disabled>
           <has-error :form="form" field="Opportunitemission"></has-error>
          </div>

                     <div class="form-group col-md-6">
           <label>Opportunité mission</label>
           <input v-model="form.Opportunitemission" type="text" name="Opportunitemission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Opportunitemission') }" disabled>
           <has-error :form="form" field="Opportunitemission"></has-error>
          </div>

                     <div class="form-group col-md-6">
           <label>Opportunité mission</label>
           <input v-model="form.Opportunitemission" type="text" name="Opportunitemission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Opportunitemission') }" disabled>
           <has-error :form="form" field="Opportunitemission"></has-error>
          </div>
       </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="nextModal()">Suivant</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Enregistrer</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="nextModals" tabindex="-1" role="dialog" aria-labelledby="AddNew" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editmode" id="AddNewLabel">Traiter la mission</h5>
        <h5 class="modal-title" v-show="editmode" id="AddNewLabel">Demande de traitement 2/2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form @submit.prevent="editmode ? updateMissione() : createMissione()" style="font-size: 10px;">
      <div class="modal-body">
          <!-- premiere ligne -->
        <div class="form-row">
          <div class="form-group col-md-3">
           <label>N° BC</label>
           <input type="number" name="nBC"
            class="form-control" :class="{ 'is-invalid': form.errors.has('nBC') }">
           <has-error :form="form" field="nBC"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Date BC</label>
           <input type="date" name="dateBC"
            class="form-control" :class="{ 'is-invalid': form.errors.has('dateBC') }" >
           <has-error :form="form" field="dateBC"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Région</label>
           <input type="text" name="region"
            class="form-control" :class="{ 'is-invalid': form.errors.has('region') }" >
           <has-error :form="form" field="region"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Nom Hotel</label>
           <input type="text" name="nomHotel"
            class="form-control" :class="{ 'is-invalid': form.errors.has('nomHotel') }">
           <has-error :form="form" field="nomHotel"></has-error>
          </div>
       </div>

       <!-- deuxieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Objet BC</label>
           <input type="text" name="objetBC"
            class="form-control" :class="{ 'is-invalid': form.errors.has('objetBC') }" >
           <has-error :form="form" field="objetBC"></has-error>
          </div>
          <div class="form-group col-md-6">
           <label>Nom missionnaire</label>
           <input type="text" name="NomM"
            class="form-control" :class="{ 'is-invalid': form.errors.has('NomM') }" >
           <has-error :form="form" field="NomM"></has-error>
          </div>
       </div>

       <!-- troisieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
           <label>Séjour du</label>
           <input type="Date" name="SejourDu"
            class="form-control" :class="{ 'is-invalid': form.errors.has('SejourDu') }">
           <has-error :form="form" field="SejourDu"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Au</label>
           <input type="Date" name="Au"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Au') }" >
           <has-error :form="form" field="Au"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Nombre de nuitée</label>
           <input type="number" name="nuitee"
            class="form-control" :class="{ 'is-invalid': form.errors.has('nuitee') }">
           <has-error :form="form" field="nuitee"></has-error>
          </div>
       </div>

       <!-- quatrieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
		      <label>Prestation hébergement</label>    
		      <select name="hebergement" id="hebergement" 
		        class="form-control" :class="{ 'is-invalid': form.errors.has('hebergement') }">
		        <option value="Expire">Chambre double</option>
		        <option value="Expire">Chambre single</option>
		        </select>
		      <has-error :form="form" field="hebergement"></has-error>
		   </div>
          <div class="form-group col-md-4">
		      <label>Prestation réstauration</label>    
		      <select name="restauration" id="restauration" 
		        class="form-control" :class="{ 'is-invalid': form.errors.has('restauration') }">
		        <option value="Expire">Aucune</option>
		        <option value="Expire">Petit déjeuner - Diner</option>
		        <option value="Expire">Tout inclus</option>
		        </select>
		      <has-error :form="form" field="restauration"></has-error>
		  </div>
          <div class="form-group col-md-4">
		      <label>Billeterie - Compagnies</label>    
		      <select name="billeterie" id="billeterie" 
		        class="form-control" :class="{ 'is-invalid': form.errors.has('billeterie') }">
		        <option value="Expire">Aucune</option>
		        <option value="Expire">AIR ALGERIE</option>
		        <option value="Expire">TASSILI AIR LINES</option>
		        </select>
		      <has-error :form="form" field="billeterie"></has-error>
		  </div>
       </div>

       <!-- (5eme) ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
           <label>Réf. BC</label>
           <input type="text" name="refBC"
            class="form-control" :class="{ 'is-invalid': form.errors.has('refBC') }">
           <has-error :form="form" field="refBC"></has-error>
          </div>

          <div class="form-group col-md-4">
           <label>Date BC</label>
           <input type="date" name="dateBC"
            class="form-control" :class="{ 'is-invalid': form.errors.has('dateBC') }">
           <has-error :form="form" field="dateBC"></has-error>
          </div>

          <div class="form-group col-md-4">
           <label>Région de déstination</label>
           <input type="text" name="RegionDest"
            class="form-control" :class="{ 'is-invalid': form.errors.has('RegionDest') }">
           <has-error :form="form" field="RegionDest"></has-error>
          </div>
       </div>

       <!-- 6 ligne -->
        <div class="form-row">

          <div class="form-group col-md-4">
           <label>Type trajet</label>
           <input type="text" name="TypeTrajet"
            class="form-control" :class="{ 'is-invalid': form.errors.has('TypeTrajet') }">
           <has-error :form="form" field="TypeTrajet"></has-error>
          </div>

          <div class="form-group col-md-4">
           <label>Trajet</label>
           <input type="text" name="Trajet"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Trajet') }">
           <has-error :form="form" field="Trajet"></has-error>
          </div>

            <div class="form-group col-md-4">
		      <label>Classe</label>    
		      <select name="classe" id="classe" 
		        class="form-control" :class="{ 'is-invalid': form.errors.has('classe') }">
		        <option value="Expire">Aucune</option>
		        <option value="Expire">Economique</option>
		        <option value="Expire">Affaire</option>
		        <option value="Expire">Première classe</option>
		        </select>
		      <has-error :form="form" field="classe"></has-error>
		  </div>
       </div>

       <!-- 7 ligne -->
      <div class="form-row">
       	  <div class="form-group col-md-4">
           <label>Objet BC</label>
           <input type="text" name="ObjetBC"
            class="form-control" :class="{ 'is-invalid': form.errors.has('ObjetBC') }">
           <has-error :form="form" field="ObjetBC"></has-error>
          </div>

           <div class="form-group col-md-4">
           <label>Date de départ</label>
           <input type="date" name="DateDepart"
            class="form-control" :class="{ 'is-invalid': form.errors.has('DateDepart') }" >
           <has-error :form="form" field="DateDepart"></has-error>
          </div>

          <div class="form-group col-md-4">
           <label>Date de retour</label>
           <input type="date" name="DateRetour"
            class="form-control" :class="{ 'is-invalid': form.errors.has('DateRetour') }" >
           <has-error :form="form" field="DateRetour"></has-error>
          </div>

       </div>

       <!-- 8eme ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Nom missionnaire</label>
           <input type="text" name="NomMiss"
            class="form-control" :class="{ 'is-invalid': form.errors.has('NomMiss') }">
           <has-error :form="form" field="NomMiss"></has-error>
          </div>
           <div class="form-group col-md-6">
           <label>Compte analytique</label>
           <input type="text" name="CompteAnal"
            class="form-control" :class="{ 'is-invalid': form.errors.has('CompteAnal') }">
           <has-error :form="form" field="CompteAnal"></has-error>
          </div>

       </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="prevModal()">Retour</button>
        <button type="button" class="btn btn-primary" @click="nextModal()">Terminer</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        
      </div>
      </form>
    </div>
  </div>
</div>

    </div>
</template>

<script>
import Form from 'vform';
    export default {
        data() {
          return {
            editmode: true,
            missiones : {},
              form: new Form({
                 id: '',
                 Direction: '',
                 Departement: '',
                 Demandeeffectueepar: '',
                 Compteanalytique: '',
                 Datedemande: '',
                 Destinataire: '',
                 Periodedelamissionde: '',
                 Au: '',
                 Nombredejours: '',
                 Objetdelamission: '',
                 Lieudelamission: '',
                 Pays: '',
                 Cadredelamission: '',
                 Informationcomplementaire: '',
                 Nomsmissionaires: '',
                 Situationvisa: '',
                 Informationcomplementairevisa: '',
                 Dateexpirationdespasseports: '',
                 Objectifsdelamission: '',
                 Opportunitemission:''

              })
            }
        },
   methods: {
          getResults(page = 1) {
			axios.get('api/missione?page=' + page)
				.then(response => {
					this.missiones = response.data;
				});
		},  


          updateMissione(){
            this.$Progress.start();
            this.form.put('api/missione/'+this.form.id)
            .then(() => {
              $('#AddNew').modal('hide');
              swal.fire(
               'Modifié!',
               'mission mise à jour.',
               'success'  
             )
             this.$Progress.finish();
             Fire.$emit('AfterCreate');

            })
            .catch(() => {
              this.$Progress.fail();
            });
          },
          editModal(missione){
           this.editmode = true;
           this.form.reset();
           $('#AddNew').modal('show');
           this.form.fill(missione);
 
          },
          newModal(){
           this.editmode = false;
           this.form.reset();
           $('#AddNew').modal('show');
          },
          nextModal(){
           this.editmode = true;
           $('#AddNew').modal('hide');
           $('#nextModals').modal('show');
          },
          prevModal(){
           this.editmode = true;
           $('#AddNew').modal('show');
           $('#nextModals').modal('hide');
          },
        deleteMissione(id){
            swal.fire({
           title: 'Êtes-vous sûr?',
           text: "You won't be able to revert this!",
           icon: 'warning',
           showCancelButton: true,
           cancelButtonText: 'Annuler',
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Oui'
          }).then((result) => {
            // envoyer une requete au serveur
            if (result.value) {
            this.form.delete('api/missione/'+id).then(() => {
               swal.fire(
               'Supprimé!',
               'mission a été supprimé.',
               'success'  
             )
             Fire.$emit('AfterCreate');
           }).catch(() => {
             swal("Failed","someting wrong","warning");
           });
           }
          })
        },
          loadMissiones(){
            axios.get("api/missione").then(({data}) => (this.missiones = data));
            
          },

        createMissione(){
         this.$Progress.start();

         this.form.post('api/missione')
         .then(() => {
         Fire.$emit('AfterCreate');
         $('#AddNew').modal('hide')

         Toast.fire({
            icon: 'success',
            title: 'Mission créé!'
          })
         this.$Progress.finish();
        })
        .catch(() =>{
           this.$Progress.fail(); 
        })
        }

        },
        created() {
            Fire.$on('searching',() => {
              let query = this.$parent.search;
              axios.get('api/findMissione?q=' + query)  
              .then((data) => {
                 this.missiones = data.data
              })
              .catch(() => { 

              })
            })       

            this.loadMissiones();
            Fire.$on('AfterCreate', () => {
            this.loadMissiones(); 
            });
        }
    }
</script>