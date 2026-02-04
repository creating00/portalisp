<?php
use Livewire\Volt\Component;
use App\Services\IspApiService;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

new class extends Component {
    protected string $layout = 'layouts.app';

    public $email = '';
    public $password = '';
    public $remember = false;

    public function login(IspApiService $api)
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $response = $api->login($this->email, $this->password);

            if ($response->successful()) {
                session(['api_token' => $response->json('token')]);

                // Intentar obtener el nombre del usuario para el navbar
                $resCliente = $api->getCliente($response->json('token'));
                if ($resCliente->successful()) {
                    session([
                        'cliente' => [
                            'id' => $resCliente->json('id'),
                            'dni' => $resCliente->json('dni'),
                            'nombre' => $resCliente->json('nombre'),
                            'apellido' => $resCliente->json('apellido'),
                            'email' => $resCliente->json('mail'),
                        ],
                    ]);
                }

                return redirect()->to('/');
            }

            // Si la API responde pero no es exitoso (ej: 401)
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no coinciden con nuestro sistema externo.',
            ]);
        } catch (\Exception $e) {
            // Manejo de errores de conexión o API caída
            session()->flash('error', 'Error de conexión con el servidor de autenticación.');
        }
    }
}; ?>

<div class="flex min-h-screen">
    <div class="flex flex-col justify-center items-center w-full lg:w-[45%] p-8 md:p-16 xl:p-24 bg-white z-10">
        <div class="w-full max-w-md">
            <x-auth.header title="Welcome Back" subtitle="Please enter your details to sign in to your account." />

            {{-- Mostrar errores generales si los hay --}}
            @if (session()->has('error'))
                <div class="mb-4 text-red-500 font-bold text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="login" class="space-y-6">
                <x-auth.input label="Email" type="email" id="email" placeholder="name@company.com" icon="mail"
                    wire:model="email" />
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-bold text-slate-700" for="password">Password</label>
                        <a class="text-sm font-bold text-primary-violet hover:text-primary-violet/80 transition-colors"
                            href="#">Forgot Password?</a>
                    </div>
                    <x-auth.input-raw wire:model="password" type="password" id="password" placeholder="••••••••"
                        icon="lock" />
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input wire:model="remember"
                        class="w-5 h-5 rounded border-slate-300 text-primary-violet focus:ring-primary-violet"
                        id="remember" type="checkbox" />
                    <label class="ml-2 text-sm font-medium text-slate-600" for="remember">Remember for 30
                        days</label>
                </div>

                <button
                    class="w-full bg-primary-orange text-white py-4 rounded-xl font-extrabold text-lg shadow-lg shadow-primary-orange/20 hover:bg-orange-600 transition-all hover:scale-[1.02] active:scale-95 orange-glow"
                    type="submit">
                    <span wire:loading.remove>Login</span>
                    <span wire:loading>Processing...</span>
                </button>

                <x-auth.social-button provider="Google"
                    icon="https://lh3.googleusercontent.com/aida-public/AB6AXuATxCB90x02Oe_JPlXvN849ZvjrG_FE5TTBRQspdATOGPt1sLjhYHJKmDvqJaGZH9Mp5nPyFpfB7P7LEMlvANn4YKE21vGwMWb4ZtY1M5JdhKef8aXIsxVelUO6T4fccjIvAP7tRf46F7eegYdcrqCVugC3vu9GHN5TLdcAn2e0HQGKykMMsSvVHlyhBwnXojyuVLxlqL9vQ0VlmFcBO28lczrOQ5krIpHWSnTBHDhfjzvu1kH0sWWWWyf7CakjZYIK4Rd6SS6NBeyQ" />
            </form>

            <p class="mt-10 text-center text-slate-600 font-medium">
                Don't have an account?
                <a class="text-primary-orange font-bold hover:underline ml-1" href="/register">Sign up</a>
            </p>
        </div>

        <footer class="mt-auto pt-10 text-slate-400 text-xs font-medium">
            © 2026 YnfinitY Portal. All rights reserved.
        </footer>
    </div>

    <x-auth.visual-side />
</div>
