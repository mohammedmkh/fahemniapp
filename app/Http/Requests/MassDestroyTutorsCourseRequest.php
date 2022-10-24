<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\TutorsCourse;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTutorsCourseRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('tutors_course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:tutors_courses,id',
]
    
}

}