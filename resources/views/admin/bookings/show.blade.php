@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.booking.title') }}
    </div>

    <style>
        .checked {
            color: orange;
        }


    </style>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            @if($booking->status == 5 || $booking->status == 6)
                <div class="overflow-auto pb-5">
                    <!--begin::Notice-->
                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed min-w-lg-600px flex-shrink-0 p-6">
                        <!--begin::Icon-->

                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                            <!--begin::Content-->
                            <div class="mb-3 mb-md-0 fw-bold">
                                <h2 class="text-gray-900 fw-bolder" style="color: red">{{ $booking->booking_status }}  </h2>
                                <div class="fs-6 text-gray-700 pe-7" style="font-size: 20px" >{{$booking->note_cancel }}</div>
                            </div>
                            <!--end::Content-->
                            <!--begin::Action-->
                            @if($booking->is_refunded == 1)
                                <div class="col-6" style="text-align: center; margin: 0 auto; color: red; font-size: 16px" >
                                  تم استرجاع المبلغ
                                </div>
                            @elseif($booking->is_refunded == 0)
                                <div class="col-6" style="text-align: center; margin: 0 auto">
                                    <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" style="float: left" onclick="openPOP()">ارجاع للطالب مبلغ {{ $booking->total }}</a>
                                </div>
                                @endif

                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                </div>
            @endif


            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.id') }}
                        </th>
                        <td>
                            {{ $booking->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.user') }}
                        </th>
                        <td>
                            {{ $booking->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.tutor') }}
                        </th>
                        <td>
                            {{ $booking->tutor->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.date') }}
                        </th>
                        <td>
                            {{ $booking->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.time') }}
                        </th>
                        <td>
                            {{ $booking->times->time->time ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.payed') }}
                        </th>
                        <td>
                            {{ $booking->payed_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.status') }}
                        </th>
                        <td style="color: red">
                            {{ $booking->booking_status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.price') }}
                        </th>
                        <td>
                            <div>
                            <span> عدد الطلاب </span> <span> {{ $booking->price->price->num_std ?? '' }}</span>
                            </div>
                            <div>
                                <span> عدد الساعات </span> <span> {{ $booking->price->price->hours ?? '' }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.total') }}
                        </th>
                        <td>
                            {{ $booking->total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Id
                            دفع ميسر
                        </th>
                        <td>
                            {{ $booking->checkout_id }}
                        </td>
                    </tr>
                </tbody>
            </table>
   @if($booking->is_review_student == 1)
            <div style="margin-top: 30px">
            <h3>تقييم المعلم للطالب</h3>
            <tr>
                <div>
                    <span class="fa fa-star {{$booking->review_student >= 1  ?'checked' :''}}"></span>
                    <span class="fa fa-star {{$booking->review_student >= 2  ?'checked' :''}}"></span>
                    <span class="fa fa-star {{$booking->review_student>= 3  ?'checked' :''}}"></span>
                    <span class="fa fa-star {{$booking->review_student >= 4  ?'checked' :''}}" ></span>
                    <span class="fa fa-star {{$booking->review_student >= 5  ?'checked' :''}}"></span>


                </div>
                <td>
     {{ $booking->note_on_student }}
                </td>
            </tr>
            </div>

            @endif


            @if($booking->is_review_tutor == 1)
            <div style="margin-top: 30px">

            <h3>تقييم  الطالب للملعم</h3>
            <tr>
                <div>

                    <span class="fa fa-star {{$booking->review_tutor >= 1  ?'checked' :''}}"></span>
                    <span class="fa fa-star {{$booking->review_tutor >= 2  ?'checked' :''}}"></span>
                    <span class="fa fa-star {{$booking->review_tutor>= 3  ?'checked' :''}}"></span>
                    <span class="fa fa-star {{$booking->review_tutor >= 4  ?'checked' :''}}" ></span>
                    <span class="fa fa-star {{$booking->review_tutor >= 5  ?'checked' :''}}"></span>


                </div>
                <td>
                    {{ $booking->note_on_tutor }}
                </td>
            </tr>
            </div>

            @endif

            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>


</div>

<div class="modal" tabindex="-1" role="dialog" id="modalAcceptReject">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">عملية استرجاع المبلغ المدفوع من طرف الطالب </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" style="text-align: center">
                    <button type="button" class="btn btn-primary" onclick="sendAccept()">اكمال عملية  refund </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="sendNotRefund()">لا</button>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('scripts')
    @parent
    <script>
        function openPOP() {
            //$('#reason').removeClass('is-invalid');
           // $('#reason').val('');
           // $('#teacher_id').val(id);
            $('#modalAcceptReject').modal('show');
        }

        function sendNotRefund(){


            data={
                '_token' :"{{csrf_token()}}" ,
                'booking_id' : '{{ $booking->id }}' ,
            };


            $.ajax({
                type:'POST',
                url:'{{url('admin/notrefundBooking')}}',
                data:data,
                success:function(data) {
                     location.reload();
                }
            });
        }

        function sendAccept(){


            data={
                '_token' :"{{csrf_token()}}" ,
                'booking_id' : '{{ $booking->id }}' ,

            };


            $.ajax({
                type:'POST',
                url:'{{url('admin/refundBooking')}}',
                data:data,
                success:function(data) {
                    location.reload();
                }
            });
        }

    </script>

@endsection
