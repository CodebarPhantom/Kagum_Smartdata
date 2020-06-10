<!DOCTYPE html>
<html lang="en" >
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="noindex"/>
	<meta name="googlebot" content="noindex"/>
	<meta name="robots" content="noindex, nofollow"/>



<meta charset="UTF-8">
<title><?php echo 'Test' ?></title>



</head>

<body>
    <style>



#pdfreport {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  margin-left:auto; 
  margin-right:auto;
  font-size: 10px;

  
  }

#pdfreport td {
  border: 1px solid #ddd;
  padding: 3px;
  
}
#pdfreport th{
    border: 1px solid #ddd;
    padding: 5px;
}



#pdfreport tr:hover {background-color: #ddd;}

#pdfreport th {
  background-color: #353b48;
  color: white;
  text-align: center;
}

.rata-kanan{
	vertical-align: middle; 
	text-align: right;
}

</style>
<!-- partial:index.partial.html -->
<div class="container">
  <table  id="pdfreport">
    <caption><strong style="font-size: 14px;"><?php echo 'Test' ?></strong> <br/></caption>
    
    <thead>
        <tr>
            <th rowspan="2"><?php echo $lang_hotel_name; ?></th>
            <th rowspan="2">Rooms</th>
            <th rowspan="2">R. Sold</th>
            <th colspan="3">Today</th>
            <th colspan="4">MTD</th>
            <th rowspan="2">%</th>                                            
        </tr>
        <tr>
            <th>OCC</th>
            <th>ARR</th>
            <th>REV</th>
            <th>OCC</th>
            <th>ARR</th>
            <th>REV</th>
            <th>BUDGET</th>
        </tr>
    </thead>

    

    <tbody>

                            

    </tbody>     

    <tfoot>
      <tr>
        <td colspan="11" style="font-size: 9px;">Sources: Kagum Hotels Smartdata.</td>
      </tr>
    </tfoot>
  </table>
</div>

</body>
</html>