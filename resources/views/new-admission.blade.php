@extends('main')
@section('content')
<div class="card col-6">
  <h4 class="card-header">
    <i class="menu-icon tf-icons bx bx-user-plus"></i><b>नया प्रवेश</b>
  </h4>
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-12">
        <label class="form-label">नाम</label>
        <input class="form-control form-control-sm" type="text">
      </div>
      <div class="col-12">
        <label class="form-label">पिता का नाम</label>
        <input class="form-control form-control-sm" type="text">
      </div>
      <div class="col-4">
        <label class="form-label">कक्षा</label>
        <select class="form-select form-select-sm" id="exampleFormControlSelect1" aria-label="Default select example">
          <option value="" selected>कक्षा</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div>
      <div class="col-4">
        <label class="form-label">माध्यम</label>
        <select class="form-select form-select-sm" id="exampleFormControlSelect1" aria-label="Default select example">
          <option value="" selected>माध्यम</option>
          <option value="अंग्रेज़ी">अंग्रेज़ी</option>
          <option value="हिन्दी">हिन्दी</option>
        </select>
      </div>
      <div class="col-4">
        <label class="form-label">जन्म तिथि</label>
        <input class="form-control form-control-sm" type="date">
      </div>
      <div class="col-4">
        <label class="form-label">फीस</label>
        <select class="form-select form-select-sm" id="exampleFormControlSelect1" aria-label="Default select example">
          <option value="आधी">आधी</option>
          <option selected value="पूरी">पूरी</option>
        </select>
      </div>
      <div class="col-8">
        <label class="form-label">संपर्क</label>
        <input class="form-control form-control-sm" type="text">
      </div>
    </div>
    <div class="row mb-2">
      <div class="col-12">
        <label for="exampleFormControlTextarea1" class="form-label">पता</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <button type="button" class="btn rounded-pill btn-success float-end">सेव करें</button>
        <button type="button" class="btn rounded-pill mx-2 btn-warning float-end">हटाएं</button>
      </div>
    </div>
  </div>
</div>
@endsection