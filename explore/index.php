<!DOCTYPE html>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
        <script src="epoch/epoch.min.js"></script>
        <link rel="stylesheet" type="text/css" href="epoch/epoch.min.css">

    </head>
    <body>
        <h1>Real-time Stream Graphic</h1>

        <div id="chart">
            <div class="epoch" style="width:320px; height: 240px;"></div>
            <p><button>Play</button></p>
        </div>

        <button onclick="reconnect()">Reconnect</button>

        <script>
        function getTimeValue() {
            var dateBuffer = new Date();
            var Time = dateBuffer.getTime();
            return Time;
        }

        function updateChart(barInstance, yValue) {
            var newBarChartData = [{time: getTimeValue(), y: yValue}];
            barInstance.push(newBarChartData);
        }

        var barChartData = [{
            label: "Series 1",
            values: [{
                time: getTimeValue(),
                y: 0
            }]
        }, ];

        var barChartInstance = $('#chart .epoch').epoch({
            type: 'time.bar',
            axes: ['right', 'bottom', 'left'],
            data: barChartData
        });

        $('#chart button').on('click', function(e) {
            updateChart(barChartInstance, Math.random() * 100);
        });
        </script>

        <!-- Websocket -->
        <script type="text/javascript">

        // Config
        var port = 9000;
        var host = "ws://35.237.134.41:"+port; // No need to change this if using localhost

        //Declare Variables
        var socket;
        var explodedValues = [0,0,0,0]; //initial value for the plot = 0

        function init() {
            try {
                socket = new WebSocket(host);
                console.log('WebSocket status '+socket.readyState);
                socket.onopen = function(msg) {
                    console.log("Welcome - status "+this.readyState);
                };
                socket.onmessage = function(msg) {
                    console.log("Message Received: "+msg.data);
                    explodedValues = msg.data.split(';');
                    //console.log("Separate Values: "+explodedValues);

                    //convert strings to numbers
                    for(var i=0; i<explodedValues.length; i++) { explodedValues[i] = +explodedValues[i]; }

                    updateChart(barChartInstance, msg.data);
                };
                socket.onclose = function(msg) {
                    console.log("Disconnected - status "+this.readyState);
                };
            } catch(ex) {
                console.log(ex);
            }
        }

        function quit(){
            if (socket != null) {
                console.log("Close Socket");
                socket.close();
                socket=null;
            }
        }

        function reconnect() {
            quit();
            init();
        }

        </script>
    </body>
</html>