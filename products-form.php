<?php 
$label = "Add New";
if($_GET['action'] == 'edit') {
	$sql = "SELECT * FROM products WHERE productID = " .$_GET['pid'];
	$result = mysql_query($sql);
	$proizvod = mysql_fetch_assoc($result);
	$label = "Edit";

} 
if($_POST['submit']) {
	$productName = $_POST['name'];
	$type = $_POST['type'];
	$desc = $_POST['description'];
	$price = $_POST['price'];
	$part = $_POST['part'];

	$putanja = getcwd();
	$ime_slike = time() . "_" . $_FILES['slika']['name'];
	
	$putanja = $putanja . "/uploads/" . $ime_slike; 
	move_uploaded_file($_FILES['slika']['tmp_name'], $putanja);
	
	if($_POST['action'] == 'add') {
	$sql = "INSERT INTO products SET productName = '$productName', productType='$type', description = '$desc', price = '$price', partNum = '$part', imageName='$ime_slike'";
	} else {
	 $sql = "UPDATE products SET productName = '$productName', productType='$type', description = '$desc', price = '$price', partNum = '$part', imageName='$ime_slike' WHERE productID = " . $_POST['pid'];
	}
	$rezultat = mysql_query($sql);
	if ($rezultat) {
		header('Location: ?');
	}
}


 ?><!doctype html>
<html>
	<head>
		<title><?php echo $label; ?> Product</title>
	</head>
	<body>
		<h1><?php echo $label; ?> Product</h1>
		<form action="?action=add" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="<?php echo $_GET['action']; ?>">
			<input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">
			<table>
				<tr>
					<td>Product name</td>
					<td><input type="text" name="name" value="<?php echo $proizvod['productName']; ?>"></td>
				</tr>
				<tr>
					<td>Product description</td>
					<td><textarea name="description" id="" cols="30" rows="10"><?php echo $proizvod['description']; ?></textarea></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>
						<select name="type">
							<?php 
		$sql = "SELECT DISTINCT productType FROM products";
		$result  = mysql_query($sql);

		while( $row  = mysql_fetch_assoc($result) ):
			if ( $row['productType'] == $proizvod['productType']) {
				$selected = "selected";
			} else {
				$selected = "";
			}
		?>
				<option value="<?php echo $row['productType']; ?>" <?php echo $selected; ?>><?php echo $row['productType']; ?></option>
		<?php
		endwhile;
		 ?>
						</select>

					</td>
				</tr>
				<tr>
					<td>Product image</td>
					<td><?php 

					if($proizvod['imageName']){
						echo "<img src='uploads/".$proizvod['imageName']."'>";
					}

					 ?><input type="file" name="slika"></td>
				</tr>
				<tr>
					<td>Price</td>
					<td><input type="text" name="price" value="<?php echo $proizvod['price']; ?>"></td>
				</tr>
				<tr>
					<td>PartNo</td>
					<td><input type="text" name="part" value="<?php echo $proizvod['partNum']; ?>"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="<?php echo $label; ?>"><input type="reset" value="Reset"></td>
				</tr>

			</table>
		</form>
	</body>
</html>