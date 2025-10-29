function getLocation() {       
            if (!navigator.geolocation) {
                alert('Geolocalização não é suportada pelo seu navegador.');
                return;
            }

            const opcoes = {
                enableHighAccuracy: true,    // Alta precisão
                timeout: 5000,             // 10 segundos de timeout
                maximumAge: 0               // Não usar cache
            };

            navigator.geolocation.getCurrentPosition(
                // Success
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const precision = position.coords.accuracy;
                    
                    addToFields(lat, lng);
                },
                // Error
                function() {
                    alert('Some unexpected error happened')
                },
                // Options
                opcoes
            );
        }

function addToFields(lat, lng){
    document.getElementById('lat').value = lat;
    document.getElementById('lon').value = lng;
}