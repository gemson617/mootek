@extends('layouts.app')

@section('content')
<style>
    .btn:focus {
        background-color: #2C3333;
        box-shadow: 10px 10px 10px 10px #2C3333;

    }
    .btn-sm:focus {
        background-color: #2C3333;
        box-shadow:10px 10px 10px 10px #2C3333;
    }
    .button:focus {
        background-color: #2C3333;
        box-shadow: 10px 10px 10px 100px #2C3333;
    }
    </style>
<div class="app-content page-body">
    <div class="container">
        <div class="page-header">
            <div class="page-leftheader">
              <h4 class="page-title">Schedule Order List</h4>
                  <ol class="breadcrumb pl-0">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item"><a href="#">Customers - {{$id}}</a></li>
                      <li class="breadcrumb-item"><a href="#">Add Customer</a></li>
                  </ol>
            </div>
        </div>
        <div class="row">
          <div class="col-md-2">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#mainModal">Schedule Order</button>
      </div>
      </div>

      <div class="modal fade" id="mainModal" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title" id="exampleModalLabel">Schedule Order</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form  class="ajaxForm" id="ajaxForm_sche_order">

                    <input type="hidden" id="form_ready" name="form_ready" value="1">
                    <input type="hidden" id="customer_id" name="customer_id" value="{{$id}}">

                    <div class="row" style="margin-left:10px;">
                      <div class="col-md-3">
                          <label>Mon (Avg 0.0)</label>
                          <div id="offer" style="">
                          <input type="hidden" name="mon_day1" value="" />
                          <input type="checkbox"
                             id="offer_checkbox"
                              class="form-control" name="mon_day" value="Monday"><br>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label>Tue (Avg 0.0)</label>
                            <div id="offer" style="">
                              <input type="hidden" name="tues_day1" value="" />
                            <input type="checkbox"
                               id="offer_checkbox"
                                class="form-control" name="tues_day" value="Tuesday"><br>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label>Wed (Avg 0.0)</label>
                              <div id="offer" style="">
                              <input type="hidden" name="wed_day1" value="" />
                              <input type="checkbox"
                                 id="offer_checkbox"
                                  class="form-control" name="wed_day" value="Wednesday"><br>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label>Thu (Avg 0.0)</label>
                                <div id="offer" style="">
                                <input type="hidden" name="thu_day1" value="" />
                                <input type="checkbox"
                                   id="offer_checkbox"
                                    class="form-control" name="thu_day" value="Thursday"><br>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <label>Fri (Avg 0.0)</label>
                                  <div id="offer" style="">
                                  <input type="hidden" name="fri_day1" value="" />
                                  <input type="checkbox"
                                     id="offer_checkbox"
                                      class="form-control" name="fri_day" value="Friday"><br>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <label>Sat (Avg 0.0)</label>
                                    <div id="offer" style="">
                                    <input type="hidden" name="sat_day1" value="" />
                                    <input type="checkbox"
                                       id="offer_checkbox"
                                        class="form-control" name="sat_day" value="Saturday"><br>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <label>Sun (Avg 0.0)</label>
                                      <div id="offer" style="">
                                      <input type="hidden" name="sun_day1" value="" />
                                      <input type="checkbox"
                                         id="offer_checkbox"
                                          class="form-control" name="sun_day" value="Sunday"><br>
                                        </div>
                                      </div>
                    </div>
                    <br style="clear:both;">
                    <br>
                    <div class="formItem">
                      <label for="week_no">Every</label>
                      <br>
                      <select class="form-control" id="week_no" name="week_no">
                        <option value="0" selected="">NONE</option>
                        <option value="1">1ST</option>
                        <option value="2">2ND</option>
                        <option value="3">3RD</option>
                        <option value="4">4TH</option>
                      </select>
                    </div>
                    <div class="formItem">
                      <label for="day_no">day</label>
                      <br>
                      <select class="form-control" id="day_no" name="day_no">
                        <option value=""> --SELECT-- </option>
                        <option value="Monday">MON</option>
                        <option value="Tuesday">TUE</option>
                        <option value="Wednesday">WED</option>
                        <option value="Thursday">THU</option>
                        <option value="Friday">FRI</option>
                        <option value="Saturday">SAT</option>
                        <option value="Sunday">SUN</option>
                      </select>
                    </div>
                  <div class="formItem">
                    <label for="delEvery">Deliver Every</label>
                    <br>
                    <input type="hidden" name="delEvery" value="0">
                    <input type="checkbox" id="delEvery" name="delEvery" checked="">
                    <br>
                  </div>
                    <br style="clear:both;">
                    <br>
                    <div class="formItem">
                      <label for="startdate">Start Date</label>
                      <br>
                      <input type="date"
                          name="start_date" id="startdate"
                          class="form-control">
                      <!-- <input type="text" class="form-control" id="startdate" name="startdate" value="2022/07/03" class="hasDatepicker"> -->
                    </div>

                    <div class="formItem">
                      <br>
                      <a href="#">Clear</a>
                    </div>
                    <br style="clear:both;">
                    <br>
                    <div class="formItem">
                      <label for="enddate">End Date</label>
                      <br>
                      <input type="date"
                          name="end_date" id="end_date"
                          class="form-control">
                      <!-- <input type="text" class="form-control" id="enddate" name="enddate" value="2022/07/29" class="hasDatepicker"> -->
                    </div>

                    <div class="formItem">
                      <br>
                      <a href="#">Clear</a>
                    </div>
                    <br style="clear:both;">
                    <br>
                    <input class="btn btn-success" style="color:#fff;" type="submit" value="Save changes" >
                    <br>
                    <br>
                    </form>

                  </div>
                  <!-- <div class="modal-footer"> -->
                  <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                  <!-- </div> -->
              </div>
          </div>
      </div>
        <!--row open-->
        <!--row closed-->
    </div>
</div>
<script>
  $('#mainModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  })

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#ajaxForm_sche_order').submit(function(e) {
      e.preventDefault();
      // var formData = new FormData();
      // alert(formData);
      var custom_id = $('#customer_id').val();
      // alert(custom_id);
      let formData = new FormData(this);
      // console.log(formData);
      $.ajax({
          type: 'POST',
          url: '{{route("customer.scheduled_order_insert")}}',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(data) {
              // alert(JSON.stringify(data));
              // $('#suseee').html(data
              //   if(data==1){
              // window.location = '/order/list/' + custom_id + '/' + 0;
              // }

          },
          error: function(data) {
              console.log(data);
          }
      });
  });
</script>
@endsection
