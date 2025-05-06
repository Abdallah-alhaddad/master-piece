<x-app-layout>
    <!-- Profile Section -->
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <!-- Left Side - User Info Card -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="bg-white p-6 rounded-xl shadow">
                        <div class="text-center">
                            <div class="relative inline-block">
                                @if(auth()->user()->image)
                                    <img src="{{ asset('storage/' . auth()->user()->image) }}"
                                        class="rounded-full h-32 w-32 border-4 border-white shadow-md"
                                        alt="User profile">
                                @else
                                    <img src="{{ asset('images/default.jpg') }}"
                                    class="rounded-full h-32 w-32 border-4 border-white shadow-md"
                                    alt="User profile">
                                @endif
                            </div>

                            <h2 class="mt-4 text-md font-medium text-gray-900">{{ Auth::user()->name ?? 'User' }}</h2>
                            <p class="text-sm text-gray-600">Patient</p>

                            <button class="mt-4 px-4 py-2 rounded-md btn-main text-white transition">
                                <a href="{{ route('profile.edit') }}" class="inline-flex text-white items-center">
                                    <i class="icofont-edit mr-2"></i>Edit Profile
                                </a>
                            </button>

                            <hr class="my-4 border-gray-200">

                            <div class="space-y-3 text-left">
                                <div class="flex items-center">
                                    <i class="icofont-phone text-gray-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Phone</p>
                                        <p class="text-sm text-gray-600">{{ Auth::user()->phone ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <i class="icofont-email text-gray-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Email</p>
                                        <p class="text-sm text-gray-600">{{ Auth::user()->email ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <i class="icofont-user-alt-3 text-gray-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Age</p>
                                        <p class="text-sm text-gray-600">{{ Auth::user()->age ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <i class="icofont-location-pin text-gray-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Address</p>
                                        <p class="text-sm text-gray-600">{{ Auth::user()->address ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Content Tabs -->
                <div class="col-lg-8">
                    <div class="bg-white rounded-xl shadow">
                        <!-- Tab Navigation -->
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8 overflow-x-auto">
                                <button onclick="switchTab('appointments')" id="appointmentsTab" class="border-b-2 border-transparent whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    <i class="icofont-calendar mr-2"></i>Appointments
                                </button>
                                <button onclick="switchTab('doctors')" id="doctorsTab" class="border-b-2 border-transparent whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    <i class="icofont-user-md mr-2"></i>My Doctors
                                </button>
                            </nav>
                        </div>

                        <!-- Appointments Content -->
                        <div id="appointmentsContent" class="p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                                <h3 class="text-md font-medium text-gray-900 mb-2 sm:mb-0">My Appointments</h3>
                                <a href="{{ route('doctors') }}" class="btn btn-main btn-sm">
                                    <i class="icofont-plus mr-1"></i> Book New
                                </a>
                            </div>

                            <!-- Status Filter -->
                            <div class="flex mb-4 space-x-2 overflow-x-auto pb-2">
                                <a href="{{ route('profile') }}" class="status-filter btn btn-xs {{ empty($currentStatus) ? 'btn-main' : 'btn-outline-primary' }}">
                                    All
                                </a>
                                <a href="{{ route('profile', ['status' => 'pending']) }}" class="status-filter btn btn-xs {{ $currentStatus === 'pending' ? 'btn-main' : 'btn-outline-primary' }}">
                                    Pending
                                </a>
                                <a href="{{ route('profile', ['status' => 'confirmed']) }}" class="status-filter btn btn-xs {{ $currentStatus === 'confirmed' ? 'btn-main' : 'btn-outline-primary' }}">
                                    Confirmed
                                </a>
                                <a href="{{ route('profile', ['status' => 'canceled']) }}" class="status-filter btn btn-xs {{ $currentStatus === 'canceled' ? 'btn-main' : 'btn-outline-primary' }}">
                                    Canceled
                                </a>
                            </div>

                            <!-- Appointments List -->
                            <div class="space-y-3">
                                @forelse($appointments ?? [] as $appointment)
                                <div class="border rounded-lg p-3 hover:shadow transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img src="{{ ($appointment->doctor && $appointment->doctor->image) ? asset('storage/' . $appointment->doctor->image) : asset('images/default-doctor.jpg') }}"
                                                 class="rounded-full h-10 w-10 border-2 border-white shadow mr-3"
                                                 alt="Doctor">
                                            <div>
                                                <h4 class="text-sm font-medium">Dr. {{ $appointment->doctor->name ?? 'Unknown Doctor' }}</h4>
                                                <p class="text-xs text-gray-600">
                                                    {{ $appointment->doctor->specialization->name ?? 'General Practitioner' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <div class="text-right">
                                                <span class="status-badge status-{{ $appointment->status ?? 'unknown' }} px-2 py-1 rounded-full text-xs">
                                                    {{ ucfirst($appointment->status ?? 'unknown') }}
                                                </span>
                                                <p class="text-xs text-gray-600 mt-1">
                                                    @isset($appointment->appointment_date)
                                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M j, Y') }}
                                                    @endisset
                                                    @isset($appointment->appointment_time)
                                                        • {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                    @endisset
                                                </p>
                                            </div>
                                            <div class="flex gap-2">
                                                @if($appointment->status === 'confirmed' && !$appointment->rating)
                                                    <a href="{{ route('appointments.rate', $appointment) }}" class="btn btn-primary btn-xs">
                                                        <i class="icofont-star mr-1"></i> Rate
                                                    </a>
                                                @endif
                                                @if($appointment->id)
                                                    <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-outline-primary btn-xs">
                                                        <i class="icofont-info-circle"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <i class="icofont-calendar text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600">No appointments found.</p>
                                    <a href="{{ route('doctors') }}" class="btn btn-main btn-sm mt-3">
                                        <i class="icofont-plus mr-1"></i> Book Appointment
                                    </a>
                                </div>
                                @endforelse
                            </div>

                            @if(isset($appointments) && $appointments->hasPages())
                            <div class="mt-4">
                                {{ $appointments->withQueryString()->links() }}
                            </div>
                            @endif
                        </div>

                        <!-- Doctors Content -->
                        <div id="doctorsContent" class="p-6 hidden">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-md font-medium text-gray-900">My Doctors</h3>
                                <a href="{{ route('doctors') }}" class="btn btn-main btn-sm">
                                    <i class="icofont-search mr-1"></i> Find New
                                </a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($doctors ?? [] as $doctor)
                                <div class="border rounded-lg p-4 hover:shadow transition">
                                    <div class="flex items-start">
                                        <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('images/default-doctor.jpg') }}"
                                             class="rounded-full h-12 w-12 border-2 border-white shadow mr-3"
                                             alt="Doctor">
                                        <div>
                                            <h4 class="font-medium">Dr. {{ $doctor->name ?? 'Unknown Doctor' }}</h4>
                                            <p class="text-sm text-gray-600 mb-2">
                                                {{ $doctor->specialization->name ?? 'General Practitioner' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mb-3">
                                                <i class="icofont-location-pin"></i> {{ $doctor->governorate ?? 'Location not specified' }}
                                            </p>
                                            <div class="flex gap-2">
                                                <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="icofont-eye mr-1"></i> View
                                                </a>
                                                <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}" class="btn btn-main btn-sm">
                                                    <i class="icofont-calendar mr-1"></i> Book
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-2 text-center py-8">
                                    <i class="icofont-user-md text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600">You haven't saved any doctors yet.</p>
                                    <a href="{{ route('doctors') }}" class="btn btn-main btn-sm mt-3">
                                        <i class="icofont-search mr-1"></i> Find Doctors
                                    </a>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }

        .status-pending {
            background-color: #fffbeb;
            color: #d97706;
        }

        .status-confirmed {
            background-color: #f0fdf4;
            color: #16a34a;
        }

        .status-canceled {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .status-unknown {
            background-color: #f3f4f6;
            color: #6b7280;
        }
    </style>

    <script>
        function switchTab(tabName) {
            // Hide all content
            document.getElementById('appointmentsContent').classList.add('hidden');
            document.getElementById('doctorsContent').classList.add('hidden');

            // Remove active class from all tabs
            document.getElementById('appointmentsTab').classList.remove('border-red-500', 'text-red-600');
            document.getElementById('doctorsTab').classList.remove('border-red-500', 'text-red-600');

            // Show selected content and mark tab as active
            document.getElementById(tabName + 'Content').classList.remove('hidden');
            document.getElementById(tabName + 'Tab').classList.add('border-red-500', 'text-red-600');

            // Update URL without reload
            history.pushState(null, null, '#' + tabName);
        }

        // Initialize based on hash or default to appointments
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.substring(1);
            if (hash === 'doctors') {
                switchTab('doctors');
            } else {
                switchTab('appointments');
            }
        });
    </script>
</x-app-layout>
