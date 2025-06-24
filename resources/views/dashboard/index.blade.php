<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='alt-dashboard' />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Dashboard" />

        <div class="container-fluid py-4">

            <!-- Selector de mes -->
            <!-- <form method="GET" action="{{ route('alt-dashboard') }}" class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <label for="mes" class="form-label">Seleccionar mes:</label>
                        <select name="mes" id="mes" class="form-select" onchange="this.form.submit()">
                            @foreach ($meses as $num => $nombre)
                                <option value="{{ $num }}" {{ $mesSeleccionado == $num ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form> -->

            <!-- Cards -->
            <div class="row">
                <!-- Ventas del Mes -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">attach_money</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">
                                    Ventas en
                                    {{ (isset($mesSeleccionado) && array_key_exists($mesSeleccionado, $meses)) ? $meses[$mesSeleccionado] : 'Mes inválido' }}
                                </p>
                                <h4 class="mb-0">${{ number_format($ventasMensuales, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ventas Anuales -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">bar_chart</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Ventas del Año</p>
                                <h4 class="mb-0">${{ number_format($ventasAnuales, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clientes Totales -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-faded-primary shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">groups</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes Totales</p>
                                <h4 class="mb-0">{{ $clientesTotales }}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Clientes pendientes -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-warning shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">schedule</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes pendientes</p>
                                <h4 class="mb-0">{{ $clientesPendientesPago  }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-xl-3 col-sm-6 mb-4"> </div> -->

                <!-- Clientes con Deuda -->
                <!-- <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">priority_high</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes con deuda</p>
                                <h4 class="mb-0">{{ $clientesConDeuda }}</h4>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Clientes que pagaron -->
                <!-- <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">check_circle</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Clientes que pagaron</p>
                                <h4 class="mb-0">{{ $clientesPagados }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4"> </div> -->

                <div class="row">
                    <div class="col-md-5">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">Estado de Clientes</h5>
                                <canvas id="estadoClientesChart" style="max-height: 350px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold">Ventas Mensuales {{ now()->year }}</h5>
                                <canvas id="ventasMensualesChart" style="max-height: 350px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </main>
    @include('dashboard.partials.scripts')
</x-layout>