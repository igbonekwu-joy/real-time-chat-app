<div class="login-page">
    <div class="form">
            <form wire:submit="register" class="register-form">
                <input type="text" placeholder="name" wire:model="name"/>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror

                <input type="password" placeholder="password" wire:model="password"/>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror

                <input type="text" placeholder="email address" wire:model="email"/>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">create</button>
                <p class="message">Already registered? <a href={{ route('login') }} wire:navigate>Sign In</a></p>
            </form>
    </div>
</div>
