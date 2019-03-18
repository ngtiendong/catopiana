<h3>Form liên hệ</h3>
<br/>
Họ và tên: {{$data['name']}}<br/>
Email: {{$data['email']}}<br/>
Số điện thoại: {{$data['country_code']}} {{$data['contact_number']}}<br/>
Chủ đề: {{$data['subject']}}<br/>
Nội dung: {{$data['message']}}<br/>
<br/>
@if ($data['page'] == 'nhan-tho')
   @if (isset($data['goal']))
      <b>Bạn muốn:</b><br/>
      @foreach ($data['goal'] as $row)
           - {{$row}} <br/>
      @endforeach
   @endif

   @if (isset($data['gender']))
      <b>Giới tính : </b>
      {{$data['gender']}}<br/>
   @endif

   @if (isset($data['old']))
      <b>Tuổi : </b>
      {{$data['old']}}<br/>
   @endif

    @if (isset($data['job']))
    <b>Nghề nghiệp : </b>
    {{$data['job']}}<br/>
    @endif
@endif
