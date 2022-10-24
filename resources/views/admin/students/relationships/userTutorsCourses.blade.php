

<div class="card">
    <div class="card-header">

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userTutorsCourses">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.tutorsCourse.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutorsCourse.fields.user') }}
                        </th>
                        <th>
                            السؤال
                        </th>
                        <th>
                           الاجابة
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($tutorsCourses as $key => $tutorsCourse)
                        <tr data-entry-id="{{ $tutorsCourse->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $tutorsCourse->id ?? '' }}
                            </td>
                            <td>
                                {{ $tutorsCourse->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $tutorsCourse->question->question ?? '' }}
                            </td>
                            <td>
                                {{ $tutorsCourse->answer_name ?? '' }}
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('tutors_course_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tutors-courses.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
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
  });
  let table = $('.datatable-userTutorsCourses:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection