

<div class="card">
    <div class="card-header">

    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th>
                    السيرة الذاتية
                </th>
                <td>
                    @if($user->cv != '')
                        <a href="{{$user->cv_path}}" target="_blank"> تنزيل </a>
                    @else
                        لم يتم الرفع
                    @endif
                </td>
            </tr>
            <tr>
                <th>
                    كشف الدرجات
                </th>
                <td>
                    @if($user->grades_doc != '')
                        <a href="{{$user->grades_doc_path}}" target="_blank"> تنزيل </a>
                    @else
                        لم يتم الرفع
                    @endif
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</div>

@section('scripts')
    @parent

@endsection