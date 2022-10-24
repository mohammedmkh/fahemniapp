@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.review.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.reviews.update", [$review->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="reviewer_id">{{ trans('cruds.review.fields.reviewer') }}</label>
                <select class="form-control select2 {{ $errors->has('reviewer') ? 'is-invalid' : '' }}" name="reviewer_id" id="kt_select2_1">
                    @foreach($reviewers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('reviewer_id') ? old('reviewer_id') : $review->reviewer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('reviewer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reviewer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.review.fields.reviewer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reviewed_id">{{ trans('cruds.review.fields.reviewed') }}</label>
                <select class="form-control select2 {{ $errors->has('reviewed') ? 'is-invalid' : '' }}" name="reviewed_id" id="kt_select2_2">
                    @foreach($revieweds as $id => $entry)
                        <option value="{{ $id }}" {{ (old('reviewed_id') ? old('reviewed_id') : $review->reviewed->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('reviewed'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reviewed') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.review.fields.reviewed_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="type">{{ trans('cruds.review.fields.type') }}</label>
                <select name="type" class="form-control">
                    <option value="1" {{ $review->type == 1 ? 'selected' : '' }}>تقييم مدرس</option>
                    <option value="2" {{ $review->type == 2 ? 'selected' : '' }}>تقييم طالب</option>
                </select>
            </div>
            <div class="form-group">
                <label for="review">{{ trans('cruds.review.fields.review') }}</label>
                <input class="form-control {{ $errors->has('review') ? 'is-invalid' : '' }}" type="text" name="review" id="review" value="{{ old('review', $review->review) }}">
                @if($errors->has('review'))
                    <div class="invalid-feedback">
                        {{ $errors->first('review') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.review.fields.review_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.review.fields.note') }}</label>
                <input class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" type="text" name="note" id="note" value="{{ old('note', $review->note) }}">
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.review.fields.note_helper') }}</span>
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