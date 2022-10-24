@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.help.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.helps.update", [$help->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="question_ar">{{ trans('cruds.help.fields.question_ar') }}</label>
                <input class="form-control {{ $errors->has('question_ar') ? 'is-invalid' : '' }}" type="text" name="question_ar" id="question_ar" value="{{ old('question_ar', $help->question_ar) }}">
                @if($errors->has('question_ar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question_ar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.help.fields.question_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="question_en">{{ trans('cruds.help.fields.question_en') }}</label>
                <input class="form-control {{ $errors->has('question_en') ? 'is-invalid' : '' }}" type="text" name="question_en" id="question_en" value="{{ old('question_en', $help->question_en) }}">
                @if($errors->has('question_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question_en') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.help.fields.question_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="answer_en">{{ trans('cruds.help.fields.answer_en') }}</label>
                <input class="form-control {{ $errors->has('answer_en') ? 'is-invalid' : '' }}" type="text" name="answer_en" id="answer_en" value="{{ old('answer_en', $help->answer_en) }}">
                @if($errors->has('answer_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('answer_en') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.help.fields.answer_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="answer_ar">{{ trans('cruds.help.fields.answer_ar') }}</label>
                <input class="form-control {{ $errors->has('answer_ar') ? 'is-invalid' : '' }}" type="text" name="answer_ar" id="answer_ar" value="{{ old('answer_ar', $help->answer_ar) }}">
                @if($errors->has('answer_ar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('answer_ar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.help.fields.answer_ar_helper') }}</span>
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