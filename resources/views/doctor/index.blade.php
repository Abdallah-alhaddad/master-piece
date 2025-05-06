@extends('layouts.public.doctorPortal')

@section('styles')
<style>
    .sidebar {
        background-color: #223a66;
    }
    .btn-primary {
        background-color: #e12454;
        color: white;
    }
    .btn-primary:hover {
        background-color: #c01e48;
    }
    .badge-pending {
        background-color: #f59e0b;
        color: white;
    }
    .badge-confirmed {
        background-color: #10b981;
        color: white;
    }
    .badge-cancelled {
        background-color: #ef4444;
        color: white;
    }
    .badge-completed {
        background-color: #3b82f6;
        color: white;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 4px;
    }
    .dropdown-content a {
        color: black;
        padding: 8px 12px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .action-btn {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
    }
    .edit-btn {
        background-color: #3b82f6;
        color: white;
        border: none;
    }
    .edit-btn:hover {
        background-color: #2563eb;
    }
    .cancel-btn {
        background-color: #ef4444;
        color: white;
        border: none;
    }
    .cancel-btn:hover {
        background-color: #dc2626;
    }
    .confirm-btn {
        background-color: #10b981;
        color: white;
        border: none;
    }
    .confirm-btn:hover {
        background-color: #059669;
    }
    .inline-form {
        display: inline-block;
    }
    .day-badge {
        display: inline-block;
        background-color: #1a365d;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
    }
    .working-hours {
        font-size: 0.875rem;
        color: #cbd5e0;
        margin-top: 0.5rem;
    }
    #newAppointmentModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}
#newAppointmentModal > div {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}
.hiddenM {
    display: none !important;
}

</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-0 py-8">
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Doctor Profile Sidebar -->
        <div class="md:w-1/3 lg:w-1/4">
            <div class="sidebar rounded-lg shadow-lg overflow-hidden text-white">
                <!-- Profile Header -->
                <div class="bg-[#1a2d52] p-6 text-center">
                    <div class="relative inline-block">
                        @isset($doctor->image)
                        <img src="{{ asset('storage/'.$doctor->image) }}" alt="Profile Photo"
                             class="w-32 h-32 rounded-full object-cover border-4 border-[#e12454] mx-auto">
                        @else
                        <div class="w-32 h-32 rounded-full bg-gray-200 border-4 border-[#e12454] mx-auto flex items-center justify-center text-4xl font-bold text-gray-600">
                            {{ substr($doctor->name, 0, 1) }}
                        </div>
                        @endisset
                        <span class="absolute bottom-0 right-0 bg-green-500 rounded-full w-4 h-4 border-2 border-white"></span>
                    </div>
                    <h2 class="text-xl font-bold mt-4">{{ $doctor->name ?? 'Doctor Name' }}</h2>
                    @isset($doctor->specialization)
                    <p class="text-blue-200">{{ $doctor->specialization->name }}</p>
                    @endisset
                    <div class="mt-4">
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#e12454] hover:bg-[#c01e48]">
                            Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-blue-300 uppercase tracking-wider">Contact Information</h3>
                        <ul class="mt-2 space-y-2">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-blue-200 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $doctor->email ?? 'N/A' }}</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-blue-200 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $doctor->phone ?? 'N/A' }}</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-blue-200 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>
                                    @isset($doctor->address){{ $doctor->address }}@endisset
                                    @isset($doctor->governorate), {{ $doctor->governorate }}@endisset
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-blue-300 uppercase tracking-wider">Professional Details</h3>
                        <ul class="mt-2 space-y-2">
                            <li class="flex justify-between">
                                <span class="text-blue-100">Experience:</span>
                                <span>{{ $doctor->experience_years ?? '0' }} years</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-blue-100">Fee:</span>
                                <span>{{ $doctor->price_per_appointment ?? '0' }} JOD</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-blue-100">Status:</span>
                                <span class="capitalize">{{ $doctor->status ?? 'active' }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-blue-300 uppercase tracking-wider">Availability</h3>
                        <div class="mt-2">
                            @php
                                $days = [
                                    'monday' => 'Monday',
                                    'tuesday' => 'Tuesday',
                                    'wednesday' => 'Wednesday',
                                    'thursday' => 'Thursday',
                                    'friday' => 'Friday',
                                    'saturday' => 'Saturday',
                                    'sunday' => 'Sunday'
                                ];
                                $hasAvailability = false;
                            @endphp

                            @foreach($days as $key => $day)
                                @if($doctor->$key)
                                    <span class="day-badge">{{ $day }}</span>
                                    @php $hasAvailability = true; @endphp
                                @endif
                            @endforeach

                            @if(!$hasAvailability)
                                <p class="text-sm text-blue-100">No availability set</p>
                            @endif
                        </div>
                        @if($doctor->working_hours_start && $doctor->working_hours_end)
                            <div class="working-hours">
                                Working Hours: {{ \Carbon\Carbon::parse($doctor->working_hours_start)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($doctor->working_hours_end)->format('h:i A') }}
                            </div>
                        @endif
                    </div>

                    {{-- <div class="mt-6">
                        <a href="{{ route('doctor.profile.edit') }}" class="btn-primary w-full py-2 px-4 rounded-md font-medium text-center block">
                            Edit Profile
                        </a>
                    </div> --}}
                </div>
            </div>

            <!-- Quick2 Stats -->
            <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Stats</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <p class="text-2xl font-bold text-[#223a66]">{{ $total_appointments ?? 0 }}</p>
                        <p class="text-xs text-gray-600">Total Appointments</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <p class="text-2xl font-bold text-green-600">{{ $completed_appointments ?? 0 }}</p>
                        <p class="text-xs text-gray-600">Confirmed</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-lg">
                        <p class="text-2xl font-bold text-yellow-600">{{ $pending_appointments ?? 0 }}</p>
                        <p class="text-xs text-gray-600">Pending</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-lg">
                        <p class="text-2xl font-bold text-red-600">{{ $canceled_appointments ?? 0 }}</p>
                        <p class="text-xs text-gray-600">Canceled</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content - Appointments -->
        <div class="md:w-2/3 lg:w-3/4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Appointments Header -->
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Appointments</h2>
                        <div class="flex space-x-2">
                            <button id="newAppointmentButton" class="btn-primary px-4 py-2 rounded-md text-sm">
                                + New Appointment
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Appointments Content -->
                <div class="p-6">
                    <!-- Upcoming Appointments Table -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Appointments</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date & Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @isset($upcomingAppointments)
                                        @foreach($upcomingAppointments as $appointment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @isset($appointment->patient)
                                                        <img class="h-10 w-10 rounded-full" src="{{ $appointment->patient->image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($appointment->patient->name).'&color=223a66&background=e12454' }}" alt="">
                                                        @endisset
                                                    </div>
                                                    <div class="ml-4">
                                                        @isset($appointment->patient)
                                                        <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $appointment->patient->email }}</div>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @isset($appointment->appointment_date)
                                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                                                @endisset
                                                @isset($appointment->appointment_time)
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                                @endisset
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @isset($appointment->status)
                                                <span class="px-2 py-1 text-xs rounded-full badge-{{ $appointment->status }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                                @endisset
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex space-x-2">
                                                    @if($appointment->status == 'pending')
                                                        <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="confirm-btn action-btn">
                                                                Confirm
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="canceled">
                                                            <button type="submit" class="cancel-btn action-btn">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($appointment->status == 'confirmed')
                                                        <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="canceled">
                                                            <button type="submit" class="cancel-btn action-btn">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($appointment->status == 'canceled')
                                                        <form method="POST" action="{{ route('doctor.appointments.update', ['appointmentId' => $appointment->id]) }}" class="inline-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="confirm-btn action-btn">
                                                                Re-confirm
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                No upcoming appointments found
                                            </td>
                                        </tr>
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                        @isset($upcomingAppointments)
                        <div class="mt-4">
                            {{ $upcomingAppointments->links() }}
                        </div>
                        @endisset
                    </div>

                    <!-- Recent Appointments Table -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Appointments</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date & Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @isset($recentAppointments)
                                        @foreach($recentAppointments as $appointment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @isset($appointment->patient)
                                                        <img class="h-10 w-10 rounded-full" src="{{ $appointment->patient->image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($appointment->patient->name).'&color=223a66&background=e12454' }}" alt="">
                                                        @endisset
                                                    </div>
                                                    <div class="ml-4">
                                                        @isset($appointment->patient)
                                                        <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $appointment->patient->email }}</div>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @isset($appointment->appointment_date)
                                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                                                @endisset
                                                @isset($appointment->appointment_time)
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                                @endisset
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @isset($appointment->status)
                                                <span class="px-2 py-1 text-xs rounded-full badge-{{ $appointment->status }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                                @endisset
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex space-x-2">
                                                    <a href="#" class="text-[#e12454] hover:text-[#c01e48] mr-3">View</a>
                                                    <a href="#" class="text-[#223a66] hover:text-[#1a2d52]">Notes</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                No recent appointments found
                                            </td>
                                        </tr>
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                        @isset($recentAppointments)
                        <div class="mt-4">
                            {{ $recentAppointments->links() }}
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="newAppointmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hiddenM z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-bold text-gray-800">New Appointment</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Error Message Container -->
        <div id="errorMessage" class="hiddenM bg-red-50 border-l-4 border-red-500 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p id="errorText" class="text-sm text-red-700"></p>
                </div>
            </div>
        </div>

        <!-- Patient Information Step -->
        <div id="patientInfoStep" class="mt-4">
            <h4 class="text-lg font-semibold mb-4">Patient Information</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="patientName" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="patientName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#e12454] focus:border-[#e12454]">
                </div>
                <div>
                    <label for="patientPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" id="patientPhone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#e12454] focus:border-[#e12454]">
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button id="nextToDate" class="btn-primary px-4 py-2 rounded-md text-sm">
                    Next: Select Date & Time
                </button>
            </div>
        </div>

        <!-- Date & Time Selection Step -->
        <div id="dateTimeStep" class="mt-4 hiddenM">
            <h4 class="text-lg font-semibold mb-4">Select Date & Time</h4>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Available Dates</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="availableDatesContainer">
                    <!-- Dates will be populated by JavaScript -->
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Available Time Slots</label>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2 time-slots-container">
                    <!-- Time slots will be populated by JavaScript -->
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <button id="backToPatient" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                    Back to Patient Info
                </button>
                <button id="confirmAppointment" class="btn-primary px-4 py-2 rounded-md text-sm">
                    Confirm Appointment
                </button>
            </div>
        </div>

        <!-- Confirmation Step -->
        <div id="confirmationStep" class="mt-4 hiddenM">
            <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Appointment Scheduled Successfully!</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p id="confirmationDetails"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button id="closeModalAfterConfirm" class="btn-primary px-4 py-2 rounded-md text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    document.getElementById('newAppointmentModal').classList.add('hiddenM');
    const modal = document.getElementById('newAppointmentModal');
    const closeModalBtn = document.getElementById('closeModal');
    const closeModalAfterConfirmBtn = document.getElementById('closeModalAfterConfirm');
    const newAppointmentBtn = document.getElementById('newAppointmentButton');

    // Error handling elements
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    // Step elements
    const patientInfoStep = document.getElementById('patientInfoStep');
    const dateTimeStep = document.getElementById('dateTimeStep');
    const confirmationStep = document.getElementById('confirmationStep');

    // Navigation buttons
    const nextToDateBtn = document.getElementById('nextToDate');
    const backToPatientBtn = document.getElementById('backToPatient');
    const confirmAppointmentBtn = document.getElementById('confirmAppointment');

    // Form fields
    const patientName = document.getElementById('patientName');
    const patientPhone = document.getElementById('patientPhone');

    // Open modal when clicking the New Appointment button
    if (newAppointmentBtn) {
        newAppointmentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hiddenM');
            resetModal();
        });
    }

    // Close modal
    closeModalBtn.addEventListener('click', function() {
        modal.classList.add('hiddenM');
    });

    closeModalAfterConfirmBtn.addEventListener('click', function() {
        modal.classList.add('hiddenM');
        window.location.reload();
    });

    // Show error message
    function showError(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hiddenM');
        setTimeout(() => {
            errorMessage.classList.add('hiddenM');
        }, 5000);
    }

    // Next button - validate patient info and show date/time selection
    nextToDateBtn.addEventListener('click', function() {
        if (!patientName.value.trim()) {
            showError('Please enter patient name');
            patientName.focus();
            return;
        }

        if (!patientPhone.value.trim()) {
            showError('Please enter patient phone number');
            patientPhone.focus();
            return;
        }

        // Simple phone number validation
        if (!/^[0-9+]{8,15}$/.test(patientPhone.value.trim())) {
            showError('Please enter a valid phone number');
            patientPhone.focus();
            return;
        }

        patientInfoStep.classList.add('hiddenM');
        dateTimeStep.classList.remove('hiddenM');
        loadAvailableDates();
    });

    // Back button - return to patient info
    backToPatientBtn.addEventListener('click', function() {
        dateTimeStep.classList.add('hiddenM');
        patientInfoStep.classList.remove('hiddenM');
    });

    // Confirm appointment button
    confirmAppointmentBtn.addEventListener('click', function() {
        const selectedDate = document.querySelector('.date-card.selected');
        const selectedTime = document.querySelector('.time-slot.selected');

        if (!selectedDate || !selectedTime) {
            showError('Please select both date and time');
            return;
        }

        const appointmentData = {
            patient_name: patientName.value.trim(),
            patient_phone: patientPhone.value.trim(),
            appointment_date: selectedDate.dataset.date,
            appointment_time: selectedTime.dataset.time,
            doctor_id: {{ $doctor->id }},
            status: 'confirmed'
        };

        fetch('{{ route("doctor.appointments.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(appointmentData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                dateTimeStep.classList.add('hiddenM');
                confirmationStep.classList.remove('hiddenM');
                document.getElementById('confirmationDetails').innerHTML = `
                    <p><strong>Patient:</strong> ${appointmentData.patient_name}</p>
                    <p><strong>Date:</strong> ${formatDateForDisplay(appointmentData.appointment_date)}</p>
                    <p><strong>Time:</strong> ${formatTimeForDisplay(appointmentData.appointment_time)}</p>
                `;
            } else {
                showError(data.message || 'Failed to create appointment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('An error occurred while creating the appointment');
        });
    });

    // Reset modal to initial state
    function resetModal() {
        patientInfoStep.classList.remove('hiddenM');
        dateTimeStep.classList.add('hiddenM');
        confirmationStep.classList.add('hiddenM');
        errorMessage.classList.add('hiddenM');
        patientName.value = '';
        patientPhone.value = '';
    }

    // Load available dates for the next 14 days
    function loadAvailableDates() {
        const datesContainer = document.getElementById('availableDatesContainer');
        datesContainer.innerHTML = '';

        const workingDays = [
            @if($doctor->monday) 'Monday', @endif
            @if($doctor->tuesday) 'Tuesday', @endif
            @if($doctor->wednesday) 'Wednesday', @endif
            @if($doctor->thursday) 'Thursday', @endif
            @if($doctor->friday) 'Friday', @endif
            @if($doctor->saturday) 'Saturday', @endif
            @if($doctor->sunday) 'Sunday', @endif
        ];

        const unavailableDates = {!! json_encode($doctor->unavailable->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        })) !!};

        const unavailableTimes = {!! json_encode($doctor->unavailable->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
        })->map(function($group) {
            return $group->map(function($item) {
                return \Carbon\Carbon::parse($item->start_time)->format('H:i');
            });
        })) !!};

        const today = new Date();
        let hasAvailableDates = false;

        for (let i = 0; i < 14; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);

            const dayName = date.toLocaleDateString('en-US', { weekday: 'long' });
            if (!workingDays.includes(dayName)) continue;

            const dateKey = formatDate(date);
            const isDateUnavailable = unavailableDates.includes(dateKey) &&
                                     unavailableTimes[dateKey] &&
                                     unavailableTimes[dateKey].includes('00:00');

            const dateCard = document.createElement('div');
            dateCard.className = `border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow date-card ${
                isDateUnavailable ? 'bg-gray-50 opacity-70 cursor-not-allowed' : 'cursor-pointer'
            }`;
            dateCard.dataset.date = dateKey;

            if (isDateUnavailable) {
                dateCard.innerHTML = `
                    <h4 class="font-medium text-gray-900 mb-2 text-center text-sm bg-gray-100 py-1 rounded">
                        ${i === 0 ? 'Today' : i === 1 ? 'Tomorrow' : dayName.substring(0, 3)}, ${formatDateForDisplay(dateKey)}
                    </h4>
                    <div class="text-center py-4 text-gray-500">
                        Unavailable all day
                    </div>
                `;
            } else {
                hasAvailableDates = true;
                dateCard.innerHTML = `
                    <h4 class="font-medium text-gray-900 mb-2 text-center text-sm bg-gray-50 py-1 rounded ${
                        i === 0 ? 'text-[#e12454] font-bold' : i === 1 ? 'text-[#e12454] font-bold' : ''
                    }">
                        ${i === 0 ? 'Today' : i === 1 ? 'Tomorrow' : dayName.substring(0, 3)}, ${formatDateForDisplay(dateKey)}
                    </h4>
                    <div class="text-center py-2 text-sm text-gray-600">
                        Available
                    </div>
                `;

                dateCard.addEventListener('click', function() {
                    document.querySelectorAll('.date-card').forEach(card => {
                        card.classList.remove('selected', 'border-[#e12454]', 'bg-[#fef1f4]');
                    });
                    this.classList.add('selected', 'border-[#e12454]', 'bg-[#fef1f4]');
                    loadAvailableTimes(dateKey, unavailableTimes[dateKey] || []);
                });
            }

            datesContainer.appendChild(dateCard);
        }

        if (!hasAvailableDates) {
            datesContainer.innerHTML = `
                <div class="col-span-full text-center py-6 text-gray-500">
                    No available days in the next 14 days
                </div>
            `;
        }
    }

    // Load available time slots for a specific date
    function loadAvailableTimes(date, unavailableTimes) {
        const timeSlotsContainer = document.querySelector('.time-slots-container');
        timeSlotsContainer.innerHTML = '';

        const workingHoursStart = '{{ $doctor->working_hours_start }}';
        const workingHoursEnd = '{{ $doctor->working_hours_end }}';

        // Get already booked appointments for this date
        const bookedAppointments = {!! json_encode($doctor->appointments()
            ->where('status', 'confirmed')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->appointment_date)->format('Y-m-d');
            })
            ->map(function($group) {
                return $group->map(function($item) {
                    return \Carbon\Carbon::parse($item->appointment_time)->format('H:i');
                });
            })) !!};

        const startTime = new Date(`2000-01-01T${workingHoursStart}`);
        const endTime = new Date(`2000-01-01T${workingHoursEnd}`);

        let currentTime = new Date(startTime);
        while (currentTime < endTime) {
            const timeKey = formatTime(currentTime);
            const displayTime = formatTimeForDisplay(timeKey);
            const isUnavailable = unavailableTimes.includes(timeKey);
            const isBooked = bookedAppointments[date] && bookedAppointments[date].includes(timeKey);

            const timeSlot = document.createElement('button');
            timeSlot.className = `py-2 px-3 rounded-md text-sm text-center time-slot ${
                isUnavailable || isBooked ?
                'bg-gray-100 text-gray-400 line-through cursor-not-allowed' :
                'bg-gray-50 hover:bg-[#e12454] hover:text-white border border-gray-200'
            }`;
            timeSlot.dataset.time = timeKey;
            timeSlot.textContent = displayTime;

            if (!isUnavailable && !isBooked) {
                timeSlot.addEventListener('click', function() {
                    document.querySelectorAll('.time-slot').forEach(slot => {
                        slot.classList.remove('selected', 'bg-[#e12454]', 'text-white');
                        if (!slot.classList.contains('cursor-not-allowed')) {
                            slot.classList.add('hover:bg-[#e12454]', 'hover:text-white');
                        }
                    });
                    this.classList.add('selected', 'bg-[#e12454]', 'text-white');
                    this.classList.remove('hover:bg-[#e12454]', 'hover:text-white');
                });
            } else if (isBooked) {
                timeSlot.title = 'This time slot is already booked';
            }

            timeSlotsContainer.appendChild(timeSlot);
            currentTime.setMinutes(currentTime.getMinutes() + 30);
        }
    }

    // Helper functions
    function formatDate(date) {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [year, month, day].join('-');
    }

    function formatDateForDisplay(dateStr) {
        const options = { month: 'short', day: 'numeric' };
        return new Date(dateStr).toLocaleDateString('en-US', options);
    }

    function formatTime(date) {
        const d = new Date(date);
        let hours = '' + d.getHours();
        let minutes = '' + d.getMinutes();
        if (hours.length < 2) hours = '0' + hours;
        if (minutes.length < 2) minutes = '0' + minutes;
        return [hours, minutes].join(':');
    }

    function formatTimeForDisplay(timeStr) {
        const [hours, minutes] = timeStr.split(':');
        const hour = parseInt(hours, 10);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        return `${hour12}:${minutes} ${ampm}`;
    }
});
</script>
@endsection
