@extends('main')
@section('content')
<div class="card col-6">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-receipt"></i>
    <b>शुल्क भुगतान</b>
    &nbsp;&nbsp;
    <div class="d-inline-block mx-2">
      <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
        <option value="" selected>कक्षा</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
    </div>
    <div class="d-inline-block">
      <input class="form-control form-control-sm" type="text" v-model="roll_no">
    </div>
    <button type="button" class="btn btn-sm rounded-pill btn-info" @click="getByRollNo">
      <i class="menu-icon tf-icons bx bx-search"></i>
    </button>
  </h4>
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-12">
        <label class="form-label">नाम</label>
        <input class="form-control form-control-sm" type="text" v-model="formData.name" disabled>
      </div>
      <div class="col-12">
        <label class="form-label">पिता का नाम</label>
        <input class="form-control form-control-sm" type="text" v-model="formData.father_name" disabled>
      </div>
      <div class="col-6">
        <label class="form-label">कक्षा</label>
        <input class="form-control form-control-sm" type="text" v-model="formData.standard" disabled>
      </div>
      <div class="col-6">
        <label class="form-label">माध्यम</label>
        <input class="form-control form-control-sm" type="text" v-model="formData.medium" disabled>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col-4">
        <label class="form-label">शुल्क</label>
        <select class="form-select form-select-sm" id="exampleFormControlSelect1" v-model="formData.fee_type" @change="getFee" aria-label="Default select example">
          <option value="" selected>शुल्क</option>
          <option value="admission_fee">प्रवेश</option>
          <option value="exam_fee">परीक्षा</option>
          <option value="monthly_fee">मासिक</option>
          <option value="other_fee">अन्य</option>
        </select>
      </div>
      <div class="col-4">
        <label class="form-label">फीस</label>
        <input class="form-control form-control-sm" type="text" v-model="formData.amount" v-bind:disabled="formData.fee_type != 'other_fee'">
      </div>
    </div>
    <div class="row mb-2" v-show="formData.fee_type == 'monthly_fee'">
      <div class="col-4" v-for="month in months" :key="month.id">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" v-model="month.checked" />
          <label class="form-check-label">@{{month.name}}</label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <label class="form-label">कुल फीस</label>
        <input class="form-control form-control-sm" type="text" v-model="totalAmount" disabled>
      </div>
    </div>
    <div class="row">
      <div class="col-4 mx-auto">
        <button type="button" @click="payFee" class="btn rounded-pill btn-success">प्रिंट करें</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const app = Vue.createApp({
      data() {
          return {
            roll_no: '',
            formData: {},
            months: [
              {
                id: 1, name: "जनवरी", checked:false
              },
              {
                id: 2, name: "फ़रवरी", checked:false
              },
              {
                id: 3, name: "मार्च", checked:false
              }
            ]
          }
      },
      computed: {
        totalAmount() {
          if(this.formData.fee_type == 'monthly_fee')
          {
            let selectedMonths = this.months.filter(month => month.checked);
            return this.formData.amount * selectedMonths.length;
          }

          return this.formData.amount;
        }
      },
      methods: {
        async getByRollNo() {
          const response = await fetch("api/student/getByRollNo/" + this.roll_no);
          this.formData = await response.json();
        },
        async getFee() {
          if(this.formData.fee_type == 'other_fee')
          {
            this.formData.amount = 0;
            return;
          }

          const response = await fetch("api/fee/get/" + this.formData.standard + "/" + this.formData.medium + "/" + this.formData.fee_type);
          const amount = (await response.json()).fee;
          this.formData.amount = amount;
        },
        async payFee() {
          const response = await fetch("api/fee/pay/" + this.formData.uuid, {
            method:"POST",
            headers: {
              "Content-Type":"application/json"
            },
            body:JSON.stringify(this.formData)
          });

          if(response.ok)
          {
            window.open("print-receipt", '_blank');
          }
        }
      }
  });

  app.mount('#app');
</script>
@endsection