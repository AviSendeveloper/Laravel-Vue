<template>
  <div>
    <div class="content-wrapper">
      <div class="container-xxl flex-grow-1 container-p-y col-md-4">
        <div class="box">
          <div class="form-group space">
            <h2 class="align">Login Page</h2>
          </div>
          <div class="form-group space">
            <label for="exampleInputEmail1" class="lable">Email</label>
            <input
              type="email"
              class="form-control field"
              placeholder="Enter Email"
              v-model="data.email"
            />
          </div>
          <div class="form-group space">
            <label for="exampleInputEmail1">Password</label>
            <input
              type="password"
              class="form-control"
              placeholder="Enter Password"
              v-model="data.password"
            />
          </div>
          <div>
            <button class="btn btn-primary space" @click="login">Login</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.box {
  box-sizing: content-box;
  width: 100%;
  border: solid #a7a7a7 2px;
  border-radius: 10px;
  padding: 20px;
  margin-top: 287px;
}
.align {
  text-align: center;
}
.space {
  margin: 20px;
}
.lable {
  margin: 5px 10px 5px 0;
}
.field {
  margin: 5px 10px 5px 0;
}
</style>

<script>
export default {
  data() {
    return {
      data: {
        email: "",
        password: "",
      },
      isLoggedin: false,
    };
  },

  methods: {
    async login() {
        if (this.data.email == '')  this.warning('Email field can not be blank');
        if (this.data.password == '') return this.warning('Password field can not be blank');

        const res = await this.callApi('post', 'admin/login', this.data);

        if (res.status === 200) {
            console.log(res);
            this.data.email = '';
            this.data.password = '';
            this.isLoggedin = true;
            this.$store.commit('updateUserLoginStatus', res.data.userStatus, res.data.userDetails)
            this.$router.push('/home');
        } else {
            let errors = res.data.errors;
            if (errors) {
              for (let error in errors) {
                this.error(errors[error]);
              }
            } else {
                this.error(res.data.msg);
            }
        }
    },
  },
};
</script>
