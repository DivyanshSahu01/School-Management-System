@extends('main')
@section('content')
<div class="card">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-table"></i>
    <b>भुगतान सूची</b>
    <div class="d-inline-block mx-2">
      <select class="form-select" v-model="standard" aria-label="Default select example">
        <option value="" selected>कक्षा</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>
    </div>
    <div class="d-inline-block mx-2">
      <input class="form-control form-control-sm" type="text" v-model="search_data">
    </div>
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
        <tr v-for="student in filteredStudents">
          <td>@{{student.name}}</td>
          <td>@{{student.father_name}}</td>
          <td>@{{student.student_fee?.admission_fee ?? 0}}</td>
          <td>@{{student.student_fee?.exam_fee ?? 0}}</td>
          <td>@{{student.student_fee?.january ?? 0}}</td>
          <td>@{{student.student_fee?.february ?? 0}}</td>
          <td>@{{student.student_fee?.march ?? 0}}</td>
          <td>@{{student.student_fee?.april ?? 0}}</td>
          <td>@{{student.student_fee?.may ?? 0}}</td>
          <td>@{{student.student_fee?.june ?? 0}}</td>
          <td>@{{student.student_fee?.july ?? 0}}</td>
          <td>@{{student.student_fee?.august ?? 0}}</td>
          <td>@{{student.student_fee?.september ?? 0}}</td>
          <td>@{{student.student_fee?.october ?? 0}}</td>
          <td>@{{student.student_fee?.november ?? 0}}</td>
          <td>@{{student.student_fee?.december ?? 0}}</td>
          <td>@{{student.student_fee?.other_fee ?? 0}}</td>
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
            standard: '',
            search_data: '',
            receipts: []
          }
      },
      mounted(){
        this.listFees();
      },
      computed: {
        filteredStudents(){
          let filteredStudents = this.students;
          if(this.standard != ''){
            filteredStudents = filteredStudents.filter((student) => student.standard == this.standard);
          }
          if(this.search_data != ''){
            const query = this.search_data.toLowerCase();
            filteredStudents = filteredStudents.filter((student) => Object.values(student).some(item => String(item).toLowerCase().includes(query)));
          }
          return filteredStudents;
        }
      },
      methods: {
        async listFees() {
          const response = await fetch("api/student/listFees");
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