<template>
  <div>
<div class="card">

    <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ
      <div class=" spinner-grow spinner-grow-sm text-success" v-if="Loading" role="status">
          <span class="visually-hidden">Loading...</span>
      </div>
    </h5>
  <div class="card-body">

    <div v-if="ShowFrom">

      <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2" :disabled="CheckForm" @click="SaveStore()" >
                <span v-if="Loading">
                    <div class="spinner-border spinner-border-sm text-white" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div> loading...
                </span>
                <span v-else> ບັນທຶກ </span>
            </button>
          <button type="button" class="btn btn-secondary" @click="CancelStore()">ຍົກເລິກ</button>
      </div>
      <div class="row">
            <div class="col-md-4 text-center" style=" position: relative; ">
                <button type="button" class="btn rounded-pill btn-icon btn-danger img-remove" @click="RemoveImage()"  v-if="FormStore.image" >
                    <i class='bx bxs-x-circle fs-3'></i>
              </button>
               <img :src="image_pre" @click="$refs.img_store.click()" class=" rounded cursor-pointer " style=" width: 80%;" alt="">
               <input type="file" ref="img_store" style=" display: none;" @change="onSelect" >
            </div>
        <div class="col-md-8"> {{FormStore}}
          <h1></h1>
            <label class="form-label fs-6">ຊື່ສິນຄ້າ: <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-2" v-model="FormStore.name" placeholder=".....">

            <label class="form-label fs-6">ຈຳນວນ: <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-2" v-model="FormStore.amount" placeholder="....." >

            <div class="row">
              <div class="col-md-6">
                <label class="form-label fs-6">ລາຄາຊື້: <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-2" v-model="FormStore.price_buy" placeholder=".....">
              </div>
              <div class="col-md-6">
                <label class="form-label fs-6">ລາຄາຂາຍ: <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-2" v-model="FormStore.price_sell" placeholder=".....">
              </div>
            </div>  

        </div>
      </div>
    </div>


    <div v-if="!ShowFrom" class="table-responsive text-nowrap">
      <div class=" d-flex justify-content-between mb-2">
          <div class=" d-flex align-items-center">
            <div class="cursor-pointer" @click="ChangeSort()">
            <i class='bx bx-sort-up fs-4 me-2' v-if="Sort == 'asc'"></i>
            <i class='bx bx-sort-down fs-4 me-2' v-if="Sort == 'desc'"></i>
            </div>
            <select id="defaultSelect" v-model="list_num" @change="GetStore()" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
            </select>
          </div>
          <div class="d-flex">
            <input type="text" class="from-control me-2" placeholder="ຄົ້ນຫາ..." v-model="search" @keyup.enter="GetStore()">
            <button type="button" class=" btn btn-primary" @click="AddStore()"> <i class='bx bx-user-plus' ></i> ເພີ່ມຂໍ້ມູນ </button>
          </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="80">ID</th>
            <th width="120">ຮູບພາບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody v-if="Loading_table">
          <tr>
            <td colspan="5" class="text-center">
                     <div class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
              ກຳລັງໂຫຼດ...</td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td>{{ list.id }}</td>
            <td>
              <img :src="url+'/assets/img/'+list.image" v-if="list.image" class=" rounded w-100" alt="">
              <img :src="url+'/assets/img/no_img.jpg'" v-else class=" rounded w-100" alt="">
            </td>
            <td>
              {{ list.name }}
            </td>
            <td>{{ formatPrice(list.price_buy) }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" @click="EditStore(list.id)" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" @click="DeleteStore(list.id)" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> ລົບຂໍ້ມູນ</a>
                </div>
              </div>
            </td>
          </tr>


        </tbody>
      </table>

      <pagination :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />
    </div>
  </div>
</div>
  </div>
</template>

<script>

import Cleave from 'vue-cleave-component';
import axios from 'axios';
import { useStore } from '../store/auth';
import Pagination from '../components/Pagination.vue';

export default {
  components: { Pagination },
  name: 'Minipos12Store',
  setup(){
    const store = useStore()
    return { store }
  },
  data() {
    return {
      search:'',
      list_num: 5,
      Sort:"asc",
      StoreData:[],
      EditID:'',
      ShowFrom:false,
      FormStore:{
        name:'',
        image:'',
        amount:'',
        price_buy:'',
        price_sell:''
      },
      FormType: true,
      Loading: false,
      Loading_table: false,
            //   options:{
            //     //   prefix: '₭ ',
            //       numeral: true,
            //       numeralPositiveOnly: true,
            //       noImmediatePrefix: true,
            //       rawValueTrimPrefix: true,
            //       numeralIntegerScale: 10,
            //       numeralDecimalScale: 2,
            //       numeralDecimalMark: ',',
            //       delimiter: '.'
            // },
            image_pre: window.location.origin+"/assets/img/add_img.png",
            url: window.location.origin
    };
  },

  mounted() {
    
  },

  computed:{
      CheckForm(){
        if(this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == ''){
            return true
        }else{
           if(this.Loading){
            return true
           }else{
            return false
           }
        }
      }
  },

  methods: {
          RemoveImage(){

            this.FormStore.image = ""
            this.image_pre = window.location.origin+"/assets/img/add_img.png"

            },
        onSelect(event){
            // console.log(event)
            this.FormStore.image = event.target.files[0]
            let reder = new FileReader()
            reder.readAsDataURL(this.FormStore.image)
            reder.addEventListener("load", function(){
                this.image_pre = reder.result
            }.bind(this),false)
        },
      formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
      ChangeSort(){
          if(this.Sort == "asc"){
              this.Sort = "desc"
          }else{
              this.Sort = "asc"
          }
          this.GetStore()
      },
      AddStore(){
          this.FormStore.name='',
          this.FormStore.amount='',
          this.FormStore.price_buy='',
          this.FormStore.price_sell='',
          this.image='',
          this.image_pre=this.url + "/assets/img/add_img.png",
          this.ShowFrom = true,
          this.FormType = true
      },
      CancelStore(){
        this.ShowFrom = false
      },
      SaveStore(){
        if(this.FormType){
            //add
            // console.log('Go!!');
            this.Loading = true
            // setTimeout(() => {
            //   console.log('Run...');
              axios.post("api/store/add",
                this.FormStore,{ headers:{"content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}
                ).then((res)=>{
                    
                    this.Loading = false
                    if(res.data.success){
                        this.ShowFrom = false
                        this.GetStore()
                        this.$swal({
                          toast: true,
                          position: 'top-end',
                          icon: 'success',
                          title: res.data.message,
                          showConfirmButton: false,
                          timer: 1000
                        })
                    }else{
                        this.$swal({
                          // toast: true,
                          position: 'center',
                          icon: 'error',
                          title: 'ຜິດພາດ',
                          text: res.data.message,
                          showConfirmButton: false,
                          timer: 1000
                        })

                    }
                }).catch((err)=>{
                    this.Loading = false
                    console.log(err);
                    if(err.response.status == 401){
                        this.store.remove_token()
                        this.store.remove_user()
                        localStorage.removeItem("web_token")
                        localStorage.removeItem("web_user")
                        this.$router.push("/login")
                    }
                })
            // }, 2000);

        }else{
              this.Loading = true
              axios.post(`api/store/update/${this.EditID}`,
                this.FormStore,{ headers:{"content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}
                ).then((res)=>{
                    
                    this.Loading = false
                    if(res.data.success){
                        this.ShowFrom = false
                        this.GetStore()
                        this.$swal({
                          toast: true,
                          position: 'top-end',
                          icon: 'success',
                          title: res.data.message,
                          showConfirmButton: false,
                          timer: 1000
                        })
                    }else{
                        this.$swal({
                          // toast: true,
                          position: 'center',
                          icon: 'error',
                          title: 'ຜິດພາດ',
                          text: res.data.message,
                          showConfirmButton: false,
                          timer: 1000
                        })
                    }
                }).catch((err)=>{
                    this.Loading = false
                    console.log(err);
                    if(err.response.status == 401){
                        this.store.remove_token()
                        this.store.remove_user()
                        localStorage.removeItem("web_token")
                        localStorage.removeItem("web_user")
                        this.$router.push("/login")
                    }
                })
        }
      },
      EditStore(id){
        this.EditID = id
        this.FormType = false

        axios.get(`api/store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{

            // console.log(res.data)
            this.FormStore = res.data
            this.ShowFrom = true

            //show image form system

            if(res.data.image){
              this.image_pre = this.url + "/assets/img/" + res.data.image
            }else{
              this.image_pre = this.url + "/assets/img/no_img.jpg"
            }

        }).catch((err)=>{
              console.log(err)
              if(err){
                    if(err.response.status == 401){
                        this.store.remove_token()
                        this.store.remove_user()
                        localStorage.removeItem("web_token")
                        localStorage.removeItem("web_user")
                        this.$router.push("/login")
                      }
                    }
          })
      },

      DeleteStore(id){
        this.$swal({
            title: "ທ່ານແນ່ໃຈບໍ່?",
            text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ຢືນຢັນ!",
            cancelButtonText: "ຍົກເລິກ"
            }).then((result) => {
              if (result.isConfirmed) {


                axios.delete(`api/store/delete/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{

                    if(res.data.success){
                        this.GetStore()
                              this.$swal({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: res.data.message,
                                showConfirmButton: false,
                                timer: 1000
                              })
                    }else{
                              this.$swal({
                                // toast: true,
                                position: 'center',
                                icon: 'error',
                                title: 'ຜິດພາດ',
                                text: res.data.message,
                                showConfirmButton: false,
                                timer: 1000
                              })
                    }

                }).catch((err)=>{
                    console.log(err)
                    if(err){
                          if(err.response.status == 401){
                              this.store.remove_token()
                              this.store.remove_user()
                              localStorage.removeItem("web_token")
                              localStorage.removeItem("web_user")
                              this.$router.push("/login")
                            }
                          }
                    })
          }
        })

      },

      GetStore(page){
        this.Loading_table = true
          axios.get(`api/store?page=${page}&sort=${this.Sort}&list_num=${this.list_num}&search=${this.search}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
              this.Loading_table = false
              this.StoreData = res.data

          }).catch((err)=>{
            this.Loading_table = false
              console.log(err)
              if(err){
                    if(err.response.status == 401){
                        this.store.remove_token()
                        this.store.remove_user()
                        localStorage.removeItem("web_token")
                        localStorage.removeItem("web_user")
                        this.$router.push("/login")
                      }
                    }
          })
      }
  },

  created(){
    this.GetStore()
  },

  watch:{
    search(){
      if(this.search == ''){
        this.GetStore()
      }
    }
  },
    components: {
      Cleave
    }
};
</script>
<style scoped>
    .img-remove{
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>