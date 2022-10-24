@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.devicetoken.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.devicetokens.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.devicetoken.fields.id') }}
                        </th>
                        <td>
                            {{ $devicetoken->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.devicetoken.fields.user') }}
                        </th>
                        <td>
                            {{ $devicetoken->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.devicetoken.fields.device_type') }}
                        </th>
                        <td>
                            {{ $devicetoken->device_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.devicetoken.fields.device_token') }}
                        </th>
                        <td>
                            {{ $devicetoken->device_token }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.devicetokens.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection