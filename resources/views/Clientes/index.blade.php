<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='clientes'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Clientes"></x-navbars.navs.auth>
        <!-- End Navbar -->
         <div class="card m-4">
      <div class="table-responsive p-3">
       <table class="table align-items-center mb-0">
  <thead>
    <tr>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telefono 1</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telefono 2</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Dia</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Referencias</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <!-- Ejemplo de fila -->
    <tr>
      <td>
        <div class="d-flex px-2 py-1">
          <div class="my-auto">
            <h6 class="mb-0 text-xs">Alex</h6>
          </div>
        </div>
      </td>
      <td>
        <p class="text-xs font-weight-normal mb-0">alex@gmail.com</p>
      </td>
      <td>
        <p class="text-xs font-weight-normal mb-0">alexUser</p>
      </td>
      <td>
        <p class="text-xs font-weight-normal mb-0">alexUser</p>
      </td>
      <td>
        <p class="text-xs font-weight-normal mb-0">Casa de 1378239 pisos alado de la casa de la vecina</p>
      </td>
      <td class="align-middle text-center">
        <a href="#" class="btn btn-link text-secondary p-0 mx-1" title="Ver detalles">
          <span class="material-icons">visibility</span>
        </a>
        <a href="#" class="btn btn-link text-secondary p-0 mx-1" title="Editar">
          <span class="material-icons">edit</span>
        </a>
        <a href="#" class="btn btn-link text-danger p-0 mx-1" title="Eliminar">
          <span class="material-icons">delete</span>
        </a>
      </td>
    </tr>

    <!-- Puedes duplicar y ajustar estas filas para más usuarios -->
  </tbody>
</table>

      </div>
    </div>
    </main>
    </div>
 
   
</x-layout>
