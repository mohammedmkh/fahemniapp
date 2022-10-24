@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ url("admin/coursesrequests/". $course->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name_ar">اسم المادة </label>
                <input class="form-control " type="text" name="course_name" id="course_name" value="{{ old('course_name', $course->course_name) }}" required>

            </div>
            <div class="form-group">
                <label class="required" for="name_en">كود المادة</label>
                <input class="form-control " type="text" name="course_code" id="course_code" value="{{ old('course_code', $course->course_code) }}" >

            </div>
            <div class="form-group">
                <label class="required" for="name_en"> تفاصيل</label>
                <textarea rows="3" class="form-control" name="details">{{$course->details}}</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection