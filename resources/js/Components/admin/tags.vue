<template>
  <div>
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
          <div class="heading">
              <div class="child">
                  <h5>Tags list</h5>
              </div>
              <div class="child">
                  <div class="add-button">
                      <Button class="float-right" @click="addModel = true">Add tag</Button>
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
                  <th>Craeted Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" v-if="tags.length">
                <tr v-for="(tag, i) in tags" :key="i">
                  <td>
                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <strong>{{ tag.id }}</strong>
                  </td>
                  <td>{{ tag.name }}</td>
                  <td>
                    <span class="badge bg-label-primary me-1">
                      {{ tag.created_at }}</span>
                  </td>
                  <td>
                    <button class="btn btn-warning" @click="toggleEditModel(tag, i)">Edit</button> &nbsp;
                    <button class="btn btn-danger" @click="toggleDeleteModel(tag, i)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Bootstrap Table with Header - Light -->

        <!-- Add model -->
        <Modal v-model="addModel" title="Add tag" @on-ok="addTag">
          <div class="form-group">
            <label for="exampleInputEmail1">Tag Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter email"
              v-model="addData.name"
            />
          </div>
        </Modal>
        <!-- Add model -->

        <!-- Edit model -->
        <Modal v-model="editModel" title="Edit Tag" @on-ok="editTag">
          <div class="form-group">
            <label>Tag Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter email"
              v-model="editData.name"
            />
          </div>
        </Modal>
        <!-- Edit model -->

        <!-- Delete model -->
        <!-- <Modal v-model="delModel" width="360">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p>After this task is deleted, the downstream 10 tasks will not be implemented.</p>
                <p>Will you delete it?</p>
            </div>
            <template #footer>
                <Button type="error" size="large" long :loading="del_modal_loading" @click="deleteTag()">Delete</Button>
            </template>
        </Modal> -->
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
      },
      editModel: false,
      editData: {
        id: '',
        name: "",
      },
      tags: [],
      editIndex: -1,
      delModel: false,
      del_modal_loading: false,
      deleteId: 0,
      deleteIndex: -1
    };
  },

  methods: {
    async addTag() {
      // Validate tag name field
      if (this.addData.name == '') {
          return this.warning('Name field can not be blank');
      }

      // Upload tag name
      const res = await this.callApi("post", "admin/add-tag", this.addData);
      if (res.status === 201) {
          this.tags.unshift(res.data);
          this.addData.name = '';
          this.addModel = false;
          this.success('Tag add successfully')
      } else {
          if (res.data.errors.name) {
              this.error(res.data.errors.name[0]);
          } else {
              this.error();
          }
      }
    },

    toggleEditModel(tag, index) {
        this.editData.id = tag.id;
        this.editData.name = tag.name;
        this.editIndex = index;
        this.editModel = true;
    },

    async editTag() {
      // Validate tag name field
      if (this.editData.name == '') {
          return this.warning('Name field can not be blank');
      }

      // Upload edited tag name
      const res = await this.callApi("post", "admin/edit-tag", this.editData);
      if (res.status === 200) {
          this.tags[this.editIndex].name = this.editData.name;
          this.editModel = false;
          return this.success('Tag edit successfully')
      } else {
          if (res.data.errors.name) {
              this.error(res.data.errors.name[0]);
          } else {
              this.error();
          }
      }
    },

    toggleDeleteModel(tag, index) {
        const deleteModelObj = {
            showDeleteModel: true,
            deleteUrl: 'admin/delete-tag',
            deleteId: tag.id,
            deleteIndex: index,
            isDeleted: false
        }

        this.$store.commit('showDeleteModel', deleteModelObj);
    },

    async deleteTag () {
      this.del_modal_loading = true;
      const delete_response = await this.callApi('post', `admin/delete-tag`, {id: this.deleteId});

      if (delete_response.status === 200) {
          // delete data from tag array
          this.tags.splice(this.deleteIndex, 1);
          this.del_modal_loading = false;
          this.delModel = false;
          this.success(delete_response.data.msg);
      }
    }
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
        this.tags.splice(obj.deleteIndex, 1);
      }
    }
  },

  async created() {
    // const res = await this.callApi("get", "admin/get-tag").then((res) => {
    //   console.log(res);
    //   if (res.status === 200) {
    //     this.tags = res.data;
    //   }
    // });

    const res = await this.callApi("get", "admin/get-tag")
    if (res.status === 200) {
      this.tags = res.data;
    }
  },

  components: {
    DeleteModel
  }
};
</script>
