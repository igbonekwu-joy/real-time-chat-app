<div class="login-page">
    <div class="form">
        @if (session('success'))
            <div
                x-data
                x-init="
                    setTimeout(() => {
                        Livewire.navigate('/login')
                    }, 3000)
                "
                class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form wire:submit="register" class="register-form">
            @csrf
            <input type="text" placeholder="name" wire:model="name"/>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="text" placeholder="email address" wire:model="email"/>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="password" placeholder="password" wire:model="password"/>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">create</button>
            <p class="message">Already registered? <a href={{ route('login') }} wire:navigate>Sign In</a></p>
        </form>
    </div>
</div>
