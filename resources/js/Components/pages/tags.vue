<template>
  <div>
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
          <h5 >Light Table head</h5>
          <Button class="float-right">Default</Button>
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="table-light">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Craeted_at</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>
                    <i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <strong>1</strong>
                  </td>
                  <td>Albert Cook</td>
                  <td>
                    <span class="badge bg-label-primary me-1">04/05/2022</span>
                  </td>
                  <td>
                    <button class="btn btn-warning">Edit</button> &nbsp;
                    <button class="btn btn-danger">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Bootstrap Table with Header - Light -->

        <!-- Add model -->
        <Modal
          v-model="showAddModel"
          title="Modal Title"
          ok-text="OK"
          cancel-text="Cancel"
        >
          <p>Something...</p>
          <p>Something...</p>
          <p>Something...</p>
        </Modal>
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
      showAddModel: true,
    }
  },

  // async created() {
  //   const res = await this.callApi('post', '/app/fetch-tags', {tag_name: 'test tag'});

  //   if (res == 200) {
  //       consol.log(res);
  //   }
  // }
};
</script>
