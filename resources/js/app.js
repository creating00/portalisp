import "./bootstrap";
import MercadoPagoHandler from "./services/MercadoPagoHandler";

// Instanciamos el servicio
const mpHandler = new MercadoPagoHandler();

// Lo exponemos al objeto window para que el HTML/Volt pueda acceder
window.iniciarPago = (facturaId) => {
    // Podemos añadir un feedback visual aquí si fuera necesario
    mpHandler.pagarFactura(facturaId).catch((err) => {
        alert("Error de pago: " + err.message);
    });
};
