require(['jquery'], function($) {
    $(document).ready(function() {
        const path = window.location.pathname; // "/referral/management/edit/2"

        // Separar por "/"
        const parts = path.split('/'); // ["", "referral", "management", "edit", "2"]

        // El último segmento
        const id = parts[parts.length - 1];

        console.log('ID obtenido:', id); // "2"
    });
});
