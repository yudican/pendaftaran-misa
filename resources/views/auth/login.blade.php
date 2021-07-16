<x-guest-layout>
    <div class="container container-login container-transparent animated fadeIn">
        @if (session()->has('status'))
        <div class="alert alert-success">{{session()->get('status')}}</div>
        @endif
        @if (session()->has('error'))
        <div class="alert alert-danger">{{session()->get('error')}}</div>
        @endif
        <h3 class="text-center">Masuk</h3>
        <livewire:auth.login />
    </div>
</x-guest-layout>