
<div class="login-page">
    <div class="form">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form class="login-form" wire:submit="login">
            @csrf
            <input type="text" placeholder="email" wire:model="email"/>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="password" placeholder="password" wire:model="password"/>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            @error('invalid')
                <div class="error">{{ $message }}</div>
            @enderror

            <button>login</button>
            <p class="message">Not registered? <a href={{ route('register') }} wire:navigate>Create an account</a></p>
        </form>
    </div>
</div>
