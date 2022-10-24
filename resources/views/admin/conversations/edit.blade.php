@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.conversation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.conversations.update", [$conversation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.conversation.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $conversation->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.conversation.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tutor_id">{{ trans('cruds.conversation.fields.tutor') }}</label>
                <select class="form-control select2 {{ $errors->has('tutor') ? 'is-invalid' : '' }}" name="tutor_id" id="tutor_id">
                    @foreach($tutors as $id => $entry)
                        <option value="{{ $id }}" {{ (old('tutor_id') ? old('tutor_id') : $conversation->tutor->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tutor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tutor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.conversation.fields.tutor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="accept">{{ trans('cruds.conversation.fields.accept') }}</label>
                <input class="form-control {{ $errors->has('accept') ? 'is-invalid' : '' }}" type="number" name="accept" id="accept" value="{{ old('accept', $conversation->accept) }}" step="1">
                @if($errors->has('accept'))
                    <div class="invalid-feedback">
                        {{ $errors->first('accept') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.conversation.fields.accept_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_conv">{{ trans('cruds.conversation.fields.end_conv') }}</label>
                <input class="form-control {{ $errors->has('end_conv') ? 'is-invalid' : '' }}" type="number" name="end_conv" id="end_conv" value="{{ old('end_conv', $conversation->end_conv) }}" step="1">
                @if($errors->has('end_conv'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_conv') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.conversation.fields.end_conv_helper') }}</span>
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