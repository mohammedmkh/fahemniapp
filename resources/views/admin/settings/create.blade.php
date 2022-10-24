@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.setting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="text_policy">{{ trans('cruds.setting.fields.text_policy') }}</label>
                <input class="form-control {{ $errors->has('text_policy') ? 'is-invalid' : '' }}" type="text" name="text_policy" id="text_policy" value="{{ old('text_policy', '') }}">
                @if($errors->has('text_policy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('text_policy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.text_policy_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tex_policy_ar">{{ trans('cruds.setting.fields.tex_policy_ar') }}</label>
                <input class="form-control {{ $errors->has('tex_policy_ar') ? 'is-invalid' : '' }}" type="text" name="tex_policy_ar" id="tex_policy_ar" value="{{ old('tex_policy_ar', '') }}">
                @if($errors->has('tex_policy_ar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tex_policy_ar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.tex_policy_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aboutus_en">{{ trans('cruds.setting.fields.aboutus_en') }}</label>
                <input class="form-control {{ $errors->has('aboutus_en') ? 'is-invalid' : '' }}" type="text" name="aboutus_en" id="aboutus_en" value="{{ old('aboutus_en', '') }}">
                @if($errors->has('aboutus_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('aboutus_en') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.aboutus_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aboutus_ar">{{ trans('cruds.setting.fields.aboutus_ar') }}</label>
                <input class="form-control {{ $errors->has('aboutus_ar') ? 'is-invalid' : '' }}" type="text" name="aboutus_ar" id="aboutus_ar" value="{{ old('aboutus_ar', '') }}">
                @if($errors->has('aboutus_ar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('aboutus_ar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.aboutus_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="terms_ar">{{ trans('cruds.setting.fields.terms_ar') }}</label>
                <input class="form-control {{ $errors->has('terms_ar') ? 'is-invalid' : '' }}" type="text" name="terms_ar" id="terms_ar" value="{{ old('terms_ar', '') }}">
                @if($errors->has('terms_ar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('terms_ar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.terms_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="terms_en">{{ trans('cruds.setting.fields.terms_en') }}</label>
                <input class="form-control {{ $errors->has('terms_en') ? 'is-invalid' : '' }}" type="text" name="terms_en" id="terms_en" value="{{ old('terms_en', '') }}">
                @if($errors->has('terms_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('terms_en') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.setting.fields.terms_en_helper') }}</span>
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