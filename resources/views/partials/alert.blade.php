    @if (session('succes'))
      <div class="alert-success">
        {{session('succes')}}
      </div>
      
    @endif
    
    @if (session('error'))
        <div class="alert-danger">
          {{session('error')}}
        </div>
    @endif