@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.conversation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.conversations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.conversation.fields.id') }}
                        </th>
                        <td>
                            {{ $conversation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.conversation.fields.user') }}
                        </th>
                        <td>
                            {{ $conversation->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.conversation.fields.tutor') }}
                        </th>
                        <td>
                            {{ $conversation->tutor->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.conversation.fields.accept') }}
                        </th>
                        <td>
                            {{ $conversation->accept }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.conversation.fields.end_conv') }}
                        </th>
                        <td>
                            {{ $conversation->end_conv }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.conversations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection