<x-app-layout>
    <!-- Slider Start -->
    <section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-xl-7">
                    <div class="block">
                        <div class="divider mb-3"></div>
                        <span class="text-uppercase text-sm letter-spacing">Total Health care solution</span>
                        <h1 class="mb-3 mt-3">Your most trusted health partner</h1>
                        <p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p>

                        <form class="appointment-form" action="{{ route('doctors') }}" method="GET">
                            <div class="appointment-container">
                                <div class="select-group">
                                    <select name="governorate" 
                                            class="appointment-select" 
                                            id="governorate"
                                            aria-label="Select Governorate"
                                            title="Select Governorate">
                                        <option value="" disabled selected>Select Governorate</option>
                                        @foreach(['Ajloun', 'Amman', 'Aqaba', 'Balqa', 'Irbid', 'Jerash', 'Karak', 'Maan', 'Madaba', 'Mafraq', 'Tafilah', 'Zarqa'] as $gov)
                                            <option value="{{ strtolower($gov) }}">{{ $gov }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="select-group">
                                    <select name="specializations[]" 
                                            class="appointment-select" 
                                            id="specialty"
                                            aria-label="Select Specialty"
                                            title="Select Specialty">
                                        <option value="" disabled selected>Select Specialty</option>
                                        @foreach($specializations as $specialty)
                                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="select-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Search doctor name" 
                                           value="{{ request('search') }}"
                                           aria-label="Search doctor name"
                                           title="Search doctor name"
                                           style="height: 55px; border-radius: 25px; border: 1px solid #e9ecef;">
                                </div>

                                <div class="btn-container">
                                    <button type="submit" 
                                            class="btn btn-main-2 btn-icon btn-round-full"
                                            aria-label="Search for doctors"
                                            title="Search for doctors">
                                        Search <i class="icofont-simple-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Doctors Section -->
    <section class="recommended-doctors">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row justify-center">
                        <div class="col-lg-7 text-center">
                            <h2 class="section-title">Featured Doctors</h2>
                            <div class="divider mx-auto my-4"></div>
                        </div>
                    </div>

                    <div class="splide" id="doctors-slider">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach($featuredDoctors as $doctor)
                                <li class="splide__slide">
                                    <div class="doctor-card">
                                        <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('images/team/default.jpg') }}"
                                             alt="{{ $doctor->name }}" class="doctor-image">
                                        <div class="doctor-info">
                                            <h3 class="doctor-name">Dr. {{ $doctor->name }}</h3>
                                            <span class="doctor-specialty">{{ $doctor->specialization->name ?? 'General' }}</span>
                                            <div class="btn-container">
                                                <a href="{{ route('doctor', $doctor->id) }}" class="btn btn-main">
                                                    Book <i class="icofont-simple-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="steps-section pt-5 pb-5">
        <div class="container">
            <div class="row justify-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">How To Book An Appointment</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Simple steps to get the care you need</p>
                </div>
            </div>
            <div class="row justify-center gap-5">
                <div class="col-lg-3 col-md-6">
                    <div class="step-card text-center p-4 bg-white rounded shadow-sm">
                        <div class="step-icon mb-4 bg-soft-primary rounded-circle d-inline-flex align-items-center justify-content-center">
                            <i class="icofont-doctor-alt text-primary" style="font-size: 2rem;"></i>
                            <span class="step-number bg-primary text-white rounded-circle">1</span>
                        </div>
                        <h4 class="text-dark">Find Your Doctor</h4>
                        <p class="text-muted">Search by specialty, location, or doctor name</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card text-center p-4 bg-white rounded shadow-sm">
                        <div class="step-icon mb-4 bg-soft-primary rounded-circle d-inline-flex align-items-center justify-content-center">
                            <i class="icofont-ui-calendar text-primary" style="font-size: 2rem;"></i>
                            <span class="step-number bg-primary text-white rounded-circle">2</span>
                        </div>
                        <h4 class="text-dark">Select Time Slot</h4>
                        <p class="text-muted">Choose from available dates and times</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card text-center p-4 bg-white rounded shadow-sm">
                        <div class="step-icon mb-4 bg-soft-primary rounded-circle d-inline-flex align-items-center justify-content-center">
                            <i class="icofont-check-alt text-primary" style="font-size: 2rem;"></i>
                            <span class="step-number bg-primary text-white rounded-circle">3</span>
                        </div>
                        <h4 class="text-dark">Confirm Booking</h4>
                        <p class="text-muted">Receive instant confirmation via SMS/Email</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Specialties Grid Section -->
    <section class="specialties-section pt-5 pb-5 bg-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">Our Medical Specialties</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Book appointments across 10+ medical specialties</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-heart-beat-alt text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Cardiology</h5>
                        <p class="text-muted mb-0">Heart health specialists</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-brain-alt text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Neurology</h5>
                        <p class="text-muted mb-0">Brain & nervous system</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-baby text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Pediatrics</h5>
                        <p class="text-muted mb-0">Child healthcare</p>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="#" class="specialty-card d-block p-4 bg-white rounded text-center h-100">
                        <i class="icofont-tooth text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="text-dark">Dentistry</h5>
                        <p class="text-muted mb-0">Oral health care</p>
                    </a>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-main">View All Specialties</a>
            </div>
        </div>
    </section>

    <!-- Stats Counter Section -->
    <section class="stats-section pt-5 pb-5 bg-primary-darker text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stat-card text-center">
                        <i class="icofont-doctor mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2"><span class="counter">{{ $stats['doctors_count'] }}</span>+</h3>
                        <p class="mb-0">Qualified Doctors</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stat-card text-center">
                        <i class="icofont-google-map mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2"><span class="counter">12</span></h3>
                        <p class="mb-0">Governorates Covered</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-sm-0">
                    <div class="stat-card text-center">
                        <i class="icofont-laughing mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2"><span class="counter">{{ $stats['happy_patients'] }}</span>+</h3>
                        <p class="mb-0">Happy Patients</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat-card text-center">
                        <i class="icofont-clock-time mb-3" style="font-size: 3rem;"></i>
                        <h3 class="mt-2" style="color: #e12454;"><span class="counter">24</span>/7</h3>
                        <p class="mb-0">Support Available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section pt-5 pb-5 bg-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">What Patients Say</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Hear from our satisfied patients</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="splide" id="testimonials-slider">
                        <div class="splide__track p-1">
                            <ul class="splide__list">
                                <!-- Testimonial 1 -->
                                <li class="splide__slide">
                                    <div class="testimonial-item bg-white p-4 rounded shadow-sm h-100">
                                        <div class="testimonial-content mb-4">
                                            <i class="icofont-quote-left text-primary mb-3" style="font-size: 1.5rem;"></i>
                                            <p class="font-italic">"Found the perfect cardiologist through this platform. The booking process was seamless and the doctor was excellent."</p>
                                        </div>
                                        <div class="patient-info d-flex align-items-center">
                                            <img src="/images/testimonial-1.jpg" alt="Patient" class="rounded-circle me-3" width="50">
                                            <div>
                                                <h5 class="mb-1">Mohammad Ali</h5>
                                                <span class="text-muted small">Amman</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- Additional testimonials (omitted for brevity)... -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Emergency CTA Section -->
    <section class="emergency-section pt-5 pb-5 bg-primary-darker text-white">
        <div class="container">
            <div class="emergency-cta p-4 rounded">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <h3 class="mb-2">Need Emergency Care?</h3>
                        <p class="mb-0">24/7 emergency appointment availability with our network of hospitals</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="tel:+962790000000" class="btn btn-white btn-round-full">
                            <i class="icofont-phone me-2"></i> Call Now: +962 79 000 0000
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section pt-5 pb-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <h2 class="section-title">Frequently Asked Questions</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p class="text-muted">Find answers to common questions about our services</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">How do I book an appointment?</h5>
                        <p class="text-muted">Use our search tool to find doctors by specialty or location, select your preferred time slot, and complete the booking form.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">Can I reschedule my appointment?</h5>
                        <p class="text-muted">Yes, you can reschedule up to 24 hours before your appointment time through the link in your confirmation email.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">What payment methods do you accept?</h5>
                        <p class="text-muted">We accept cash payments at the clinic. Some clinics may accept credit cards - this will be specified during booking.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="faq-item bg-gray p-4 rounded">
                        <h5 class="text-dark mb-3">Is my personal information secure?</h5>
                        <p class="text-muted">Yes, we use industry-standard encryption to protect all patient data and comply with medical privacy regulations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="final-cta pt-5 pb-5 bg-primary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <h3 class="text-white mb-2">Ready to book your appointment?</h3>
                    <p class="text-white mb-0">Find the right specialist for your healthcare needs today</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#search-doctors" class="btn btn-main border btn-round-full btn-lg">
                        Find a Doctor Now <i class="icofont-simple-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Chatbot -->
    <div class="chatbot-container fixed bottom-4 right-4 z-50">
        <!-- Chat Button -->
        <button id="chatbot-toggle" 
                class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-colors"
                aria-label="Open chat with medical assistant"
                title="Open chat with medical assistant">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </button>

        <!-- Chat Window (initially hidden) -->
        <div id="chatbot-window" class="hidden w-96 bg-white rounded-lg shadow-lg transform transition-all duration-300 ease-in-out">
            <div class="chatbot-header bg-blue-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                <h3 class="text-xl font-semibold">Medical Assistant</h3>
                <button class="close-chatbot text-white text-2xl hover:text-gray-200"
                        aria-label="Close chat window"
                        title="Close chat window">×</button>
            </div>
            <div class="chatbot-messages p-4 h-96 overflow-y-auto bg-gray-50">
                <div class="message bot bg-white p-3 rounded-lg mb-3 shadow-sm">
                    Hello! I'm your medical assistant. Please describe your symptoms and I'll help you find the right specialist.
                </div>
            </div>
            <div class="chatbot-input p-4 border-t bg-white">
                <form id="chatbot-form" class="flex gap-2">
                    @csrf
                    <input type="text" 
                           id="symptoms-input" 
                           class="flex-1 border-2 border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none" 
                           placeholder="Describe your symptoms..."
                           aria-label="Describe your symptoms"
                           title="Describe your symptoms">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 rounded-lg hover:bg-blue-700 transition-colors"
                            aria-label="Send message"
                            title="Send message">Send</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Doctors slider
            new Splide('#doctors-slider', {
                type: 'loop',
                perPage: 4,
                perMove: 2,
                autoplay: true,
                interval: 3000,
                gap: '20px',
                padding: '50px',
                pagination: false,
                breakpoints: {
                    1200: { perPage: 3, gap: '50px', padding: '40px' },
                    1024: { perPage: 2, gap: '40px', padding: '30px' },
                    768: { perPage: 2, perMove: 1, gap: '30px', padding: '20px' },
                    568: { perPage: 1, perMove: 1, gap: '40px', padding: '80px' },
                    400: { perPage: 1, perMove: 1, gap: '40px', padding: '60px' }
                }
            }).mount();

            // Testimonials slider
            new Splide('#testimonials-slider', {
                type: 'loop',
                perPage: 3,
                perMove: 1,
                autoplay: true,
                interval: 3000,
                gap: '20px',
                padding: '50px',
                pagination: false,
                breakpoints: {
                    1200: { perPage: 3, gap: '20px', padding: '40px' },
                    1024: { perPage: 2, gap: '20px', padding: '30px' },
                    768: { perPage: 1, gap: '20px', padding: '20px' },
                    568: { perPage: 1, gap: '20px', padding: '10px' },
                    400: { perPage: 1, gap: '20px', padding: '10px' }
                }
            }).mount();

            // Counter animation
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });

            const chatbotForm = document.getElementById('chatbot-form');
            const symptomsInput = document.getElementById('symptoms-input');
            const messagesContainer = document.querySelector('.chatbot-messages');
            const toggleButton = document.getElementById('chatbot-toggle');
            const closeButton = document.querySelector('.close-chatbot');
            const chatbotWindow = document.getElementById('chatbot-window');
            
            // Toggle chatbot window
            toggleButton.addEventListener('click', function() {
                chatbotWindow.classList.remove('hidden');
                chatbotWindow.classList.add('animate-slide-in');
                toggleButton.classList.add('hidden');
            });
            
            closeButton.addEventListener('click', function() {
                chatbotWindow.classList.add('hidden');
                chatbotWindow.classList.remove('animate-slide-in');
                toggleButton.classList.remove('hidden');
            });
            
            chatbotForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const input = document.getElementById('symptoms-input');
                const message = input.value.trim();
                
                if (message) {
                    // Add user message to chat
                    addMessage(message, 'user');
                    input.value = '';
                    
                    // Send to server
                    fetch('/chatbot/recommend', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ symptoms: message })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.isDrugInfo) {
                            // Display drug information with proper formatting
                            addMessage(data.message, 'bot', true);
                        } else {
                            // Display message with links if present
                            addMessage(data.message, 'bot', data.hasLinks);
                            
                            // Add buttons for each recommended specialization
                            if (data.specializations && data.specializations.length > 0) {
                                const buttonsContainer = document.createElement('div');
                                buttonsContainer.className = 'specialization-buttons mt-3';
                                
                                data.specializations.forEach(specialization => {
                                    const specializationId = data.specializationIds[specialization];
                                    if (specializationId) {
                                        const button = document.createElement('button');
                                        button.className = 'btn btn-sm btn-primary me-2 mb-2';
                                        button.textContent = `Find ${specialization}`;
                                        button.onclick = function() {
                                            // Redirect to doctors page with selected specializations
                                            const url = new URL('/doctors', window.location.origin);
                                            url.searchParams.append('specializations[]', specializationId);
                                            window.location.href = url.toString();
                                        };
                                        buttonsContainer.appendChild(button);
                                    }
                                });
                                
                                const messageDiv = document.createElement('div');
                                messageDiv.className = 'message bot-message';
                                messageDiv.appendChild(buttonsContainer);
                                document.querySelector('.chatbot-messages').appendChild(messageDiv);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                    });
                }
            });
            
            function addMessage(text, sender, isHTML = false) {
                const chatMessages = document.querySelector('.chatbot-messages');
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}-message`;
                
                if (isHTML) {
                    messageDiv.innerHTML = text;
                } else {
                    messageDiv.textContent = text;
                }
                
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Add keyboard support for the chat window
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !chatbotWindow.classList.contains('hidden')) {
                    closeButton.click();
                }
            });

            // Focus the input when the chat window opens
            toggleButton.addEventListener('click', function() {
                setTimeout(() => {
                    symptomsInput.focus();
                }, 300);
            });
        });
    </script>

    <style>
    .animate-slide-in {
        animation: slideIn 0.3s ease-out forwards;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    </style>
</x-app-layout>
