<div class="login-form">
    <div class="form-group">
        <label for="username" class="placeholder"><b>Username</b></label>
        <input id="username" wire:model="username" type="text" class="form-control" name="username"
            :value="old('username')" required>
    </div>
    <div class="form-group">
        <label for="password" class="placeholder"><b>Password</b></label>
        {{-- @if (Route::has('password.request'))
                    <a class="link float-right" href="{{ route('password.request') }}">
        {{ __('Lupa kata sandi?') }}
        </a>
        @endif --}}
        <div class="position-relative">
            <input id="password" wire:model="password" name="password" type="password" class="form-control" required>
            {{-- <div class="show-password">
                            <i class="icon-eye"></i>
                        </div> --}}
        </div>
    </div>
    <div class="form-group form-action-d-flex mb-3">
        {{-- <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="remember" id="rememberme">
            <label class="custom-control-label m-0" for="rememberme">Remember Me</label>
        </div> --}}
        <button type="button" wire:click="login"
            class="btn btn-secondary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Masuk</button>
    </div>
</div>