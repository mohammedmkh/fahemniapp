@extends('layouts.admin')
@section('content')

<div class="card">

    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label"> طلبات اضافة مواد </h3>
        </div>

    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Course">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.course.fields.id') }}
                    </th>
                    <th>
                       اسم المادة
                    </th>
                    <th>
                       الكود
                    </th>
                    <th>
                       التفاصيل
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
                <h5 class="modal-title">قبول أو رفض اضافة المادة </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label> اسم المادة</label>
                    <input type="text" class="form-control" name="course_name" id="course_name" >

                </div>

                <div class="form-group">
                    <label> كود المادة</label>
                    <input type="text" class="form-control" name="course_code" id="course_code" >

                </div>

                <div class="form-group">

                    <input type="hidden" name="courserequest_id" id="courserequest_id" >
                    <label>اختر الاجراء</label>

                    <div class="radio-inline">
                        <label class="radio radio-square">


                            <input type="radio" checked="checked" id="radio1" name="radios13_1" value="1">
                            <span></span>قبول</label>
                        <label class="radio radio-square radio-danger">
                            <input type="radio" name="radios13_1"id="radio2" value="0">
                            <span></span>رفض</label>




                    </div>
                    <div style="margin-bottom: 10px"></div>
                    <label >اختر المادة او القسم الرئيسي التابع له المادة</label>
                    <div class="">
                        <select class="form-control" id="parent_course">
                            @foreach($courses as $c)
                            <option value="{{$c->id}}"> {{$c->name}}</option>
                                @endforeach
                        </select>
                    </div>


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

    function openPOPCourse(id , course_name , course_code) {

        $('#courserequest_id').val(id);
        $('#course_name').val(course_name);
        $('#course_code').val(course_code);
        $('#modalAcceptReject').modal('show');
    }
    function sendAccept(){
        course_name =  $('#course_name').val();
        courserequest_id =  $('#courserequest_id').val();
        course_code =  $('#course_code').val();
        accept = $('input[name="radios13_1"]:checked').val();
        parent_course =  $('#parent_course').val();



        data={
            '_token' :"{{csrf_token()}}" ,
            'courserequest_id' : courserequest_id ,
            'accept' : accept ,
            'course_code' : course_code ,
            'course_name':course_name,
            'parent_course':parent_course
        };


        $.ajax({
            type:'POST',
            url:'{{url('admin/acceptCourserequest')}}',
            data:data,
            success:function(data) {
                location.reload();
            }
        });
    }

    $(function () {
        let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
        let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
        let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
        let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
        let printButtonTrans = '{{ trans('global.datatables.print') }}'
        let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
        let selectAllButtonTrans = '{{ trans('global.select_all') }}'
        let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

        buttons = [
            {
                extend: 'selectAll',
                className: 'btn-primary',
                text: selectAllButtonTrans,
                exportOptions: {
                    columns: ':visible'
                },
                action: function(e, dt) {
                    e.preventDefault()
                    dt.rows().deselect();
                    dt.rows({ search: 'applied' }).select();
                }
            },
            {
                extend: 'selectNone',
                className: 'btn-primary',
                text: selectNoneButtonTrans,
                exportOptions: {
                    columns: [1,2,3]
                }
            },
            {
                extend: 'copy',
                className: 'btn-default',
                text: copyButtonTrans,
                exportOptions: {
                    columns: [1,2,3]
                }
            },
            {
                extend: 'csv',
                className: 'btn-default',
                text: csvButtonTrans,
                exportOptions: {
                    columns: [1,2,3]
                }
            },
            {
                extend: 'excel',
                className: 'btn-default',
                text: excelButtonTrans,
                exportOptions: {
                    columns: [1,2,3]
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn-default',
                text: pdfButtonTrans,

                exportOptions: {
                    columns: [1,2,3]
                },
            },
            {
                extend: 'print',
                className: 'btn-default',
                text: printButtonTrans,
                exportOptions: {
                    columns: [1,2,3]
                }
            },




        ]


    });
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('course_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.coursesrequests.massDestroy') }}",
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
                dom: 'Bfrtip',
                buttons:buttons,
                processing: true,
                language: {
                    processing: "<img src='{{url('loading.gif')}}' id='processingloading'>",
                },
                serverSide: true,
                retrieve: true,
                aaSorting: [],
    ajax: "{{ route('admin.coursesrequests.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'course_name', name: 'course_name' },
{ data: 'course_code', name: 'course_code' },
        { data: 'details', name: 'details' },
{ data: 'actions', name: '{{ trans('global.actions') }}' , sortable:false , searchable:false}
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
  let table = $('.datatable-Course').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
