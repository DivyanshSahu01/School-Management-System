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
      <div class="col-4" v-for="feeType in feeTypes">
        <label class="form-label">@{{feeType.display}}</label>
        <input class="form-control form-control-sm" type="text" v-model="feeType.fee" :disabled="feeType.type != 'other_fee'">
        <input class="form-check-input" type="checkbox" v-model="feeType.checked" :disabled="feeType.type == 'other_fee'"/>
      </div>
    </div>
    <div class="row mb-2" v-show="feeTypes[2].checked">
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
            feeTypes: [
              {'type':'exam_fee', 'display':'परीक्षा शुल्क', 'fee':0, 'checked':false},
              {'type':'admission_fee', 'display':'प्रवेश शुल्क', 'fee':0, 'checked':false},
              {'type':'monthly_fee', 'display':'मासिक शुल्क', 'fee':0, 'checked':false},
              {'type':'other_fee', 'display':'अन्य शुल्क', 'fee':0, 'checked':true}
            ],
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
          let selectedMonths = this.months.filter(month => month.checked);
          let sum = 0;
          this.feeTypes.forEach(feeType => {
            if(feeType.checked)
            {
              if(feeType.type == 'monthly_fee')
              {
                sum += parseFloat(feeType.fee) * selectedMonths.length;
              }
              else
              {
                sum += parseFloat(feeType.fee);
              }
            }
          });
          return sum;

          return this.feeTypes.reduce((sum, fee) => fee.checked ? sum + parseFloat(fee.fee) : sum + 0, 0);
        }
      },
      methods: {
        async getByRollNo() {
          const response = await fetch("api/student/getByRollNo/" + this.roll_no);
          this.formData = await response.json();
          this.getFee();
        },
        async getFee() {
          const response = await fetch("api/fee/get/" + this.formData.standard + "/" + this.formData.medium);
          const result = await response.json();

          this.feeTypes[0].fee = result.exam_fee;
          this.feeTypes[1].fee = result.admission_fee;
          this.feeTypes[2].fee = result.monthly_fee;
        },
        async payFee() {
          let selectedMonths = this.months.filter(month => month.checked).map(month => month.id);
          let selectedFeeTypes = this.feeTypes.filter(feeType => feeType.checked);

          const response = await fetch("api/fee/pay/" + this.formData.uuid, {
            method:"POST",
            headers: {
              "Content-Type":"application/json"
            },
            body:JSON.stringify
            (
              {
                selectedFeeTypes: JSON.stringify(selectedFeeTypes),
                months: selectedMonths.toString()
              }
            )
          });

          if(response.ok)
          {
            const result = await response.json();
            window.open("print-receipt/" + result.id, '_blank');
          }
        }
      }
  });

  app.mount('#app');
</script>
@endsection