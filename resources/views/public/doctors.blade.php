<x-app-layout>
    <!-- Doctors Listing Section -->
    <section class="pt-4 pb-5 doctors-section" style="background-color: #f8f9fa;">
        <div class="container">
            <!-- Search Section -->
            <div class="search-section mb-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="search-card p-3 p-md-4 shadow-sm rounded-3" style="background: white; border-top: 3px solid #e12454;">
                            <h3 class="text-center mb-3" style="color: #223a66; font-weight: 600; font-size: 1.5rem;">Find the Right Specialist</h3>
                            <form class="appointment-form" action="{{ route('doctors') }}" method="GET">
                                <div class="row g-2 g-md-3 align-items-center">
                                    <div class="col-12 col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fas fa-search text-muted"></i>
                                            </span>
                                            <input type="text" name="search" class="form-control border-start-0 shadow-none py-2" placeholder="Doctor name or specialty" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fas fa-map-marker-alt text-muted"></i>
                                            </span>
                                            <select name="governorate" class="form-select border-start-0 shadow-none py-2">
                                                <option value="">All Locations</option>
                                                <option value="Amman" {{ request('governorate') == 'Amman' ? 'selected' : '' }}>Amman</option>
                                                <option value="Irbid" {{ request('governorate') == 'Irbid' ? 'selected' : '' }}>Irbid</option>
                                                <option value="Ajloun" {{ request('governorate') == 'Ajloun' ? 'selected' : '' }}>Ajloun</option>
                                                <option value="Aqaba" {{ request('governorate') == 'Aqaba' ? 'selected' : '' }}>Aqaba</option>
                                                <option value="Balqa" {{ request('governorate') == 'Balqa' ? 'selected' : '' }}>Balqa</option>
                                                <option value="Zarqa" {{ request('governorate') == 'Zarqa' ? 'selected' : '' }}>Zarqa</option>
                                                <option value="Mafraq" {{ request('governorate') == 'Mafraq' ? 'selected' : '' }}>Mafraq</option>
                                                <option value="Maan" {{ request('governorate') == 'Maan' ? 'selected' : '' }}>Maan</option>
                                                <option value="Tafilah" {{ request('governorate') == 'Tafilah' ? 'selected' : '' }}>Tafilah</option>
                                                <option value="Karak" {{ request('governorate') == 'Karak' ? 'selected' : '' }}>Karak</option>
                                                <option value="Jerash" {{ request('governorate') == 'Jerash' ? 'selected' : '' }}>Jerash</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="submit" class="btn btn-main w-100 py-2">
                                            <i class="fas fa-search me-1"></i> Search
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Mobile Specialty Filter Dropdown (visible only on small screens) -->
                                <div class="col-12 mt-2 d-block d-lg-none">
                                    <div class="dropdown specialty-dropdown">
                                        <button class="btn btn-light dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center" type="button" id="specialtyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div>
                                                <i class="fas fa-stethoscope me-2 text-secondary"></i>
                                                <span class="filter-placeholder">Select Specialties</span>
                                            </div>
                                            <span class="badge rounded-pill bg-primary specialty-count" style="display: none;">0</span>
                                        </button>
                                        <div class="dropdown-menu specialty-menu p-3 w-100" aria-labelledby="specialtyDropdown">
                                            <div class="mb-2 pb-2 border-bottom">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0">Select Specialties</h6>
                                                    <button type="button" class="btn btn-sm btn-link clear-all p-0">Clear all</button>
                                                </div>
                                            </div>
                                            <div class="specialty-list" style="max-height: 250px; overflow-y: auto;">
                                                @foreach($specializations as $specialization)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input specialty-checkbox" type="checkbox"
                                                        name="specializations[]"
                                                        value="{{ $specialization->id }}"
                                                        id="dropdown-spec-{{ $specialization->id }}"
                                                        @if(request()->has('specializations') && in_array($specialization->id, request('specializations'))) checked @endif>
                                                    <label class="form-check-label" for="dropdown-spec-{{ $specialization->id }}">
                                                        {{ $specialization->name }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="mt-3 d-flex justify-content-between">
                                                <button type="button" class="btn btn-sm btn-outline-secondary cancel-btn" data-bs-toggle="dropdown">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-main apply-filters">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Filters Column (Desktop) -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="filter-section mb-4 p-3 bg-white rounded-3 shadow-sm sticky-top" style="top: 20px;">
                        <h4 class="mb-3 fw-bold" style="color: #223a66; font-size: 1.2rem;">Filters</h4>
                        <div class="divider mb-3"></div>

                        <!-- Specialty Filter -->
                        <form action="{{ route('doctors') }}" method="GET" id="filter-form">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="governorate" value="{{ request('governorate') }}">

                            <div class="filter-group mb-3">
                                <h5 class="mb-2 fw-semibold" style="color: #223a66; font-size: 1rem;">
                                    <i class="fas fa-stethoscope me-1"></i> Specialty
                                </h5>
                                <div class="filter-options" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($specializations as $specialization)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            name="specializations[]"
                                            value="{{ $specialization->id }}"
                                            id="spec-{{ $specialization->id }}"
                                            @if(request()->has('specializations') && in_array($specialization->id, request('specializations'))) checked @endif>
                                        <label class="form-check-label" for="spec-{{ $specialization->id }}" style="font-size: 0.9rem;">
                                            {{ $specialization->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main w-100 py-2" style="font-size: 0.9rem;">
                                <i class="fas fa-filter me-1"></i> Apply Filters
                            </button>
                        </form>
                    </div>

                    <!-- Quick Stats -->
                    <div class="quick-stats p-3 bg-white rounded-3 shadow-sm mb-4">
                        <h5 class="mb-2 fw-semibold" style="color: #223a66; font-size: 1rem;">
                            <i class="fas fa-chart-pie me-1"></i> Quick Stats
                        </h5>
                        <div class="stats-item d-flex justify-content-between mb-1" style="font-size: 0.9rem;">
                            <span class="text-muted">Total Doctors</span>
                            <span class="fw-bold">{{ $totalDoctors }}</span>
                        </div>
                        <div class="stats-item d-flex justify-content-between mb-1" style="font-size: 0.9rem;">
                            <span class="text-muted">Specialties</span>
                            <span class="fw-bold">{{ $specializations->count() }}</span>
                        </div>
                        <div class="stats-item d-flex justify-content-between" style="font-size: 0.9rem;">
                            <span class="text-muted">Locations</span>
                            <span class="fw-bold">11</span>
                        </div>
                    </div>
                </div>

                <!-- Doctors List -->
                <div class="col-12 col-lg-9">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 p-3 bg-white rounded-3 shadow-sm">
                        <h4 class="mb-2 mb-md-0 fw-bold" style="color: #223a66; font-size: 1.2rem;">
                            <i class="fas fa-user-md me-1"></i> Available Doctors
                            <span class="badge bg-main ms-2" style="font-size: 0.8rem;">{{ $doctors->total() }}</span>
                        </h4>
                        <div class="d-flex align-items-center mt-2 mt-md-0">
                            <span class="me-2 text-muted" style="font-size: 0.9rem;">Sort:</span>
                            <select class="form-select shadow-sm border-0 py-1" id="sort-select" name="sort" style="width: 160px; font-size: 0.9rem;">
                                <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experienced</option>
                            </select>
                        </div>
                    </div>

                    <!-- Active Filters (Mobile & Desktop) -->
                    @if(request()->has('specializations') || request('specialty') || request('governorate'))
                    <div class="active-filters mb-3 p-2 bg-white rounded-3 shadow-sm">
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="me-2 text-muted" style="font-size: 0.9rem;"><i class="fas fa-filter me-1"></i> Active:</span>
                            
                            @if(request('specialty'))
                            <div class="filter-badge bg-light me-2 mb-1 px-2 py-1 rounded-pill" style="font-size: 0.8rem;">
                                <span>Specialty: {{ $specializations->firstWhere('id', request('specialty'))->name }}</span>
                                <a href="{{ request()->fullUrlWithQuery(['specialty' => null]) }}" class="ms-1 text-secondary text-decoration-none">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            </div>
                            @endif
                            
                            @if(request('governorate'))
                            <div class="filter-badge bg-light me-2 mb-1 px-2 py-1 rounded-pill" style="font-size: 0.8rem;">
                                <span>Location: {{ request('governorate') }}</span>
                                <a href="{{ request()->fullUrlWithQuery(['governorate' => null]) }}" class="ms-1 text-secondary text-decoration-none">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            </div>
                            @endif
                            
                            @if(request()->has('specializations'))
                                @foreach(request('specializations') as $specId)
                                <div class="filter-badge bg-light me-2 mb-1 px-2 py-1 rounded-pill" style="font-size: 0.8rem;">
                                    <span>{{ $specializations->firstWhere('id', $specId)->name }}</span>
                                    <a href="#" class="ms-1 text-secondary text-decoration-none remove-filter" data-id="{{ $specId }}">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 justify-content-center">
                        @forelse($doctors as $doctor)
                        <!-- Doctor Card -->
                        <div class="col mb-3 fade-up">
                            <div class="doctor-card h-100 bg-white rounded-3 overflow-hidden shadow-sm border-0 mx-auto" style="max-width: 300px;">
                                <div class="position-relative" style="height: 150px; overflow: hidden;">
                                    <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('images/team/default.jpg') }}"
                                         class="w-100 h-100"
                                         alt="{{ $doctor->name }}"
                                         style="object-fit: cover;">
                                    
                                </div>
                                <div class="p-3">
                                    <h5 class="mb-1 fw-bold" style="color: #223a66; font-size: 1rem;">Dr. {{ $doctor->name }}</h5>
                                    <p class="mb-2" style="color: #e12454; font-size: 0.85rem; font-weight: 500;">
                                        {{ $doctor->specialization ? $doctor->specialization->name : 'General' }}
                                    </p>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt me-1" style="color: #6c757d; font-size: 0.8rem;"></i>
                                        <small class="text-muted" style="font-size: 0.8rem;">{{ $doctor->governorate }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <i class="fas fa-briefcase me-1" style="color: #6c757d; font-size: 0.8rem;"></i>
                                            <small class="text-muted" style="font-size: 0.8rem;">{{ $doctor->experience_years ?? '5' }}y</small>
                                        </div>
                                        <div>
                                            <i class="fas fa-comments me-1" style="color: #6c757d; font-size: 0.8rem;"></i>
                                            <small class="text-muted" style="font-size: 0.8rem;">EN/AR</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('doctor', $doctor->id) }}" class="btn btn-main-2 btn-sm w-100 py-1" style="font-size: 0.8rem;">
                                        <i class="fas fa-calendar-alt me-1"></i> Book
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info d-flex align-items-center py-2" role="alert" style="font-size: 0.9rem;">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <h5 class="alert-heading mb-1" style="font-size: 1rem;">No doctors found</h5>
                                    <p class="mb-0">Try different search parameters</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm">
                                {{ $doctors->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle sort selection
            const sortSelect = document.getElementById('sort-select');
            if(sortSelect) {
                sortSelect.addEventListener('change', function() {
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.set('sort', this.value);
                    window.location.href = currentUrl.toString();
                });
            }
            
            // Handle removing individual specialization filters
            const removeFilterButtons = document.querySelectorAll('.remove-filter');
            removeFilterButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const specId = this.getAttribute('data-id');
                    const currentUrl = new URL(window.location);
                    
                    // Get current specializations
                    let specs = currentUrl.searchParams.getAll('specializations[]');
                    
                    // Remove the one we clicked
                    specs = specs.filter(id => id !== specId);
                    
                    // Clear all current specializations
                    currentUrl.searchParams.delete('specializations[]');
                    
                    // Add back the filtered list
                    specs.forEach(id => {
                        currentUrl.searchParams.append('specializations[]', id);
                    });
                    
                    window.location.href = currentUrl.toString();
                });
            });
            
            // Specialty dropdown functionality
            const specialtyCheckboxes = document.querySelectorAll('.specialty-checkbox');
            const specialtyPlaceholder = document.querySelector('.filter-placeholder');
            const specialtyCount = document.querySelector('.specialty-count');
            const clearAllBtn = document.querySelector('.clear-all');
            const cancelBtn = document.querySelector('.cancel-btn');
            
            // Initialize the counter display
            updateSpecialtyCounter();
            
            // Handle checkbox changes
            specialtyCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSpecialtyCounter();
                });
            });
            
            // Clear all checkboxes
            if(clearAllBtn) {
                clearAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    specialtyCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    updateSpecialtyCounter();
                });
            }
            
            // Cancel button (restore original state)
            if(cancelBtn) {
                const originalState = Array.from(specialtyCheckboxes).map(checkbox => checkbox.checked);
                
                cancelBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Restore original state
                    specialtyCheckboxes.forEach((checkbox, index) => {
                        checkbox.checked = originalState[index];
                    });
                    updateSpecialtyCounter();
                });
            }
            
            // Update counter display
            function updateSpecialtyCounter() {
                const checkedCount = document.querySelectorAll('.specialty-checkbox:checked').length;
                
                if(checkedCount > 0) {
                    specialtyPlaceholder.textContent = `${checkedCount} specialties selected`;
                    specialtyCount.textContent = checkedCount;
                    specialtyCount.style.display = 'inline-flex';
                } else {
                    specialtyPlaceholder.textContent = 'Select Specialties';
                    specialtyCount.style.display = 'none';
                }
            }
            
            // Ensure dropdown stays open when clicking inside content
            document.querySelector('.specialty-menu').addEventListener('click', function(e) {
                if(!e.target.classList.contains('cancel-btn') && 
                   !e.target.classList.contains('apply-filters')) {
                    e.stopPropagation();
                }
            });
        });
    </script>
</x-app-layout>