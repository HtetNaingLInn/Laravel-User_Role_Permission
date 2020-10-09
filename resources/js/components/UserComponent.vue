<template>
  <div class="container col-md-12">
    <div class="row">
      <div class="col-md-6">
        <button v-on:click="createUser()" class="btn btn-primary btn-sm my-3">Create User</button>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6"></div>
          <div class="col-md-6">
            <form v-on:submit.prevent="userSearch()">
              <div class="input-group">
                <input v-model="search" type="text" placeholder="search" class="form-control" />
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- Form Start -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5 class="text-info">
              {{
              editMode ? "Edit User info" : "Create New User"
              }}
            </h5>
          </div>
          <div class="card-body">
            <alert-error :form="user" v-bind:message="message"></alert-error>
            <form
              v-on:submit.prevent="
                                editMode ? updateUser() : storeUser()
                            "
            >
              <div class="form-group">
                <label>Username :</label>
                <input
                  v-model="user.name"
                  type="text"
                  class="form-control"
                  :class="{
                                        'is-invalid': user.errors.has('name')
                                    }"
                />
                <has-error :form="user" field="password"></has-error>
              </div>

              <div class="form-group">
                <label>Email :</label>
                <input
                  v-model="user.email"
                  type="email"
                  class="form-control"
                  :class="{
                                        'is-invalid': user.errors.has('email')
                                    }"
                />
                <has-error :form="user" field="password"></has-error>
              </div>
              <div class="form-group">
                <label>Password :</label>
                <input
                  v-model="user.password"
                  type="password"
                  class="form-control"
                  :class="{
                                        'is-invalid': user.errors.has(
                                            'password'
                                        )
                                    }"
                />
                <has-error :form="user" field="password"></has-error>
              </div>
              <div class="form-group">
                <label>Select User Role</label>
                <select class="form-control" v-model="user.role_id">
                  <option
                    v-for="role in roles"
                    :key="role.id"
                    v-bind:value="role.id"
                  >{{ role.name }}</option>
                </select>
              </div>

              <div class="form-group">
                <label>Select User Permission</label>
                <select multiple class="form-control" v-model="user.permission">
                  <option
                    v-for="permission in permissions"
                    :key="permission.id"
                    v-bind:value="permission.id"
                  >{{ permission.name }}</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary float-right">save</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Form End -->
      <div class="col-md-8">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Username</th>
              <th scope="col">Email Address</th>
              <th scope="col">Role</th>
              <th scope="col">Permission</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.role }}</td>
              <td>
                <div class="dropdown dropright">
                  <button
                    class="btn btn-warning btn-sm dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >Permission</button>
                  <div class="dropdown-menu">
                    <p
                      v-for="(permission,
                                            index) in user.permissions"
                      :key="index"
                      class="dropdown-item"
                      href="#"
                    >{{ permission.name }}</p>
                  </div>
                </div>
              </td>
              <td>
                <button v-on:click="editUser(user)" class="btn btn-success btn-sm">Edit</button>
                <button v-on:click="deleteUser(user.id)" class="btn btn-danger btn-sm">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
        <pagination :data="users" @pagination-change-page="userList" class="justify-content-center"></pagination>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "UserComponent.vue",
  data() {
    return {
      users: {},
      roles: [],
      permissions: [],
      message: "",
      editMode: false,
      search: "",
      user: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        role_id: "",
        permission: [],
      }),
    };
  },
  methods: {
    roleList() {
      axios.get("/api/role").then((res) => {
        this.roles = res.data;
      });
    },
    permissionList() {
      axios.get("/api/permission").then((res) => {
        this.permissions = res.data;
      });
    },

    userSearch() {
      this.user.get("/api/user?search=" + this.search).then((res) => {
        this.$Progress.start();
        this.users = res.data;
        this.$Progress.finish();
      });
    },

    userList(page = 1) {
      this.user.get("/api/user?page=" + page).then((res) => {
        this.$Progress.start();
        this.users = res.data;
        this.$Progress.finish();
      });
    },
    createUser() {
      this.$Progress.start();
      this.editMode = false;
      this.user.reset();
      this.userList();
      this.$Progress.finish();
    },
    storeUser() {
      this.user
        .post("/api/user/")
        .then((res) => {
          this.$Progress.start();
          this.userList();
          this.user.reset();
          this.$Progress.finish();
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
    },
    editUser(user) {
      this.$Progress.start();
      this.editMode = true;
      this.user.id = user.id;
      this.user.name = user.name;
      this.user.email = user.email;
      this.user.clear();
      this.$Progress.finish();
    },
    updateUser() {
      this.user
        .put(`/api/user/${this.user.id}`)
        .then((res) => {
          this.$Progress.start();
          this.userList();
          this.user.reset();
          this.createUser();
          this.$Progress.finish();
        })
        .catch((err) => {
          this.message = err.response.data.message;
        });
    },
    deleteUser(id) {
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
          axios.delete(`/api/user/${id}`).then((res) => {
            this.userList();
          });
          this.$Progress.finish();
        }
      });
    },
  },
  created() {
    this.$Progress.start();
    this.userList();
    this.roleList();
    this.permissionList();
    this.$Progress.finish();
  },
};
</script>
