
<!DOCTYPE html>

<html>
<head>
	<title>Database</title>

<link rel = "stylesheet" type = "text/css" href = "../includes/Forms.css">
<link rel = "stylesheet" type = "text/css" href ="../includes/NavBar.css"

</head>

	<body>
		<ul>
<li> <a href = "../index.php" > Home </a> </li>
<li> <a href = "Database.php"> Voucher Database </a> </li> 
<li> <a href = #mainwebsite > MarinE </a> </li>
</ul>

</br></br>
<p>
		<font size = "30"> 
	Version 1.2 of the UCSC Algae Voucher Researcher Tool
</font>
</p>


<form action="SearchFunction.php" method="POST">  
	<fieldset> 
	<legend > Algae Image Data base </legend>
	<p>Search with one or more filters! <br> Note: Will not search with no filters </p>
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

<br>

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
</html>
