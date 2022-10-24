@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>



    <div class="card-body">
        <div class="row">





            <div class="form-group col-lg-3" >
                <label for="subscription_id">حالة التفعيل</label>
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

            <div class="form-group col-lg-3" >
                <label for="subscription_id"> الجامعة</label>
                <select class="form-control " name="univ" id="univ">

                    <option value="0">الكل </option>
                    @foreach($univs as $univ)
                    <option value="{{$univ->id}}">  {{ $univ->name }} </option>
                        @endforeach

                </select>

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
                       التفعيل
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.country') }}
                    </th>

                    <th>
                        {{ trans('cruds.user.fields.level') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.university') }}
                    </th>

                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalAcceptReject">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">قبول أو رفض المعلم </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">

                    <input type="hidden" name="teacher_id" id="teacher_id" >
                    <label>اختر الاجراء</label>
                    <div class="radio-inline">
                        <label class="radio radio-square">
                            <input type="radio" checked="checked" id="radio1" name="radios13_1" value="1">
                            <span></span>قبول</label>
                        <label class="radio radio-square radio-danger">
                            <input type="radio" name="radios13_1"id="radio2" value="0">
                            <span></span>رفض</label>




                    </div>

                </div>
                <div class="form-group" id="textareaAccept">
                    <label for="exampleTextarea">ارسال رسالة للمستخدم</label>
                    <textarea class="form-control form-control-solid" id="reason" rows="3" name="reason"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="sendAccept()">حفظ</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>

    $(document).ready(function(){
        $('#textareaAccept').hide();
    });

    function sendAccept(){
        teacher_id =  $('#teacher_id').val();
        accept = $('input[name="radios13_1"]:checked').val();
        text = $('#reason').val();

        if(accept == 0 && text == ''){
            $('#reason').addClass('is-invalid');
            return ;
        }
        data={
            '_token' :"{{csrf_token()}}" ,
            'user_id' : teacher_id ,
            'accept' : accept ,
            'text' : text
        };


        $.ajax({
            type:'POST',
            url:'{{url('admin/acceptTeacher')}}',
            data:data,
            success:function(data) {
               location.reload();
            }
        });
    }
    $('#radio1').click(function() {
        $('#textareaAccept').hide();
    });
    $('#radio2').click(function() {
           $('#textareaAccept').show();
    });

    function openPOP(id) {
        $('#reason').removeClass('is-invalid');
        $('#reason').val('');
        $('#teacher_id').val(id);
        $('#modalAcceptReject').modal('show');
    }

    function search(){
        table.ajax.reload();
    }


    function clearData(){
        console.log('this will clear now');
        $('#status').val(-1) ;
        $('#phone').val('') ;
        $('#name').val('') ;
        $('#univ').val(0) ;
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
    ajax: "{{ route('admin.teachers.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },

{ data: 'verify', name: 'verify' },
{ data: 'phone', name: 'phone' },
{ data: 'status', name: 'status' ,searchable:false , sortable:false},
{ data: 'country_name_ar', name: 'country.name_ar' },

{ data: 'level_name_ar', name: 'level.name_ar' },
{ data: 'university_name_en', name: 'university.name_en' },

{ data: 'actions', name: '{{ trans('global.actions') }}' ,searchable:false , sortable:false }
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
          data.university_id   =  $('#univ').val() ;

      })

      .DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});






</script>
@endsection
