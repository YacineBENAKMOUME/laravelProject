<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isRst()"> 
        <div class="col-md-12"> 
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Liste des demandes de missions à l'étranger</h4>

              <div class="card-tools">
                <button class="btn btn-success" @click="newModal"> <i class="fas fa-plus fa-fw"></i>
                      Ajouter nouvelle mission 
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
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

                  <td><span class="label label-success">Traité</span></td>
                    
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
         <!-- second child -->
        <div class="col-md-8" v-if="!$gate.isRst()">
               <not-found></not-found>>
        </div> 

        <!-- third child -->
<!-- Modal -->
<div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="AddNew" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editmode" id="AddNewLabel">Ajouter mission</h5>
        <h5 class="modal-title" v-show="editmode" id="AddNewLabel">Mettre à jour </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form @submit.prevent="editmode ? updateMissione() : createMissione()">
      <div class="modal-body">
          <!-- premiere ligne -->
        <div class="form-row">
          <div class="form-group col-md-3">
           <label>Direction</label>
           <input v-model="form.Direction" type="text" name="Direction"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Direction') }">
           <has-error :form="form" field="Direction"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Département</label>
           <input v-model="form.Departement" type="text" name="Departement"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Departement') }">
           <has-error :form="form" field="Departement"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Demandes effectuée par</label>
           <input v-model="form.Demandeeffectueepar" type="text" name="Demandeeffectueepar"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Demandeeffectueepar') }">
           <has-error :form="form" field="Demandeeffectueepar"></has-error>
          </div>
          <div class="form-group col-md-3">
           <label>Compte analytique</label>
           <input v-model="form.Compteanalytique" type="text" name="Compteanalytique"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Compteanalytique') }">
           <has-error :form="form" field="Compteanalytique"></has-error>
          </div>
       </div>

       <!-- deuxieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Date demande</label>
           <input v-model="form.Datedemande" type="Date" name="Datedemande"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Datedemande') }">
           <has-error :form="form" field="Datedemande"></has-error>
          </div>
          <div class="form-group col-md-6">
           <label>Destinataire</label>
           <input v-model="form.Destinataire" type="text" name="Destinataire"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Destinataire') }">
           <has-error :form="form" field="Destinataire"></has-error>
          </div>
       </div>

       <!-- troisieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
           <label>Période de la mission du</label>
           <input v-model="form.Periodedelamissionde" type="Date" name="Periodedelamissionde"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Periodedelamissionde') }">
           <has-error :form="form" field="Periodedelamissionde"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Au</label>
           <input v-model="form.Au" type="Date" name="Au"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Au') }">
           <has-error :form="form" field="Au"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Nombre de jours</label>
           <input v-model="form.Nombredejours" type="number" name="Nombredejours"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Nombredejours') }">
           <has-error :form="form" field="Nombredejours"></has-error>
          </div>
       </div>

       <!-- quatrieme ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
           <label>Objet de la mission</label>
           <input v-model="form.Objetdelamission" type="text" name="Objetdelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Objetdelamission') }">
           <has-error :form="form" field="Objetdelamission"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Lieu de la mission</label>
           <input v-model="form.Lieudelamission" type="text" name="Lieudelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Lieudelamission') }">
           <has-error :form="form" field="Lieudelamission"></has-error>
          </div>
          <div class="form-group col-md-4">
           <label>Pays</label>
           <input v-model="form.Pays" type="text" name="Pays"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Pays') }">
           <has-error :form="form" field="Pays"></has-error>
          </div>
       </div>

       <!-- (5eme) ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Cadre de la mission</label>
           <input v-model="form.Cadredelamission" type="text" name="Cadredelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Cadredelamission') }">
           <has-error :form="form" field="Cadredelamission"></has-error>
          </div>
          <div class="form-group col-md-6">
           <label>Information complémentaire</label>
           <input v-model="form.Informationcomplementaire" type="text" name="Informationcomplementaire"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Informationcomplementaire') }">
           <has-error :form="form" field="Informationcomplementaire"></has-error>
          </div>
       </div>

       <!-- 6 ligne -->
        <div class="form-row">
          <div class="form-group col-md-12">
           <label>Noms des missionnaires</label>
           <textarea v-model="form.Nomsmissionaires" type="text" name="Nomsmissionaires"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Nomsmissionaires') }"> </textarea>
           <has-error :form="form" field="Nomsmissionaires"></has-error>
          </div>
       </div>

       <!-- 7 ligne -->
        <div class="form-row">
          <div class="form-group col-md-4">
          <label>Situation visa</label>    
      <select name="Situationvisa" v-model="form.Situationvisa" id="Situationvisa" 
        class="form-control" :class="{ 'is-invalid': form.errors.has('Situationvisa') }">
        <option value="">Choisissez</option>
        <option value="Expire">Expiré</option>
        <option value="Expire">Expiré</option>
        </select>
      <has-error :form="form" field="Situationvisa"></has-error>
    </div>
          <div class="form-group col-md-4">
           <label>Information complémentaire visa</label>
           <input v-model="form.Informationcomplementairevisa" type="text" name="Informationcomplementairevisa"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Informationcomplementairevisa') }">
           <has-error :form="form" field="Informationcomplementairevisa"></has-error>
          </div>
           <div class="form-group col-md-4">
           <label>Date expiration des passeports</label>
           <input v-model="form.Dateexpirationdespasseports" type="date" name="Dateexpirationdespasseports"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Dateexpirationdespasseports') }">
           <has-error :form="form" field="Dateexpirationdespasseports"></has-error>
          </div>
       </div>

       <!-- 8eme ligne -->
        <div class="form-row">
          <div class="form-group col-md-6">
           <label>Objectifs de la mission</label>
           <input v-model="form.Objectifsdelamission" type="text" name="Objectifsdelamission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Objectifsdelamission') }">
           <has-error :form="form" field="Objectifsdelamission"></has-error>
          </div>
           <div class="form-group col-md-6">
           <label>Opportunité mission</label>
           <input v-model="form.Opportunitemission" type="text" name="Opportunitemission"
            class="form-control" :class="{ 'is-invalid': form.errors.has('Opportunitemission') }">
           <has-error :form="form" field="Opportunitemission"></has-error>
          </div>
       </div>

      </div>
      <div class="modal-footer">
        <button v-show="editmode" type="submit" class="btn btn-primary">Modifier</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Enregistrer</button>
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