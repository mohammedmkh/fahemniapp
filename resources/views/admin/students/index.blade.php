@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="row">

            <div class="form-group col-lg-3" >
                <label for="subscription_id"> تفعيل sms</label>
                <select class="form-control " name="status" id="status">

                    <option value="-1">الكل </option>
                    <option value="0"> غير مفعل </option>
                    <option value="1">  مفعل </option>
                </select>

            </div>
            <div class="form-group col-lg-3" >
                <label for="subscription_id">  الاسم</label>
                <input type="text" name="name" id="name" class="form-control ">

            </div>
            <div class="form-group col-lg-3" >
                <label for="subscription_id"> رقم الموبايل</label>
                <input type="text" name="phone" id="phone" class="form-control ">

            </div>





        </div>
        <div class="row">
            <div class="form-group col-lg-3">
                <button class="btn btn-success" onclick="search()"> بحث</button>

                <button class="btn btn-warning" onclick="clearData()"> مسح </button>
            </div>
        </div>

        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.user.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>


                    <th>
                        {{ trans('cruds.user.fields.verify') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.sex') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.age') }}
                    </th>

                    <th>
                        {{ trans('cruds.user.fields.level') }}
                    </th>


                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>

    function search(){
        table.ajax.reload();
    }


    function clearData(){
        $('#status').val(-1) ;
        $('#phone').val('') ;
        $('#name').val('') ;

        table.ajax.reload();
    }
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.students.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },
{ data: 'verify', name: 'verify' },
{ data: 'phone', name: 'phone' },
{ data: 'sex', name: 'sex' },
{ data: 'age', name: 'age' , searchable:false , sortable:false},


{ data: 'level_name_ar', name: 'level.name_ar' },

{ data: 'actions', name: '{{ trans('global.actions') }}' , searchable:false , sortable:false}
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
   table = $('.datatable-User')
      .on('preXhr.dt', function (e, settings, data) {

          data.status   =  $('#status').val() ;
          data.phone   =  $('#phone').val() ;
          data.name   =  $('#name').val() ;


      })
      .DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
