
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="main.css" type="text/css" />

<style>
    thead th{
        background-color:lightgrey;
        color:white;
        font-size:25px;
    }
</style>
    </head>

    <body>

        <div class="main">

            <div id="headerWrapper"><h1>Zoom The Pic Of Your Favorite Game Hero</h1>
                <div id="idselected"></div>
            </div>

                <div>

                Show <span><select>

                    <option value="0">select</option>
                    <option value="10">10</option>
                    <option value="100">100</option>
                    <option value="300">300</option>
                    <option value="All">All</option>
                </select></span> Entries
                
                </div>
                <hr>
                <div id="container"></div><!-- here starts the table-->

                <script>
                 
                    var entries = 0;

                     $(function () {
                        
                        $('select').on('change', function () {
                            entries = this.value;
                            
                            if(entries!=="0"){
                               $('select').remove();
                            }
                            
                            $("span").text(entries);
                             $('<div />')
                            .attr('class', "loader")      
                            .appendTo($('#container'));

                            display(entries);
                            
                             });
                        });
 
                function display(entries){
                    var obj = "";
                    var url = "api.php";
                    $.ajax({
                        url: url,
                        method: 'POST',
                    }).done(function (result) {
                        obj = JSON.parse(result);
                        //  console.log(obj);Object.keys(obj.amiibo).length
                        tbl = $('<table></table>').attr({class: 'table'});
                        thead = $('<thead/>').appendTo(tbl);
                        var tr = $('<tr></tr>').attr({class:
                                        ["class1", "class2", "class3", "class4", "class5"]
                                        .join(' ')}).appendTo(tbl);
                         $('<th></th>').text("amiiboSeries").appendTo(tr);
                         $('<th></th>').text("character").appendTo(tr);
                         $('<th></th>').text("gameSeries").appendTo(tr);
                         $('<th></th>').text("image").appendTo(tr);
                        tr.appendTo(thead);
                     

                        if(entries=="All"){
                            entries=Object.keys(obj.amiibo).length;
                        }
                        $("#container div:last-child").remove();//remove the loading
                        
                        for (var i = 0; i < entries; i++) {
                            var $name = obj.amiibo[i]['name'];
                            var $img = obj.amiibo[i]['image'];
                            var $series = obj.amiibo[i]['amiiboSeries'];
                            var $character = obj.amiibo[i]['character'];
                            var $gameSeries = obj.amiibo[i]['gameSeries'];
                            var $inputName = $('<input>').attr({
                                type: 'hidden',
                                id: i,
                                name: i,
                                value: $name
                            });

                            var row = $('<tr></tr>').attr({class:
                                        ["class1", "class2", "class3", "class4", "class5"]
                                        .join(' ')}).appendTo(tbl);
                           
                            $('<td></td>').text($character).appendTo(row);
                            $('<td></td>').text($gameSeries).appendTo(row);
                            $('<td></td>').text($name).appendTo(row);

                            $('<td></td>').prepend($('<img >').
                                    attr({src: $img, id: i, 'width': '50', class: 'zoom'}).
                                    text("image")).append($inputName).appendTo(row);

                            tbl.appendTo($("#container"));

                        }

                    }).fail(function (err) {
                        throw err;
                    });

                    $('#container').on('mouseover', 'img', function (e) {

                        var id = e.currentTarget.id;
                        $.ajax({
                            type: "post",
                            url: "countTimes.php",
                            dataType: "text",
                            data: {"id": id},
                            success: function (data) {

                                $("#idselected").text("Name: " + JSON.parse(data).name +
                                        ", Searched Times: " + JSON.parse(data).searchedTimes + "");

                            },
                            complete: function (data, status) { //optional, used for debugging purposes
                                //  alert(status);
                            }

                        });//AJAX

                    });
                } 

                </script>
            </div>
        </div> 
    </body>
</html>
