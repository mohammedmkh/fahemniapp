@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.devicetoken.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.devicetokens.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.devicetoken.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.devicetoken.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="device_type">{{ trans('cruds.devicetoken.fields.device_type') }}</label>
                <input class="form-control {{ $errors->has('device_type') ? 'is-invalid' : '' }}" type="text" name="device_type" id="device_type" value="{{ old('device_type', '') }}">
                @if($errors->has('device_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('device_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.devicetoken.fields.device_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="device_token">{{ trans('cruds.devicetoken.fields.device_token') }}</label>
                <input class="form-control {{ $errors->has('device_token') ? 'is-invalid' : '' }}" type="text" name="device_token" id="device_token" value="{{ old('device_token', '') }}">
                @if($errors->has('device_token'))
                    <div class="invalid-feedback">
                        {{ $errors->first('device_token') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.devicetoken.fields.device_token_helper') }}</span>
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