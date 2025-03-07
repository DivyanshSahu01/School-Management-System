@extends('main')
@section('content')
<div class="card">
  <h4 class="card-header">
    <form @submit.prevent="listIncomeExpense">
      <i class="menu-icon tf-icons bx bx-wallet"></i>
      <b>आय-व्यय</b>&nbsp;&nbsp;
      <div class="d-inline-block">
        <input type="date" v-model="fromDate" class="form-control" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">      
      </div>
      <label class="form-label form-label-lg">
        &nbsp;&nbsp;<b>से</b>&nbsp;&nbsp;
      </label>
      <div class="d-inline-block">
        <input type="date" v-model="toDate" class="form-control" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">      
      </div>
      &nbsp;
      <button type="submit" class="btn btn-sm rounded-pill btn-info"><i class="menu-icon tf-icons bx bx-search"></i></button>
      <button type="button" class="btn rounded-pill btn-danger float-end" data-bs-toggle="modal" data-bs-target="#largeModal"><i class="menu-icon tf-icons bx bx-money-withdraw"></i>व्यय जोड़ें</button>
    </form>
  </h4>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>समय</th>
          <th>विवरण</th>
          <th>राशि</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" >
        <tr v-for="transaction in transactions">
          <td>@{{transaction.created_at}}</td>
          <td><span class="badge bg-label-warning">@{{transaction.description}}</span></td>
          <td><span class="badge" :class="transaction.amount < 0 ? 'bg-label-danger': 'bg-label-success'">@{{transaction.amount}}</span></td>
        </tr>
        <tr>
          <td></td>
          <th>योग:</td>
          <td>@{{totalAmount}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3"><i class="menu-icon tf-icons bx bx-money-withdraw"></i>व्यय जोड़ें</h5>
      </div>
      <form @submit.prevent="saveExpense">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label class="form-label">राशि</label>
              <input class="form-control form-control-sm" v-model="formData.amount" pattern="[0-9]+" type="text" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')">
            </div>
            <div class="col-12">
              <label for="exampleFormControlTextarea1" class="form-label">विवरण</label>
              <textarea class="form-control" v-model="formData.description" id="exampleFormControlTextarea1" rows="3" required oninvalid="this.setCustomValidity('कृपया इसे भरें')" oninput="this.setCustomValidity('')"></textarea>
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
            formData: {},
            transactions: [],
            totalAmount: 0,
            loading: false
          }
      },
      methods: {
        async listIncomeExpense() {
          const response = await fetch("api/expense/list/" + this.fromDate + "/" + this.toDate);
          this.transactions = await response.json();
          this.totalAmount = this.transactions.map(transaction => transaction.amount).reduce((acc, amount) => acc + amount);
        },
        // editFee(fee) {
        //   this.formData = {...fee};
        //   $("#largeModal").modal('show');
        // },
        async saveExpense(){
          if (this.loading) 
            return;

          this.loading = true;
          const response = await fetch("api/expense/create", {
            method:"POST",
            headers: {
              "Content-Type":"application/json"
            },
            body:JSON.stringify(this.formData)
          });

          if(response.ok)
          {
            $("#largeModal").modal('hide');
            this.listIncomeExpense();
            this.loading = false;
          }
        }
      }
  })

  app.mount('#app');
</script>
@endsection