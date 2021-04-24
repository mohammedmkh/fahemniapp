@extends('layouts.admin')
@section('content')
@can('help_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.helps.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.help.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.help.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Help">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.help.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.help.fields.question_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.help.fields.question_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.help.fields.answer_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.help.fields.answer_ar') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($helps as $key => $help)
                        <tr data-entry-id="{{ $help->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $help->id ?? '' }}
                            </td>
                            <td>
                                {{ $help->question_ar ?? '' }}
                            </td>
                            <td>
                                {{ $help->question_en ?? '' }}
                            </td>
                            <td>
                                {{ $help->answer_en ?? '' }}
                            </td>
                            <td>
                                {{ $help->answer_ar ?? '' }}
                            </td>
                            <td>
                                @can('help_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.helps.show', $help->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('help_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.helps.edit', $help->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('help_delete')
                                    <form action="{{ route('admin.helps.destroy', $help->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('help_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.helps.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-Help:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection