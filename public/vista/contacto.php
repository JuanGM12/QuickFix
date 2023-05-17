<?php

?>
<main class="bg-main  text-white pt-1 py-md-5">
  <div class="container-fluid mt-4">

    <div class="row d-flex justify-content-center m-0">
      <div class="col-md-11 col-lg-10 col-xl-9 d-flex align-items-center mb-md-5 p-2 ps-sm-5 ps-md-0">
        <i class="icon-headset text-second fs-2 me-3"></i>
        <h2 class="text-color-secondary ff-5 m-0">Contáctenos</h2>
      </div>
    </div>

    <div class="row d-flex justify-content-center flex-column-reverse flex-md-row py-4 m-0">

      <div class="col-md-6 col-lg-5 px-lg-5 d-none d-md-flex justify-content-center align-items-center">
        <div>
          <span><img width="300px" src="/plantilla/images/contactenos.png" alt="Contactenos"></span>
          <p class="my-4"><i class="bi bi-geo-alt me-3"></i>Carrera 49 N° 7 Sur -50</p>
          <p class="d-flex mb-4">  
            <i class="bi bi-telephone-fill me-3"></i>
            <span> 
              Linea nacional 01 8000 515 900 <br>
              Línea de atención (57) 604 2619500 <br>
              Whatsapp: (57) 310 8992908
            </span> 
          </p> 
        </div>
      </div>

      <div class="col-md-6 px-lg-5 px-sm-5 px-md-1">
        <form id="formSuport">
          <div class="rounded-3 px-4 py-5" style="background-color:#181a76">
            <div class="form-group">
              <label for="nombre" class="mb-2 nameSuport labelDate">Nombre Completo</label>
              <input  autocomplete="off" name="nombre" type="nombre" class="form-control inputDate onText" id="nameSuport"  placeholder="">
            </div>
            <div class="form-group">
              <label for="email" class="mt-4 mb-2 emailSuport labelDate">Correo Electrónico</label>
              <input  autocomplete="off"  name="email" type="text" class="form-control inputDate" id="emailSuport" placeholder="">
            </div>
            <div class="form-group">
              <label for="comentarios" class="mt-5 mb-2 comentarios labelDate">Mensaje</label>
              <textarea  autocomplete="off"  name="comentarios" class="form-control inputDate" id="comentarios" rows="5" placeholder=""></textarea>
            </div>
          </div>
          <button type="button" class="btn rounded-2 bg-second text-white ff-3 mt-4 px-5 py-2 sendSuport" id="sendSuport" style="min-width: 200px;">
            ENVIAR
          </button>
        </form>
      </div>
    </div>
  </div>
</main>