@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.help.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.helps.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.help.fields.id') }}
                        </th>
                        <td>
                            {{ $help->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.help.fields.question_ar') }}
                        </th>
                        <td>
                            {{ $help->question_ar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.help.fields.question_en') }}
                        </th>
                        <td>
                            {{ $help->question_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.help.fields.answer_en') }}
                        </th>
                        <td>
                            {{ $help->answer_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.help.fields.answer_ar') }}
                        </th>
                        <td>
                            {{ $help->answer_ar }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.helps.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection