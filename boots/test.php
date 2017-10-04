<!DOCTYPE html>
<html>
<head>
    <title>Sakila - Services</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/boots.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <span id="menuButton" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <div class = "container-fluid">
        <div id="main">
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="/boots/about.php">About</a>
                <a href="/boots/services.php">Services</a>
                <a href="/boots/customers.php">Customers</a>
                <a href="#">Contact</a>
            </div>
            <div id="header" class="jumbotron text-center">
                <h1>Customers</h1>
            </div>
            <div class = "row">
                <div class="col-xs-12 col-lg12">
                    <div id="cusomter-table" class="table-responsive">
                        <table id="tblData" class="table table-hover full-width-table">
                            <?php
                                include('../baseController.php');
                                $bc = new baseController();
                                $query =
                                "select
                                customer.customer_id,
                                    concat(customer.first_name, ' ', customer.last_name) as name,
                                    customer.email,
                                    address.address,
                                    city.city,
                                    country.country
                                from customer
                                inner join address
                                    on customer.address_id = address.address_id
                                inner join city
                                    on address.city_id = city.city_id
                                inner join country
                                    on city.country_id = country.country_id
                                where customer.active = 1
                                order by last_name;";
                                $values = $bc->query($query);
                                $header = false;
                                foreach( $values as $row ){
                                    echo "<tr>";
                                    if( ! $header ){
                                        foreach( $row as $label => $value ){
                                            if( $label === "customer_id" ){
                                                continue;
                                            }
                                            echo "<th>" . ucwords(implode(" ",explode("_",$label))) . "</th>";
                                        }
                                        echo "</tr><tr>";
                                        $header = true;
                                    }
                                    foreach( $row as $label => $value ){
                                        if( $label === "customer_id" ){
                                            $customer_id = $value;
                                            continue;
                                        }
                                        if( $label === "name" ){
                                            echo "<td><a href=\"customer.php?id=$customer_id\">" . ucwords(strtolower($value)) . "</a></td>";
                                            continue;
                                        }
                                        echo "<td>$value</td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        <div id="pages-container" style="width:100%; height:50px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="footercontent">
                <p>Patent pending but please don't steal from us while we get out legal shit figured out.</p>
            </div>
        </div>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
            document.getElementById("menuButton").style.visibility = "hidden";
        }
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
            document.getElementById("menuButton").style.visibility = "visible";
        }
    </script>
    <script type="text/javascript">
        
        
        $(document).ready(function() {
            // set records per page
            var recordPerPage = 20;
            // store row and page counts
            var totalRows = $('#tblData').find('tbody tr:has(td)').length;
            var totalPages = Math.ceil(totalRows / recordPerPage);


            // create page button div
            //var $pages = $('<ul id="pages" class="pagination"></ul>');
            var list = $("#pages-container").append('<ul id="pages" class="pagination center-block"></ul>').find('ul');
            // add button for each page and add to div
            list.append('<li id = "1" class="pageNumber"><a href="#tblData">First</a></li>');
            for (i = 1; i < totalPages - 1; i++) {
                //$('<li class="pageNumber">' + (i + 1) + '</li>').appendTo($pages);
                list.append('<li id="' + (i + 1) + '" class="pageNumber"><a href="#tblData">' + (i + 1) + '</a></li>');
            }
            list.append('<li id="' + totalPages + '" class="pageNumber"><a href="#tblData">Last</a></li>');
            // append button div to table
            // might want to switch that to append to outer div instead
            

            // hide all rows 
            $('table').find('tbody tr:has(td)').hide();
            // show the first x rows
            var tr = $('table tbody tr:has(td)');
            for (var i = 0; i <= recordPerPage - 1; i++) {
                $(tr[i]).show();
            }
            $('#pages').find('li').hide();
            var li = $('#pages li');
            for (var i = 0; i <= 9; i++) {
                $(li[i]).show();
            }
            $(li[totalPages-1]).show();
            // show a different group of rows
            $('.pageNumber').click(function(event) {
                // hide all rows
                $('#tblData').find('tbody tr:has(td)').hide();
                // starting row = (span label -1) * records per page  
                var nBegin = ($(this).attr('id') - 1) * recordPerPage;
                // ending row = span label * records per page - 1
                var nEnd = $(this).attr('id') * recordPerPage - 1;
                // show every row in between
                for (var i = nBegin; i <= nEnd; i++) {
                    $(tr[i]).show();
                }
                // hide page options
                $('#pages').find('li').hide();
                var page = Math.max( Math.min( totalPages - 5, $(this).attr('id')), 5)
                var nBegin = page - 5;
                var nEnd = page + 4;
                for (var i = nBegin; i <= nEnd; i++) {
                    $(li[i]).show();
                }
                $(li[0]).show();
                $(li[totalPages-1]).show();
            });
        });

    </script>
</body>
</html>