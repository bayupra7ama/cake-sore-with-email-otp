document.addEventListener("DOMContentLoaded", () => {
    /* ======================================================
       CSRF HELPER
    ====================================================== */
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    /* ======================================================
       CART: QTY + / - + REALTIME PRICE
    ====================================================== */

    // Dengarkan klik tombol + -
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("qtybtn")) {
            const proQty = e.target.closest(".pro-qty");
            const input = proQty?.querySelector(".cart-qty");

            if (!input) return;

            // tunggu JS template update value
            setTimeout(() => updateCartRow(input), 50);
        }
    });

    // Manual input qty
    document.querySelectorAll(".cart-qty").forEach((input) => {
        input.addEventListener("keyup", () => updateCartRow(input));
        input.addEventListener("change", () => updateCartRow(input));
    });

    function updateCartRow(input) {
        let qty = parseInt(input.value);
        if (!qty || qty < 1) qty = 1;
        input.value = qty;

        const price = parseInt(input.dataset.price);
        const total = qty * price;

        // Update total per item
        const row = input.closest("tr");
        const totalEl = row?.querySelector(".item-total");
        if (totalEl) {
            totalEl.innerText = total.toLocaleString("id-ID");
        }

        updateCartSubtotal();
        syncCartSession(input.dataset.id, qty);
    }

    function updateCartSubtotal() {
        let subtotal = 0;

        document.querySelectorAll(".item-total").forEach((el) => {
            subtotal += parseInt(el.innerText.replace(/\./g, ""));
        });

        const subtotalEl = document.getElementById("cart-subtotal");
        const totalEl = document.getElementById("cart-total");

        if (subtotalEl)
            subtotalEl.innerText = "Rp " + subtotal.toLocaleString("id-ID");
        if (totalEl)
            totalEl.innerText = "Rp " + subtotal.toLocaleString("id-ID");
    }

    function syncCartSession(id, qty) {
        if (!csrfToken) return;

        fetch(`/user/cart/update/${id}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ quantity: qty }),
        });
    }

    /* ======================================================
       CART: ADD TO CART (DETAIL PAGE)
    ====================================================== */
    const addToCartBtn = document.getElementById("add-to-cart");
    if (addToCartBtn) {
        addToCartBtn.addEventListener("click", (e) => {
            e.preventDefault();

            const qtyInput = document.getElementById("qty");
            const hiddenQty = document.getElementById("qty-hidden");
            const form = document.getElementById("cart-form");

            if (qtyInput && hiddenQty && form) {
                hiddenQty.value = qtyInput.value;
                form.submit();
            }
        });
    }

    /* ======================================================
       PRODUCT DETAIL: SYNC QTY INPUT
    ====================================================== */
    const proQtyInput = document.querySelector(".pro-qty input");
    const hiddenQtyInput = document.getElementById("qty-input");

    if (proQtyInput && hiddenQtyInput) {
        proQtyInput.addEventListener("change", () => {
            hiddenQtyInput.value = proQtyInput.value;
        });
    }

    /* ======================================================
       DELETE IMAGE AJAX
    ====================================================== */
    document.querySelectorAll(".delete-image").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Hapus gambar ini?")) return;

            try {
                const res = await fetch(btn.dataset.url, {
                    method: "DELETE",
                    credentials: "same-origin",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                });

                if (res.ok) {
                    btn.closest("[data-image-id]")?.remove();
                } else {
                    alert("Gagal hapus gambar");
                }
            } catch (err) {
                console.error(err);
                alert("Terjadi kesalahan");
            }
        });
    });

    const modal = document.getElementById("orderModal");
    const orderDetail = document.getElementById("orderDetail");

    // OPEN MODAL
    document.querySelectorAll(".btn-detail").forEach((btn) => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;

            const res = await fetch(`/user/orders/${id}`, {
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (!res.ok) {
                alert("Gagal mengambil detail order");
                return;
            }

            const data = await res.json();

            let html = `
            <li>
                <span>Nama</span>
                <span class="value">${data.name}</span>
            </li>
            <li>
                <span>Phone</span>
                <span class="value">${data.phone}</span>
            </li>
            <li>
                <span>Alamat</span>
                <span class="value">${data.address}</span>
            </li>
            <li>
                <span>Status</span>
                <span class="value">${data.status}</span>
            </li>
            <li>
                <span>Payment</span>
                <span class="value">${data.payment_method}</span>
            </li>
            <li>
                <span>Total</span>
                <span class="value">
                    Rp ${Number(data.total).toLocaleString("id-ID")}
                </span>
            </li>
            
        `;

            html += `<li class="divider"><strong>Produk</strong></li>`;

            data.items.forEach((item) => {
                html += `
                <li>
                    <span>${item.product_name} × ${item.quantity}</span>
                    <span class="value">
                        Rp ${Number(item.subtotal).toLocaleString("id-ID")}
                    </span>
                </li>
            `;
            });

            if (data.payment_proof) {
                html += `
        <li style="flex-direction: column; align-items: flex-start">
            <span><strong>Bukti Pembayaran</strong></span>
            <img 
                src="/storage/${data.payment_proof}" 
                alt="Bukti Pembayaran"
                style="
                    width: 100%;
                    max-width: 300px;
                    margin-top: 8px;
                    border-radius: 8px;
                    border: 1px solid #eee;
                "
            >
        </li>
    `;
            }

            orderDetail.innerHTML = html;
            modal.classList.add("show");
        });
    });
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-close-modal")) {
            const modal = document.getElementById("orderModal");
            if (modal) {
                modal.style.display = "none";
            }
        }
    });

    // CLOSE MODAL (CLICK OVERLAY)
    modal.addEventListener("click", (e) => {
        if (e.target.id === "orderModal") {
            modal.classList.remove("show");
        }
    });

    $(document).ready(function () {
        $(".order-status-carousel").owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            dots: false,
            autoWidth: true,
            navText: [
                "<span class='icon_carrot-left'></span>",
                "<span class='icon_carrot-right'></span>",
            ],
            responsive: {
                0: { items: 2 },
                600: { items: 4 },
                1000: { items: 6 },
            },
        });
    });
});
