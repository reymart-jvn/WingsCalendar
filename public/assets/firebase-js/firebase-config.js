const getAllTralvelHistory = (device_code) => {
    $('#travel_list_datatable').modal({
        backdrop: 'static',
        keyboard: true
    }).modal('show');
}

const proceedToTracker = (device_code, start, driver_name) => {

    // alert(device_code);

    const deviceData = { d_code: device_code, start_at: start, d_name: driver_name };
    const url = `location-mapping?${new URLSearchParams(deviceData).toString()}`;
    window.open(url, "_blank", "menubar=no,scrollbars=yes,resizable=yes,top=500,fullscreen=yes");
}

// Create an empty GeoJSON feature collection
const geojson = {
    type: 'FeatureCollection',
    features: []
};


// Update the line with new coordinates
// Function to show the loading overlay
const showLoadingOverlay = () => {
    document.getElementById('loadingOverlay').style.display = 'flex';
};

// Function to hide the loading overlay
const hideLoadingOverlay = () => {
    document.getElementById('loadingOverlay').style.display = 'none';
};
const navigateMap = (device_code, start, driver_name) => {
    let marker = null;
    let historicalMarkers = [];
    let lineCoordinates = [];

    var db = firebase.database();
    const ref = db.ref('/');
    var collectionDataPerDevice = db.ref().child(device_code + '/' + start + '/2-push');
    var collectionDataPerDeviceDash = db.ref(device_code + '/' + start + '/1-set');
    // console.log(db.ref(device_code +'/'+ start +'/1-set/long'));
    const initialLocation = [121.2831761, 14.1942478];
    mapboxgl.accessToken = 'pk.eyJ1IjoianZuLWNncyIsImEiOiJjbGhqdzd6ZnYwbTJ1M2xueGI1OHFqbG5mIn0.4th0lCrUn9MoXPsGM9UqZw';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: initialLocation, // Set your desired center coordinates
        zoom: 12, // Set the initial zoom level
    });
    // Function to update the map location

    const updateMapLocation = (longitude, latitude) => {
        map.flyTo({ center: [longitude, latitude], zoom: 12 });
    };
    // Create a custom marker using the custom marker GIF
    function createCustomMarker() {

        const img = new Image(50, 50);
        // img.src = pointer; // Replace with the URL to your custom marker GIF
        img.src = assetUrl;
        img.classList.add('blinking-marker');
        return img;
    }

    // // Create a historical marker using a different GIF
    // function createHistoricalMarker() {
    //     const img = new Image(10, 10);
    //     img.src = point; // Replace with the URL to your historical marker GIF
    //     return img;
    // }

    // Create a data source with the empty GeoJSON
    map.on('load', function() {
        map.addSource('line', {
            type: 'geojson',
            data: {
                type: 'Feature',
                geometry: {
                    type: 'LineString',
                    coordinates: [],
                },
            },
        });

        map.addLayer({
            id: 'line',
            type: 'line',
            source: 'line',
            paint: {
                'line-color': '#ff0000',
                'line-width': 3,
            },
        });
        // Retrieve coordinates from Firebase and update the line
        const coordinatesRef = db.ref().child(device_code + '/' + start + '/2-push');
        coordinatesRef.on("child_added", data => {
            coordinates = [data.child("long").val(), data.child("lat").val()];
            // console.log(coordinates);
            const historicalCoordinate = coordinates[coordinates.length - 2];
            hideLoadingOverlay();
            if (coordinates && coordinates.length > 0) {
                geojson.features = [{
                    type: 'Feature',
                    geometry: {
                        type: 'LineString',
                        coordinates: coordinates
                    }
                }];
                // const currentCoordinate = [coordinates.long, coordinates.lat];
                lineCoordinates.push(coordinates);
                updateMapLocation(data.child("long").val(), data.child("lat").val());
                // addLineMarker(coordinates);
            } else {
                // If coordinates are null or empty, clear the line
                geojson.features = [];
            }
            if (marker) {
                marker.setLngLat(coordinates);
            } else {
                // marker = new mapboxgl.Marker().setLngLat(coordinates).addTo(map);
                marker = new mapboxgl.Marker({ element: createCustomMarker() }).setLngLat(coordinates).addTo(map);
            }

            // // Show historical marker if there's a previous point
            // if (lineCoordinates.length >= 2) {
            //     const historicalCoordinate = lineCoordinates[lineCoordinates.length - 2];
            //     if (historicalMarkers.length > 0) {
            //         for (const marker of historicalMarkers) {
            //             marker.remove();
            //         }
            //     }

            //     const popup = new mapboxgl.Popup({ offset: 25 }).setText('Historical Point');
            //     const historicalMarker = new mapboxgl.Marker({ element: createHistoricalMarker() })
            //         .setLngLat(historicalCoordinate)
            //         .setPopup(popup)
            //         .addTo(map);

            //     historicalMarkers.push(historicalMarker);
            // }
            // map.getSource('line').setData(geojson);
        }, function(error) {
            console.log("Error: " + error.code);
        });

    });
    $('#map_location').text(device_code);
    $('#vehicle_driver').text(driver_name);
    //display long lat
    collectionDataPerDeviceDash.on('value', function(snapshot) {
        // snapshot.forEach(function(childSnapshot) {
        var coordinates = '@' + snapshot.child("long").val() + ", " + snapshot.child("lat").val();
        var _timestamp = '@' + snapshot.child("timestamp").val();
        // console.log(_timestamp);
        $('#realtime_location_dash').text(coordinates);
        $('#last_trip_timestamp').text(_timestamp);
        // });
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
                        // console.log(data.data[0].device_id);
                        // $('#device_code_input').modal('hide');
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