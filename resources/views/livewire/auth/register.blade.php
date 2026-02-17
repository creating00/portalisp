<?php
use Livewire\Volt\Component;
use App\Services\IspApiService;
use App\Actions\Auth\RegisterUserAction;
use Illuminate\Validation\ValidationException;

new class extends Component {
    protected string $layout = 'layouts.app';

    public string $dni = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;

    public function register(RegisterUserAction $action, IspApiService $api)
    {
        $this->validate([
            'dni' => 'required|string|min:7',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted',
        ]);

        try {
            $action->execute($api, [
                'dni' => $this->dni,
                'email' => $this->email,
                'password' => $this->password,
            ]);

            return redirect()->to('/');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            session()->flash('error', 'No se pudo establecer comunicación con el servidor central.');
        }
    }
};
?>

<div class="flex min-h-screen w-full bg-brand-dark">

    <div class="w-full lg:w-[45%] flex flex-col p-8 lg:p-16 xl:p-24 overflow-y-auto">

        <x-auth.header title="Create Account" subtitle="Join the network." is-dark="true" />

        <div class="flex-1 flex flex-col justify-center max-w-md mx-auto w-full">

            @if (session()->has('error'))
                <div class="mb-4 text-red-400 text-sm font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="register" class="space-y-5">

                <x-auth.input-dark label="DNI / CUIT" type="text" id="dni" placeholder="12345678" icon="badge"
                    model="dni" />
                @error('dni')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror

                <x-auth.input-dark label="Email Address" type="email" id="email" placeholder="name@company.com"
                    icon="mail" model="email" />
                @error('email')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-auth.input-dark label="Password" type="password" id="password" placeholder="••••••••"
                        icon="lock" model="password" />

                    <x-auth.input-dark label="Confirm Password" type="password" id="password_confirmation"
                        placeholder="••••••••" icon="shield_lock" model="password_confirmation" />
                </div>
                @error('password')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror

                <div class="flex items-start gap-3 pt-2">
                    <input wire:model="terms"
                        class="w-4 h-4 text-primary-orange bg-white/5 border-white/10 rounded focus:ring-primary-orange"
                        id="terms" type="checkbox" />
                    <label class="text-sm text-slate-400" for="terms">
                        I agree to the
                        <a class="text-primary-violet hover:underline" href="#">
                            Terms of Service
                        </a>
                    </label>
                </div>
                @error('terms')
                    <span class="text-red-400 text-xs">{{ $message }}</span>
                @enderror

                <button
                    class="w-full bg-primary-orange hover:bg-orange-600 text-white font-extrabold py-4 rounded-xl mt-4 transition-all orange-glow transform active:scale-[0.98]">
                    Create Account
                </button>

            </form>

            <p class="mt-8 text-center text-slate-400 text-sm">
                Already have an account?
                <a class="text-primary-orange font-bold hover:underline" href="/login">Log in</a>
            </p>
        </div>

        <x-auth.footer-simple />
    </div>

    <x-auth.visual-side-register />
</div>
