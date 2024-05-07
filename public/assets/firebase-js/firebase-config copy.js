$(document).ready(function () {
    const config = {
        apiKey: "AIzaSyDkweC7Ua52jliddO-ftQvZ0bYxtZnHYEg",
        authDomain: "realtime-gps-test.firebaseapp.com",
        databaseURL: "https://realtime-gps-test-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "realtime-gps-test",
        storageBucket: "realtime-gps-test.appspot.com",
        messagingSenderId: "752926122591",
        appId: "1:752926122591:web:5a46add86b11b8f21731ea"
    };
    firebase.initializeApp(config); //inicializamos firebase
    // console.log('lol');
});

const getAllTralvelHistory = (device_code) => {
    $('#travel_list_datatable').modal({
        backdrop: 'static',
        keyboard: true
    }).modal('show');
}

const proceedToTracker = (device_code,start) => {

    // alert(device_code);
    const deviceData = { d_code: device_code, start_at: start };
    const url = `location-mapping?${new URLSearchParams(deviceData).toString()}`;
    window.open(url, "_blank", "menubar=no,scrollbars=yes,resizable=yes,top=500,fullscreen=yes");    
}

const navigateMap = (device_code,start) => {
    
    var db = firebase.database();
    const ref = db.ref('/');
        // ref.once('value', (snapshot) => {
        // console.log('Firebase Realtime Database connection status: Connected');
        // }, (error) => {
        // console.error('Firebase Realtime Database connection status: Disconnected');
        // });

    
    var collectionDataPerDevice = db.ref().child(device_code +'/'+ start +'/2-push');
    // console.log(collectionDataPerDevice);
    var collectionDataPerDeviceDash = db.ref(device_code +'/'+ start +'/1-set');
    // const coordinateCollection = [];
    // console.log(collectionDataPerDevice);
    // $('#device_code_input').modal('hide')
    // console.log(collectionDataPerDevice);

    function updateLine(coordinates) {
        // map.getSource('line').setData({
        //   type: 'Feature',
        //   properties: {},
        //   geometry: {
        //     type: 'LineString',
        //     coordinates: coordinates,
        //   },
        // });
        map.getSource('line').setData({
            type: 'FeatureCollection',
            features: [coordinates]
        });
      }

      
    collectionDataPerDevice.on("child_added", data => {
        // alert('log');
        dataSet = [data.child("long").val(), data.child("lat").val()];
        // coordinateCollection.push(dataSet);
        
        var newLineData = {
            type: 'Feature',
            geometry: {
              type: 'LineString',
              coordinates: [dataSet]
            }
          };
          
          updateLine(newLineData);
        //   console.log(newLineData);
        // map.getSource('line').setData({
        //     type: 'FeatureCollection',
        //     features: [newLineData]
        // });
        loadingIndicator.style.display = 'none';
        // console.log(dataSet);
    }, function (error) {
        console.log("Error: " + error.code);
    });
   

    collectionDataPerDeviceDash.on('value', function (snapshot) {
        // snapshot.forEach(function(childSnapshot) {
        var coordinates = '@' + snapshot.child("long").val() + ", " + snapshot.child("lat").val();
        var _timestamp = '@' + snapshot.child("timestamp").val();
        // console.log(_timestamp);
        $('#realtime_location_dash').text(coordinates);
        $('#last_trip_timestamp').text(_timestamp);
        // });
    });

    // collectionDataPerDeviceDash.on("value", function (snapshot) {

    // }, function (error) {
    //     console.log("Error: " + error.code);
    // });

    mapboxgl.accessToken = 'pk.eyJ1IjoianZuLWNncyIsImEiOiJjbGhqdzd6ZnYwbTJ1M2xueGI1OHFqbG5mIn0.4th0lCrUn9MoXPsGM9UqZw';
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        // center: [
        //     121.28285416666667, 14.1854495
        // ],
        zoom: 14
    });
    // console.log(coordinateCollection);
    map.on('load', () => {
        // map.addSource('route', {
        //     'type': 'geojson',
        //     'data': {
        //         'type': 'Feature',
        //         'properties': {},
        //         'geometry': {
        //             'type': 'LineString',
        //             'coordinates': coordinateCollection
        //         }
        //     }
        // });

        map.addSource('line', {
            type: 'geojson',
            data: {
              type: 'Feature',
              features: []
            }
          });
        
          

        const el = document.createElement('div');
        const width = 50;
        const height = 50;
        el.className = 'marker';
        el.style.backgroundImage = "url(https://placekitten.com/g/${width}/${height}/)";
        el.style.width = `${width}px`;
        el.style.height = `${height}px`;
        el.style.backgroundSize = '100%';
        //Create Map Layer
        const marker1 = new mapboxgl.Marker();
        collectionDataPerDeviceDash.on('value', function (snapshot) {
            var long = snapshot.child("long").val();
            var lat = snapshot.child("lat").val();
            marker1.setLngLat([long, lat])
            .addTo(map);
            map.jumpTo({ center: [long, lat] })
        });
       

        map.addLayer({
            'id': 'route',
            'type': 'line',
            'source': 'route',
            'layout': {
                'line-join': 'round',
                'line-cap': 'round'
            },
            'paint': {
                'line-color': '#888',
                'line-width': 8
            }
        });
        // map.addLayer({
        //     id: 'line',
        //     type: 'line',
        //     source: 'line',
        //     layout: {
        //       'line-join': 'round',
        //       'line-cap': 'round',
        //     },
        //     paint: {
        //       'line-color': '#ff0000',
        //       'line-width': 3,
        //     },
        //   });
    });
}


