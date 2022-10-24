@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        تعديل البلاغ
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.reports.update", [$report->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="reviewed_id">الطرف المبلغ</label>
                <select class="form-control  {{ $errors->has('reviewed') ? 'is-invalid' : '' }}" name="reviewed_id" id="kt_select2_2" disabled>

                        <option value="{{ $report->user_id }}" selected>{{ $report->user->name }}</option>

                </select>

            </div>

            <div class="form-group">
                <label for="reviewed_id">نوع المستخدم المبلغ</label>
                <select class="form-control  {{ $errors->has('reviewed') ? 'is-invalid' : '' }}" name="reviewed_id44" id="kt_select2_244" disabled>

                    @if($report->user->role == 3)
                    <option value="{{ $report->user_id }}" selected>مدرس</option>
                    @else
                        <option value="{{ $report->user_id }}" selected>طالب</option>
                    @endif

                </select>

            </div>

            <div class="form-group">
                <label for="review">نص البلاغ</label>
                <input class="form-control {{ $errors->has('review') ? 'is-invalid' : '' }}" type="text" name="text" id="text" value="{{ old('text', $report->text) }}">

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
