<?php 
require_once('db.php');
if(isset($_GET['action'])) {
	$akcija = $_GET['action'];
	$id = $_GET['pid'];

	switch ($akcija) {
		case 'delete':
			$sql = "DELETE FROM products WHERE productID = " . $id;
			mysql_query($sql);
		break;
		case 'add':
			include_once('products-form.php');
			die;
		break;
		case 'edit':
			include_once('products-form.php');
			die;
		break;		

	}

}

 ?><!doctype html>
<html>
<head>
	<title>CMS</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Proizvodi</h1>
	<div class="ispis">
		<a href="?action=add">Dodaj novi proizvod</a><br><br>
		<a href="?">All</a>
		
		<?php 
		$sql = "SELECT DISTINCT productType FROM products";
		$result  = mysql_query($sql);

		while( $row  = mysql_fetch_assoc($result) ):
		echo " | ";
		echo "<a href='?tip=".$row['productType']."'>".$row['productType']."</a>";
		
		endwhile;
		 ?>

		
		<br><br>	

		<table>
			<tr>
				<th>No</th>
				<th>Product</th>
				<th>Type</th>
				<th>Description</th>
				<th>Image</th>
				<th>Price</th>
				<th>PartNo</th>
				<th>Actions</th>


			</tr>
	<?php // OVDE POCINJE LOOP
			$tip = $_GET['tip'];

			if($tip) { // u slucaju da postoji filter (tj varijabla tip u URL)
				$sql = "SELECT * FROM products WHERE productType='$tip'";
			} else { //u suprotnom sve 
				$sql = "SELECT * FROM products";	
			}
			 $sql.= " ORDER BY productID";
			
			$result = mysql_query($sql);

			$count = 1;
		while( $row = mysql_fetch_assoc($result) ): 
			
			//OVAKO CEMO UTVRDITI KOJI REDOVI SU NEPARNI 
			if( $count % 2  == 1) {
				$klasa = "sivkasto";
			} else {
				$klasa = "";
			}
		
	 ?>
			<tr class="<?php echo $klasa; ?>">
				<td><?php echo $count; ?></td>
				<td><?php echo $row['productName']; ?></td>
				<td><?php echo $row['productType']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td><img width="50" src="uploads/<?php echo $row['imageName']; ?>"></td>
				<td><?php echo $row['price']; ?></td>
				<td><?php echo $row['partNum']; ?></td>
				<td><a href="?action=edit&pid=<?php echo $row['productID']; ?>">EDIT</a> | <a href="?action=delete&pid=<?php echo $row['productID']; ?>" onclick="confirm('Are you sure?');">DELETE</a></td>
			</tr>
	
	<?php 
			$count++;
			endwhile;  

	// OVDE SE ZAVRSAVA LOOP ?>


		</table>
	</div>

</body>
</html>