<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">Nueva Reserva</h2>
    </x-slot>

    <!-- Enlace al archivo CSS -->
    <link href="{{ asset('css/reservationStyles.css') }}" rel="stylesheet">

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Título con ícono -->
        <div class="mb-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="form-title">Realiza tu reserva</h3>
            </div>
            <p class="form-subtitle">Completa los detalles de la reserva y paga al instante.</p>
        </div>

        <!-- Contenedor Principal - Grid de 2 columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imagen de la Habitación (izquierda) -->
            <div>
                <div class="sticky top-6">
                    <div class="image-preview bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="relative">
                            <img src="{{ asset('img/image.png') }}" alt="Habitación de lujo" class="w-full h-64 lg:h-96 object-cover">
                            <div class="absolute top-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                Disponible
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Suite Deluxe</h4>
                            <p class="text-gray-600 mb-4">Habitación de pareja con todas las comodidades modernas. Incluye desayuno buffet, wifi de alta velocidad, y vista panorámica.</p>
                            
                            <!-- Características destacadas -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Vista al mar
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                    </svg>
                                    WiFi gratis
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M7 13v8m10-8v8m-9-8h2m6 0h2"></path>
                                    </svg>
                                    Minibar
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Check-in 24h
                                </div>
                            </div>
                            
                            <!-- Precio -->
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Precio por noche</span>
                                    <span class="text-2xl font-bold text-indigo-600">s/ 199</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario (derecha) -->
            <div>
                <form method="POST" action="{{ route('reservations.store') }}" class="space-y-6 container-form">
                    @csrf
                    
                    <!-- Progress Steps -->
                    <div class="steps-indicator mb-8">
                        <div class="flex justify-between items-center">
                            <div class="step active">
                                <div class="step-number">1</div>
                                <div class="step-title">Detalles de la reserva</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-title">Confirmación y pago</div>
                            </div>
                        </div>
                    </div>

                    <!-- ID de Habitación -->
                    <div class="form-field">
                        <label for="reservable_id" class="form-label">ID de Habitación</label>
                        <div class="relative">
                            <input type="number" name="reservable_id" id="reservable_id" class="form-input" placeholder="Ej. 101" required>
                            <div class="input-icon">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Fechas de Entrada y Salida -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-field">
                            <label for="check_in" class="form-label">Fecha de Entrada</label>
                            <div class="relative">
                                <input type="datetime-local" name="check_in" id="check_in" class="form-input" required>
                                <div class="input-icon">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="check_out" class="form-label">Fecha de Salida</label>
                            <div class="relative">
                                <input type="datetime-local" name="check_out" id="check_out" class="form-input" required>
                                <div class="input-icon">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Número de Huéspedes -->
                    <div class="form-field">
                        <label for="guests" class="form-label">Número de Huéspedes</label>
                        <div class="relative">
                            <input type="number" name="guests" id="guests" class="form-input" placeholder="¿Cuántas personas?" required min="1" max="4">
                            <div class="input-icon">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Máximo 4 personas por habitación</p>
                    </div>

                    <!-- Solicitudes Especiales -->
                    <div class="form-field">
                        <label for="special_requests" class="form-label">Solicitudes Especiales</label>
                        <div class="relative">
                            <textarea name="special_requests" id="special_requests" class="form-input h-32" placeholder="¿Necesitas algo especial? Cuéntanos aquí..."></textarea>
                            <div class="input-icon top-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Ejemplos: cuna para bebé, piso alto, almohadas extra</p>
                    </div>

                    <!-- Resumen de precios -->
                    <div class="price-summary">
                        <h4 class="text-lg font-semibold mb-4">Resumen de precios</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Precio por noche</span>
                                <span>s/ 199</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Número de noches</span>
                                <span id="nights-count">0</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Impuestos y tasas</span>
                                <span>s/ 25</span>
                            </div>
                            <div class="border-t pt-2 mt-2">
                                <div class="flex justify-between font-bold text-lg">
                                    <span>Total</span>
                                    <span id="total-price">s/ 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Envío -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('dashboard') }}" class="cancel-btn">
                            Cancelar
                        </a>
                        <button type="submit" class="submit-btn">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M7 13v8m10-8v8m-9-8h2m6 0h2"></path>
                            </svg>
                            Reservar y Pagar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para cálculo de precios -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkIn = document.getElementById('check_in');
            const checkOut = document.getElementById('check_out');
            const nightsCount = document.getElementById('nights-count');
            const totalPrice = document.getElementById('total-price');
            const pricePerNight = 199;
            const taxes = 25;

            function calculateTotal() {
                if (checkIn.value && checkOut.value) {
                    const startDate = new Date(checkIn.value);
                    const endDate = new Date(checkOut.value);
                    const diffTime = Math.abs(endDate - startDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    if (diffDays > 0) {
                        nightsCount.textContent = diffDays;
                        const total = (pricePerNight * diffDays) + taxes;
                        totalPrice.textContent = 's/ ' + total;
                    } else {
                        nightsCount.textContent = '0';
                        totalPrice.textContent = 's/ 0';
                    }
                }
            }

            checkIn.addEventListener('change', calculateTotal);
            checkOut.addEventListener('change', calculateTotal);
        });
    </script>
</x-app-layout>