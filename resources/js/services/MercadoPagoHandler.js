import { loadMercadoPago } from "@mercadopago/sdk-js";

export default class MercadoPagoHandler {
    constructor() {
        this.mp = null;
        this.scriptLoaded = false;
    }

    async init(publicKey) {
        if (!this.scriptLoaded) {
            await loadMercadoPago();
            this.scriptLoaded = true;
        }
        this.mp = new window.MercadoPago(publicKey);
    }

    async pagarFactura(facturaId) {
        try {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            const response = await fetch("/pagos/mercadopago/preferencia", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: JSON.stringify({ factura_id: facturaId }),
            });

            const data = await response.json();

            if (!response.ok || data.error) {
                throw new Error(data.error || "No se pudo generar el enlace.");
            }

            // Prioridad de redirección:
            // Si el servidor detecta credenciales TEST, enviará sandbox_init_point.
            const redirectUrl = data.sandbox_init_point || data.init_point;

            if (redirectUrl) {
                console.log("Redirigiendo a Mercado Pago...");
                window.location.href = redirectUrl;
            } else {
                throw new Error(
                    "El servidor no proporcionó una URL de pago válida.",
                );
            }
        } catch (err) {
            console.error("MP Service Error:", err);
            throw err;
        }
    }
}
