@extends('index') @section('title', 'Đóng góp bài viết mới') 
@section('b-script')
    {!!Html::style('/public/js/lib/jq-ui.css')!!}
    {!!Html::script('/public/js/handle-string.js')!!}
@stop 
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="sidebar">
            <div class="list-group list-success">
                <a href="{{ route('ui.user.detail') }}" class="list-group-item"><i class="fa fa-info"></i> Thông tin tài khoản</a>
                <a href="{{ route('ui.user.change-password') }}" class="list-group-item "><i class="fa fa-key"></i> Thay đổi mật khẩu</a>
                <a href="#" class="list-group-item"><i class="fa fa-cog"></i> Cài đặt</a>
                <a href="#" class="list-group-item"><i class="fa fa-pencil"></i> Bài viết</a>
                <a href="#" class="list-group-item"><i class="fa fa-briefcase"></i> Quản lý</a>
            </div>
        </div>
    </div>
    {!!Form::open(array( 'route' => 'ui.user.update-detail', 'method' => 'POST', 'class' => '', 'files' => true ))!!}
        <div class="col-md-9">
            @if(session()->has('status'))
                <div class="alert alert-{{session()->get('label')}}">
                    <strong>Cập nhật thành công!</strong> Thông tin của bạn đã được thay đổi và cập nhật thành công.
                </div>
            @endif
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Thông tin đăng nhập</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" readonly="readonly" name="email" id="email" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control"  name="name" id="name" value="{{$user->name}}" >
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Thông tin chi tiết</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="">Họ tên</label>
                        <input type="text" name="fullname" class="form-control" id="" value="{{$user->fullname}}">
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính</label>
                        <select name="gender" id="gender" class="form-control" required="required">
                            <option @if($user->gender==1) selected="selected" @endif value="1">Nam</option>
                            <option @if($user->gender==0) selected="selected" @endif value="0">Nữ</option>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="">Ngày sinh</label>
                        <div class="form-group">
                            <select name="dateofbirth" id="input" class="form-control" required="required">
                                <option value="0">-Ngày-</option>
                                <option value="1">01</option>
                                <option value="2">02</option>
                                <option value="3">03</option>
                                <option value="4">04</option>
                                <option value="5">05</option>
                                <option value="6">06</option>
                                <option value="7">07</option>
                                <option value="8">08</option>
                                <option value="9">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="" id="input" class="form-control" required="required">
                                <option value="0">-Tháng-</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="" id="input" class="form-control" required="required">
                                <option value="0">-Năm-</option>
                                <option value="1985">1985</option>
                                <option value="1986">1986</option>
                                <option value="1987">1987</option>
                                <option value="1988">1988</option>
                                <option value="1989">1989</option>
                                <option value="1990">1990</option>
                                <option value="1991">1991</option>
                                <option value="1992">1992</option>
                                <option value="1993">1993</option>
                                <option value="1994">1994</option>
                                <option value="1995">1995</option>
                                <option value="1996">1996</option>
                                <option value="1997">1997</option>
                                <option value="1998">1998</option>
                                <option value="1999">1999</option>
                                <option value="2000">2000</option>
                                <option value="2001">2001</option>
                                <option value="2002">2002</option>
                                <option value="2003">2003</option>
                                <option value="2004">2004</option>
                                <option value="2005">2005</option>
                                <option value="2006">2006</option>
                                <option value="2007">2007</option>
                                <option value="2008">2008</option>
                                <option value="2009">2009</option>
                                <option value="2010">2010</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <textarea name="address" id="address" class="form-control" rows="3">{{$user->address}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="religion">Tôn giáo</label>
                        <select name="religion" id="religion" class="form-control">
                            <option value="">Cao đài</option>
                            <option value="">Phật giáo</option>
                            <option value="">Công giáo</option>
                            <option value="">Thiên Chúa giáo</option>
                            <option value="">Tin lành</option>
                            <option value="">Đạo hồi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">Giới thiệu bản thân</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="inputBio">Giới thiệu ngắn gọn chi tiết về bản thân</label>
                        <textarea name="bio" id="inputBio" class="form-control" rows="3" placeholder="Đôi nét về bản thân bạn như sở thích, nghề nghiệp, công việc...">{{$user->bio}}</textarea>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tài khoản</h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('ui.user.deactivate') }}" class="btn btn-danger">Xóa tài khoản</a>
                </div>
            </div>

            <div class="form-group ">
                <button type="submit" class="btn btn-success">Lưu thông tin</button>
            </div>
            
                
            
                
        </div>
    
    {!!Form::close()!!}
</div>

@stop
