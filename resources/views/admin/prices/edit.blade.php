@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.price.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.prices.update", [$price->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="num_std">{{ trans('cruds.price.fields.num_std') }}</label>
                <select class="form-control"  name="num_std" id="num_std" >
                    <option value="1" {{( $price->num_std == 1 )?'selected':'' }}>  طالب واحد</option>
                    <option value="2" {{( $price->num_std == 2 )?'selected':'' }}>طالبين </option>
                    <option value="3" {{( $price->num_std == 3 )?'selected':'' }}>ثلاث طلاب</option>
                </select>
            </div>
            <div class="form-group">
                <label class="required" for="hours">{{ trans('cruds.price.fields.hours') }}</label>
                <input class="form-control {{ $errors->has('hours') ? 'is-invalid' : '' }}" type="text" name="hours" id="hours" value="{{ old('hours', $price->hours) }}" required>
                @if($errors->has('hours'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hours') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.price.fields.hours_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.price.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', $price->price) }}" required>
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.price.fields.price_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.price.fields.commission') }}</label>
                <input class="form-control {{ $errors->has('commission') ? 'is-invalid' : '' }}" type="text" name="commission" id="commission" value="{{ old('commission', $price->commission) }}" required>
                @if($errors->has('commission'))
                    <div class="invalid-feedback">
                        {{ $errors->first('commission') }}
                    </div>
                @endif

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
