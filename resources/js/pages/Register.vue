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
          <p class="mb-4">ລົງທະບຽນຢູເຊີໃຫມ່</p>
          </div>

            <div class="mb-3">
              <label for="user_name" class="form-label">ຊື່ຜູ້ໃຊ້</label>
              <input type="text" class="form-control" id="user_name" v-model="user_name"  placeholder="ປ້ອນຊື່ຜູ້ໃຊ້">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວ</label>
              <input type="text" class="form-control" id="email" name="email-username" v-model="email" placeholder="ປ້ອນອີເມວ">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ</label>

              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" v-model="password" placeholder="············" aria-describedby="ປ້ອນລະຫັດຜ່ານ">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ຢືນຢັນລະຫັດຜ່ານ</label>

              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" v-model="password2" placeholder="············" aria-describedby="ປ້ອນລະຫັດຜ່ານ">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="show_error">
            {{ msg_error }} 
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" @click="Register()">ລົງທະບຽນ</button>
            </div>


          <p class="text-center">
            <span>ມີບັນຊີແລ້ວ!</span>
            <router-link to="/login">
              <span>ເຂົ້າສູ່ລະບົບ</span>
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
import axios from 'axios'

export default { 
  name: 'Minipos12Register',

  data() {
    return {
      user_name:'',
      email:'',
      password:'',
      password2:'',
      show_error:false,
      msg_error:''
    };
  },

  mounted() {
    
  },

  methods: {
    Register(){
        if(this.user_name == '' || this.email == '' || this.password == ''){
            this.show_error = true;
            this.msg_error = 'ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!!';
        }else{

            if(this.password == this.password2){
                this.show_error = false;
                this.msg_error = '';

                axios.post("api/register",{
                    name: this.user_name,
                    email: this.email,
                    password: this.password
                }).then((res)=>{
                    console.log(res);
                    if(res.data.success){
                        this.user_name=''
                        this.password=''
                        this.password2=''
                        this.email=''

                        this.$router.push("/login")
                    }else{
                        this.show_error = true;
                        this.msg_error = res.data.message;

                    }
                }).catch((err)=>{
                    console.log(err);
                })

            }else{
                this.show_error = true;
                this.msg_error = 'ລະຫັດຜ່ານບໍ່ຕົງກັນ!!';
            }
        }
    }
  },
};
</script>
<style lang="scss" scoped>

</style>