<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data"
        x-data="{ photoName: null, photoPreview: null }">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div>
            <x-input-label for="photo" :value="__('Profile Photo')" />

            <!-- Profile Photo File Input -->
            <input type="file" id="photo" name="photo" class="hidden" x-ref="photo" accept="image/*" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " />

            <div class="mt-2 flex items-center gap-4">
                <!-- Current Profile Photo -->
                <div x-show="! photoPreview" class="relative">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                            class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md">
                    @else
                        <div
                            class="h-20 w-20 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-3xl border-4 border-white shadow-md">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- New Profile Photo Preview -->
                <div x-show="photoPreview" style="display: none;">
                    <span
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center border-4 border-white shadow-md"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="flex flex-col">
                    <x-secondary-button class="mt-2 text-xs" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select New Photo') }}
                    </x-secondary-button>
                    <p class="mt-2 text-xs text-gray-500" x-show="photoName" x-text="photoName"></p>
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>