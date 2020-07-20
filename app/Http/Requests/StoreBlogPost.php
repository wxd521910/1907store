<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 该成已授权
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 验证
            'class_name' => 'required|unique:posts|max:255',
        ];
    }
    // 中文错误信息
    public function messages(){
        return[ 
            // 自定义报错信息
            'class_name.required' =>'分类不能为空',
        ];  
    }
       
}
