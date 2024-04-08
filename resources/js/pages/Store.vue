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
        <div class="col-md-4">Image</div>
        <div class="col-md-8"> {{FormStore}}
          <h1></h1>
            <label class="form-label fs-6">ຊື່ສິນຄ້າ: <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-2" v-model="FormStore.name" placeholder=".....">

            <label class="form-label fs-6">ຈຳນວນ: <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-2" v-model="FormStore.amount" placeholder=".....">

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
            <select id="defaultSelect" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
            </select>
          </div>
          <div class="d-flex">
            <input type="text" class="from-control me-2" placeholder="ຄົ້ນຫາ...">
            <button type="button" class=" btn btn-primary" @click="AddStore()"> <i class='bx bx-user-plus' ></i> ເພີ່ມຂໍ້ມູນ </button>
          </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບພາບ</th>
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
          <tr v-for="list in StoreData" :key="list.id">
            <td>{{ list.id }}</td>
            <td>{{ list.image }}</td>
            <td>
              {{ list.name }}
            </td>
            <td>{{ list.price_buy }}</td>
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
    </div>
  </div>
</div>
  </div>
</template>

<script>
import axios from 'axios';
import { useStore } from '../store/auth';

export default {
  name: 'Minipos12Store',
  setup(){
    const store = useStore()
    return { store }
  },
  data() {
    return {
      Sort:"asc",
      StoreData:[],
      EditID:'',
      ShowFrom:false,
      FormStore:{
        name:'',
        amount:'',
        price_buy:'',
        price_sell:''
      },
      FormType: true,
      Loading: false,
      Loading_table: false,

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
          this.ShowFrom = true,
          this.FormType = true
      },
      CancelStore(){
        this.ShowFrom = false
      },
      SaveStore(){
        if(this.FormType){
            //add
            console.log('Go!!');
            this.Loading = true
            setTimeout(() => {
              console.log('Run...');
              axios.post("api/store/add",
                this.FormStore,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}
                ).then((res)=>{
                    
                    this.Loading = false
                    if(res.data.success){
                        this.ShowFrom = false
                        this.GetStore()
                    }else{


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
            }, 2000);

        }else{
              this.Loading = true
              axios.post(`api/store/update/${this.EditID}`,
                this.FormStore,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}
                ).then((res)=>{
                    
                    this.Loading = false
                    if(res.data.success){
                        this.ShowFrom = false
                        this.GetStore()
                    }else{

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
          axios.delete(`api/store/delete/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{

              if(res.data.success){
                  this.GetStore()
              }else{

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

      GetStore(){
        this.Loading_table = true
          axios.get(`api/store`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
              this.Loading_table = false
              this.StoreData = res.data

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
  },

  created(){
    this.GetStore()
  }
};
</script>
<style lang="scss" scoped>

</style>