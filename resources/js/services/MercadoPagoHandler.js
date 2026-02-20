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
        // Asignamos la instancia a la propiedad de la clase
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
                throw new Error(data.error || "Error en la petición.");
            }

            if (data.preferenceId && data.publicKey) {
                // Nos aseguramos de inicializar el SDK con la llave del servidor
                await this.init(data.publicKey);
                this.abrirModal(data.preferenceId);
            } else {
                throw new Error(
                    "Faltan datos (preferenceId o publicKey) en la respuesta.",
                );
            }
        } catch (err) {
            console.error("MP Service Error:", err);
            throw err;
        }
    }

    abrirModal(preferenceId) {
        if (!this.mp) {
            throw new Error("MercadoPago no ha sido inicializado.");
        }

        this.mp.checkout({
            preference: {
                id: preferenceId,
            },
            autoOpen: true,
        });
    }
}
