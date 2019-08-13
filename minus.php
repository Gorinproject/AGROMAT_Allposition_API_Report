<html>
<head>
    <style type="text/css">
     td.negative { color : red; }
    </style>
    <script language="JavaScript" type="text/javascript">
    <!--
    function MakeNegative() {
        TDs = document.getElementsByTagName('td');
        for (var i=0; i<TDs.length; i++) {
                var temp = TDs[i];
                if (temp.firstChild.nodeValue.indexOf('-') == 0) temp.className = "negative";
            }
    }
    //-->
    </script>
</head>
<body>
 <table id="mytable">
  <caption>Some Financial Stuff</caption>
  <thead>
    <tr><th scope="col">Date</th><th scope="col">Money is good</th></tr>
  </thead>
  <tbody>
  <tr><td>2006-05-01</td><td>19.95</td></tr>
  <tr><td>2006-05-02</td><td>-54.54</td></tr>
  <tr><td>2006-05-03</td><td>34.45</td></tr>
  <tr><td>2006-05-04</td><td>88.00</td></tr>
  <tr><td>2006-05-05</td><td>22.43</td></tr>
  </tbody>
 </table>
    <script language="JavaScript" type="text/javascript">
  <!--
   MakeNegative();
  //-->
    </script>
</body>