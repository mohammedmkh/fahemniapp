<?php

namespace App\Http\Requests;

use App\TutorsCourse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTutorsCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tutors_course_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'course_id' => [
                'required',
                'integer',
            ],
            'grade' => [
                'string',
                'nullable',
            ],
        ];
    }
}
