@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
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
                        {{ trans('cruds.user.fields.email_verified_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.roles') }}
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
                        {{ trans('cruds.user.fields.country') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.lat') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.long') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.level') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.university') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.bio') }}
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
    ajax: "{{ route('admin.users.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },
{ data: 'email_verified_at', name: 'email_verified_at' },
{ data: 'roles', name: 'roles.title' },
{ data: 'verify', name: 'verify' },
{ data: 'phone', name: 'phone' },
{ data: 'sex', name: 'sex' },
{ data: 'age', name: 'age' },
{ data: 'country_name_ar', name: 'country.name_ar' },
{ data: 'lat', name: 'lat' },
{ data: 'long', name: 'long' },
{ data: 'level_name_ar', name: 'level.name_ar' },
{ data: 'university_name_en', name: 'university.name_en' },
{ data: 'bio', name: 'bio' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-User').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
