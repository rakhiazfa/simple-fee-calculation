<x-layout title="Login">

    <main class="min-h-screen bg-gray-100">

        <section class="wrapper min-h-screen grid grid-cols-1 place-items-center">

            <div class="w-full max-w-[360px] bg-white rounded-md shadow-xxs px-5 sm:px-7 pt-6 pb-10">

                <h1 class="text-2xl text-center font-bold mb-5">Login</h1>

                <hr>

                <form class="mt-5" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-7">

                        <div class="field">
                            <label class="label">Email</label>
                            <input type="text" class="control" name="email" placeholder="Masukan email anda . . ."
                                value="{{ old('email') }}">
                            @error('email')
                                <p class="invalid-field">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <input type="password" class="control" name="password"
                                placeholder="Masukan kata sandi anda . . .">
                            @error('password')
                                <p class="invalid-field">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="button primary mt-2">Login</button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</x-layout>
