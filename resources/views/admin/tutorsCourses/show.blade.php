@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tutorsCourse.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tutors-courses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorsCourse.fields.id') }}
                        </th>
                        <td>
                            {{ $tutorsCourse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorsCourse.fields.user') }}
                        </th>
                        <td>
                            {{ $tutorsCourse->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorsCourse.fields.course') }}
                        </th>
                        <td>
                            {{ $tutorsCourse->course->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorsCourse.fields.grade') }}
                        </th>
                        <td>
                            {{ $tutorsCourse->grade }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tutors-courses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection