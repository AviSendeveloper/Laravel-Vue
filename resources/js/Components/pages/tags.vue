<template>
  <div>
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
          <h5>Tags list</h5>
          <Button class="float-right" @click="addModel = true">Default</Button>
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
                    <button class="btn btn-danger">Delete</button>
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
      </div>
      <!-- / Content -->

      <div class="content-backdrop fade"></div>
    </div>
  </div>
</template>

<script>
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
      editIndex: -1
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
      if (this.addData.name == '') {
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
};
</script>
