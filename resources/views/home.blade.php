@extends('layouts.admin')
@section('content')


    @if(isset($booking_cancel_from_student) && $booking_cancel_from_student> 0)
    <div class="col-lg-6" style="margin: 20px auto; text-align: center">


        <div class="col bg-light-danger px-6 py-8 rounded-2 me-7">
            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
            <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"></path>
																	<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"></path>
																</svg>
															</span>
            <!--end::Svg Icon-->
            <a href="{{url('admin/bookings?bookstatus=5&is_refunded=1')}}" class="text-danger fw-bold fs-6 mt-2"> حجوزات ملغية من قبل الطالب </a>
        </div>
    </div>
    @endif
    @if(isset($booking_cancel_from_tutor) && $booking_cancel_from_tutor  > 0)
    <div class="col-lg-6" style="margin: 20px auto; text-align: center">


    <div class="col bg-light-danger px-6 py-8 rounded-2 me-7">
        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"></path>
																	<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"></path>
																</svg>
															</span>
        <!--end::Svg Icon-->
        <a href="{{url('admin/bookings?bookstatus=6&is_refunded=1')}}" class="text-danger fw-bold fs-6 mt-2"> حجوزات مرفوضة من قبل المعلم </a>
    </div>
   @endif
    </div>
<div class="content">
    <div class="row">



                        <div class="col-lg-12">
                            <!--begin::Mixed Widget 1-->
                            <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                                <!--begin::Header-->
                                <div class="card-header border-0 bg-danger py-5">
                                    <h3 class="card-title font-weight-bolder text-white">تقارير سريعة</h3>
                                    <div class="card-toolbar">

                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body p-0 position-relative overflow-hidden">
                                    <!--begin::Chart-->
                                    <div id="kt_mixed_widget_1_chart" class="card-rounded-bottom bg-danger" style="height: 200px; min-height: 200px;"><div id="apexcharts2q3zzk32h" class="apexcharts-canvas apexcharts2q3zzk32h apexcharts-theme-light" style="width: 463px; height: 200px;"><svg id="SvgjsSvg1658" width="463" height="200" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1660" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1659"><clipPath id="gridRectMask2q3zzk32h"><rect id="SvgjsRect1663" width="470" height="203" x="-3.5" y="-1.5" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask2q3zzk32h"><rect id="SvgjsRect1664" width="467" height="204" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><filter id="SvgjsFilter1670" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood1671" flood-color="#d13647" flood-opacity="0.5" result="SvgjsFeFlood1671Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1672" in="SvgjsFeFlood1671Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1672Out"></feComposite><feOffset id="SvgjsFeOffset1673" dx="0" dy="5" result="SvgjsFeOffset1673Out" in="SvgjsFeComposite1672Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1674" stdDeviation="3 " result="SvgjsFeGaussianBlur1674Out" in="SvgjsFeOffset1673Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1675" result="SvgjsFeMerge1675Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1676" in="SvgjsFeGaussianBlur1674Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1677" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1678" in="SourceGraphic" in2="SvgjsFeMerge1675Out" mode="normal" result="SvgjsFeBlend1678Out"></feBlend></filter><filter id="SvgjsFilter1680" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood1681" flood-color="#d13647" flood-opacity="0.5" result="SvgjsFeFlood1681Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1682" in="SvgjsFeFlood1681Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1682Out"></feComposite><feOffset id="SvgjsFeOffset1683" dx="0" dy="5" result="SvgjsFeOffset1683Out" in="SvgjsFeComposite1682Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1684" stdDeviation="3 " result="SvgjsFeGaussianBlur1684Out" in="SvgjsFeOffset1683Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1685" result="SvgjsFeMerge1685Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1686" in="SvgjsFeGaussianBlur1684Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1687" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1688" in="SourceGraphic" in2="SvgjsFeMerge1685Out" mode="normal" result="SvgjsFeBlend1688Out"></feBlend></filter></defs><g id="SvgjsG1689" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1690" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1699" class="apexcharts-grid"><g id="SvgjsG1700" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1702" x1="0" y1="0" x2="463" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1703" x1="0" y1="20" x2="463" y2="20" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1704" x1="0" y1="40" x2="463" y2="40" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1705" x1="0" y1="60" x2="463" y2="60" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1706" x1="0" y1="80" x2="463" y2="80" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1707" x1="0" y1="100" x2="463" y2="100" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1708" x1="0" y1="120" x2="463" y2="120" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1709" x1="0" y1="140" x2="463" y2="140" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1710" x1="0" y1="160" x2="463" y2="160" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1711" x1="0" y1="180" x2="463" y2="180" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1712" x1="0" y1="200" x2="463" y2="200" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG1701" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1714" x1="0" y1="200" x2="463" y2="200" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1713" x1="0" y1="1" x2="0" y2="200" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1665" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1666" class="apexcharts-series" seriesName="NetxProfit" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1669" d="M 0 200L 0 125C 27.008333333333333 125 50.15833333333334 87.5 77.16666666666667 87.5C 104.17500000000001 87.5 127.32500000000002 120 154.33333333333334 120C 181.34166666666667 120 204.49166666666667 25 231.5 25C 258.5083333333333 25 281.65833333333336 100 308.6666666666667 100C 335.675 100 358.825 100 385.8333333333333 100C 412.84166666666664 100 435.9916666666667 100 463 100C 463 100 463 100 463 200M 463 100z" fill="transparent" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask2q3zzk32h)" filter="url(#SvgjsFilter1670)" pathTo="M 0 200L 0 125C 27.008333333333333 125 50.15833333333334 87.5 77.16666666666667 87.5C 104.17500000000001 87.5 127.32500000000002 120 154.33333333333334 120C 181.34166666666667 120 204.49166666666667 25 231.5 25C 258.5083333333333 25 281.65833333333336 100 308.6666666666667 100C 335.675 100 358.825 100 385.8333333333333 100C 412.84166666666664 100 435.9916666666667 100 463 100C 463 100 463 100 463 200M 463 100z" pathFrom="M -1 200L -1 200L 77.16666666666667 200L 154.33333333333334 200L 231.5 200L 308.6666666666667 200L 385.8333333333333 200L 463 200"></path><path id="SvgjsPath1679" d="M 0 125C 27.008333333333333 125 50.15833333333334 87.5 77.16666666666667 87.5C 104.17500000000001 87.5 127.32500000000002 120 154.33333333333334 120C 181.34166666666667 120 204.49166666666667 25 231.5 25C 258.5083333333333 25 281.65833333333336 100 308.6666666666667 100C 335.675 100 358.825 100 385.8333333333333 100C 412.84166666666664 100 435.9916666666667 100 463 100" fill="none" fill-opacity="1" stroke="#d13647" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask2q3zzk32h)" filter="url(#SvgjsFilter1680)" pathTo="M 0 125C 27.008333333333333 125 50.15833333333334 87.5 77.16666666666667 87.5C 104.17500000000001 87.5 127.32500000000002 120 154.33333333333334 120C 181.34166666666667 120 204.49166666666667 25 231.5 25C 258.5083333333333 25 281.65833333333336 100 308.6666666666667 100C 335.675 100 358.825 100 385.8333333333333 100C 412.84166666666664 100 435.9916666666667 100 463 100" pathFrom="M -1 200L -1 200L 77.16666666666667 200L 154.33333333333334 200L 231.5 200L 308.6666666666667 200L 385.8333333333333 200L 463 200"></path><g id="SvgjsG1667" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1720" r="0" cx="231.5" cy="25" class="apexcharts-marker wrm7ze3qd no-pointer-events" stroke="#d13647" fill="#ffe2e5" fill-opacity="1" stroke-width="3" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1668" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1715" x1="0" y1="0" x2="463" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1716" x1="0" y1="0" x2="463" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1717" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1718" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1719" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1698" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1661" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 100px;"></div><div class="apexcharts-tooltip apexcharts-theme-light" style="left: 46.4062px; top: 28px;"><div class="apexcharts-tooltip-title" style="font-family: Poppins; font-size: 12px;">May</div><div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: transparent; display: none;"></span><div class="apexcharts-tooltip-text" style="font-family: Poppins; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Net Profit: </span><span class="apexcharts-tooltip-text-value">$70 thousands</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                    <!--end::Chart-->
                                    <!--begin::Stats-->
                                    <div class="card-spacer mt-n25">
                                        <!--begin::Row-->
                                        <div class="row m-0">
                                            <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
															<span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"></rect>
																		<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
																		<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
																		<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
																		<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="{{ url('admin/students') }}" class="text-warning font-weight-bold font-size-h6"><span>الطلاب المسجلون</span> <span> {{ $students_count }} </span></a>
                                            </div>
                                            <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
															<span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"></polygon>
																		<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																		<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="{{ url('admin/teachers') }}" class="text-primary font-weight-bold font-size-h6 mt-2"> <span>المعلمين</span> <span> {{ $tutors_count }} </span></a>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Row-->
                                        <div class="row m-0">
                                            <div class="col bg-light-danger px-4 py-8 rounded-xl mr-7">
															<span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"></polygon>
																		<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
																		<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="{{ url('admin/reports') }}" class="text-danger font-weight-bold font-size-h6 mt-2"><span> عدد البلاغات</span> <span> {{ $reports_count }} </span>  </a>
                                            </div>


                                            <div class="col bg-light-success px-4 py-8 rounded-xl">
															<span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Urgent-mail.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"></rect>
																		<path d="M12.7037037,14 L15.6666667,10 L13.4444444,10 L13.4444444,6 L9,12 L11.2222222,12 L11.2222222,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L12.7037037,14 Z" fill="#000000" opacity="0.3"></path>
																		<path d="M9.80428954,10.9142091 L9,12 L11.2222222,12 L11.2222222,16 L15.6666667,10 L15.4615385,10 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9.80428954,10.9142091 Z" fill="#000000"></path>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
                                                <a href="{{ url('admin/coursesrequests') }}" class="text-success font-weight-bold font-size-h6 mt-2">   <span>طلبات المواد</span> <span> {{ $courses_count }} </span></a>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Stats-->
                                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 464px; height: 447px;"></div></div><div class="contract-trigger"></div></div></div>
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 1-->
                        </div>



    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection
