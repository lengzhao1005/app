<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method())
        {
            //create
            case 'POST':
            //UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|min:2',
                    'body' => 'required|min:10',
                    'category_id'=>'required|numeric',
                ];
            }

            default :
                {
                    return [];
                }

                break;

        }
    }

    public function messages()
    {
        return [
            'title.min'=>'标题不能少于两个字符',
            'body.min'=>'文章内容不能少于10个字符',
        ];
    }
}
