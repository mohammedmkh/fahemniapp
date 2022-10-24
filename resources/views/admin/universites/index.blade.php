@extends('layouts.admin')
@section('content')
@can('universite_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.universites.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.universite.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.universite.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Universite">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.universite.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.universite.fields.name_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.universite.fields.name_ar') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($universites as $key => $universite)
                        <tr data-entry-id="{{ $universite->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $universite->id ?? '' }}
                            </td>
                            <td>
                                {{ $universite->name_en ?? '' }}
                            </td>
                            <td>
                                {{ $universite->name_ar ?? '' }}
                            </td>
                            <td>
                                @can('universite_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.universites.show', $universite->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('universite_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.universites.edit', $universite->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('universite_delete')
                                    <form action="{{ route('admin.universites.destroy', $universite->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
  let dtButtons = [
      'print',
      'copyHtml5',
      'excelHtml5',
      'csvHtml5',
      'pdfHtml5',
  ]

       // console.log(' the arr buttons is ' +dtButtons);
@can('universite_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.universites.massDestroy') }}",
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

  /*
  let table = $('.datatable-Universite:not(.ajaxTable)')
      .DataTable(
          { buttons: dtButtons }
      );


   */


        var table = $('.datatable-Universite').DataTable({



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
                        columns: [ 0, 1,2 ,3]
                    }
                }

            ]



            @if(session()->get('locale') == 'arabic')
            ,
            language :{
                url:"//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json",
            }
            @endif
        });




  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
