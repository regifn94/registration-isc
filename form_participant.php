<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Presenter Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-bottom: 50px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .payment-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .row > div {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Participant Registration</h1>

        <form id="registrationForm" action="process_registration_participant.php" method="post" enctype="multipart/form-data">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Personal Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="title" class="form-label">Title</label>
                            <select class="form-select" id="title" name="title" required>
                                <option value="">Select...</option>
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Miss.">Miss.</option>
                                <option value="Dr.">Dr.</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="fullname" class="form-label">Full Name (for Certificate)</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
                        <div class="col-md-5">
                            <label for="education_degrees" class="form-label">Education Degrees (MBA, PhD, etc.)</label>
                            <input type="text" class="form-control" id="education_degrees" name="education_degrees">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" min="18" max="99">
                        </div>
                        <div class="col-md-4">
                            <label for="shirt_size" class="form-label">Shirt Size</label>
                            <select class="form-select" id="shirt_size" name="shirt_size">
                                <option value="">Select...</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Affiliation Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="institution_name" class="form-label">Institution/University Name</label>
                            <select class="form-select" id="institution_name" name="institution_name" required>
                                <option value="">Select your institution...</option>
                                <option value="Adventist International Institute of Advanced Studies">Adventist International Institute of Advanced Studies</option>
                                <option value="Adventist University of the Philippines">Adventist University of the Philippines</option>
                                <option value="Asia-Pacific International University">Asia-Pacific International University</option>
                                <option value="Universitas Advent Indonesia">Universitas Advent Indonesia</option>
                                <option value="other">Other (please specify)</option>
                            </select>
                            <input type="text" class="form-control mt-2" id="other_institution" name="other_institution" style="display: none;" placeholder="Please specify your institution">
                            <input type="hidden" id="member_status" name="member_status" value="non_member">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="country" class="form-label">Country of Residence</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department/Division</label>
                            <input type="text" class="form-control" id="department" name="department">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="job_title" class="form-label">Job Title/Position</label>
                            <input type="text" class="form-control" id="job_title" name="job_title">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4" id="registrationFeeCard">
                <div class="card-header">
                    <h5>Registration Fee</h5>
                </div>
                <div class="card-body">
                    <div id="nonMemberFee">
                        <p>Registration Fee: $50</p>
                        <div class="mb-3">
                            <label for="registration_receipt" class="form-label">Upload Payment Receipt</label>
                            <input type="file" class="form-control" id="registration_receipt" name="registration_receipt">
                        </div>
                        <div class="payment-details">
                            <p>Payment Details:</p>
                            <div class="mb-2">
                                <label class="form-label">Account Name:</label>
                                <input type="text" class="form-control" id="reg_acc_name" name="reg_acc_name">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Account Number:</label>
                                <input type="text" class="form-control" id="reg_acc_number" name="reg_acc_number">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Bank Name:</label>
                                <input type="text" class="form-control" id="reg_bank_name" name="reg_bank_name">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Bank Address:</label>
                                <input type="text" class="form-control" id="reg_bank_address" name="reg_bank_address">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">SWIFT Code:</label>
                                <input type="text" class="form-control" id="reg_bank_swift_code" name="reg_bank_swift_code">
                            </div>
                        </div>
                    </div>
                    <div id="memberFee" style="display: none;">
                        <p><b>No registration fee for members.</b></p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Travel and Accommodation</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Do you want to be picked up at the airport?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pickup-radio" type="radio" name="airport_pickup" id="pickup_yes" value="yes">
                                    <label class="form-check-label" for="pickup_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pickup-radio" type="radio" name="airport_pickup" id="pickup_no" value="no" checked>
                                    <label class="form-check-label" for="pickup_no">No</label>
                                </div>
                            </div>
                            <div id="pickupDetails" class="mt-2" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="arrival_date" class="form-label">Arrival Date/Time</label>
                                        <input type="datetime-local" class="form-control" id="arrival_date" name="arrival_date">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="flight_number_arrival" class="form-label">Flight Number to Manado</label>
                                        <input type="text" class="form-control" id="flight_number_arrival" name="flight_number_arrival">
                                    </div>
                                </div>
                            </div>
                            <div id="noPickupDetails" class="mt-2">
                                <label for="on_campus_checkin" class="form-label">On-campus check-in time</label>
                                <input type="time" class="form-control" id="on_campus_checkin" name="on_campus_checkin">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Do you want to be dropped off at the airport?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input dropoff-radio" type="radio" name="airport_dropoff" id="dropoff_yes" value="yes">
                                    <label class="form-check-label" for="dropoff_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input dropoff-radio" type="radio" name="airport_dropoff" id="dropoff_no" value="no" checked>
                                    <label class="form-check-label" for="dropoff_no">No</label>
                                </div>
                            </div>
                            <div id="dropoffDetails" class="mt-2" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="departure_date" class="form-label">Departure Date/Time</label>
                                        <input type="datetime-local" class="form-control" id="departure_date" name="departure_date">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="flight_number_departure" class="form-label">Flight Number from Manado</label>
                                        <input type="text" class="form-control" id="flight_number_departure" name="flight_number_departure">
                                    </div>
                                </div>
                            </div>
                            <div id="noDropoffDetails" class="mt-2">
                                <label for="on_campus_checkout" class="form-label">On-campus check-out time</label>
                                <input type="time" class="form-control" id="on_campus_checkout" name="on_campus_checkout">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Lodging</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lodging" id="hotel" value="hotel" checked>
                                    <label class="form-check-label" for="hotel">Hotel (own cost)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lodging" id="dormitory" value="dormitory">
                                    <label class="form-check-label" for="dormitory">Dormitory (Shared rooms with bunk bed)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="family_members" class="form-label">Family members joining as participant/presenter</label>
                            <textarea class="form-control" id="family_members" name="family_members" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Post-conference Tour</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Will you join the tour?</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input tour-radio" type="radio" name="post_conference_tour" id="tour_yes" value="yes">
                                <label class="form-check-label" for="tour_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input tour-radio" type="radio" name="post_conference_tour" id="tour_no" value="no" checked>
                                <label class="form-check-label" for="tour_no">No</label>
                            </div>
                        </div>
                    </div>
                    <div id="tourDetails" style="display: none;">
                        <div class="payment-details">
                            <p>Payment Details:</p>
                            <div class="mb-2">
                                <label class="form-label">Account Name:</label>
                                <input type="text" class="form-control" id="tour_acc_name" name="tour_acc_name">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Account Number:</label>
                                <input type="text" class="form-control" id="tour_acc_number" name="tour_acc_number">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Bank Name:</label>
                                <input type="text" class="form-control" id="tour_bank_name" name="tour_bank_name">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Bank Address:</label>
                                <input type="text" class="form-control" id="tour_bank_address" name="tour_bank_address">
                            </div>
                            <div class="mb-3">
                                <label for="tour_receipt" class="form-label">Upload Tour Payment Receipt (if applicable)</label>
                                <input type="file" class="form-control" id="tour_receipt" name="tour_receipt">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Register Now</button>
            </div>
        </form>

        <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalMessage">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const institutionSelect = document.getElementById('institution_name');
            const otherInput = document.getElementById('other_institution');
            const memberStatusInput = document.getElementById('member_status');
            const registrationFeeCard = document.getElementById('registrationFeeCard');
            const nonMemberFeeDiv = document.getElementById('nonMemberFee');
            const memberFeeDiv = document.getElementById('memberFee');

            institutionSelect.addEventListener('change', function() {
                otherInput.style.display = this.value === 'other' ? 'block' : 'none';
                memberStatusInput.value = this.value === 'Adventist International Institute of Advanced Studies' || this.value === 'Adventist University of the Philippines' || this.value === 'Asia-Pacific International University' || this.value === 'Universitas Advent Indonesia' ? 'member' : 'non_member';
                registrationFeeCard.style.display = 'block';
                nonMemberFeeDiv.style.display = memberStatusInput.value === 'non_member' ? 'block' : 'none';
                memberFeeDiv.style.display = memberStatusInput.value === 'member' ? 'block' : 'none';
            });

            const pickupYes = document.getElementById('pickup_yes');
            const pickupNo = document.getElementById('pickup_no');
            const pickupDetails = document.getElementById('pickupDetails');
            const noPickupDetails = document.getElementById('noPickupDetails');

            pickupYes.addEventListener('change', function() {
                pickupDetails.style.display = this.checked ? 'block' : 'none';
                noPickupDetails.style.display = this.checked ? 'none' : 'block';
            });

            pickupNo.addEventListener('change', function() {
                pickupDetails.style.display = this.checked ? 'none' : 'block';
                noPickupDetails.style.display = this.checked ? 'block' : 'none';
            });

            const dropoffYes = document.getElementById('dropoff_yes');
            const dropoffNo = document.getElementById('dropoff_no');
            const dropoffDetails = document.getElementById('dropoffDetails');
            const noDropoffDetails = document.getElementById('noDropoffDetails');

            dropoffYes.addEventListener('change', function() {
                dropoffDetails.style.display = this.checked ? 'block' : 'none';
                noDropoffDetails.style.display = this.checked ? 'none' : 'block';
            });

            dropoffNo.addEventListener('change', function() {
                dropoffDetails.style.display = this.checked ? 'none' : 'block';
                noDropoffDetails.style.display = this.checked ? 'block' : 'none';
            });

            const tourYes = document.getElementById('tour_yes');
            const tourNo = document.getElementById('tour_no');
            const tourDetails = document.getElementById('tourDetails');

            tourYes.addEventListener('change', function() {
                tourDetails.style.display = this.checked ? 'block' : 'none';
            });

            tourNo.addEventListener('change', function() {
                tourDetails.style.display = this.checked ? 'none' : 'block';
            });

            const registrationForm = document.getElementById('registrationForm');
            const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');

            function getUrlParam(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            const registrationStatus = getUrlParam('registration_status');
            const message = getUrlParam('message');

            if (registrationStatus === 'success') {
                modalTitle.textContent = 'Pendaftaran Berhasil';
                modalMessage.textContent = message;
                messageModal.show();
                history.replaceState(null, null, window.location.pathname);
            } else if (registrationStatus === 'failed') {
                modalTitle.textContent = 'Pendaftaran Gagal';
                modalMessage.textContent = message;
                messageModal.show();
                history.replaceState(null, null, window.location.pathname);
            }

            registrationForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Handle "Other" institution
                if (institutionSelect.value === 'other' && otherInput.value) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'institution_name';
                    hiddenInput.value = otherInput.value;
                    this.appendChild(hiddenInput);
                }

                // Kirim data formulir secara tradisional
                this.submit();
            });
        });
    </script>
</body>
</html>