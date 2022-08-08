<template>
  <div>
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
          <div class="heading">
              <div class="child">
                  <h5>Roles list</h5>
              </div>
              <div class="child">
                  <div class="add-button">
                      <Button class="float-right" @click="addModel = true">Add Role</Button>
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
                  <th>User Type</th>
                  <th>Craeted Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" v-if="roles.length">
                <tr v-for="(role, i) in roles" :key="i">
                  <td>
                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <strong>{{ role.id }}</strong>
                  </td>
                  <td>{{ role.name }}</td>
                  <td>{{ role.isAdmin===1 ? 'Admin' : 'User' }}</td>
                  <td>
                    <span class="badge bg-label-primary me-1">
                      {{ role.created_at }}</span>
                  </td>
                  <td>
                    <button class="btn btn-warning" @click="toggleEditModel(role, i)">Edit</button> &nbsp;
                    <button class="btn btn-danger" @click="toggleDeleteModel(role, i)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Bootstrap Table with Header - Light -->

        <!-- Add model -->
        <Modal v-model="addModel" title="Add role" @on-ok="addRole">
          <div class="form-group">
            <label for="exampleInputEmail1">Role Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter email"
              v-model="addData.name"
            />
          </div>
          <div class="form-group">
            <RadioGroup v-model="addData.isAdmin">
                <Radio label="1">
                    <span>Admin</span>
                </Radio>
                <Radio label="0">
                    <span>User</span>
                </Radio>
            </RadioGroup>
          </div>
        </Modal>
        <!-- Add model -->

        <!-- Edit model -->
        <Modal v-model="editModel" title="Edit Role" @on-ok="editRole">
          <div class="form-group">
            <label>Role Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter email"
              v-model="editData.name"
            />
          </div>
          <div class="form-group">
            <RadioGroup v-model="editData.isAdmin">
                <Radio label="1">
                    <span>Admin</span>
                </Radio>
                <Radio label="0">
                    <span>User</span>
                </Radio>
            </RadioGroup>
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
        isAdmin: ''
      },
      editModel: false,
      editData: {
        id: '',
        name: "",
        isAdmin: ''
      },
      roles: [],
      editIndex: -1,
      delModel: false,
      del_modal_loading: false,
      deleteId: 0,
      deleteIndex: -1
    };
  },

  methods: {
    async addRole() {
      // Validate role name field
      if (this.addData.name == '') return this.warning('Name field can not be blank');
      if (this.addData.isAdmin == '') return this.warning('User type can not be blank');

      // Upload role name
      const res = await this.callApi("post", "admin/add-role", this.addData);
      if (res.status === 201) {
          this.roles.unshift(res.data);
          this.addData.name = '';
          this.addModel = false;
          this.success('Role add successfully')
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

    toggleEditModel(role, index) {
        this.editData.id = role.id;
        this.editData.name = role.name;
        this.editData.isAdmin = role.isAdmin;
        this.editIndex = index;
        // console.log('role object', this.roles[this.editIndex]);
        this.editModel = true;
    },

    async editRole() {
      // Validate role name field
      if (this.editData.name == '') return this.warning('Name field can not be blank');
      if (this.editData.isAdmin == '') return this.warning('User type can not be blank');

      // Upload edited role name
      const res = await this.callApi("post", "admin/edit-role", this.editData);
      if (res.status === 200) {
          console.log(res);
          this.roles[this.editIndex].name = res.data.name;
          this.roles[this.editIndex].isAdmin = res.data.isAdmin;
          this.editModel = false;
          return this.success('Role edit successfully')
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

    toggleDeleteModel(role, index) {
        const deleteModelObj = {
            showDeleteModel: true,
            deleteUrl: 'admin/delete-role',
            deleteId: role.id,
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
      console.log(obj);
      if (this.getDeleteModelObj.isDeleted) {
        this.roles.splice(obj.deleteIndex, 1);
      }
    }
  },

  async created() {
    const res = await this.callApi("get", "admin/get-role")
    if (res.status === 200) {
      this.roles = res.data;
    }

    console.log(this.roles);
  },

  components: {
    DeleteModel
  }
};
</script>
