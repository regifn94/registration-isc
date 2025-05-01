<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Presenter Registration</title>
</head>
<body>

  <h2>Presenter Registration Form</h2>
  <form action="save_presenter.php" method="post" enctype="multipart/form-data">

    <!-- General Info -->
    <label for="fullname">Full Name:</label><br>
    <input type="text" name="fullname" id="fullname" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <!-- Affiliation -->
    <label for="affiliation_type">Affiliation:</label><br>
    <select name="affiliation_type" id="affiliation_type" onchange="toggleRegPayment()" required>
      <option value="">--Select--</option>
      <option value="member">Member</option>
      <option value="non_member">Non-member</option>
    </select><br><br>

    <!-- Registration Payment Section (Non-member only) -->
    <div id="reg_payment_section" style="display: none;">
      <h4>Registration Payment Info (Non-Member)</h4>
      <label for="reg_account_name">Account Name:</label><br>
      <input type="text" name="reg_account_name" id="reg_account_name"><br><br>

      <label for="reg_account_number">Account Number:</label><br>
      <input type="text" name="reg_account_number" id="reg_account_number"><br><br>

      <label for="reg_bank_number">Bank Number:</label><br>
      <input type="text" name="reg_bank_number" id="reg_bank_number"><br><br>

      <label for="reg_bank_address">Bank Address:</label><br>
      <textarea name="reg_bank_address" id="reg_bank_address"></textarea><br><br>

      <label for="reg_payment_receipt">Upload Registration Payment Receipt:</label><br>
      <input type="file" name="reg_payment_receipt" id="reg_payment_receipt" accept=".pdf,.jpg,.jpeg,.png"><br><br>
    </div>

    <!-- Post-Conference Tour -->
    <label for="join_tour">Join Post-conference Tour?</label><br>
    <select name="join_tour" id="join_tour" onchange="toggleTourPayment()" required>
      <option value="">--Select--</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select><br><br>

    <!-- Tour Payment Section -->
    <div id="tour_payment_section" style="display: none;">
      <h4>Post-conference Tour Payment</h4>
      <label for="tour_payment_receipt">Upload Tour Payment Receipt:</label><br>
      <input type="file" name="tour_payment_receipt" id="tour_payment_receipt" accept=".pdf,.jpg,.jpeg,.png"><br><br>
    </div>

    <button type="submit">Submit</button>
  </form>

  <script>
    function toggleRegPayment() {
      const affiliation = document.getElementById("affiliation_type").value;
      const regSection = document.getElementById("reg_payment_section");
      regSection.style.display = (affiliation === "non_member") ? "block" : "none";
    }

    function toggleTourPayment() {
      const tour = document.getElementById("join_tour").value;
      const tourSection = document.getElementById("tour_payment_section");
      tourSection.style.display = (tour === "Yes") ? "block" : "none";
    }
  </script>

</body>
</html>
