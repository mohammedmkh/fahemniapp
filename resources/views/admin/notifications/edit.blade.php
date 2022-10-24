@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.notification.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.notifications.update", [$notification->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.notification.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $notification->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action_type">{{ trans('cruds.notification.fields.action_type') }}</label>
                <input class="form-control {{ $errors->has('action_type') ? 'is-invalid' : '' }}" type="text" name="action_type" id="action_type" value="{{ old('action_type', $notification->action_type) }}">
                @if($errors->has('action_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.action_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="actionid">{{ trans('cruds.notification.fields.actionid') }}</label>
                <input class="form-control {{ $errors->has('actionid') ? 'is-invalid' : '' }}" type="text" name="actionid" id="actionid" value="{{ old('actionid', $notification->actionid) }}">
                @if($errors->has('actionid'))
                    <div class="invalid-feedback">
                        {{ $errors->first('actionid') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.actionid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action">{{ trans('cruds.notification.fields.action') }}</label>
                <input class="form-control {{ $errors->has('action') ? 'is-invalid' : '' }}" type="text" name="action" id="action" value="{{ old('action', $notification->action) }}">
                @if($errors->has('action'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reed">{{ trans('cruds.notification.fields.reed') }}</label>
                <input class="form-control {{ $errors->has('reed') ? 'is-invalid' : '' }}" type="number" name="reed" id="reed" value="{{ old('reed', $notification->reed) }}" step="1">
                @if($errors->has('reed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reed') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.reed_helper') }}</span>
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