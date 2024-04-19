<template>
  <div class="d-flex justify-content-center">
    <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">



</span>

            </a>
          </div>
          <!-- /Logo -->
          <div class="text-center">
          <h4 class="mb-2">ສະບາຍດີ! 👋</h4>
          <p class="mb-4">ຍິນດີຕອນຮັບ</p>
          </div>

            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວ</label>
              <input type="text" class="form-control" id="email" v-model="email"  placeholder="ປ້ອນອີເມວ" @keyup.enter="login()">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ</label>

              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" v-model="password" placeholder="············" aria-describedby="ປ້ອນລະຫັດຜ່ານ" @keyup.enter="login()">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="show_error">
            {{ msg_error }} 
            </div>

            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" :disabled="check_bt" @click="login()">ເຂົ້າສູ່ລະບົບ</button>
            </div>


          <p class="text-center"> 
            <span>ບໍ່ມີບັນຊີ?</span>
            <router-link to="/register">
              <span>ລົງທະບຽນຢູເຊີໃຫມ່</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
  </div>
</template>

<script>
export default {
  name: 'Minipos12Login',

  data() {
    return {
      email:'',
      password:'',
      show_error:false,
      msg_error:''
    };
  },

  mounted() {
    
  },

  computed:{
    check_bt(){
        if(this.email == "" || this.password == ""){
          return true;
        }else{
          return false;
        }
    }
  },

  methods: {
      login(){

        if(this.email !='' || this.password !=''){
            axios.post("api/login",{
                    email: this.email,
                    password: this.password
                }).then((res)=>{
                    // console.log(res);
                    if(res.data.success){
                        this.password=''
                        this.email=''
                        this.show_error = false;
                        this.msg_error = '';

                        localStorage.setItem("web_token", res.data.token)
                        localStorage.setItem("web_user", JSON.stringify(res.data.user))

                        this.$router.push("/")
                    }else{
                        this.show_error = true;
                        this.msg_error = res.data.message;

                    }
                }).catch((err)=>{
                    console.log(err);
                })
        }


      }
  },
};
</script>
<style lang="scss" scoped>

</style>