(function($) {
    $.fn.buttonLoader = function(action) {
    var self = $(this);
    //start loading animation
    if (action == 'start') {
        if ($(self).attr("disabled") == "disabled") {
        e.preventDefault();
        }
        //disable buttons when loading state
        $('.has-spinner').attr("disabled", "disabled");
        $(self).attr('data-btn-text', $(self).text());
        //binding spinner element to button and changing button text
        $(self).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="sr-only">Loading...</span>`);
        $(self).addClass('active');
    }
    //stop loading animation
    if (action == 'stop') {
        $(self).html($(self).attr('data-btn-text'));
        $(self).removeClass('active');
        //enable buttons after finish loading
        $('.has-spinner').removeAttr("disabled");
    }
    }
})(jQuery);
$(document).ready(function() {
    $("#device_form").validate({
        rules: {
            txt_device_id: "required",
        },
        messages: {
            txt_device_id: "Please enter plate/mv-file number",
        },
        onfocusout: function(e) {
            this.element(e);
        },
        onkeyup: false,
        highlight: function(element, errorClass, validClass) {
            jQuery(element).closest('.form-control').addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            jQuery(element).closest('.form-control').removeClass('is-invalid');
            jQuery(element).closest('.form-control').addClass('is-valid');
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group-prepend').length) {
                $(element).siblings(".invalid-feedback").append(error);
                //error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var formData = new FormData($("#device_form").get(0));
            $.ajax({
                url: '/vehicle-has-device',
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "JSON",
                beforeSend: function() {
                    // processObject.showProcessLoader();
                    $('#btn_device_verify').buttonLoader('start');
                },
                success: function(data) {
                    console.log();
                    if (data.success) {
                        // console.log(data.data.device_id);
                        Swal.fire({
                            title: "Device successfully verified! .",
                            icon: 'success',
                            html: data.messages,
                            type: "success",
                        });
                        // console.log(data.data[0].device_id);
                        getTravelList(data.data[0].device_id);
                        console.log(data.data[0].device_id);
                        $('#device_code_input').modal('hide');
                    //  proceedToTracker(data.data[0].device_id);
                    } else {
                        Swal.fire({
                            title: "No record found! .",
                            icon: 'warning',
                            html: data.messages,
                            type: "error",
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire({
                        title: "Oops! something went wrong.",
                        html: "<b>" + errorThrown +
                            "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                        type: "error",
                        footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                    });
                },
                complete: function() {
                    $('#btn_device_verify').buttonLoader('stop');
                },
            });
        }
    });
});
