@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">

        <div class="row">

            <div class="form-group col-lg-3" >
                <label for="subscription_id">  حالة الطلب </label>
                <select class="form-control " name="status" id="status">
                    <option value="-1">الكل </option>
                    @foreach($statuses as $status)
                    <option value="{{$status->id}}" {{ Request::get('bookstatus')  == $status->id ? "selected" :""}}> {{$status->status_name}} </option>
                    @endforeach
                </select>

            </div>

            @if(Request::get('is_refunded') == 1)
                <input type="hidden"  id="is_refunded" value="0">
                @else
                <input type="hidden"  id="is_refunded" value="-1">
            @endif

            <div class="form-group col-lg-3" >
                <label for="subscription_id">  رقم الحجز </label>
                <input type="text" name="idbooking" id="idbooking" class="form-control ">

            </div>
            <div class="form-group col-lg-3" >
                <label for="subscription_id"> تاريخ الحجز</label>
                <input type="text" name="datepicker" id="datepicker" class="form-control">

            </div>

            <div class="form-group col-lg-3" >
                <label for="subscription_id">  اسم الفهيم</label>
                <input type="text" name="name" id="name" class="form-control ">

            </div>

            <div class="form-group col-lg-3" >
                <label for="subscription_id">   تم الدفع للفيهم </label>
                <select class="form-control " name="payed" id="payed">
                    <option value="-1">الكل </option>
                    <option value="0">No </option>
                    <option value="1">Yes </option>
                </select>

            </div>


        </div>
        <div class="row">
            <div class="form-group col-lg-3">
                <button class="btn btn-success" onclick="search()"> بحث</button>

                <button class="btn btn-warning" onclick="clearData()"> مسح </button>
            </div>
        </div>

        <div class="table-responsive">

        <table class=" table table-striped table-hover ajaxTable datatable datatable-Booking">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.user') }}
                    </th>
                    <th>
                        هاتف الطالب
                    </th>

                    <th>
                        {{ trans('cruds.booking.fields.tutor') }}
                    </th>

                    <th>
                       هاتف الفهيم
                    </th>

                    <th>
                        {{ trans('cruds.booking.fields.date') }}
                    </th>

                    <th>
                        {{ trans('cruds.booking.fields.time') }}
                    </th>

                    <th>
                        {{ trans('cruds.booking.fields.status') }}
                    </th>

                    <th>
                        {{ trans('cruds.booking.fields.payed') }}
                    </th>

                    <th>
                        {{ trans('cruds.booking.fields.total') }}
                    </th>

                    <th>
                       نسبة الفهيم
                    </th>

                    <th>
                        نسبة فهمني
                    </th>


                    <th>
                        اسم البنك
                    </th>

                    <th>
                         اسم الحساب
                    </th>

                    <th>
                        رقم الحساب
                    </th>

                    <th>
                         IBAN
                    </th>

                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker" ).datepicker(
            { dateFormat: 'dd-mm-yy' }
        );
    } );
</script>

<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('booking_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bookings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
      dom: 'Blfrtip',

      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "الكل"]],

      buttons: [
          {
              extend: 'excelHtml5',
              exportOptions: {
                  modifier : {
                      order : 'index', // 'current', 'applied','index', 'original'
                      page : 'all', // 'all', 'current'
                      search : 'none' // 'none', 'applied', 'removed'
                  },
                  columns: [ 0, 1,2 ,3 ,4,5,6,7,8,9 ,10 ,11,12 ,13,14,15,16]
              }
          }

      ],
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.bookings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
 { data: 'user_phone', name: 'user.phone' },
{ data: 'tutor_name', name: 'tutor.name' },
{ data: 'tutor_phone', name: 'tutor.phone' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },

{ data: 'status', name: 'status' },
{ data: 'payed', name: 'payed' ,searchable:false , sortable:false},
{ data: 'total', name: 'total' },
{ data: 'total_tutor_earn', name: 'total_tutor_earn' },
{ data: 'total_fahemni_earn', name: 'total_fahemni_earn' },

        { data: 'bank_name', name: 'bank_name' },
        { data: 'bank_user_name', name: 'bank_user_name' },
        { data: 'bank_account', name: 'bank_account' },
        { data: 'bank_iban', name: 'bank_iban' },

{ data: 'actions', name: '{{ trans('global.actions') }}'  ,searchable:false , sortable:false}
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100
                    @if(session()->get('language') == 'ar')
                ,
                language :{
                    url:"//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json",
                    processing: "<img src='{{url('loading.gif')}}' id='processingloading'>",
                }
                    @endif
  };
        table = $('.datatable-Booking').on('preXhr.dt', function (e, settings, data) {

      data.status   =  $('#status').val() ;
      data.idbooking   =  $('#idbooking').val() ;
      data.date  =  $('#datepicker').val() ;
      data.is_refunded = $('#is_refunded').val() ;
            data.name = $('#name').val() ;
            data.payed = $('#payed').val() ;


  }).DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});


    function payThisBooking(id){

        data={
            '_token' :"{{csrf_token()}}" ,
            'id' : id ,

        };


        $.ajax({
            type:'POST',
            url: '{{url('/payThisBooking')}}',
            data:data,
            success:function(data) {
               console.log(data);
               // location.reload();
            }
        });


    }

    function search(){
        table.ajax.reload();
    }


    function clearData(){
        $('#status').val(-1) ;
        $('#idbooking').val('') ;
        $('#datepicker').val('') ;
        $('#name').val('') ;
        $('#payed').val(-1) ;

        table.ajax.reload();
    }

</script>
@endsection
