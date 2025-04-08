<?php
// Load locations from columns.json for the dropdown list
$locations = [];
$json_file = 'C:\\xampp\\htdocs\\project\\project\\model\\columns.json';
if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $decoded = json_decode($json_data, true);
    if (isset($decoded['data_columns'])) {
        $locations = array_slice($decoded['data_columns'], 2);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Property Valuation</title>
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/calculator.css">
  <style>
      body {
          display: flex;
          justify-content: center;
          align-items: center;
          flex-direction: column;
          padding: 20px;
      }
      form {
          width: 100%;
          max-width: 600px; /* Limit the width of the form */
      }
      input[type="number"],
      input[type="text"] {
          width: 100%; /* Full width */
          padding: 15px; /* Increased padding for larger input boxes */
          margin-bottom: 15px; /* Space between inputs */
          border: 1px solid #ccc; /* Light border */
          border-radius: 4px; /* Rounded corners */
      }
      button {
          width: 100%; /* Full width for button */
          padding: 15px; /* Padding for button */
          background-color: rgb(74, 206, 74); /* Green background */
          color: white; /* White text */
          border: none; /* No border */
          border-radius: 4px; /* Rounded corners */
          cursor: pointer; /* Pointer cursor on hover */
      }
      button:hover {
          background-color: rgb(60, 180, 60); /* Darker green on hover */
      }
  </style>
</head>
<body>
<?php include 'components/user_header.php'; ?>

  <h1>Property Evaluation</h1>
 
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get and sanitize user inputs
      $bedrooms  = htmlspecialchars($_POST['bed']);
      $bathrooms = htmlspecialchars($_POST['bath']);
      $location  = htmlspecialchars($_POST['location']);
     
      // Prepare data to send as JSON
      $data = array(
          "bedrooms"  => $bedrooms,
          "bathrooms" => $bathrooms,
          "location"  => $location
      );
      $data_string = json_encode($data);
     
      // Set the URL to your Flask API endpoint
      $url = "http://localhost:5000/predict";
     
      // Initialize cURL
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($data_string)
      ));
     
      // Execute the POST request
      $result = curl_exec($ch);
      curl_close($ch);
     
      // Decode the JSON response
      $response = json_decode($result, true);
     
      // Display the predicted price or an error message
      if (isset($response["predicted_price"])) {
          $predicted_price = number_format($response["predicted_price"], 2);
          echo "<div id='result'>Predicted Price: \$$predicted_price</div>";
      } else if (isset($response["error"])) {
          echo "<div id='result'>Error: " . htmlspecialchars($response["error"]) . "</div>";
      } else {
          echo "<div id='result'>An unknown error occurred.</div>";
      }
  }
  ?>
 
  <form id="valuationForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="bed">Bedrooms:</label>
      <input type="number" id="bed" name="bed" required min="0" placeholder="Enter number of bedrooms">
 
      <label for="bath">Bathrooms:</label>
      <input type="number" id="bath" name="bath" required min="0" placeholder="Enter number of bathrooms">
 
      <label for="carpark">Carpark:</label>
      <input type="number" id="carpark" name="carpark" required min="0" placeholder="Enter number of carparks">
 
      <label for="location">Location:</label>
      <input type="text" id="location" name="location" required oninput="filterLocations()" placeholder="Type to search...">
      <div id="locationDropdown" style="border: 1px solid #ccc; display: none; position: absolute; background-color: white; z-index: 1000; margin-top: 5px;">
          <ul id="locationList"></ul>
      </div>
      <script>
          const locations = <?php echo json_encode($locations); ?>; // Pass PHP array to JavaScript
          function filterLocations() {
              const input = document.getElementById('location');
              const filter = input.value.toLowerCase();
              const dropdown = document.getElementById('locationDropdown');
              const list = document.getElementById('locationList');
              list.innerHTML = ''; // Clear previous results
              dropdown.style.display = 'none'; // Hide dropdown initially
              if (filter) {
                  const filteredLocations = locations.filter(loc => loc.toLowerCase().includes(filter));
                  if (filteredLocations.length > 0) {
                      filteredLocations.forEach(loc => {
                          const li = document.createElement('li');
                          li.textContent = loc;
                          li.onclick = () => {
                              input.value = loc; // Set input value on click
                              dropdown.style.display = 'none'; // Hide dropdown
                          };
                          list.appendChild(li);
                      });
                      dropdown.style.display = 'block'; // Show dropdown if there are results
                  } else {
                      const li = document.createElement('li');
                      li.textContent = 'No location found';
                      li.style.color = 'red'; // Optional: style for no results
                      list.appendChild(li);
                      dropdown.style.display = 'block'; // Show dropdown with no results
                  }
              }
          }
      </script>
 
      <button type="submit">Evaluate</button>
  </form>
 
  <?php
  if ($_SERVER["REQUEST_METHOD"] != "POST") {
      echo "<div id='result'></div>";
  }
  ?>
</body>
</html>
