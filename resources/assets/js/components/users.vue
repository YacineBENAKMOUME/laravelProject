<template>
    <div class="container">
       <div class="row mt-5" >
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Gestion des utilisateurs</h3>
                <div class="card-tools">
                 <button class="btn btn-success" @click="newModal">Ajouter <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Date</th>
                      <th>Modifier</th>
                    </tr>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type | upText}}</td>
                      <td>{{user.created_at }}</td>

                      <td>
                         <a href="#" @click="editModal(user)">
                         <i class="fa fa-edit blue"></i>
                         </a>
                         /
                         <a href="#" @click="deleteUser(user.id)">
                         <i class="fa fa-trash red"></i>
                         </a>
                     </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Modal -->
 
 
 
 
 
 
 
 <!-- Modal -->

<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Ajouter un utilisateur</h5>
        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

     <form @submit.prevent="editmode ? updateUser() : createUser()">
   <div class="modal-body">
    <div class="form-group">
            <input v-model="form.name" type="text" name="name"
            placeholder="Nom"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>

    <div class="form-group">
            <input v-model="form.email" type="email" email="email"
            placeholder="Adresse e-mail"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
      <has-error :form="form" field="email"></has-error>
    </div>

    <div class="form-group">
            <textarea v-model="form.bio" name="bio" id="bio"
            placeholder="short bio for the user (facultatif)"
        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
      <has-error :form="form" field="bio"></has-error>
    </div>

    <div class="form-group">
      <select name="type" v-model="form.type" id="type" 
        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
        <option value="">Choisir Type utilisateur</option>
        <option value="RST">RST</option>
        <option value="RSF">RSF</option>
        <option value="Service Relex">Relex</option>
        <option value="Chef de Département">Chef département</option>
        </select>
      <has-error :form="form" field="type"></has-error>
    </div>

    <div class="form-group">
      <input v-model="form.password" type="password" name="password" id="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
      <has-error :form="form" field="password"></has-error>
    </div>
        
      </div>
      <div class="modal-footer">
        <button v-show="editmode" type="submit" class="btn btn-success">Modifier</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Enregistrer</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
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
        data(){
          return {
            editmode: true,
            users : {},
              form: new Form({
                 id: '',
                 name: '',
                 email: '',
                 password: '',
                 type: '',
                 bio: '',
                 photo: ''
              })
          } 
        },
        methods: {
          updateUser(){
            this.$Progress.start();
            this.form.put('api/user/'+this.form.id)
            .then(() => {
              $('#addNew').modal('hide');
              swal.fire(
               'Modifié!',
               'user updated.',
               'success'  
             )
             this.$Progress.finish();
             Fire.$emit('AfterCreate');

            })
            .catch(() => {
              this.$Progress.fail();
            });
          },
          editModal(user){
           this.editmode = true;
           this.form.reset();
           $('#addNew').modal('show');
           this.form.fill(user);
 
          },
          newModal(){
           this.editmode = false;
           this.form.reset();
           $('#addNew').modal('show');
          },
        deleteUser(id){
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
            this.form.delete('api/user/'+id).then(() => {
               swal.fire(
               'Deleted!',
               'utilisateur a été supprimé.',
               'success'  
             )
             Fire.$emit('AfterCreate');
           }).catch(() => {
             swal("Failed","someting wrong","warning");
           });
           }
          })
        },
          loadUsers(){
            axios.get("api/user").then(({data}) => (this.users = data.data));
            
          },

        createUser(){
         this.$Progress.start();

         this.form.post('api/user')
         .then(() => {
         Fire.$emit('AfterCreate');
         $('#addNew').modal('hide')

         Toast.fire({
            icon: 'success',
            title: 'Utilisateur créé!'
          })
         this.$Progress.finish();
        })
        .catch(() =>{
           this.$Progress.fail(); 
        })
        }

        },
        created() {
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
              this.loadUsers();
            });
        }
    }
</script>