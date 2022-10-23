@component('mail::message')#
# Thais shop

<div style="font-size: 22px; font-weight: bold">Thông tin khách hàng: </div>
Khách hàng: <strong style="color:blue">{{$user->full_name}}</strong><br>
Số điện thoại: {{$user->number_phone}}<br>
Address: {{$user->address}}<br>

<div style="font-size: 22px; font-weight: bold; margin-top: 20px">Thông tin sản phẩm: </div>
ID sản phẩm: {{$cdGame->id}}<br>
Tên sản phẩm: {{$cdGame->name}}<br>
Giá tiền: {{$payment}}<br>
<img src={{$cdGame->image}} alt={{$cdGame->name}}>


Thanks,<br>
<strong style="color:red">Thais shop</strong>
@endcomponent
