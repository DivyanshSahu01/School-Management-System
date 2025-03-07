@extends('main')
@section('content')
<div class="card col-6">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-receipt"></i>
    <b>शुल्क भुगतान</b>
    &nbsp;
    <div class="d-inline-block">
      <input class="form-control form-control-sm" type="text" v-model="roll_no">
    </div>
    &nbsp;
    <button type="button" class="btn btn-sm rounded-pill btn-info" @click="getFee">
      <i class="menu-icon tf-icons bx bx-search"></i>
    </button>
  </h4>
  <div class="card-body">
    <form @submit.prevent="payFee">
      <div class="row mb-2">
        <div class="col-6">
          <label class="form-label">नाम</label>
          <input class="form-control form-control-sm" type="text" v-model="formData.name" disabled>
        </div>
        <div class="col-6">
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
          <input class="form-control form-control-sm" pattern="[0-9]+" type="text" v-model="feeType.fee" :disabled="feeType.type != 'other_fee'" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
          <input class="form-check-input" type="checkbox" v-show="feeType.show" v-model="feeType.checked" :disabled="feeType.type == 'other_fee'"/>
        </div>
      </div>
      <div class="row mb-2" v-show="feeTypes[2].checked">
        <div class="col-4" v-for="month in months" :key="month.id" v-show="month.show">
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
          <button type="submit" id="btn_Payfee" class="btn rounded-pill btn-success">प्रिंट करें</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const app = Vue.createApp({
      data() {
          return {
            roll_no: '{{$roll_no}}',
            formData: {},
            feeTypes: [
              {'type':'exam_fee', 'display':'परीक्षा शुल्क', 'fee':0, 'checked':false, 'show':true},
              {'type':'admission_fee', 'display':'प्रवेश शुल्क', 'fee':0, 'checked':false, 'show':true},
              {'type':'monthly_fee', 'display':'मासिक शुल्क', 'fee':0, 'checked':false, 'show':true},
              {'type':'other_fee', 'display':'अन्य शुल्क', 'fee':0, 'checked':true, 'show':true}
            ],
            months: [
              {
                id: 1, name: "जनवरी", checked:false, show:true
              },
              {
                id: 2, name: "फ़रवरी", checked:false, show:true
              },
              {
                id: 3, name: "मार्च", checked:false, show:true
              },
              {
                id: 4, name: "अप्रैल", checked:false, show:true
              },
              {
                id: 5, name: "मई", checked:false, show:true
              },
              {
                id: 6, name: "जून", checked:false, show:true
              },
              {
                id: 7, name: "जुलाई", checked:false, show:true
              },
              {
                id: 8, name: "अगस्त", checked:false, show:true
              },
              {
                id: 9, name: "सितम्बर", checked:false, show:true
              },
              {
                id: 10, name: "अक्टूबर", checked:false, show:true
              },
              {
                id: 11, name: "नवंबर", checked:false, show:true
              },
              {
                id: 12, name: "दिसंबर", checked:false, show:true
              }
            ]
          }
      },
      mounted() {
        if(this.roll_no != '') {
          this.getFee();
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
        async getFee() {
          const response = await fetch("/api/fee/get/" + this.roll_no);
          const result = await response.json();

          this.formData.uuid = result.student.uuid;
          this.formData.name = result.student.name;
          this.formData.father_name = result.student.father_name;
          this.formData.standard = result.student.standard;
          this.formData.medium = result.student.medium;

          this.feeTypes[0].fee = result.Fee.exam_fee;
          this.feeTypes[1].fee = result.Fee.admission_fee;
          this.feeTypes[2].fee = result.Fee.monthly_fee;

          this.feeTypes[0].show = result.studentFee.exam_fee == 0 ? true : false;
          this.feeTypes[1].show = result.studentFee.admission_fee == 0 ? true : false;

          this.months.forEach(month => {
            month.show = result.paidMonths.includes(month.id) ? false: true;
          });
        },
        async payFee() {
          if(parseFloat(this.totalAmount) <= 0)
            return;

          $("#btn_Payfee").attr("style", "display: none !important");
          let selectedMonths = this.months.filter(month => month.checked).map(month => month.id);
          let selectedFeeTypes = this.feeTypes.filter(feeType => feeType.checked);

          const response = await fetch("/api/fee/pay/" + this.formData.uuid, {
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
            window.open("/print-receipt/" + result.id, '_blank');
          }
        }
      }
  });

  app.mount('#app');
</script>
@endsection