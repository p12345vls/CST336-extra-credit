
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
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.loader{
  position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -50px;
    margin-left: -50px;
    width: 100px;
    height: 100px;
}
</style>
    </head>

    <body>

        <div class="main">

            <div id="headerWrapper"><h1>Zoom The Pic Of Your Favorite Game Hero</h1>
                <div id="idselected"></div>
            </div>

            <div class="container">
                Show<select>

                    <option value="0">select</option>
                    <option value="10">10</option>
                    <option value="100">100</option>
                    <option value="300">300</option>
                    <option value="All">All</option>
                </select>Entries
                <hr>
                <div id="container"></div><!-- here starts the table-->


                <script>
                    var entries = 0;
                    
                            
                            
                     $(function () {
                        $('select').on('change', function () {
                            entries = this.value;
                             $('<div />')
                            .attr('class', "loader")        // ADD IMAGE PROPERTIES.
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

                        if(entries=="All"){
                            entries=Object.keys(obj.amiibo).length;
                        }
                        $("#container div:last-child").remove();
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
                            $('<td></td>').text($series).appendTo(row);
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
