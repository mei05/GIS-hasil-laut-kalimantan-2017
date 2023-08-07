<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="data/style.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.9.0/css/ol.css" type="text/css">
    <style>
        .map {
            height: 600px;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.9.0/build/ol.js"></script>
    <title>OpenLayers example</title>
</head>

<body>
    <h2>My Map</h2>
    <div id="map" class="map"></div>

    <!-- Membuat Fitur PopUp -->
    <div class="ol-popup" id="popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>
    <!-- End PopUp-->

    <script type="text/javascript">
        // Membuat variabel untuk ditampilkan di layer
        var layerBanjir = new ol.layer.Vector({
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: 'data/JSONPerikanan.json' // PATH FILE JSON
            }),
            //membuat icon
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 46],
                    anchorXUnits: 'flaticon',
                    anchorYUnits: 'pixels',
                    src: 'icon/flood.png' // PATH FILE icon
                })
            })
            //end
        });
        //end
        // Membuat variabel untuk ditampilkan di layer
        var layerRiau = new ol.layer.Vector({
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: 'data/polygon_riau.json' // PATH FILE JSON
            })
        });
        //end
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }), layerRiau, layerBanjir
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([101.438309, 0.510440]),
                zoom: 10
            })
        });
    </script>


    <!-- Script untuk PopUp -->
    <script type="text/javascript">
        var container = document.getElementById('popup'),
            content_element = document.getElementById('popup-content')
        closer = document.getElementById('popup-closer');

        //membuat close popup
        closer.onclick = function() { 
            overlay.setPosition(undefined);
            closer.blur();
            return false;
        };
        //end popup
        //membuat overlay
        var overlay = new ol.Overlay({
            element: container,
            autoPan: true,
            offset: [0, -10]
        });
        //end overlay

        map.addOverlay(overlay); //menambahkan overlay ke dalam map
        var FullScreen = new ol.control.FullScreen();
        map.addControl(FullScreen);
            //kalau icon kita di klik
        map.on('click', function(evt) { 
            var feature = map.forEachFeatureAtPixel(evt.pixel,
                function(feature, Layer) {
                    return feature;
                });
            //end    
            // jika featurenya ada 
            if (feature) {
                var geometry = feature.getGeometry();
                var coord = geometry.getCoordinates();
                var content = '<h2> Nama Daerah : ' + feature.get('Nama_Pemetaan') + '</h2>';
                content += '<h2> Jumlah Korban : ' + feature.get('Jumlah_Korban') + '</h2>';

                content_element.innerHTML = content;
                overlay.setPosition(coord);
                console.info(feature.getProperties());
            }
        });
            //end
    </script>


    <!-- End Script PopUp -->
</body>

</html>