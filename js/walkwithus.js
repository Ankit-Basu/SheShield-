document.addEventListener('DOMContentLoaded', function() {
    const requestForm = document.getElementById('requestWalkForm');
    const loadingAnimation = document.getElementById('loadingAnimation');
    const escortDetails = document.getElementById('escortDetails');
    const activeWalk = document.getElementById('activeWalk');

    // Function to smoothly transition between cards
    function transitionToCard(showCard, hideCard = null) {
        if (hideCard) {
            hideCard.classList.remove('show');
            setTimeout(() => {
                hideCard.classList.add('hidden');
                showTransitionCard();
            }, 300);
        } else {
            showTransitionCard();
        }

        function showTransitionCard() {
            showCard.classList.remove('hidden');
            showCard.offsetHeight;
            showCard.classList.add('show');
            showCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Check for active walk first
    const activeWalkData = localStorage.getItem('activeWalk');
    if (activeWalkData) {
        showActiveWalk(JSON.parse(activeWalkData));
    } else {
        const savedEscortDetails = localStorage.getItem('escortDetails');
        if (savedEscortDetails) {
            displayEscortDetails(JSON.parse(savedEscortDetails));
        }
    }

    requestForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const currentLocation = {
            name: document.getElementById('pickupLocation').value,
            lat: document.getElementById('pickupLocation').dataset.lat || '31.2533',
            lng: document.getElementById('pickupLocation').dataset.lng || '75.7050'
        };
        
        const destination = {
            name: document.getElementById('destination').value,
            lat: document.getElementById('destination').dataset.lat || '31.2545',
            lng: document.getElementById('destination').dataset.lng || '75.7035'
        };

        loadingAnimation.classList.remove('hidden');
        requestAnimationFrame(() => loadingAnimation.style.opacity = '1');

        try {
            // Get preferred time from form
            const preferredTime = document.getElementById('preferredTime').value;
            
            // Send data as application/json instead of form-data
            const response = await fetch('get_escort.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    location: currentLocation.name,
                    destination: destination.name,
                    preferredTime: preferredTime
                })
            });
            
            const data = await response.json();
            
            loadingAnimation.style.opacity = '0';
            setTimeout(() => loadingAnimation.classList.add('hidden'), 300);
            
            if (data.success) {
                data.route = {
                    pickup: currentLocation,
                    destination: destination
                };
                
                localStorage.setItem('escortDetails', JSON.stringify(data));
                displayEscortDetails(data);

                // Show email notification status with SweetAlert2
                Swal.fire({
                    title: data.emailSent ? 'Escort Notified' : 'Notification Status',
                    text: data.emailMessage || (data.emailSent ? 
                        'The escort has been notified via email.' : 
                        'Could not send email notification to escort.'),
                    icon: data.emailSent ? 'success' : 'warning',
                    background: 'rgba(26, 26, 46, 0.95)',
                    color: '#fff',
                    customClass: {
                        confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:from-[#3A1859] hover:to-[#C55C66]'
                    },
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: 'No Escorts Available',
                    text: data.message || 'No escorts are available at the moment. Please try again later.',
                    icon: 'info',
                    background: 'rgba(26, 26, 46, 0.95)',
                    color: '#fff',
                    customClass: {
                        confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:from-[#3A1859] hover:to-[#C55C66]'
                    }
                });
            }
        } catch (error) {
            console.error('Error:', error);
            loadingAnimation.style.opacity = '0';
            setTimeout(() => loadingAnimation.classList.add('hidden'), 300);
            
            Swal.fire({
                title: 'Error',
                text: 'Failed to find an escort. Please try again.',
                icon: 'error',
                background: 'rgba(26, 26, 46, 0.95)',
                color: '#fff',
                customClass: {
                    confirmButton: 'bg-gradient-to-r from-purple-700 to-pink-500 hover:from-purple-800 hover:to-pink-600'
                }
            });
        }
    });

    // Function to display escort details
    function displayEscortDetails(data) {
        const escort = data.escort;
        const route = data.route;

        // Calculate distance and ETA
        const R = 6371; // Earth's radius in km
        const dLat = (route.destination.lat - route.pickup.lat) * Math.PI / 180;
        const dLon = (route.destination.lng - route.pickup.lng) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                 Math.cos(route.pickup.lat * Math.PI / 180) * Math.cos(route.destination.lat * Math.PI / 180) * 
                 Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        const distance = R * c;
        const walkingSpeed = 5; // km/h
        const eta = Math.round((distance / walkingSpeed) * 60); // minutes

        // Update escort details
        document.getElementById('escortImage').src = escort.profilePic;
        document.getElementById('escortName').textContent = escort.name;
        document.getElementById('escortId').textContent = `ID: ${escort.id}`;
        document.getElementById('escortRating').innerHTML = `${'★'.repeat(Math.round(escort.rating))} <span class="text-gray-400">(${escort.rating})</span>`;
        document.getElementById('escortCompletedWalks').textContent = `${escort.completedWalks} walks completed`;
        document.getElementById('walkEta').textContent = `${eta} minutes`;
        document.getElementById('walkDistance').textContent = `${distance.toFixed(1)} km`;
        document.getElementById('walkRoute').textContent = `${route.pickup.name} → ${route.destination.name}`;

        // Transition to escort details
        transitionToCard(escortDetails, activeWalk);
    }

    // Function to show active walk interface
    function showActiveWalk(data) {
        const escort = data.escort;
        const route = data.route;
        const startTime = new Date(data.startTime);

        // Update active walk details
        document.getElementById('activeEscortImage').src = escort.profilePic;
        document.getElementById('activeEscortName').textContent = escort.name;
        document.getElementById('activeEscortId').textContent = `ID: ${escort.id}`;
        document.getElementById('activeCurrentLocation').textContent = route.pickup.name;
        document.getElementById('activeDestination').textContent = route.destination.name;
        document.getElementById('activeStartTime').textContent = startTime.toLocaleTimeString();
        document.getElementById('activeDistance').textContent = `${data.distance.toFixed(1)} km`;
        document.getElementById('activeEta').textContent = `${data.eta} minutes`;

        // Transition to active walk
        transitionToCard(activeWalk, escortDetails);
    }

    // Handle start walk button
    document.getElementById('startWalk').addEventListener('click', function() {
        const savedData = JSON.parse(localStorage.getItem('escortDetails'));
        if (!savedData) return;

        Swal.fire({
            title: 'Start Walk',
            html: `
                <p class="mb-4">Your escort <strong>${savedData.escort.name}</strong> will be notified.</p>
                <p class="text-sm text-gray-300">Please ensure you:</p>
                <ul class="text-left text-sm text-gray-300 mt-2">
                    <li>• Verify escort's ID before starting</li>
                    <li>• Stay in well-lit areas</li>
                    <li>• Keep your phone charged</li>
                </ul>
            `,
            icon: 'info',
            showCancelButton: true,
            customClass: {
                confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
            },
            cancelButtonColor: '#4A5568',
            confirmButtonText: 'Start Walk',
            background: 'rgba(26, 26, 46, 0.95)',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create active walk data
                const activeData = {
                    ...savedData,
                    startTime: new Date().toISOString(),
                    distance: parseFloat(document.getElementById('walkDistance').textContent),
                    eta: parseInt(document.getElementById('walkEta').textContent)
                };

                // Show active walk interface first
                showActiveWalk(activeData);

                // Then save to localStorage and show success message
                localStorage.setItem('activeWalk', JSON.stringify(activeData));
                localStorage.removeItem('escortDetails');

                Swal.fire({
                    title: 'Walk Started!',
                    text: 'Your escort has been notified and is waiting at the pickup location.',
                    icon: 'success',
                    background: 'rgba(26, 26, 46, 0.95)',
                    color: '#fff',
                    customClass: {
                        confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
                    }
                });
            }
        });
    });

    // Handle end walk button
    document.getElementById('endWalk').addEventListener('click', function() {
        Swal.fire({
            title: 'End Walk?',
            text: 'Are you sure you want to end this walk?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
                confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
            },
            cancelButtonColor: '#4A5568',
            confirmButtonText: 'Yes, end walk',
            background: 'rgba(26, 26, 46, 0.95)',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                // Clear active walk data
                localStorage.removeItem('activeWalk');
                
                // Hide active walk with fade out
                activeWalk.style.opacity = '0';
                activeWalk.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    activeWalk.classList.add('hidden');
                    requestForm.reset();
                }, 300);
                
                // Show rating dialog
                Swal.fire({
                    title: 'Rate Your Experience',
                    html: `
                        <div class="text-center">
                            <p class="mb-4">How was your walk with ${document.getElementById('activeEscortName').textContent}?</p>
                            <div class="text-2xl text-yellow-400 space-x-2">
                                <i class="fas fa-star cursor-pointer hover:scale-110 transition-transform"></i>
                                <i class="fas fa-star cursor-pointer hover:scale-110 transition-transform"></i>
                                <i class="fas fa-star cursor-pointer hover:scale-110 transition-transform"></i>
                                <i class="fas fa-star cursor-pointer hover:scale-110 transition-transform"></i>
                                <i class="fas fa-star cursor-pointer hover:scale-110 transition-transform"></i>
                            </div>
                        </div>
                    `,
                    background: 'rgba(26, 26, 46, 0.95)',
                    color: '#fff',
                    customClass: {
                        confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
                    },
                    confirmButtonText: 'Submit Rating'
                });

                // Scroll back to request form smoothly
                requestForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    // Handle emergency button
    document.getElementById('emergencyButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Emergency Alert',
            html: `
                <div class="text-center">
                    <p class="mb-4">This will alert campus security and your emergency contacts.</p>
                    <p class="text-red-500">Use only in case of emergency!</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            customClass: {
                confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
            },
            cancelButtonColor: '#4A5568',
            confirmButtonText: 'Send Alert',
            background: 'rgba(26, 26, 46, 0.95)',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Alert Sent',
                    text: 'Emergency services have been notified and are on their way.',
                    icon: 'success',
                    background: 'rgba(26, 26, 46, 0.95)',
                    color: '#fff',
                    customClass: {
                        confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
                    }
                });
            }
        });
    });

    // Handle cancel walk
    document.getElementById('cancelWalk').addEventListener('click', function() {
        Swal.fire({
            title: 'Cancel Walk?',
            text: 'Are you sure you want to cancel this walk request?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
                confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
            },
            cancelButtonColor: '#4A5568',
            confirmButtonText: 'Yes, cancel',
            background: 'rgba(26, 26, 46, 0.95)',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                // Clear saved escort details
                localStorage.removeItem('escortDetails');
                
                // Hide escort details with fade out
                escortDetails.style.opacity = '0';
                escortDetails.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    escortDetails.classList.add('hidden');
                    requestForm.reset();
                }, 300);
                
                // Scroll back to request form smoothly
                requestForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    // This event listener is removed as it's targeting a non-existent element 'volunteer-form'
    // The volunteer form submission is now handled by the event listener for 'volunteerForm' below

    // Handle volunteer form submission
    const volunteerForm = document.getElementById('volunteerForm');
    volunteerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Show loading state
        Swal.fire({
            title: 'Submitting application...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            background: 'rgba(26, 26, 46, 0.95)',
            color: '#fff'
        });

        // Get form data - using more specific selectors to avoid null references
        const datetimeInputs = this.querySelectorAll('input[type="datetime-local"]');
        const availableFrom = datetimeInputs[0] ? datetimeInputs[0].value : '';
        const availableTo = datetimeInputs[1] ? datetimeInputs[1].value : '';
        
        // Get selected preferred areas
        const preferredAreasSelect = this.querySelector('select');
        const preferredAreas = preferredAreasSelect ? Array.from(preferredAreasSelect.selectedOptions).map(option => option.text) : [];
        
        try {
            const response = await fetch('register_volunteer_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    available_from: availableFrom,
                    available_to: availableTo,
                    preferred_areas: preferredAreas
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                Swal.fire({
                    title: 'Thank You!',
                    text: 'Your volunteer application has been submitted. We will review it and get back to you soon.',
                    icon: 'success',
                    background: 'rgba(26, 26, 46, 0.95)',
                    color: '#fff',
                    customClass: {
                        confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
                    }
                });
                
                volunteerForm.reset();
            } else {
                throw new Error(result.message || 'Failed to submit application');
            }
        } catch (error) {
            console.error('Error submitting volunteer application:', error);
            
            Swal.fire({
                title: 'Error',
                text: error.message || 'Failed to submit your application. Please try again.',
                icon: 'error',
                background: 'rgba(26, 26, 46, 0.95)',
                color: '#fff',
                customClass: {
                    confirmButton: 'bg-gradient-to-r from-[#4A1E73] to-[#D76D77] hover:shadow-lg transform hover:scale-[1.02]'
                }
            });
        }
    });
});