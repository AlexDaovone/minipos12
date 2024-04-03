<template>
  <div>
<div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="!ShowFrom">
      <div class="row">
        <div class="col-md-4">Image</div>
        <div class="col-md-8">data

            <label class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
            <input type="text" class="form-control mb-2" placeholder=".....">
            <label class="form-label fs-6">ຈຳນວນ:</label>
            <input type="text" class="form-control mb-2" placeholder=".....">
        </div>
      </div>
    </div>


    <div class="table-responsive text-nowrap">
      <div class=" d-flex justify-content-between mb-2">
          <div class=" d-flex align-items-center">
            <i class='bx bx-sort-up fs-4 me-2'></i>

            <select id="defaultSelect" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
            </select>
          </div>
          <div class=" d-flex">
            <input type="text" class="from-control me-2" placeholder="ຄົ້ນຫາ...">
            <button type="button" class=" btn btn-pr  imary"> <i class='bx bx-user-plus' ></i> ເພີ່ມຂໍ້ມູນ</button>
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
        <tbody>
          <tr>
            <td><i class="bx bxl-angular bx-sm text-danger me-3"></i> <span class="fw-medium">Angular Project</span></td>
            <td>Albert Cook</td>
            <td>
              ການ
            </td>
            <td><span class="badge bg-label-primary me-1">Active</span></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> ລົບຂໍ້ມູນ</a>
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
export default {
  name: 'Minipos12Store',

  data() {
    return {
      ShowFrom:false,
    };
  },

  mounted() {
    
  },

  methods: {
    
  },
};
</script>
<style lang="scss" scoped>

</style>