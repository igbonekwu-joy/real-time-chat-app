<main>
    <div class="layout">
        <!-- Start of Sign Up -->
        <div class="main order-md-2">
            <div class="start">
                <div class="container">
                    <div class="col-md-12">
                        <div class="content">
                            <h1>Create Account</h1>
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
                            <form class="signup" wire:submit="register">
                                @csrf
                                <div class="form-parent">
                                    <div class="form-group">
                                        <input type="text" id="inputName" class="form-control" placeholder="Username" wire:model="name">
                                        <button class="btn icon"><i class="material-icons">person_outline</i></button>

                                        @error('name')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="inputEmail" class="form-control" placeholder="Email Address" wire:model="email">
                                        <button class="btn icon"><i class="material-icons">mail_outline</i></button>

                                        @error('email')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" wire:model="password">
                                    <button class="btn icon"><i class="material-icons">lock_outline</i></button>

                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn button" formaction="index-2.html">
                                    Sign Up
                                    <span wire:loading wire:target="register" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sign Up -->
        <!-- Start of Sidebar -->
        <div class="aside order-md-1">
            <div class="container">
                <div class="col-md-12">
                    <div class="preference">
                        <h2>Welcome Back!</h2>
                        <p>To keep connected with your friends please login with your personal info.</p>
                        <a href={{ route('login') }} wire:navigate class="btn button">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sidebar -->
    </div> <!-- Layout -->
</main>
