<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAudioRequest extends FormRequest
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
            'content' => 'required|min:100',
            'category' => 'choose',
            'audio' => 'between:1,10240', 
            // 'images.*' => 'required|mimes:jpg,png,gif,bmp,jpeg|between:1,10240', 
            'tags' => 'required|mintag'
        ];
    }

    /**
     * Display message to front when validate
     * Message in each to field
     * @return void
     * @author 
     **/
    public function messages()
    {
        return [
            'title.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'title.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'title.unique' => 'Dường như bài viết đã có trên website. Sử dụng chứ năng tìm kiếm để tra hoặc yêu cầu quyền chỉnh sửa bài viết từ tác giả.',
            'slug.min' => 'Tiêu đề bài viết quá ngắn. Tối thiểu :min ký tự',
            'slug.max' => 'Tiêu đề bài viết quá dài. Tối đa :max ký tự',
            'description.min' => 'Mô tả quá ngắn để có cái nhìn tổng quát về bài viết.',
            'description.max' => 'Mô tả quá dài. Vui lòng thể hiện vào phần nội dung',
            'category.choose' => 'Hãy chọn một chủ đề cụ thể cho bài viết.',
            'content.required' => 'Vui lòng nhập nội dung cho trang web',
            'content.min' => 'Nội dung quá ngắn. Hãy thể hiện lòng chân thành khi viết bài.',
            'audio.mimes' => 'Định dạng tệp âm thanh chưa đúng. (.mp3, .wma, .amr)',
            'audio.between' => 'Kích thướt ảnh quá nhỏ hoặc quá lớn (tối thiểu :min tối đa: :max)',
            'tags.mintag' => 'Nhập ít nhất một thẻ cho bài viết',
            'tags.required' => 'Nhập ít nhất một thẻ cho bài viết'
        ];
    }
}
