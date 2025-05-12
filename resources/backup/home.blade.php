@extends('layouts.app')

@section('title', 'Inicio - Sistema de Reservas Premium')

@section('content')
    <!-- Hero Section con Imagen de Fondo -->
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Imagen de fondo con overlay -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');">
            <div class="absolute inset-0 bg-blue-900 opacity-60"></div>
        </div>

        <!-- Contenido principal -->
        <div class="relative container mx-auto px-4 text-center text-white z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 animate-on-scroll">
                <span class="block">Experiencias Exclusivas</span>
                <span class="block mt-2">Reservas Premium</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-on-scroll">
                Descubra la excelencia en cada reserva. Hoteles, restaurantes y locales para eventos excepcionales a su
                alcance.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-on-scroll">
                <a href="#discover"
                    class="px-8 py-4 bg-white text-blue-900 rounded-md hover:bg-gray-100 transition duration-300 font-semibold">
                    Explorar
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-white text-white rounded-md hover:bg-white hover:text-blue-900 transition duration-300 font-semibold">
                    Reservar Ahora
                </a>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Sección de Servicios Premium -->
    <section id="discover" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Servicios Exclusivos</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Descubra nuestra colección de servicios premium, cuidadosamente seleccionados para ofrecerle
                    experiencias inolvidables.
                </p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Hoteles -->
                <div
                    class="group luxury-shadow rounded-xl overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative h-60 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                            alt="Hoteles de lujo"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Hoteles de Lujo</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-gray-600 mb-6">
                            Encuentre y reserve los mejores hoteles para su estancia. Opciones exclusivas con atención
                            personalizada y comodidades de primer nivel.
                        </p>
                        <a href="/hotels"
                            class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition duration-300">
                            <span>Explorar Hoteles</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Restaurantes -->
                <div
                    class="group luxury-shadow rounded-xl overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative h-60 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                            alt="Restaurantes gourmet"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Restaurantes Gourmet</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-gray-600 mb-6">
                            Descubra los mejores restaurantes y reserve su mesa para una experiencia culinaria excepcional.
                            Propuestas gastronómicas de primer nivel.
                        </p>
                        <a href="/restaurants"
                            class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition duration-300">
                            <span>Explorar Restaurantes</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Locales para Eventos -->
                <div
                    class="group luxury-shadow rounded-xl overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative h-60 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                            alt="Locales para eventos"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Locales Exclusivos</h3>
                        </div>
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-gray-600 mb-6">
                            Reserve el lugar perfecto para su próximo evento especial. Espacios elegantes y versátiles para
                            bodas, conferencias o celebraciones privadas.
                        </p>
                        <a href="/venues"
                            class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition duration-300">
                            <span>Explorar Locales</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Características -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">¿Por qué elegirnos?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Nuestro sistema ofrece una experiencia de reservas excepcional, con atención a cada detalle.
                </p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Característica 1 -->
                <div class="text-center p-6">
                    <div class="inline-block p-4 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Selección Exclusiva</h3>
                    <p class="text-gray-600">
                        Alianzas con los mejores establecimientos, cuidadosamente seleccionados para garantizar su
                        satisfacción.
                    </p>
                </div>

                <!-- Característica 2 -->
                <div class="text-center p-6">
                    <div class="inline-block p-4 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Reservas Inmediatas</h3>
                    <p class="text-gray-600">
                        Sistema de reservas en tiempo real con confirmación instantánea para su tranquilidad.
                    </p>
                </div>

                <!-- Característica 3 -->
                <div class="text-center p-6">
                    <div class="inline-block p-4 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Atención Personalizada</h3>
                    <p class="text-gray-600">
                        Servicio de atención al cliente 24/7 para resolver cualquier consulta o solicitud especial.
                    </p>
                </div>

                <!-- Característica 4 -->
                <div class="text-center p-6">
                    <div class="inline-block p-4 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pagos Seguros</h3>
                    <p class="text-gray-600">
                        Sistema de pago encriptado y opciones flexibles para mayor comodidad y seguridad.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Call to Action -->
    <section class="py-20 luxury-gradient text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-8">Reserve con Elegancia y Simplicidad</h2>
            <p class="text-xl mb-10 max-w-3xl mx-auto">
                Disfrute de una experiencia de reserva sin complicaciones. Hoteles exclusivos, restaurantes gourmet y
                locales para eventos especiales en un solo lugar.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="#"
                    class="px-8 py-4 bg-white text-blue-900 rounded-md hover:bg-gray-100 transition duration-300 font-semibold">
                    Crear una Cuenta
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-white text-white rounded-md hover:bg-white hover:text-blue-900 transition duration-300 font-semibold">
                    Descubrir Ofertas
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de Testimonios -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Lo que dicen nuestros clientes</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Experiencias auténticas de quienes han confiado en nuestro servicio.
                </p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Testimonio 1 -->
                <div class="bg-gray-50 p-8 rounded-xl luxury-shadow">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-xl mr-4">
                            JD
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold">Juan Díaz</h4>
                            <p class="text-gray-500">CEO, Empresa Tecnológica</p>
                        </div>
                    </div>
                    <div class="text-yellow-400 flex mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-600 italic">
                        "Organicé una conferencia empresarial a través de este sistema. El proceso fue impecable y el local
                        superó todas nuestras expectativas. Definitivamente volveré a utilizar este servicio."
                    </p>
                </div>

                <!-- Testimonio 2 -->
                <div class="bg-gray-50 p-8 rounded-xl luxury-shadow">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-xl mr-4">
                            MR
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold">María Rodríguez</h4>
                            <p class="text-gray-500">Arquitecta</p>
                        </div>
                    </div>
                    <div class="text-yellow-400 flex mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-600 italic">
                        "La reserva del hotel para nuestra luna de miel fue perfecta. El sistema me permitió especificar
                        todos los detalles y el servicio personalizado hizo de nuestra estancia una experiencia
                        inolvidable."
                    </p>
                </div>

                <!-- Testimonio 3 -->
                <div class="bg-gray-50 p-8 rounded-xl luxury-shadow">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-xl mr-4">
                            CL
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold">Carlos López</h4>
                            <p class="text-gray-500">Gerente Comercial</p>
                        </div>
                    </div>
                    <div class="text-yellow-400 flex mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-600 italic">
                        "La reserva del restaurante fue impecable. El sistema me permitió solicitar una mesa especial para
                        mi aniversario y todo fue perfecto. El servicio al cliente es excepcional."
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Proceso de Reserva -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Proceso Simple y Elegante</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Reserve en cuatro sencillos pasos y disfrute de una experiencia sin complicaciones.
                </p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-6"></div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="relative flex-1 pb-20 md:pb-0">
                    <!-- Línea de conexión para escritorio -->
                    <div class="hidden md:block absolute top-1/4 left-0 right-0 h-1 bg-blue-200 z-0"></div>

                    <!-- Pasos del proceso -->
                    <div class="flex flex-col md:flex-row justify-between relative z-10">
                        <!-- Paso 1 -->
                        <div class="flex flex-col items-center mb-10 md:mb-0">
                            <div
                                class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-600 text-white text-2xl font-bold mb-4">
                                1
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Buscar</h3>
                            <p class="text-gray-600 text-center max-w-xs">
                                Encuentre el servicio ideal utilizando nuestros filtros avanzados.
                            </p>
                        </div>

                        <!-- Paso 2 -->
                        <div class="flex flex-col items-center mb-10 md:mb-0">
                            <div
                                class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-600 text-white text-2xl font-bold mb-4">
                                2
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Seleccionar</h3>
                            <p class="text-gray-600 text-center max-w-xs">
                                Elija la opción que mejor se adapte a sus necesidades.
                            </p>
                        </div>

                        <!-- Paso 3 -->
                        <div class="flex flex-col items-center mb-10 md:mb-0">
                            <div
                                class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-600 text-white text-2xl font-bold mb-4">
                                3
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Reservar</h3>
                            <p class="text-gray-600 text-center max-w-xs">
                                Complete su reserva con nuestro sistema seguro.
                            </p>
                        </div>

                        <!-- Paso 4 -->
                        <div class="flex flex-col items-center">
                            <div
                                class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-600 text-white text-2xl font-bold mb-4">
                                4
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Disfrutar</h3>
                            <p class="text-gray-600 text-center max-w-xs">
                                Reciba su confirmación y disfrute de su experiencia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Newsletter Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-blue-50 rounded-xl p-10 luxury-shadow">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Manténgase Informado</h2>
                    <p class="text-xl text-gray-600">
                        Reciba en su correo electrónico las mejores ofertas y novedades exclusivas.
                    </p>
                </div>
                <form class="flex flex-col md:flex-row gap-4">
                    <input type="email" placeholder="Su correo electrónico"
                        class="flex-grow px-5 py-4 rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <button
                        class="px-8 py-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 font-semibold">
                        Suscribirse
                    </button>
                </form>
                <p class="text-gray-500 text-sm mt-4 text-center">
                    Nos importa su privacidad. Nunca compartiremos su información con terceros.
                </p>
            </div>
        </div>
    </section>
@endsection
