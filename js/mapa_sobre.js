var map;
var directionsDisplay;
// Instanciaremos ele mais tarde, que será o nosso google.maps.DirectionsRenderer
var directionsService = new google.maps.DirectionsService();
directionsDisplay = new google.maps.DirectionsRenderer();
// Instanciando...
var latlng = new google.maps.LatLng(-29.718668, -53.729318);

var options = {
    zoom: 16,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.SATELLITE
};

// Relacionamos o directionsDisplay com o mapa desejado
map = new google.maps.Map(document.getElementById("mapa"), options);
directionsDisplay.setMap(map);
directionsDisplay.setPanel(document.getElementById("trajeto-texto")); // Aqui faço a definição


$("form").submit(function (event) {
    event.preventDefault();

    var enderecoPartida = $("#txtEnderecoPartida").val();
    var enderecoChegada = $("#txtEnderecoChegada").val();

    var request = { // Novo objeto google.maps.DirectionsRequest, contendo:
        origin: enderecoPartida, // origem
        destination: enderecoChegada, // destino
        travelMode: google.maps.TravelMode.DRIVING // meio de transporte, nesse caso, de carro
    };

    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) { // Se deu tudo certo
            directionsDisplay.setDirections(result); // Renderizamos no mapa o resultado
        }
        else {
            alert("Local de partida não encontrado.")
        }
    });
});
var x = document.getElementById("txtEnderecoPartida");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    x.innerHTML = position.coords.latitude + ", " + position.coords.longitude;
}