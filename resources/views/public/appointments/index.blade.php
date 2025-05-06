@foreach($appointments as $appointment)
    <div class="bg-white rounded-lg shadow-md p-4 mb-4">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Dr. {{ $appointment->doctor->name }}</h3>
                <p class="text-gray-600">{{ $appointment->appointment_date->format('F j, Y') }} at {{ $appointment->appointment_time->format('g:i A') }}</p>
                <p class="text-sm text-gray-500">Status: <span class="font-medium {{ $appointment->status === 'confirmed' ? 'text-green-600' : 'text-yellow-600' }}">{{ ucfirst($appointment->status) }}</span></p>
            </div>
            <div class="flex gap-2">
                @if($appointment->status === 'confirmed' && !$appointment->rating)
                    <a href="{{ route('appointments.rate', $appointment) }}" class="btn btn-primary btn-sm">
                        <i class="icofont-star mr-1"></i> Rate Doctor
                    </a>
                @endif
                @if($appointment->status === 'pending')
                    <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="icofont-close-circled mr-1"></i> Cancel
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endforeach 