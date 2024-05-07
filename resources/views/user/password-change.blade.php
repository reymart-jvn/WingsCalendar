@extends('layouts.star-admin-app')
@section('css')
<style>
    /* Media query for smaller screens */
@media (max-width: 768px) {
  .column {
    width: 50%; /* Each column occupies 50% of the container width */
  }
}

/* Media query for even smaller screens */
@media (max-width: 480px) {
  .column {
    width: 100%; /* Each column occupies 100% of the container width (stacked vertically) */
  }
}
</style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-12 grid-margin stretch-card justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Change Password') }}</h4>
                    <p class="card-description text-warning">{{ $label }}</p>
                        <form action="{{ route('update-password') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @elseif (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
    
                                <div class="mb-3">
                                    <label for="oldPasswordInput" class="form-label">Old Password</label>
                                    <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                        placeholder="Old Password">
                                    @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="newPasswordInput" class="form-label">New Password</label>
                                    <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                        placeholder="New Password">
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                    <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                        placeholder="Confirm New Password">
                                </div>
    
                            </div>
    
                            <div class="card-footer">
                                <button class="btn btn-block w-100 btn-success">Submit Changes</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    
@endsection
@section('js')
    <script src="{{ asset('assets/js/ph_address.js') }}"></script>
    <script>
        $(function() {
            $('#date_of_birth').datepicker();

        });
    </script>

  
@endsection
