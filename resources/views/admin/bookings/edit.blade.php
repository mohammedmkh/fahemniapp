@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.update", [$booking->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.booking.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $booking->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tutor_id">{{ trans('cruds.booking.fields.tutor') }}</label>
                <select class="form-control select2 {{ $errors->has('tutor') ? 'is-invalid' : '' }}" name="tutor_id" id="tutor_id">
                    @foreach($tutors as $id => $entry)
                        <option value="{{ $id }}" {{ (old('tutor_id') ? old('tutor_id') : $booking->tutor->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tutor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tutor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.tutor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.booking.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $booking->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.booking.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $booking->time) }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payed">{{ trans('cruds.booking.fields.payed') }}</label>
                <input class="form-control {{ $errors->has('payed') ? 'is-invalid' : '' }}" type="number" name="payed" id="payed" value="{{ old('payed', $booking->payed) }}" step="1">
                @if($errors->has('payed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payed') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.payed_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.booking.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $booking->status) }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price_id">{{ trans('cruds.booking.fields.price') }}</label>
                <select class="form-control select2 {{ $errors->has('price') ? 'is-invalid' : '' }}" name="price_id" id="price_id">
                    @foreach($prices as $id => $entry)
                        <option value="{{ $id }}" {{ (old('price_id') ? old('price_id') : $booking->price->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total">{{ trans('cruds.booking.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total', $booking->total) }}" step="0.01">
                @if($errors->has('total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.total_helper') }}</span>
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