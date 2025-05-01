<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="assets/css/google-web-fonts.css" rel="stylesheet"> 
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
  <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">

  <script>
	window.onload = function() {
		var dropdownSelectRole = document.getElementById("dropdownSelectRole");
		var drowdownSelectUniversity = document.getElementById("drowdownSelectUniversity");
		var otherSection = document.getElementById("otherSection");
		var registrationSection = document.getElementById("registrationSection");
		var paperInformation = document.getElementById("paperInformation");
		var dropdownPickup = document.getElementById("dropdownPickup");
		var dropdownDroppedoff = document.getElementById("dropdownDroppedoff");
		var dropdownFamily = document.getElementById("dropdownFamily");
		var arrivalSection = document.getElementById("arrivalSection");
		var departureSection = document.getElementById("departureSection");
		var familySection = document.getElementById("familySection");
		var checkinSection = document.getElementById("checkinSection");
		var checkoutSection = document.getElementById("checkoutSection");
		var fee50 = document.getElementById("fee50");
		var fee75 = document.getElementById("fee75");

		dropdownSelectRole.onchange = function() {
			if (drowdownSelectUniversity.value == "Others" && dropdownSelectRole.value == "Participant") {
				fee75.style.display = "block";
				fee50.style.display = "none";
				registrationSection.style.display = "block";
				otherSection.style.display = "block";
				paperInformation.style.display = "none";
			}else if(drowdownSelectUniversity.value == "Others" && dropdownSelectRole.value == "Presenter"){
				fee75.style.display = "none";
				fee50.style.display = "block";
				registrationSection.style.display = "block";
				otherSection.style.display = "block";
				paperInformation.style.display = "block";
			}else if(drowdownSelectUniversity.value != "Others" && dropdownSelectRole.value == "Participant"){
				fee75.style.display = "none";
				fee50.style.display = "block";
				registrationSection.style.display = "block";
				otherSection.style.display = "none";
				paperInformation.style.display = "none";
			}else if(drowdownSelectUniversity.value != "Others" && dropdownSelectRole.value == "Presenter"){
				fee75.style.display = "none";
				fee50.style.display = "none";
				registrationSection.style.display = "none";
				otherSection.style.display = "none";
				paperInformation.style.display = "block";
			}
		}

		drowdownSelectUniversity.onchange = function() {
			if (drowdownSelectUniversity.value == "Others" && dropdownSelectRole.value == "Participant") {
				fee75.style.display = "block";
				fee50.style.display = "none";
				registrationSection.style.display = "block";
				otherSection.style.display = "block";
			}else if(drowdownSelectUniversity.value == "Others" && dropdownSelectRole.value == "Presenter"){
				fee75.style.display = "none";
				fee50.style.display = "block";
				registrationSection.style.display = "block";
				otherSection.style.display = "block";
			}else if(drowdownSelectUniversity.value != "Others" && dropdownSelectRole.value == "Participant"){
				fee75.style.display = "none";
				fee50.style.display = "block";
				registrationSection.style.display = "block";
				otherSection.style.display = "none";
			}else if(drowdownSelectUniversity.value != "Others" && dropdownSelectRole.value == "Presenter"){
				fee75.style.display = "none";
				fee50.style.display = "none";
				registrationSection.style.display = "none";
				otherSection.style.display = "none";
			}
		}

		dropdownPickup.onchange = function() {
			if (dropdownPickup.value == "Yes") {
				arrivalSection.style.display = "block";
				checkinSection.style.display = "none";
			}else{
				arrivalSection.style.display = "none";
				checkinSection.style.display = "block";
			}
		}

		dropdownDroppedoff.onchange = function() {
			if (dropdownDroppedoff.value == "Yes") {
				departureSection.style.display = "block";
				checkoutSection.style.display = "none";
			}else{
				departureSection.style.display = "none";
				checkoutSection.style.display = "block";
			}
		}

		dropdownFamily.onchange = function() {
			if (dropdownFamily.value == "Yes") {
				familySection.style.display = "block";
			}else{
				familySection.style.display = "none";
			}
		}
	}
  </script>

