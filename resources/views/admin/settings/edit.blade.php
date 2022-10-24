@extends('layouts.admin')
@section('content')

<div class="card" xmlns="http://www.w3.org/1999/html">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.setting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settings.update", [$setting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="text_policy">{{ trans('cruds.setting.fields.text_policy') }}</label>
                <textarea rows="9" class="form-control  form-control-solid {{ $errors->has('text_policy') ? 'is-invalid' : '' }}"  name="text_policy" id="text_policy" >{{ $setting->text_policy }}
                </textarea>

            </div>
            <div class="form-group">
                <label for="tex_policy_ar">{{ trans('cruds.setting.fields.tex_policy_ar') }}</label>
                <textarea rows="9" class="form-control  form-control-solid {{ $errors->has('tex_policy_ar') ? 'is-invalid' : '' }}"  name="tex_policy_ar" id="tex_policy_ar">{{  $setting->tex_policy_ar }} </textarea>

            </div>
            <div class="form-group">
                <label for="aboutus_en">{{ trans('cruds.setting.fields.aboutus_en') }}</label>
                <textarea rows="9"  class="form-control  form-control-solid" name="aboutus_en" id="aboutus_en" > {{ $setting->aboutus_en }} </textarea>

            </div>
            <div class="form-group">
                <label for="aboutus_ar">{{ trans('cruds.setting.fields.aboutus_ar') }}</label>
                <textarea rows="9"  class="form-control  form-control-solid"  name="aboutus_ar" id="aboutus_ar" > {{$setting->aboutus_ar}}</textarea>

            </div>
            <div class="form-group">
                <label for="terms_ar">{{ trans('cruds.setting.fields.terms_ar') }}</label>
                <textarea rows="9"  class="form-control  form-control-solid"  name="terms_ar" id="terms_ar" > {{$setting->terms_ar}}</textarea>

            </div>
            <div class="form-group">
                <label for="terms_en">{{ trans('cruds.setting.fields.terms_en') }}</label>
                <textarea rows="9"  class="form-control  form-control-solid"  name="terms_en" id="terms_en" >{{$setting->terms_en}}</textarea>

            </div>


            <div class="form-group">
                <label for="text_policy">whatsapp</label>
                <input class="form-control {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $setting->whatsapp) }}">
            </div>

            <div class="form-group">
                <label for="text_policy">facebook</label>
                <input class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}" type="text" name="facebook" id="facebook" value="{{ old('facebook', $setting->facebook) }}">
            </div>

            <div class="form-group">
                <label for="text_policy">linkedin</label>
                <input class="form-control {{ $errors->has('linkedin') ? 'is-invalid' : '' }}" type="text" name="linkedin" id="linkedin" value="{{ old('linkedin', $setting->linkedin) }}">
            </div>
            <div class="form-group">
                <label for="text_policy">youtube</label>
                <input class="form-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}" type="text" name="youtube" id="youtube" value="{{ old('youtube', $setting->youtube) }}">
            </div>
            <div class="form-group">
                <label for="text_policy">phone</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $setting->phone) }}">
            </div>

            <div class="form-group">
                <label for="text_policy">mail</label>
                <input class="form-control {{ $errors->has('mail') ? 'is-invalid' : '' }}" type="text" name="mail" id="mail" value="{{ old('mail', $setting->mail) }}">
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