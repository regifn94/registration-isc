document.addEventListener('DOMContentLoaded', function() {
    // Handle member status change
    const memberRadios = document.querySelectorAll('input[name="member_status"]');
    const nonMemberFeeDiv = document.getElementById('nonMemberFee');
    const memberFeeDiv = document.getElementById('memberFee');
    
    memberRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'non_member') {
                nonMemberFeeDiv.style.display = 'block';
                memberFeeDiv.style.display = 'none';
            } else {
                nonMemberFeeDiv.style.display = 'none';
                memberFeeDiv.style.display = 'block';
            }
        });
    });

    // Handle airport pickup/dropoff toggles
    const pickupRadios = document.querySelectorAll('.pickup-radio');
    const dropoffRadios = document.querySelectorAll('.dropoff-radio');
    const tourRadios = document.querySelectorAll('.tour-radio');
    
    pickupRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('pickupDetails').style.display = 
                this.value === 'yes' ? 'block' : 'none';
            document.getElementById('noPickupDetails').style.display = 
                this.value === 'yes' ? 'none' : 'block';
        });
    });
    
    dropoffRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('dropoffDetails').style.display = 
                this.value === 'yes' ? 'block' : 'none';
            document.getElementById('noDropoffDetails').style.display = 
                this.value === 'yes' ? 'none' : 'block';
        });
    });
    
    tourRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('tourDetails').style.display = 
                this.value === 'yes' ? 'block' : 'none';
        });
    });

    // Form submission
    const registrationForm = document.getElementById('registrationForm');
    const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    
    registrationForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('process_registration.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 
                data.success ? 'Registration Successful' : 'Registration Failed';
            document.getElementById('modalMessage').innerHTML = 
                data.message + (data.success ? '<p>You will receive a confirmation email shortly.</p>' : '');
            messageModal.show();
            
            if (data.success) {
                registrationForm.reset();
                // Reset all toggles
                document.getElementById('nonMemberFee').style.display = 'none';
                document.getElementById('memberFee').style.display = 'block';
                document.getElementById('pickupDetails').style.display = 'none';
                document.getElementById('noPickupDetails').style.display = 'block';
                document.getElementById('dropoffDetails').style.display = 'none';
                document.getElementById('noDropoffDetails').style.display = 'block';
                document.getElementById('tourDetails').style.display = 'none';
            }
        })
        .catch(error => {
            document.getElementById('modalTitle').textContent = 'Error';
            document.getElementById('modalMessage').textContent = 
                'An error occurred while processing your registration. Please try again.';
            messageModal.show();
            console.error('Error:', error);
        });
    });
});