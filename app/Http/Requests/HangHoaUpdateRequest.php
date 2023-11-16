<?php

namespace App\Http\Requests;

use App\Models\HangHoa;
use Illuminate\Foundation\Http\FormRequest;

class HangHoaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $hangHoa = HangHoa::where('ma_hang_hoa', $this->ma_hang_hoa_old)->first();
        return [
            'ten_hang_hoa' => 'required|max:255',
            'ma_hang_hoa' => "required|max:100|unique:hang_hoa,ma_hang_hoa," . $hangHoa->id,
            'id_loai_hang' => 'required|integer',
            'gia_ban' => 'required|integer|min:1',
            'don_vi_tinh' => 'required|max:50',
            'change_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'barcode' => ['required', 'max:20', 'regex:/^[A-Z0-9]+$/', 'unique:hang_hoa,barcode, ' . $hangHoa->id,],
        ];
    }

    public function messages()
    {
        return [
            'ten_hang_hoa.required' => 'Bạn cần nhập tên hàng.',
            'ten_hang_hoa.max' => 'Tên hàng hóa không được vượt quá :max ký tự.',
            'ma_hang_hoa.required' => 'Bạn chưa nhập mã hàng hóa.',
            'ma_hang_hoa.unique' => 'Mã hàng hóa đã tồn tại.',
            'ma_hang_hoa.max' => 'Mã hàng hóa không được vượt quá :max ký tự.',
            'id_loai_hang.required' => 'Vui lòng chọn loại hàng.',
            'id_loai_hang.integer' => 'Loại hàng phải là số nguyên.',
            'don_vi_tinh.required' => 'Bạn cần nhập đơn vị tính.',
            'don_vi_tinh.max' => 'Đơn vị tính không được vượt quá :max ký tự.',
            'change_img.image' => 'File không đúng định dạng hình ảnh.',
            'change_img.mimes' => 'Định dạng hình ảnh không hỗ trợ. Chỉ chấp nhận các định dạng: jpeg, png, jpg, gif, svg.',
            'change_img.max' => 'Kích thước hình ảnh không được vượt quá :max KB.',
            'barcode.max' => 'Mã vạch không được vượt quá :max ký tự.',
            'barcode.required' => 'Bạn cần nhập barcode.',
            'barcode.unique' => 'Barcode đã tồn tại.',
            'barcode.regex' => 'Mã vạch không hợp lệ. Vui lòng kiểm tra lại.',
            'gia_ban.min' => 'Bạn cần nhập giá bán lớn hơn 0.',
            'gia_ban.required' => 'Bạn cần nhập giá bán.',

        ];
    }
}
