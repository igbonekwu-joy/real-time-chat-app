<main>
    <div class="layout">
        <!-- Start of Sign In -->
        <div class="main order-md-1">
            <div class="start">
                <div class="container">
                    <div class="col-md-12">
                        <div class="content">
                            <h1>Sign in to Swipe</h1>
                            <form wire:submit="login">
                                @csrf
                                <div class="form-group">
                                    <input type="email" id="inputEmail" class="form-control" placeholder="Email Address" wire:model="email">
                                    <button class="btn icon"><i class="material-icons">mail_outline</i></button>

                                    @error('email')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" wire:model="password">
                                    <button class="btn icon"><i class="material-icons">lock_outline</i></button>

                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn button" formaction="index-2.html">Sign In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sign In -->
        <!-- Start of Sidebar -->
        <div class="aside order-md-2">
            <div class="container">
                <div class="col-md-12">
                    <div class="preference">
                        <h2>Hello, Friend!</h2>
                        <p>Enter your personal details and start your journey with Swipe today.</p>
                        <a href={{ route('register') }} wire:navigate class="btn button">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sidebar -->
    </div> <!-- Layout -->
</main>
