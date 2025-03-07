@extends('main')
@section('content')
<div class="card">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-cog"></i>
    <b>सेटिंग्स</b>
    <div class="d-inline-block mx-2">
      <select class="form-select" id="exampleFormControlSelect1" v-model="medium" aria-label="Default select example" @change="listFees(medium)">
        <option value="1">अंग्रेज़ी</option>
        <option value="2">हिन्दी</option>
      </select>
    </div>
  </h4>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>कक्षा</th>
          <th>प्रवेश शुल्क</th>
          <th>परीक्षा शुल्क</th>
          <th>मासिक शुल्क</th>
          <th>विकल्प</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <tr v-for="fee in fees">
          <td>@{{fee.standard}}</td>
          <td><span class="badge bg-label-success">@{{fee.admission_fee}}</span></td>
          <td><span class="badge bg-label-warning">@{{fee.exam_fee}}</span></td>
          <td><span class="badge bg-label-danger">@{{fee.monthly_fee}}</span></td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);" @click="editFee(fee)"><i class="bx bx-edit-alt me-1"></i> एडिट</a>
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
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3"><i class="bx bx-edit-alt me-1"></i> शुल्क विवरण</h5>
      </div>
      <form @submit.prevent="saveFee">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label">कक्षा</label>
              <input class="form-control form-control-sm" type="text" v-model="formData.standard" disabled>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label">माध्यम</label>
              <input class="form-control form-control-sm" type="text" v-model="formData.medium" disabled>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label">प्रवेश शुल्क</label>
              <input class="form-control form-control-sm" type="number" v-model="formData.admission_fee" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label">परीक्षा शुल्क</label>
              <input class="form-control form-control-sm" type="number" v-model="formData.exam_fee" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label">मासिक शुल्क</label>
              <input class="form-control form-control-sm" type="number" v-model="formData.monthly_fee" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
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
<div class="content-backdrop fade"></div>
@endsection

@section('scripts')
<script>
  const app = Vue.createApp({
      data() {
          return {
            fees: [],
            formData: {},
            medium: 1
          }
      },
      mounted(){
        this.listFees(this.medium)
      },
      methods: {
        async listFees(medium) {
          this.fees = [];
          const response = await fetch("api/fee/list/"+medium);
          this.fees = await response.json();
        },
        editFee(fee) {
          this.formData = {...fee};
          $("#largeModal").modal('show');
        },
        async saveFee(){
          const response = await fetch("api/fee/edit/" + this.formData.standard + "/" + this.formData.medium, {
            method:"POST",
            headers: {
              "Content-Type":"application/json"
            },
            body:JSON.stringify(this.formData)
          });

          if(response.ok)
          {
            $("#largeModal").modal('hide');
            this.listFees(this.medium);
          }
        }
      }
  })

  app.mount('#app')
</script>
@endsection