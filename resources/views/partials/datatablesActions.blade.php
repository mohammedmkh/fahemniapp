


<div class="dropdown dropdown-inline">
    <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="ki ki-bold-more-ver"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
        <!--begin::Navigation-->
        <ul class="navi navi-hover">
            <li class="navi-header pb-1">
                <span class="text-primary text-uppercase font-weight-bold font-size-sm">الاجراء</span>
            </li>

            @if($crudRoutePart  == 'teachers' && $row->status == 0)
            <li class="navi-item">
                <a href="#" class="navi-link" onclick="openPOP({{$row->id}})">
																		<span class="navi-icon">
																			<i class="flaticon2-graph-1"></i>
																		</span>
                    <span class="navi-text">قبول او الرفض</span>
                </a>
            </li>

            @endif


            @if($crudRoutePart  == 'coursesrequests' && $row->status == 0)
                <li class="navi-item">
                    <a href="#" class="navi-link" onclick="openPOPCourse({{$row->id}} , '{{$row->course_name}}' , '{{$row->course_code}}')" >
																		<span class="navi-icon">
																			<i class="flaticon2-graph-1"></i>
																		</span>
                        <span class="navi-text">قبول او الرفض</span>
                    </a>
                </li>

            @endif

            @can($viewGate)
            <li class="navi-item">

                <a href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-shopping-cart-1"></i>
																		</span>
                    <span class="navi-text"> {{ trans('global.view') }}</span>
                </a>

            </li>
            @endcan




            @can($editGate)
            <li class="navi-item">

                <a href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-writing"></i>
																		</span>
                    <span class="navi-text">        {{ trans('global.edit') }}</span>
                </a>
            </li>
            @endcan

            @can($deleteGate)
                <li class="navi-item">
                    <a href="#" class="navi-link" onclick="deleteBtn({{$row->id}})" >
                        <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" name="formdelete{{$row->id}}" style="display: inline-block">

																		<span class="navi-icon">
																			<i class="flaticon2-rocket-1"></i>
																		</span>
                            <span class="navi-text" >{{ trans('global.delete') }}</span>


                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </a>
                </li>
            @endcan
        </ul>
        <!--end::Navigation-->
    </div>
</div>


