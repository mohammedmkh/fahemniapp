@extends('layouts.admin')
@section('content')
@can('conversation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.conversations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.conversation.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.conversation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Conversation">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.conversation.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.conversation.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.conversation.fields.tutor') }}
                    </th>
                    <th>
                        {{ trans('cruds.conversation.fields.accept') }}
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('conversation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.conversations.massDestroy') }}",
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
    ajax: "{{ route('admin.conversations.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'tutor_name', name: 'tutor.name' },
{ data: 'accept', name: 'accept' },

{ data: 'actions', name: '{{ trans('global.actions') }}',searchable:false , sortable:false  }
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
  let table = $('.datatable-Conversation').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection