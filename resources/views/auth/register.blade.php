<x-guest-layout>

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
        <h3 class="text-red-700 font-medium">Please fix the following errors:</h3>
        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Patient Registration</h1>
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full focus-accent" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full focus-accent" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" class="block mt-1 w-full focus-accent" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full focus-accent"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full focus-accent"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Image Upload Field -->
            <div class="mt-4">
                <x-input-label for="image" :value="__('Profile Photo (Optional)')" />
                <div class="file-upload mt-1 p-4 rounded-lg text-center" id="image-upload-container">
                    <input id="image" name="image" type="file" class="hidden" accept="image/*">
                    <label for="image" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-1 text-sm text-gray-600">Click to upload profile photo</p>
                        <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                    </label>
                </div>
                <div id="image-preview" class="hidden mt-2 text-center">
                    <img id="preview-image" class="mx-auto h-24 w-24 object-cover  border-2 border-white shadow">
                    <button type="button" class="mt-2 text-sm link-accent hover:underline" onclick="removeImage()">
                        Remove photo
                    </button>
                </div>
                <x-input-error :messages="$errors->get('image')" class="mt-1" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm link-accent hover:underline" href="{{ route('login') }}">
                    Already registered?
                </a>
                <button type="submit" class="btn-primary px-4 py-2 rounded-md font-medium">
                    Register
                </button>
            </div>
        </form>
</x-guest-layout>

<style>
    .btn-primary {
        background-color: #e12454;
        color: white;
    }
    .btn-primary:hover {
        background-color: #c01e48;
    }
    .link-accent {
        color: #e12454;
    }
    .link-accent:hover {
        color: #c01e48;
    }
    .border-accent {
        border-color: #e12454;
    }
    .focus-accent:focus {
        border-color: #e12454;
        ring-color: #e12454;
    }
    .file-upload {
        border: 1px dashed #d1d5db;
        transition: all 0.3s ease;
    }
    .file-upload:hover {
        border-color: #e12454;
    }
    .error-message {
        color: #e12454;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image upload preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('preview-image');
        const imagePreviewContainer = document.getElementById('image-preview');
        const imageUploadContainer = document.getElementById('image-upload-container');

        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        imagePreviewContainer.classList.remove('hidden');
                        imageUploadContainer.classList.add('hidden');
                    };

                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });

    function removeImage() {
        const imageInput = document.getElementById('image');
        const imagePreviewContainer = document.getElementById('image-preview');
        const imageUploadContainer = document.getElementById('image-upload-container');

        imageInput.value = '';
        imagePreviewContainer.classList.add('hidden');
        imageUploadContainer.classList.remove('hidden');
    }
</script>
