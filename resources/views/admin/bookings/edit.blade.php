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
                <select class="form-control  {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" disabled>
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
                <select class="form-control select2 {{ $errors->has('tutor') ? 'is-invalid' : '' }}" name="tutor_id" id="kt_select2_2">
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
                <label for="time_id">حزمة وقت المعلم</label>

                <select class="form-control" name="time_id" id="time_id">
                    @if(isset($booking->tutor->times ))
                         @foreach($booking->tutor->times as $time)
                            <option value="{{$time->id}}" {{ $time->id == $booking->time_id ? 'selected': '' }}>{{$time->time->time}}</option>
                         @endforeach
                    @endif
                </select>

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
                <label for="payed">{{ trans('cruds.booking.fields.payed') }}</label>
                <select name="payed" class="form-control">

                        <option value="1" {{$booking->payed == 1 ?'selected' : '' }}> مدفوع</option>
                        <option value="0" {{$booking->payed != 1 ?'selected' : '' }}> غير مدفوع</option>
                </select>
                <span class="help-block">{{ trans('cruds.booking.fields.payed_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.booking.fields.status') }}</label>

                <select name="status" class="form-control">
                      @foreach($booking_statuses as $status)
                    <option value="{{$status->id}}" {{$booking->status == $status->id ?'selected' : '' }}> {{$status->status_name}}</option>
                        @endforeach
                </select>

            </div>
            <div class="form-group">
                <label for="price_id">{{ trans('cruds.booking.fields.price') }}</label>
                <select class="form-control  {{ $errors->has('price') ? 'is-invalid' : '' }}" name="price_id" id="price_id">
                    @foreach($prices as $price)
                        <option value="{{ $price->id }}" {{ (old('price_id') ? old('price_id') : $booking->price_id ?? '') == $price->id ? 'selected' : '' }}>{{ $price->name }}</option>
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

    @section('scripts')
        <script type="text/javascript">

                $('#kt_select2_2').change(function(){
                    var tid = $('#kt_select2_2').val();
                    if(tid) {


                        $.ajax({
                            type: 'GET',
                            url: '{{url('/getTimes')}}/'+tid,
                            data: '_token = {{csrf_token()}}',
                            success: function (data) {
                                $('#time_id').empty();
                                $.each(data, function (k, v) {
                                    $('#time_id').append(
                                        '<option value="' + v.id + '">' + v.time.time + '</ooption>'
                                    );
                                });
                            }
                        });
                    }

                    });
                        /*
                        $.ajax({
                            type:"GET",
                            url:"{{url('/getTimes')}}/"+tid,
                            success:function(res) {
                                $('#time_id').empty();
                                $.each( res, function(k, v) {
                                    $('#time_id').append(
                                        '<option value="'+v.id+'">'+v.name+'</ooption>'
                                    );
                                });

                            }
                 }
                        })*/






        </script>

    @endsection