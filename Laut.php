<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="data/style.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.9.0/css/ol.css" type="text/css">
    <style>
        .map {
            height: 875px;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.9.0/build/ol.js"></script>
    <title>OpenLayers example</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <!-- Favicon -->
  <link rel="icon" href="assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body>
    <h2>My Map</h2>
     <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="examples/dashboard.html">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">All</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="ni ni-planet text-orange"></i>
                <span class="nav-link-text">Laut</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="examples/map.html">
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">Danau</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="examples/profile.html">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">Sungai</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="examples/tables.html">
                <i class="ni ni-bullet-list-67 text-default"></i>
                <span class="nav-link-text">Waduk</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="examples/login.html">
                <i class="ni ni-key-25 text-info"></i>
                <span class="nav-link-text">Login</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="examples/register.html">
                <i class="ni ni-circle-08 text-pink"></i>
                <span class="nav-link-text">Register</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="examples/upgrade.html">
                <i class="ni ni-send text-dark"></i>
                <span class="nav-link-text">Upgrade</span>
              </a>
            </li> -->
          </ul>
        
        </div>
      </div>
    </div>
  </nav>
    <div id="map" class="map"></div>

    <!-- Membuat Fitur PopUp -->
    <div class="ol-popup" id="popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>
    <!-- End PopUp-->

    <script type="text/javascript">
        // Membuat variabel untuk ditampilkan di layer
        var layerLaut = new ol.layer.Vector({
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: 'data/hasilLaut.json' // PATH FILE JSON
            }),
            //membuat icon
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 46],
                    anchorXUnits: 'flaticon',
                    anchorYUnits: 'pixels',
                    src: 'icon/location.png' // PATH FILE icon
                })
            })
            //end
        });
        //end
        // Membuat variabel untuk ditampilkan di layer
        var layerKalimantan = new ol.layer.Vector({
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: 'data/kalimantan.json' // PATH FILE JSON
            })
        });
      
        //end
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }), layerKalimantan, layerLaut
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([117.153709, -0.502106]),
                zoom: 6
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
                var content = '<img src="' + feature.get('Link_Foto')+ '" style="width:auto; height:300px"  />';
                content += '<h5> Nama Daerah : ' + feature.get('Nama_Kota_') + '</h5>';
                content += '<h5> Laut : ' + feature.get('Laut__Kg_') + ' kg</h5>';
                
                content_element.innerHTML = content;
                overlay.setPosition(coord);
                console.info(feature.getProperties());
            }
        });
            //end
    </script>


    <!-- End Script PopUp -->
</body>
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="assets/js/argon.js?v=1.2.0"></script>
</html>