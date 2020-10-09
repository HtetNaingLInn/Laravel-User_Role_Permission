<template>
  <div class="container-fluid">
    <div class="row">
      <!-- Create button Start -->
      <div class="col-md-6">
        <button v-on:click="createRole" class="btn btn-primary btn-sm my-2">
            <i class="fas fa-plus-circle"></i>&nbsp;Create Role</button>
      </div>
      <!-- Create button End -->
      <div class="col-md-6"></div>
    </div>
    <div class="row my-2">
      <!-- Form Start -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5 class="text-info">
              {{
              editMode ? "Edit Role Name" : "Create New Role"
              }}
            </h5>
          </div>
          <div class="card-body">
            <alert-error :form="role" v-bind:message="message"></alert-error>
            <form
              v-on:submit.prevent="
                                editMode ? updateRole() : storeRole()
                            "
            >
              <div class="form-group">
                <input
                  v-model="role.name"
                  type="text"
                  class="form-control"
                  placeholder="Enter Role Name"
                  :class="{
                                        'is-invalid': role.errors.has('name')
                                    }"
                />
                <has-error :form="role" field="name"></has-error>
              </div>
              <button type="submit" class="btn btn-primary float-right">
                  <i class="fa fa-save"></i>&nbsp;save</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Form End -->
      <!-- Table Start -->
      <div class="col-md-8">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles" :key="role.id">
              <td>{{ role.id }}</td>
              <td>{{ role.name }}</td>
              <td>
                <button v-on:click="editRole(role)" class="btn btn-success btn-sm"><i class="far fa-edit"></i></button>
                <button v-on:click="deleteRole(role.id)" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
              </td>
            </tr>
            <tr></tr>
          </tbody>
        </table>
        <!-- <pagination
                    :data="roles"
                    @pagination-change-page="RoleList"
                    class="justify-content-center"
        ></pagination>-->
      </div>
      <!-- Table End -->
    </div>
  </div>
</template>
<script>
export default {
  name: "RoleComponent.vue",

  data() {
    return {
      editMode: false,
      roles: [],
      message: "",
      role: new Form({
        id: "",
        name: "",
      }),
    };
  },
  methods: {
    RoleList() {
      this.role.get("/api/role").then((res) => {
        this.roles = res.data;
      });
    },
    createRole() {
      this.$Progress.start();
      this.RoleList();
      this.role.reset();
      this.editMode = false;
      this.$Progress.finish();
    },
    storeRole() {
      this.$Progress.start();
      this.role
        .post("/api/role")
        .then((res) => {
          this.RoleList();

          this.role.reset();
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
         Toast.fire({
                icon: 'success',
                title: 'Created in successfully'
                })
      this.$Progress.finish();
    },
    editRole(role) {
      this.$Progress.start();
      this.editMode = true;
      this.role.id = role.id;
      this.role.name = role.name;
      this.role.clear();
      this.$Progress.finish();
    },
    updateRole() {
      this.$Progress.start();
      this.role
        .put(`/api/role/${this.role.id}`)
        .then((res) => {
          this.RoleList();
          this.role.reset();
          this.createRole();
          this.role.clear();
          this.editMode = false;
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
         Toast.fire({
                icon: 'success',
                title: 'Edited in successfully'
                })
      this.$Progress.finish();
    },
    deleteRole(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire("Deleted!", "", "success");
          this.$Progress.start();
          axios.delete(`/api/role/${id}`).then((res) => {
            this.RoleList();
          });
           Toast.fire({
                icon: 'success',
                title: 'Deleted in successfully'
                })
          this.$Progress.finish();
        }
      });
    },
  },
  created() {
    this.$Progress.start();
    this.RoleList();
    this.$Progress.finish();
  },
};
</script>
