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
                  <Select v-model="role_id" @on-change="ChangeRole()">
                      <Option :value="role.id" v-for="(role, index) in roles" :key="index">{{ role.name }}</Option>
                  </Select>
              </div>
          </div>
          <hr>
          <br>
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="table-light">
                <tr>
                  <th>Resouce Name</th>
                  <th>Read</th>
                  <th>Write Type</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" v-if="resources.length">
                <tr v-for="(r, i) in resources" :key="i">
                  <td>
                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <strong>{{ r.resouceName }}</strong>
                  </td>
                  <td><Checkbox v-model="r.read"></Checkbox></td>
                  <td><Checkbox v-model="r.write"></Checkbox></td>
                  <td>
                    <Checkbox v-model="r.update"></Checkbox>
                  </td>
                  <td>
                    <Checkbox v-model="r.delete"></Checkbox>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="add-button">
              <button class="btn btn-primary" @click="assignRole()">Assign Role</button>
            </div>
          </div>
        </div>
        <!-- Bootstrap Table with Header - Light -->
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
export default {
  data() {
    return {
      role_id: null,
      roles: [],
      resources: [
        {
          resouceName: 'tags',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'tags'
        },
        {
          resouceName: 'categories',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'categories'
        },
        {
          resouceName: 'Admin User',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'admin_user'
        },
        {
          resouceName: 'Role Assign',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'role_assign'
        },
        {
          resouceName: 'Home',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'home'
        },
      ],
      defaultResourcesPermission: [
        {
          resouceName: 'tags',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'tags'
        },
        {
          resouceName: 'categories',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'categories'
        },
        {
          resouceName: 'Admin User',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'admin_user'
        },
        {
          resouceName: 'Role Assign',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'role_assign'
        },
        {
          resouceName: 'Home',
          read: false,
          write: false,
          update: false,
          delete: false,
          name: 'home'
        },
      ],
    };
  },

  methods: {
    async assignRole() {
      const data = JSON.stringify(this.resources);
      const res = await this.callApi('post', 'admin/role-assign', {permission: data, id: this.role_id});
      if (res.status === 200) {
        this.success('Role assigned successfully');
        let roleData = this.roles.find(role => role.id == this.role_id);
        roleData.permission = data;
      } else {
        this.error();
      }
    },

    ChangeRole() {
      const res = this.roles.find(role => role.id == this.role_id);
      if (!res.permission) {
        this.resources = this.defaultResourcesPermission;
      } else {
        this.resources = JSON.parse(res.permission);
      }
    }
  },

  async created() {
    const res = await this.callApi("get", "admin/get-role");
    if (res.status === 200) {
      this.roles = res.data;
      this.role_id = res.data[0].id;
      if (res.data[0].permission) {
        this.resources = JSON.parse(res.data[0].permission);
      }
    }
  },
};
</script>
