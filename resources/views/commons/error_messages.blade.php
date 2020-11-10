@if (count($errors) > 0)
    
    {{-- roleは警告 --}}
    <ul class="alert alert-danger" role="alert">
        
        {{-- errorのなかには、コントローラーのバリデーション処理による、エラー内容が変数に入る --}}
        {{-- errorの中身を取得し、ある数だけくりかえす --}}
        
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>

@endif