</head>
<body>

	<div class="container mt-3">
	<div class="mb-12 mt-12 text-center">
		<h1>Registration</h1>
	</div>
	<div class="mb-3 mt-3">
		<label for="dropdownSelectRole" class="form-label">Select Role:</label>
		<select class="form-select" id="dropdownSelectRole" name="dropdownSelectRoleList">
			<option value="Presenter">Presenter</option>
			<option value="Participant">Participant</option>
		</select>
	</div>
	<h3>Personal Details</h3>
	<form action="/action_page.php">
		<div class="mb-3 mt-3">
			<label for="drowdownSelectTitle" class="form-label">Title:</label>
			<select class="form-select" id="drowdownSelectTitle" name="dropdownSelectTitleList">
				<option>Mr.</option>
				<option>Mrs.</option>
				<option>Ms.</option>
				<option>Dr.</option>
			</select>
		</div>
		<div class="mb-3 mt-3">
			<label for="textBoxFullname">Fullname(Needed for Certificate):</label>
			<input type="text" class="form-control" placeholder="Enter Fullname" name="fullname" id="textBoxFullname" required>
		</div>
		<div class="mb-3 mt-3">
			<label for="textBoxEducationDegrees">Education Degrees:</label>
			<input type="text" class="form-control" placeholder="Enter Education Degrees" name="educationDegrees" id="textBoxEducationDegrees" required>
		</div>
		<div class="mb-3 mt-3">
			<label for="drowdownSelectGender" class="form-label">Select Gender:</label>
			<select class="form-select" id="drowdownSelectGender" name="selectGender">
				<option>Male</option>
				<option>Female</option>
			</select>
		</div>
		<div class="mb-3 mt-3">
			<label for="numberAge">Age:</label>
			<input type="number" class="form-control" id="numberAge" name="age" min="1" max="100" required>
		</div>
		<div class="mb-3 mt-3">
		<label for="drowdownSelectShirtSize" class="form-label">Select Shirt Size:</label>
		<select class="form-select" id="drowdownSelectShirtSize" name="selectShirtSize">
			<option>S</option>
			<option>M</option>
			<option>L</option>
			<option>XL</option>
			<option>XXL</option>
		</select>
		</div>
		<h3>Affiliation Details</h3>
		<div class="mb-3 mt-3">
			<label for="drowdownSelectUniversity" class="form-label">Select Univeristy/instituion:</label>
			<select class="form-select" id="drowdownSelectUniversity" name="selectUniversity">
				<option value="aiias">Adventist International Institute of Advanced Studies</option>
				<option value="aup">Adventist University of the Philippines</option>
				<option value="apiu">Asia-Pacific International University</option>
				<option value="unai">Universitas Advent Indonesia</option>
				<option value="Others">Others</option>
			</select>
		</div>
		<div id="otherSection" style="display:none">
			<div class="mb-3 mt-3">
				<label for="textBoxUniversity">Other University/Institution:</label>
				<input type="text" class="form-control" placeholder="Enter University/Institution" name="university" id="textBoxUniversity" required>
			</div>
		</div>
		<div class="mb-3 mt-3">
			<label for="textBoxCountry">Country of Residence:</label>
			<input type="text" class="form-control" placeholder="Enter Country of Residence" name="country" id="textBoxCountry" required>
		</div>
		<div class="mb-3 mt-3">
			<label for="textBoxDepartment">Department/Division:</label>
			<input type="text" class="form-control" placeholder="Enter Department/Division" name="department" id="textBoxDepartment" required>
		</div>
		<div class="mb-3 mt-3">
			<label for="textBoxPosition">Job Title/Position:</label>
			<input type="text" class="form-control" placeholder="Enter Job Title/Position" name="position" id="textBoxPosition" required>
		</div>
		<div id="paperInformation" style="display:block">
			<h3>Paper Information</h3>
			<div class="mb-3 mt-3">
				<label for="textBoxStrand">Strand:</label>
				<input type="text" class="form-control" placeholder="Enter Strand" name="strand" id="textBoxStrand" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxCode">Code:</label>
				<input type="text" class="form-control" placeholder="Enter Code" name="code" id="textBoxCode" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxPaperTitle">Paper Title:</label>
				<input type="text" class="form-control" placeholder="Enter Paper Title" name="paperTitle" id="textBoxPaperTitle" required>
			</div>
		</div>
		<h3>Travel and Accomodation</h3>
		<div class="mb-3 mt-3">
			<label for="dropdownPickup">Do you want to be picked up at the airport?</label>
			<select class="form-select" id="dropdownPickup" name="selectPickup">
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
		</div>
		<div id="arrivalSection" style="display:block">
			<div class="mb-3 mt-3">
				<label for="textBoxFlightNumberArrival">Flight Number:</label>
				<input type="text" class="form-control" placeholder="Enter Flight Number" name="arrivalFlightNumber" id="textBoxFlightNumberArrival" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="dateTimePickup">Pickup Date:</label>
				<input type="datetime-local" id="dateTimePickup" name="dateTimePickup">
			</div>
		</div>
		<div id="checkinSection" style="display:none">
			<div class="mb-3 mt-3">
				<label for="dateTimeCheckin">Checkin Date:</label>
				<input type="datetime-local" id="dateTimeCheckin" name="dateTimeCheckin">
			</div>
		</div>
		<div class="mb-3 mt-3">
			<label for="dropdownDroppedoff">Do you want to be dropped off at the airport?</label>
			<select class="form-select" id="dropdownDroppedoff" name="selectDroppedOff">
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
		</div>
		<div id="departureSection" style="display:block">
			<div class="mb-3 mt-3">
				<label for="textBoxFlightNumberDroppedOff">Flight Number:</label>
				<input type="text" class="form-control" placeholder="Enter Flight Number" name="droppedoffFlightNumber" id="textBoxFlightNumberDroppedOff" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="dateTimeDeparture">Departure Date:</label>
				<input type="datetime-local" id="dateTimeDeparture" name="dateTimeDeparture">
			</div>
		</div>
		<div id="checkoutSection" style="display:none">
			<div class="mb-3 mt-3">
				<label for="dateTimeCheckout">Checkout Date:</label>
				<input type="datetime-local" id="dateTimeCheckout" name="dateTimeCheckout">
			</div>
		</div>
		<div class="mb-3 mt-3">
			<label for="dropdownLodge">Lodge:</label>
			<select class="form-select" id="dropdownLodge" name="lodge">
				<option>Hotel(Own Cost)</option>
				<option>Dormitory(Shared Rooms with Bunk Bed)</option>
			</select>
		</div>
		<div class="mb-3 mt-3">
			<label for="dropdownFamily">Is there any family member joining this program as a participant or presenter?</label>
			<select class="form-select" id="dropdownFamily" name="family">
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
		</div>
		<div id="familySection" style="display:block">
			<div class="mb-3 mt-3">
				<label for="textBoxFamilyName">Family Fullname:</label>
				<input type="text" class="form-control" placeholder="Enter Family Fullname" name="droppedoffFlightNumber" id="textBoxFamilyName" required>
			</div>
		</div>
		<div id="registrationSection" style="display:none">
			<h3>Registration Fee</h3>
			<div id="fee50" style="display:none">
				<div class="mb-3 mt-3">
					<label id="labelRegistrationFee50">Fee: $50</label>
				</div>
			</div>
			<div id="fee75" style="display:none">
				<div class="mb-3 mt-3">
					<label id="labelRegistrationFee75">Fee: $75</label>
				</div>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxAccountName">Account Name:</label>
				<input type="text" class="form-control" placeholder="Enter Account Name" name="accountName" id="textBoxAccountName" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxAccountNumber">Account Number:</label>
				<input type="text" class="form-control" placeholder="Enter Account Number" name="accountNumber" id="textBoxAccountNumber" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxNumberBank">Number of Bank:</label>
				<input type="text" class="form-control" placeholder="Enter Number of Bank" name="numberofBank" id="textBoxNumberBank" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxBankAddr">Bank Address:</label>
				<input type="text" class="form-control" placeholder="Enter Bank Address" name="bankAddress" id="textBoxBankAddr" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxSwiftCode">Swift Code:</label>
				<input type="text" class="form-control" placeholder="Enter Swift Code" name="swiftCode" id="textBoxSwiftCode" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxRoutingNumber">Routing Number:</label>
				<input type="text" class="form-control" placeholder="Enter Routing Number" name="routingNumber" id="textBoxRoutingNumber" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="textBoxBeneficiaryAddr">Beneficiary Address:</label>
				<input type="text" class="form-control" placeholder="Enter Beneficiary Address" name="beneficiaryAddress" id="textBoxBeneficiaryAddr" required>
			</div>
			<div class="mb-3 mt-3">
				<label for="uploadPaymentReceipt">Payment Receipt:</label>
				<input class="form-control" type="file" id="uploadPaymentReceipt" required>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
	</div>
</body>
</html>
