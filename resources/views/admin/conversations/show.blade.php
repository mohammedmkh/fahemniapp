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

                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.conversations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>

    <div class="card-body">



            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Chat-->
                        <div class="d-flex flex-row">

                            <!--begin::Content-->
                            <div class="flex-row-fluid ml-lg-8" id="kt_chat_content">
                                <!--begin::Card-->
                                <div class="card card-custom">
                                    <!--begin::Header-->
                                    <div class="card-header align-items-center px-4 py-3">
                                        <div class="text-left flex-grow-1">
                                            <!--begin::Aside Mobile Toggle-->
                                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md d-lg-none" id="kt_app_chat_toggle">
														<span class="svg-icon svg-icon-lg">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Adress-book2.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3" />
																	<path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000" />
																</g>
															</svg>
                                                            <!--end::Svg Icon-->
														</span>
                                            </button>
                                            <!--end::Aside Mobile Toggle-->
                                            <!--begin::Dropdown Menu-->
                                            <h3>المحادثات  </h3>
                                            <!--end::Dropdown Menu-->
                                        </div>


                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    @if(count($chat) > 0)
                                    <div class="card-body">
                                        <!--begin::Scroll-->
                                        <div class="scroll scroll-pull" data-mobile-height="350">
                                            <!--begin::Messages-->
                                            <div class="messages">
                                                <!--begin::Message In-->

                                                @foreach($chat as $message)

                                                    @if($message['is_teacher'] )
                                                <div class="d-flex flex-column mb-5 align-items-start">
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-circle symbol-40 mr-3">
                                                            <img alt="Pic" src="{{$teacher['image']}}" />
                                                        </div>
                                                        <div>
                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{$teacher['name']}}</a>
                                                            <span class="text-muted font-size-sm">{{$message['date']}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                        @if($message['type'] != 'text')
                                                            Audio Message
                                                        @else
                                                            {{$message['content']}}
                                                        @endif
                                                    </div>
                                                </div>

                                                    @else
                                                <div class="d-flex flex-column mb-5 align-items-end">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <span class="text-muted font-size-sm">{{$message['date']}}</span>
                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{{$student['name']}}</a>
                                                        </div>
                                                        <div class="symbol symbol-circle symbol-40 ml-3">
                                                            <img alt="Pic" src="{{$student['image']}}" />
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                        @if($message['type'] != 'text')
                                                                    Audio Message
                                                            @else
                                                            {{$message['content']}}
                                                            @endif

                                                    </div>
                                                </div>
                                                    @endif

                                                @endforeach



                                                <!--end::Message Out-->
                                            </div>
                                            <!--end::Messages-->
                                        </div>
                                        <!--end::Scroll-->
                                    </div>
                                    @endif
                                    <!--end::Body-->
                                    <!--begin::Footer-->

                                    <!--end::Footer-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Chat-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>



    </div>

</div>



@endsection