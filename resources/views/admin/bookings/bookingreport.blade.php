@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       الحجوزات المراد تصديرها للمعلمين
    </div>

    <div class="card-body">




        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Booking">
            <thead>
                <tr>

                    <th>
                        {{ trans('cruds.booking.fields.id') }}
                    </th>
                    <th>
                       الاسم
                    </th>

                    <th>
                       عدد الطلبات
                    </th>

                    <th>
                       المجموع الكلي
                    </th>

                    <th>
                        ربح المستخدم
                    </th>
                    <th>
                        &nbsp;ربح فهمني
                    </th>

                    <th>
                        &nbsp;اسم البنك
                    </th>
                    <th>
                        &nbsp;اسم الحساب
                    </th>
                    <th>
                        &nbsp;رقم الحساب
                    </th>
                    <th>
                        &nbsp;رقم الايبان
                    </th>
                </tr>
            </thead>

            <tbody>

              @foreach($bookings as $book)
                <tr>
                     <td>{{ $book->id }} </td>
                     <td>{{ $book->name }} </td>
                     <td>{{ $book->count_booking_finish }} </td>
                     <td>{{ $book->total_finish }} </td>
                     <td>{{ $book->total_tutor_finish }}</td>
                     <td>{{ $book->total_admin_finish }} </td>
                    <td> {{$book->bank_name}}</td>
                    <td> {{$book->bank_user_name}}</td>
                    <td> {{$book->bank_account}}</td>
                    <td> {{$book->bank_iban}}</td>
                </tr>
              @endforeach

            </tbody>
        </table>
    </div>
</div>



@endsection
@section('scripts')

    <script>

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            pageLength: 100
            @if(session()->get('language') == 'ar')
            ,
            language :{
                url:"//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json",
                processing: "<img src='{{url('loading.gif')}}' id='processingloading'>",
            }
            @endif
        });

       $('.datatable-Booking').DataTable({



            dom: 'Blfrtip',

            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "الكل"]],

            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        modifier : {
                            order : 'index', // 'current', 'applied','index', 'original'
                            page : 'all', // 'all', 'current'
                            search : 'none' // 'none', 'applied', 'removed'
                        },
                        columns: [ 0, 1,2 ,3 ,4,5,6,7,8,9]
                    }
                }

            ]



            @if(session()->get('locale') == 'arabic')
            ,
            language :{
                url:"//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json",
            }
            @endif
        });

    </script>
@endsection
