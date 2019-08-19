<?php 
// view at http://localhost:8080/AlgaeVouchers/
include_once '../includes/dbh_inc.php'; //gives us access to variable $conn, which is the connection to  our database
?>

<head> 
<link rel = "stylesheet" type = "text/css" href = "../includes/Tables.css">
<link rel = "stylesheet" type = "text/css" href = "../includes/Forms.css">
<link rel = "stylesheet" type = "text/css" href ="../includes/NavBar.css">
</head>


<body>
	<ul>
<li> <a href = "../index.php" > Home </a> </li>
<li> <a href = "Database.php"> Voucher Database </a> </li> 
<li> <a href = #mainwebsite > MarinE </a>  </li>
</ul>
</br></br></br>

<!-- 
<p>
	<font size = "25"> 
	</br> Search Again! 
	</font>
</p> -->

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
	<br>
</body>


<p>
	<font size = "6"> 
	Search Results: 
	</font>
</p>

<?php

$Region = mysqli_real_escape_string($conn, $_POST['Region']); 
$PrepRegion = '%'.$Region.'%';
$Intertidal_sitename = mysqli_real_escape_string($conn, $_POST['Site']);
$PrepSite = '%'.$Intertidal_sitename.'%';
$Genus = mysqli_real_escape_string($conn, $_POST['Genus']); 
$PrepGenus = '%'.$Genus.'%';
$Sampler = mysqli_real_escape_string($conn, $_POST['Sampler']);
$PrepSampler = '%'.$Sampler.'%';

if (!isset($_POST['scanned'])) {
    $ScannedOnly ='';
} else {
    $ScannedOnly = mysqli_real_escape_string($conn, $_POST['scanned']);
}
$PrepScanned = '%'.$ScannedOnly.'%';


if($Region == '' and $Intertidal_sitename == '' and $Genus == '' and $Sampler == '')
{
	echo "No Filters Applied :(";
}
else
{
	//Created a template
	$sql = "
	SELECT Voucher.Catalog_number, Voucher.GENUS_SPP,  Sampler.SAMPLER, Region.region, Intertidal_sitename.Intertidal_sitename, Images.Scan_Link
	From Voucher
	join Sampler 
	on Sampler.SAMPLER_NUMBER = Voucher.Sampler
	join Region
	on Voucher.REGION = Region.REGION_NUMBER
	join Intertidal_sitename
	on Voucher.Intertidal_sitename = Intertidal_sitename.Site_number
	join Images
	on Images.Catalog_number = Voucher.Catalog_number
	WHERE Region.region like ? and Intertidal_sitename.Intertidal_sitename like ? and Voucher.genus_spp like ? and Sampler.SAMPLER like ? and Images.Scanned like ?
	ORDER BY Voucher.Catalog_number;";
	//CREATE A PREPARED STATEMENTS
	$stmt = mysqli_stmt_init($conn);
	//Prepare the  prepared statement
	if(!mysqli_stmt_prepare($stmt,$sql))
	{
		echo 'SQL Statement Failed';
	}   else {
		//Bind parameters to placeholders
		mysqli_stmt_bind_param($stmt, "sssss", $PrepRegion, $PrepSite, $PrepGenus, $PrepSampler, $PrepScanned);
		//Run Parameters inside database
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		//$results = mysqli_query($conn, $sql); //two arguments, the connection and the query
	$resultCheck = mysqli_num_rows($result);

	if($resultCheck > 0)
	{
		echo "<div style = 'overflow-x:auto;'>"; //horizontal scroll bar :)
		echo"<table>"; //border='1' consider removing border all together
		echo"<tr> <th> Catalog_number </th>  <th> Genus_Species </th> <th> Sampler </th> <th> Region </th> <th> Intertidal_sitename </th> <th> Scan_Link </th>  </tr>\n";
		//header row, tr is a row, td are the values across the rows

		While($row = mysqli_fetch_assoc($result)) //for full tables- https://www.youtube.com/watch?v=pc0otVM80Sk
		//$row is an array, with indexs that are the column values... 
		{
			if(strlen($row['Scan_Link']) < 15) //less characters than null or any google drive link
				{
					echo "<tr> 
					<td> {$row['Catalog_number']} </td>
					 <td> {$row['GENUS_SPP']} </td>
					  <td> {$row['SAMPLER']} </td>
					   <td> {$row['region']} </td>
					    <td> {$row['Intertidal_sitename']}  </td> 
					    <td> No Scan </td> 
					    </tr>\n";
				}
				else //There is a scan!!
				{
					echo "<tr> <td> {$row['Catalog_number']} </td> 
					<td> {$row['GENUS_SPP']} </td> 
					<td> {$row['SAMPLER']} </td>
					 <td> {$row['region']} </td> 
					 <td> {$row['Intertidal_sitename']}  </td> 
					<td> <a href = '{$row['Scan_Link']}' target = ' _blank' > Scan </a> </td> 
					 </tr>\n";
				}
			
		}
		echo"</table>";
		echo "<div>";
	}
	else
	{	
		echo "No Matching Results Found";	
	}
	}


}

?>