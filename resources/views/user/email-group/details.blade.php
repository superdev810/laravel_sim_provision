@foreach($emailList as $email)
    <div class="row">
        <div class="col-md-6"> {{$email->email}} </div>
    </div>
@endforeach