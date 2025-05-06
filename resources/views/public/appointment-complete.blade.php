<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <div class="text-center mb-6">
                <i class="icofont-check-circled text-6xl text-green-500 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Appointment Completed!</h2>
                <p class="text-gray-600">Thank you for choosing our service. We hope you had a great experience.</p>
            </div>

            @if(!$appointment->rating)
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Rate Your Experience</h3>
                <form action="{{ route('ratings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Rating</label>
                        <div class="rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                                <label for="star{{ $i }}">
                                    <i class="icofont-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 text-sm font-medium mb-2">Comment (Optional)</label>
                        <textarea name="comment" id="comment" rows="3" class="shadow-sm focus:ring-primary focus:border-primary mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            Submit Rating
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Thank You for Your Rating!</h3>
                <div class="flex items-center mb-2">
                    <div class="rating">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ $i == $appointment->rating->rating ? 'checked' : '' }} disabled>
                            <label for="star{{ $i }}">
                                <i class="icofont-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>
                @if($appointment->rating->comment)
                    <p class="text-gray-600 mt-2">{{ $appointment->rating->comment }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>

    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 0.25rem;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            font-size: 1.5rem;
            color: #e2e8f0;
            transition: color 0.2s;
        }

        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #fbbf24;
        }

        .rating input:checked ~ label {
            color: #fbbf24;
        }

        .rating input:disabled ~ label {
            cursor: default;
        }

        .rating input:disabled:checked ~ label {
            color: #fbbf24;
        }
    </style>
</x-app-layout> 