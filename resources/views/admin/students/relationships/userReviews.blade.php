

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
                            التقييم
                        </th>
                        <th>
                           الملاحظة
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
                                {{ $tutorsCourse->reviewer->name ?? '' }}
                            </td>
                            <td>
                                {{ $tutorsCourse->review ?? '' }}
                            </td>
                            <td>
                                {{ $tutorsCourse->note ?? '' }}
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

@endsection