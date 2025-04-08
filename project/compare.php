<?php  
include 'components/connect.php';

$property1 = isset($_GET['property1']) ? $_GET['property1'] : '';
$property2 = isset($_GET['property2']) ? $_GET['property2'] : '';

if (!$property1) {
   header('location:home.php'); // Redirect if no property selected
}

// Fetch first property
$select_property1 = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
$select_property1->execute([$property1]);
$fetch_property1 = $select_property1->fetch(PDO::FETCH_ASSOC);

// Fetch second property if selected
$fetch_property2 = null;
if ($property2) {
   $select_property2 = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
   $select_property2->execute([$property2]);
   $fetch_property2 = $select_property2->fetch(PDO::FETCH_ASSOC);
}

// Fetch all properties for selection dropdown
$all_properties = $conn->prepare("SELECT id, property_name FROM `property` WHERE id != ?");
$all_properties->execute([$property1]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Compare Properties</title>
   <link rel="stylesheet" href="css/style.css">
   <style>
      .compare-container {
         display: flex;
         justify-content: center;
         gap: 20px;
         padding: 20px;
         flex-wrap: wrap;
      }
      .property-box {
         background: #fff;
         padding: 20px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
         max-width: 450px;
         width: 100%;
         text-align: center;
      }
      .property-box img {
         width: 100%;
         height: 250px;
         object-fit: cover;
         border-radius: 8px;
      }
      .property-box h2 {
         font-size: 22px;
         margin-top: 10px;
      }
      .property-box p {
         font-size: 16px;
         margin: 5px 0;
      }
      .compare-section {
         text-align: center;
         padding: 20px;
      }
      .select-box {
         margin-top: 20px;
      }
   </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="compare-section">
   <h1 class="heading">Compare Properties</h1>

   <div class="compare-container">
      <div class="property-box">
         <img src="uploaded_files/<?= $fetch_property1['image_01']; ?>" alt="Property 1">
         <h2><?= $fetch_property1['property_name']; ?></h2>
         <p><strong>Price:</strong> $<?= $fetch_property1['price']; ?></p>
         <p><strong>Location:</strong> <?= $fetch_property1['address']; ?></p>
         <p><strong>Type:</strong> <?= ucfirst($fetch_property1['type']); ?></p>
         <p><strong>Size:</strong> <?= $fetch_property1['carpet']; ?> sqft</p>
         <p><strong>Bedrooms:</strong> <?= $fetch_property1['bedroom']; ?></p>
         <p><strong>Bathrooms:</strong> <?= $fetch_property1['bathroom']; ?></p>
         <p><strong>Status:</strong> <?= ucfirst($fetch_property1['status']); ?></p>
         <p><strong>Furnished:</strong> <?= ucfirst($fetch_property1['furnished']); ?></p>
      </div>

      <div class="property-box">
         <?php if ($fetch_property2) { ?>
            <img src="uploaded_files/<?= $fetch_property2['image_01']; ?>" alt="Property 2">
            <h2><?= $fetch_property2['property_name']; ?></h2>
            <p><strong>Price:</strong> $<?= $fetch_property2['price']; ?></p>
            <p><strong>Location:</strong> <?= $fetch_property2['address']; ?></p>
            <p><strong>Type:</strong> <?= ucfirst($fetch_property2['type']); ?></p>
            <p><strong>Size:</strong> <?= $fetch_property2['carpet']; ?> sqft</p>
            <p><strong>Bedrooms:</strong> <?= $fetch_property2['bedroom']; ?></p>
            <p><strong>Bathrooms:</strong> <?= $fetch_property2['bathroom']; ?></p>
            <p><strong>Status:</strong> <?= ucfirst($fetch_property2['status']); ?></p>
            <p><strong>Furnished:</strong> <?= ucfirst($fetch_property2['furnished']); ?></p>
         <?php } else { ?>
            <h2>Select a Property to Compare</h2>
            <form action="" method="GET" class="select-box">
               <input type="hidden" name="property1" value="<?= $property1; ?>">
               <select name="property2" required>
                  <option value="">-- Select a Property --</option>
                  <?php while ($row = $all_properties->fetch(PDO::FETCH_ASSOC)) { ?>
                     <option value="<?= $row['id']; ?>"><?= $row['property_name']; ?></option>
                  <?php } ?>
               </select>
               <input type="submit" value="Compare" class="btn">
            </form>
         <?php } ?>
      </div>
   </div>

   <!-- Reset Comparison Button (Now Placed Inside Comparison Section) -->
   <div class="reset-container">
      <button onclick="resetComparison()" class="btn">Reset Comparison</button>
   </div>

</section>
<script>
   function resetComparison() {
      // Update the URL without reloading the page
      window.history.pushState({}, document.title, "compare.php");

      // Remove second property selection
      let compareBox = document.querySelector(".property-box:nth-child(2)");
      compareBox.innerHTML = `
         <h2>Select a Property to Compare</h2>
         <form action="" method="GET" class="select-box">
            <input type="hidden" name="property1" value="<?= $property1; ?>">
            <select name="property2" required>
               <option value="">-- Select a Property --</option>
               <?php while ($row = $all_properties->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?= $row['id']; ?>"><?= $row['property_name']; ?></option>
               <?php } ?>
            </select>
            <input type="submit" value="Compare" class="btn">
         </form>
      `;
   }
</script>



<?php include 'components/footer.php'; ?>

</body>
</html>
