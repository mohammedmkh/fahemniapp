@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                            &nbsp;	&nbsp;	&nbsp;
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label" style="background-image:url({{$user->image_path}})"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>


                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.verify') }}
                        </th>
                        <td>
                            {{ $user->verify_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.phone') }}
                        </th>
                        <td>
                            {{ $user->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.sex') }}
                        </th>
                        <td>
                            {{ $user->sex_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.age') }}
                        </th>
                        <td>
                            {{ $user->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.country') }}
                        </th>
                        <td>
                            {{ $user->country->name_ar ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.level') }}
                        </th>
                        <td>
                            {{ $user->level->name_ar ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.university') }}
                        </th>
                        <td>
                            {{ $user->university->name_en ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.bio') }}
                        </th>
                        <td>
                            {{ $user->bio }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs" style="margin-top: 30px">
        <li class="nav-item">
            <a class="nav-link active" href="#user_tutors_courses" role="tab" data-toggle="tab">
               كورسات المعلم
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="#user_reviewed" role="tab" data-toggle="tab">
                التقييمات المعلم
            </a>
        </li>

        <li class="nav-item ">
            <a class="nav-link" href="#user_user" role="tab" data-toggle="tab">
                الملفات المرفقة
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" id="user_tutors_courses">
            @includeIf('admin.teachers.relationships.userTutorsCourses', ['tutorsCourses' => $user->userTutorsCourses])
        </div>
        <div class="tab-pane " role="tabpanel" id="user_reviewed">
            @includeIf('admin.teachers.relationships.userReviews', ['tutorsCourses' => $user->reviewed])
        </div>
        <div class="tab-pane " role="tabpanel" id="user_user">
            @includeIf('admin.teachers.relationships.docs', ['user' => $user])
        </div>
    </div>
</div>

@endsection
