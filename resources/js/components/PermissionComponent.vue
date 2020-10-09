<template>
  <div class="container-fluid">
    <div class="row">
      <!-- Create button Start -->
      <div class="col-md-6">
        <button v-on:click="createPermission" class="btn btn-primary btn-sm my-2">Create Permission</button>
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
              editMode
              ? "Edit Permission"
              : "Create New Permission"
              }}
            </h5>
          </div>
          <div class="card-body">
            <alert-error :form="permission" v-bind:message="message"></alert-error>
            <form
              v-on:submit.prevent="
                                editMode
                                    ? updatePermission()
                                    : storePermission()
                            "
            >
              <div class="form-group">
                <input
                  v-model="permission.name"
                  type="text"
                  class="form-control"
                  placeholder="Enter Permission Name"
                  :class="{
                                        'is-invalid': permission.errors.has(
                                            'name'
                                        )
                                    }"
                />
                <has-error :form="permission" field="name"></has-error>
              </div>
              <button type="submit" class="btn btn-primary float-right">save</button>
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
            <tr v-for="permission in permissions" :key="permission.id">
              <td>{{ permission.id }}</td>
              <td>{{ permission.name }}</td>
              <td>
                <button v-on:click="editPermission(permission)" class="btn btn-success btn-sm">Edit</button>
                <button
                  v-on:click="deletePermission(permission.id)"
                  class="btn btn-danger btn-sm"
                >Delete</button>
              </td>
            </tr>
            <tr></tr>
          </tbody>
        </table>
      </div>
      <!-- Table End -->
    </div>
  </div>
</template>

<script>
export default {
  name: "PermissionComponent.vue",
  data() {
    return {
      message: "",
      editMode: false,
      permissions: [],
      permission: new Form({
        id: "",
        name: "",
      }),
    };
  },
  methods: {
    permissionList() {
      this.permission.get("/api/permission").then((res) => {
        this.permissions = res.data;
      });
    },
    createPermission() {
      this.$Progress.start();
      this.permission.clear();
      this.editMode = false;
      this.permission.reset();
      this.$Progress.finish();
    },
    storePermission() {
      this.$Progress.start();
      this.permission
        .post("/api/permission")
        .then((res) => {
          this.permissionList();
          this.permission.reset();
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
      this.$Progress.finish();
    },
    editPermission(permission) {
      this.$Progress.start();
      this.permission.clear();
      this.editMode = true;
      this.permission.id = permission.id;
      this.permission.name = permission.name;
      this.$Progress.finish();
    },
    updatePermission() {
      this.$Progress.start();
      this.permission
        .put(`/api/permission/${this.permission.id}`)
        .then((res) => {
          this.permissionList();
          this.permission.reset();
          this.createPermission();
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
      this.$Progress.finish();
    },
    deletePermission(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
          this.$Progress.start();
          this.permission.delete(`/api/permission/${id}`).then((res) => {
            this.permissionList();
            this.$Progress.finish();
          });
        }
      });
    },
  },
  created() {
    this.$Progress.start();
    this.permissionList();
    this.$Progress.finish();
  },
};
</script>
