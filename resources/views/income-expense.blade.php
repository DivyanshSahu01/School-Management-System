@extends('main')
@section('content')
<div class="card">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-wallet"></i>
    <b>आय व्यय</b>
    &nbsp;&nbsp;
    <div class="d-inline-block">
      <input type="date" class="form-control">      
    </div>
    <label class="form-label form-label-lg">
      <b>से</b>
    </label>
    <div class="d-inline-block">
      <input type="date" class="form-control">      
    </div>
    &nbsp;
    <button type="button" class="btn btn-sm rounded-pill btn-info"><i class="menu-icon tf-icons bx bx-search"></i></button>
    <button type="button" class="btn rounded-pill btn-danger float-end" data-bs-toggle="modal" data-bs-target="#largeModal"><i class="menu-icon tf-icons bx bx-money-withdraw"></i>व्यय जोड़ें</button>
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
      <tbody class="table-border-bottom-0">
        <tr>
          <td>Angular Project</td>
          <td><span class="badge bg-label-warning">10</span></td>
          <td><span class="badge bg-label-danger">7483487198</span></td>
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
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12">
            <label class="form-label">राशि</label>
            <input class="form-control form-control-sm" type="text">
          </div>
          <div class="col-12">
            <label for="exampleFormControlTextarea1" class="form-label">विवरण</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn rounded-pill mx-2 btn-warning" data-bs-dismiss="modal">
          बंद करें
        </button>
        <button type="button" class="btn rounded-pill btn-success">सेव करें</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="content-backdrop fade"></div>
@endsection