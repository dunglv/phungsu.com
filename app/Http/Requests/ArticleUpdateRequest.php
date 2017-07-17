<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
        return [
            'title' => 'required|min:10|max:200',
            'slug' => 'required|min:10|max:200',
            'description' => 'min:10|max:500',
            'content' => 'min:100',
            'category' => 'choose',
            'thumbnail' => 'mimes:jpg,png,gif,bmp,jpeg|between:1,2048',
            // 'video' => 'required|mimes:mp4|between:1,10240',
            // 'audio' => 'required|mimes:mpga|between:1,10240', 
            // 'images.*' => 'required|mimes:jpg,png,gif,bmp,jpeg|between:1,10240', 
            'tags' => 'required|mintag'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Hãy nhập tiêu đề cho bài viết',
            'title.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'title.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'slug.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'slug.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'description.min' => 'Mô tả quá ngắn để có cái nhìn tổng quát về bài viết.',
            'description.max' => 'Mô tả quá dài. Vui lòng thể hiện vào phần nội dung',
            'category.choose' => 'Hãy chọn một chủ đề cụ thể cho bài viết.',
            'content.min' => 'Nội dung quá ngắn. Hãy thể hiện lòng chân thành khi viết bài.',
            // 'audio.required' => 'Chọn một tệp tin âm thanh mp3 để upload.',
            // 'audio.mimes' => 'Định dạng tệp âm thanh chưa đúng. (.mp3, .wma, .amr)',
            // 'audio.between' => 'Kích thướt ảnh quá nhỏ hoặc quá lớn (tối đa: 2:max)',
            'tags.mintag' => 'Nhập ít nhất một thẻ cho bài viết',
            'tags.required' => 'Nhập ít nhất một thẻ cho bài viết'
        ];
    }
}
