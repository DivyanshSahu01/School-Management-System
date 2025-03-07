@extends('main')
@section('content')
<div class="card">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-table"></i>
    <b>छात्र सूची&nbsp;<span class="badge badge-center rounded-pill bg-warning">@{{filteredStudents.length}}</span></b>
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
    <button type="button" class="btn rounded-pill btn-info float-end" @click="addStudent"><i class="menu-icon tf-icons bx bx-user-plus"></i>नया प्रवेश</button>
  </h4>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>नाम</th>
          <th>कक्षा</th>
          <th>संपर्क</th>
          <th>पिता का नाम</th>
          <th>पता</th>
          <th>विकल्प</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <tr v-for="student in filteredStudents">
          <td>@{{student.name}}</td>
          <td><span class="badge bg-label-primary">@{{student.standard}}</span></td>
          <td><span class="badge bg-label-danger">7483487198</span></td>
          <td>@{{student.father_name}}</td>
          <td>@{{student.address}}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" @click="editStudent(student)" href="javascript:void(0);"
                  ><i class="bx bx-edit-alt me-1"></i> एडिट</a
                >
                <a class="dropdown-item" @click="showDeleteModal(student.uuid)" href="javascript:void(0);"
                  ><i class="bx bx-trash me-1"></i> हटाए</a
                >
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
        <h5 class="modal-title"><i class="menu-icon tf-icons bx bx-user"></i> छात्र विवरण</h5>
      </div>
      <form @submit.prevent="saveStudent">
        <div class="modal-body">
          <div class="alert alert-danger alert-dismissible" v-show="errorMessage != ''" role="alert">
            @{{errorMessage}}
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label">नाम</label>
              <input class="form-control form-control-sm" type="text" v-model="formData.name" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
            <div class="col-12">
              <label class="form-label">पिता का नाम</label>
              <input class="form-control form-control-sm" type="text" v-model="formData.father_name" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
            <div class="col-4">
              <label class="form-label">कक्षा</label>
              <select class="form-select form-select-sm" aria-label="Default select example" v-model="formData.standard" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
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
            <div class="col-4">
              <label class="form-label">माध्यम</label>
              <select class="form-select form-select-sm" aria-label="Default select example" v-model="formData.medium" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
                <option value="" selected>माध्यम</option>
                <option value="1">अंग्रेज़ी</option>
                <option value="2">हिन्दी</option>
              </select>
            </div>
            <div class="col-4">
              <label class="form-label">जन्म तिथि</label>
              <input class="form-control form-control-sm" type="date" v-model="formData.date_of_birth" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
            <div class="col-4">
              <label class="form-label">फीस</label>
              <select class="form-select form-select-sm" aria-label="Default select example" v-model="formData.fee_type" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
                <option value="1">आधी</option>
                <option selected value="2">पूरी</option>
              </select>
            </div>
            <div class="col-4">
              <label class="form-label">संपर्क</label>
              <input class="form-control form-control-sm" type="text" v-model="formData.contact" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
            <div class="col-4">
              <label class="form-label">पंजीक्रम</label>
              <input class="form-control form-control-sm" type="text" v-model="formData.roll_no" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label for="exampleFormControlTextarea1" class="form-label">पता</label>
              <textarea class="form-control" rows="3" v-model="formData.address" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn rounded-pill mx-2 btn-warning" data-bs-dismiss="modal">
            बंद करें
          </button>
          <button type="submit" class="btn rounded-pill btn-success">सेव करें</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->

<div class="modal fade" id="largeModal1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-trash me-1"></i> छात्र हटाएं</h5>
      </div>
      <form @submit.prevent="deleteStudent">
        <div class="modal-body">
          <div class="alert alert-danger alert-dismissible" v-show="errorMessage != ''" role="alert">
            @{{errorMessage}}
          </div>
          <div class="row mb-2">
            <div class="col-12">
              क्या आप इस छात्र को स्थायी रूप से हटाना चाहते हैं?
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn rounded-pill mx-2 btn-warning" data-bs-dismiss="modal">
            नहीं
          </button>
          <button type="submit" class="btn rounded-pill btn-success">हाँ</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="content-backdrop fade"></div>
@endsection

@section('scripts')
<script>
  const app = Vue.createApp({
      data() {
          return {
            students: [],
            formData: {},
            search_data: '',
            errorMessage: '',
            studentUUID: '',
            standard: '',
            editMode:false
          }
      },
      mounted(){
        this.listStudents();
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
        async listStudents() {
          const response = await fetch("api/student/list");
          this.students = await response.json();
        },
        addStudent(){
          this.editMode = false;
          this.formData = {};
          $("#largeModal").modal('show');
        },
        editStudent(student){
          this.editMode = true;
          this.formData = {...student};
          $("#largeModal").modal('show');
        },
        showDeleteModal(studentUUID){
          this.studentUUID = studentUUID;
          $("#largeModal1").modal('show');
        },
        async deleteStudent(){
          url = "api/student/delete/" + this.studentUUID;

          const response = await fetch(url, {
            method: "DELETE",
            headers: {
              "Content-Type":'application/json'
            }
          });

          if(response.ok)
          {
            this.listStudents();
            $("#largeModal1").modal('hide');
          }
        },
        async saveStudent() {
          if(this.editMode)
            url = "api/student/edit/" + this.formData.uuid;
          else
            url = "api/student/create";

          const response = await fetch(url, {
            method: "POST",
            headers: {
              "Content-Type":'application/json'
            },
            body: JSON.stringify(this.formData)
          });

          if(response.ok)
          {
            $("#largeModal").modal('hide');
            this.listStudents();
          }
          else
          {
            const result = await response.json();
            this.errorMessage = result.message;

            setTimeout(() => this.errorMessage = '', 5000);
          }
        }
      }
  });

  app.mount('#app')
</script>
@endsection