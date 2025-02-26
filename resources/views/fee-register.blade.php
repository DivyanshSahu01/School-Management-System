@extends('main')
@section('content')
<div class="card">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-table"></i>
    <b>छात्र सूची</b>
    <div class="d-inline-block mx-2">
      <select class="form-select" @change="listFees" v-model="standard" aria-label="Default select example">
        <option value="" selected>कक्षा</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
    </div>
    <button type="button" class="btn rounded-pill btn-info float-end" @click="addStudent"><i class="menu-icon tf-icons bx bx-user-plus"></i>नया प्रवेश</button>
  </h4>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>नाम</th>
          <th>पिता का नाम</th>
          <th>प्रवेश शुल्क</th>
          <th>परीक्षा शुल्क</th>
          <th>जनवरी</th>
          <th>फ़रवरी</th>
          <th>मार्च</th>
          <th>अप्रैल</th>
          <th>मई</th>
          <th>जून</th>
          <th>जुलाई</th>
          <th>अगस्त</th>
          <th>सितंबर</th>
          <th>अक्टूबर</th>
          <th>नवंबर</th>
          <th>दिसंबर</th>
          <th>अन्य</th>
          <th>विकल्प</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <tr v-for="student in students">
          <td>@{{student.name}}</td>
          <td>@{{student.father_name}}</td>
          <td>@{{student.student_fee.admission_fee}}</td>
          <td>@{{student.student_fee.exam_fee}}</td>
          <td>@{{student.student_fee.january}}</td>
          <td>@{{student.student_fee.february}}</td>
          <td>@{{student.student_fee.march}}</td>
          <td>@{{student.student_fee.april}}</td>
          <td>@{{student.student_fee.may}}</td>
          <td>@{{student.student_fee.june}}</td>
          <td>@{{student.student_fee.july}}</td>
          <td>@{{student.student_fee.august}}</td>
          <td>@{{student.student_fee.september}}</td>
          <td>@{{student.student_fee.october}}</td>
          <td>@{{student.student_fee.november}}</td>
          <td>@{{student.student_fee.december}}</td>
          <td>@{{student.student_fee.other_fee}}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" @click="listReceipts(student.uuid)" href="javascript:void(0);"><i class="bx bx-receipt me-1"></i> रसीद</a>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!-- / Content -->

<!-- Modal -->
<div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>क्रमाँक</th>
                  <th>शुल्क</th>
                  <th>दिनांक</th>
                  <th>प्रिंट करें</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr v-for="receipt in receipts">
                  <td>@{{receipt.id}}</td>
                  <td>@{{receipt.admission_fee + receipt.exam_fee + receipt.other_fee + receipt.monthly_fee}}</td>
                  <td>@{{receipt.created_at}}</td>
                  <td>
                    <a class="dropdown-item" v-bind:href="'print-receipt/'+receipt.id" target="_blank"><i class="bx bx-receipt me-1"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn rounded-pill mx-2 btn-warning" data-bs-dismiss="modal">
          बंद करें
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="content-backdrop fade"></div>
@endsection

@section('scripts')
<script>
  const app = Vue.createApp({
      data() {
          return {
            students: [],
            standard: 1,
            receipts: []
          }
      },
      mounted(){
        this.listFees();
      },
      methods: {
        async listFees() {
          const response = await fetch("api/student/listFees/" + this.standard);
          this.students = await response.json();
        },
        async listReceipts(studentUUID) {
          const response = await fetch("api/receipt/list/" + studentUUID);
          this.receipts = await response.json();
          $("#largeModal").modal('show');
        }
      }
  });

  app.mount('#app');
</script>
@endsection