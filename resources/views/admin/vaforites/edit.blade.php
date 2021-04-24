@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.vaforite.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vaforites.update", [$vaforite->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.vaforite.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $vaforite->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vaforite.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tutor_id">{{ trans('cruds.vaforite.fields.tutor') }}</label>
                <select class="form-control select2 {{ $errors->has('tutor') ? 'is-invalid' : '' }}" name="tutor_id" id="tutor_id">
                    @foreach($tutors as $id => $entry)
                        <option value="{{ $id }}" {{ (old('tutor_id') ? old('tutor_id') : $vaforite->tutor->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tutor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tutor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vaforite.fields.tutor_helper') }}</span>
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