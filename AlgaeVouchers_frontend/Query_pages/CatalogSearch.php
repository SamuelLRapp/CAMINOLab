<?php
//this search form will allows users to see all info about 1 voucher at a time
include_once '../includes/dbh_inc.php';
?>

<head> 
<link rel = "stylesheet" type = "text/css" href = "../includes/Tables.css">
<link rel = "stylesheet" type = "text/css" href = "../includes/Forms.css"> 
<link rel = "stylesheet" type = "text/css" href ="../includes/NavBar.css">
</head>
</br></br></br>



<body>
<ul>
<li> <a href = "../index.php" > Home </a> </li>
<li> <a href = "Database.php"> Voucher Database </a> </li> 
<li> <a href = #mainwebsite > MarinE </a> </li>
</ul>

<form action="SearchFunction.php" method="POST">  
	<fieldset> 
	<legend > Algae Image Data base </legend>
	<p>Search Again!</p>
	Genus Species: <input type="text" name = "Genus">
	<br>
	Intertidal Site: <input type="text" name = "Site">
	<br>
	Region: <input type = "text" name = "Region">
	<br>
	Sampler: <input type = "text" name = "Sampler">
	<br>
	Scanned Results Only: <input type = "radio" name = "scanned" value = "Y">
	All Results: <input type = "radio" name = "scanned" value =""> 
 	<br>
	<input type="submit" name = "submit" > 

</fieldset>
</form>

<form action='CatalogSearch.php' method='POST'>
	<fieldset>
		<p>Get more info about a chosen Voucher!</p>
		<legend> Catalog Search: All info </legend>
		Catalog Number: <input = 'text' name ='CatalogNum'>
		<br>
		<input type ="submit" name = "submit">
	</fieldset>

</body>


<p>
	<font size = "6">  
	Results of Catalog Search: 
	</font>
</p>

<?php

$Catalog_Number = mysqli_real_escape_string($conn, $_POST['CatalogNum']);
$PrepedCatalog = '%'.$Catalog_Number.'%';
if($Catalog_Number == '')
{
	echo "No Filters Applied :(";
}


if(strlen($Catalog_Number) == 4)
{

	$sql = "
	SELECT Voucher.Catalog_number, Voucher.GENUS_SPP,  Sampler.SAMPLER, Region.region, Intertidal_sitename.Intertidal_sitename, Voucher.Date, Images.Scan_Link, Voucher.Voucher_name, Voucher.Notes, Voucher.Habitat, Voucher.Transect, Voucher.Binder_Letter, Voucher.Page_Num
	From Voucher
	join Sampler 
	on Sampler.SAMPLER_NUMBER = Voucher.Sampler
	join Region
	on Voucher.REGION = Region.REGION_NUMBER
	join Intertidal_sitename
	on Voucher.Intertidal_sitename = Intertidal_sitename.Site_number
	join Images
	on Images.Catalog_number = Voucher.Catalog_number
	WHERE Voucher.Catalog_Number like ?;";

	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql))
	{
		echo 'SQL statement Failed';
	}
	else
	{
		mysqli_stmt_bind_param($stmt, "s", $PrepedCatalog);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);




	$resultsCheck = mysqli_num_rows($result);	
	if($resultsCheck > 1)
	{
		echo " Error: Multiple Results";
	}
	if($resultsCheck == 0)
	{
		echo "No results found";
	}
	if($resultsCheck == 1)
	{
		echo "<div style = 'overflow-x:auto;'>"; //horizontal scroll bar :)

		echo "<table>";//border = '1'
		echo "<tr> <th> Catalog_number </th>  <th> Genus_Species </th> <th> Sampler </th> <th> Region </th> <th> Intertidal_sitename </th> <th> Date </th> <th> Scan_Link </th> <th> Name_Vouchered-in field </th>  <th> Notes </th> <th> Habitat </th> <th> Transect </th> <th> Cabinet: Binder_Letter </th> <th> Cabinet: Page_Num </th>
		</tr> \n";

		While($row = mysqli_fetch_assoc($result))
		{
			if(strlen($row['Scan_Link']) < 5) //less characters than null or any google drive link
				{
					echo "<tr>  
			<td> {$row['Catalog_number']} </td> 
			<td> {$row['GENUS_SPP']} </td>
			<td> {$row['SAMPLER']} </td> 
			<td> {$row['region']} </td>
			<td> {$row['Intertidal_sitename']}  </td> 
			<td> {$row['Date']} </td>
			<td> No Scan > Scan </a> </td> 
			<td> {$row['Voucher_name']}</td>
			<td> {$row['Notes']} </td>
			<td> {$row['Habitat']} </td>
			<td> {$row['Transect']} </td>
			<td> {$row['Binder_Letter']} </td>
			<td> {$row['Page_Num']} </td>
			</tr>\n";
				}
				else //there is a scan!!
				{
					echo "<tr> 
			<td> {$row['Catalog_number']} </td> 
			<td> {$row['GENUS_SPP']} </td>
			<td> {$row['SAMPLER']} </td> 
			<td> {$row['region']} </td>
			<td> {$row['Intertidal_sitename']}  </td> 
			<td> {$row['Date']} </td>
			<td> <a href = '{$row['Scan_Link']}' target='_blank'> Scan </a> </td> 
			<td> {$row['Voucher_name']}</td>
			<td> {$row['Notes']} </td>
			<td> {$row['Habitat']} </td>
			<td> {$row['Transect']} </td>
			<td> {$row['Binder_Letter']} </td>
			<td> {$row['Page_Num']} </td>
			</tr>\n";
				}

			
		}
		echo"</table>";
		echo "<div>";
	}
	else
	{
		echo "Invalid Catalog_Number Length";
	}
	}
}


	

?>