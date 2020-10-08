<template>
    <div class="container-fluid">
        <div class="row">
            <!-- Create button Start -->
            <div class="col-md-6">
                <button
                    v-on:click="createPermission"
                    class="btn btn-primary btn-sm my-2"
                >
                    Create Permission
                </button>
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
                        <alert-error
                            :form="permission"
                            v-bind:message="message"
                        ></alert-error>
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
                                <has-error
                                    :form="permission"
                                    field="name"
                                ></has-error>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary float-right"
                            >
                                save
                            </button>
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
                        <tr
                            v-for="permission in permissions.data"
                            :key="permission.id"
                        >
                            <td>{{ permission.id }}</td>
                            <td>{{ permission.name }}</td>
                            <td>
                                <button
                                    v-on:click="editPermission(permission)"
                                    class="btn btn-success btn-sm"
                                >
                                    Edit
                                </button>
                                <button
                                    v-on:click="deletePermission(permission.id)"
                                    class="btn btn-danger btn-sm"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr></tr>
                    </tbody>
                </table>

                <pagination
                    :data="permissions"
                    @pagination-change-page="permissionList"
                    class="justify-content-center"
                ></pagination>
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
            permissions: {},
            permission: new Form({
                id: "",
                name: ""
            })
        };
    },
    methods: {
        permissionList(page = 1) {
            this.permission.get("/api/permission?page=" + page).then(res => {
                this.permissions = res.data;
            });
        },
        createPermission() {
            this.permission.clear();
            this.editMode = false;
            this.permission.reset();
        },
        storePermission() {
            this.permission
                .post("/api/permission")
                .then(res => {
                    this.permissionList();
                    this.permission.reset();
                })
                .catch(err => {
                    this.message = err.response.data.message;
                });
        },
        editPermission(permission) {
            this.permission.clear();
            this.editMode = true;
            this.permission.id = permission.id;
            this.permission.name = permission.name;
        },
        updatePermission() {
            this.permission
                .put(`/api/permission/${this.permission.id}`)
                .then(res => {
                    this.permissionList();
                    this.permission.reset();
                    this.createPermission();
                })
                .catch(err => {
                    this.message = err.response.data.message;
                });
        },
        deletePermission(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                    this.permission
                        .delete(`/api/permission/${id}`)
                        .then(res => {
                            this.permissionList();
                        });
                }
            });
        }
    },
    created() {
        this.permissionList();
    }
};
</script>
