<!-- Alert message error-->
 @if(count($errors)>0)
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button> <br>    
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>
@endif