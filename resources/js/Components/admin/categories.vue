<template>
  <div>
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
          <div class="heading">
            <div class="child">
              <h5>Category list</h5>
            </div>
            <div class="child">
              <div class="add-button">
                <Button class="float-right" @click="addModel = true"
                  >Add category</Button
                >
              </div>
            </div>
          </div>
          <hr />
          <br />
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="table-light">
                <tr>
                  <th>Id</th>
                  <th>Icon</th>
                  <th>Name</th>
                  <th>Craeted Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" v-if="categories.length">
                <tr v-for="(category, i) in categories" :key="i">
                  <td>
                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <strong>{{ category.id }}</strong>
                  </td>
                  <td>
                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <div>
                      <img
                        :src="`/upload/category/${category.icon}`"
                        style="width: 100px"
                      />
                    </div>
                  </td>
                  <td>{{ category.name }}</td>
                  <td>
                    <span class="badge bg-label-primary me-1">
                      {{ category.created_at }}</span
                    >
                  </td>
                  <td>
                    <button
                      class="btn btn-warning"
                      @click="toggleEditModel(category, i)"
                    >
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      @click="toggleDeleteModel(category, i)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Bootstrap Table with Header - Light -->

        <!-- Add model -->
        <Modal
          v-model="addModel"
          title="Add category"
          @on-ok="addCategory"
          @on-cancel="closeAddModel"
        >
          <div class="form-group">
            <label for="exampleInputEmail1">Category Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter email"
              v-model="addData.name"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Upload Icon</label>
            <Upload
              ref="upload"
              :headers="{
                'x-csrf-token': token,
                'X-Requested-With': 'XMLHttpRequest',
              }"
              :on-success="handleSuccess"
              :on-error="handelError"
              :format="['jpg', 'jpeg', 'png']"
              :on-format-error="handleFormatError"
              type="drag"
              action="admin/upload-category-image"
            >
              <div style="padding: 20px 0">
                <Icon
                  type="ios-cloud-upload"
                  size="52"
                  style="color: #3399ff"
                ></Icon>
                <p>Click or drag files here to upload</p>
              </div>
            </Upload>
            <div style="padding: 20px 0">
              <div v-if="addData.icon.length" @click="deleteImage()">
                <Icon type="ios-trash-outline" size="40" />
              </div>
              <img :src="`/upload/category/${addData.icon}`" alt="" />
            </div>
          </div>
        </Modal>
        <!-- Add model -->

        <!-- Edit model -->
        <Modal
          v-model="editModel"
          title="Edit Tag"
          @on-ok="editCategory"
          @on-cancel="closeEditModel"
        >
          <div class="form-group">
            <label>Category Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter email"
              v-model="editData.name"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Uploaded Icon</label>
            <Upload
              v-if="isNewUpload"
              ref="edit_upload"
              :headers="{
                'x-csrf-token': token,
                'X-Requested-With': 'XMLHttpRequest',
              }"
              :on-success="handleSuccess"
              :on-error="handelError"
              :format="['jpg', 'jpeg', 'png']"
              :on-format-error="handleFormatError"
              type="drag"
              action="admin/upload-category-image"
            >
              <div style="padding: 20px 0">
                <Icon
                  type="ios-cloud-upload"
                  size="52"
                  style="color: #3399ff"
                ></Icon>
                <p>Click or drag files here to upload</p>
              </div>
            </Upload>
            <div style="padding: 20px 0">
              <div v-if="editData.icon.length" @click="deleteImage()">
                <Icon type="ios-trash-outline" size="40" />
              </div>
              <img :src="`/upload/category/${editData.icon}`" alt="" />
            </div>
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
                <Button type="error" size="large" long :loading="del_modal_loading" @click="deleteCategory()">Delete</Button>
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
        icon: ''
      },
      editModel: false,
      editData: {
        id: '',
        name: "",
        icon: ''
      },
      categories: [],
      editIndex: -1,
      delModel: false,
      del_modal_loading: false,
      deleteId: 0,
      deleteIndex: -1,
      token: '',
      isNewUpload: false
    };
  },

  methods: {
    // Add
    async addCategory() {
      // Validate tag name field
      if (this.addData.name == '') {
          return this.warning('Name field can not be blank');
      }

      // Upload category name
      const res = await this.callApi("post", "admin/add-category", this.addData);
      if (res.status === 201) {
          this.categories.unshift(res.data);
          this.addData.name = '';
          this.addData.icon = '';
          this.$refs.upload.clearFiles();
          this.addModel = false;
          this.success('Category add successfully')
      } else {
          if (res.data.errors.name) {
              this.error(res.data.errors.name[0]);
          } else {
              this.error();
          }
      }
    },

    async closeAddModel() {
        this.addData.name = '';
        if (this.addData.icon) {
            await this.deleteImage;
        }
        this.addModel = false;
    },

    // Edit
    toggleEditModel(category, index) {
        this.editData.id = category.id;
        this.editData.name = category.name;
        this.editData.icon = category.icon;
        console.log(this.editData.icon);
        this.editIndex = index;
        this.editModel = true;
    },

    async closeEditModel() {
        console.log('working');
        this.editModel = false;
    },

    async editCategory() {
      // Validate category name field
      if (this.editData.name == '') {
          return this.warning('Name field can not be blank');
      }

      // Upload edited tag name
      const res = await this.callApi("post", "admin/edit-category", this.editData);
      if (res.status === 200) {
          this.categories[this.editIndex].name = this.editData.name;
          this.categories[this.editIndex].icon = this.editData.icon;
          this.editModel = false;
          return this.success('Category edit successfully')
      } else {
          if (res.data.errors.name) {
              this.error(res.data.errors.name[0]);
          } else {
              this.error();
          }
      }
    },

    // Delete
    toggleDeleteModel(category, index) {
        const deleteModelObj = {
            showDeleteModel: true,
            deleteUrl: 'admin/delete-category',
            deleteId: category.id,
            deleteIndex: index,
            isDeleted: false
        }

        this.$store.commit('showDeleteModel', deleteModelObj);

        // this.deleteIndex = index;
        // this.deleteId = category.id;
        // this.delModel = true;
    },

    // async deleteCategory () {
    //   this.del_modal_loading = true;
    //   const delete_response = await this.callApi('post', `admin/delete-category`, {id: this.deleteId});

    //   if (delete_response.status === 200) {
    //       // delete data from category array
    //       this.categories.splice(this.deleteIndex, 1);
    //       this.del_modal_loading = false;
    //       this.delModel = false;
    //       this.success(delete_response.data.msg);
    //   }
    // },

    // Delete Image for add and edit model
    async deleteImage() {
      if (this.editModel == true) { // for edit model
          if (this.editData.icon == '') {
              return this.warning('Image must be exist');
          }

          const res = await this.callApi('post', 'admin/delete-category-image', {id: this.editData.id, icon: this.editData.icon, editImage: this.isNewUpload});

          if (res.status === 200) {
              this.editData.icon = '';
              this.categories[this.editIndex].icon = '';
              if (this.isNewUpload) {
                  this.$refs.edit_upload.clearFiles();
              }
              this.isNewUpload = true;
              this.success('File deleted successfully');
              console.log(this.editData);
          } else {
              this.warning('File not exist');
          }
          console.log('working');
      } else { // for add model
          if (this.addData.icon == '') {
              return this.warning('Image must be exist');
          }

          const res = await this.callApi('post', 'admin/delete-category-image', {icon: this.addData.icon});

          if (res.status === 200) {
              this.addData.icon = '';
              this.$refs.upload.clearFiles();
              this.success('File deleted successfully');
          } else {
              this.warning('File not exist');
          }
      }
    },

    // upload response handeler
    handleSuccess (res, file) {
        if (this.isNewUpload) {
            this.editData.icon = res.file_name;
        }
        this.addData.icon = res.file_name;
    },

    handelError(res, file) {
        this.$Notice.warning({
            title: 'Something is wrong',
            desc: `${file.errors.file.length ? file.errors.file[0] : 'Something is wrong'}`
        });
    },

    handleFormatError (file) {
        this.$Notice.warning({
            title: 'The file format is incorrect',
            desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
        });
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
        this.categories.splice(obj.deleteIndex, 1);
      }
    }
  },

  async created() {
    this.token = document.querySelector('meta[name="_token"]').getAttribute('content');
    
    const res = await this.callApi("get", "admin/get-category")
    if (res.status === 200) {
      this.categories = res.data;
    }
  },

  components: {
    DeleteModel
  }
};
</script>
