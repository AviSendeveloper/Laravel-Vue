<template>
  <div>
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
          <div class="heading">
              <div class="child">
                  <h5>Admins list</h5>
              </div>
              <div class="child">
                  <div class="add-button">
                      <Button class="float-right" @click="addModel=true">Add Admin</Button>
                  </div>
              </div>
          </div>
          <hr>
          <br>
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="table-light">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>User Type</th>
                  <th>Craeted Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" v-if="admins.length">
                <tr v-for="(admin, i) in admins" :key="i">
                  <td>
                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <strong>{{ admin.id }}</strong>
                  </td>
                  <td>{{ admin.name }}</td>
                  <td>{{ admin.email }}</td>
                  <td>{{ admin.role.name }}</td>
                  <td>
                    <span class="badge bg-label-primary me-1">
                      {{ admin.created_at }}</span>
                  </td>
                  <td>
                    <button class="btn btn-warning" @click="toggleEditModel(admin, i)">Edit</button> &nbsp;
                    <button class="btn btn-danger" @click="toggleDeleteModel(admin, i)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Bootstrap Table with Header - Light -->

        <!-- Add model -->
        <Modal v-model="addModel" title="Add admin" @on-ok="addAdmin">
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter Name"
              v-model="addData.name"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input
              type="email"
              class="form-control"
              placeholder="Enter Email"
              v-model="addData.email"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input
              type="password"
              class="form-control"
              placeholder="Enter Password"
              v-model="addData.password"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">User Type</label>
            <Select v-model="addData.role_id">
                <Option :value="role.id" v-for="(role, index) in roles" :key="index">{{ role.name }}</Option>
            </Select>
          </div>
        </Modal>
        <!-- Add model -->

        <!-- Edit model -->
        <Modal v-model="editModel" title="Edit admin" @on-ok="editAdmin">
          <div class="form-group">
            <label>Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter email"
              v-model="editData.name"
            />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input
              type="email"
              class="form-control"
              placeholder="Enter email"
              v-model="editData.email"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">User Type</label>
            <Select v-model="editData.role_id">
                <Option :value="role.id" v-for="(role, index) in roles" :key="index">{{ role.name }}</Option>
            </Select>
          </div>
        </Modal>
        <!-- Edit model -->

        <!-- Delete model -->
          <delete-model></delete-model>
        <!-- Delete model -->
      </div>
      <!-- / Content -->

      <div class="content-backdrop fade"></div>
    </div>
  </div>
</template>

<style scoped>
    .child {
        width: 50%;
        float: left;
        padding: 20px;
    }

    .add-button {
      float: right;
    }
</style>

<script>
import DeleteModel from '../reuse_component/DeleteModel.vue';
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      addModel: false,
      addData: {
        name: "",
        email: "",
        password: "",
        role_id: "",
      },
      editModel: false,
      editData: {
        id: '',
        name: "",
        email: "",
        role_id: "",
      },
      admins: [],
      editIndex: -1,
      roles: []
    };
  },

  methods: {
    async addAdmin() {
      // Validate admin name field
      if (this.addData.name == '')  this.warning('Name field can not be blank');
      if (this.addData.email == '')  this.warning('Email field can not be blank');
      if (this.addData.password == '')  this.warning('Password field can not be blank');
      if (this.addData.role_id == '') return this.warning('User role can not be blank');

      // Upload admin name
      const res = await this.callApi("post", "admin/add-admin", this.addData);
      if (res.status === 201) {
          this.admins.unshift(res.data);
          this.addData.name = '';
          this.addData.email = '';
          this.addData.password = '';
          this.addData.role_id = '';
          this.addModel = false;
          this.success('Admin add successfully')
      } else {
          let errors = res.data.errors;
          if (errors) {
            for (let error in errors) {
              this.error(errors[error]);
            }
          } else {
              this.error();
          }
      }
    },

    toggleEditModel(admin, index) {
        console.log(admin);
        this.editData.id = admin.id;
        this.editData.name = admin.name;
        this.editData.email = admin.email;
        this.editData.role_id = admin.role_id;
        this.editIndex = index;
        this.editModel = true;
    },

    async editAdmin() {
      // Validate admin name field
      if (this.editData.name == '') return this.warning('Name field can not be blank');
      if (this.editData.email == '') return this.warning('Email field can not be blank');
      if (this.editData.role_id == '') return this.warning('User role can not be blank');

      // Upload edited admin name
      const res = await this.callApi("post", "admin/edit-admin", this.editData);
      if (res.status === 200) {
          this.admins[this.editIndex] = res.data;
          this.editModel = false;
          return this.success('Admin edit successfully')
      } else {
          let errors = res.data.errors;
          if (errors) {
            for (let error in errors) {
              this.error(errors[error]);
            }
          } else {
              this.error();
          }
      }
    },

    toggleDeleteModel(admin, index) {
        const deleteModelObj = {
            showDeleteModel: true,
            deleteUrl: 'admin/delete-admin',
            deleteId: admin.id,
            deleteIndex: index,
            isDeleted: false
        }

        this.$store.commit('showDeleteModel', deleteModelObj);
    },
  },

  computed: {
    ...mapGetters([
        'getDeleteModelObj'
    ])
  },

  watch: {
    getDeleteModelObj(obj) {
      if (this.getDeleteModelObj.isDeleted) {
        this.admins.splice(obj.deleteIndex, 1);
      }
    }
  },

  async created() {
    const res = await this.callApi("get", "admin/get-admin")
    const roles_res = await this.callApi("get", "admin/get-role")

    if (res.status === 200) {
      this.admins = res.data;
    }

    if (roles_res.status == 200) {
        this.roles = roles_res.data;
    }
  },

  components: {
    DeleteModel
  }
};
</script>
